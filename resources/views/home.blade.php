<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="icon" href="{{ asset('favicon.ico') }}">

        <title>{{ config('app.name') }}</title>

        <link rel="canonical" href="{{ url('/') }}">

        <link href="{{ mix("css/app.css") }}" rel="stylesheet">
    </head>

    <body>

    <header>
        <!-- Fixed navbar -->
        <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
            <a class="navbar-brand" href="#">Adverts</a>
        </nav>
    </header>

    <main role="main" class="container">
        <h1 class="mt-5"></h1>
        <p class="lead"></p>
    </main>

    <footer class="footer">
        <div class="container">
            <span class="text-muted">{{ date("Y") }} @ Redwerk Test.</span>
        </div>
    </footer>

    <script src="{{ mix("js/jquery.min.js") }}"></script>
    <script src="{{ mix("js/popper.min.js") }}"></script>
    <script src="{{ mix("js/bootstrap.min.js") }}"></script>
    <script src="{{ mix("js/app.js") }}"></script>
    </body>
</html>
