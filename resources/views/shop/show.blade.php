<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>{{ $product->name }} - Miza Shop</title>
<meta name="description" content="{{ Str::limit($product->description, 160) }}">
<meta name="csrf-token" content="{{ csrf_token() }}">
<script src="https://cdn.tailwindcss.com"></script>
<link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
<style>
    body { font-family: 'DM Sans', sans-serif; }
    h1, h2, .serif { font-family: 'DM Serif Display', serif; }

    /* ── DARK ── */
    .dark { background: #0f0e17; background-image: radial-gradient(ellipse 80% 50% at 50% -10%, rgba(232,197,71,0.08) 0%, transparent 70%); color: #fffffe; }
    .light { background: #f4f3ef; background-image: radial-gradient(ellipse 80% 50% at 50% -10%, rgba(232,197,71,0.12) 0%, transparent 70%); color: #1a1828; }

    .dark .navbar  { background: rgba(26,24,40,0.85); border-bottom: 1px solid rgba(255,255,255,0.06); }
    .light .navbar { background: rgba(255,255,255,0.85); border-bottom: 1px solid rgba(0,0,0,0.07); }

    .dark .panel  { background: #1a1828; border: 1px solid rgba(255,255,255,0.07); }
    .light .panel { background: #ffffff; border: 1px solid rgba(0,0,0,0.07); }

    .dark .card  { background: #1a1828; border: 1px solid rgba(255,255,255,0.07); box-shadow: 0 8px 24px rgba(0,0,0,0.3); }
    .light .card { background: #ffffff; border: 1px solid rgba(0,0,0,0.07); box-shadow: 0 8px 24px rgba(0,0,0,0.07); }
    .dark  .card:hover { border-color: rgba(232,197,71,0.28) !important; }
    .light .card:hover { border-color: rgba(232,197,71,0.45) !important; }

    .dark  .text-main { color: #fffffe; }
    .light .text-main { color: #1a1828; }
    .dark  .text-sub { color: #a7a4c0; }
    .light .text-sub { color: #6e6b8a; }
    .dark  .text-muted { color: #6e6b8a; }
    .light .text-muted { color: #9e9bac; }

    .dark  .img-bg { background: linear-gradient(135deg,#1e1c2e,#252336); }
    .light .img-bg { background: linear-gradient(135deg,#ede9f0,#ddd9e8); }

    .dark  .divider { border-color: rgba(255,255,255,0.07); }
    .light .divider { border-color: rgba(0,0,0,0.07); }

    .badge-brand { background: rgba(232,197,71,0.1); color: #e8c547; border: 1px solid rgba(232,197,71,0.2); font-size: 0.65rem; font-weight: 600; letter-spacing: 0.08em; text-transform: uppercase; padding: 3px 10px; border-radius: 999px; }
    .badge-cat   { background: rgba(99,102,241,0.1); color: #818cf8; border: 1px solid rgba(99,102,241,0.2); font-size: 0.65rem; font-weight: 600; letter-spacing: 0.08em; text-transform: uppercase; padding: 3px 10px; border-radius: 999px; }
    .badge-stock-ok  { background: rgba(110,231,183,0.1); color: #6ee7b7; border: 1px solid rgba(110,231,183,0.2); }
    .badge-stock-low { background: rgba(239,68,68,0.1); color: #f87171; border: 1px solid rgba(239,68,68,0.2); }

    .price-text { font-family: 'DM Serif Display', serif; color: #e8c547; }
    .btn-gold { background: linear-gradient(135deg,#e8c547,#c9a227); color: #0f0e17; font-weight: 600; border-radius: 14px; transition: all 0.25s; border: none; cursor: pointer; }
    .btn-gold:hover { background: linear-gradient(135deg,#f0d060,#e8c547); transform: translateY(-2px); box-shadow: 0 8px 28px rgba(232,197,71,0.35); }
    .btn-gold:active { transform: translateY(0); }

    .nav-link { font-size: 0.875rem; transition: color 0.2s; display:flex; align-items:center; gap:5px; }
    .dark  .nav-link { color: #a7a4c0; }
    .light .nav-link { color: #6e6b8a; }
    .dark  .nav-link:hover { color: #fffffe; }
    .light .nav-link:hover { color: #1a1828; }

    .toggle-btn { border-radius: 999px; width:36px; height:36px; display:flex; align-items:center; justify-content:center; transition: all 0.2s; cursor: pointer; }
    .dark  .toggle-btn { background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.1); color: #fffffe; }
    .light .toggle-btn { background: rgba(0,0,0,0.05); border: 1px solid rgba(0,0,0,0.1); color: #1a1828; }
    .toggle-btn:hover { border-color: rgba(232,197,71,0.4); }

    .cart-badge { background: #e8c547; color: #0f0e17; font-size: 0.6rem; font-weight: 700; width:17px; height:17px; border-radius:999px; display:flex; align-items:center; justify-content:center; }

    /* ── Gallery ── */
    .gallery-main {
        border-radius: 16px; overflow: hidden; position: relative;
        aspect-ratio: 1/1; width: 100%;
    }
    .gallery-main img {
        width: 100%; height: 100%; object-fit: cover;
        transition: opacity 0.4s ease;
    }
    .gallery-thumbs { display: flex; gap: 8px; margin-top: 12px; overflow-x: auto; padding-bottom: 4px; }
    .gallery-thumb {
        width: 72px; height: 72px; border-radius: 10px; overflow: hidden; cursor: pointer;
        border: 2px solid transparent; transition: all 0.2s; flex-shrink: 0; opacity: 0.6;
    }
    .gallery-thumb:hover { opacity: 0.9; }
    .gallery-thumb.active { border-color: #e8c547; opacity: 1; box-shadow: 0 0 0 3px rgba(232,197,71,0.2); }
    .gallery-thumb img { width: 100%; height: 100%; object-fit: cover; }

    /* ── Zoom overlay ── */
    .zoom-overlay {
        position: fixed; inset: 0; z-index: 100;
        background: rgba(0,0,0,0.92); backdrop-filter: blur(10px);
        display: none; align-items: center; justify-content: center; cursor: zoom-out;
    }
    .zoom-overlay.active { display: flex; }
    .zoom-overlay img { max-width: 90vw; max-height: 90vh; object-fit: contain; border-radius: 12px; }

    /* ── Feature cards ── */
    .dark  .feature-card { background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.06); }
    .light .feature-card { background: rgba(0,0,0,0.02); border: 1px solid rgba(0,0,0,0.06); }

    /* ── Scrollbar ── */
    .gallery-thumbs::-webkit-scrollbar { height: 4px; }
    .gallery-thumbs::-webkit-scrollbar-track { background: transparent; }
    .gallery-thumbs::-webkit-scrollbar-thumb { background: rgba(232,197,71,0.3); border-radius: 4px; }

    /* ── Fade in animation ── */
    @keyframes fadeUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
    .fade-up { animation: fadeUp 0.5s ease forwards; }
    .fade-up-delay { animation: fadeUp 0.5s ease 0.15s forwards; opacity: 0; }
</style>
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
            <a href="https://www.google.com/maps/place/Miza/@32.2870485,-9.2290253,169m/data=!3m2!1e3!4b1!4m6!3m5!1s0xdac2769bb875665:0x2037af52b4630b38!8m2!3d32.2870485!4d-9.2283802!16s%2Fg%2F11s333hg51?entry=ttu&g_ep=EgoyMDI2MDQwNS4wIKXMDSoASAFQAw%3D%3D" target="_blank" class="nav-link font-medium flex items-center gap-1" title="Notre Localisation">
                <span>🏢</span><span class="hidden sm:inline">Localisation</span>
            </a>
            @php $cartCount = session('cart') ? count(session('cart')) : 0; @endphp
            <a href="{{ route('cart.index') }}" class="nav-link font-medium flex items-center gap-1 relative">
                <span>🛒</span> <span class="hidden sm:inline">Panier</span>
                <span class="cart-badge absolute -top-2 -right-3" id="cart-count">{{ $cartCount }}</span>
            </a>
            @auth
                <a href="{{ route('dashboard') }}" class="text-xs font-semibold tracking-widest uppercase px-3 sm:px-4 py-2 rounded-full transition-all duration-200"
                   style="background:rgba(232,197,71,0.12); color:#e8c547; border:1px solid rgba(232,197,71,0.2);"
                   onmouseover="this.style.background='rgba(232,197,71,0.2)'"
                   onmouseout="this.style.background='rgba(232,197,71,0.12)'"><span class="hidden sm:inline">Mon Espace</span><span class="sm:hidden">⚡</span></a>
            @else
                <a href="{{ route('login') }}" class="text-xs font-semibold tracking-widest uppercase px-3 sm:px-4 py-2 rounded-full transition-all duration-200"
                   style="background:rgba(232,197,71,0.12); color:#e8c547; border:1px solid rgba(232,197,71,0.2);"
                   onmouseover="this.style.background='rgba(232,197,71,0.2)'"
                   onmouseout="this.style.background='rgba(232,197,71,0.12)'"><span class="hidden sm:inline">Se connecter</span><span class="sm:hidden">🔐</span></a>
            @endauth
        </div>
    </div>
</nav>

<!-- ZOOM OVERLAY -->
<div class="zoom-overlay" id="zoomOverlay" onclick="closeZoom()">
    <img id="zoomImage" src="" alt="Zoom">
</div>

<!-- BREADCRUMB -->
<div class="max-w-6xl mx-auto px-6 pt-6">
    <div class="flex items-center gap-2 text-xs text-sub">
        <a href="{{ route('shop.index') }}" class="nav-link text-xs" style="gap:3px;">
            <span>🏠</span> Accueil
        </a>
        <span class="text-muted">›</span>
        @if($product->category)
            <span class="text-sub">{{ $product->category->name }}</span>
            <span class="text-muted">›</span>
        @endif
        <span class="text-main font-semibold">{{ $product->name }}</span>
    </div>
</div>

<!-- MAIN CONTENT -->
<div class="max-w-6xl mx-auto px-6 py-8">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">

        <!-- ═══ LEFT: GALLERY ═══ -->
        <div class="fade-up">
            <div class="panel rounded-2xl p-4" style="box-shadow: 0 24px 60px rgba(0,0,0,0.15);">

                <!-- Main Image -->
                <div class="gallery-main img-bg cursor-zoom-in" onclick="openZoom()">
                    @if($product->image)
                        <img id="mainImage" src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                    @else
                        <div class="w-full h-full flex items-center justify-center">
                            <span style="font-size:5rem; opacity:0.15;">📦</span>
                        </div>
                    @endif
                </div>

                <!-- Thumbnails -->
                @php
                    $allImages = collect();
                    if($product->image) {
                        $allImages->push((object)['image_path' => $product->image]);
                    }
                    if($product->images->count()) {
                        $allImages = $allImages->merge($product->images);
                    }
                @endphp

                @if($allImages->count() > 1)
                    <div class="gallery-thumbs">
                        @foreach($allImages as $index => $img)
                            <div class="gallery-thumb {{ $index === 0 ? 'active' : '' }}"
                                 onclick="changeImage('{{ asset('storage/' . $img->image_path) }}', this)">
                                <img src="{{ asset('storage/' . $img->image_path) }}" alt="Image {{ $index + 1 }}">
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        <!-- ═══ RIGHT: PRODUCT INFO ═══ -->
        <div class="fade-up-delay">

            <!-- Badges -->
            <div class="flex items-center gap-2 mb-4 flex-wrap">
                @if($product->brand)
                    <span class="badge-brand">{{ $product->brand->name }}</span>
                @endif
                @if($product->category)
                    <span class="badge-cat">{{ $product->category->name }}</span>
                @endif
            </div>

            <!-- Name -->
            <h1 class="text-main text-3xl lg:text-4xl font-normal tracking-tight mb-4 serif">
                {{ $product->name }}
            </h1>

            <!-- Reference -->
            <p class="text-muted text-xs font-mono mb-6">Réf : {{ $product->reference }}</p>

            <!-- Price -->
            <div class="mb-6 flex items-end gap-3">
                <span class="price-text text-4xl lg:text-5xl">{{ number_format($product->selling_price, 2) }}</span>
                <span class="text-sub text-lg mb-1">DH</span>
            </div>

            <!-- Stock -->
            <div class="mb-6">
                @if($product->stock_quantity > 0)
                    <span class="badge-stock-ok text-xs font-semibold px-3 py-1.5 rounded-full inline-flex items-center gap-1">
                        <span>✓</span> En stock ({{ $product->stock_quantity }} disponibles)
                    </span>
                @else
                    <span class="badge-stock-low text-xs font-semibold px-3 py-1.5 rounded-full inline-flex items-center gap-1">
                        <span>✕</span> Rupture de stock
                    </span>
                @endif
            </div>

            <!-- Divider -->
            <div class="divider border-t mb-6"></div>

            <!-- Description -->
            @if($product->description)
                <div class="mb-6">
                    <h3 class="text-sub text-xs font-semibold tracking-widest uppercase mb-3">Description</h3>
                    <p class="text-sub text-sm leading-relaxed">{{ $product->description }}</p>
                </div>
            @endif

            <!-- Add to Cart -->
            @if($product->stock_quantity > 0)
                <button onclick="addToCart('{{ route('cart.add', $product->id) }}')"
                        class="btn-gold w-full py-4 px-6 text-base flex items-center justify-center gap-3 mb-6"
                        id="addToCartBtn">
                    <span style="font-size:1.2rem;">🛒</span>
                    Ajouter au panier
                </button>
            @else
                <button disabled
                        class="w-full py-4 px-6 text-base rounded-xl font-semibold mb-6 cursor-not-allowed opacity-50"
                        style="background: rgba(255,255,255,0.05); color: #6e6b8a; border: 1px solid rgba(255,255,255,0.07);">
                    Rupture de stock
                </button>
            @endif

            <!-- Features -->
            <div class="grid grid-cols-3 gap-3 mb-4">
                <div class="feature-card rounded-xl p-3 text-center">
                    <div class="text-xl mb-1">🚚</div>
                    <p class="text-muted text-xs font-semibold">Livraison rapide</p>
                </div>
                <div class="feature-card rounded-xl p-3 text-center">
                    <div class="text-xl mb-1">🔒</div>
                    <p class="text-muted text-xs font-semibold">Paiement sécurisé</p>
                </div>
                <div class="feature-card rounded-xl p-3 text-center">
                    <div class="text-xl mb-1">💎</div>
                    <p class="text-muted text-xs font-semibold">Qualité garantie</p>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- RELATED PRODUCTS -->
@if($relatedProducts->count())
<div class="max-w-6xl mx-auto px-6 pb-16">
    <div class="divider border-t mb-8"></div>
    <h2 class="text-main text-2xl font-normal tracking-tight mb-6 serif">Produits similaires</h2>
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-5">
        @foreach($relatedProducts as $related)
        <a href="{{ route('shop.show', $related->id) }}"
           class="card rounded-2xl overflow-hidden transition-all duration-200 block">
            <div class="img-bg h-40 flex items-center justify-center overflow-hidden">
                @if($related->image)
                    <img src="{{ asset('storage/' . $related->image) }}" alt="{{ $related->name }}" class="w-full h-full object-cover">
                @else
                    <span style="font-size:2rem; opacity:0.2;">📦</span>
                @endif
            </div>
            <div class="p-4">
                @if($related->brand)
                    <span class="badge-brand mb-2" style="font-size:0.55rem;">{{ $related->brand->name }}</span>
                @endif
                <h3 class="text-main text-sm font-semibold truncate mt-1" title="{{ $related->name }}">{{ $related->name }}</h3>
                <p class="price-text text-xl mt-2">
                    {{ number_format($related->selling_price, 2) }}
                    <span class="text-sub text-xs font-normal">DH</span>
                </p>
            </div>
        </a>
        @endforeach
    </div>
</div>
@endif

<!-- SCRIPTS -->
<script>
const body = document.getElementById('body')
const sun  = document.getElementById('sunIcon')
const moon = document.getElementById('moonIcon')

// ── Gallery ──
function changeImage(src, thumb) {
    const mainImg = document.getElementById('mainImage');
    if (mainImg) {
        mainImg.style.opacity = '0';
        setTimeout(() => {
            mainImg.src = src;
            mainImg.style.opacity = '1';
        }, 200);
    }
    document.querySelectorAll('.gallery-thumb').forEach(t => t.classList.remove('active'));
    thumb.classList.add('active');
}

// ── Zoom ──
function openZoom() {
    const mainImg = document.getElementById('mainImage');
    if (!mainImg) return;
    document.getElementById('zoomImage').src = mainImg.src;
    document.getElementById('zoomOverlay').classList.add('active');
    document.body.style.overflow = 'hidden';
}
function closeZoom() {
    document.getElementById('zoomOverlay').classList.remove('active');
    document.body.style.overflow = '';
}
document.addEventListener('keydown', e => { if(e.key === 'Escape') closeZoom(); });

// ── Add to Cart (AJAX) ──
function addToCart(url) {
    const tokenMeta = document.querySelector('meta[name="csrf-token"]');
    if (!tokenMeta) return;

    const btn = document.getElementById('addToCartBtn');
    if (btn) {
        btn.innerHTML = '<span>⏳</span> Ajout en cours...';
        btn.style.pointerEvents = 'none';
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
        if (!response.ok) throw new Error('Server Error');
        return data;
    })
    .then(data => {
        if (data.cartCount !== undefined) {
            document.getElementById('cart-count').textContent = data.cartCount;
        }
        if (btn) {
            btn.innerHTML = '<span style="font-size:1.2rem;">✓</span> Ajouté au panier !';
            btn.style.background = 'linear-gradient(135deg,#6ee7b7,#34d399)';
            setTimeout(() => {
                btn.innerHTML = '<span style="font-size:1.2rem;">🛒</span> Ajouter au panier';
                btn.style.background = 'linear-gradient(135deg,#e8c547,#c9a227)';
                btn.style.pointerEvents = '';
            }, 1500);
        }
    })
    .catch(error => {
        console.error(error);
        if (btn) {
            btn.innerHTML = '<span style="font-size:1.2rem;">🛒</span> Ajouter au panier';
            btn.style.pointerEvents = '';
        }
    });
}

// ── Theme ──
function applyTheme(theme) {
    body.classList.remove('dark','light');
    body.classList.add(theme);
    if (theme === 'dark') { moon.classList.remove('hidden'); sun.classList.add('hidden'); }
    else { sun.classList.remove('hidden'); moon.classList.add('hidden'); }
    localStorage.setItem('theme', theme);
}
function toggleTheme() {
    const current = localStorage.getItem('theme') || 'dark';
    applyTheme(current === 'dark' ? 'light' : 'dark');
}
;(function(){
    const saved = localStorage.getItem('theme');
    if (saved) applyTheme(saved);
    else applyTheme(window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
})()
</script>

</body>
</html>
