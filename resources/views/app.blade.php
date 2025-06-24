<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />

    <title inertia>{{ config('app.name', 'Task Manager') }}</title>

    @vite(['resources/js/app.js', 'resources/css/app.css'])
    
    @inertiaHead
  </head>
  <body>
    @inertia

    <script>
      if (window.InertiaProgress) {
        InertiaProgress.init();
      }
    </script>
  </body>
</html>
