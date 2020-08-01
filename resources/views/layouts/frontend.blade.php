<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ config('app.name') }} | {{$title}}</title>
    <link
      href="https://fonts.googleapis.com/css?family=Lato:400,700,900|Pacifico&display=swap"
      rel="stylesheet"
    />
    <link rel="shortcut icon" type="image/png" href="img/favicon.png" />
    <link rel="stylesheet" type="text/css" href="{{ url('css/main.css') }}" />
  </head>
  <body>
    @yield('content')
  </body>
</html>
