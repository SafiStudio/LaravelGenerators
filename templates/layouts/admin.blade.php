<html>
<head>
    <title>{{ config('cms.name') }}</title>
    <link rel="stylesheet" href="{{ asset('css/fontawesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/calendar.css') }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('images/admin/favicon.ico') }}" />
    <script src="{{ asset('js/admin/jquery-2.1.4.min.js') }}"></script>
    <script src="{{ asset('js/admin/calendar.js') }}"></script>
    <script src="{{ asset('js/admin/scripts.js') }}"></script>
    @if (isset($_head_scripts))
        {!! $_head_scripts !!}
    @endif
</head>
<body>
<section class="top">
    <header class="header">
        <div class="logo">
                <span>
                    <a href="{{ action('Admin\PanelController@index') }}">
                        <img src="{{ asset('images/admin/'.config('cms.logo')) }}" alt="Safi Studio" /> CMS
                    </a>
                </span>
        </div>
        <a href="{{ action('Admin\AuthController@getLogout') }}" class="logout">
            <i class="icon fa fa-sign-out"></i> Wyloguj się
        </a>
    </header>
</section>
<section class="sidebar">
    <div class="sidebar-head"></div>
    @include('admin.menu')
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