<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="user" content="{{ Auth::user() }}">
  <title>{{ config('app.name') }} | Dashboard</title>

  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="/adminlte/plugins/fontawesome-free/css/all.min.css">
    {{-- Themify Icons --}}
  {{-- <link rel="stylesheet" href="/themify_icons/themify_icons.css"> --}}
  <link rel="stylesheet" href="https://rawgit.com/lykmapipo/themify-icons/master/css/themify-icons.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

  <!-- Theme style -->
  <link rel="stylesheet" href="/adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="/adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="/adminlte/plugins/toastr/toastr.min.css">
  <link rel="stylesheet" href="/adminlte/css/adminlte.min.css">
 
  <link rel="stylesheet" href="{{ mix('css/app.css') }}>

  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <!-- CSS pages -->
</head>
<body class="hold-transition sidebar-mini">

<div class="wrapper">
  <div id="app">
      <!-- Navbar -->
      <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
          </li>
          <li class="nav-item d-none d-sm-inline-block">
            <a href="index3.html" class="nav-link">Home</a>
          </li>
          <li class="nav-item d-none d-sm-inline-block">
            <a href="#" class="nav-link">Contact</a>
          </li>
        </ul>

        <!-- SEARCH FORM -->
        <form class="form-inline ml-3">
          <div class="input-group input-group-sm">
            <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
            <div class="input-group-append">
              <button class="btn btn-navbar" type="submit">
                <i class="fas fa-search"></i>
              </button>
            </div>
          </div>
        </form>

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
          <!-- Messages Dropdown Menu -->
          <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
              <i class="far fa-comments"></i>
              <span class="badge badge-danger navbar-badge">3</span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
              <a href="#" class="dropdown-item">
                <!-- Message Start -->
                <div class="media">
                  <img src="/adminlte/img/user1-128x128.jpg" alt="User Avatar" class="img-size-50 mr-3 img-circle">
                  <div class="media-body">
                    <h3 class="dropdown-item-title">
                      Brad Diesel
                      <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                    </h3>
                    <p class="text-sm">Call me whenever you can...</p>
                    <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                  </div>
                </div>
                <!-- Message End -->
              </a>
              <div class="dropdown-divider"></div>
              <a href="#" class="dropdown-item">
                <!-- Message Start -->
                <div class="media">
                  <img src="/adminlte/img/user8-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
                  <div class="media-body">
                    <h3 class="dropdown-item-title">
                      John Pierce
                      <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
                    </h3>
                    <p class="text-sm">I got your message bro</p>
                    <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                  </div>
                </div>
                <!-- Message End -->
              </a>
              <div class="dropdown-divider"></div>
              <a href="#" class="dropdown-item">
                <!-- Message Start -->
                <div class="media">
                  <img src="adminlte/img/user3-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
                  <div class="media-body">
                    <h3 class="dropdown-item-title">
                      Nora Silvester
                      <span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>
                    </h3>
                    <p class="text-sm">The subject goes here</p>
                    <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                  </div>
                </div>
                <!-- Message End -->
              </a>
              <div class="dropdown-divider"></div>
              <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
            </div>
          </li>
          <!-- Notifications Dropdown Menu -->
          <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
              <i class="far fa-bell"></i>
              <span class="badge badge-warning navbar-badge">15</span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
              <span class="dropdown-header">15 Notifications</span>
              <div class="dropdown-divider"></div>
              <a href="#" class="dropdown-item">
                <i class="fas fa-envelope mr-2"></i> 4 new messages
                <span class="float-right text-muted text-sm">3 mins</span>
              </a>
              <div class="dropdown-divider"></div>
              <a href="#" class="dropdown-item">
                <i class="fas fa-users mr-2"></i> 8 friend requests
                <span class="float-right text-muted text-sm">12 hours</span>
              </a>
              <div class="dropdown-divider"></div>
              <a href="#" class="dropdown-item">
                <i class="fas fa-file mr-2"></i> 3 new reports
                <span class="float-right text-muted text-sm">2 days</span>
              </a>
              <div class="dropdown-divider"></div>
              <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#"><i
                class="fas fa-th-large"></i></a>
          </li>
        </ul>
      </nav>
      <!-- /.navbar -->

      <!-- Main Sidebar Container -->
      <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="index3.html" class="brand-link">
          <img src="/adminlte/img/sale_logo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
              style="opacity: .8">
          <span class="brand-text font-weight-light">{{ config('app.name') }}</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
          <!-- Sidebar user panel (optional) -->
          <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
              <img src="/adminlte/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
            </div>
            @if(auth()->user())
              <div class="info">
              <a href="#" class="d-block">{{ auth()->user()->name }}</a>
              </div>
            @endif
          </div>

          <!-- Sidebar Menu -->
          <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <router-link to="/" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                          Dashboard
                        </p>
                    </router-link>
                </li>
                {{-- Divisa --}}
                <li class="nav-item">
                  <router-link to="/divisas" class="nav-link" >
                    <i class="nav-icon fas fa-money-bill-alt"></i>
                    <p>
                      Divisa
                    </p>
                  </router-link>
                </li>
              <li class="nav-item has-treeview">
                <router-link to="#" class="nav-link">
                  <i class="nav-icon fas fa-boxes"></i>
                  <p>
                    Almacén
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </router-link>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <router-link to="/categorias" class="nav-link">
                      <i class="nav-icon fas fa-tags"></i>
                      <p>Categorias</p>
                    </router-link>
                  </li>
                  <li class="nav-item">
                      <router-link to="/productos" class="nav-link">
                        <i class="nav-icon fas fa-box"></i>
                        <p>Productos</p>
                      </router-link>
                  </li>
                  <li class="nav-item">
                    <router-link to="/precios_lista" class="nav-link">
                      <i class="nav-icon far fa-list-alt"></i>
                      <p>Lista de Precios</p>
                    </router-link>
                  </li>
                </ul>
              </li>
              <li class="nav-item has-treeview {{ setActiveNavDrop(['ingresos.index','proveedores.index']) }}">
                <a href="#" class="nav-link {{ setActiveRoute(['ingresos.index','proveedores.index']) }}">
                  <i class="nav-icon fas fa-store"></i>
                  <p>
                    Compras
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <router-link to="/ingresos" class="nav-link">
                      <i class="nav-icon fas fa-piggy-bank"></i>
                      <p>Ingresos</p>
                    </router-link>
                  </li>
                  <li class="nav-item">
                    <router-link to="/proveedores" class="nav-link">
                      <i class="nav-icon fas fa-industry"></i>
                      <p>Proveedores</p>
                    </router-link>
                  </li>
                </ul>
              </li>
              <li class="nav-item has-treeview {{ setActiveNavDrop(['ventas.index','clientes.index']) }}">
                <a href="#" class="nav-link {{ setActiveRoute(['ventas.index','clientes.index']) }}">
                  <i class="nav-icon far fa-handshake"></i>
                  <p>
                    Ventas
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <router-link to="/ventas" class="nav-link">
                      <i class="nav-icon fas fa-cash-register"></i>
                      <p>Ventas</p>
                    </router-link>
                  </li>
                  <li class="nav-item">
                    <router-link to="/clientes" class="nav-link">
                      <i class="nav-icon fas fa-user-tie"></i>
                      <p>Clientes</p>
                    </router-link>
                  </li>
                </ul>
              </li>
              <li class="nav-item has-treeview {{ request()->is(['usuarios','roles']) ? 'menu-openn' : '' }}">
                <a href="#" class="nav-link">
                  <i class="nav-icon fas fa-door-open"></i>
                  <p>
                    Accesos
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <router-link to="/usuarios" class="nav-link">
                      <i class="nav-icon fas fa-users"></i>
                      <p>Usurios</p>
                    </router-link>
                  </li>
                  <li class="nav-item">
                    <a href="{{ route('productos.index')}}" class="nav-link">
                      <i class="nav-icon fas fa-users-cog"></i>
                      <p>Roles</p>
                    </a>
                  </li>
                </ul>
              </li>
              <li class="nav-item has-treeview {{ request()->is(['reportesin','reportesout']) ? 'menu-openn' : '' }}">
                <a href="#" class="nav-link">
                  <i class="nav-icon fas fa-clipboard"></i>
                  <p>
                    Reportes
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="{{ route('categorias.index') }}" class="nav-link">
                      <i class="nav-icon fas fa-file-invoice"></i>
                      <p>Reportes Ingreso</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ route('productos.index')}}" class="nav-link">
                      <i class="nav-icon fas fa-file-invoice-dollar"></i>
                      <p>Reportes Ventas</p>
                    </a>
                  </li>
                </ul>
              </li>
              <li class="nav-item">
                <a href="{{ route('logout') }}"
                onclick="event.preventDefault();
                              document.getElementById('logout-form').submit();" class="nav-link">
                  <i class="nav-icon fas fa-sign-out-alt"></i>
                  <p>
                    {{ __('Logout') }}
                    {{-- <span class="right badge badge-danger">New</span> --}}
                  </p>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                  @csrf
                </form>
              </li>
            </ul>
          </nav>
          <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
      </aside>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">


          {{-- Message --}}
          <div class="container-fluid">
            @if(session()->has('message'))
              <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('message') }}
                <button type="button"
                  class="close"
                  data-dismiss="alert"
                  aria-label="Close">
                  <span arian-hidden="true">&times;</span>
                </button>
              </div>
            @endif
          </div>

          <div class="content">
            <router-view></router-view>
          </div>  
      </div> 

      <!-- Main Footer -->
      <footer class="main-footer">
        <!-- To the right -->
        <div class="float-right d-none d-sm-inline">
          Anything you want
        </div>
        <!-- Default to the left -->
        <strong>Copyright &copy; 2020 | V-1.0 <a href="https://adminlte.io">{{ config('app.name') }}.io</a>.</strong> All rights reserved.
      </footer>
  </div>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="/adminlte/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="/adminlte/plugins/chart.js/Chart.min.js"></script>
<!-- DataTables -->
{{-- <script src="/adminlte/plugins/datatables/jquery.dataTables.js"></script>
<script src="/adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="/adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="/adminlte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script> --}}
<script src="/adminlte/plugins/toastr/toastr.min.js"></script>
<!-- AdminLTE App -->
<script src="/adminlte/js/adminlte.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.min.js"></script>
<!-- AdminLTE App -->
<script src="{{ mix('js/app.js') }}"></script>
</body>

</html>
