<div class="nk-header nk-header-fixed is-light">
                    <div class="container-fluid">
                        <div class="nk-header-wrap">
                            <div class="nk-menu-trigger d-xl-none ms-n1">
                                <a href="#" class="nk-nav-toggle nk-quick-nav-icon" data-target="sidebarMenu"><em class="icon ni ni-menu"></em></a>
                            </div>

                            <div class="nk-header-tools">
                                <ul class="nk-quick-nav">

                                    <li class="dropdown user-dropdown">
                                        <a href="#" class="dropdown-toggle me-n1" data-bs-toggle="dropdown">
                                            <div class="user-toggle">
                                                <div class="user-avatar sm">
                                                    <em class="icon ni ni-user-alt"></em>
                                                </div>
                                                <div class="user-info d-none d-xl-block">
                                                    <div class="user-status user-status-unverified">{{ Auth::user()->status }}</div>
                                                    <div class="user-name dropdown-indicator">{{ Auth::user()->firstname.' '.Auth::user()->lastname }}</div>
                                                </div>
                                            </div>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-md dropdown-menu-end">
                                            <div class="dropdown-inner user-card-wrap bg-lighter d-none d-md-block">
                                                <div class="user-card">
                                                    <div class="user-avatar">
                                                        <span>
                                                            {{ strtoupper(substr(Auth::user()->firstname, 0, 1)).strtoupper(substr(Auth::user()->lastname, 0, 1)) }}
                                                        </span>
                                                    </div>
                                                    <div class="user-info">
                                                        <span class="lead-text">{{ Auth::user()->firstname.' '.Auth::user()->lastname }}</span>
                                                        <span class="sub-text">{{ Auth::user()->email }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- <div class="dropdown-inner">
                                                <ul class="link-list">
                                                    <li>
                                                        <a href="html/user-profile-regular.html">
                                                            <em class="icon ni ni-user-alt"></em>
                                                            <span>Mon profile</span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div> --}}
                                            <div class="dropdown-inner">
                                                <ul class="link-list">
                                                    <li>
                                                        <a href="{{route('logout')}}">
                                                            <em class="icon ni ni-signout"></em>
                                                            <span>Se déconnecter</span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div><!-- .nk-header-wrap -->
                    </div><!-- .container-fliud -->
                </div>
