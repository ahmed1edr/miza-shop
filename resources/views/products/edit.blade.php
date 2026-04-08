<!DOCTYPE html>
<html lang="fr" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier le produit - Miza Shop</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'DM Sans', sans-serif; }
        h2   { font-family: 'DM Serif Display', serif; }
        select option { background: #232136; color: #fffffe; }
    </style>
</head>
<body class="min-h-screen antialiased"
      style="background:#0f0e17; background-image: radial-gradient(ellipse 80% 50% at 50% -10%, rgba(232,197,71,0.08) 0%, transparent 70%);">

    {{-- Navbar --}}
    @include('layouts.navbar')

    {{-- Contenu --}}
    <div class="max-w-3xl mx-auto p-8">
        <div class="rounded-2xl p-8"
             style="background:#1a1828; border:1px solid rgba(255,255,255,0.07); box-shadow: 0 24px 60px rgba(0,0,0,0.5), 0 0 80px rgba(232,197,71,0.04);">

            {{-- Header --}}
            <div class="flex items-center justify-between mb-8">
                <div>
                    <span class="text-xs font-semibold tracking-widest uppercase px-3 py-1 rounded-full mb-3 inline-block"
                          style="background:rgba(232,197,71,0.12); color:#e8c547; border:1px solid rgba(232,197,71,0.2);">
                        Miza Shop — Admin
                    </span>
                    <h2 class="text-3xl font-normal tracking-tight" style="color:#fffffe;">
                        Modifier le produit
                        <span style="color:#e8c547;">: {{ $product->name }}</span>
                    </h2>
                </div>
                <a href="{{ route('products.index') }}"
                   class="text-sm font-medium transition-all duration-200"
                   style="color:#a7a4c0;"
                   onmouseover="this.style.color='#e8c547'"
                   onmouseout="this.style.color='#a7a4c0'">
                    &larr; Retour
                </a>
            </div>

            {{-- Errors --}}
            @if($errors->any())
                <div class="p-4 rounded-xl mb-6 text-sm"
                     style="background:#2d1515; border:1px solid rgba(252,165,165,0.15); color:#fca5a5;">
                    <p class="font-semibold mb-2">Erreur</p>
                    <ul style="list-style:none; padding:0;" class="space-y-1">
                        @foreach($errors->all() as $error)
                            <li>· {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Form --}}
            <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                @csrf
                @method('PUT')

                {{-- Catégorie + Famille + Référence --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-semibold tracking-widest uppercase mb-2"
                               style="color:#a7a4c0;">Catégorie</label>
                        <select name="category_id" required
                                class="w-full px-4 py-3 rounded-xl outline-none transition-all text-sm"
                                style="background:#232136; border:1px solid rgba(255,255,255,0.07); color:#fffffe;"
                                onfocus="this.style.borderColor='#e8c547'; this.style.background='#27253e'; this.style.boxShadow='0 0 0 3px rgba(232,197,71,0.12)'"
                                onblur="this.style.borderColor='rgba(255,255,255,0.07)'; this.style.background='#232136'; this.style.boxShadow='none'">
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold tracking-widest uppercase mb-2"
                               style="color:#a7a4c0;">Famille <span style="color:#6e6b8a; font-size:10px;">(optionnel)</span></label>
                        <select name="brand_id"
                                class="w-full px-4 py-3 rounded-xl outline-none transition-all text-sm"
                                style="background:#232136; border:1px solid rgba(255,255,255,0.07); color:#fffffe;"
                                onfocus="this.style.borderColor='#e8c547'; this.style.background='#27253e'; this.style.boxShadow='0 0 0 3px rgba(232,197,71,0.12)'"
                                onblur="this.style.borderColor='rgba(255,255,255,0.07)'; this.style.background='#232136'; this.style.boxShadow='none'">
                            <option value="" style="color:#6e6b8a;">-- Sans famille --</option>
                            @foreach($brands as $brand)
                                <option value="{{ $brand->id }}" {{ $product->brand_id == $brand->id ? 'selected' : '' }}>
                                    {{ $brand->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold tracking-widest uppercase mb-2"
                               style="color:#a7a4c0;">Référence</label>
                        <input type="text" name="reference"
                               value="{{ old('reference', $product->reference) }}" required
                               class="w-full px-4 py-3 rounded-xl outline-none transition-all text-sm font-mono"
                               style="background:#232136; border:1px solid rgba(255,255,255,0.07); color:#fffffe;"
                               onfocus="this.style.borderColor='#e8c547'; this.style.background='#27253e'; this.style.boxShadow='0 0 0 3px rgba(232,197,71,0.12)'"
                               onblur="this.style.borderColor='rgba(255,255,255,0.07)'; this.style.background='#232136'; this.style.boxShadow='none'">
                    </div>
                </div>

                {{-- Nom --}}
                <div>
                    <label class="block text-xs font-semibold tracking-widest uppercase mb-2"
                           style="color:#a7a4c0;">Nom du produit</label>
                    <input type="text" name="name"
                           value="{{ old('name', $product->name) }}" required
                           class="w-full px-4 py-3 rounded-xl outline-none transition-all text-sm"
                           style="background:#232136; border:1px solid rgba(255,255,255,0.07); color:#fffffe;"
                           onfocus="this.style.borderColor='#e8c547'; this.style.background='#27253e'; this.style.boxShadow='0 0 0 3px rgba(232,197,71,0.12)'"
                           onblur="this.style.borderColor='rgba(255,255,255,0.07)'; this.style.background='#232136'; this.style.boxShadow='none'">
                </div>

                {{-- Prix achat + Prix vente + Stock --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-semibold tracking-widest uppercase mb-2"
                               style="color:#a7a4c0;">Prix d'achat (MAD)</label>
                        <input type="number" step="0.01" name="purchase_price"
                               value="{{ old('purchase_price', $product->purchase_price) }}" required
                               class="w-full px-4 py-3 rounded-xl outline-none transition-all text-sm"
                               style="background:#232136; border:1px solid rgba(255,255,255,0.07); color:#fffffe;"
                               onfocus="this.style.borderColor='#e8c547'; this.style.background='#27253e'; this.style.boxShadow='0 0 0 3px rgba(232,197,71,0.12)'"
                               onblur="this.style.borderColor='rgba(255,255,255,0.07)'; this.style.background='#232136'; this.style.boxShadow='none'">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold tracking-widest uppercase mb-2"
                               style="color:#a7a4c0;">Prix de vente (MAD)</label>
                        <input type="number" step="0.01" name="selling_price"
                               value="{{ old('selling_price', $product->selling_price) }}" required
                               class="w-full px-4 py-3 rounded-xl outline-none transition-all text-sm"
                               style="background:#232136; border:1px solid rgba(255,255,255,0.07); color:#fffffe;"
                               onfocus="this.style.borderColor='#e8c547'; this.style.background='#27253e'; this.style.boxShadow='0 0 0 3px rgba(232,197,71,0.12)'"
                               onblur="this.style.borderColor='rgba(255,255,255,0.07)'; this.style.background='#232136'; this.style.boxShadow='none'">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold tracking-widest uppercase mb-2"
                               style="color:#a7a4c0;">Stock (Qté)</label>
                        <input type="number" name="stock_quantity"
                               value="{{ old('stock_quantity', $product->stock_quantity) }}" required
                               class="w-full px-4 py-3 rounded-xl outline-none transition-all text-sm"
                               style="background:#232136; border:1px solid rgba(255,255,255,0.07); color:#fffffe;"
                               onfocus="this.style.borderColor='#e8c547'; this.style.background='#27253e'; this.style.boxShadow='0 0 0 3px rgba(232,197,71,0.12)'"
                               onblur="this.style.borderColor='rgba(255,255,255,0.07)'; this.style.background='#232136'; this.style.boxShadow='none'">
                    </div>
                </div>

                {{-- Description --}}
                <div>
                    <label class="block text-xs font-semibold tracking-widest uppercase mb-2"
                           style="color:#a7a4c0;">Description <span style="color:#6e6b8a; font-size:10px;">(optionnel)</span></label>
                    <textarea name="description" rows="3"
                              class="w-full px-4 py-3 rounded-xl outline-none transition-all text-sm resize-none"
                              style="background:#232136; border:1px solid rgba(255,255,255,0.07); color:#fffffe;"
                              onfocus="this.style.borderColor='#e8c547'; this.style.background='#27253e'; this.style.boxShadow='0 0 0 3px rgba(232,197,71,0.12)'"
                              onblur="this.style.borderColor='rgba(255,255,255,0.07)'; this.style.background='#232136'; this.style.boxShadow='none'">{{ old('description', $product->description) }}</textarea>
                </div>

                {{-- Image --}}
                <div>
                    <label class="block text-xs font-semibold tracking-widest uppercase mb-2"
                           style="color:#a7a4c0;">Image du produit <span style="color:#6e6b8a; font-size:10px;">(optionnel)</span></label>
                    @if($product->image)
                        <div class="flex items-center gap-4 mb-3 p-3 rounded-xl"
                             style="background:#232136; border:1px solid rgba(255,255,255,0.07);">
                            <img src="{{ asset('storage/' . $product->image) }}"
                                 alt="Image actuelle"
                                 class="w-14 h-14 object-cover rounded-lg"
                                 style="border:1px solid rgba(255,255,255,0.1);">
                            <div>
                                <p class="text-xs font-semibold" style="color:#a7a4c0;">Image actuelle</p>
                                <p class="text-xs mt-0.5" style="color:#6e6b8a;">Uploadez une nouvelle image pour la remplacer</p>
                            </div>
                        </div>
                    @endif
                    <input type="file" name="image" accept="image/*"
                           class="w-full px-4 py-3 rounded-xl text-sm transition-all cursor-pointer"
                           style="background:#232136; border:1px solid rgba(255,255,255,0.07); color:#a7a4c0;"
                           onchange="this.style.borderColor='#e8c547'"
                           onblur="this.style.borderColor='rgba(255,255,255,0.07)'">
                </div>

                {{-- Images supplémentaires existantes --}}
                @if($product->images->count())
                <div>
                    <label class="block text-xs font-semibold tracking-widest uppercase mb-2"
                           style="color:#a7a4c0;">Images supplémentaires actuelles</label>
                    <div class="flex flex-wrap gap-3 p-3 rounded-xl"
                         style="background:#232136; border:1px solid rgba(255,255,255,0.07);">
                        @foreach($product->images as $img)
                            <div class="relative group">
                                <img src="{{ asset('storage/' . $img->image_path) }}"
                                     class="w-16 h-16 object-cover rounded-lg"
                                     style="border:1px solid rgba(255,255,255,0.1);">
                                <label class="absolute -top-1 -right-1 w-5 h-5 rounded-full flex items-center justify-center text-xs cursor-pointer transition-all"
                                       style="background:rgba(239,68,68,0.9); color:white;"
                                       title="Supprimer cette image">
                                    <input type="checkbox" name="delete_images[]" value="{{ $img->id }}" class="hidden">
                                    ✕
                                </label>
                            </div>
                        @endforeach
                    </div>
                    <p class="text-xs mt-1" style="color:#6e6b8a;">Cliquez sur ✕ pour marquer les images à supprimer</p>
                </div>
                @endif

                {{-- Ajouter d'autres images --}}
                <div>
                    <label class="block text-xs font-semibold tracking-widest uppercase mb-2"
                           style="color:#a7a4c0;">Ajouter d'autres images <span style="color:#6e6b8a; font-size:10px;">(optionnel)</span></label>
                    <input type="file" name="gallery[]" multiple accept="image/*"
                           class="w-full px-4 py-3 rounded-xl text-sm transition-all cursor-pointer"
                           style="background:#232136; border:1px solid rgba(255,255,255,0.07); color:#a7a4c0;"
                           onchange="this.style.borderColor='#e8c547'"
                           onblur="this.style.borderColor='rgba(255,255,255,0.07)'">
                </div>

                {{-- Submit --}}
                <div style="border-top:1px solid rgba(255,255,255,0.06); padding-top:20px;">
                    <button type="submit"
                            class="w-full py-3 px-4 rounded-xl font-semibold text-sm transition-all duration-200"
                            style="background:rgba(99,102,241,0.15); color:#818cf8; border:1px solid rgba(99,102,241,0.25); box-shadow:0 4px 20px rgba(99,102,241,0.1);"
                            onmouseover="this.style.background='rgba(99,102,241,0.28)'; this.style.transform='translateY(-1px)'; this.style.boxShadow='0 8px 28px rgba(99,102,241,0.25)'"
                            onmouseout="this.style.background='rgba(99,102,241,0.15)'; this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 20px rgba(99,102,241,0.1)'">
                        ✎ Mettre à jour le produit
                    </button>
                </div>

            </form>
        </div>
    </div>

</body>
</html>
