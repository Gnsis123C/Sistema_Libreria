<?= $this->extend('plantilla/layout') ?>

<?= $this->section('titulo') ?> 
    <?= $pagina ?> | <?= $titulo ?> <?= json_encode(session('usuario')['usuario']) ?>
<?= $this->endSection() ?>

<?= $this->section('css') ?>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.0/css/responsive.bootstrap4.min.css">
    <style type="text/css">
        .table.dataTable thead .sorting_desc,
        .table.dataTable thead .sorting_asc,
        .table.dataTable thead .sorting {
          background: none;
        }
        .btn-action{
            width: 12%;
            text-align: center;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            padding: 0px !important;
            border: 0px !important;
        }
        .gradeA.estado{
            min-width: 65px!important;
            width: 65px!important;
        }
    </style> 
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<!--begin::Row-->
<div class="row">
  <div class="col-12 px-0 px-sm-3">
    <!-- Default box -->
    <div class="card shadow-none">
      <div class="card-header">
        <h3 class="card-title"><i class="bi bi-exclamation-triangle-fill"></i> Espacio en mantenimiento</h3>
        <!-- <div class="card-tools">
          <button
            type="button"
            class="btn btn-tool"
            data-lte-toggle="card-collapse"
            title="Collapse"
          >
            <i data-lte-icon="expand" class="bi bi-plus-lg"></i>
            <i data-lte-icon="collapse" class="bi bi-dash-lg"></i>
          </button>
          <button
            type="button"
            class="btn btn-tool"
            data-lte-toggle="card-remove"
            title="Remove"
          >
            <i class="bi bi-x-lg"></i>
          </button>
        </div> -->
      </div>
      <div class="card-body"><i class="bi bi-exclamation-triangle-fill"></i> Espacio en mantenimiento</div>
      <!-- /.card-body -->
      <!-- <div class="card-footer">Footer</div> -->
      <!-- /.card-footer-->
    </div>
    <!-- /.card -->
  </div>
</div>
<!--end::Row-->
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<!-- Responsive examples -->
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script> 
<script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.4.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.4.0/js/responsive.bootstrap4.min.js"></script>

<script type="text/javascript">
    
</script>

<?= $this->endSection() ?>