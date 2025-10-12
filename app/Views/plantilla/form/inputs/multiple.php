<div class="form-group position-relative">
    <?= view('plantilla/form/partials/label', ['ins' => $ins]) ?>
    <select name="<?= $ins['name'] ?>[]"
            id="<?= $ins['name'] ?>"
            class="form-select"
            multiple
            <?= $ins['requerido'] ? 'required' : '' ?>>
        <?php foreach ($ins['option'] as $opt): ?>
            <option value="<?= $opt['value'] ?>" <?= $opt['selected'] ? 'selected' : '' ?>>
                <?= $opt['text'] ?>
            </option>
        <?php endforeach; ?>
    </select>
</div>
