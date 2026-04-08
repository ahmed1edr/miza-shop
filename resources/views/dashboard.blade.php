<!DOCTYPE html>
<html lang="fr" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Miza Shop</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display&family=DM+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'DM Sans', sans-serif; }
        h1, .serif { font-family: 'DM Serif Display', serif; }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(15px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-in { animation: fadeInUp 0.4s ease forwards; }

        @keyframes countUp {
            from { opacity: 0; transform: scale(0.8); }
            to { opacity: 1; transform: scale(1); }
        }
        .count-anim { animation: countUp 0.5s ease 0.2s forwards; opacity: 0; }
    </style>
</head>
<body class="min-h-screen antialiased"
      style="background:#0f0e17; background-image: radial-gradient(ellipse 80% 50% at 50% -10%, rgba(232,197,71,0.08) 0%, transparent 70%);">

    {{-- Navbar --}}
    @include('layouts.navbar')

    {{-- Contenu --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 py-6 sm:py-10">

        {{-- Titre --}}
        <div class="mb-8 animate-in">
            <span class="text-xs font-semibold tracking-widest uppercase px-3 py-1 rounded-full mb-3 inline-block"
                  style="background:rgba(232,197,71,0.12); color:#e8c547; border:1px solid rgba(232,197,71,0.2);">
                Miza Shop — Admin
            </span>
            <h1 class="text-3xl font-normal tracking-tight" style="color:#fffffe;">
                Tableau de bord
            </h1>
        </div>

        {{-- Stats Cards (الأساسية) --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">

            {{-- Produits --}}
            <div class="rounded-2xl p-6 transition-all duration-200 animate-in"
                 style="background:#1a1828; border:1px solid rgba(255,255,255,0.07); box-shadow:0 8px 24px rgba(0,0,0,0.3);"
                 onmouseover="this.style.borderColor='rgba(232,197,71,0.25)'; this.style.boxShadow='0 12px 32px rgba(0,0,0,0.4)'"
                 onmouseout="this.style.borderColor='rgba(255,255,255,0.07)'; this.style.boxShadow='0 8px 24px rgba(0,0,0,0.3)'">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-xs font-semibold tracking-widest uppercase" style="color:#a7a4c0;">Produits</span>
                    <span class="text-lg">📦</span>
                </div>
                <p class="text-4xl font-bold count-anim" style="color:#e8c547;">{{ $stats['products'] }}</p>
                <a href="{{ route('products.index') }}"
                   class="text-xs mt-3 inline-block transition-all duration-200"
                   style="color:#6e6b8a;"
                   onmouseover="this.style.color='#e8c547'"
                   onmouseout="this.style.color='#6e6b8a'">
                    Voir la liste →
                </a>
            </div>

            @if(auth()->user()->role === 'admin')

                {{-- Utilisateurs --}}
                <div class="rounded-2xl p-6 transition-all duration-200 animate-in"
                     style="background:#1a1828; border:1px solid rgba(255,255,255,0.07); box-shadow:0 8px 24px rgba(0,0,0,0.3);"
                     onmouseover="this.style.borderColor='rgba(168,85,247,0.25)'; this.style.boxShadow='0 12px 32px rgba(0,0,0,0.4)'"
                     onmouseout="this.style.borderColor='rgba(255,255,255,0.07)'; this.style.boxShadow='0 8px 24px rgba(0,0,0,0.3)'">
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-xs font-semibold tracking-widest uppercase" style="color:#a7a4c0;">Utilisateurs</span>
                        <span class="text-lg">👥</span>
                    </div>
                    <p class="text-4xl font-bold count-anim" style="color:#c084fc;">{{ $stats['users'] }}</p>
                    <a href="{{ route('users.index') }}"
                       class="text-xs mt-3 inline-block transition-all duration-200"
                       style="color:#6e6b8a;"
                       onmouseover="this.style.color='#c084fc'"
                       onmouseout="this.style.color='#6e6b8a'">
                        Voir la liste →
                    </a>
                </div>

                {{-- Familles --}}
                <div class="rounded-2xl p-6 transition-all duration-200 animate-in"
                     style="background:#1a1828; border:1px solid rgba(255,255,255,0.07); box-shadow:0 8px 24px rgba(0,0,0,0.3);"
                     onmouseover="this.style.borderColor='rgba(99,102,241,0.25)'; this.style.boxShadow='0 12px 32px rgba(0,0,0,0.4)'"
                     onmouseout="this.style.borderColor='rgba(255,255,255,0.07)'; this.style.boxShadow='0 8px 24px rgba(0,0,0,0.3)'">
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-xs font-semibold tracking-widest uppercase" style="color:#a7a4c0;">Familles</span>
                        <span class="text-lg">🏷️</span>
                    </div>
                    <p class="text-4xl font-bold count-anim" style="color:#818cf8;">{{ $stats['brands'] }}</p>
                    <a href="{{ route('brands.index') }}"
                       class="text-xs mt-3 inline-block transition-all duration-200"
                       style="color:#6e6b8a;"
                       onmouseover="this.style.color='#818cf8'"
                       onmouseout="this.style.color='#6e6b8a'">
                        Voir la liste →
                    </a>
                </div>

                {{-- Catégories --}}
                <div class="rounded-2xl p-6 transition-all duration-200 animate-in"
                     style="background:#1a1828; border:1px solid rgba(255,255,255,0.07); box-shadow:0 8px 24px rgba(0,0,0,0.3);"
                     onmouseover="this.style.borderColor='rgba(110,231,183,0.25)'; this.style.boxShadow='0 12px 32px rgba(0,0,0,0.4)'"
                     onmouseout="this.style.borderColor='rgba(255,255,255,0.07)'; this.style.boxShadow='0 8px 24px rgba(0,0,0,0.3)'">
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-xs font-semibold tracking-widest uppercase" style="color:#a7a4c0;">Catégories</span>
                        <span class="text-lg">🗂️</span>
                    </div>
                    <p class="text-4xl font-bold count-anim" style="color:#6ee7b7;">{{ $stats['categories'] }}</p>
                    <a href="{{ route('categories.index') }}"
                       class="text-xs mt-3 inline-block transition-all duration-200"
                       style="color:#6e6b8a;"
                       onmouseover="this.style.color='#6ee7b7'"
                       onmouseout="this.style.color='#6e6b8a'">
                        Voir la liste →
                    </a>
                </div>

            @endif
        </div>

        {{-- ==================== قسم الإحصائيات المتقدمة (أدمن فقط) ==================== --}}
        @if(auth()->user()->role === 'admin')

            {{-- Extra Stats Row --}}
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                <div class="rounded-xl p-5 transition-all duration-200"
                     style="background:rgba(110,231,183,0.06); border:1px solid rgba(110,231,183,0.15);">
                    <div class="text-xs font-semibold tracking-wider uppercase mb-2" style="color:#6ee7b7;">💰 Revenus Total</div>
                    <div class="text-2xl font-bold serif" style="color:#6ee7b7;">
                        {{ number_format($extraStats['totalRevenue'], 2) }} <span class="text-sm">DH</span>
                    </div>
                </div>
                <div class="rounded-xl p-5 transition-all duration-200"
                     style="background:rgba(251,191,36,0.06); border:1px solid rgba(251,191,36,0.15);">
                    <div class="text-xs font-semibold tracking-wider uppercase mb-2" style="color:#fbbf24;">📦 Aujourd'hui</div>
                    <div class="text-2xl font-bold serif" style="color:#fbbf24;">
                        {{ $extraStats['todayOrders'] }} <span class="text-sm">commandes</span>
                    </div>
                </div>
                <div class="rounded-xl p-5 transition-all duration-200"
                     style="background:rgba(96,165,250,0.06); border:1px solid rgba(96,165,250,0.15);">
                    <div class="text-xs font-semibold tracking-wider uppercase mb-2" style="color:#60a5fa;">📊 Taux livraison</div>
                    <div class="text-2xl font-bold serif" style="color:#60a5fa;">
                        {{ $extraStats['deliveredRate'] }}%
                    </div>
                </div>
                <div class="rounded-xl p-5 transition-all duration-200"
                     style="background:rgba(239,68,68,0.06); border:1px solid rgba(239,68,68,0.15);">
                    <div class="text-xs font-semibold tracking-wider uppercase mb-2" style="color:#f87171;">⏳ En attente</div>
                    <div class="text-2xl font-bold serif" style="color:#f87171;">
                        {{ $extraStats['pendingOrders'] }} <span class="text-sm">commandes</span>
                    </div>
                </div>
            </div>

            {{-- Charts Grid --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">

                {{-- Chart 1: Revenus de la semaine (Bar) --}}
                <div class="lg:col-span-2 rounded-2xl p-6"
                     style="background:#1a1828; border:1px solid rgba(255,255,255,0.07); box-shadow:0 8px 24px rgba(0,0,0,0.3);">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h3 class="text-sm font-semibold" style="color:#fffffe;">📈 Revenus de la semaine</h3>
                            <p class="text-xs mt-0.5" style="color:#6e6b8a;">Les 7 derniers jours</p>
                        </div>
                    </div>
                    <div style="height:280px;">
                        <canvas id="revenueChart"></canvas>
                    </div>
                </div>

                {{-- Chart 2: Top Marques (Doughnut) --}}
                <div class="rounded-2xl p-6"
                     style="background:#1a1828; border:1px solid rgba(255,255,255,0.07); box-shadow:0 8px 24px rgba(0,0,0,0.3);">
                    <div class="mb-4">
                        <h3 class="text-sm font-semibold" style="color:#fffffe;">🏷️ Top Marques</h3>
                        <p class="text-xs mt-0.5" style="color:#6e6b8a;">Par nombre de commandes</p>
                    </div>
                    <div style="height:280px; display:flex; align-items:center; justify-content:center;">
                        <canvas id="brandsChart"></canvas>
                    </div>
                </div>

            </div>
        @endif
    </div>

    @if(auth()->user()->role === 'admin')
    <script>
        // ====== إعدادات عامة ديال Chart.js ======
        Chart.defaults.color = '#6e6b8a';
        Chart.defaults.font.family = "'DM Sans', sans-serif";

        // ====== 1. رسم بياني ديال الدخل (Bar Chart) ======
        const revenueCtx = document.getElementById('revenueChart').getContext('2d');
        const revenueData = @json($weeklyRevenue);

        new Chart(revenueCtx, {
            type: 'bar',
            data: {
                labels: revenueData.map(d => d.day),
                datasets: [{
                    label: 'Revenus (DH)',
                    data: revenueData.map(d => d.revenue),
                    backgroundColor: revenueData.map((d, i) =>
                        i === revenueData.length - 1
                            ? 'rgba(232,197,71,0.8)'
                            : 'rgba(232,197,71,0.25)'
                    ),
                    borderColor: 'rgba(232,197,71,0.6)',
                    borderWidth: 1,
                    borderRadius: 8,
                    borderSkipped: false,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#1a1828',
                        titleColor: '#e8c547',
                        bodyColor: '#fffffe',
                        borderColor: 'rgba(232,197,71,0.3)',
                        borderWidth: 1,
                        padding: 12,
                        cornerRadius: 10,
                        callbacks: {
                            label: ctx => ctx.parsed.y.toLocaleString('fr') + ' DH'
                        }
                    }
                },
                scales: {
                    x: {
                        grid: { color: 'rgba(255,255,255,0.04)' },
                        ticks: { font: { weight: 600, size: 11 } }
                    },
                    y: {
                        grid: { color: 'rgba(255,255,255,0.04)' },
                        ticks: {
                            callback: v => v.toLocaleString('fr') + ' DH',
                            font: { size: 11 }
                        }
                    }
                }
            }
        });

        // ====== 2. رسم بياني ديال الماركات (Doughnut) ======
        const brandsCtx = document.getElementById('brandsChart').getContext('2d');
        const brandsData = @json($topBrands);
        const brandColors = ['#e8c547', '#c084fc', '#60a5fa', '#6ee7b7', '#f87171'];

        new Chart(brandsCtx, {
            type: 'doughnut',
            data: {
                labels: brandsData.map(b => b.name),
                datasets: [{
                    data: brandsData.map(b => b.count),
                    backgroundColor: brandColors.map(c => c + '40'),
                    borderColor: brandColors,
                    borderWidth: 2,
                    hoverOffset: 8,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '65%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 15,
                            usePointStyle: true,
                            pointStyleWidth: 10,
                            font: { size: 11, weight: 600 }
                        }
                    },
                    tooltip: {
                        backgroundColor: '#1a1828',
                        titleColor: '#e8c547',
                        bodyColor: '#fffffe',
                        borderColor: 'rgba(232,197,71,0.3)',
                        borderWidth: 1,
                        padding: 12,
                        cornerRadius: 10,
                    }
                }
            }
        });

    </script>
    @endif

</body>
</html>
