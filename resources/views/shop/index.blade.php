<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Miza Shop</title>
<meta name="csrf-token" content="{{ csrf_token() }}">
<script src="https://cdn.tailwindcss.com"></script>
<link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
<style>
    body { font-family: 'DM Sans', sans-serif; }
    h1, h2, .serif { font-family: 'DM Serif Display', serif; }

    /* ── DARK ── */
    .dark {
        background: #0f0e17;
        background-image: radial-gradient(ellipse 80% 50% at 50% -10%, rgba(232,197,71,0.08) 0%, transparent 70%);
        color: #fffffe;
    }

    /* ── LIGHT ── */
    .light {
        background: #f4f3ef;
        background-image: radial-gradient(ellipse 80% 50% at 50% -10%, rgba(232,197,71,0.12) 0%, transparent 70%);
        color: #1a1828;
    }

    /* ── NAVBAR ── */
    .dark .navbar  { background: rgba(26,24,40,0.85); border-bottom: 1px solid rgba(255,255,255,0.06); }
    .light .navbar { background: rgba(255,255,255,0.85); border-bottom: 1px solid rgba(0,0,0,0.07); }

    /* ── CARD ── */
    .dark .card  { background: #1a1828; border: 1px solid rgba(255,255,255,0.07); box-shadow: 0 8px 24px rgba(0,0,0,0.3); }
    .light .card { background: #ffffff;  border: 1px solid rgba(0,0,0,0.07);       box-shadow: 0 8px 24px rgba(0,0,0,0.07); }

    .dark  .card:hover { border-color: rgba(232,197,71,0.28) !important; box-shadow: 0 14px 36px rgba(0,0,0,0.45) !important; }
    .light .card:hover { border-color: rgba(232,197,71,0.45) !important; box-shadow: 0 14px 36px rgba(0,0,0,0.12) !important; }

    /* ── SEARCH BOX ── */
    .dark  .search-box { background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); color: #fffffe; }
    .light .search-box { background: rgba(0,0,0,0.04);       border: 1px solid rgba(0,0,0,0.12);       color: #1a1828; }
    .search-box::placeholder { color: #a7a4c0; }
    .search-box:focus { outline: none; border-color: rgba(232,197,71,0.5); box-shadow: 0 0 0 3px rgba(232,197,71,0.08); }

    /* ── TOOLBAR PANEL ── */
    .dark  .toolbar { background: #1a1828; border: 1px solid rgba(255,255,255,0.07); }
    .light .toolbar { background: #ffffff;  border: 1px solid rgba(0,0,0,0.07); }

    /* ── TOGGLE BUTTON ── */
    .dark  .toggle-btn { background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.1); color: #fffffe; }
    .light .toggle-btn { background: rgba(0,0,0,0.05);       border: 1px solid rgba(0,0,0,0.1);        color: #1a1828; }
    .toggle-btn { border-radius: 999px; width:36px; height:36px; display:flex; align-items:center; justify-content:center; transition: all 0.2s; cursor: pointer; }
    .toggle-btn:hover { border-color: rgba(232,197,71,0.4); }

    /* ── CART BADGE ── */
    .cart-badge { background: #e8c547; color: #0f0e17; font-size: 0.6rem; font-weight: 700; width:17px; height:17px; border-radius:999px; display:flex; align-items:center; justify-content:center; }

    /* ── BRAND BADGE ── */
    .badge-brand { background: rgba(232,197,71,0.1); color: #e8c547; border: 1px solid rgba(232,197,71,0.2); font-size: 0.6rem; font-weight: 600; letter-spacing: 0.08em; text-transform: uppercase; padding: 2px 8px; border-radius: 999px; display:inline-block; }

    /* ── PRODUCT NAME ── */
    .dark  .prod-name { color: #fffffe; }
    .light .prod-name { color: #1a1828; }

    /* ── PRICE ── */
    .price-text { font-family: 'DM Serif Display', serif; color: #e8c547; }
    .dark  .price-unit { color: #a7a4c0; }
    .light .price-unit { color: #6e6b8a; }

    /* ── BUTTON ── */
    .btn-gold { background: linear-gradient(135deg,#e8c547,#c9a227); color: #0f0e17; font-weight: 600; border-radius: 12px; transition: all 0.2s; }
    .btn-gold:hover { background: linear-gradient(135deg,#f0d060,#e8c547); transform: translateY(-1px); box-shadow: 0 6px 20px rgba(232,197,71,0.3); }

    /* ── IMG PLACEHOLDER ── */
    .dark  .img-bg { background: linear-gradient(135deg,#1e1c2e,#252336); }
    .light .img-bg { background: linear-gradient(135deg,#ede9f0,#ddd9e8); }

    /* ── PAGE TITLE BADGE ── */
    .title-badge { background: rgba(232,197,71,0.12); color: #e8c547; border: 1px solid rgba(232,197,71,0.2); font-size: 0.65rem; font-weight: 600; letter-spacing: 0.1em; text-transform: uppercase; padding: 3px 12px; border-radius: 999px; display: inline-block; margin-bottom: 10px; }

    /* ── NAV LINK ── */
    .dark  .nav-link { color: #a7a4c0; }
    .light .nav-link { color: #6e6b8a; }
    .nav-link { font-size: 0.875rem; transition: color 0.2s; display:flex; align-items:center; gap:5px; }
    .dark  .nav-link:hover { color: #fffffe; }
    .light .nav-link:hover { color: #1a1828; }

    /* ── SELECT OPTION FIX ── */
    .dark select option { background: #1a1828; color: #fffffe; }
    .light select option { background: #ffffff; color: #1a1828; }
</style>
</head>

<body id="body" class="min-h-screen antialiased transition-colors duration-300">

<!-- NAVBAR -->
<nav class="navbar sticky top-0 z-50" style="backdrop-filter:blur(14px);">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 py-3 sm:py-4">
        <div class="flex justify-between items-center">

            <a href="{{ route('shop.index') }}" class="serif text-xl tracking-tight">
                MIZA<span style="color:#e8c547;">SHOP</span>
            </a>

            {{-- Desktop Nav --}}
            <div class="hidden md:flex items-center gap-4">
                <button onclick="toggleTheme()" class="toggle-btn">
                    <svg id="sunIcon" class="w-4 h-4 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 3v1m0 16v1m8-9h1M3 12H2m15.364-6.364l.707-.707M6.343 17.657l-.707.707m12.728 0l-.707-.707M6.343 6.343l-.707-.707M12 8a4 4 0 100 8 4 4 0 000-8z"/>
                    </svg>
                    <svg id="moonIcon" class="w-4 h-4 hidden" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M21 12.79A9 9 0 0111.21 3c0 .34.02.67.05 1A7 7 0 0019 19c.33.03.66.05 1 .05z"/>
                    </svg>
                </button>
                <a href="https://www.google.com/maps/place/Miza/@32.2870485,-9.2290253,169m/data=!3m2!1e3!4b1!4m6!3m5!1s0xdac2769bb875665:0x2037af52b4630b38!8m2!3d32.2870485!4d-9.2283802!16s%2Fg%2F11s333hg51?entry=ttu&g_ep=EgoyMDI2MDQwNS4wIKXMDSoASAFQAw%3D%3D" target="_blank" class="nav-link font-medium flex items-center gap-1" title="Notre Localisation">
                    <span>🏢</span><span>Localisation</span>
                </a>
                <a href="{{ route('tracking.index') }}" class="nav-link font-medium flex items-center gap-1">
                    <span>📍</span><span>Suivi Commande</span>
                </a>
                @php $cartCount = session('cart') ? count(session('cart')) : 0; @endphp
                <a href="{{ route('cart.index') }}" class="nav-link font-medium flex items-center gap-1 relative">
                    <span>🛒</span><span>Panier</span>
                    <span class="cart-badge absolute -top-2 -right-3" id="cart-count">{{ $cartCount }}</span>
                </a>
                @auth
                    <a href="{{ route('dashboard') }}"
                       class="text-xs font-semibold tracking-widest uppercase px-4 py-2 rounded-full transition-all duration-200"
                       style="background:rgba(232,197,71,0.12); color:#e8c547; border:1px solid rgba(232,197,71,0.2);"
                       onmouseover="this.style.background='rgba(232,197,71,0.2)'"
                       onmouseout="this.style.background='rgba(232,197,71,0.12)'">Mon Espace</a>
                @else
                    <a href="{{ route('login') }}"
                       class="text-xs font-semibold tracking-widest uppercase px-4 py-2 rounded-full transition-all duration-200"
                       style="background:rgba(232,197,71,0.12); color:#e8c547; border:1px solid rgba(232,197,71,0.2);"
                       onmouseover="this.style.background='rgba(232,197,71,0.2)'"
                       onmouseout="this.style.background='rgba(232,197,71,0.12)'">Se connecter</a>
                @endauth
            </div>

            {{-- Mobile: icons + hamburger --}}
            <div class="flex md:hidden items-center gap-2">
                <button onclick="toggleTheme()" class="toggle-btn" style="width:32px; height:32px;">
                    <svg id="sunIconM" class="w-4 h-4 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 3v1m0 16v1m8-9h1M3 12H2m15.364-6.364l.707-.707M6.343 17.657l-.707.707m12.728 0l-.707-.707M6.343 6.343l-.707-.707M12 8a4 4 0 100 8 4 4 0 000-8z"/>
                    </svg>
                    <svg id="moonIconM" class="w-4 h-4 hidden" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M21 12.79A9 9 0 0111.21 3c0 .34.02.67.05 1A7 7 0 0019 19c.33.03.66.05 1 .05z"/>
                    </svg>
                </button>
                @php if(!isset($cartCount)) $cartCount = session('cart') ? count(session('cart')) : 0; @endphp
                <a href="{{ route('cart.index') }}" class="relative toggle-btn" style="width:32px; height:32px; text-decoration:none;">
                    🛒
                    <span class="cart-badge absolute -top-1 -right-1" id="cart-count-m" style="width:15px; height:15px; font-size:0.55rem;">{{ $cartCount }}</span>
                </a>
                <button onclick="toggleShopMobileMenu()" class="flex flex-col items-center justify-center w-9 h-9 rounded-lg transition-all"
                        style="background:rgba(255,255,255,0.06); border:1px solid rgba(255,255,255,0.1);">
                    <span class="block w-4 h-0.5 mb-1 transition-all duration-300" style="background:#e8c547;" id="shopHam1"></span>
                    <span class="block w-4 h-0.5 mb-1 transition-all duration-300" style="background:#e8c547;" id="shopHam2"></span>
                    <span class="block w-4 h-0.5 transition-all duration-300" style="background:#e8c547;" id="shopHam3"></span>
                </button>
            </div>
        </div>

        {{-- Mobile Menu --}}
        <div id="shopMobileMenu" class="md:hidden overflow-hidden transition-all duration-300 ease-in-out" style="max-height:0; opacity:0;">
            <div class="pt-4 pb-2 space-y-1">
                <a href="{{ route('shop.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all"
                   style="color:#e8c547; background:rgba(232,197,71,0.08);">
                    <span>🏠</span> Accueil
                </a>
                <a href="https://www.google.com/maps/place/Miza/@32.2870485,-9.2290253,169m/data=!3m2!1e3!4b1!4m6!3m5!1s0xdac2769bb875665:0x2037af52b4630b38!8m2!3d32.2870485!4d-9.2283802!16s%2Fg%2F11s333hg51?entry=ttu&g_ep=EgoyMDI2MDQwNS4wIKXMDSoASAFQAw%3D%3D" target="_blank" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all"
                   style="color:#a7a4c0;" title="Notre Localisation">
                    <span>🏢</span> Localisation
                </a>
                <a href="{{ route('tracking.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all"
                   style="color:#a7a4c0;">
                    <span>📍</span> Suivi Commande
                </a>
                <a href="{{ route('cart.index') }}" class="flex items-center justify-between px-3 py-2.5 rounded-xl text-sm font-medium transition-all"
                   style="color:#a7a4c0;">
                    <span class="flex items-center gap-3"><span>🛒</span> Panier</span>
                    <span class="cart-badge" style="width:18px; height:18px; font-size:0.6rem;">{{ $cartCount }}</span>
                </a>
                <div class="my-2" style="border-top:1px solid rgba(128,128,128,0.1);"></div>
                @auth
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all"
                       style="color:#e8c547;">
                        <span>⚡</span> Mon Espace
                    </a>
                @else
                    <a href="{{ route('login') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all"
                       style="color:#e8c547;">
                        <span>🔐</span> Se connecter
                    </a>
                @endauth
            </div>
        </div>
    </div>
</nav>

<!-- CONTENT -->
<div class="max-w-6xl mx-auto px-6 py-10">

    <!-- Sctructure de filtre et menu de navigation -->
    @php
        $hasActiveFilters = request('category_id') || request('brand_id');
        $filterCount = (request('category_id') ? 1 : 0) + (request('brand_id') ? 1 : 0);
    @endphp

    <form action="{{ route('shop.index') }}" method="GET" id="shopFilterForm" class="mb-8">
        <div class="toolbar rounded-2xl px-6 py-5 flex flex-col gap-4">
            
            <!-- Header + Search Row -->
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <span class="title-badge">Miza Shop — Catalogue</span>
                    <h2 class="text-3xl font-normal tracking-tight">Nos Produits</h2>
                </div>

                <div class="flex items-center gap-3 w-full md:w-auto">
                    <!-- Search Input -->
                    <div class="relative flex-1 md:w-64">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-sm opacity-50">🔍</span>
                        <input type="text" name="search" value="{{ request('search') }}"
                               placeholder="Chercher un produit..."
                               class="search-box pl-9 pr-4 py-2.5 rounded-xl text-sm w-full transition-all duration-200">
                    </div>

                    <!-- Search Button -->
                    <button type="submit" class="btn-gold px-4 py-2.5 text-sm whitespace-nowrap">
                        Chercher
                    </button>

                    <!-- Filter Toggle Button -->
                    <button type="button" onclick="toggleShopFilters()"
                            class="relative flex items-center justify-center gap-2 p-2.5 rounded-xl transition-all duration-200 cursor-pointer"
                            style="background:{{ $hasActiveFilters ? 'rgba(232,197,71,0.15)' : 'transparent' }}; 
                                   color:{{ $hasActiveFilters ? '#e8c547' : 'inherit' }};
                                   border:1px solid {{ $hasActiveFilters ? 'rgba(232,197,71,0.3)' : 'rgba(128,128,128,0.2)' }};">
                        
                        <!-- Equalizer SVG -->
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="4" y1="6" x2="20" y2="6"></line>
                            <line x1="4" y1="12" x2="20" y2="12"></line>
                            <line x1="4" y1="18" x2="20" y2="18"></line>
                            <circle cx="8" cy="6" r="2" fill="currentColor" stroke="none"></circle>
                            <circle cx="16" cy="12" r="2" fill="currentColor" stroke="none"></circle>
                            <circle cx="10" cy="18" r="2" fill="currentColor" stroke="none"></circle>
                        </svg>

                        @if($filterCount > 0)
                            <span class="absolute -top-1.5 -right-1.5 w-5 h-5 rounded-full flex items-center justify-center text-[10px] font-bold"
                                  style="background:#e8c547; color:#0f0e17; box-shadow: 0 2px 8px rgba(232,197,71,0.4);">
                                {{ $filterCount }}
                            </span>
                        @endif
                    </button>

                    <!-- Reset -->
                    @if(request('search') || $hasActiveFilters)
                        <a href="{{ route('shop.index') }}" 
                           class="p-2.5 rounded-xl transition-all duration-200"
                           style="background:rgba(239,68,68,0.1); color:#f87171; border:1px solid rgba(239,68,68,0.2);"
                           title="Réinitialiser">
                           ✕
                        </a>
                    @endif
                </div>
            </div>

            <!-- Collapsible Filters Panel -->
            <div id="shopFilterPanel" class="overflow-hidden transition-all duration-300 ease-in-out"
                 style="max-height:{{ $hasActiveFilters ? '300px' : '0' }}; opacity:{{ $hasActiveFilters ? '1' : '0' }}; margin-top:{{ $hasActiveFilters ? '8px' : '0' }};">
                
                <div class="p-4 rounded-xl search-box" style="border-width:1px;">
                    <div class="flex flex-wrap items-center gap-4">
                        
                        <!-- Category Filter -->
                        <div class="flex flex-col gap-1.5 flex-1 min-w-[200px]">
                            <label class="text-[10px] font-bold uppercase tracking-widest opacity-60">Catégorie</label>
                            <select name="category_id" class="search-box px-3 py-2 rounded-lg text-sm font-medium outline-none cursor-pointer w-full"
                                    onchange="document.getElementById('shopFilterForm').submit()">
                                <option value="">📂 Toutes les catégories</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Brand Filter -->
                        <div class="flex flex-col gap-1.5 flex-1 min-w-[200px]">
                            <label class="text-[10px] font-bold uppercase tracking-widest opacity-60">Marque</label>
                            <select name="brand_id" class="search-box px-3 py-2 rounded-lg text-sm font-medium outline-none cursor-pointer w-full"
                                    onchange="document.getElementById('shopFilterForm').submit()">
                                <option value="">🏷️ Toutes les marques</option>
                                @foreach($brands as $brand)
                                    <option value="{{ $brand->id }}" {{ request('brand_id') == $brand->id ? 'selected' : '' }}>
                                        {{ $brand->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Active Filters Indicators -->
            @if(request('search') || $hasActiveFilters)
                <div class="flex flex-wrap items-center gap-2 pt-3" style="border-top:1px solid rgba(128,128,128,0.1);">
                    <span class="text-xs font-medium opacity-60">Filtres actifs :</span>
                    @if(request('search'))
                        <span class="text-xs font-semibold px-2.5 py-1 rounded-full text-[#e8c547]" style="background:rgba(232,197,71,0.1); border:1px solid rgba(232,197,71,0.15);">
                            🔍 "{{ request('search') }}"
                        </span>
                    @endif
                    @if(request('category_id'))
                        @php $catName = $categories->find(request('category_id'))->name ?? ''; @endphp
                        <span class="text-xs font-semibold px-2.5 py-1 rounded-full text-[#60a5fa]" style="background:rgba(96,165,250,0.1); border:1px solid rgba(96,165,250,0.15);">
                            📂 {{ $catName }}
                        </span>
                    @endif
                    @if(request('brand_id'))
                        @php $brandName = $brands->find(request('brand_id'))->name ?? ''; @endphp
                        <span class="text-xs font-semibold px-2.5 py-1 rounded-full text-[#34d399]" style="background:rgba(52,211,153,0.1); border:1px solid rgba(52,211,153,0.15);">
                            🏷️ {{ $brandName }}
                        </span>
                    @endif
                </div>
            @endif

        </div>
    </form>

    <!-- Grid -->
    @if($products->isEmpty())
        <div class="text-center py-20 rounded-2xl toolbar">
            <div class="text-6xl mb-4 opacity-50">🛍️</div>
            <h3 class="text-xl font-medium mb-2">Aucun produit trouvé</h3>
            <p class="opacity-60 text-sm mb-6">Essayez de modifier vos filtres ou de chercher autre chose.</p>
            <a href="{{ route('shop.index') }}" class="btn-gold px-6 py-2.5 text-sm inline-block">
                Réinitialiser les filtres
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5">

            @foreach($products as $product)
        <div class="card rounded-2xl overflow-hidden transition-all duration-200">

            <!-- Image (clickable) -->
            <a href="{{ route('shop.show', $product->id) }}" class="block">
                <div class="img-bg h-48 flex items-center justify-center overflow-hidden">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}"
                             alt="{{ $product->name }}"
                             class="w-full h-full object-cover transition-transform duration-300"
                             onmouseover="this.style.transform='scale(1.05)'"
                             onmouseout="this.style.transform='scale(1)'">
                    @else
                        <span style="font-size:2.5rem; opacity:0.2;">📦</span>
                    @endif
                </div>
            </a>

            <!-- Info -->
            <div class="p-5">
                <div class="mb-2">
                    <span class="badge-brand">
                        {{ $product->brand ? $product->brand->name : 'Générique' }}
                    </span>
                </div>

                <a href="{{ route('shop.show', $product->id) }}">
                    <h3 class="prod-name text-sm font-semibold truncate mb-1 hover:underline" title="{{ $product->name }}">
                        {{ $product->name }}
                    </h3>
                </a>

                <p class="price-text text-2xl mb-4">
                    {{ number_format($product->selling_price, 2) }}
                    <span class="price-unit text-sm font-normal">DH</span>
                </p>

                <div class="flex gap-2">
                    <button onclick="addToCart('{{ route('cart.add', $product->id) }}')" class="btn-gold flex-1 py-2 px-3 text-sm">
                        🛒 Ajouter
                    </button>
                    <a href="{{ route('shop.show', $product->id) }}"
                       class="py-2 px-3 text-sm font-semibold rounded-xl transition-all duration-200 text-center"
                       style="background:rgba(99,102,241,0.1); color:#818cf8; border:1px solid rgba(99,102,241,0.2);"
                       onmouseover="this.style.background='rgba(99,102,241,0.2)'"
                       onmouseout="this.style.background='rgba(99,102,241,0.1)'">
                        Détails
                    </a>
                </div>
            </div>

        </div>
        @endforeach

        </div>
    @endif

    <!-- Pagination -->
    <div class="mt-12 flex justify-center">
        {{ $products->links() }}
    </div>

</div>

<!-- SCRIPT -->
<script>
const body   = document.getElementById('body')
const sun    = document.getElementById('sunIcon')
const moon   = document.getElementById('moonIcon')
const sunM   = document.getElementById('sunIconM')
const moonM  = document.getElementById('moonIconM')

function addToCart(url) {
    const tokenMeta = document.querySelector('meta[name="csrf-token"]');
    if (!tokenMeta) {
        alert("🚨 نسيتي ماحطيتيش <meta name='csrf-token'> الفوق فـ <head> !");
        return;
    }

    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': tokenMeta.content
        }
    })
    .then(async response => {
        const data = await response.json();
        if (!response.ok) {
            console.error( data);
            throw new Error('Server Error');
        }
        return data;
    })
    .then(data => {
        if (data.cartCount !== undefined) {
            const el = document.getElementById('cart-count');
            const elM = document.getElementById('cart-count-m');
            if(el) el.textContent = data.cartCount;
            if(elM) elM.textContent = data.cartCount;
        }
    })
    .catch(error => {
        console.error(error);
    });
}

function applyTheme(theme) {
    body.classList.remove('dark','light')
    body.classList.add(theme)
    if (theme === 'dark') {
        if(moon) moon.classList.remove('hidden')
        if(sun) sun.classList.add('hidden')
        if(moonM) moonM.classList.remove('hidden')
        if(sunM) sunM.classList.add('hidden')
    } else {
        if(sun) sun.classList.remove('hidden')
        if(moon) moon.classList.add('hidden')
        if(sunM) sunM.classList.remove('hidden')
        if(moonM) moonM.classList.add('hidden')
    }
    localStorage.setItem('theme', theme)
}

function toggleTheme() {
    const current = localStorage.getItem('theme') || 'dark'
    applyTheme(current === 'dark' ? 'light' : 'dark')
}

function toggleShopFilters() {
    const panel = document.getElementById('shopFilterPanel');
    if (panel.style.maxHeight === '0px' || panel.style.maxHeight === '') {
        panel.style.maxHeight = '300px';
        panel.style.opacity = '1';
        panel.style.marginTop = '8px';
    } else {
        panel.style.maxHeight = '0px';
        panel.style.opacity = '0';
        panel.style.marginTop = '0px';
    }
}

function toggleShopMobileMenu() {
    const menu = document.getElementById('shopMobileMenu');
    const l1 = document.getElementById('shopHam1');
    const l2 = document.getElementById('shopHam2');
    const l3 = document.getElementById('shopHam3');

    if (menu.style.maxHeight === '0px' || menu.style.maxHeight === '') {
        menu.style.maxHeight = '400px';
        menu.style.opacity = '1';
        l1.style.transform = 'rotate(45deg) translate(4px, 4px)';
        l2.style.opacity = '0';
        l3.style.transform = 'rotate(-45deg) translate(4px, -4px)';
    } else {
        menu.style.maxHeight = '0px';
        menu.style.opacity = '0';
        l1.style.transform = '';
        l2.style.opacity = '1';
        l3.style.transform = '';
    }
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

</body>
</html>
