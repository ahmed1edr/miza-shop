<!DOCTYPE html>
<html lang="fr" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier l'Utilisateur - Miza Shop</title>
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
    <div class="max-w-2xl mx-auto p-8">
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
                        Modifier l'utilisateur
                    </h2>
                </div>
                <a href="{{ route('users.index') }}"
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
            <form action="{{ route('users.update', $user->id) }}" method="POST" class="space-y-5">
                @csrf
                @method('PUT')

                {{-- Nom & Email --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold tracking-widest uppercase mb-2"
                               style="color:#a7a4c0;">Nom complet</label>
                        <input type="text" name="name" required value="{{ old('name', $user->name) }}"
                               class="w-full px-4 py-3 rounded-xl outline-none transition-all text-sm"
                               style="background:#232136; border:1px solid rgba(255,255,255,0.07); color:#fffffe;"
                               onfocus="this.style.borderColor='#e8c547'; this.style.background='#27253e'; this.style.boxShadow='0 0 0 3px rgba(232,197,71,0.12)'"
                               onblur="this.style.borderColor='rgba(255,255,255,0.07)'; this.style.background='#232136'; this.style.boxShadow='none'">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold tracking-widest uppercase mb-2"
                               style="color:#a7a4c0;">Adresse Email</label>
                        <input type="email" name="email" required value="{{ old('email', $user->email) }}"
                               class="w-full px-4 py-3 rounded-xl outline-none transition-all text-sm"
                               style="background:#232136; border:1px solid rgba(255,255,255,0.07); color:#fffffe;"
                               onfocus="this.style.borderColor='#e8c547'; this.style.background='#27253e'; this.style.boxShadow='0 0 0 3px rgba(232,197,71,0.12)'"
                               onblur="this.style.borderColor='rgba(255,255,255,0.07)'; this.style.background='#232136'; this.style.boxShadow='none'">
                    </div>
                </div>

                {{-- Mot de passe --}}
                <div>
                    <label class="block text-xs font-semibold tracking-widest uppercase mb-2"
                           style="color:#a7a4c0;">Mot de passe <span style="color:#6e6b8a; font-size:10px;">(laisser vide pour garder l'ancien)</span></label>
                    <input type="password" name="password" placeholder="Nouveau mot de passe (optionnel)"
                           class="w-full px-4 py-3 rounded-xl outline-none transition-all text-sm"
                           style="background:#232136; border:1px solid rgba(255,255,255,0.07); color:#fffffe;"
                           onfocus="this.style.borderColor='#e8c547'; this.style.background='#27253e'; this.style.boxShadow='0 0 0 3px rgba(232,197,71,0.12)'"
                           onblur="this.style.borderColor='rgba(255,255,255,0.07)'; this.style.background='#232136'; this.style.boxShadow='none'">
                </div>

                {{-- Rôle & Famille --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold tracking-widest uppercase mb-2"
                               style="color:#a7a4c0;">Rôle</label>
                        <select name="role" required
                                class="w-full px-4 py-3 rounded-xl outline-none transition-all text-sm"
                                style="background:#232136; border:1px solid rgba(255,255,255,0.07); color:#fffffe;"
                                onfocus="this.style.borderColor='#e8c547'; this.style.background='#27253e'; this.style.boxShadow='0 0 0 3px rgba(232,197,71,0.12)'"
                                onblur="this.style.borderColor='rgba(255,255,255,0.07)'; this.style.background='#232136'; this.style.boxShadow='none'">
                            <option value="employe" {{ old('role', $user->role) == 'employe' ? 'selected' : '' }}>Employé (Gère une famille)</option>
                            <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Administrateur (Accès total)</option>
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
                            <option value="" style="color:#6e6b8a;">-- Toutes / Aucune --</option>
                            @foreach($brands as $brand)
                                <option value="{{ $brand->id }}" {{ old('brand_id', $user->brand_id) == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Submit --}}
                <div style="border-top:1px solid rgba(255,255,255,0.06); padding-top:20px;">
                    <button type="submit"
                            class="w-full py-3 px-4 rounded-xl font-semibold text-sm transition-all duration-200"
                            style="background:#e8c547; color:#0f0e17; box-shadow:0 4px 20px rgba(232,197,71,0.25);"
                            onmouseover="this.style.background='#f0d060'; this.style.transform='translateY(-1px)'; this.style.boxShadow='0 8px 28px rgba(232,197,71,0.35)'"
                            onmouseout="this.style.background='#e8c547'; this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 20px rgba(232,197,71,0.25)'">
                        Enregistrer les modifications
                    </button>
                </div>

            </form>
        </div>
    </div>

</body>
</html>
