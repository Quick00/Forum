<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="{{ url('/css/reset.css') }}" />
        <link rel="stylesheet" type="text/css" href="{{ url('/css/main.css') }}" />

        <title>Laravel</title>

    </head>
    <body>
    <div class="container">
        <div id='app'>
            <main></main>
        </div>
    </div>
    <script src="js/app.js"></script>
    </body>

</html>
