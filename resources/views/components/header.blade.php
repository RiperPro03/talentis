<div class="navbar bg-white shadow-lg">
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
                <li><a>Homepage</a></li>
                <li><a>Portfolio</a></li>
                <li><a>About</a></li>
            </ul>
        </div>

        <!-- Logo (centré en mobile) -->
        <a class="btn btn-ghost text-xl" href="#">
            <img src="{{ asset('./img/logo/logo.png') }}" class="h-10 w-auto mr-2 rounded" alt="Logo">
            Talentis
        </a>

        <!-- Avatar (à droite) -->
        <div class="dropdown dropdown-end">
            <div tabindex="0" role="button" class="btn btn-ghost btn-circle avatar">
                <div class="w-10 rounded-full">
                    <img alt="Photo" src="{{ asset('./img/test/photo.png') }}"/>
                </div>
            </div>
            <ul tabindex="0" class="menu menu-sm dropdown-content bg-white rounded-box z-10 mt-3 w-52 p-2 shadow">
                <li>
                    <a class="justify-between">
                        Profile
                        <span class="badge">New</span>
                    </a>
                </li>
                <li><a>Settings</a></li>
                <li><a>Logout</a></li>
            </ul>
        </div>
    </div>

    <!-- Partie Desktop -->
    <div class="hidden w-full lg:flex items-center justify-between">
        <!-- Logo (gauche en PC) -->
        <a class="btn btn-ghost text-xl" href="#">
            <img src="{{ asset('./img/logo/logo.png') }}" class="h-8 w-auto mr-2 rounded-full" alt="Logo">
            Talentis
        </a>

        <!-- Menu (centré en PC) -->
        <div class="navbar-center">
            <ul class="menu menu-horizontal px-1">
                <li><a>Item 1</a></li>
                <li>
                    <details>
                        <summary>Parent</summary>
                        <ul class="p-2">
                            <li><a>Submenu 1</a></li>
                            <li><a>Submenu 2</a></li>
                        </ul>
                    </details>
                </li>
                <li><a>Item 3</a></li>
            </ul>
        </div>

        <!-- Avatar (droite en PC) -->
        <div class="dropdown dropdown-end">
            <div tabindex="0" role="button" class="btn btn-ghost btn-circle avatar">
                <div class="w-10 rounded-full">
                    <img alt="Photo" src="{{ asset('./img/test/photo.png') }}"/>
                </div>
                <div class="avatar avatar-placeholder">
                    <div class="bg-neutral text-neutral-content w-12 rounded-full">
                        <span>SY</span>
                    </div>
                </div>
            </div>
            <ul tabindex="0" class="menu menu-sm dropdown-content bg-white rounded-box z-10 mt-3 w-52 p-2 shadow">
                <li>
                    <a class="justify-between">
                        Profile
                        <span class="badge">New</span>
                    </a>
                </li>
                <li><a>Settings</a></li>
                <li><a>Logout</a></li>
            </ul>
        </div>
    </div>
</div>
