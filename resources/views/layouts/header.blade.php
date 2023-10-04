<!--=============== HEADER ===============-->
<header class="header" id="header">
    <nav class="nav container">
        <a href="{{ route('accueil.get') }}" class="nav__logo">
            <!--<i class="bx bxs-shopping-bags nav__logo-icon">e-commerce</i>-->
            <img src="{{ asset('assets/img/logo-mct.png') }}" alt="" class="nav__logo-mct">
        </a>

        <div class="nav__menu" id="nav-menu">
            <ul class="nav__list">
                <li class="nav__item">
                    <a href="{{ route('accueil.get') }}"
                        class="nav__link @if(isActiveLink(['accueil.get'])) active-link @endif">Accueil</a>
                </li>
                <li class="nav__item">
                    <a href="{{ route('acheter.voiture.get') }}"
                        class="nav__link @if(isActiveLink(['acheter.voiture.get'])) active-link @endif">Acheter une
                        voiture</a>
                </li>
                <li class="nav__item">
                    <a href="{{ route('contactez.nous.get') }}"
                        class="nav__link @if(isActiveLink(['contactez.nous.get'])) active-link @endif">Contactez-nous</a>
                </li>
                <li class="nav__item">
                    <a href="{{ route('inscription.view') }}"
                        class="nav__link @if(isActiveLink(['inscription.view'])) active-link @endif">Inscription</a>
                </li>
                <li class="nav__item">
                    <a href="{{ route('about.get') }}"
                        class="nav__link @if(isActiveLink(['about.get'])) active-link @endif">A propos</a>
                </li>
                @if (Auth::check() && Auth::user()->roles_user == "C01")
                <li class="nav__item">
                    <a href="{{ route('utilisateur.dashbord') }}"
                        class="nav__link @if(isActiveLink(['utilisateur.dashbord']) || isActiveLink(['utilisateur.profile']) || isActiveLink(['utilisateur.mdp'])) active-link @endif">Voir mon
                        compte</a>
                </li>
                @endif
            </ul>

            <div class="nav__close" id="nav-close">
                <i class="bx bx-x"></i>
            </div>
        </div>
        @guest
        <div class="nav__btns">
            <div class="login__toggle">
                <a style="color: #fff;" href="{{ route('login') }}"
                    class="nav__link button__login @if(isActiveLink(['login'])) active-link @endif">
                    <i style="font-size: 20px;" class="bx bx-user"></i> Se connecter
                </a>
            </div>
            <div class="nav__toggle" id="nav-toggle">
                <i class="bx bx-grid-alt"></i>
            </div>
        </div>
        @endguest
        @if (Auth::check())
        {{-- <div class="login__toggle">
            <a style="color: #fff;" href="{{ route('login') }}"
                class="nav__link button__login @if(isActiveLink(['login'])) active-link @endif">
                <i style="font-size: 20px;" class="bx bx-door-open"></i> Se deconnecter
            </a>
        </div> --}}
        <div class="login__toggle">
            <a class="dropdown-item d-flex align-items-center button__login" href="{{ route('logout') }}" onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
                <span style="font-size: 20px;"><i class="bx bx-door-open"></i> Se deconnecter</span>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </div>
        @endif
    </nav>
</header>