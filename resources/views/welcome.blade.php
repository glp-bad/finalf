<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <title>Finalf</title>
        <link href="{{ asset(mix('css/app.css')) }}" type="text/css" rel="stylesheet" />
        <meta name="csrf-token" value="{{ csrf_token() }}" />

    </head>
    <body>
        <noscript><strong>We're sorry but vue-client doesn't work properly without JavaScript enabled. Please enable it to continue.</strong></noscript>
            <div id="app"></div>
            <script src="{{ asset(mix('js/chunk-vendors.js')) }}" type="text/javascript"></script>
            <script src="{{ asset(mix('js/app.js')) }}" type="text/javascript"></script>
    </body>
</html>
