<div class="form-group position-relative">
    <?= view('plantilla/form/partials/label', ['ins' => $ins]) ?>
    <div class="input-daterange input-group">
        <input type="date"
               name="<?= $ins['data'][0]['name'] ?>"
               value="<?= $ins['data'][0]['value'] ?>"
               class="form-control"
               required>
        <span class="input-group-text">Hasta</span>
        <input type="date"
               name="<?= $ins['data'][1]['name'] ?>"
               value="<?= $ins['data'][1]['value'] ?>"
               class="form-control"
               required>
    </div>
</div>
