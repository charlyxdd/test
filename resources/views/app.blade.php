<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <title>Laravel</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link href=" {{ mix('css/app.css') }}" rel="stylesheet">
</head>
<body>
<div id="app">
    <login v-if="!login" @login="fn_login"></login>
    <app v-if="login"></app>
</div>

<script src="{{ mix('js/bootstrap.js') }}"></script>
<script src="{{ mix('js/app.js') }}"></script>
</body>
</html>
