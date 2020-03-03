
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

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>Turon Plast</title>

  <!-- <link rel="stylesheet" type="text/css" href="/css/app.css"> -->
  <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">

</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper" id="app">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
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

  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="{{ asset('img/logo.png') }}" alt="TuronPlast Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">Turon Plast</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{ asset('img/profile.png') }}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{ Auth::user()->name }}</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

          <li class="nav-item">
            <router-link to="/dashboard" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </router-link>
          </li>

          <li class="nav-item has-treeview">
            <router-link to="/xomashyo" class="nav-link">
              <i class="nav-icon fas fa-list"></i>
              <p>
                Xom Ashyo
                <i class="right fas fa-angle-left"></i>
              </p>
            </router-link>
            <ul class="nav nav-treeview" style="display: none;">
              <li class="nav-item">
                <router-link to="/calculation" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Kalkulyatsiya</p>
                </router-link>
              </li>
              <li class="nav-item">
                <router-link to="/ishlab-chiqarish" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Ishlab Chiqarish</p>
                </router-link>
              </li>
              <li class="nav-item">
                <router-link to="/savdo" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Savdo</p>
                </router-link>
              </li>
            </ul>
          </li>
          
          <!-- <li class="nav-item has-treeview">
            <router-link to="/maxsulot" class="nav-link">
              <i class="nav-icon fas fa-box"></i>
              <p>
                Maxsulot
                <i class="right fas fa-angle-left"></i>
              </p>
            </router-link>
            <ul class="nav nav-treeview" style="display: none;">
              <li class="nav-item">
                <router-link to="/t-maxsulotlar" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Tayyor Maxsulotlar</p>
                </router-link>
              </li>
              <li class="nav-item">
                <router-link to="/yt-maxsulotlar" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Yarim Tayyor Maxsulotlar</p>
                </router-link>
              </li>
            </ul>
          </li> -->

          <li class="nav-item">
            <router-link to="/maxsulot" class="nav-link">
              <i class="nav-icon fas fa-box"></i>
              <p>
                Maxsulot
              </p>
            </router-link>
          </li>
          
          <li class="nav-item">
            <router-link to="/zakaz-olish" class="nav-link">
              <i class="nav-icon fas fa-dolly"></i>
              <p>
                Zakaz Olish
              </p>
            </router-link>
          </li>

          <li class="nav-item has-treeview">
            <router-link to="/sklad" class="nav-link">
              <i class="nav-icon fas fa-warehouse"></i>
              <p>
                Sklad
                <i class="right fas fa-angle-left"></i>
              </p>
            </router-link>
            <ul class="nav nav-treeview" style="display: none;">
              <li class="nav-item">
                <router-link to="/tm-skladi" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Tayyor Maxsulotlar Skladi</p>
                </router-link>
              </li>
              <li class="nav-item">
                <router-link to="/xom-ashyo-skladi" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Xom Ashyo Skladi</p>
                </router-link>
              </li>
            </ul>
          </li>

          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-clipboard-list"></i>
              <p>
                Oldi Berdilar
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview" style="display: none;">
              <li class="nav-item">
                <router-link to="/klentlar-oldi-berdisi" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Klentlar Bilan</p>
                </router-link>
              </li>
              <li class="nav-item">
                <router-link to="/mol-yetkazuvchilar-oldi-berdisi" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Mol Yetkazuvchilar Bilan</p>
                </router-link>
              </li>
            </ul>
          </li>

          <li class="nav-item has-treeview">
            <router-link to="/harajatlar" class="nav-link">
              <i class="nav-icon fas fa-clipboard-check"></i>
              <p>
                Harajatlar
                <i class="right fas fa-angle-left"></i>
              </p>
            </router-link>
            <ul class="nav nav-treeview" style="display: none;">
              <li class="nav-item">
                <router-link to="/kassa" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Kassa</p>
                </router-link>
              </li>
              <li class="nav-item">
                <router-link to="/klentlar" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Klentlar Ro'yhati</p>
                </router-link>
              </li>
              <li class="nav-item">
                <router-link to="/jurnal" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Jurnal</p>
                </router-link>
              </li>
            </ul>
          </li>

          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-clipboard-check"></i>
              <p>
                Sozlamalar
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview" style="display: none;">
              <li class="nav-item">
                <router-link to="/olchovlar" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>O'lchovlar</p>
                </router-link>
              </li>
              <li class="nav-item">
                <router-link to="/klent_turlari" class="nav-link">
                  <i class="fas fa-users nav-icon"></i>
                  <p>Klent Turlari</p>
                </router-link>
              </li>
              <li class="nav-item">
                <router-link to="/users" class="nav-link">
                  <i class="fas fa-users nav-icon"></i>
                  <p>Users</p>
                </router-link>
              </li>
              <li class="nav-item">
                <router-link to="/pul" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Pul birliklari</p>
                </router-link>
              </li>
              <li class="nav-item">
                <router-link to="/harajat_turlari" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Harajat Turlari</p>
                </router-link>
              </li>
              <li class="nav-item">
                <router-link to="/maxsulot_turlari" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Maxsulot Turlari</p>
                </router-link>
              </li>
            </ul>
          </li>



          <li class="nav-item">
            <a class="nav-link" href="{{ route('logout') }}"
               onclick="event.preventDefault();
                             document.getElementById('logout-form').submit();">
                <i class="nav-icon fas fa-power-off"></i>
                <p>{{ __('Chiqish') }}</p>

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
    
    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        
        <router-view></router-view>

        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  
  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
      Anything you want
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; 2014-2019 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
  </footer>
</div>
<!-- ./wrapper -->

<script src="{{ asset('js/app.js') }}" type="text/javascript"></script>
</body>
</html>
