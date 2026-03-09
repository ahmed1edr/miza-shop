<!DOCTYPE html>
<html lang="fr" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un produit - Miza Shop</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'DM Sans', sans-serif; }
        h2   { font-family: 'DM Serif Display', serif; }
        select option { background: #232136; color: #fffffe; }
    </style>
</head>
<body class="min-h-screen antialiased flex items-center justify-center p-8"
      style="background:#0f0e17; background-image: radial-gradient(ellipse 80% 50% at 50% -10%, rgba(232,197,71,0.08) 0%, transparent 70%);">

    <div class="w-full max-w-3xl rounded-2xl p-8"
         style="background:#1a1828; border:1px solid rgba(255,255,255,0.07); box-shadow: 0 24px 60px rgba(0,0,0,0.5), 0 0 80px rgba(232,197,71,0.04);">

        {{-- Header --}}
        <div class="flex items-center justify-between mb-8">
            <div>
                <span class="text-xs font-semibold tracking-widest uppercase px-3 py-1 rounded-full mb-3 inline-block"
                      style="background:rgba(232,197,71,0.12); color:#e8c547; border:1px solid rgba(232,197,71,0.2);">
                    Miza Shop — Admin
                </span>
                <h2 class="text-3xl font-normal tracking-tight" style="color:#fffffe;">
                    Ajouter un nouveau produit
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

        {{-- Success --}}
        @if(session('success'))
            <div class="flex items-start gap-3 p-4 rounded-xl mb-6 text-sm font-medium"
                 style="background:#0d2e1e; border:1px solid rgba(110,231,183,0.2); color:#6ee7b7;">
                <span class="font-bold">✓</span>
                <p>{{ session('success') }}</p>
            </div>
        @endif

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
        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf

            {{-- Catégorie + Référence --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold tracking-widest uppercase mb-2"
                           style="color:#a7a4c0;">Catégorie</label>
                    <select name="category_id" required
                            class="w-full px-4 py-3 rounded-xl outline-none transition-all text-sm"
                            style="background:#232136; border:1px solid rgba(255,255,255,0.07); color:#fffffe;"
                            onfocus="this.style.borderColor='#e8c547'; this.style.background='#27253e'; this.style.boxShadow='0 0 0 3px rgba(232,197,71,0.12)'"
                            onblur="this.style.borderColor='rgba(255,255,255,0.07)'; this.style.background='#232136'; this.style.boxShadow='none'">
                        <option value="" disabled selected style="color:#6e6b8a;">-- Choisissez --</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold tracking-widest uppercase mb-2"
                           style="color:#a7a4c0;">Référence</label>
                    <input type="text" name="reference" required
                           placeholder="ex : REF-001"
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
                <input type="text" name="name" required
                       placeholder="ex : Samsung Galaxy S24"
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
                    <input type="number" step="0.01" name="purchase_price" required
                           placeholder="0.00"
                           class="w-full px-4 py-3 rounded-xl outline-none transition-all text-sm"
                           style="background:#232136; border:1px solid rgba(255,255,255,0.07); color:#fffffe;"
                           onfocus="this.style.borderColor='#e8c547'; this.style.background='#27253e'; this.style.boxShadow='0 0 0 3px rgba(232,197,71,0.12)'"
                           onblur="this.style.borderColor='rgba(255,255,255,0.07)'; this.style.background='#232136'; this.style.boxShadow='none'">
                </div>
                <div>
                    <label class="block text-xs font-semibold tracking-widest uppercase mb-2"
                           style="color:#a7a4c0;">Prix de vente (MAD)</label>
                    <input type="number" step="0.01" name="selling_price" required
                           placeholder="0.00"
                           class="w-full px-4 py-3 rounded-xl outline-none transition-all text-sm"
                           style="background:#232136; border:1px solid rgba(255,255,255,0.07); color:#fffffe;"
                           onfocus="this.style.borderColor='#e8c547'; this.style.background='#27253e'; this.style.boxShadow='0 0 0 3px rgba(232,197,71,0.12)'"
                           onblur="this.style.borderColor='rgba(255,255,255,0.07)'; this.style.background='#232136'; this.style.boxShadow='none'">
                </div>
                <div>
                    <label class="block text-xs font-semibold tracking-widest uppercase mb-2"
                           style="color:#a7a4c0;">Stock (Qté)</label>
                    <input type="number" name="stock_quantity" required
                           placeholder="0"
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
                          placeholder="Décrivez le produit..."
                          class="w-full px-4 py-3 rounded-xl outline-none transition-all text-sm resize-none"
                          style="background:#232136; border:1px solid rgba(255,255,255,0.07); color:#fffffe;"
                          onfocus="this.style.borderColor='#e8c547'; this.style.background='#27253e'; this.style.boxShadow='0 0 0 3px rgba(232,197,71,0.12)'"
                          onblur="this.style.borderColor='rgba(255,255,255,0.07)'; this.style.background='#232136'; this.style.boxShadow='none'"></textarea>
            </div>

            {{-- Image --}}
            <div>
                <label class="block text-xs font-semibold tracking-widest uppercase mb-2"
                       style="color:#a7a4c0;">Image du produit</label>
                <input type="file" name="image" accept="image/*"
                       class="w-full px-4 py-3 rounded-xl text-sm transition-all cursor-pointer"
                       style="background:#232136; border:1px solid rgba(255,255,255,0.07); color:#a7a4c0;"
                       onchange="this.style.borderColor='#e8c547'"
                       onblur="this.style.borderColor='rgba(255,255,255,0.07)'">
            </div>

            {{-- Submit --}}
            <div style="border-top:1px solid rgba(255,255,255,0.06); padding-top:20px;">
                <button type="submit"
                        class="w-full py-3 px-4 rounded-xl font-semibold text-sm transition-all duration-200"
                        style="background:#e8c547; color:#0f0e17; box-shadow:0 4px 20px rgba(232,197,71,0.25);"
                        onmouseover="this.style.background='#f0d060'; this.style.transform='translateY(-1px)'; this.style.boxShadow='0 8px 28px rgba(232,197,71,0.35)'"
                        onmouseout="this.style.background='#e8c547'; this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 20px rgba(232,197,71,0.25)'">
                    Enregistrer le produit
                </button>
            </div>

        </form>
    </div>
</body>
</html>
