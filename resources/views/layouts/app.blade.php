<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <title>@yield('title')</title>
  @include('components.app.styles')
  @stack('additional-styles')
</head>

<body>
  <!-- Semantic elements -->
  <!-- https://www.w3schools.com/html/html5_semantic_elements.asp -->

  <!-- Bootstrap navbar example -->
  <!-- https://www.w3schools.com/bootstrap4/bootstrap_navbar.asp -->
  @include('components.app.navbar')

  @yield('content')

  @include('components.app.footer')

  @include('components.app.script')

  @stack('additional-script')
</body>

</html>