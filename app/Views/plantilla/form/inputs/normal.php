<label for="<?= htmlspecialchars($ins['name']) ?>" class="control-label">
    <?= htmlspecialchars($ins['title']) ?>
    <?php if (!empty($ins['requerido'])): ?>
        <small id="asterisco-requerido-<?= htmlspecialchars($ins['name']) ?>" class="asterisco-danger text-danger">*</small>
    <?php endif; ?>
</label>

<div class="position-relative group-b-4 pass-block">
    <input 
        <?= $ins['type'] === 'password' ? 'data-eye' : '' ?>
        placeholder="<?= isset($ins['placeholder']) ? htmlspecialchars($ins['placeholder']) : '' ?>"
        autocomplete="off"
        type="<?= htmlspecialchars($ins['type']) ?>"
        name="<?= htmlspecialchars($ins['name']) ?>"
        value="<?= isset($ins['value']) ? htmlspecialchars($ins['value']) : '' ?>"
        <?= !empty($ins['requerido']) ? 'required' : '' ?>
        id="<?= htmlspecialchars($ins['name']) ?>"
        maxlength="<?= isset($ins['max']) ? intval($ins['max']) : '' ?>"
        class="form-control shadow-none"
    >
    <div id="caracteres_<?= htmlspecialchars($ins['name']) ?>" class="form-text txaCount"></div>
</div>
<datalist id="<?= htmlspecialchars($ins['name']) ?>_list"></datalist>