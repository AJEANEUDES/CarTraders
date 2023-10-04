<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        @if (Auth::user()->roles_user == "A03")
        <li class="nav-item">
            <a class="nav-link @if(!isActiveLink(['admin.dashbord'])) collapsed @endif"
                href="{{ route('admin.dashbord') }}">
                <i style="font-size: 16px;" class="bi bi-grid"></i>
                <span style="font-size: 16px;">Tableau de bord</span>
            </a>
        </li>
        @elseif(Auth::user()->roles_user == "G02")
        <li class="nav-item">
            <a class="nav-link @if(!isActiveLink(['gestionnaire.dashbord'])) collapsed @endif"
                href="{{ route('gestionnaire.dashbord') }}">
                <i style="font-size: 16px;" class="bi bi-grid"></i>
                <span style="font-size: 16px;">Tableau de bord</span>
            </a>
        </li>
        @endif

        <li class="nav-heading">MENU PRINCIPAL</li>

        @if (Auth::user()->roles_user == "A03")
        <li class="nav-item">
            <a class="nav-link @if(!isActiveLink(['marques-voitures.get'])) collapsed @endif"
                href="{{ route('marques-voitures.get') }}">
                <i style="font-size: 16px;" class="bx bx-tag"></i>
                <span style="font-size: 16px;">Mes marques</span>
            </a>
        </li><!-- End Profile Page Nav -->
        @elseif(Auth::user()->roles_user == "G02")
        <li class="nav-item">
            <a class="nav-link @if(!isActiveLink(['marques-voitures.get.gestion'])) collapsed @endif"
                href="{{ route('marques-voitures.get.gestion') }}">
                <i style="font-size: 16px;" class="bx bx-tag"></i>
                <span style="font-size: 16px;">Mes marques</span>
            </a>
        </li><!-- End Profile Page Nav -->
        @endif

        @if (Auth::user()->roles_user == "A03")
        <li class="nav-item">
            <a class="nav-link @if(!isActiveLink(['modeles-voitures.get'])) collapsed @endif"
                href="{{ route('modeles-voitures.get') }}">
                <i style="font-size: 16px;" class="bx bx-bus"></i>
                <span style="font-size: 16px;">Mes modeles</span>
            </a>
        </li><!-- End Profile Page Nav -->
        @elseif(Auth::user()->roles_user == "G02")
        <li class="nav-item">
            <a class="nav-link @if(!isActiveLink(['modeles-voitures.get.gestion'])) collapsed @endif"
                href="{{ route('modeles-voitures.get.gestion') }}">
                <i style="font-size: 16px;" class="bx bx-bus"></i>
                <span style="font-size: 16px;">Mes modeles</span>
            </a>
        </li><!-- End Profile Page Nav -->
        @endif

        @if (Auth::user()->roles_user == "A03")
        <li class="nav-item">
            <a class="nav-link @if(!isActiveLink(['voitures.get'])) collapsed @endif"
                href="{{ route('voitures.get') }}">
                <i style="font-size: 16px;" class="bx bx-car"></i>
                <span style="font-size: 16px;">Mes voitures</span>
            </a>
        </li><!-- End Profile Page Nav -->
        @elseif(Auth::user()->roles_user == "G02")
        <li class="nav-item">
            <a class="nav-link @if(!isActiveLink(['voitures.get.gestion'])) collapsed @endif"
                href="{{ route('voitures.get.gestion') }}">
                <i style="font-size: 16px;" class="bx bx-car"></i>
                <span style="font-size: 16px;">Mes voitures</span>
            </a>
        </li><!-- End Profile Page Nav -->
        @endif

        @if (Auth::user()->roles_user == "A03")
        <li class="nav-item">
            <a class="nav-link @if(!isActiveLink(['images-voitures.get'])) collapsed @endif"
                href="{{ route('images-voitures.get') }}">
                <i style="font-size: 16px;" class="bx bxs-image"></i>
                <span style="font-size: 16px;">Mes images</span>
            </a>
        </li><!-- End Profile Page Nav -->
        @elseif(Auth::user()->roles_user == "G02")
        <li class="nav-item">
            <a class="nav-link @if(!isActiveLink(['images-voitures.get.gestion'])) collapsed @endif"
                href="{{ route('images-voitures.get.gestion') }}">
                <i style="font-size: 16px;" class="bx bxs-image"></i>
                <span style="font-size: 16px;">Mes images</span>
            </a>
        </li><!-- End Profile Page Nav -->
        @endif

        @if (Auth::user()->roles_user == "A03")
        <li class="nav-item">
            <a class="nav-link @if(!isActiveLink(['societes.get'])) collapsed @endif"
                href="{{ route('societes.get') }}">
                <i style="font-size: 16px;" class="bx bxs-bank"></i>
                <span style="font-size: 16px;">Mes societes</span>
            </a>
        </li>
        <!-- End Profile Page Nav -->

        <li class="nav-item">
            <a class="nav-link @if(!isActiveLink(['parkings-voitures.get'])) collapsed @endif"
                href="{{ route('parkings-voitures.get') }}">
                <i style="font-size: 16px;" class="bi bi-bookmarks-fill"></i>
                <span style="font-size: 16px;">Mes parcs</span>
            </a>
        </li><!-- End Profile Page Nav -->

        <li class="nav-item">
            <a class="nav-link @if(!isActiveLink(['services-voitures.get'])) collapsed @endif"
                href="{{ route('services-voitures.get') }}">
                <i style="font-size: 16px;" class="bx bxs-diamond"></i>
                <span style="font-size: 16px;">Mes services</span>
            </a>
        </li><!-- End Profile Page Nav -->

        <li class="nav-heading">GESTION DES RESERVATIONS</li>
        <li class="nav-item">
            <a class="nav-link @if(!isActiveLink(['reservations.get'])) collapsed @endif" href="{{ route('reservations.get') }}">
                <i style="font-size: 16px;" class="bx bxs-carousel"></i>
                <span style="font-size: 16px;">Mes reservations</span>
            </a>
        </li><!-- End Profile Page Nav -->
        <li class="nav-item">
            <a class="nav-link @if(!isActiveLink(['factures.get'])) collapsed @endif" href="{{ route('factures.get') }}">
                <i style="font-size: 16px;" class="bx bxs-file-blank"></i>
                <span style="font-size: 16px;">Mes factures</span>
            </a>
        </li><!-- End Profile Page Nav -->

        <li class="nav-heading">GESTION DES UTILISATEURS</li>
        <li class="nav-item">
            <a class="nav-link @if(!isActiveLink(['admins.get'])) collapsed @endif" href="{{ route('admins.get') }}">
                <i style="font-size: 16px;" class="bi bi-person"></i>
                <span style="font-size: 16px;">Administrateurs</span>
            </a>
        </li><!-- End Profile Page Nav -->

        <li class="nav-item">
            <a class="nav-link @if(!isActiveLink(['gestionnaires.get'])) collapsed @endif"
                href="{{ route('gestionnaires.get') }}">
                <i style="font-size: 16px;" class="bi bi-file-person"></i>
                <span style="font-size: 16px;">Gestionnaires</span>
            </a>
        </li><!-- End Profile Page Nav -->

        <li class="nav-item">
            <a class="nav-link @if(!isActiveLink(['clients.get'])) collapsed @endif" href="{{ route('clients.get') }}">
                <i style="font-size: 16px;" class="bi bi-people"></i>
                <span style="font-size: 16px;">Clients</span>
            </a>
        </li><!-- End Profile Page Nav -->

        {{-- <li class="nav-heading">AUTRES MENU</li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="javascript:void(0)">
                <i style="font-size: 16px;" class="bx bx-comment"></i>
                <span style="font-size: 16px;">Temoignages</span>
            </a>
        </li><!-- End Profile Page Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" href="javascript:void(0)">
                <i style="font-size: 16px;" class="bx bx-message"></i>
                <span style="font-size: 16px;">Messages</span>
            </a>
        </li><!-- End Register Page Nav --> --}}
        @endif

    </ul>

</aside>