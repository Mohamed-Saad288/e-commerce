<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
<div id="app">
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                {{ config('app.name', 'Laravel') }}
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav mr-auto">

                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                    <!-- Authentication Links -->
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="#">{{ __('Login') }}</a>
                        </li>
{{--                        @if (Route::has('register'))--}}
{{--                            <li class="nav-item">--}}
{{--                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>--}}
{{--                            </li>--}}
{{--                        @endif--}}
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
{{--                                {{ Auth::user()->name }}--}}
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="#"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="#" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <main class="py-4">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <center>
                        <button id="btn-nft-enable" onclick="initFirebaseMessagingRegistration()" class="btn btn-danger btn-xs btn-flat">Allow for Notification</button>
                    </center>
                    <div class="card">
                        <div class="card-header">{{ __('Dashboard') }}</div>

                        <div class="card-body">
                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif

                            <form action="{{ route('send_notification') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label>Title</label>
                                    <input type="text" class="form-control" name="title">
                                </div>
                                <div class="form-group">
                                    <label>Body</label>
                                    <textarea class="form-control" name="body"></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Send Notification</button>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://www.gstatic.com/firebasejs/7.23.0/firebase.js"></script>
        <script>


            var firebaseConfig = {
                apiKey: "AIzaSyCrcDJhIgVFloAdk7XucpwtgZIV_rayXtk",
                authDomain: "drcode-8d60f.firebaseapp.com",
                projectId: "drcode-8d60f",
                storageBucket: "drcode-8d60f.firebasestorage.app",
                messagingSenderId: "624263796486",
                appId: "1:624263796486:web:92d1e23dc1143b62e73087",
                measurementId: "G-BNWRCFRYCD"
            };
            // measurementId: G-R1KQTR3JBN
            // Initialize Firebase
            firebase.initializeApp(firebaseConfig);
            const messaging = firebase.messaging();

            function initFirebaseMessagingRegistration() {
                messaging
                    .requestPermission()
                    .then(function () {
                        return messaging.getToken()
                    })
                    .then(function(token) {
                        console.log(token);

                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });

                        $.ajax({
                            url: '{{ route("save-token") }}',
                            type: 'POST',
                            data: {
                                token: token
                            },
                            dataType: 'JSON',
                            success: function (response) {
                                alert('Token saved successfully.');
                            },
                            error: function (err) {
                                console.log('User Chat Token Error'+ err);
                            },
                        });

                    }).catch(function (err) {
                    toastr.error('User Chat Token Error'+ err, null, {timeOut: 3000, positionClass: "toast-bottom-right"});
                });
            }


            messaging.onMessage(function(payload) {
                const noteTitle = payload.notification.title;
                const noteOptions = {
                    body: payload.notification.body,
                    icon: payload.notification.icon,
                };
                new Notification(noteTitle, noteOptions);
            });

        </script>
    </main>
</div>
</body>
</html>
