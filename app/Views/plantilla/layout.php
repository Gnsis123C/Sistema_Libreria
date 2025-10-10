<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0"> 

        <title><?= $this->renderSection('titulo') ?></title>
        <link rel="icon" type="image/png" href="<?= base_url('assets/img/icon') ?>/favicon-32x32.png">
        <!--begin::Fonts-->
        <link
          rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css"
          integrity="sha256-tXJfXfp6Ewt1ilPzLDtQnJV4hclT9XuaZUKyUvmyr+Q="
          crossorigin="anonymous"
        />
        <!--end::Fonts-->
        <!--begin::Third Party Plugin(OverlayScrollbars)-->
        <link
          rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.10.1/styles/overlayscrollbars.min.css"
          integrity="sha256-tZHrRjVqNSRyWg2wbppGnT833E/Ys0DHWGwT04GiqQg="
          crossorigin="anonymous"
        />
        <!--end::Third Party Plugin(OverlayScrollbars)-->
        <!--begin::Third Party Plugin(Bootstrap Icons)-->
        <link
          rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
          integrity="sha256-9kPW/n5nn53j4WMRYAxe9c1rCY96Oogo/MKSVdKzPmI="
          crossorigin="anonymous"
        />
        <!--end::Third Party Plugin(Bootstrap Icons)-->
        <!--begin::Required Plugin(AdminLTE)-->
        <link rel="stylesheet" href="<?= base_url("/assets/admin/dist/css/adminlte.css") ?>" />

        <link rel="stylesheet" href="<?= base_url("/assets/plugins/toastr/toastr.css") ?>" />
        
        <!--end::Required Plugin(AdminLTE)-->

        <?= $this->renderSection('css') ?>

        <style type="text/css">
            .p-size-menu-email{
                font-size: 10px;
                line-height: 1;
                font-weight: 300;
            }

            .cerrar-sesion-icon-nav p{
                font-size: 10px;
                line-height: 1;
                font-weight: 300;
            }

            .bg-body-cr-red{
                --bs-bg-opacity: 1;
                background-color: rgba(118, 3, 0, var(--bs-bg-opacity)) !important;
            }

            [data-bs-theme=dark]{
                --bs-border-color: #fff;
            }

            .sidebar-brand{

            }

            @keyframes spin {
                from {
                    transform:rotate(0deg);
                }
                to {
                    transform:rotate(360deg);
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

            .form-control-feedback {
                position: absolute;
                z-index: 1;
                right: 10px;
                top: 8px;
            }

            .has-error .fv-bootstrap-icon-no-label,
            .has-error small[data-fv-result="INVALID"] {
                color: rgba(118, 3, 0, var(--bs-bg-opacity));
            }

            .fv-form-bootstrap .fv-bootstrap-icon-no-label {
                top: 8px;
            }

        </style>

    </head>

    <body class="sidebar-expand-lg bg-light" id="admin_cr">
        <div class="app-wrapper">
            <!--begin::Header-->
            <nav class="app-header navbar navbar-expand bg-body">
                <?= $this->include('plantilla/navbar/index') ?>
            </nav>
            <!--end::Header-->
            
            <!--begin::Sidebar-->
            <aside class="app-sidebar bg-body-cr-red shadow" data-bs-theme="dark">
                <?= $this->include('plantilla/sidebar/index') ?>
            </aside>
            <!--end::Sidebar-->

            <!--begin::App Main-->
            <main class="app-main">
                <?= $this->include('plantilla/content/index') ?>
            </main>
            <!--end::App Main-->

            <!--begin::Footer-->
            <footer class="app-footer">
                <?= $this->include('plantilla/footer/index') ?>
            </footer>
            <!--end::Footer-->
            
            <!-- Control Sidebar -->
            <aside class="control-sidebar control-sidebar-dark">
              <!-- Control sidebar content goes here -->
            </aside>
            <!-- /.control-sidebar -->
        </div>

        <script
          src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.10.1/browser/overlayscrollbars.browser.es6.min.js"
          integrity="sha256-dghWARbRe2eLlIJ56wNB+b760ywulqK3DzZYEpsg2fQ="
          crossorigin="anonymous"
        ></script>
        <!--end::Third Party Plugin(OverlayScrollbars)--><!--begin::Required Plugin(popperjs for Bootstrap 5)-->
        <script
          src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
          integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
          crossorigin="anonymous"
        ></script>
        <!--end::Required Plugin(popperjs for Bootstrap 5)--><!--begin::Required Plugin(Bootstrap 5)-->
        <script
          src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
          integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
          crossorigin="anonymous"
        ></script>
        <!--end::Required Plugin(Bootstrap 5)--><!--begin::Required Plugin(AdminLTE)-->
        <script src="<?= base_url("/assets/admin/dist/js/adminlte.js") ?>"></script>

        <script src="<?= base_url('assets/jquery-3.7.1.min.js') ?>"></script>

        <script src="<?= base_url("/assets/plugins/sweetalert2/sweetalert2@11.js") ?>"></script> 
        <script src="<?= base_url("/assets/plugins/toastr/toastr.min.js") ?>"></script>
        <!-- End Javascripts -->
        <?= $this->renderSection('script') ?>
        <script>
          const SELECTOR_SIDEBAR_WRAPPER = '.sidebar-wrapper';
          const Default = {
            scrollbarTheme: 'os-theme-light',
            scrollbarAutoHide: 'leave',
            scrollbarClickScroll: true,
          };
          document.addEventListener('DOMContentLoaded', function () {
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
        <script type="text/javascript">
            // window.onload = function() { 
            //     var all_links = document.getElementById("test-nav-ul").getElementsByTagName("a"),
            //         i=0, len=all_links.length,
            //         full_path = location.href.split('#')[0]; //Ignore hashes?

            //     for(i=0; i<len; i++) {
            //         if(all_links[i].href.split("#")[0] == full_path && (all_links[i].href.split("#")).length < 2) {
            //             all_links[i].className += " active";
            //         }
            //     }
            // }
            // $(function(){
            //     $(document).on('show.bs.modal', '.modal', function() {
            //       const zIndex = 1040 + 10 * $('.modal:visible').length;
            //       $(this).css('z-index', zIndex);
            //       setTimeout(() => $('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).addClass('modal-stack'));
            //     });
            // })
        </script>
    </body>

</html>