<div class="form-group position-relative">
    <?= view('plantilla/form/partials/label', ['ins' => $ins]) ?>
    <textarea name="<?= $ins['name'] ?>"
              id="<?= $ins['name'] ?>"
              class="form-control"
              rows="4"
              maxlength="<?= $ins['max'] ?? '' ?>"
              <?= $ins['requerido'] ? 'required' : '' ?>><?= $ins['value'] ?? '' ?></textarea>
</div>
