<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="csrf-token" id="csrf-token" content="{{ csrf_token() }}">
  <!-- <link rel="apple-touch-icon" sizes="76x76" href="./assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="./assets/img/favicon.png"> -->
  <title>
    PKU MUI
  </title>
  <!--     Fonts and icons     -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />
  <!-- Nucleo Icons -->
  <link href="{{asset('assets/admin/css/nucleo-icons.css')}}" rel="stylesheet" />
  <link href="{{asset('assets/admin/css/nucleo-svg.css')}}" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <!-- Material Icons -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
  <!-- CSS Files -->
  <link id="pagestyle" href="{{asset('assets/admin/css/material-dashboard.css?v=3.0.2')}}" rel="stylesheet" />
  <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
 
 <!-- DevExtreme theme -->
 <link rel="stylesheet" href="https://cdn3.devexpress.com/jslib/21.2.7/css/dx.light.css">
  <script>
    var PARAMETER_URL = "{{ route('parameterLookup') }}"
  </script>
 <!-- DevExtreme library -->
 <script type="text/javascript" src="https://cdn3.devexpress.com/jslib/21.2.7/js/dx.all.js"></script>

</head>
