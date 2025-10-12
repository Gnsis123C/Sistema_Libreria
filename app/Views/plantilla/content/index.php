<!--begin::App Content Header-->
<div class="app-content-header">
  <!--begin::Container-->
  <div class="container-fluid">
    <!--begin::Row-->
    <div class="row">
      <div class="col-sm-6 px-0 px-sm-3">
        <h3 class="mb-0"><?= $titulo ?></h3>
      </div>
      <div class="col-sm-6 px-0 px-sm-3">
        <ol class="breadcrumb float-sm-end">
            <?php for ($i = 0; $i < count($breadcrumb); $i++) { ?>
                <?php $ins = $breadcrumb[$i]; ?>
                <li class="breadcrumb-item <?= ((count($breadcrumb)-1)==$i?'active':'') ?>">
                    <a href="<?= $ins['url'] ?>">
                        <?= $ins['name'] ?>
                    </a>
                </li>
                <?php ?>
            <?php } ?>
        </ol>
        <!-- <ol class="breadcrumb float-sm-end">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active" aria-current="page">Unfixed Layout</li>
        </ol> -->
      </div>
    </div>
    <!--end::Row-->
  </div>
  <!--end::Container-->
</div>
<!--end::App Content Header-->
<!--begin::App Content-->
<div class="app-content">
  <!--begin::Container-->
  <div class="container-fluid">
    <?= $this->renderSection('content') ?>
  </div>
</div>
<!--end::App Content-->