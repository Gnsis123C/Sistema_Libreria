<div class="form-group position-relative">
    <?= view('plantilla/form/partials/label', ['ins' => $ins]) ?>
    <input type="color"
           name="<?= $ins['name'] ?>"
           id="<?= $ins['name'] ?>"
           class="form-control"
           value="<?= $ins['value'] ?? '#000000' ?>"
           <?= $ins['requerido'] ? 'required' : '' ?>>
</div>
