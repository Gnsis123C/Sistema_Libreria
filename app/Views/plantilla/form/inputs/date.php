<div class="form-group position-relative">
    <?= view('plantilla/form/partials/label', ['ins' => $ins]) ?>
    <input type="date"
           name="<?= $ins['name'] ?>"
           id="<?= $ins['name'] ?>"
           class="form-control"
           value="<?= $ins['value'] ?? '' ?>"
           <?= $ins['requerido'] ? 'required' : '' ?>>
</div>
