<!doctype html>
<html lang="id">
    <head>
        <title>Login | ERP CV. SAE GROUP</title>
        <!-- [Meta] -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="description" content="Mantis is made using Bootstrap 5 design framework. Download the free admin template & use it for your project.">
        <meta name="keywords" content="Mantis, Dashboard UI Kit, Bootstrap 5, Admin Template, Admin Dashboard, CRM, CMS, Bootstrap Admin Template">
        <meta name="author" content="CodedThemes">
      
        <!-- [Favicon] icon -->
        <link rel="icon" href="../assets/images/favicon.svg" type="image/x-icon"> <!-- [Google Font] Family -->
      <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap" id="main-font-link">
      <!-- [Tabler Icons] https://tablericons.com -->
      <link rel="stylesheet" href="../assets/fonts/tabler-icons.min.css" >
      <!-- [Feather Icons] https://feathericons.com -->
      <link rel="stylesheet" href="../assets/fonts/feather.css" >
      <!-- [Font Awesome Icons] https://fontawesome.com/icons -->
      <link rel="stylesheet" href="../assets/fonts/fontawesome.css" >
      <!-- [Material Icons] https://fonts.google.com/icons -->
      <link rel="stylesheet" href="../assets/fonts/material.css" >
      <!-- [Template CSS Files] -->
      <link rel="stylesheet" href="../assets/css/style.css" id="main-style-link" >
      <link rel="stylesheet" href="../assets/css/style-preset.css" >
      
    </head>
<body>
    <!-- loader -->
    <div class="loader-bg">
        <div class="loader-track">
        <div class="loader-fill"></div>
        </div>
    </div>

    <!-- Wrapper -->
    <div class="auth-main">
        <div class="auth-wrapper v3">
            <div class="auth-form">
                <div class="auth-header">
                    {{-- <a href="#"><img src="../assets/images/logo.png" alt="img" class="logo"></a> --}}
                </div>
                <div class="card my-5">
                    @yield('container')
                </div>
                <div class="auth-footer row">
                    {{-- <div class="col my-1">
                        <p class="m-0">Copyright © <a href="#">Codedthemes</a></p>
                    </div>
                    <div class="col-auto my-1">
                        <ul class="list-inline footer-link mb-0">
                            <li class="list-inline-item"><a href="#">Home</a></li>
                            <li class="list-inline-item"><a href="#">Privacy Policy</a></li>
                            <li class="list-inline-item"><a href="#">Contact us</a></li>
                        </ul>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>

    @yield('specificpagescripts')

    <!-- App JavaScript -->
    {{-- <script src="{{ asset('assets/js/app.js') }}"></script> --}}
    <script src="../assets/js/plugins/popper.min.js"></script>
    <script src="../assets/js/plugins/simplebar.min.js"></script>
    <script src="../assets/js/plugins/bootstrap.min.js"></script>
    <script src="../assets/js/fonts/custom-font.js"></script>
    <script src="../assets/js/pcoded.js"></script>
    <script src="../assets/js/plugins/feather.min.js"></script>
    
</body>
</html>
