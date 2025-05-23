<header class="navbar bg-white shadow-lg">
    <!-- Partie Mobile -->
    <div class="flex w-full items-center justify-between lg:hidden">
        <!-- Menu Burger (à gauche) -->
        <div class="dropdown">
            <div tabindex="0" role="button" class="btn btn-ghost btn-circle">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
                </svg>
            </div>
            <ul tabindex="0" class="menu menu-sm dropdown-content bg-base-100 rounded-box z-10 mt-3 w-52 p-2 shadow">
                <li><a href="{{ route('home') }}">Accueil</a></li>
                <li><a href="{{ route('offer.index') }}">Offres</a></li>
                <li><a href="{{ route('company.index') }}">Entreprises</a></li>
                <li><a href="{{ route('stats.index') }}">Statistique</a></li>
            </ul>
        </div>

        <!-- Logo (centré en mobile) -->
        <a class="btn btn-ghost text-xl" href="{{ route('home') }}">
            <img src="{{ asset('img/logo/logo.png') }}" class="h-10 w-auto mr-2 rounded" alt="Logo">
            Talentis
        </a>

        @auth
            <!-- Avatar (à droite) -->
            <div class="dropdown dropdown-end">
                <div tabindex="0" role="button" class="btn btn-ghost btn-circle avatar">
                    <div class="w-10 rounded-full">
                        <img src="{{ auth()->user()->profile_picture_path ? Storage::url(auth()->user()->profile_picture_path) : asset('img/1223671392.jpg') }}"
                             alt="Photo de profil"
                             class="w-10 h-10 rounded-full">
                    </div>
                </div>
                @php
                    $isAdmin = auth()->user()->hasRole('admin');
                    $isStudent = auth()->user()->hasRole('student');
                    $isPilot = auth()->user()->hasRole('pilot');
                @endphp
                <ul tabindex="0" class="menu menu-sm dropdown-content bg-white rounded-box z-20 mt-3 w-52 p-2 shadow">
                    <li><a href="{{ route('profil.show') }}" class="text-lg">Profil</a></li>
                    @if($isAdmin || $isStudent)
                        <li><a href="{{ route('apply.index') }}" class="text-lg">Mes candidatures</a></li>
                        <li><a href="{{ route('wishlist.index') }}" class="text-lg">Favori</a></li>
                    @endif

                    @if($isAdmin)
                        <li><a href="{{ route('filament.admin.pages.dashboard') }}" class="text-lg">Tableau de bord</a></li> {{-- Dashboard admin --}}
                    @endif

                    @if($isPilot)
                        <li><a href="{{ route('dashboard.index') }}" class="text-lg">Tableau de bord</a></li> {{-- Dashboard pilot --}}
                    @endif

                    <li><a href="{{ route('logout') }}" class="text-red-500 text-lg">Déconnexion</a></li>
                </ul>
            </div>
        @endauth

        @guest
            <a href="{{ route('login') }}" class="btn btn-primary text-base-100">Connexion</a>
        @endguest
    </div>

    <!-- Partie Desktop -->
    <div class="hidden w-full lg:flex items-center justify-between">
        <!-- Logo (PC) -->
        <a class="btn btn-ghost text-3xl animate-gradient-text font-bold bg-clip-text text-transparent
                        bg-gradient-to-r from-primary via-secondary to-accent" href="{{ route('home') }}">
            <img src="{{ asset('img/logo/logo.png') }}" class="h-8 w-auto mr-2 rounded" alt="Logo">
            Talentis
        </a>

        <!-- Menu (PC) -->
        <div class="navbar">
            <ul class="menu menu-horizontal px-1 ml-5">
                <li><a href="{{ route('home') }}" class="text-2xl">Accueil</a></li>
                <li><a href="{{ route('offer.index') }}" class="text-2xl">Offres</a></li>
                <li><a href="{{ route('company.index') }}" class="text-2xl">Entreprises</a></li>
                <li><a href="{{ route('stats.index') }}" class="text-2xl">Statistique</a></li>
            </ul>
        </div>

        @auth
            <!-- Avatar (PC) -->
            <div class="dropdown dropdown-end">
                <div tabindex="0" role="button" class="btn btn-ghost btn-circle avatar w-20 h-20">
                    <div class="w-16 rounded-full">
                        <img src="{{ auth()->user()->profile_picture_path ? Storage::url(auth()->user()->profile_picture_path) : asset('img/1223671392.jpg') }}"
                             alt="Photo de profil"
                             class="w-10 h-10 rounded-full">
                    </div>
                </div>


                @php
                    $isAdmin = auth()->user()->hasRole('admin');
                    $isStudent = auth()->user()->hasRole('student');
                    $isPilot = auth()->user()->hasRole('pilot');
                @endphp
                <ul tabindex="0" class="menu menu-sm dropdown-content bg-white rounded-box z-20 mt-3 w-52 p-2 shadow">
                    <li><a href="{{ route('profil.show') }}" class="text-lg">Profil</a></li>
                    @if($isAdmin || $isStudent)
                        <li><a href="{{ route('apply.index') }}" class="text-lg">Mes candidatures</a></li>
                        <li><a href="{{ route('wishlist.index') }}" class="text-lg">Favori</a></li>
                    @endif

                    @if($isAdmin)
                        <li><a href="{{ route('filament.admin.pages.dashboard') }}" class="text-lg">Tableau de bord</a></li> {{-- Dashboard admin --}}
                    @endif

                    @if($isPilot)
                        <li><a href="{{ route('dashboard.index') }}" class="text-lg">Tableau de bord</a></li> {{-- Dashboard pilot --}}
                    @endif

                    <li><a href="{{ route('logout') }}" class="text-red-500 text-lg">Déconnexion</a></li>
                </ul>
            </div>
        @endauth

        @guest
            <a href="{{ route('login') }}" class="btn btn-primary text-base-100">Connexion</a>
        @endguest
    </div>
</header>
