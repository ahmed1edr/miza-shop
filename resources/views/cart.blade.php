<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Panier - Miza Shop</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'DM Sans', sans-serif; }
        h1, h2, .serif { font-family: 'DM Serif Display', serif; }

        .dark {
            background: #0f0e17;
            background-image: radial-gradient(ellipse 80% 50% at 50% -10%, rgba(232,197,71,0.08) 0%, transparent 70%);
            color: #fffffe;
        }
        .light {
            background: #f4f3ef;
            background-image: radial-gradient(ellipse 80% 50% at 50% -10%, rgba(232,197,71,0.12) 0%, transparent 70%);
            color: #1a1828;
        }

        .dark .navbar  { background: rgba(26,24,40,0.85); border-bottom: 1px solid rgba(255,255,255,0.06); }
        .light .navbar { background: rgba(255,255,255,0.85); border-bottom: 1px solid rgba(0,0,0,0.07); }

        .dark  .panel { background: #1a1828; border: 1px solid rgba(255,255,255,0.07); box-shadow: 0 8px 24px rgba(0,0,0,0.3); }
        .light .panel { background: #ffffff;  border: 1px solid rgba(0,0,0,0.07);       box-shadow: 0 8px 24px rgba(0,0,0,0.07); }

        .dark  .thead-row { background: rgba(255,255,255,0.03); border-bottom: 1px solid rgba(255,255,255,0.07); }
        .light .thead-row { background: rgba(0,0,0,0.02);       border-bottom: 1px solid rgba(0,0,0,0.06); }

        .dark  .th-text { color: #6e6b8a; }
        .light .th-text { color: #9996b0; }

        .dark  .row-divider { border-bottom: 1px solid rgba(255,255,255,0.05); }
        .light .row-divider { border-bottom: 1px solid rgba(0,0,0,0.05); }

        .dark  .row-hover:hover { background: rgba(255,255,255,0.02); }
        .light .row-hover:hover { background: rgba(0,0,0,0.015); }

        .dark  .prod-name { color: #fffffe; }
        .light .prod-name { color: #1a1828; }

        .dark  .unit-price { color: #a7a4c0; }
        .light .unit-price { color: #6e6b8a; }

        .dark  .qty-text { color: #fffffe; }
        .light .qty-text { color: #1a1828; }

        .price-text { font-family: 'DM Serif Display', serif; color: #e8c547; }

        .dark  .img-placeholder { background: linear-gradient(135deg,#1e1c2e,#252336); }
        .light .img-placeholder { background: linear-gradient(135deg,#ede9f0,#ddd9e8); }

        .btn-gold { background: linear-gradient(135deg,#e8c547,#c9a227); color: #0f0e17; font-weight: 600; border-radius: 12px; transition: all 0.2s; }
        .btn-gold:hover { background: linear-gradient(135deg,#f0d060,#e8c547); transform: translateY(-1px); box-shadow: 0 6px 20px rgba(232,197,71,0.3); }

        .btn-remove { background: rgba(239,68,68,0.1); color: #f87171; border: 1px solid rgba(239,68,68,0.2); border-radius: 999px; font-size: 0.75rem; font-weight: 600; padding: 4px 12px; transition: all 0.2s; }
        .btn-remove:hover { background: rgba(239,68,68,0.2); color: #fca5a5; }

        .title-badge { background: rgba(232,197,71,0.12); color: #e8c547; border: 1px solid rgba(232,197,71,0.2); font-size: 0.65rem; font-weight: 600; letter-spacing: 0.1em; text-transform: uppercase; padding: 3px 12px; border-radius: 999px; display: inline-block; margin-bottom: 10px; }

        .dark  .nav-link { color: #a7a4c0; }
        .light .nav-link { color: #6e6b8a; }
        .nav-link { font-size: 0.875rem; transition: color 0.2s; }
        .dark  .nav-link:hover { color: #e8c547; }
        .light .nav-link:hover { color: #c9a227; }

        .dark  .total-label { color: #6e6b8a; }
        .light .total-label { color: #9996b0; }

        .dark  .empty-panel { background: #1a1828; border: 1px solid rgba(255,255,255,0.07); }
        .light .empty-panel { background: #ffffff;  border: 1px solid rgba(0,0,0,0.07); }

        .dark  .empty-text { color: #6e6b8a; }
        .light .empty-text { color: #9996b0; }

        .toggle-btn { border-radius: 999px; width:36px; height:36px; display:flex; align-items:center; justify-content:center; transition: all 0.2s; cursor: pointer; }
        .dark  .toggle-btn { background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.1); color: #fffffe; }
        .light .toggle-btn { background: rgba(0,0,0,0.05);       border: 1px solid rgba(0,0,0,0.1);        color: #1a1828; }
        .toggle-btn:hover { border-color: rgba(232,197,71,0.4); }
    </style>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body id="body" class="min-h-screen antialiased transition-colors duration-300">

    <!-- NAVBAR -->
    <nav class="navbar sticky top-0 z-50" style="backdrop-filter:blur(14px);">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 py-3 sm:py-4 flex justify-between items-center">

            <a href="{{ route('shop.index') }}" class="serif text-xl tracking-tight">
                MIZA<span style="color:#e8c547;">SHOP</span>
            </a>

            <div class="flex items-center gap-2 sm:gap-4">
                <button onclick="toggleTheme()" class="toggle-btn">
                    <svg id="sunIcon" class="w-4 h-4 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 3v1m0 16v1m8-9h1M3 12H2m15.364-6.364l.707-.707M6.343 17.657l-.707.707m12.728 0l-.707-.707M6.343 6.343l-.707-.707M12 8a4 4 0 100 8 4 4 0 000-8z"/>
                    </svg>
                    <svg id="moonIcon" class="w-4 h-4 hidden" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M21 12.79A9 9 0 0111.21 3c0 .34.02.67.05 1A7 7 0 0019 19c.33.03.66.05 1 .05z"/>
                    </svg>
                </button>

                <a href="https://www.google.com/maps/place/Miza/@32.2870485,-9.2290253,169m/data=!3m2!1e3!4b1!4m6!3m5!1s0xdac2769bb875665:0x2037af52b4630b38!8m2!3d32.2870485!4d-9.2283802!16s%2Fg%2F11s333hg51?entry=ttu&g_ep=EgoyMDI2MDQwNS4wIKXMDSoASAFQAw%3D%3D" target="_blank" class="nav-link font-medium items-center gap-1 hidden sm:flex" title="Notre Localisation">
                    <span>🏢</span>
                    <span>Localisation</span>
                </a>
                <a href="{{ route('tracking.index') }}" class="nav-link font-medium items-center gap-1 hidden sm:flex">
                    <span>📍</span>
                    <span>Suivi</span>
                </a>
                <a href="{{ route('shop.index') }}" class="nav-link font-medium flex items-center gap-1 text-xs sm:text-sm">
                    ← <span class="hidden sm:inline">Continuer mes achats</span><span class="sm:hidden">Boutique</span>
                </a>
            </div>
        </div>
    </nav>

    <!-- CONTENT -->
    <div class="max-w-6xl mx-auto px-6 py-10">

        <!-- Title -->
        <div class="mb-8">
            <span class="title-badge">Miza Shop — Panier</span>
            <h1 class="text-3xl font-normal tracking-tight">Mon Panier 🛒</h1>
        </div>

        @if(session('cart') && count(session('cart')) > 0)

            {{-- DESKTOP TABLE (hidden on mobile) --}}
            <div class="panel rounded-2xl overflow-hidden hidden md:block">
                <table class="w-full text-left">
                    <thead>
                        <tr class="thead-row">
                            <th class="th-text py-4 px-6 text-xs font-semibold tracking-widest uppercase">Produit</th>
                            <th class="th-text py-4 px-6 text-xs font-semibold tracking-widest uppercase">Prix unitaire</th>
                            <th class="th-text py-4 px-6 text-xs font-semibold tracking-widest uppercase text-center">Quantité</th>
                            <th class="th-text py-4 px-6 text-xs font-semibold tracking-widest uppercase">Total</th>
                            <th class="th-text py-4 px-6 text-xs font-semibold tracking-widest uppercase text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $total = 0; @endphp
                        @foreach(session('cart') as $id => $details)
                            @php $total += $details['price'] * $details['quantity']; @endphp
                            <tr class="row-divider row-hover transition-colors">
                                <td class="py-4 px-6">
                                    <div class="flex items-center gap-4">
                                        @if(isset($details['image']) && $details['image'])
                                            <img src="{{ asset('storage/' . $details['image']) }}" class="w-14 h-14 object-cover rounded-xl">
                                        @else
                                            <div class="img-placeholder w-14 h-14 rounded-xl flex items-center justify-center" style="font-size:1.5rem; opacity:0.3;">📦</div>
                                        @endif
                                        <span class="prod-name font-semibold text-sm">{{ $details['name'] }}</span>
                                    </div>
                                </td>
                                <td class="py-4 px-6 unit-price text-sm">{{ number_format($details['price'], 2) }} DH</td>
                                <td class="py-4 px-6">
                                    <div class="flex items-center justify-center gap-2">
                                        <button type="button" onclick="updateCart('{{ $id }}', 'decrease')"
                                                class="w-8 h-8 rounded-full text-sm font-bold flex items-center justify-center transition-all duration-200"
                                                style="background:rgba(255,255,255,0.06); color:#a7a4c0; border:1px solid rgba(255,255,255,0.08);"
                                                onmouseover="this.style.background='rgba(239,68,68,0.12)'; this.style.color='#f87171'"
                                                onmouseout="this.style.background='rgba(255,255,255,0.06)'; this.style.color='#a7a4c0'">−</button>
                                        <input type="number" id="qty-{{ $id }}" value="{{ $details['quantity'] }}" min="1"
                                               class="w-12 text-center text-sm font-bold rounded-lg outline-none transition-all"
                                               style="background:#232136; border:1px solid rgba(255,255,255,0.07); color:#fffffe; padding:6px 0;"
                                               onchange="updateCart('{{ $id }}', 'input', this.value)">
                                        <button type="button" onclick="updateCart('{{ $id }}', 'increase')"
                                                class="w-8 h-8 rounded-full text-sm font-bold flex items-center justify-center transition-all duration-200"
                                                style="background:rgba(255,255,255,0.06); color:#a7a4c0; border:1px solid rgba(255,255,255,0.08);"
                                                onmouseover="this.style.background='rgba(110,231,183,0.12)'; this.style.color='#6ee7b7'"
                                                onmouseout="this.style.background='rgba(255,255,255,0.06)'; this.style.color='#a7a4c0'">+</button>
                                    </div>
                                </td>
                                <td class="py-4 px-6 whitespace-nowrap" id="item-total-{{ $id }}">
                                    <span class="text-sm font-bold" style="color:#6ee7b7;">{{ number_format($details['price'] * $details['quantity'], 2) }} DH</span>
                                </td>
                                <td class="py-4 px-6 text-center">
                                    <form action="{{ route('cart.remove', $id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn-remove">Retirer ✕</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- MOBILE CARDS (hidden on desktop) --}}
            <div class="md:hidden space-y-4">
                @php $total = 0; @endphp
                @foreach(session('cart') as $id => $details)
                    @php $total += $details['price'] * $details['quantity']; @endphp
                    <div class="panel rounded-2xl p-4">
                        <div class="flex gap-3">
                            {{-- Image --}}
                            @if(isset($details['image']) && $details['image'])
                                <img src="{{ asset('storage/' . $details['image']) }}" class="w-20 h-20 object-cover rounded-xl flex-shrink-0">
                            @else
                                <div class="img-placeholder w-20 h-20 rounded-xl flex items-center justify-center flex-shrink-0" style="font-size:1.8rem; opacity:0.3;">📦</div>
                            @endif

                            {{-- Info --}}
                            <div class="flex-1 min-w-0">
                                <h3 class="prod-name font-semibold text-sm truncate">{{ $details['name'] }}</h3>
                                <p class="unit-price text-xs mt-1">{{ number_format($details['price'], 2) }} DH / unité</p>
                                <p class="text-sm font-bold mt-1" style="color:#6ee7b7;" id="item-total-m-{{ $id }}">{{ number_format($details['price'] * $details['quantity'], 2) }} DH</p>
                            </div>

                            {{-- Remove --}}
                            <form action="{{ route('cart.remove', $id) }}" method="POST" class="flex-shrink-0">
                                @csrf
                                <button type="submit" class="w-8 h-8 rounded-full flex items-center justify-center text-xs transition-all"
                                        style="background:rgba(239,68,68,0.1); color:#f87171; border:1px solid rgba(239,68,68,0.2);">✕</button>
                            </form>
                        </div>

                        {{-- Quantity Controls --}}
                        <div class="flex items-center justify-between mt-3 pt-3" style="border-top:1px solid rgba(255,255,255,0.05);">
                            <span class="text-xs font-semibold" style="color:#6e6b8a;">Quantité</span>
                            <div class="flex items-center gap-3">
                                <button type="button" onclick="updateCart('{{ $id }}', 'decrease')"
                                        class="w-9 h-9 rounded-full text-sm font-bold flex items-center justify-center transition-all"
                                        style="background:rgba(255,255,255,0.06); color:#a7a4c0; border:1px solid rgba(255,255,255,0.08);">−</button>
                                <input type="number" id="qty-m-{{ $id }}" value="{{ $details['quantity'] }}" min="1"
                                       class="w-14 text-center text-sm font-bold rounded-lg outline-none"
                                       style="background:#232136; border:1px solid rgba(255,255,255,0.07); color:#fffffe; padding:6px 0;"
                                       onchange="updateCart('{{ $id }}', 'input', this.value)">
                                <button type="button" onclick="updateCart('{{ $id }}', 'increase')"
                                        class="w-9 h-9 rounded-full text-sm font-bold flex items-center justify-center transition-all"
                                        style="background:rgba(255,255,255,0.06); color:#a7a4c0; border:1px solid rgba(255,255,255,0.08);">+</button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Total + Checkout --}}
            <div class="panel mt-5 rounded-2xl px-6 sm:px-8 py-6">
                <div class="flex flex-col items-end">
                    <p class="total-label text-xs font-semibold tracking-widest uppercase mb-1">Total à payer</p>
                    <p class="text-3xl sm:text-4xl font-extrabold mb-6"><span id="grand-total" style="color:#e8c547;">{{ number_format(max($total, 0), 2) }}</span> <span class="text-lg sm:text-xl" style="color:#6e6b8a;">DH</span></p>
                    <a href="{{ route('checkout.index') }}" class="inline-block w-full sm:w-auto text-center bg-gradient-to-r from-[#e8c547] to-[#c9a227] hover:shadow-lg hover:-translate-y-0.5 transform text-[#0f0e17] font-bold py-3 px-10 rounded-xl text-lg transition-all duration-200">
                        Passer la commande 💳
                    </a>
                </div>
            </div>

        @else

            <div class="empty-panel rounded-2xl p-10 sm:p-16 text-center">
                <p style="font-size:3.5rem;" class="mb-4">🚫</p>
                <p class="empty-text text-lg font-semibold mb-6">Votre panier est vide.</p>
                <a href="{{ route('shop.index') }}" class="btn-gold inline-block py-3 px-8 text-sm">Découvrir nos produits</a>
            </div>

        @endif
    </div>

    <script>
    const body = document.getElementById('body')
    const sun  = document.getElementById('sunIcon')
    const moon = document.getElementById('moonIcon')

    function applyTheme(theme) {
        body.classList.remove('dark','light')
        body.classList.add(theme)
        if (theme === 'dark') {
            moon.classList.remove('hidden')
            sun.classList.add('hidden')
        } else {
            sun.classList.remove('hidden')
            moon.classList.add('hidden')
        }
        localStorage.setItem('theme', theme)
    }

    function toggleTheme() {
        const current = localStorage.getItem('theme') || 'dark'
        applyTheme(current === 'dark' ? 'light' : 'dark')
    }

    ;(function(){
        const saved = localStorage.getItem('theme')
        if (saved) {
            applyTheme(saved)
        } else {
            applyTheme(window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light')
        }
    })()
    </script>
    <script>
    function updateCart(productId, action, qtyValue = null) {
        const tokenMeta = document.querySelector('meta[name="csrf-token"]');
        if (!tokenMeta) return;

        // كنوجدو شنو غنصيفطو للسيرفور (increase, decrease, ولا رقم جديد)
        let bodyData = { action: action };
        if (action === 'input') {
            bodyData.quantity = qtyValue;
        }

        // كنصيفطو الطلب
        fetch(`/cart/update/${productId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': tokenMeta.content
            },
            body: JSON.stringify(bodyData)
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                // كنبدلو الرقم فـ الخانة
                document.getElementById(`qty-${productId}`).value = data.newQuantity;
                // كنبدلو المجموع ديال داك المنتج بوحدو
                document.getElementById(`item-total-${productId}`).innerText = data.itemTotal + ' DH';
                // كنبدلو المجموع الكلي ديال السلة كاملة
                document.getElementById('grand-total').innerText = data.grandTotal;
            }
        })
        .catch(err => console.error(err));
    }

    </script>

</body>
</html>

