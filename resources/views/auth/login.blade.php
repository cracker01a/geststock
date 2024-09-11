<!DOCTYPE html>
<html lang="fr" class="js">

<head>
    <base href="../../../">
    <meta charset="utf-8">
    <meta name="author" content="Softnio">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="A powerful and conceptual apps base dashboard template that especially build for developers and programmers.">
    <!-- Fav Icon  -->
    {{-- <link rel="shortcut icon" href="./images/favicon.png"> --}}
    <!-- Page Title  -->
    <title>Connexion</title>
    <!-- StyleSheets  -->
    <link rel="stylesheet" href="./assets/css/dashlite.css?ver=3.2.3">
    <link id="skin-default" rel="stylesheet" href="./assets/css/theme.css?ver=3.2.3">
</head>

<body class="nk-body bg-white npc-default pg-auth">
    <div class="nk-app-root">
        <!-- main @s -->
        <div class="nk-main ">
            <!-- wrap @s -->
            <div class="nk-wrap nk-wrap-nosidebar">
                <!-- content @s -->
                <div class="nk-content ">
                    <div class="nk-block nk-block-middle nk-auth-body  wide-xs">

                        <div class="card">
                            <div class="card-inner card-inner-lg">
                                <div class="nk-block-head">
                                    <div class="nk-block-head-content">
                                        <h4 class="nk-block-title">Connexion</h4>
                                        <div class="nk-block-des">
                                            <p>Accédez à votre tableau de bord</p>

                                            <div id="showMsg"></div>
                                        </div>
                                    </div>
                                </div>
                                <form action="{{ route('login') }}" method="POST" autocomplete="off">
                                    @csrf
                                    <div class="form-group">
                                        <div class="form-label-group">
                                            <label class="form-label" for="email">E-mail</label>
                                        </div>
                                        <div class="form-control-wrap">
                                            <input type="text"
                                                    class="form-control form-control-lg @error('email') is-invalid @enderror"
                                                    name="email"
                                                    id="email"
                                                    placeholder="Enter votre addresse email"
                                                    oninput="checkUser()">
                                        @error('email')
                                            <span class="error">{{ $message }}</span>
                                        @enderror
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="form-label-group">
                                            <label class="form-label" for="password">Mot de passe</label></div>
                                        <div class="form-control-wrap">
                                            <a href="#" class="form-icon form-icon-right passcode-switch lg" data-target="password">
                                                <em class="passcode-icon icon-show icon ni ni-eye"></em>
                                                <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                                            </a>
                                            <input type="password"
                                                    class="form-control form-control-lg @error('password') is-invalid @enderror"
                                                    name="password"
                                                    id="password"
                                                    placeholder="Enter votre mot de passe">
                                            @error('password')
                                                <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group d-none" id="content_confirm_password">
                                        <label for="confirm_password" class="form-label">Confirmation de mot de passe</label>
                                        <input type="password" name="confirm_password" class="form-control form-control-merge @error('confirm_password') is-invalid @enderror" id="confirm_password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password"/>
                                        @error('confirm_password')
                                            <span class="error">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <button class="btn btn-lg btn-primary btn-block"> Se connecter </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- wrap @e -->
            </div>
            <!-- content @e -->
        </div>
        <!-- main @e -->
    </div>
    <!-- app-root @e -->
    <!-- JavaScript -->
    <script src="./assets/js/bundle.js?ver=3.2.3"></script>
    <script src="./assets/js/scripts.js?ver=3.2.3"></script>
    <!-- select region modal -->


    <script src="{!! asset('./assets/js/functions.js') !!}"></script>

    <script>
        function checkUser(){
            var email = $('#email').val()

            // console.log(email)

            var route = '{{ route("recover_user.email", ":email") }}';
                route = route.replace(':email', email);
            $.get(route, function(data) {
                if (data.response) {
                    $('#content_confirm_password').removeClass('d-none')
                }else{
                    $('#content_confirm_password').addClass('d-none')
                }
            });
        }

        window.onload = checkUser()

        @if(Session::has('User unactive'))
            message_alert('danger',"Votre compte est désactivé. Vous n'avez plus les drois pour vous connecter sur cette plateforme !")
        @endif

        @if(Session::has('password succes'))
            message_alert('success',"Vous avez modifier votre mot de passe. Veuillez vous reconnecter.")
        @endif

    </script>

</html>
