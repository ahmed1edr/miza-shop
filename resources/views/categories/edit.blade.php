<!DOCTYPE html>
<html lang="fr" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier une catégorie - Miza Shop</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'DM Sans', sans-serif; }
        h2   { font-family: 'DM Serif Display', serif; }
    </style>
</head>
<body class="min-h-screen antialiased"
      style="background:#0f0e17; background-image: radial-gradient(ellipse 80% 50% at 50% -10%, rgba(232,197,71,0.08) 0%, transparent 70%);">

    {{-- Navbar --}}
    @include('layouts.navbar')

    {{-- Contenu --}}
    <div class="max-w-md mx-auto p-8">
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
                        Modifier la catégorie
                    </h2>
                </div>
                <a href="{{ route('categories.index') }}"
                   class="text-sm font-medium transition-all duration-200"
                   style="color:#a7a4c0;"
                   onmouseover="this.style.color='#e8c547'"
                   onmouseout="this.style.color='#a7a4c0'">
                    &larr; Retour
                </a>
            </div>

            {{-- Error alert --}}
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
            <form action="{{ route('categories.update', $category->id) }}" method="POST" class="space-y-5">
                @csrf
                @method('PUT')

                <div>
                    <label for="name" class="block text-xs font-semibold tracking-widest uppercase mb-2"
                           style="color:#a7a4c0;">Nom de la catégorie</label>
                    <input type="text" name="name" id="name"
                           value="{{ old('name', $category->name) }}" required
                           class="w-full px-4 py-3 rounded-xl outline-none transition-all text-sm"
                           style="background:#232136; border:1px solid rgba(255,255,255,0.07); color:#fffffe;"
                           onfocus="this.style.borderColor='#e8c547'; this.style.background='#27253e'; this.style.boxShadow='0 0 0 3px rgba(232,197,71,0.12)'"
                           onblur="this.style.borderColor='rgba(255,255,255,0.07)'; this.style.background='#232136'; this.style.boxShadow='none'">
                </div>

                <div>
                    <label for="slug" class="block text-xs font-semibold tracking-widest uppercase mb-2"
                           style="color:#a7a4c0;">Slug / Lien court</label>
                    <input type="text" name="slug" id="slug"
                           value="{{ old('slug', $category->slug) }}" required
                           class="w-full px-4 py-3 rounded-xl outline-none transition-all text-sm font-mono"
                           style="background:#232136; border:1px solid rgba(255,255,255,0.07); color:#fffffe;"
                           onfocus="this.style.borderColor='#e8c547'; this.style.background='#27253e'; this.style.boxShadow='0 0 0 3px rgba(232,197,71,0.12)'"
                           onblur="this.style.borderColor='rgba(255,255,255,0.07)'; this.style.background='#232136'; this.style.boxShadow='none'">
                </div>

                <div style="border-top:1px solid rgba(255,255,255,0.06); padding-top:20px;">
                    <button type="submit"
                            class="w-full py-3 px-4 rounded-xl font-semibold text-sm transition-all duration-200"
                            style="background:rgba(99,102,241,0.15); color:#818cf8; border:1px solid rgba(99,102,241,0.25); box-shadow:0 4px 20px rgba(99,102,241,0.1);"
                            onmouseover="this.style.background='rgba(99,102,241,0.28)'; this.style.transform='translateY(-1px)'; this.style.boxShadow='0 8px 28px rgba(99,102,241,0.25)'"
                            onmouseout="this.style.background='rgba(99,102,241,0.15)'; this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 20px rgba(99,102,241,0.1)'">
                        ✎ Mettre à jour la catégorie
                    </button>
                </div>
            </form>

        </div>
    </div>

</body>
</html>
