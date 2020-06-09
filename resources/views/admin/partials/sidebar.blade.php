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
        <div class="info">
        @if(auth()->user())  
        <a href="#" class="d-block">{{ auth()->user()->name }}</a>
        @endif
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-item">
                <a href="{{ route('admin') }}" class="nav-link {{ setActiveRoute('admin') }}">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>
                    Dashboard
                    {{-- <span class="right badge badge-danger">New</span> --}}
                    </p>
                </a>
            </li>
            {{-- Divisa --}}
            <li class="nav-item">
              <a href="{{ route('divisa.index') }}" class="nav-link {{ setActiveNavDrop('divisa.index') }}">
                <i class="nav-icon fas fa-money-bill-alt"></i>
                <p>
                  Divisa
                  {{-- <span class="right badge badge-success">{{ number_format($divisa_p, 2, ',','.') }}</span> --}}
                </p>
              </a>
            </li>
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item has-treeview {{ setActiveNavDrop(['categorias.index','productos.index']) }}">
            <a href="#" class="nav-link {{ setActiveRoute(['categorias.index','productos.index']) }}">
              <i class="nav-icon fas fa-boxes"></i>
              <p>
                Almacén
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('categorias.index') }}" class="nav-link {{ setActiveRoute('categorias.index') }}">
                  <i class="nav-icon fas fa-tags"></i>
                  <p>Categorias</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('productos.index')}}" class="nav-link {{ setActiveRoute('productos.index') }}">
                  <i class="nav-icon fas fa-box"></i>
                  <p>Productos</p>
                </a>
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
                <a href="{{ route('ingresos.index') }}" class="nav-link {{ setActiveRoute('ingresos.index') }}">
                  <i class="nav-icon fas fa-piggy-bank"></i>
                  <p>Ingresos</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('proveedores.index')}}" class="nav-link {{ setActiveRoute('proveedores.index') }}">
                  <i class="nav-icon fas fa-industry"></i>
                  <p>Proveedores</p>
                </a>
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
                <a href="{{ route('ventas.index') }}" class="nav-link {{ setActiveRoute('ventas.index') }}">
                  <i class="nav-icon fas fa-cash-register"></i>
                  <p>Ventas</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('clientes.index')}}" class="nav-link {{ setActiveRoute('clientes.index') }}">
                  <i class="nav-icon fas fa-user-tie"></i>
                  <p>Clientes</p>
                </a>
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
                <a href="{{ route('categorias.index') }}" class="nav-link">
                  <i class="nav-icon fas fa-users"></i>
                  <p>Usurios</p>
                </a>
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