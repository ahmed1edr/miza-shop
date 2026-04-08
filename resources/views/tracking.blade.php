<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suivi de commande - Miza Shop</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display&family=DM+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'DM Sans', sans-serif; }
        h1, h2, .serif { font-family: 'DM Serif Display', serif; }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .fade-in { animation: fadeInUp 0.5s ease forwards; }
        .fade-in-delay { animation: fadeInUp 0.5s ease 0.2s forwards; opacity: 0; }

        @keyframes pulse-step {
            0%, 100% { box-shadow: 0 0 0 0 rgba(232,197,71,0.3); }
            50% { box-shadow: 0 0 0 8px rgba(232,197,71,0); }
        }
        .step-active { animation: pulse-step 2s ease-in-out infinite; }

        .search-glow:focus {
            box-shadow: 0 0 0 3px rgba(232,197,71,0.15), 0 8px 30px rgba(232,197,71,0.1);
            border-color: #e8c547 !important;
        }
    </style>
    @include('layouts.theme')
</head>
<body id="body" class="min-h-screen antialiased transition-colors duration-300">

    {{-- Navbar Client --}}
    <nav style="background:rgba(26,24,40,0.85); border-bottom:1px solid rgba(255,255,255,0.06); backdrop-filter:blur(14px);">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 py-3 sm:py-4 flex justify-between items-center">
            <a href="{{ route('shop.index') }}" class="serif text-xl tracking-tight" style="color:#fffffe;">
                MIZA<span style="color:#e8c547;">SHOP</span>
            </a>
            <div class="flex items-center gap-2 sm:gap-4">
                <button onclick="toggleTheme()" class="flex items-center justify-center w-8 h-8 rounded-full transition-all duration-200"
                        style="background:rgba(255,255,255,0.05); color:#a7a4c0; border:1px solid rgba(255,255,255,0.1);"
                        onmouseover="this.style.color='#e8c547'; this.style.borderColor='rgba(232,197,71,0.5)'"
                        onmouseout="this.style.color='#a7a4c0'; this.style.borderColor='rgba(255,255,255,0.1)'">
                    <svg id="sunIcon" class="w-4 h-4 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m8-9h1M3 12H2m15.364-6.364l.707-.707M6.343 17.657l-.707.707m12.728 0l-.707-.707M6.343 6.343l-.707-.707M12 8a4 4 0 100 8 4 4 0 000-8z"/>
                    </svg>
                    <svg id="moonIcon" class="w-4 h-4 hidden" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M21 12.79A9 9 0 0111.21 3c0 .34.02.67.05 1A7 7 0 0019 19c.33.03.66.05 1 .05z"/>
                    </svg>
                </button>
                <a href="https://www.google.com/maps/place/Miza/@32.2870485,-9.2290253,169m/data=!3m2!1e3!4b1!4m6!3m5!1s0xdac2769bb875665:0x2037af52b4630b38!8m2!3d32.2870485!4d-9.2283802!16s%2Fg%2F11s333hg51?entry=ttu&g_ep=EgoyMDI2MDQwNS4wIKXMDSoASAFQAw%3D%3D" target="_blank"
                   class="text-xs font-semibold transition-all duration-200 px-3 sm:px-4 py-2 rounded-lg"
                   style="color:#a7a4c0;"
                   onmouseover="this.style.color='#e8c547'"
                   onmouseout="this.style.color='#a7a4c0'" title="Notre Localisation">
                    🏢 <span class="hidden sm:inline">Localisation</span>
                </a>
                <a href="{{ route('shop.index') }}"
                   class="text-xs font-semibold transition-all duration-200 px-3 sm:px-4 py-2 rounded-lg"
                   style="color:#a7a4c0;"
                   onmouseover="this.style.color='#e8c547'"
                   onmouseout="this.style.color='#a7a4c0'">
                    ← <span class="hidden sm:inline">Retour à la boutique</span><span class="sm:hidden">Boutique</span>
                </a>
            </div>
        </div>
    </nav>

    <div class="max-w-3xl mx-auto px-4 sm:px-6 py-8 sm:py-12">

        {{-- Header --}}
        <div class="text-center mb-10 fade-in">
            <span class="text-xs font-semibold tracking-widest uppercase px-3 py-1 rounded-full mb-4 inline-block"
                  style="background:rgba(232,197,71,0.12); color:#e8c547; border:1px solid rgba(232,197,71,0.2);">
                📍 Suivi de commande
            </span>
            <h1 class="text-2xl sm:text-4xl font-normal tracking-tight mb-3" style="color:#fffffe;">
                Où est ma commande ?
            </h1>
            <p class="text-sm" style="color:#6e6b8a;">
                Entrez votre numéro de téléphone
            </p>
        </div>

        {{-- Formulaire de recherche --}}
        <div class="rounded-2xl p-4 sm:p-8 mb-8 fade-in"
             style="background:#1a1828; border:1px solid rgba(255,255,255,0.07); box-shadow:0 24px 60px rgba(0,0,0,0.4);">
            <form action="{{ route('tracking.search') }}" method="POST">
                @csrf
                <div class="flex flex-col sm:flex-row gap-3">
                    <div class="flex-1 relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-lg">🔍</span>
                        <input type="text"
                               name="query"
                               value="{{ $query ?? '' }}"
                               placeholder="Ex: 0612345678"
                               required
                               class="w-full pl-12 pr-4 py-4 rounded-xl text-sm font-medium outline-none transition-all duration-300 search-glow"
                               style="background:#232136; border:1px solid rgba(255,255,255,0.1); color:#fffffe;">
                    </div>
                    <button type="submit"
                            class="px-6 sm:px-8 py-4 rounded-xl font-bold text-sm transition-all duration-200 w-full sm:w-auto"
                            style="background:#e8c547; color:#0f0e17; box-shadow:0 4px 20px rgba(232,197,71,0.25);"
                            onmouseover="this.style.background='#f0d060'; this.style.transform='translateY(-1px)'"
                            onmouseout="this.style.background='#e8c547'; this.style.transform='translateY(0)'">
                        Rechercher
                    </button>
                </div>
            </form>
        </div>

        {{-- Erreurs de validation --}}
        @if($errors->any())
            <div class="rounded-xl p-4 mb-6 text-sm"
                 style="background:rgba(239,68,68,0.1); border:1px solid rgba(239,68,68,0.2); color:#f87171;">
                ⚠️ Veuillez saisir un numéro de téléphone valide.
            </div>
        @endif

        {{-- Résultats --}}
        @if(isset($orders))
            @if($orders->isEmpty())
                <div class="rounded-2xl p-12 text-center fade-in-delay"
                     style="background:#1a1828; border:1px solid rgba(255,255,255,0.07);">
                    <div class="text-5xl mb-4">🔍</div>
                    <p class="font-semibold text-lg mb-2" style="color:#a7a4c0;">Aucune commande trouvée</p>
                    <p class="text-sm" style="color:#6e6b8a;">
                        Vérifiez votre numéro de téléphone
                    </p>
                </div>
            @else
                {{-- Grouper par group_id --}}
                @php
                    $grouped = $orders->groupBy('group_id');
                @endphp

                @foreach($grouped as $groupId => $groupOrders)
                    <div class="rounded-2xl p-6 mb-6 fade-in-delay"
                         style="background:#1a1828; border:1px solid rgba(255,255,255,0.07); box-shadow:0 12px 40px rgba(0,0,0,0.3);">

                        {{-- Info commande --}}
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-6 pb-4 gap-3"
                             style="border-bottom:1px solid rgba(255,255,255,0.06);">
                            <div>
                                <div class="flex items-center gap-2 mb-1">
                                    <span class="text-xs font-bold px-2.5 py-1 rounded-lg"
                                          style="background:rgba(232,197,71,0.1); color:#e8c547; border:1px dashed rgba(232,197,71,0.3);">
                                        🔗 {{ $groupId ?? 'N/A' }}
                                    </span>
                                    <span class="text-xs" style="color:#6e6b8a;">
                                        {{ $groupOrders->first()->created_at->format('d/m/Y à H:i') }}
                                    </span>
                                </div>
                                <p class="text-sm font-semibold mt-1" style="color:#fffffe;">
                                    {{ $groupOrders->first()->name }}
                                </p>
                            </div>
                            <div class="text-right">
                                <p class="text-xs uppercase tracking-wider mb-1" style="color:#6e6b8a;">Total</p>
                                <p class="text-xl font-bold serif" style="color:#e8c547;">
                                    {{ number_format($groupOrders->sum('total'), 2) }} DH
                                </p>
                            </div>
                        </div>

                        {{-- Pour chaque commande (par marque) --}}
                        @foreach($groupOrders as $order)
                            @php
                                $allStatuses = ['en attente', 'confirmé', 'expédié', 'livré'];
                                $currentIndex = array_search($order->status, $allStatuses);
                                if ($currentIndex === false) $currentIndex = -1;
                                $isCancelled = $order->status === 'annulé';

                                $stepsConfig = [
                                    ['icon' => '⏳', 'label' => 'En attente',  'color' => '#fbbf24'],
                                    ['icon' => '📞', 'label' => 'Confirmé',   'color' => '#60a5fa'],
                                    ['icon' => '🚚', 'label' => 'Expédié',    'color' => '#c084fc'],
                                    ['icon' => '✅', 'label' => 'Livré',      'color' => '#6ee7b7'],
                                ];
                            @endphp

                            <div class="mb-6 last:mb-0">
                                {{-- Produits --}}
                                <div class="flex flex-wrap gap-2 mb-5">
                                    @foreach($order->items as $item)
                                        <div class="flex items-center gap-2 px-3 py-1.5 rounded-lg text-xs"
                                             style="background:#232136; border:1px solid rgba(255,255,255,0.07);">
                                            <span class="font-bold" style="color:#e8c547;">{{ $item['quantity'] }}x</span>
                                            <span style="color:#a7a4c0;">{{ $item['name'] }}</span>
                                        </div>
                                    @endforeach
                                </div>

                                {{-- Timeline --}}
                                @if($isCancelled)
                                    <div class="flex items-center gap-3 p-4 rounded-xl"
                                         style="background:rgba(239,68,68,0.08); border:1px solid rgba(239,68,68,0.2);">
                                        <span class="text-2xl">❌</span>
                                        <div>
                                            <p class="font-bold text-sm" style="color:#f87171;">Commande annulée</p>
                                            <p class="text-xs mt-0.5" style="color:#6e6b8a;">Cette commande a été annulée.</p>
                                        </div>
                                    </div>
                                @else
                                    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between relative gap-4 sm:gap-0">
                                        {{-- Ligne de progression --}}
                                        <div class="absolute top-5 left-8 right-8 h-0.5 hidden sm:block" style="background:rgba(255,255,255,0.06);"></div>
                                        <div class="absolute top-5 left-8 h-0.5 transition-all duration-500 hidden sm:block"
                                             style="background: linear-gradient(90deg, #fbbf24, #60a5fa, #c084fc, #6ee7b7);
                                                    width: {{ $currentIndex >= 0 ? (($currentIndex / 3) * 100) : 0 }}%;
                                                    max-width: calc(100% - 64px);">
                                        </div>

                                        @foreach($stepsConfig as $i => $step)
                                            @php
                                                $isDone = $i <= $currentIndex;
                                                $isCurrent = $i === $currentIndex;
                                            @endphp
                                            <div class="flex flex-col items-center relative z-10" style="width:25%;">
                                                <div class="w-10 h-10 rounded-full flex items-center justify-center text-lg mb-2 transition-all duration-300
                                                            {{ $isCurrent ? 'step-active' : '' }}"
                                                     style="background:{{ $isDone ? $step['color'].'20' : 'rgba(255,255,255,0.04)' }};
                                                            border:2px solid {{ $isDone ? $step['color'] : 'rgba(255,255,255,0.1)' }};
                                                            {{ $isDone ? 'box-shadow:0 4px 15px '.$step['color'].'30' : '' }};">
                                                    <span style="{{ !$isDone ? 'opacity:0.3;' : '' }}">{{ $step['icon'] }}</span>
                                                </div>
                                                <span class="text-xs font-semibold text-center"
                                                      style="color:{{ $isDone ? $step['color'] : '#4a4766' }};">
                                                    {{ $step['label'] }}
                                                </span>
                                                @if($isCurrent)
                                                    <span class="text-[10px] mt-1 font-bold px-2 py-0.5 rounded-full"
                                                          style="background:{{ $step['color'] }}20; color:{{ $step['color'] }};">
                                                        Actuel
                                                    </span>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endforeach
            @endif
        @endif

    </div>

</body>
</html>
