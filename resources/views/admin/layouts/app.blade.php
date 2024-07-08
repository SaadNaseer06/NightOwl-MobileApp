@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Birds View</title>
    
    <link rel="icon" type="image/x-icon" href="{{ asset('public/storage/images/logo.png') }}">
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('public/css/all.min.css') }}">
    <!-- IonIcons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('public/css/adminlte.css') }}">
    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    
    <style>
        .nav-item.active > .nav-link {
            background-color: #007bff;
            color: #fff;
        }
        table {
          font-family: arial, sans-serif;
          border-collapse: collapse;
          width: 100%;
        }
        
        td, th {
          border: 1px solid #dddddd;
          text-align: left;
          padding: 8px;
        }
        
        tr:nth-child(even) {
          background-color: #dddddd;
        }
    </style>
    
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                            class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block" style="padding: 8px;">
                    <a href="/" class="nav-nav" style="color: rgba(0, 0, 0, .5);display: inline-block !important;">Home</a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- Navbar Search -->
                
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="btn btn-primary" type="submit">Logout</button>
                </form>
                <script>
                    // Wait for the DOM to be fully loaded
                    document.addEventListener('DOMContentLoaded', function() {
                        // Find the logout button by its ID
                        const logoutButton = document.getElementById('logoutButton');
                
                        // Add a click event listener to the logout button
                        logoutButton.addEventListener('click', function() {
                            // Send an AJAX POST request to the logout route
                            axios.post('{{ route("logout") }}')
                                .then(response => {
                                    console.log(response.data.message); // Log success message
                                    // Optionally redirect to another page after logout
                                    window.location.href = '/'; // Redirect to homepage
                                })
                                .catch(error => {
                                    console.error('Logout failed:', error);
                                });
                        });
                    });
                </script>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="/" class="brand-link">
                <img src="{{ asset('public/storage/images/logo.png') }}" alt="AdminLTE Logo"
                    class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">Birds View</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="{{ Auth::guard('web')->user()->image }}" class="img-circle elevation-2"
                            alt="User Image">
                    </div>
                    <div class="info">
                        <a href="#" class="d-block">{{ Auth::guard('web')->user()->username }}</a>
                    </div>
                </div>

                <!-- SidebarSearch Form -->

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class with font-awesome or any other icon font library -->
                        <li class="nav-item">
                            <a href="/" class="nav-link">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    Dashboard
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-copy"></i>
                                <p>
                                    Users
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="/add-user" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Add Users</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="/users" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>All Users</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-copy"></i>
                                <p>
                                    Bars
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="/add-bars" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Add Bars</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="/bars" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>All Bars</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="/inactive" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Inactive Bars</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                
                    <script>
                        document.addEventListener("DOMContentLoaded", function() {
                            const currentUrl = window.location.pathname;
                            const navItems = document.querySelectorAll('.nav-item');
                            const navLinks = document.querySelectorAll('.nav-link');
                
                            // Function to remove 'active' class from all nav-items and nav-links
                            function removeAllActive() {
                                navItems.forEach(item => {
                                    item.classList.remove('active menu-is-opening menu-open');
                                });
                
                                navLinks.forEach(link => {
                                    link.classList.remove('active');
                                });
                            }
                
                            // Check if current URL matches any nav-link's href
                            navLinks.forEach(link => {
                                const href = link.getAttribute('href');
                                if (href === currentUrl) {
                                    link.classList.add('active');
                                    link.closest('.nav-item').classList.add('active');
                                }
                            });
                
                            // Check if current URL matches any nav-item's href
                            navItems.forEach(item => {
                                const links = item.querySelectorAll('.nav-link');
                                links.forEach(link => {
                                    const href = link.getAttribute('href');
                                    if (href === currentUrl) {
                                        item.classList.add('active');
                                        link.classList.add('active');
                                    }
                                });
                            });
                        });
                    </script>
                </nav>
            </div>
        </aside>

        @yield('content')

        <footer class="main-footer">
            <strong>Copyright &copy; {{ date('Y') }} <a href="https://owlapi.zemfar.com/">Birds View</a>.</strong>
            All rights reserved.
        </footer>
    </div>

    <!-- REQUIRED SCRIPTS -->

    <!-- jQuery -->
    <script src="{{ asset('public/js/jquery.min.js') }}"></script>
    <!-- Bootstrap -->
    <script src="{{ asset('public/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE -->
    <script src="{{ asset('public/js/adminlte.js') }}"></script>

    <!-- OPTIONAL SCRIPTS -->
    <script src="{{ asset('public/js/Chart.min.js') }}"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="{{ asset('public/js/demo1.js') }}"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="{{ asset('public/js/dashboard3.js') }}"></script>

    <!-- SweetAlert2 -->
    <script src="{{ asset('public/plugins/sweetalert2.min.js') }}"></script>

    <!-- Toastr -->
    <script src="{{ asset('public/plugins/toastr.min.js') }}"></script>
</body>

</html>
