<div class="form-group position-relative">
    <?php
    // Variables sanitizadas
    $name = htmlspecialchars($ins['name'] ?? '', ENT_QUOTES, 'UTF-8');
    $title = htmlspecialchars($ins['title'] ?? '', ENT_QUOTES, 'UTF-8');
    $placeholder = htmlspecialchars($ins['placeholder'] ?? '', ENT_QUOTES, 'UTF-8');
    $value = htmlspecialchars($ins['value'] ?? '', ENT_QUOTES, 'UTF-8');
    $max = filter_var($ins['max'] ?? '', FILTER_SANITIZE_NUMBER_INT);
    $required = !empty($ins['requerido']);
    ?>
    
    <label for="<?= $name ?>" class="control-label">
        <?= $title ?>
        <?php if ($required): ?>
            <small id="asterisco-requerido-<?= $name ?>" class="asterisco-danger text-danger">*</small>
        <?php endif; ?>
    </label>
    
    <div class="position-relative group-b-4">
        <input 
            type="text"
            name="<?= $name ?>"
            id="<?= $name ?>"
            class="form-control"
            placeholder="<?= $placeholder ?>"
            value="<?= $value ?>"
            maxlength="<?= $max ?>"
            autocomplete="off"
            <?= $required ? 'required' : '' ?>
            <?= isset($ins['pattern']) ? 'pattern="'.htmlspecialchars($ins['pattern'], ENT_QUOTES, 'UTF-8').'"' : '' ?>
            <?= isset($ins['disabled']) && $ins['disabled'] ? 'disabled' : '' ?>
        >
        <div id="caracteres_<?= htmlspecialchars($ins['name']) ?>" class="form-text txaCount"></div>
    </div>
    
    <datalist id="<?= $name ?>_list">
        <?php if (!empty($ins['options'])): ?>
            <?php foreach ($ins['options'] as $option): ?>
                <option value="<?= htmlspecialchars($option, ENT_QUOTES, 'UTF-8') ?>">
            <?php endforeach; ?>
        <?php endif; ?>
    </datalist>
    
    <?php if (!empty($ins['help_text'])): ?>
        <small class="form-text text-muted"><?= htmlspecialchars($ins['help_text'], ENT_QUOTES, 'UTF-8') ?></small>
    <?php endif; ?>
</div>