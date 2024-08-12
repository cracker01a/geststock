<!DOCTYPE html>
<html lang="zxx" class="js">

<head>

    <base href="{{ asset('./') }}">

    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="author" content="Softnio">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="A powerful and conceptual apps base dashboard template that especially build for developers and programmers.">
    <!-- Fav Icon  -->
    <link rel="shortcut icon" href="./images/favicon.png">
    <!-- Page Title  -->
    <title> @yield('title') </title>
    <!-- StyleSheets  -->
    <link rel="stylesheet" href="./assets/css/dashlite.css?ver=3.2.3">
    <link id="skin-default" rel="stylesheet" href="./assets/css/theme.css?ver=3.2.3">
</head>

<body class="nk-body bg-lighter npc-default has-sidebar ">
    <div class="nk-app-root">
        <!-- main @s -->
        <div class="nk-main ">
            <!-- sidebar @s -->
            @include('partials.sidebar')
            <!-- sidebar @e -->
            <!-- wrap @s -->
            <div class="nk-wrap ">
                <!-- main header @s -->
                @include('partials.header')
                
                <div class="nk-content ">
                    <div class="container-fluid">
                        <div class="nk-content-inner">
                            <div class="nk-content-body">

                                <div id='showMsg'></div>
                                <!-- main header @e -->
                                <!-- content @s -->
                                @yield('content')
                            </div>
                        </div>
                    </div>
                </div>
                <!-- content @e -->
                <!-- footer @s -->
                @include('partials.footer')
                <!-- footer @e -->
            </div>
            <!-- wrap @e -->
        </div>
        <!-- main @e -->
    </div>
    <!-- app-root @e -->
    <!-- select region modal -->

    <!-- JavaScript -->
    <script src="./assets/js/bundle.js?ver=3.2.3"></script>
    <script src="./assets/js/scripts.js?ver=3.2.3"></script>
    <script src="./assets/js/charts/chart-ecommerce.js?ver=3.2.3"></script>
    <script src="./assets/js/functions.js"></script>

    @include('partials.js.function')
    @yield('scripts')
</body>

</html>
