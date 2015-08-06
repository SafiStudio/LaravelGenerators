<html>
<head>
    <title>Your CMS Name</title>
    <link rel="stylesheet" href="{{ asset('css/fontawesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/style.css') }}">
    <script src="{{ asset('js/admin/jquery-2.1.4.min.js') }}"></script>
    <script src="{{ asset('js/admin/scripts.js') }}"></script>
</head>
<body>
    <section class="top">
        <header class="header">
            <div class="logo">
                <span class="mdl-layout-title">Your CMS Name</span>
            </div>
            <nav class="main-navigation">
                <ul>
                    <li>
                        <a href="#">Sample Link</a>
                    </li>
                    <li>
                        <a href="{{ action('Admin\AuthController@getLogout') }}" class="mdl-menu__item">
                            <i class="icon fa fa-sign-out"></i> Wyloguj się
                        </a>
                    </li>
                </ul>
            </nav>
        </header>
    </section>
    <section id="main" class="middle">
        @if (count($errors) > 0)
        <div class="alert danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        @if(Session::has('message'))
        <div class="alert">
            <ul>
                <li>{{ Session::get('message') }}</li>
            </ul>
        </div>
        @endif
        <div class="row">
            <div class="content">
                @yield('content')
            </div>
        </div>
    </section>
</body>
</html>