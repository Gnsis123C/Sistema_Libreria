<label for="<?= $ins['name'] ?>" class="form-label">
    <?= $ins['title'] ?>
    <?php if (!empty($ins['requerido']) && $ins['requerido']): ?>
        <small class="text-danger">*</small>
    <?php endif; ?>
</label>
