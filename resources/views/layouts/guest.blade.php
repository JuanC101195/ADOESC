<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('titulo', 'ADOESC')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        body { background: linear-gradient(135deg, #007940 0%, #111111 100%); min-height: 100vh; }
        .auth-card { max-width: 420px; width: 100%; }
        .text-adoesc { color: #007940; }
        .btn-adoesc { background-color: #007940; border-color: #007940; color: #fff; }
        .btn-adoesc:hover { background-color: #005c30; border-color: #005c30; color: #fff; }
    </style>
</head>
<body class="d-flex align-items-center justify-content-center py-5">
    <div class="auth-card">
        <div class="text-center text-white mb-4">
            <h1 class="fw-bold"><i class="bi bi-calendar2-event"></i> ADOESC</h1>
            <p class="mb-0">Organización Eficiente de Eventos</p>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('contenido')
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
