<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

  <title><?= $this->renderSection('titulo') ?></title>
  <link rel="stylesheet" href="<?= base_url("assets/scss/custom.css") ?>">
  <link rel="apple-touch-icon" sizes="180x180" href="<?= base_url('assets/img/icon') ?>/apple-icon.png?v=2">
  <link rel="icon" type="image/png" sizes="32x32" href="<?= base_url('assets/img/icon') ?>/favicon-32x32.png?v=2">
  <link rel="icon" type="image/png" sizes="16x16" href="<?= base_url('assets/img/icon') ?>/favicon-16x16.png?v=2">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <link rel="stylesheet" href="<?= base_url("assets/admin.css?v=0.0.9") ?>">
  <link rel="stylesheet" href="<?= base_url("assets/plugins/toastr/toastr.css") ?>" />

  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="<?= base_url("assets/regular-icon-font-free/css/icons.css") ?>">
  <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200;300;400;500;600;700;800&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
  <style>
    .dropdown-header {
      --bs-dropdown-header-padding-y: 2px;
    }

    .has-error i,
    .has-error small {
      color: #d80d18;
      font-size: 10px;
    }

    .has-success i {
      display: none;
    }

    @keyframes spin {
      from {
        transform: rotate(0deg);
      }

      to {
        transform: rotate(360deg);
      }
    }

    .bi-spin {
      animation-name: spin;
      animation-duration: 1500ms;
      animation-iteration-count: infinite;
      animation-timing-function: linear;
      width: 20px;
      height: 20px;
      display: block;
      line-height: 1.4;
      /* background: red; */
      text-align: center;
    }

    .form-control-feedback.bi-arrow-repeat {
      position: absolute;
      top: 38px;
      color: #111827;
      right: 12px;
    }

    /* .actions-filters-custom{
                display: flex;
                justify-content: flex-end;
            } */

    .notification-dropdown {
      width: 350px;
    }

    .notification-item {
      border-bottom: 1px solid #e9ecef;
      transition: background-color 0.2s;
    }

    .notification-item:hover {
      background-color: #f8f9fa;
    }

    .notification-item:last-child {
      border-bottom: none;
    }

    .notification-badge {
      position: relative;
    }

    .notification-count {
      position: absolute;
      top: -8px;
      right: -8px;
      background-color: #dc3545;
      color: white;
      font-size: 10px;
      padding: 2px 6px;
      border-radius: 50%;
      min-width: 18px;
      text-align: center;
    }

    .notification-icon {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 16px;
      color: white;
    }

    .notification-time {
      font-size: 11px;
      color: #6c757d;
    }

    .unread {
      background-color: #e3f2fd !important;
      border-left: 3px solid #2196f3;
    }

    .dropdown-header-custom {
      background-color: #495057;
      color: white;
      font-weight: 600;
      border-radius: 0;
      margin-bottom: 0;
    }

    .dropdown-footer {
      background-color: #f8f9fa;
      border-top: 1px solid #e9ecef;
      text-align: center;
      font-size: 14px;
    }

    .dropdown-footer:hover {
      background-color: #e9ecef;
    }

    .dropdown-header {
      --bs-dropdown-header-padding-y: 2px;
    }

    .has-error i,
    .has-error small {
      color: #d80d18;
      font-size: 10px;
    }

    .has-success i {
      display: none;
    }

    @keyframes spin {
      from {
        transform: rotate(0deg);
      }

      to {
        transform: rotate(360deg);
      }
    }

    .bi-spin {
      animation-name: spin;
      animation-duration: 1500ms;
      animation-iteration-count: infinite;
      animation-timing-function: linear;
      width: 20px;
      height: 20px;
      display: block;
      line-height: 1.4;
      /* background: red; */
      text-align: center;
    }

    .form-control-feedback.bi-arrow-repeat {
      position: absolute;
      top: 38px;
      color: #111827;
      right: 12px;
    }

    .form-group.has-error input {
      border-color: var(--color-error);
    }

    .form-group.has-error i[data-fv-icon-for] {
      position: absolute;
      right: 9px;
      top: calc(44px - 10%);
      font-size: 15px;
    }
  </style>
  <style>
    .img-logo-empresa.rounded {
      width: 40px;
      height: 40px;
      object-fit: cover;
    }

    .nav-tabs .nav-link.active {
        background-color: #fff;
        border-bottom-width: 0px;
    }
    .items-menu-nav .nav-link.active::after {
        border-top-right-radius: 1rem;
    }

    .items-menu-nav .nav-link.active::before {
        border-bottom-right-radius: 1rem;
    }

    .items-menu-nav {
  max-height: calc(100vh - 160px);
  overflow-y: auto;
  overflow-x: hidden;
  /* Transición suave para el efecto de desvanecimiento (opcional) */
  transition: opacity 0.2s;
}

/* Ocultar scrollbar en WebKit (Chrome, Safari, Edge) */
.items-menu-nav.hide-scrollbar::-webkit-scrollbar {
  width: 0 !important;
  background: transparent;
}

/* Ocultar en Firefox */
.items-menu-nav.hide-scrollbar {
  scrollbar-width: none; /* 'none' oculta la barra visualmente en Firefox */
}
  </style>
  <?= $this->renderSection('css') ?>

</head>

<body id="admin_cr" class="gnsis-theme-light">
  <!--begin::Header-->
  <nav class="sidebar" id="sidebar">
    <?= $this->include('plantilla/navbar/index') ?>
  </nav>
  <!--end::Header-->
  <div class="main-content">

    <!--begin::header-->
    <header class="header d-flex justify-content-between align-items-center m-4 mt-0 mb-3 border-0 rounded-4">
      <?= $this->include('plantilla/sidebar/index') ?>
    </header>
    <!--end::header-->

    <!--begin::App Main-->
    <div class="content-gnsis p-4 pt-2">
      <?= $this->include('plantilla/content/index') ?>
    </div>
    <!--end::App Main-->

    <!--begin::Footer-->
    <!-- <footer class="fixed-bottom text-left py-3">
                
            </footer> -->
    <!--end::Footer-->
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="<?= base_url('assets/jquery-3.7.1.min.js') ?>"></script>
  <script src="<?= base_url("assets/plugins/sweetalert2/sweetalert2@11.js") ?>"></script>
  <script src="<?= base_url("assets/plugins/toastr/toastr.min.js") ?>"></script>
  <script src="<?= base_url("assets/plugins/moment/moment.min.js") ?>"></script>
  <script src="<?= base_url("assets/plugins/moment/locale/es.js") ?>"></script>
  <!-- End Javascripts -->
  <?= $this->renderSection('script') ?>
  <script>
    // Selecciona el contenedor
const scrollContainer = document.querySelector('.items-menu-nav');

if (scrollContainer) {
  let hideTimer;

  const showScrollbar = () => {
    scrollContainer.classList.remove('hide-scrollbar');
  };

  const hideScrollbar = () => {
    scrollContainer.classList.add('hide-scrollbar');
  };

  // Mostrar al hacer scroll
  scrollContainer.addEventListener('scroll', () => {
    showScrollbar();
    clearTimeout(hideTimer);
    hideTimer = setTimeout(hideScrollbar, 2000); // 2 segundos
  });

  // Opcional: mostrar al mover el mouse dentro del contenedor (mejora UX)
  scrollContainer.addEventListener('mouseenter', () => {
    showScrollbar();
    clearTimeout(hideTimer);
  });

  scrollContainer.addEventListener('mouseleave', () => {
    hideTimer = setTimeout(hideScrollbar, 2000);
  });
}
    // Toggle sidebar for mobile
    function toggleSidebar() {
      document.getElementById('sidebar').classList.toggle('show');
    }



    // Navigation active state
    // document.querySelectorAll('.sidebar .nav-link').forEach(link => {
    //     link.addEventListener('click', function(e) {
    //         e.preventDefault();
    //         document.querySelectorAll('.sidebar .nav-link').forEach(l => l.classList.remove('active'));
    //         this.classList.add('active');
    //     });
    // });
  </script>
  <script>
    const SELECTOR_SIDEBAR_WRAPPER = '.sidebar-wrapper';
    const Default = {
      scrollbarTheme: 'os-theme-light',
      scrollbarAutoHide: 'leave',
      scrollbarClickScroll: true,
    };
    document.addEventListener('DOMContentLoaded', function() {
      const sidebarWrapper = document.querySelector(SELECTOR_SIDEBAR_WRAPPER);
      if (sidebarWrapper && typeof OverlayScrollbarsGlobal?.OverlayScrollbars !== 'undefined') {
        OverlayScrollbarsGlobal.OverlayScrollbars(sidebarWrapper, {
          scrollbars: {
            theme: Default.scrollbarTheme,
            autoHide: Default.scrollbarAutoHide,
            clickScroll: Default.scrollbarClickScroll,
          },
        });
      }
    });
  </script>
</body>

</html>