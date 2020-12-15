<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Laravel SPA</title>
  <script src="{{asset('js/eruda.js')}}"></script>
  <script>
    // eruda init
    eruda.init();
  </script>
  <link rel="stylesheet" href="{{mix('/css/app.css')}}" />
</head>
<body>
  <div id="app">
    <product-component></product-component>
  </div>
  <script src="{{mix('/js/app.js')}}"></script>
</body>
</html>