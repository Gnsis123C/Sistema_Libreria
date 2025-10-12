<div class="form-group position-relative">
    <?= view('plantilla/form/partials/label', ['ins' => $ins]) ?>
    <input type="text"
           readonly
           class="form-control"
           value="<?= $ins['value'] ?? '' ?>">
</div>
