<?= $this->extend('plantilla/layout') ?>

<?= $this->section('titulo') ?>
<?= $pagina ?>
<?= $this->endSection() ?>

<?= $this->section('css') ?>

<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="mb-4">
  <h1 class="display-6 fw-bold mb-2 text-dark">Panel de Administración</h1>
  <p class="text-muted h6 fw-light">Resumen general de la plataforma y métricas clave</p>
</div>
<!--begin::Row-->
<div class="row">
  <div class="col-12 col-sm-6 col-lg-3 px-sm-2 p-1">
    <div class="card card-metric card-shadow-dashboard">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-start">
          <div>
            <div class="metric-value">$12,458</div>
            <div class="metric-label">Ventas Hoy</div>
            <div class="metric-trend trend-up">
              <i class="fas fa-arrow-up"></i> 12.5%
            </div>
          </div>
          <div class="metric-icon icon-sales">
            <i class="fas fa-dollar-sign"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-12 col-sm-6 col-lg-3 px-sm-2 p-1">
    <div class="card card-metric card-shadow-dashboard">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-start">
          <div>
            <div class="metric-value">$12,458</div>
            <div class="metric-label">Ventas Hoy</div>
            <div class="metric-trend trend-up">
              <i class="fas fa-arrow-up"></i> 12.5%
            </div>
          </div>
          <div class="metric-icon icon-sales">
            <i class="fas fa-dollar-sign"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-12 col-sm-6 col-lg-3 px-sm-2 p-1">
    <div class="card card-metric card-shadow-dashboard">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-start">
          <div>
            <div class="metric-value">$12,458</div>
            <div class="metric-label">Ventas Hoy</div>
            <div class="metric-trend trend-up">
              <i class="fas fa-arrow-up"></i> 12.5%
            </div>
          </div>
          <div class="metric-icon icon-sales">
            <i class="fas fa-dollar-sign"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-12 col-sm-6 col-lg-3 px-sm-2 p-1">
    <div class="card card-metric card-shadow-dashboard">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-start">
          <div>
            <div class="metric-value">$12,458</div>
            <div class="metric-label">Ventas Hoy</div>
            <div class="metric-trend trend-up">
              <i class="fas fa-arrow-up"></i> 12.5%
            </div>
          </div>
          <div class="metric-icon icon-sales">
            <i class="fas fa-dollar-sign"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-12 col-sm-12 col-lg-12 pt-2">
    <div class="card card-metric card-shadow-dashboard" style="height: 500px;">
      <div class="card-body">
        
      </div>
    </div>
  </div>
</div>
<!--end::Row-->
<?= $this->endSection() ?>

<?= $this->section('script') ?>

<script type="text/javascript">
</script>

<?= $this->endSection() ?>