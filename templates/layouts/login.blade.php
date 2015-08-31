<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="{{ asset('css/fontawesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/style.css') }}">
    <script src="{{ asset('js/admin/jquery-2.1.4.min.js') }}"></script>
</head>
<body class="login">
<div class="card login-card">
    <div class="card-title">
        <h2>Zaloguj się do systemu</h2>
    </div>
    <div class="card-text">
        @if (count($errors) > 0)
            <div class="alert danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <p>Wypełnij formularz aby się zalogować</p>
        @yield('content')
    </div>
</div>
</body>
</html>