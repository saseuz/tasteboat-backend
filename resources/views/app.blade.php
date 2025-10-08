<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite('resources/js/app.js')
    @routes
    @inertiaHead
  </head>
  <body class="bg-[#111a22]">
    @inertia
  </body>
</html>