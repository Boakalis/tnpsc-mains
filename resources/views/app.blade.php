<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed " dir="ltr" data-theme="theme-default"
  data-assets-path="../frontend/assets/" id="layout" data-template="vertical-menu-template-free">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- <meta name="viewport"
    content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" /> -->
  <link rel="icon" href="%PUBLIC_URL%/favicon.ico" />

  <meta name="description" content="Web site created using create-react-app" />
  <link rel="icon" type="image/x-icon" href="/frontend/assets/img/favicon/favicon.ico" />

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link
    href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
    rel="stylesheet" />

  <!-- Icons. Uncomment required icon fonts -->
  <link rel="stylesheet" href="/frontend/assets/vendor/fonts/boxicons.css" />

  <!-- Core CSS -->
  <link rel="stylesheet" href="/frontend/assets/vendor/css/core.css" class="template-customizer-core-css" />
  <link rel="stylesheet" href="/frontend/assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
  <link rel="stylesheet" href="/frontend/assets/css/demo.css" />

  <!-- Vendors CSS -->
  <link rel="stylesheet" href="/frontend/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

  <link rel="stylesheet" href="/frontend/assets/vendor/libs/apex-charts/apex-charts.css" />

  <!-- Page CSS -->

  <!-- Helpers -->
  <script src="/frontend/assets/vendor/js/helpers.js"></script>

  <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
  <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
  <script src="/frontend/assets/js/config.js"></script>
  {{-- <link href="{{asset('css/app.css')}}" rel="stylesheet" type="text/css"> --}}

  <title>React App</title>
</head>

<body style="background:aliceblue;">
  <noscript>You need to enable JavaScript to run this app.</noscript>



  <div id="root"></div>
  <div id="modal-root"></div>
  <div id="modal-register-root"></div>
  <div id="modal-forget-password-root"></div>
  <div id="modal-profile"></div>
  <div id="modal-alert"></div>
  <script src="{{asset('js/app.js')}}" ></script>

  <script src="/frontend/assets/vendor/libs/jquery/jquery.js"></script>
  <script src="/frontend/assets/vendor/libs/popper/popper.js"></script>
  <script src="/frontend/assets/vendor/js/bootstrap.js"></script>
  <script src="/frontend/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

  <script src="/frontend/assets/vendor/js/menu.js"></script>
  <!-- endbuild -->

  <!-- Vendors JS -->
  <script src="/frontend/assets/vendor/libs/apex-charts/apexcharts.js"></script>
  <script defer src="https://friconix.com/cdn/friconix.js"> </script>

  <!-- Main JS -->
  <script src="/frontend/assets/js/main.js"></script>
  <script src="https://kit.fontawesome.com/1b0bb62797.js" crossorigin="anonymous"></script>
  <!-- Page JS -->
  <script src="/frontend/assets/js/dashboards-analytics.js"></script>
  <script>
    $('#toggleButton').on('click', function () {
      console.log('i am working')
      $('#layout').removeClass('layout-menu-expanded')
    })
  </script>
</body>

</html>
