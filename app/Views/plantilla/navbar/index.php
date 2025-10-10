<!--begin::Container-->
<div class="container-fluid">
  <!--begin::Start Navbar Links-->
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
        <i class="bi bi-list"></i>
      </a>
    </li>
    <!-- <li class="nav-item d-none d-md-block"><a href="#" class="nav-link">Home</a></li>
    <li class="nav-item d-none d-md-block"><a href="#" class="nav-link">Contact</a></li> -->
  </ul>
  <!--end::Start Navbar Links-->
  <!--begin::End Navbar Links-->
  <ul class="navbar-nav ms-auto">
    <!--begin::Notifications Dropdown Menu-->
    <li class="nav-item dropdown">
      <a class="nav-link" data-bs-toggle="dropdown" href="#">
        <i class="bi bi-bell-fill"></i>
        <span class="navbar-badge badge text-bg-warning">1</span>
      </a>
      <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
        <span class="dropdown-item dropdown-header">1 Notifications</span>
        <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item">
          <i class="bi bi-envelope me-2"></i> 4 new messages
          <span class="float-end text-secondary fs-7">3 mins</span>
        </a>
        <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item dropdown-footer"> See All Notifications </a>
      </div>
    </li>
    <!--end::Notifications Dropdown Menu-->
    <!--begin::User-->
    <!-- <li class="nav-item  user-menu">
      <label class="navbar-text">
        <img
          src="<?= base_url() ?>assets/img/user.png"
          class="user-image rounded-circle ms-2"
          alt="Foto <?= session('usuario')['usuario'] ?>"
        />
        <span class="d-none d-md-inline"><?= session('usuario')['usuario'] ?></span>
      </label>
    </li> -->
    <!--end::User-->
    <li class="nav-item cerrar-sesion-icon-nav" title="Cerrar sesión">
      <a class="nav-link d-flex flex-column justify-content-center align-items-center" href="<?= base_url(route_to('salir')) ?>" role="button">
        <i class="bi bi-box-arrow-right"></i>
        <p class="py-0 my-0">
          Cerrar sesión
        </p>
      </a>
    </li>
  </ul>
  <!--end::End Navbar Links-->
</div>
<!--end::Container-->