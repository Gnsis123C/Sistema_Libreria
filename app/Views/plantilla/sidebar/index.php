<!--begin::Sidebar Brand-->
<div class="sidebar-brand">
  <!--begin::Brand Link-->
  <a href="<?= base_url(route_to('inicio')) ?>" class="brand-link">
    <!--begin::Brand Image-->
    <img
      src="<?= base_url() ?>uploads/img/<?= session('usuario')['usuario'] ?>/<?= session('empresa')['logo'] ?>"
      alt="Logo <?= session('usuario')['usuario'] ?>"
      class="brand-image opacity-75 shadow"
    />
    <!--end::Brand Image-->
    <!--begin::Brand Text-->
    <span class="brand-text fw-light d-flex flex-column gap-0">
      <?= session('usuario')['usuario'] ?>
      <p class="p-size-menu-email pt-0 pb-0 my-0">
        <?= session('usuario')['email'] ?>
      </p>
    </span>
    <!--end::Brand Text-->
  </a>
  <!--end::Brand Link-->
</div>
<!--end::Sidebar Brand-->

<!--begin::Sidebar Wrapper-->
<div class="sidebar-wrapper">
  <nav class="mt-2">
    <!--begin::Sidebar Menu-->
        <ul
          class="nav sidebar-menu flex-column"
          data-lte-toggle="treeview"
          role="menu"
          data-accordion="false"
            >
          <li class="nav-item">
            <a href="<?= base_url(route_to('inicio')) ?>" class="nav-link <?= $pagina == "inicio" ? "active": "" ?>">
              <i class="nav-icon bi bi-house-door-fill"></i>
              <p>Inicio</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?= base_url(route_to('empresa')) ?>" class="nav-link <?= $pagina == "empresa" ? "active": "" ?>">
              <i class="nav-icon bi bi-list-columns"></i>
              <p>Empresas</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?= base_url(route_to('cliente')) ?>" class="nav-link <?= $pagina == "cliente" ? "active": "" ?>">
              <i class="nav-icon bi bi-people"></i>
              <p>Clientes/Proveedores</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?= base_url(route_to('categoria')) ?>" class="nav-link <?= $pagina == "categoria" ? "active": "" ?>">
              <i class="nav-icon bi bi-bezier"></i>
              <p>Categorias</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?= base_url(route_to('atributo')) ?>" class="nav-link <?= $pagina == "atributo" ? "active": "" ?>">
              <i class="nav-icon bi bi-bezier"></i>
              <p>Atributos</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?= base_url(route_to('producto')) ?>" class="nav-link <?= $pagina == "producto" ? "active": "" ?>">
              <i class="nav-icon bi bi-basket2"></i>
              <p>Productos</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?= base_url(route_to('compra')) ?>" class="nav-link <?= $pagina == "compra" ? "active": "" ?>">
              <i class="nav-icon bi bi-currency-dollar"></i>
              <p>Compras</p>
            </a>
          </li>
          <li class="nav-item d-none">
            <a href="#" class="nav-link">
              <i class="nav-icon bi bi-clipboard-fill"></i>
              <p>
                Layout Options
                <span class="nav-badge badge text-bg-secondary me-3">6</span>
                <i class="nav-arrow bi bi-chevron-right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="../layout/unfixed-sidebar.html" class="nav-link">
                  <i class="nav-icon bi bi-circle"></i>
                  <p>Default Sidebar</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="../layout/fixed-sidebar.html" class="nav-link">
                  <i class="nav-icon bi bi-circle"></i>
                  <p>Fixed Sidebar</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="../layout/layout-custom-area.html" class="nav-link">
                  <i class="nav-icon bi bi-circle"></i>
                  <p>Layout <small>+ Custom Area </small></p>
                </a>
              </li>
              <li class="nav-item">
                <a href="../layout/sidebar-mini.html" class="nav-link">
                  <i class="nav-icon bi bi-circle"></i>
                  <p>Sidebar Mini</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="../layout/collapsed-sidebar.html" class="nav-link">
                  <i class="nav-icon bi bi-circle"></i>
                  <p>Sidebar Mini <small>+ Collapsed</small></p>
                </a>
              </li>
              <li class="nav-item">
                <a href="../layout/logo-switch.html" class="nav-link">
                  <i class="nav-icon bi bi-circle"></i>
                  <p>Sidebar Mini <small>+ Logo Switch</small></p>
                </a>
              </li>
              <li class="nav-item">
                <a href="../layout/layout-rtl.html" class="nav-link">
                  <i class="nav-icon bi bi-circle"></i>
                  <p>Layout RTL</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-header">Salir del sistema</li>
          <li class="nav-item">
            <a href="<?= base_url(route_to('salir')) ?>" class="nav-link">
              <i class="nav-icon bi bi-box-arrow-right"></i>
              <p>Cerrar sesión</p>
            </a>
          </li>
    </ul>
    <!--end::Sidebar Menu-->
  </nav>
    </div>
    <!--end::Sidebar Wrapper-->
              