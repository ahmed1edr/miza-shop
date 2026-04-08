{{-- ===== Admin Navbar — Responsive + Creative ===== --}}
@include('layouts.theme')
<div class="admin-nav" style="background:rgba(26,24,40,0.85); border-bottom:1px solid rgba(255,255,255,0.06);">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 py-3 sm:py-4">

        {{-- Top bar: Logo + Hamburger (mobile) / Full nav (desktop) --}}
        <div class="flex justify-between items-center">

            {{-- Logo --}}
            <span class="text-xs font-semibold tracking-widest uppercase px-3 py-1 rounded-full"
                  style="background:rgba(232,197,71,0.12); color:#e8c547; border:1px solid rgba(232,197,71,0.2);">
                Miza Shop
            </span>

            {{-- Desktop Navigation --}}
            <div class="hidden lg:flex items-center gap-1">
                {{-- Theme toggle --}}
                <button onclick="toggleTheme()" class="flex items-center justify-center w-8 h-8 rounded-full transition-all duration-200 mr-2"
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
                <a href="{{ route('dashboard') }}"
                   class="text-xs font-semibold tracking-wide px-4 py-2 rounded-lg transition-all duration-200"
                   style="color:#a7a4c0;"
                   onmouseover="this.style.color='#e8c547'; this.style.background='rgba(232,197,71,0.08)'"
                   onmouseout="this.style.color='#a7a4c0'; this.style.background='transparent'">
                    Dashboard
                </a>
                <a href="{{ route('products.index') }}"
                   class="text-xs font-semibold tracking-wide px-4 py-2 rounded-lg transition-all duration-200"
                   style="color:#a7a4c0;"
                   onmouseover="this.style.color='#e8c547'; this.style.background='rgba(232,197,71,0.08)'"
                   onmouseout="this.style.color='#a7a4c0'; this.style.background='transparent'">
                    Produits
                </a>
                @php
                    $pendingCount = 0;
                    if(auth()->check()) {
                        if(auth()->user()->role === 'admin') {
                            $pendingCount = \App\Models\Order::where('status', 'en attente')->count();
                        } else {
                            $pendingCount = \App\Models\Order::where('status', 'en attente')
                                                ->where('brand_id', auth()->user()->brand_id)->count();
                        }
                    }
                @endphp
                <a href="{{ route('orders.index') }}"
                   class="relative text-xs font-semibold tracking-wide px-4 py-2 rounded-lg transition-all duration-200"
                   style="color:#a7a4c0;"
                   onmouseover="this.style.color='#e8c547'; this.style.background='rgba(232,197,71,0.08)'"
                   onmouseout="this.style.color='#a7a4c0'; this.style.background='transparent'">
                    📦 Commandes
                    <span id="nav-pending-badge"
                          class="absolute -top-1 -right-2 flex items-center justify-center w-4 h-4 rounded-full text-[10px] font-bold animate-pulse"
                          style="background:#e8c547; color:#0f0e17; box-shadow:0 0 10px rgba(232,197,71,0.5); {{ $pendingCount > 0 ? '' : 'display:none;' }}">
                        {{ $pendingCount > 99 ? '99+' : $pendingCount }}
                    </span>
                </a>
                <script>
                    setInterval(() => {
                        fetch('{{ route("api.pending.count") }}')
                            .then(res => res.json())
                            .then(data => {
                                let badge = document.getElementById('nav-pending-badge');
                                if (badge) {
                                    if(data.count > 0) {
                                        badge.style.display = 'flex';
                                        badge.innerText = data.count > 99 ? '99+' : data.count;
                                    } else {
                                        badge.style.display = 'none';
                                    }
                                }
                            });
                    }, 15000);
                </script>
                @if(auth()->user()->role === 'admin')
                    <a href="{{ route('categories.index') }}"
                       class="text-xs font-semibold tracking-wide px-4 py-2 rounded-lg transition-all duration-200"
                       style="color:#a7a4c0;"
                       onmouseover="this.style.color='#e8c547'; this.style.background='rgba(232,197,71,0.08)'"
                       onmouseout="this.style.color='#a7a4c0'; this.style.background='transparent'">
                        Catégories
                    </a>
                    <a href="{{ route('brands.index') }}"
                       class="text-xs font-semibold tracking-wide px-4 py-2 rounded-lg transition-all duration-200"
                       style="color:#a7a4c0;"
                       onmouseover="this.style.color='#e8c547'; this.style.background='rgba(232,197,71,0.08)'"
                       onmouseout="this.style.color='#a7a4c0'; this.style.background='transparent'">
                        Familles
                    </a>
                    <a href="{{ route('logs.index') }}"
                       class="text-xs font-semibold tracking-wide px-4 py-2 rounded-lg transition-all duration-200"
                       style="color:#a7a4c0;"
                       onmouseover="this.style.color='#e8c547'; this.style.background='rgba(232,197,71,0.08)'"
                       onmouseout="this.style.color='#a7a4c0'; this.style.background='transparent'">
                        Audit & Logs
                    </a>
                    <a href="{{ route('users.index') }}"
                       class="text-xs font-semibold tracking-wide px-4 py-2 rounded-lg transition-all duration-200"
                       style="color:#a7a4c0;"
                       onmouseover="this.style.color='#e8c547'; this.style.background='rgba(232,197,71,0.08)'"
                       onmouseout="this.style.color='#a7a4c0'; this.style.background='transparent'">
                        Utilisateurs
                    </a>
                @endif
            </div>

            {{-- Desktop: User + Logout --}}
            <div class="hidden lg:flex items-center gap-3">
                <div class="flex items-center gap-2 px-3 py-1.5 rounded-lg"
                     style="background:rgba(255,255,255,0.04); border:1px solid rgba(255,255,255,0.07);">
                    <span class="w-2 h-2 rounded-full" style="background:#e8c547;"></span>
                    <span class="text-xs font-semibold" style="color:#a7a4c0;">{{ auth()->user()->name }}</span>
                    @if(auth()->user()->role === 'admin')
                        <span class="text-xs font-semibold px-2 py-0.5 rounded-full"
                              style="background:rgba(168,85,247,0.12); color:#c084fc; border:1px solid rgba(168,85,247,0.25);">
                            Admin
                        </span>
                    @else
                        <span class="text-xs font-semibold px-2 py-0.5 rounded-full"
                              style="background:rgba(99,102,241,0.12); color:#818cf8; border:1px solid rgba(99,102,241,0.2);">
                            Employé
                        </span>
                    @endif
                </div>
                <form action="{{ route('logout') }}" method="POST" class="m-0">
                    @csrf
                    <button type="submit"
                            class="text-xs font-semibold px-4 py-2 rounded-lg transition-all duration-200"
                            style="background:rgba(239,68,68,0.1); color:#f87171; border:1px solid rgba(239,68,68,0.2);"
                            onmouseover="this.style.background='rgba(239,68,68,0.2)'; this.style.color='#fca5a5'"
                            onmouseout="this.style.background='rgba(239,68,68,0.1)'; this.style.color='#f87171'">
                        Déconnexion
                    </button>
                </form>
            </div>

            {{-- Mobile: Hamburger Button --}}
            <button onclick="toggleAdminMenu()" class="lg:hidden flex flex-col items-center justify-center w-10 h-10 rounded-lg transition-all"
                    style="background:rgba(255,255,255,0.06); border:1px solid rgba(255,255,255,0.1);"
                    id="hamburgerBtn">
                <span class="block w-5 h-0.5 mb-1 transition-all duration-300" style="background:#e8c547;" id="hamLine1"></span>
                <span class="block w-5 h-0.5 mb-1 transition-all duration-300" style="background:#e8c547;" id="hamLine2"></span>
                <span class="block w-5 h-0.5 transition-all duration-300" style="background:#e8c547;" id="hamLine3"></span>
            </button>
        </div>

        {{-- Mobile Menu (hidden by default) --}}
        <div id="mobileAdminMenu" class="lg:hidden overflow-hidden transition-all duration-300 ease-in-out"
             style="max-height:0; opacity:0;">
            <div class="pt-4 pb-2 space-y-1">

                {{-- User Info (mobile) --}}
                <div class="flex items-center justify-between px-3 py-2.5 mb-3 rounded-xl"
                     style="background:rgba(255,255,255,0.04); border:1px solid rgba(255,255,255,0.07);">
                    <div class="flex items-center gap-2">
                        <span class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold"
                              style="background:rgba(232,197,71,0.15); color:#e8c547;">
                            {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                        </span>
                        <div>
                            <span class="text-xs font-semibold block" style="color:#fffffe;">{{ auth()->user()->name }}</span>
                            @if(auth()->user()->role === 'admin')
                                <span class="text-[10px] font-semibold" style="color:#c084fc;">Admin</span>
                            @else
                                <span class="text-[10px] font-semibold" style="color:#818cf8;">Employé</span>
                            @endif
                        </div>
                    </div>
                    
                    {{-- Mobile Theme toggle --}}
                    <button onclick="toggleTheme()" class="flex items-center justify-center w-8 h-8 rounded-lg transition-all duration-200"
                            style="background:rgba(255,255,255,0.05); color:#a7a4c0;">
                        <svg id="sunIconMob" class="w-4 h-4 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m8-9h1M3 12H2m15.364-6.364l.707-.707M6.343 17.657l-.707.707m12.728 0l-.707-.707M6.343 6.343l-.707-.707M12 8a4 4 0 100 8 4 4 0 000-8z"/>
                        </svg>
                        <svg id="moonIconMob" class="w-4 h-4 hidden" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M21 12.79A9 9 0 0111.21 3c0 .34.02.67.05 1A7 7 0 0019 19c.33.03.66.05 1 .05z"/>
                        </svg>
                    </button>
                </div>

                {{-- Nav Links --}}
                <a href="{{ route('dashboard') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all"
                   style="color:#a7a4c0;"
                   onmouseover="this.style.background='rgba(232,197,71,0.08)'; this.style.color='#e8c547'"
                   onmouseout="this.style.background='transparent'; this.style.color='#a7a4c0'">
                    <span>📊</span> Dashboard
                </a>
                <a href="{{ route('products.index') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all"
                   style="color:#a7a4c0;"
                   onmouseover="this.style.background='rgba(232,197,71,0.08)'; this.style.color='#e8c547'"
                   onmouseout="this.style.background='transparent'; this.style.color='#a7a4c0'">
                    <span>📦</span> Produits
                </a>
                <a href="{{ route('orders.index') }}"
                   class="flex items-center justify-between px-3 py-2.5 rounded-xl text-sm font-medium transition-all"
                   style="color:#a7a4c0;"
                   onmouseover="this.style.background='rgba(232,197,71,0.08)'; this.style.color='#e8c547'"
                   onmouseout="this.style.background='transparent'; this.style.color='#a7a4c0'">
                    <span class="flex items-center gap-3"><span>🛒</span> Commandes</span>
                    @if($pendingCount > 0)
                        <span class="flex items-center justify-center w-5 h-5 rounded-full text-[10px] font-bold"
                              style="background:#e8c547; color:#0f0e17;">{{ $pendingCount > 99 ? '99+' : $pendingCount }}</span>
                    @endif
                </a>
                @if(auth()->user()->role === 'admin')
                    <a href="{{ route('categories.index') }}"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all"
                       style="color:#a7a4c0;"
                       onmouseover="this.style.background='rgba(232,197,71,0.08)'; this.style.color='#e8c547'"
                       onmouseout="this.style.background='transparent'; this.style.color='#a7a4c0'">
                        <span>📂</span> Catégories
                    </a>
                    <a href="{{ route('brands.index') }}"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all"
                       style="color:#a7a4c0;"
                       onmouseover="this.style.background='rgba(232,197,71,0.08)'; this.style.color='#e8c547'"
                       onmouseout="this.style.background='transparent'; this.style.color='#a7a4c0'">
                        <span>🏷️</span> Familles
                    </a>
                    <a href="{{ route('logs.index') }}"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all"
                       style="color:#a7a4c0;"
                       onmouseover="this.style.background='rgba(232,197,71,0.08)'; this.style.color='#e8c547'"
                       onmouseout="this.style.background='transparent'; this.style.color='#a7a4c0'">
                        <span>🕵️</span> Audit & Logs
                    </a>
                    <a href="{{ route('users.index') }}"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all"
                       style="color:#a7a4c0;"
                       onmouseover="this.style.background='rgba(232,197,71,0.08)'; this.style.color='#e8c547'"
                       onmouseout="this.style.background='transparent'; this.style.color='#a7a4c0'">
                        <span>👥</span> Utilisateurs
                    </a>
                @endif

                {{-- Divider --}}
                <div class="my-2" style="border-top:1px solid rgba(255,255,255,0.06);"></div>

                {{-- Logout --}}
                <form action="{{ route('logout') }}" method="POST" class="m-0">
                    @csrf
                    <button type="submit"
                            class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all text-left"
                            style="color:#f87171; background:rgba(239,68,68,0.06);"
                            onmouseover="this.style.background='rgba(239,68,68,0.12)'"
                            onmouseout="this.style.background='rgba(239,68,68,0.06)'">
                        <span>🚪</span> Déconnexion
                    </button>
                </form>
            </div>
        </div>

    </div>
</div>

{{-- Mobile menu toggle script --}}
<script>
function toggleAdminMenu() {
    const menu = document.getElementById('mobileAdminMenu');
    const l1 = document.getElementById('hamLine1');
    const l2 = document.getElementById('hamLine2');
    const l3 = document.getElementById('hamLine3');

    if (menu.style.maxHeight === '0px' || menu.style.maxHeight === '') {
        menu.style.maxHeight = '500px';
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
</script>

@if(session('success'))
    <div class="max-w-7xl mx-auto px-4 sm:px-6 mt-4">
        <div class="flex items-start gap-3 p-4 rounded-xl text-sm font-medium"
             style="background:#0d2e1e; border:1px solid rgba(110,231,183,0.2); color:#6ee7b7;">
            <span class="font-bold">✓</span>
            <p>{{ session('success') }}</p>
        </div>
    </div>
@endif

@if(session('error'))
    <div class="max-w-7xl mx-auto px-4 sm:px-6 mt-4">
        <div class="flex items-start gap-3 p-4 rounded-xl text-sm font-medium"
             style="background:#2d1515; border:1px solid rgba(252,165,165,0.15); color:#fca5a5;">
            <span class="font-bold">⚠</span>
            <p>{{ session('error') }}</p>
        </div>
    </div>
@endif
