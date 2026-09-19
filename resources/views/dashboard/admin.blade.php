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

        <!-- Card Statistik yang Sekaligus Berfungsi Sebagai Tombol Pindah Tab -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
            <button type="button" onclick="switchTab('payments')" id="card-payments"
                class="tab-card p-4 rounded-2xl border border-slate-200 text-left transition flex items-center gap-3 bg-white ring-2 ring-rose-500 shadow-sm">
                <div class="p-3 bg-rose-50 text-rose-600 rounded-xl text-xl">💳</div>
                <div>
                    <span class="text-[11px] text-slate-400 font-medium block">Verifikasi Transfer</span>
                    <h3 class="text-lg font-bold text-slate-900">{{ $payments->where('status', 'pending')->count() }} Pembayaran</h3>
                </div>
            </button>

            <button type="button" onclick="switchTab('mua')" id="card-mua"
                class="tab-card p-4 rounded-2xl border border-slate-200 text-left transition flex items-center gap-3 bg-white/70 hover:bg-white">
                <div class="p-3 bg-pink-50 text-pink-600 rounded-xl text-xl">💄</div>
                <div>
                    <span class="text-[11px] text-slate-400 font-medium block">Mitra Makeup Artist</span>
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
        <div class="flex items-center gap-2 border-b border-slate-200 mb-6 pb-2">
            <button type="button" onclick="switchTab('payments')" id="btn-payments"
                class="tab-btn px-4 py-2 rounded-xl text-xs font-semibold transition bg-slate-900 text-white shadow-xs">
                💳 Verifikasi Pembayaran ({{ $payments->where('status', 'pending')->count() }})
            </button>
            <button type="button" onclick="switchTab('mua')" id="btn-mua"
                class="tab-btn px-4 py-2 rounded-xl text-xs font-semibold transition text-slate-600 hover:bg-slate-200/60">
                💄 Daftar MUA ({{ $muaUsers->count() }})
            </button>
            <button type="button" onclick="switchTab('clients')" id="btn-clients"
                class="tab-btn px-4 py-2 rounded-xl text-xs font-semibold transition text-slate-600 hover:bg-slate-200/60">
                👥 Daftar Klien ({{ $clientUsers->count() }})
            </button>
        </div>

        <!-- Konten 1: Verifikasi Pembayaran -->
        <div id="content-payments" class="tab-content">
            @include('partials.admin.payments')
        </div>

        <!-- Konten 2: Data Mitra MUA -->
        <div id="content-mua" class="tab-content hidden">
            @include('partials.admin.mua')
        </div>

        <!-- Konten 3: Data Pengguna Klien -->
        <div id="content-clients" class="tab-content hidden">
            @include('partials.admin.clients')
        </div>
    </main>

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
                btn.className = 'tab-btn px-4 py-2 rounded-xl text-xs font-semibold transition text-slate-600 hover:bg-slate-200/60';
            });
            const activeBtn = document.getElementById(`btn-${target}`);
            if (activeBtn) {
                activeBtn.className = 'tab-btn px-4 py-2 rounded-xl text-xs font-semibold transition bg-slate-900 text-white shadow-xs';
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
    </script>
</body>
</html>