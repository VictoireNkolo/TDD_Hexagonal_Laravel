<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf" content="{{ csrf_token()  }}">

        <title>School Manager</title>

        <style>
            body {
                font-family: 'Nunito', sans-serif;
            }
        </style>

        @viteReactRefresh
        @vite('resources/react-app/index.css')
        @vite('resources/react-app/main.tsx')

    </head>
    <body class="antialiased">
        <div id="app"></div>
    </body>
</html>
