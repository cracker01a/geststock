
<div class="nk-sidebar nk-sidebar-fixed is-light " data-content="sidebarMenu">

    <div class="nk-sidebar-element nk-sidebar-head">
        <div class="nk-menu-trigger me-n2">
            <a href="#" class="nk-nav-toggle nk-quick-nav-icon d-xl-none" data-target="sidebarMenu"><em class="icon ni ni-arrow-left"></em></a>
            <a href="#" class="nk-nav-compact nk-quick-nav-icon d-none d-xl-inline-flex" data-target="sidebarMenu"><em class="icon ni ni-menu"></em></a>
        </div>
    </div>

    <div class="nk-sidebar-element">
        <div class="nk-sidebar-content">
            <div class="nk-sidebar-menu" data-simplebar>
                <ul class="nk-menu">

                    <li class="nk-menu-heading">
                        <h6 class="overline-title text-primary-alt">Applications</h6>
                    </li>

                    {{-- DASHBOARD --}}
                    <li class="nk-menu-item">
                        <a href="{{ route('dashboard') }}" class="nk-menu-link">
                            <span class="nk-menu-icon"><em class="icon ni ni-dashboard"></em></span>
                            <span class="nk-menu-text">Tableau de bord</span>
                        </a>
                    </li>

                    {{-- PRODUITS --}}
                    <li class="nk-menu-item has-sub">
                        <a href="#" class="nk-menu-link nk-menu-toggle">
                            <span class="nk-menu-icon"><em class="icon ni ni-card-view"></em></span>
                            <span class="nk-menu-text">Products</span>
                        </a>
                        <ul class="nk-menu-sub">
                            <li class="nk-menu-item">
                                <a href="{{ route('product.index') }}"
                                    class="nk-menu-link">
                                    <span class="nk-menu-text"> Liste </span>
                                </a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="{{ route('product.create') }}"
                                    class="nk-menu-link">
                                    <span class="nk-menu-text"> Ajouter </span>
                                </a>
                            </li>
                        </ul>
                    </li>

                    {{-- SITES --}}
                    <li class="nk-menu-item has-sub">
                        <a href="#" class="nk-menu-link nk-menu-toggle">
                            <span class="nk-menu-icon"><em class="icon ni ni-home"></em></span>
                            <span class="nk-menu-text">Gestion de site</span>
                        </a>
                        <ul class="nk-menu-sub">
                            <li class="nk-menu-item">
                                <a href="{{ route('site.index') }}" class="nk-menu-link">
                                    <span class="nk-menu-text">Liste</span>
                                </a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="{{ route('site.create') }}" class="nk-menu-link">
                                    <span class="nk-menu-text">Ajouter</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                    {{-- ACHAT --}}
                    <li class="nk-menu-item has-sub">
                        <a href="#" class="nk-menu-link nk-menu-toggle">
                            <span class="nk-menu-icon"><em class="icon ni ni-cart"></em></span>
                            <span class="nk-menu-text">Achats</span>
                        </a>
                        <ul class="nk-menu-sub">
                            <li class="nk-menu-item">
                                <a href="{{ route('achat.index') }}" class="nk-menu-link"><span class="nk-menu-text">Liste</span></a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="{{ route('achat.create') }}" class="nk-menu-link"><span class="nk-menu-text">Ajout</span></a>
                            </li>
                        </ul>
                    </li>

                    {{-- VENTES --}}
                    <li class="nk-menu-item has-sub">
                        <a href="#" class="nk-menu-link nk-menu-toggle">
                            <span class="nk-menu-icon"><em class="icon ni ni-list-check"></em></span>
                            <span class="nk-menu-text">Ventes</span>
                        </a>
                        <ul class="nk-menu-sub">
                            <li class="nk-menu-item">
                                <a href="{{ route('ventes.index') }}" class="nk-menu-link"><span class="nk-menu-text">Liste</span></a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="{{ route('ventes.create') }}" class="nk-menu-link"><span class="nk-menu-text">Ajout</span></a>
                            </li>
                        </ul>
                    </li>

                    {{-- UTILISATEURS --}}
                    <li class="nk-menu-item has-sub">
                        <a href="#" class="nk-menu-link nk-menu-toggle">
                            <span class="nk-menu-icon"><em class="icon ni ni-users-fill"></em></span>
                            <span class="nk-menu-text">Utilisateurs</span>
                        </a>
                        <ul class="nk-menu-sub">
                            <li class="nk-menu-item">
                                <a href="{{ route('users.index') }}" class="nk-menu-link">
                                    <span class="nk-menu-text">Liste</span>
                                </a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="{{ route('users.create') }}" class="nk-menu-link">
                                    <span class="nk-menu-text">Ajouter</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nk-menu-item">
                        <a href="html/pricing-table.html" class="nk-menu-link">
                            <span class="nk-menu-icon"><em class="icon ni ni-bar-chart-alt"></em></span>
                            <span class="nk-menu-text">Statistiques</span>
                        </a>
                    </li>

                </ul>

            </div>
        </div>

    </div>

</div>
