<div class="form-group position-relative">
    <?= view('plantilla/form/partials/label', ['ins' => $ins]) ?>
    <input type="text"
           name="<?= $ins['name'] ?>"
           id="<?= $ins['name'] ?>"
           class="form-control"
           maxlength="<?= $ins['max'] ?? '' ?>"
           value="<?= $ins['value'] ?? '' ?>"
           placeholder="<?= $ins['placeholder'] ?? '' ?>"
           <?= $ins['requerido'] ? 'required' : '' ?>>
</div>
