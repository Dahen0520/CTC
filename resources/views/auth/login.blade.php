<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Club Turístico Cooperativo</title>

    <link rel="stylesheet" href="{{ asset('css/login/login.css') }}">
</head>
<body>
    <div class="container">
        <div class="blue-curve-top"></div>
        <div class="green-curve-bottom"></div>
        <div class="magic-particle magic-particle-1"></div>
        <div class="magic-particle magic-particle-2"></div>
        <div class="magic-particle magic-particle-3"></div>
        <div class="magic-particle magic-particle-4"></div>
        <div class="magic-particle magic-particle-5"></div>
        <div class="magic-particle magic-particle-6"></div>
        <div class="energy-wave wave-1"></div>
        <div class="energy-wave wave-2"></div>
        <div class="energy-wave wave-3"></div>
        <div class="bubble bubble-1 bubble-yellow"></div>
        <div class="bubble bubble-2 bubble-green"></div>
        <div class="bubble bubble-3 bubble-blue"></div>
        <div class="bubble bubble-4 bubble-yellow"></div>
        <div class="bubble bubble-5 bubble-green"></div>
        <div class="bubble bubble-6 bubble-blue"></div>
        <div class="bubble bubble-7 bubble-yellow"></div>
        <div class="bubble bubble-8 bubble-green"></div>
        <div class="bubble bubble-9 bubble-blue"></div>
        <div class="bubble bubble-10 bubble-yellow"></div>
        <div class="bubble bubble-11 bubble-green"></div>
        <div class="bubble bubble-12 bubble-blue"></div>
    </div>

    <div class="login-container">
        <div class="login-header">
            <img src="{{ asset('assets/imgs/ctc.png') }}" alt="Logo" class="logo">
            <h1 class="login-title">Iniciar Sesión</h1>
        </div>

        @if (session('status'))
            <div class="session-status">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group">
                <label for="email" class="form-label">Correo Electrónico</label>
                <input
                    id="email"
                    class="form-input"
                    type="email"
                    name="email"
                    placeholder="tu@email.com"
                    required
                    autofocus
                    autocomplete="username"
                    value="{{ old('email') }}"
                >
                @error('email')
                    <div class="error-message">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password" class="form-label">Contraseña</label>
                <input
                    id="password"
                    class="form-input"
                    type="password"
                    name="password"
                    placeholder="••••••••"
                    required
                    autocomplete="current-password"
                >
                @error('password')
                    <div class="error-message">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="remember-container">
                <input
                    id="remember_me"
                    type="checkbox"
                    class="checkbox-input"
                    name="remember"
                >
                <label for="remember_me" class="checkbox-label">Recordarme</label>
            </div>

            <div class="button-group">
                <button type="submit" class="btn-primary">
                    Iniciar Sesión
                </button>

                @if (Route::has('password.request'))
                    <a class="forgot-password" href="/">
                        Regresar
                    </a>
                @endif

                <a class="btn-secondary" href="/">
                    ¿No tienes cuenta? habla con un admin
                </a>
            </div>
        </form>
    </div>

    <script src="{{ asset('js/login/login.js') }}"></script>
</body>
</html>