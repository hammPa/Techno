<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Panel Admin - GlowMUA</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 text-slate-800 antialiased min-h-screen font-sans">
    <header class="bg-white border-b border-slate-200 px-6 py-4 flex items-center justify-between sticky top-0 z-30 shadow-xs">
        <div class="flex items-center gap-2">
            <span class="w-8 h-8 rounded-xl bg-slate-900 text-white flex items-center justify-center font-bold text-sm">🛡️</span>
            <span class="font-bold text-base text-slate-900">GlowMUA <span class="text-rose-600">Admin Panel</span></span>
        </div>
        <div class="flex items-center gap-4">
            <span class="text-xs text-slate-500">{{ $user->email }} (Administrator)</span>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="text-xs text-red-600 hover:underline font-semibold transition">Keluar</button>
            </form>
        </div>
    </header>

    <main class="max-w-7xl mx-auto p-4 sm:p-6 lg:p-8">
        <div class="mb-6">
            <h1 class="text-xl sm:text-2xl font-bold text-slate-900">Dashboard Administrator</h1>
            <p class="text-xs text-slate-500">Kelola konfirmasi pembayaran, pantau mitra MUA, dan data pengguna terdaftar</p>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs rounded-2xl flex items-center justify-between shadow-xs">
                <span>✓ {{ session('success') }}</span>
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 p-4 bg-rose-50 border border-rose-200 text-rose-800 text-xs rounded-2xl shadow-xs">
                <span>⚠️ {{ $errors->first() }}</span>
            </div>
        @endif

        @php
            $pendingVerificationsCount =$muaUsers->filter(fn($u) => optional($u->muaProfile)->verification_status === 'pending')->count();
        @endphp

        <!-- Card Statistik yang Sekaligus Berfungsi Sebagai Tombol Pindah Tab -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 mb-6">
            <button type="button" onclick="switchTab('payments')" id="card-payments"
                class="tab-card p-4 rounded-2xl border border-slate-200 text-left transition flex items-center gap-3 bg-white ring-2 ring-rose-500 shadow-sm">
                <div class="p-3 bg-rose-50 text-rose-600 rounded-xl text-xl">💳</div>
                <div>
                    <span class="text-[11px] text-slate-400 font-medium block">Verifikasi Masuk</span>
                    <h3 class="text-lg font-bold text-slate-900">{{ $payments->where('status', 'pending')->count() }} Transfer</h3>
                </div>
            </button>

            <!-- KARTU: VERIFIKASI KTP IDENTITAS MUA -->
            <button type="button" onclick="switchTab('verifications')" id="card-verifications"
                class="tab-card p-4 rounded-2xl border border-slate-200 text-left transition flex items-center gap-3 bg-white/70 hover:bg-white">
                <div class="p-3 bg-indigo-50 text-indigo-600 rounded-xl text-xl">🪪</div>
                <div>
                    <span class="text-[11px] text-slate-400 font-medium block">Verifikasi Identitas</span>
                    <h3 class="text-lg font-bold text-slate-900">{{ $pendingVerificationsCount }} KTP Masuk</h3>
                </div>
            </button>

            <!-- KARTU BARU: PENCAIRAN SALDO MUA -->
            <button type="button" onclick="switchTab('payouts')" id="card-payouts"
                class="tab-card p-4 rounded-2xl border border-slate-200 text-left transition flex items-center gap-3 bg-white/70 hover:bg-white">
                <div class="p-3 bg-emerald-50 text-emerald-600 rounded-xl text-xl">💸</div>
                <div>
                    <span class="text-[11px] text-slate-400 font-medium block">Pencairan Mitra</span>
                    <h3 class="text-lg font-bold text-slate-900">{{ $payouts->where('status', 'pending')->count() }} Antrean</h3>
                </div>
            </button>

            <button type="button" onclick="switchTab('mua')" id="card-mua"
                class="tab-card p-4 rounded-2xl border border-slate-200 text-left transition flex items-center gap-3 bg-white/70 hover:bg-white">
                <div class="p-3 bg-pink-50 text-pink-600 rounded-xl text-xl">💄</div>
                <div>
                    <span class="text-[11px] text-slate-400 font-medium block">Mitra MUA</span>
                    <h3 class="text-lg font-bold text-slate-900">{{ $muaUsers->count() }} Terdaftar</h3>
                </div>
            </button>

            <button type="button" onclick="switchTab('clients')" id="card-clients"
                class="tab-card p-4 rounded-2xl border border-slate-200 text-left transition flex items-center gap-3 bg-white/70 hover:bg-white">
                <div class="p-3 bg-blue-50 text-blue-600 rounded-xl text-xl">👥</div>
                <div>
                    <span class="text-[11px] text-slate-400 font-medium block">Akun Klien</span>
                    <h3 class="text-lg font-bold text-slate-900">{{ $clientUsers->count() }} Pengguna</h3>
                </div>
            </button>
        </div>

        <!-- Tombol Tab Menu -->
        <div class="flex items-center gap-2 border-b border-slate-200 mb-6 pb-2 overflow-x-auto">
            <button type="button" onclick="switchTab('payments')" id="btn-payments"
                class="tab-btn px-4 py-2 rounded-xl text-xs font-semibold transition bg-slate-900 text-white shadow-xs whitespace-nowrap">
                💳 Verifikasi Pembayaran ({{ $payments->where('status', 'pending')->count() }})
            </button>
            <button type="button" onclick="switchTab('verifications')" id="btn-verifications"
                class="tab-btn px-4 py-2 rounded-xl text-xs font-semibold transition text-slate-600 hover:bg-slate-200/60 whitespace-nowrap">
                🪪 Antrean KTP ({{ $pendingVerificationsCount }})
            </button>
            <button type="button" onclick="switchTab('mua')" id="btn-mua"
                class="tab-btn px-4 py-2 rounded-xl text-xs font-semibold transition text-slate-600 hover:bg-slate-200/60 whitespace-nowrap">
                💄 Daftar MUA ({{ $muaUsers->count() }})
            </button>
            <button type="button" onclick="switchTab('clients')" id="btn-clients"
                class="tab-btn px-4 py-2 rounded-xl text-xs font-semibold transition text-slate-600 hover:bg-slate-200/60 whitespace-nowrap">
                👥 Daftar Klien ({{ $clientUsers->count() }})
            </button>
            <button type="button" onclick="switchTab('payouts')" id="btn-payouts"
                class="tab-btn px-4 py-2 rounded-xl text-xs font-semibold transition text-slate-600 hover:bg-slate-200/60 whitespace-nowrap">
                💸 Pencairan Dana MUA ({{ $payouts->where('status', 'pending')->count() }})
            </button>
        </div>

        <!-- Konten 1: Verifikasi Pembayaran -->
        <div id="content-payments" class="tab-content">
            @include('partials.admin.payments')
        </div>

        <!-- Konten 2: Antrean Verifikasi KTP MUA -->
        <div id="content-verifications" class="tab-content hidden">
            @include('partials.admin.verifications')
        </div>

        <!-- Konten 3: Data Mitra MUA -->
        <div id="content-mua" class="tab-content hidden">
            @include('partials.admin.mua')
        </div>

        <!-- Konten 4: Data Pengguna Klien -->
        <div id="content-clients" class="tab-content hidden">
            @include('partials.admin.clients')
        </div>

        <div id="content-payouts" class="tab-content hidden">
            @include('partials.admin.payouts')
        </div>
    </main>

    <!-- Modal Penolakan Verifikasi KTP -->
    <div id="modal-reject-mua" class="fixed inset-0 bg-slate-900/40 backdrop-blur-xs z-50 flex items-center justify-center p-4 hidden">
        <div class="bg-white rounded-2xl max-w-sm w-full p-5 shadow-xl border border-slate-200">
            <h3 class="text-sm font-bold text-slate-900 mb-1">Tolak Verifikasi KTP</h3>
            <p id="reject-mua-name" class="text-xs text-slate-500 mb-4"></p>
            
            <form id="form-reject-mua" method="POST">
                @csrf
                @method('PATCH')
                <div class="mb-4">
                    <label class="block text-[11px] font-semibold text-slate-700 mb-1">Alasan Penolakan</label>
                    <textarea name="rejection_reason" rows="3" required placeholder="Contoh: Foto KTP buram, NIK tidak terbaca jelas, atau nama tidak sesuai."
                        class="w-full text-xs p-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-rose-500"></textarea>
                </div>
                <div class="flex items-center justify-end gap-2">
                    <button type="button" onclick="closeRejectModal()" class="px-3 py-1.5 text-xs text-slate-600 hover:bg-slate-100 rounded-xl transition">Batal</button>
                    <button type="submit" class="px-3.5 py-1.5 bg-rose-600 hover:bg-rose-700 text-white text-xs font-semibold rounded-xl transition">Kirim Penolakan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Script Vanilla JS Tab Switcher -->
    <script>
        function switchTab(target) {
            // 1. Sembunyikan semua konten tabel
            document.querySelectorAll('.tab-content').forEach(el => el.classList.add('hidden'));
            
            // Tampilkan konten target
            const activeContent = document.getElementById(`content-${target}`);
            if (activeContent) activeContent.classList.remove('hidden');

            // 2. Reset style tombol tab horizontal
            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.className = 'tab-btn px-4 py-2 rounded-xl text-xs font-semibold transition text-slate-600 hover:bg-slate-200/60 whitespace-nowrap';
            });
            const activeBtn = document.getElementById(`btn-${target}`);
            if (activeBtn) {
                activeBtn.className = 'tab-btn px-4 py-2 rounded-xl text-xs font-semibold transition bg-slate-900 text-white shadow-xs whitespace-nowrap';
            }

            // 3. Reset ring highlight pada kartu atas
            document.querySelectorAll('.tab-card').forEach(card => {
                card.className = 'tab-card p-4 rounded-2xl border border-slate-200 text-left transition flex items-center gap-3 bg-white/70 hover:bg-white';
            });
            const activeCard = document.getElementById(`card-${target}`);
            if (activeCard) {
                activeCard.className = 'tab-card p-4 rounded-2xl border border-slate-200 text-left transition flex items-center gap-3 bg-white ring-2 ring-rose-500 shadow-sm';
            }
        }

        function openRejectModal(profileId, studioName) {
            const modal = document.getElementById('modal-reject-mua');
            const form = document.getElementById('form-reject-mua');
            const nameEl = document.getElementById('reject-mua-name');
            
            form.action = `/admin/mua/${profileId}/reject`;
            nameEl.innerText = `MUA: ${studioName}`;
            modal.classList.remove('hidden');
        }

        function closeRejectModal() {
            document.getElementById('modal-reject-mua').classList.add('hidden');
        }
    </script>
</body>
</html>