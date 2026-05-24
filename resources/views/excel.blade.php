<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Excel de Cientes</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <style>
            body {
                background-color: rgba(0, 0, 0, 0.6);
            }

            .view-excel__container {
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
            }

            .view-excel__content {
                background-color: #000;
                padding: 20px;
                border-radius: 10px;
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                gap: 10px;

                font-family: 'roboto', sans-serif;


                h1 {
                    font-family: 'roboto', sans-serif;
                    font-size: 2rem;
                    color: #FFF;
                    text-align: center;
                }

                a {
                    background-color: #fb862d;
                    color: #FFF;
                    padding: 10px 20px;
                    border-radius: 5px;
                    text-decoration: none;
                    cursor: pointer;
                }

                a:hover {
                    background-color: rgba(251, 134, 45, 0.8);
                }
            }
        </style>
    @endif
</head>

<body class="font-sans">
    <div class="view-excel__container">
        <div class="view-excel__content">
            <h1 class="">Lista de Clientes</h1>
            <a href="{{ route('clients.export') }}" class="">
                Descargar Excel
            </a>
        </div>
    </div>
</body>

</html>
