<div class="logo p-2">
    <h4>
      <div class="text-center">
        <img src="<?= base_url(session('empresa')['logo']) ?>" class="img-logo-empresa rounded" alt="Logo" width="100" height="100">
      </div>
    </h4>
</div>
<ul class="nav flex-column flex-nowrap items-menu-nav ps-5 py-5 pt-4">
  <?php 
      $menuTemp = getMenu($pagina);
  ?>
  <?php foreach ($menuTemp as $key => $item) { ?>
      <?php if($item['tipo'] == 'header' && $item['tipo_text'] != ''){ ?>
          <li class="nav-item mb-2 mt-2" title="<?= $item['tipo_text_title'] ?>">
            <?= $item['tipo_text'] ?>
          </li>
      <?php } ?>
      <?php foreach ($item['data'] as $key2 => $subitem) { ?>
          <li class="nav-item">
              <a href="<?= $subitem['link'] ?>" class="nav-link <?= $pagina == $subitem['pagina'] ? 'active' : '' ?> <?= $item['tipo'] == 'header' ? '' : '' ?>">
                  <i class="lni lni-<?= $subitem['icon'] ?>"></i>
                  <?= $subitem['titulo'] ?>
              </a>
          </li>
      <?php } ?>
  <?php } ?>
<!-- <span class="badge text-dark bg-white ms-2">1</span> -->

  <!-- <li class="nav-item">
    <a class="nav-link <?= $pagina == 'inicio' ? 'active' : '' ?>" href="<?= base_url() ?>">

      <i class="lni lni-home-2"></i>Inicio
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link <?= $pagina == 'empresa' ? 'active' : '' ?>" href="<?= base_url(route_to('empresa')) ?>">
      <i class="lni lni-buildings-1"></i>Empresa
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link <?= $pagina == 'usuario' ? 'active' : '' ?>" href="<?= base_url(route_to('usuario')) ?>">
      <i class="lni lni-user-multiple-4"></i>Usuarios
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link <?= $pagina == 'rol' ? 'active' : '' ?>" href="<?= base_url(route_to('rol')) ?>">
      <i class="lni lni-gear-1"></i>Roles y accesos
      
    </a>
  </li>
  <li class="nav-item mb-2 mt-2" title="Administración de productos">
    Admin. Productos
  </li>
  
  <li class="nav-item">
    <a class="nav-link <?= $pagina == 'categoria' ? 'active' : '' ?>" href="<?= base_url(route_to('categoria')) ?>">
      <i class="lni lni-brush-1-rotated"></i>Categoría
    </a>
  </li> -->
</ul>
<ul class="nav flex-column position-absolute w-100 bottom-0">
  <li class="nav-item mt-auto border-top">
    <a class="nav-link text-dark-2 fw-normal" href="<?= base_url(route_to("salir")) ?>">
      <i class="fas fa-sign-out-alt"></i>Cerrar Sesión
    </a>
  </li>
</ul>