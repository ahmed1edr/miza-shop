<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Validation de la commande - Miza Shop</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'DM Sans', sans-serif; }
        h1, h2 { font-family: 'DM Serif Display', serif; }
        input::placeholder, textarea::placeholder { color: rgba(167,164,192,0.4); }
    </style>
    @include('layouts.theme')
</head>
<body id="body" class="min-h-screen antialiased transition-colors duration-300">

    {{-- Navbar Client --}}
    <nav class="navbar sticky top-0 z-50 mb-8" style="background:rgba(26,24,40,0.85); border-bottom:1px solid rgba(255,255,255,0.06); backdrop-filter:blur(14px);">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 py-3 sm:py-4 flex justify-between items-center">
            <a href="{{ route('shop.index') }}" class="text-xl tracking-tight" style="font-family:'DM Serif Display', serif; color:#fffffe;">
                MIZA<span style="color:#e8c547;">SHOP</span>
            </a>
            <div class="flex items-center gap-2 sm:gap-4">
                <button onclick="toggleTheme()" class="flex items-center justify-center w-8 h-8 rounded-full transition-all duration-200 toggle-btn"
                        style="background:rgba(255,255,255,0.05); color:#a7a4c0; border:1px solid rgba(255,255,255,0.1);"
                        onmouseover="this.style.color='#e8c547'; this.style.borderColor='rgba(232,197,71,0.5)'"
                        onmouseout="this.style.color='#a7a4c0'; this.style.borderColor='rgba(255,255,255,0.1)'">
                    <svg id="sunIconDesk" class="w-4 h-4 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m8-9h1M3 12H2m15.364-6.364l.707-.707M6.343 17.657l-.707.707m12.728 0l-.707-.707M6.343 6.343l-.707-.707M12 8a4 4 0 100 8 4 4 0 000-8z"/>
                    </svg>
                    <svg id="moonIconDesk" class="w-4 h-4 hidden" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M21 12.79A9 9 0 0111.21 3c0 .34.02.67.05 1A7 7 0 0019 19c.33.03.66.05 1 .05z"/>
                    </svg>
                </button>
                <a href="https://www.google.com/maps/place/Miza/@32.2870485,-9.2290253,169m/data=!3m2!1e3!4b1!4m6!3m5!1s0xdac2769bb875665:0x2037af52b4630b38!8m2!3d32.2870485!4d-9.2283802!16s%2Fg%2F11s333hg51?entry=ttu&g_ep=EgoyMDI2MDQwNS4wIKXMDSoASAFQAw%3D%3D" target="_blank"
                   class="text-xs sm:text-sm font-medium inline-flex items-center gap-1 sm:gap-2 transition-all duration-200 nav-link"
                   style="color:#a7a4c0;"
                   onmouseover="this.style.color='#e8c547'"
                   onmouseout="this.style.color='#a7a4c0'" title="Notre Localisation">
                    🏢 <span class="hidden sm:inline">Localisation</span>
                </a>
                <a href="{{ route('tracking.index') }}"
                   class="text-xs sm:text-sm font-medium inline-flex items-center gap-1 sm:gap-2 transition-all duration-200 nav-link"
                   style="color:#a7a4c0;"
                   onmouseover="this.style.color='#e8c547'"
                   onmouseout="this.style.color='#a7a4c0'">
                    📍 <span class="hidden sm:inline">Suivi</span>
                </a>
                <a href="{{ route('cart.index') }}"
                   class="text-xs sm:text-sm font-medium inline-flex items-center gap-1 sm:gap-2 transition-all duration-200 nav-link"
                   style="color:#a7a4c0;"
                   onmouseover="this.style.color='#e8c547'"
                   onmouseout="this.style.color='#a7a4c0'">
                    ← <span class="hidden sm:inline">Retour au panier</span><span class="sm:hidden">Panier</span>
                </a>
            </div>
        </div>
    </nav>

    <div class="max-w-6xl mx-auto px-4 sm:px-6 py-6 sm:py-10">

        {{-- Titre --}}
        <div class="mb-8">
            <span class="text-xs font-semibold tracking-widest uppercase px-3 py-1 rounded-full mb-3 inline-block"
                  style="background:rgba(232,197,71,0.12); color:#e8c547; border:1px solid rgba(232,197,71,0.2);">
                Miza Shop
            </span>
            <h1 class="text-2xl sm:text-3xl font-normal tracking-tight" style="color:#fffffe;">
                Finaliser la commande
            </h1>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            {{-- Formulaire livraison --}}
            <div class="md:col-span-2 rounded-2xl p-5 sm:p-8 card"
                 style="background:#1a1828; border:1px solid rgba(255,255,255,0.07); box-shadow:0 24px 60px rgba(0,0,0,0.4);">

                <h2 class="text-xl font-normal mb-6 pb-3" style="color:#fffffe; border-bottom:1px solid rgba(255,255,255,0.07);">
                    Informations de livraison
                </h2>

                <form action="{{ route('checkout.store') }}" method="POST" class="space-y-5">
                    @csrf

                    <div>
                        <label class="block text-xs font-semibold tracking-widest uppercase mb-2"
                               style="color:#a7a4c0;">Nom complet *</label>
                        <input type="text" name="name" required
                               class="w-full px-4 py-3 rounded-xl transition-all text-sm search-box">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold tracking-widest uppercase mb-2"
                               style="color:#a7a4c0;">Numéro de téléphone *</label>
                        <input type="text" name="phone" required
                               placeholder="ex : 06 12 34 56 78"
                               class="w-full px-4 py-3 rounded-xl transition-all text-sm search-box">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold tracking-widest uppercase mb-2"
                               style="color:#a7a4c0;">Adresse de livraison *</label>
                        <textarea name="address" required rows="3"
                                  placeholder="Votre ville et adresse complète..."
                                  class="w-full px-4 py-3 rounded-xl transition-all text-sm resize-none search-box"></textarea>
                    </div>

                    {{-- Info paiement --}}
                    <div class="flex items-start gap-3 p-4 rounded-xl text-sm"
                         style="background:rgba(99,102,241,0.08); border:1px solid rgba(99,102,241,0.2); color:#818cf8;">
                        <span>ℹ️</span>
                        <p><strong>Paiement à la livraison :</strong> Vous ne payez que lorsque vous recevez votre commande.</p>
                    </div>

                    <div style="border-top:1px solid rgba(255,255,255,0.06); padding-top:20px;">
                        <button type="submit"
                                class="w-full py-4 px-4 rounded-xl font-semibold text-base btn-gold">
                            Confirmer ma commande
                        </button>
                    </div>
                </form>
            </div>

            {{-- Résumé commande --}}
            <div class="rounded-2xl p-4 sm:p-6 h-fit card"
                 style="background:#1a1828; border:1px solid rgba(255,255,255,0.07); box-shadow:0 24px 60px rgba(0,0,0,0.4);">

                <h2 class="text-xl font-normal mb-6 pb-3" style="color:#fffffe; border-bottom:1px solid rgba(255,255,255,0.07);">
                    Résumé
                </h2>

                @php $total = 0; @endphp

                @foreach($cart as $details)
                    @php $total += $details['price'] * $details['quantity']; @endphp
                    <div class="flex items-center gap-3 mb-4 pb-4"
                         style="border-bottom:1px solid rgba(255,255,255,0.05);">

                        @if(isset($details['image']) && $details['image'])
                            <img src="{{ asset('storage/' . $details['image']) }}"
                                 class="w-14 h-14 object-cover rounded-lg flex-shrink-0"
                                 style="border:1px solid rgba(255,255,255,0.08);">
                        @else
                            <div class="w-14 h-14 rounded-lg flex items-center justify-center flex-shrink-0 text-xl"
                                 style="background:#232136; border:1px solid rgba(255,255,255,0.07);">
                                📦
                            </div>
                        @endif

                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold truncate" style="color:#fffffe;">{{ $details['name'] }}</p>
                            <div class="flex justify-between items-center mt-1">
                                <span class="text-xs" style="color:#6e6b8a;">
                                    {{ $details['quantity'] }}x {{ number_format($details['price'], 2) }} DH
                                </span>
                                <span class="text-sm font-bold" style="color:#6ee7b7;">
                                    {{ number_format($details['price'] * $details['quantity'], 2) }} DH
                                </span>
                            </div>
                        </div>
                    </div>
                @endforeach

                {{-- Total --}}
                <div class="pt-4" style="border-top:1px solid rgba(255,255,255,0.07);">
                    <div class="flex justify-between items-center">
                        <span class="text-sm font-semibold" style="color:#a7a4c0;">Total à payer</span>
                        <span class="text-2xl font-bold" style="color:#e8c547;">
                            {{ number_format($total, 2) }} DH
                        </span>
                    </div>
                </div>
            </div>

        </div>
    </div>

</body>
</html>

