<div class="d-flex align-items-center">
  <button class="btn btn-link mobile-toggle me-3" onclick="toggleSidebar()">
    <i class="fas fa-bars"></i>
  </button>
</div>
<div class="user-info">
  <!-- Ejemplo adicional: Solo icono con badge -->
  <div class="dropdown ms-3 d-inline-block me-3">
    <button class="btn btn-light dropdown-toggle-split notification-badge disabled" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="border: none;">
      <i class="fas fa-bell fs-5"></i>
      <span class="notification-count">1</span>
    </button>

    <ul class="dropdown-menu notification-dropdown p-0">
      <li>
        <div class="dropdown-header dropdown-header-custom p-3">
          <i class="fas fa-bell me-2"></i>
          Notificaciones
        </div>
      </li>

      <li class="notification-item unread">
        <div class="dropdown-item-text p-3">
          <div class="d-flex align-items-center">
            <div class="notification-icon bg-danger me-3">
              <i class="fas fa-exclamation"></i>
            </div>
            <div class="flex-grow-1">
              <div class="fw-semibold">Alerta de seguridad</div>
              <div class="text-muted small">Nuevo inicio de sesión detectado</div>
            </div>
          </div>
        </div>
      </li>

      <li class="notification-item">
        <div class="dropdown-item-text p-3">
          <div class="d-flex align-items-center">
            <div class="notification-icon bg-success me-3">
              <i class="fas fa-check"></i>
            </div>
            <div class="flex-grow-1">
              <div class="fw-semibold">Tarea completada</div>
              <div class="text-muted small">Backup realizado con éxito</div>
            </div>
          </div>
        </div>
      </li>

      <li>
        <hr class="dropdown-divider m-0">
      </li>

      <li>
        <a class="dropdown-item dropdown-footer text-center py-2" href="#">
          Ver todo
        </a>
      </li>
    </ul>
  </div>
  <div class="text-end me-2 d-flex flex-column gap-0">
    <div class="fw-semibold">
      Hola :), Bienvenido, <span class="text-primary"><?= session('usuario')['nombre'] ?></span>
    </div>
    <small class="text-muted"><?= session('usuario')['email'] ?></small>

  </div>
  <a class="btn btn-success btn-sm" title="Cerrar sesión" href="<?= base_url(route_to("salir")) ?>">
    <i class="fas fa-sign-out-alt"></i>
  </a>
</div>