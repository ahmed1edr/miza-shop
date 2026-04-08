<!DOCTYPE html>
<html lang="fr" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des produits - Miza Shop</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display&family=DM+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'DM Sans', sans-serif; }
        h2   { font-family: 'DM Serif Display', serif; }

        /* Scrollbar */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: #1a1828; }
        ::-webkit-scrollbar-thumb { background: rgba(232,197,71,0.3); border-radius: 999px; }

        /* Checkbox */
        input[type="checkbox"] { accent-color: #e8c547; }

        /* Select */
        select option { background: #1a1828; color: #fffffe; }

        /* Inactive row overlay */
        .row-inactive {
            position: relative;
        }
        .row-inactive::after {
            content: '';
            position: absolute;
            inset: 0;
            background: rgba(15,14,23,0.45);
            pointer-events: none;
            border-radius: 0;
        }

        /* Row animation */
        @keyframes fadeSlideIn {
            from { opacity: 0; transform: translateY(6px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .product-row {
            animation: fadeSlideIn 0.25s ease forwards;
        }

        /* Filter panel */
        @keyframes slideDown {
            from { opacity: 0; max-height: 0; }
            to { opacity: 1; max-height: 300px; }
        }
        .filter-panel {
            overflow: hidden;
            transition: all 0.3s ease;
        }
    </style>
</head>
<body class="min-h-screen antialiased"
      style="background:#0f0e17; background-image: radial-gradient(ellipse 80% 50% at 50% -10%, rgba(232,197,71,0.08) 0%, transparent 70%);">

    {{-- Navbar --}}
    @include('layouts.navbar')

    {{-- Bulk Actions Hidden Form --}}
    <form id="bulkForm" action="{{ route('products.bulk') }}" method="POST">
        @csrf
    </form>

    {{-- Main Content --}}
    <div class="max-w-7xl mx-auto p-6 md:p-8">
        <div class="rounded-2xl p-6 md:p-8"
             style="background:#1a1828; border:1px solid rgba(255,255,255,0.07); box-shadow: 0 24px 60px rgba(0,0,0,0.5), 0 0 80px rgba(232,197,71,0.04);">

            {{-- ═══════════════════════════════════════════ --}}
            {{-- HEADER --}}
            {{-- ═══════════════════════════════════════════ --}}
            <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4 mb-6">
                <div>
                    <span class="text-xs font-semibold tracking-widest uppercase px-3 py-1 rounded-full mb-3 inline-block"
                          style="background:rgba(232,197,71,0.12); color:#e8c547; border:1px solid rgba(232,197,71,0.2);">
                        Miza Shop — Admin
                    </span>
                    <h2 class="text-3xl font-normal tracking-tight" style="color:#fffffe;">
                        Liste des produits
                    </h2>
                </div>

                {{-- Add Product Button --}}
                <a href="{{ route('products.create') }}"
                   class="font-semibold py-2.5 px-5 rounded-xl text-sm transition-all duration-200 whitespace-nowrap flex items-center gap-2"
                   style="background:#e8c547; color:#0f0e17; box-shadow:0 4px 20px rgba(232,197,71,0.25);"
                   onmouseover="this.style.background='#f0d060'; this.style.transform='translateY(-1px)'; this.style.boxShadow='0 8px 28px rgba(232,197,71,0.35)'"
                   onmouseout="this.style.background='#e8c547'; this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 20px rgba(232,197,71,0.25)'">
                    <span class="text-lg">+</span> Ajouter un produit
                </a>
            </div>

            {{-- ═══════════════════════════════════════════ --}}
            {{-- SEARCH & FILTERS BAR --}}
            {{-- ═══════════════════════════════════════════ --}}
            @php
                $hasActiveFilters = request('category_id') || request('brand_id') || request('status');
                $filterCount = (request('category_id') ? 1 : 0) + (request('brand_id') ? 1 : 0) + (request('status') ? 1 : 0);
            @endphp

            <form action="{{ route('products.index') }}" method="GET" id="filterForm">
                <div class="rounded-xl p-4 mb-6" style="background:#232136; border:1px solid rgba(255,255,255,0.05);">

                    {{-- Row 1: Search + Filter Button --}}
                    <div class="flex items-center gap-3">
                        {{-- Search Input --}}
                        <div class="flex-1 min-w-[200px]">
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-sm" style="color:#6e6b8a;">🔍</span>
                                <input type="text" name="search"
                                       value="{{ request('search') }}"
                                       placeholder="Chercher par nom ou référence..."
                                       class="w-full pl-9 pr-4 py-2.5 rounded-xl outline-none transition-all text-sm"
                                       style="background:#1a1828; border:1px solid rgba(255,255,255,0.07); color:#fffffe;"
                                       onfocus="this.style.borderColor='#e8c547'; this.style.boxShadow='0 0 0 3px rgba(232,197,71,0.12)'"
                                       onblur="this.style.borderColor='rgba(255,255,255,0.07)'; this.style.boxShadow='none'">
                            </div>
                        </div>

                        {{-- Search Button --}}
                        <button type="submit"
                                class="text-xs font-semibold px-4 py-2.5 rounded-xl transition-all duration-200"
                                style="background:rgba(232,197,71,0.12); color:#e8c547; border:1px solid rgba(232,197,71,0.2);"
                                onmouseover="this.style.background='rgba(232,197,71,0.2)'"
                                onmouseout="this.style.background='rgba(232,197,71,0.12)'">
                            Chercher
                        </button>

                        {{-- ═══ YouTube-style Filter Toggle Button ═══ --}}
                        <button type="button" id="filterToggleBtn"
                                class="relative flex items-center gap-2 py-2.5 px-4 rounded-xl text-xs font-bold transition-all duration-200 cursor-pointer"
                                style="background:{{ $hasActiveFilters ? 'rgba(232,197,71,0.15)' : 'rgba(255,255,255,0.05)' }};
                                       color:{{ $hasActiveFilters ? '#e8c547' : '#a7a4c0' }};
                                       border:1px solid {{ $hasActiveFilters ? 'rgba(232,197,71,0.3)' : 'rgba(255,255,255,0.08)' }};"
                                onclick="toggleFilters()">

                            {{-- Equalizer/Sliders SVG Icon (YouTube-style) --}}
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <line x1="4" y1="6" x2="20" y2="6"></line>
                                <line x1="4" y1="12" x2="20" y2="12"></line>
                                <line x1="4" y1="18" x2="20" y2="18"></line>
                                <circle cx="8" cy="6" r="2" fill="currentColor" stroke="none"></circle>
                                <circle cx="16" cy="12" r="2" fill="currentColor" stroke="none"></circle>
                                <circle cx="10" cy="18" r="2" fill="currentColor" stroke="none"></circle>
                            </svg>

                            <span>Filtres</span>

                            {{-- Badge compteur de filtres actifs --}}
                            @if($filterCount > 0)
                                <span class="absolute -top-1.5 -right-1.5 w-5 h-5 rounded-full flex items-center justify-center text-[10px] font-bold"
                                      style="background:#e8c547; color:#0f0e17; box-shadow: 0 2px 8px rgba(232,197,71,0.4);">
                                    {{ $filterCount }}
                                </span>
                            @endif
                        </button>

                        {{-- Reset Filters --}}
                        @if(request('search') || $hasActiveFilters)
                            <a href="{{ route('products.index') }}"
                               class="text-xs font-semibold px-4 py-2.5 rounded-xl transition-all duration-200"
                               style="background:rgba(239,68,68,0.1); color:#f87171; border:1px solid rgba(239,68,68,0.2);"
                               onmouseover="this.style.background='rgba(239,68,68,0.2)'"
                               onmouseout="this.style.background='rgba(239,68,68,0.1)'">
                                ✕ Réinitialiser
                            </a>
                        @endif
                    </div>

                    {{-- ═══ Collapsible Filter Panel ═══ --}}
                    <div id="filterPanel"
                         class="overflow-hidden transition-all duration-300 ease-in-out"
                         style="max-height:{{ $hasActiveFilters ? '300px' : '0' }}; opacity:{{ $hasActiveFilters ? '1' : '0' }}; margin-top:{{ $hasActiveFilters ? '12px' : '0' }};">

                        <div class="p-4 rounded-xl" style="background:#1a1828; border:1px solid rgba(255,255,255,0.05);">
                            <div class="flex flex-wrap items-center gap-3">

                                {{-- Category Filter --}}
                                <div class="flex flex-col gap-1.5">
                                    <label class="text-[10px] font-bold uppercase tracking-widest" style="color:#6e6b8a;">Catégorie</label>
                                    <select name="category_id"
                                            class="px-3 py-2 rounded-lg text-sm font-medium outline-none cursor-pointer transition-all"
                                            style="background:#232136; border:1px solid rgba(255,255,255,0.07); color:#a7a4c0; min-width:170px;"
                                            onfocus="this.style.borderColor='#e8c547'"
                                            onblur="this.style.borderColor='rgba(255,255,255,0.07)'"
                                            onchange="document.getElementById('filterForm').submit()">
                                        <option value="">📂 Toutes catégories</option>
                                        @foreach($categories as $cat)
                                            <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                                                {{ $cat->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- Brand Filter --}}
                                <div class="flex flex-col gap-1.5">
                                    <label class="text-[10px] font-bold uppercase tracking-widest" style="color:#6e6b8a;">Marque</label>
                                    <select name="brand_id"
                                            class="px-3 py-2 rounded-lg text-sm font-medium outline-none cursor-pointer transition-all"
                                            style="background:#232136; border:1px solid rgba(255,255,255,0.07); color:#a7a4c0; min-width:170px;"
                                            onfocus="this.style.borderColor='#e8c547'"
                                            onblur="this.style.borderColor='rgba(255,255,255,0.07)'"
                                            onchange="document.getElementById('filterForm').submit()">
                                        <option value="">🏷️ Toutes marques</option>
                                        @foreach($brands as $brand)
                                            <option value="{{ $brand->id }}" {{ request('brand_id') == $brand->id ? 'selected' : '' }}>
                                                {{ $brand->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- Status Filter --}}
                                <div class="flex flex-col gap-1.5">
                                    <label class="text-[10px] font-bold uppercase tracking-widest" style="color:#6e6b8a;">Statut</label>
                                    <select name="status"
                                            class="px-3 py-2 rounded-lg text-sm font-medium outline-none cursor-pointer transition-all"
                                            style="background:#232136; border:1px solid rgba(255,255,255,0.07); color:#a7a4c0; min-width:150px;"
                                            onfocus="this.style.borderColor='#e8c547'"
                                            onblur="this.style.borderColor='rgba(255,255,255,0.07)'"
                                            onchange="document.getElementById('filterForm').submit()">
                                        <option value="">🔘 Tout statut</option>
                                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>✅ Actif</option>
                                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>⏸️ Désactivé</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Active Filters Summary --}}
                    @if(request('search') || request('category_id') || request('brand_id') || request('status'))
                        <div class="flex flex-wrap items-center gap-2 mt-3 pt-3" style="border-top:1px solid rgba(255,255,255,0.05);">
                            <span class="text-xs font-medium" style="color:#6e6b8a;">Filtres actifs :</span>
                            @if(request('search'))
                                <span class="text-xs font-semibold px-2.5 py-1 rounded-full" style="background:rgba(232,197,71,0.1); color:#e8c547; border:1px solid rgba(232,197,71,0.15);">
                                    🔍 "{{ request('search') }}"
                                </span>
                            @endif
                            @if(request('category_id'))
                                @php $catName = $categories->find(request('category_id'))->name ?? ''; @endphp
                                <span class="text-xs font-semibold px-2.5 py-1 rounded-full" style="background:rgba(96,165,250,0.1); color:#60a5fa; border:1px solid rgba(96,165,250,0.15);">
                                    📂 {{ $catName }}
                                </span>
                            @endif
                            @if(request('brand_id'))
                                @php $brandName = $brands->find(request('brand_id'))->name ?? ''; @endphp
                                <span class="text-xs font-semibold px-2.5 py-1 rounded-full" style="background:rgba(192,132,252,0.1); color:#c084fc; border:1px solid rgba(192,132,252,0.15);">
                                    🏷️ {{ $brandName }}
                                </span>
                            @endif
                            @if(request('status'))
                                <span class="text-xs font-semibold px-2.5 py-1 rounded-full"
                                      style="background:{{ request('status') == 'active' ? 'rgba(110,231,183,0.1)' : 'rgba(239,68,68,0.1)' }};
                                             color:{{ request('status') == 'active' ? '#6ee7b7' : '#f87171' }};
                                             border:1px solid {{ request('status') == 'active' ? 'rgba(110,231,183,0.15)' : 'rgba(239,68,68,0.15)' }};">
                                    {{ request('status') == 'active' ? '✅ Actif' : '⏸️ Désactivé' }}
                                </span>
                            @endif
                        </div>
                    @endif
                </div>
            </form>

            {{-- ═══════════════════════════════════════════ --}}
            {{-- MESSAGES --}}
            {{-- ═══════════════════════════════════════════ --}}
            @if(session('success'))
                <div class="flex items-start gap-3 p-4 rounded-xl mb-6 text-sm font-medium"
                     style="background:#0d2e1e; border:1px solid rgba(110,231,183,0.2); color:#6ee7b7;">
                    <span class="font-bold text-lg">✓</span>
                    <p class="self-center">{{ session('success') }}</p>
                </div>
            @endif
            @if(session('error'))
                <div class="flex items-start gap-3 p-4 rounded-xl mb-6 text-sm font-medium"
                     style="background:rgba(239,68,68,0.1); border:1px solid rgba(239,68,68,0.2); color:#f87171;">
                    <span class="font-bold text-lg">✕</span>
                    <p class="self-center">{{ session('error') }}</p>
                </div>
            @endif

            {{-- ═══════════════════════════════════════════ --}}
            {{-- BULK ACTION BUTTONS --}}
            {{-- ═══════════════════════════════════════════ --}}
            <div class="flex flex-wrap items-center gap-3 mb-5 p-4 rounded-xl" style="background:#232136; border:1px solid rgba(255,255,255,0.05);">
                <span class="text-xs font-semibold uppercase tracking-wider mr-1" style="color:#6e6b8a;">Actions groupées :</span>

                {{-- Activate --}}
                <button type="submit" form="bulkForm" name="action" value="activate"
                        class="group flex items-center gap-2 text-xs font-bold py-2.5 px-4 rounded-lg transition-all duration-200"
                        style="background:rgba(110,231,183,0.08); color:#6ee7b7; border:1px solid rgba(110,231,183,0.2);"
                        onmouseover="this.style.background='rgba(110,231,183,0.18)'; this.style.transform='translateY(-1px)'; this.style.boxShadow='0 4px 12px rgba(110,231,183,0.15)'"
                        onmouseout="this.style.background='rgba(110,231,183,0.08)'; this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                    <span class="w-5 h-5 rounded-full flex items-center justify-center text-[10px]" style="background:rgba(110,231,183,0.2);">✓</span>
                    Activer
                </button>

                {{-- Deactivate --}}
                <button type="submit" form="bulkForm" name="action" value="deactivate"
                        class="flex items-center gap-2 text-xs font-bold py-2.5 px-4 rounded-lg transition-all duration-200"
                        style="background:rgba(251,191,36,0.08); color:#fbbf24; border:1px solid rgba(251,191,36,0.2);"
                        onmouseover="this.style.background='rgba(251,191,36,0.18)'; this.style.transform='translateY(-1px)'; this.style.boxShadow='0 4px 12px rgba(251,191,36,0.15)'"
                        onmouseout="this.style.background='rgba(251,191,36,0.08)'; this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                    <span class="w-5 h-5 rounded-full flex items-center justify-center text-[10px]" style="background:rgba(251,191,36,0.2);">⏸</span>
                    Désactiver
                </button>

                {{-- Delete --}}
                <button type="submit" form="bulkForm" name="action" value="delete"
                        onclick="return confirm('⚠️ Voulez-vous vraiment supprimer les produits sélectionnés ?')"
                        class="flex items-center gap-2 text-xs font-bold py-2.5 px-4 rounded-lg transition-all duration-200"
                        style="background:rgba(239,68,68,0.08); color:#f87171; border:1px solid rgba(239,68,68,0.2);"
                        onmouseover="this.style.background='rgba(239,68,68,0.18)'; this.style.transform='translateY(-1px)'; this.style.boxShadow='0 4px 12px rgba(239,68,68,0.15)'"
                        onmouseout="this.style.background='rgba(239,68,68,0.08)'; this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                    <span class="w-5 h-5 rounded-full flex items-center justify-center text-[10px]" style="background:rgba(239,68,68,0.2);">✕</span>
                    Supprimer
                </button>

                {{-- Selection Counter --}}
                <span id="selectedCount" class="text-xs font-medium ml-auto" style="color:#6e6b8a;">
                    0 sélectionné(s)
                </span>
            </div>

            {{-- ═══════════════════════════════════════════ --}}
            {{-- TABLE --}}
            {{-- ═══════════════════════════════════════════ --}}
            <div class="overflow-x-auto rounded-xl" style="border:1px solid rgba(255,255,255,0.07);">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr style="background:#232136;">
                            <th class="px-4 py-3">
                                <input type="checkbox" id="selectAll" class="w-4 h-4 cursor-pointer rounded">
                            </th>
                            <th class="px-4 py-4 text-xs font-semibold tracking-widest uppercase" style="color:#a7a4c0; border-bottom:1px solid rgba(255,255,255,0.07);">État</th>
                            <th class="px-4 py-4 text-xs font-semibold tracking-widest uppercase" style="color:#a7a4c0; border-bottom:1px solid rgba(255,255,255,0.07);">Image</th>
                            <th class="px-4 py-4 text-xs font-semibold tracking-widest uppercase" style="color:#a7a4c0; border-bottom:1px solid rgba(255,255,255,0.07);">Référence</th>
                            <th class="px-4 py-4 text-xs font-semibold tracking-widest uppercase" style="color:#a7a4c0; border-bottom:1px solid rgba(255,255,255,0.07);">Produit</th>
                            <th class="px-4 py-4 text-xs font-semibold tracking-widest uppercase" style="color:#a7a4c0; border-bottom:1px solid rgba(255,255,255,0.07);">Catégorie</th>
                            <th class="px-4 py-4 text-xs font-semibold tracking-widest uppercase" style="color:#a7a4c0; border-bottom:1px solid rgba(255,255,255,0.07);">Marque</th>
                            <th class="px-4 py-4 text-xs font-semibold tracking-widest uppercase" style="color:#a7a4c0; border-bottom:1px solid rgba(255,255,255,0.07);">Prix</th>
                            <th class="px-4 py-4 text-xs font-semibold tracking-widest uppercase" style="color:#a7a4c0; border-bottom:1px solid rgba(255,255,255,0.07);">Stock</th>
                            <th class="px-4 py-4 text-xs font-semibold tracking-widest uppercase text-center" style="color:#a7a4c0; border-bottom:1px solid rgba(255,255,255,0.07);">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $index => $product)
                        <tr class="product-row {{ !$product->is_active ? 'row-inactive' : '' }}"
                            style="border-bottom:1px solid rgba(255,255,255,0.05); transition:background 0.15s; animation-delay:{{ $index * 0.04 }}s; position:relative;
                                   {{ !$product->is_active ? 'opacity:0.55;' : '' }}"
                            onmouseover="this.style.background='rgba(232,197,71,0.04)'"
                            onmouseout="this.style.background='transparent'">

                            {{-- Checkbox --}}
                            <td class="px-4 py-3" style="position:relative; z-index:2;">
                                <input type="checkbox" form="bulkForm" name="ids[]" value="{{ $product->id }}" class="row-checkbox w-4 h-4 cursor-pointer rounded">
                            </td>

                            {{-- Status Indicator --}}
                            <td class="px-4 py-4">
                                @if($product->is_active)
                                    <div class="flex items-center gap-2">
                                        <span class="w-2.5 h-2.5 rounded-full flex-shrink-0" style="background:#6ee7b7; box-shadow: 0 0 6px rgba(110,231,183,0.5);"></span>
                                        <span class="text-xs font-bold px-2 py-1 rounded-full"
                                              style="background:rgba(110,231,183,0.1); color:#6ee7b7; border:1px solid rgba(110,231,183,0.2);">
                                            Actif
                                        </span>
                                    </div>
                                @else
                                    <div class="flex items-center gap-2">
                                        <span class="w-2.5 h-2.5 rounded-full flex-shrink-0" style="background:#f87171; box-shadow: 0 0 6px rgba(239,68,68,0.4);"></span>
                                        <span class="text-xs font-bold px-2 py-1 rounded-full"
                                              style="background:rgba(239,68,68,0.1); color:#f87171; border:1px solid rgba(239,68,68,0.2);">
                                            Désactivé
                                        </span>
                                    </div>
                                @endif
                            </td>

                            {{-- Image --}}
                            <td class="px-4 py-4">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}"
                                         alt="{{ $product->name }}"
                                         class="w-11 h-11 object-cover rounded-lg"
                                         style="border:1px solid rgba(255,255,255,0.08); {{ !$product->is_active ? 'filter:grayscale(70%);' : '' }}">
                                @else
                                    <div class="w-11 h-11 rounded-lg flex items-center justify-center text-xs"
                                         style="background:#232136; border:1px solid rgba(255,255,255,0.07); color:#6e6b8a;">—</div>
                                @endif
                            </td>

                            {{-- Référence --}}
                            <td class="px-4 py-4 text-xs font-mono" style="color:#6e6b8a;">{{ $product->reference }}</td>

                            {{-- Nom --}}
                            <td class="px-4 py-4">
                                <span class="font-semibold text-sm" style="color:{{ $product->is_active ? '#fffffe' : '#6e6b8a' }};">
                                    {{ $product->name }}
                                </span>
                                @if(!$product->is_active)
                                    <div class="text-[10px] font-bold mt-1 uppercase tracking-wider" style="color:#f87171;">
                                        ⚠ Produit caché du site
                                    </div>
                                @endif
                            </td>

                            {{-- Catégorie --}}
                            <td class="px-4 py-4 text-sm" style="color:#e8c547;">{{ $product->category->name ?? 'Sans catégorie' }}</td>

                            {{-- Marque --}}
                            <td class="px-4 py-4 text-sm">
                                @if($product->brand)
                                    <span class="text-xs font-semibold px-2.5 py-1 rounded-full"
                                          style="background:rgba(232,197,71,0.1); color:#e8c547; border:1px solid rgba(232,197,71,0.2);">
                                        {{ $product->brand->name }}
                                    </span>
                                @else
                                    <span style="color:#6e6b8a;">—</span>
                                @endif
                            </td>

                            {{-- Prix --}}
                            <td class="px-4 py-4 text-sm">
                                <span class="line-through mr-1" style="color:#6e6b8a;">{{ $product->purchase_price }} DH</span>
                                <span class="font-bold" style="color:#6ee7b7;">{{ $product->selling_price }} DH</span>
                            </td>

                            {{-- Stock --}}
                            <td class="px-4 py-4">
                                @if($product->stock_quantity <= ($product->alert_stock ?? 5))
                                    <span class="text-xs font-semibold px-2.5 py-1 rounded-full"
                                          style="background:rgba(239,68,68,0.12); color:#f87171; border:1px solid rgba(239,68,68,0.2);">
                                        {{ $product->stock_quantity }} — Critique
                                    </span>
                                @else
                                    <span class="text-xs font-semibold px-2.5 py-1 rounded-full"
                                          style="background:rgba(110,231,183,0.1); color:#6ee7b7; border:1px solid rgba(110,231,183,0.2);">
                                        {{ $product->stock_quantity }}
                                    </span>
                                @endif
                            </td>

                            {{-- Actions --}}
                            <td class="px-4 py-4 text-center" style="position:relative; z-index:2;">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('products.edit', $product->id) }}"
                                       class="text-xs font-semibold px-3 py-1.5 rounded-lg transition-all duration-200"
                                       style="background:rgba(99,102,241,0.12); color:#818cf8; border:1px solid rgba(99,102,241,0.2);"
                                       onmouseover="this.style.background='rgba(99,102,241,0.22)'; this.style.color='#a5b4fc'"
                                       onmouseout="this.style.background='rgba(99,102,241,0.12)'; this.style.color='#818cf8'">
                                        ✎ Modifier
                                    </a>
                                    <form action="{{ route('products.destroy', $product->id) }}" method="POST"
                                          class="inline-block"
                                          onsubmit="return confirm('Voulez-vous supprimer ce produit ?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="text-xs font-semibold px-3 py-1.5 rounded-lg transition-all duration-200"
                                                style="background:rgba(239,68,68,0.1); color:#f87171; border:1px solid rgba(239,68,68,0.2);"
                                                onmouseover="this.style.background='rgba(239,68,68,0.2)'; this.style.color='#fca5a5'"
                                                onmouseout="this.style.background='rgba(239,68,68,0.1)'; this.style.color='#f87171'">
                                            ✕ Supprimer
                                        </button>
                                    </form>
                                </div>
                            </td>

                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="mt-6">{{ $products->withQueryString()->links() }}</div>

            {{-- Empty state --}}
            @if($products->isEmpty())
                <div class="text-center py-16">
                    <div class="text-5xl mb-4">📦</div>
                    <p class="font-semibold text-lg" style="color:#a7a4c0;">Aucun produit trouvé</p>
                    <p class="text-sm mt-2" style="color:#6e6b8a;">
                        @if(request('search') || request('category_id') || request('brand_id') || request('status'))
                            Essayez de modifier vos filtres.
                        @else
                            Commencez par en ajouter un !
                        @endif
                    </p>
                </div>
            @endif

        </div>
    </div>

    {{-- ═══════════════════════════════════════════ --}}
    {{-- JAVASCRIPT --}}
    {{-- ═══════════════════════════════════════════ --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const selectAll = document.getElementById('selectAll');
            const checkboxes = document.querySelectorAll('.row-checkbox');
            const countEl = document.getElementById('selectedCount');

            function updateCount() {
                const checked = document.querySelectorAll('.row-checkbox:checked').length;
                countEl.textContent = checked + ' sélectionné(s)';
                countEl.style.color = checked > 0 ? '#e8c547' : '#6e6b8a';
            }

            // Select All
            selectAll.addEventListener('change', function() {
                checkboxes.forEach(cb => cb.checked = selectAll.checked);
                updateCount();
            });

            // Individual checkbox
            checkboxes.forEach(cb => {
                cb.addEventListener('change', function() {
                    if (!this.checked) selectAll.checked = false;
                    if (document.querySelectorAll('.row-checkbox:checked').length === checkboxes.length) {
                        selectAll.checked = true;
                    }
                    updateCount();
                });
            });
        });

        // Toggle Filter Panel
        function toggleFilters() {
            const panel = document.getElementById('filterPanel');
            if (panel.style.maxHeight === '0px' || panel.style.maxHeight === '') {
                panel.style.maxHeight = '300px';
                panel.style.opacity = '1';
                panel.style.marginTop = '12px';
            } else {
                panel.style.maxHeight = '0px';
                panel.style.opacity = '0';
                panel.style.marginTop = '0px';
            }
        }
    </script>
</body>
</html>
