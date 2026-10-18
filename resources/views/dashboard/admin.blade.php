<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Panel Admin - TemuMUA</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:wght@400;600&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
@php
    $pendingVerificationsCount = $muaUsers->filter(fn($u) => optional($u->muaProfile)->verification_status === 'pending')->count();
    $pendingPaymentsCount      = $payments->where('status', 'pending')->count();
    $pendingPayoutsCount       = $payouts->where('status', 'pending')->count();

    // key => [label kartu, nilai kartu, label tab]
    $tabs = [
        'payments'      => ['Verifikasi masuk',    $pendingPaymentsCount . ' transfer',      'Verifikasi pembayaran (' . $pendingPaymentsCount . ')'],
        'verifications' => ['Verifikasi identitas', $pendingVerificationsCount . ' KTP masuk', 'Antrean KTP (' . $pendingVerificationsCount . ')'],
        'payouts'       => ['Pencairan mitra',     $pendingPayoutsCount . ' antrean',        'Pencairan dana MUA (' . $pendingPayoutsCount . ')'],
        'mua'           => ['Mitra MUA',           $muaUsers->count() . ' terdaftar',        'Daftar MUA (' . $muaUsers->count() . ')'],
        'clients'       => ['Akun klien',          $clientUsers->count() . ' pengguna',      'Daftar klien (' . $clientUsers->count() . ')'],
    ];
    $firstTab = 'payments';
@endphp
<body class="bg-[#3b2230]/[0.04] text-[#3b2230] antialiased min-h-screen">

    <header class="sticky top-0 z-30 bg-white border-b border-[#3b2230]/10 px-4 sm:px-6 h-16 flex items-center justify-between">
        <div class="flex items-baseline gap-2">
            <span class="text-2xl [font-family:'Fraunces',serif]">TemuMUA</span>
            <span class="text-sm text-[#3b2230]/55">Admin</span>
        </div>
        <div class="flex items-center gap-4">
            <span class="hidden sm:inline text-sm text-[#3b2230]/60">{{ $user->email }} (Administrator)</span>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit"
                    class="text-sm font-semibold text-red-700 underline underline-offset-4 decoration-red-700/30 hover:decoration-red-700 rounded-sm focus:outline-none focus-visible:ring-2 focus-visible:ring-red-700/40">
                    Keluar
                </button>
            </form>
        </div>
    </header>

    <main class="max-w-7xl mx-auto p-4 sm:p-6 lg:p-8">
        <div class="mb-6">
            <h1 class="text-3xl [font-family:'Fraunces',serif] font-normal">Dashboard administrator</h1>
            <p class="mt-1 text-sm text-[#3b2230]/60">Kelola konfirmasi pembayaran, pantau mitra MUA, dan data pengguna terdaftar.</p>
        </div>

        @if(session('success'))
            <div role="status" class="mb-6 p-3 text-sm text-emerald-800 bg-emerald-50 border border-emerald-200 rounded-md">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div role="alert" class="mb-6 p-3 text-sm text-red-800 bg-red-50 border border-red-200 rounded-md">
                {{ $errors->first() }}
            </div>
        @endif

        <!-- Kartu statistik (sekaligus pindah tab) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 mb-6">
            @foreach($tabs as $key => [$cardLabel, $cardValue])
                <button type="button" onclick="switchTab('{{ $key }}')" id="card-{{ $key }}"
                    class="tab-card p-5 text-left bg-white border rounded-lg transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-[#3b2230]/40
                           {{ $key === $firstTab ? 'border-[#3b2230] ring-1 ring-[#3b2230]' : 'border-[#3b2230]/10 hover:border-[#3b2230]/40' }}">
                    <span class="block text-sm text-[#3b2230]/60">{{ $cardLabel }}</span>
                    <span class="block mt-1 text-xl [font-family:'Fraunces',serif]">{{ $cardValue }}</span>
                </button>
            @endforeach
        </div>

        <!-- Tab -->
        <div class="flex items-center gap-2 mb-6 pb-3 border-b border-[#3b2230]/10 overflow-x-auto" role="tablist">
            @foreach($tabs as $key => [, , $tabLabel])
                <button type="button" role="tab" onclick="switchTab('{{ $key }}')" id="btn-{{ $key }}" aria-selected="{{ $key === $firstTab ? 'true' : 'false' }}"
                    class="tab-btn px-4 py-2 text-sm font-semibold rounded-md whitespace-nowrap transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-[#3b2230]/40
                           {{ $key === $firstTab ? 'bg-[#3b2230] text-white' : 'text-[#3b2230]/70 hover:bg-[#3b2230]/[0.07]' }}">
                    {{ $tabLabel }}
                </button>
            @endforeach
        </div>

        <div id="content-payments" class="tab-content">@include('partials.admin.payments')</div>
        <div id="content-verifications" class="tab-content hidden">@include('partials.admin.verifications')</div>
        <div id="content-payouts" class="tab-content hidden">@include('partials.admin.payouts')</div>
        <div id="content-mua" class="tab-content hidden">@include('partials.admin.mua')</div>
        <div id="content-clients" class="tab-content hidden">@include('partials.admin.clients')</div>
    </main>

    <!-- Modal tolak verifikasi KTP -->
    <div id="modal-reject-mua" role="dialog" aria-modal="true" aria-labelledby="reject-title"
        class="fixed inset-0 z-50 hidden items-center justify-center overflow-y-auto p-4 bg-[#3b2230]/50">
        <div class="w-full max-w-sm p-6 bg-white border border-[#3b2230]/10 rounded-lg">
            <h3 id="reject-title" class="text-2xl [font-family:'Fraunces',serif] font-normal">Tolak verifikasi KTP</h3>
            <p id="reject-mua-name" class="mt-1 mb-5 text-sm text-[#3b2230]/60"></p>

            <form id="form-reject-mua" method="POST" class="space-y-4">
                @csrf
                @method('PATCH')
                <div>
                    <label for="rejection_reason" class="block mb-1.5 text-sm font-medium text-[#3b2230]/80">Alasan penolakan</label>
                    <textarea id="rejection_reason" name="rejection_reason" rows="3" required
                        placeholder="Contoh: Foto KTP buram, NIK tidak terbaca, atau nama tidak sesuai."
                        class="w-full px-3.5 py-2.5 bg-white rounded-md border border-[#3b2230]/15 text-sm placeholder:text-[#3b2230]/35 resize-none focus:outline-none focus:border-[#3b2230]/50 focus-visible:ring-2 focus-visible:ring-[#3b2230]/30 transition-colors"></textarea>
                </div>
                <div class="flex items-center justify-end gap-3 pt-5 border-t border-[#3b2230]/10">
                    <button type="button" onclick="closeRejectModal()"
                        class="px-4 py-2.5 text-sm font-semibold text-[#3b2230]/70 hover:text-[#3b2230] hover:bg-[#3b2230]/[0.05] rounded-md transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-[#3b2230]/40">
                        Batal
                    </button>
                    <button type="submit"
                        class="px-5 py-2.5 text-sm font-semibold text-white bg-red-700 hover:bg-red-800 rounded-md transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-red-700/60">
                        Kirim penolakan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const BTN_ON   = ['bg-[#3b2230]', 'text-white'];
        const BTN_OFF  = ['text-[#3b2230]/70', 'hover:bg-[#3b2230]/[0.07]'];
        const CARD_ON  = ['border-[#3b2230]', 'ring-1', 'ring-[#3b2230]'];
        const CARD_OFF = ['border-[#3b2230]/10', 'hover:border-[#3b2230]/40'];

        function switchTab(target) {
            document.querySelectorAll('.tab-content').forEach(el => el.classList.add('hidden'));
            const activeContent = document.getElementById(`content-${target}`);
            if (activeContent) activeContent.classList.remove('hidden');

            document.querySelectorAll('.tab-btn').forEach(btn => {
                const on = btn.id === `btn-${target}`;
                btn.classList.remove(...(on ? BTN_OFF : BTN_ON));
                btn.classList.add(...(on ? BTN_ON : BTN_OFF));
                btn.setAttribute('aria-selected', on ? 'true' : 'false');
            });

            document.querySelectorAll('.tab-card').forEach(card => {
                const on = card.id === `card-${target}`;
                card.classList.remove(...(on ? CARD_OFF : CARD_ON));
                card.classList.add(...(on ? CARD_ON : CARD_OFF));
            });
        }

        function openRejectModal(profileId, studioName) {
            const modal = document.getElementById('modal-reject-mua');
            document.getElementById('form-reject-mua').action = `/admin/mua/${profileId}/reject`;
            document.getElementById('reject-mua-name').innerText = `MUA: ${studioName}`;
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.getElementById('rejection_reason').focus();
        }

        function closeRejectModal() {
            const modal = document.getElementById('modal-reject-mua');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        window.addEventListener('click', e => {
            if (e.target === document.getElementById('modal-reject-mua')) closeRejectModal();
        });
        window.addEventListener('keydown', e => {
            const modal = document.getElementById('modal-reject-mua');
            if (e.key === 'Escape' && !modal.classList.contains('hidden')) closeRejectModal();
        });
    </script>
</body>
</html>