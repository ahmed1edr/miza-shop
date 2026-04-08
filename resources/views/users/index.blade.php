<!DOCTYPE html>
<html lang="fr" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Utilisateurs - Miza Shop</title>
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
    <div class="max-w-7xl mx-auto p-4 md:p-8">
        <div class="rounded-2xl p-5 sm:p-8"
             style="background:#1a1828; border:1px solid rgba(255,255,255,0.07); box-shadow: 0 24px 60px rgba(0,0,0,0.5), 0 0 80px rgba(232,197,71,0.04);">

            {{-- Header --}}
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
                <div>
                    <span class="text-xs font-semibold tracking-widest uppercase px-3 py-1 rounded-full mb-3 inline-block"
                          style="background:rgba(232,197,71,0.12); color:#e8c547; border:1px solid rgba(232,197,71,0.2);">
                        Miza Shop — Admin
                    </span>
                    <h2 class="text-3xl font-normal tracking-tight" style="color:#fffffe;">
                        Équipe & Utilisateurs
                    </h2>
                </div>
                <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-4 w-full md:w-auto">
                    <form action="{{ route('users.index') }}" method="GET" class="flex gap-2 w-full">
                        <input type="text" name="search" value="{{ request('search') }}"
                               placeholder="Chercher un utilisateur..."
                               class="w-full sm:w-auto px-4 py-2.5 rounded-xl text-sm outline-none transition-all duration-200"
                               style="background:rgba(255,255,255,0.05); border:1px solid rgba(255,255,255,0.1); color:#fffffe;"
                               onfocus="this.style.borderColor='#e8c547'; this.style.boxShadow='0 0 0 3px rgba(232,197,71,0.12)'"
                               onblur="this.style.borderColor='rgba(255,255,255,0.1)'; this.style.boxShadow='none'">
                        <button type="submit"
                                class="font-semibold px-4 py-2.5 rounded-xl text-sm transition-all duration-200"
                                style="background:rgba(255,255,255,0.1); color:#fffffe; border:1px solid rgba(255,255,255,0.1);"
                                onmouseover="this.style.background='rgba(255,255,255,0.15)'"
                                onmouseout="this.style.background='rgba(255,255,255,0.1)'">
                            🔍
                        </button>
                    </form>
                    <a href="{{ route('users.create') }}"
                       class="font-semibold py-2.5 px-5 rounded-xl text-sm transition-all duration-200 text-center w-full sm:w-auto whitespace-nowrap"
                       style="background:#e8c547; color:#0f0e17; box-shadow:0 4px 20px rgba(232,197,71,0.25);"
                       onmouseover="this.style.background='#f0d060'; this.style.transform='translateY(-1px)'; this.style.boxShadow='0 8px 28px rgba(232,197,71,0.35)'"
                       onmouseout="this.style.background='#e8c547'; this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 20px rgba(232,197,71,0.25)'">
                        + Ajouter un Utilisateur
                    </a>
                </div>
            </div>

            {{-- Success --}}
            @if(session('success'))
                <div class="flex items-start gap-3 p-4 rounded-xl mb-6 text-sm font-medium"
                     style="background:#0d2e1e; border:1px solid rgba(110,231,183,0.2); color:#6ee7b7;">
                    <span class="font-bold">✓</span>
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            {{-- Table --}}
            <form id="bulkForm" action="{{ route('users.bulk') }}" method="POST"> @csrf </form>

            <div class="overflow-x-auto rounded-xl" style="border:1px solid rgba(255,255,255,0.07);">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr style="background:#232136;">
                            <th class="px-5 py-4 text-xs font-semibold tracking-widest uppercase" style="color:#a7a4c0; border-bottom:1px solid rgba(255,255,255,0.07);">ID</th>
                            <th class="px-5 py-4 text-xs font-semibold tracking-widest uppercase" style="color:#a7a4c0; border-bottom:1px solid rgba(255,255,255,0.07);">Nom</th>
                            <th class="px-5 py-4 text-xs font-semibold tracking-widest uppercase" style="color:#a7a4c0; border-bottom:1px solid rgba(255,255,255,0.07);">Email</th>
                            <th class="px-5 py-4 text-xs font-semibold tracking-widest uppercase" style="color:#a7a4c0; border-bottom:1px solid rgba(255,255,255,0.07);">Rôle</th>
                            <th class="px-5 py-4 text-xs font-semibold tracking-widest uppercase" style="color:#a7a4c0; border-bottom:1px solid rgba(255,255,255,0.07);">Famille</th>
                            <th class="px-5 py-4 text-xs font-semibold tracking-widest uppercase text-center" style="color:#a7a4c0; border-bottom:1px solid rgba(255,255,255,0.07);">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr style="border-bottom:1px solid rgba(255,255,255,0.05); transition:background 0.15s;"
                            onmouseover="this.style.background='rgba(232,197,71,0.04)'"
                            onmouseout="this.style.background='transparent'">

                            <td class="px-5 py-4 text-xs font-mono" style="color:#6e6b8a;">{{ $user->id }}</td>
                            <td class="px-5 py-4 font-semibold text-sm" style="color:#fffffe;">{{ $user->name }}</td>
                            <td class="px-5 py-4 text-sm" style="color:#a7a4c0;">{{ $user->email }}</td>

                            <td class="px-5 py-4">
                                @if($user->role === 'admin')
                                    <span class="text-xs font-semibold px-2.5 py-1 rounded-full tracking-wide uppercase"
                                          style="background:rgba(168,85,247,0.12); color:#c084fc; border:1px solid rgba(168,85,247,0.25);">
                                        Admin
                                    </span>
                                @else
                                    <span class="text-xs font-semibold px-2.5 py-1 rounded-full tracking-wide uppercase"
                                          style="background:rgba(99,102,241,0.12); color:#818cf8; border:1px solid rgba(99,102,241,0.2);">
                                        Employé
                                    </span>
                                @endif
                            </td>

                            <td class="px-5 py-4 text-sm">
                                @if($user->brand)
                                    <span class="text-xs font-semibold px-2.5 py-1 rounded-full"
                                          style="background:rgba(232,197,71,0.1); color:#e8c547; border:1px solid rgba(232,197,71,0.2);">
                                        {{ $user->brand->name }}
                                    </span>
                                @else
                                    <span style="color:#6e6b8a; font-size:12px;">Toutes les marques</span>
                                @endif
                            </td>

                            <td class="px-5 py-4 text-center">
                                @if(auth()->id() !== $user->id)
                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST"
                                          class="inline-block"
                                          onsubmit="return confirm('Voulez-vous supprimer cet utilisateur ?');">
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
                                @else
                                    <span class="text-xs italic px-3 py-1.5 rounded-lg"
                                          style="background:rgba(232,197,71,0.06); color:#6e6b8a; border:1px solid rgba(255,255,255,0.05);">
                                        👤 C'est vous
                                    </span>
                                @endif
                            </td>

                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Empty state --}}
            @if($users->isEmpty())
                <div class="text-center py-16">
                    <div class="text-4xl mb-4">👥</div>
                    <p class="font-medium" style="color:#a7a4c0;">Aucun utilisateur trouvé.</p>
                    <p class="text-sm mt-1" style="color:#6e6b8a;">Commencez par en ajouter un !</p>
                </div>
            @endif

        </div>
    </div>

</body>
</html>
