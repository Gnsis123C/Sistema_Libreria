<div class="form-group position-relative">
    <?php
    // Sanitización de variables
    $name = htmlspecialchars($ins['name'] ?? '', ENT_QUOTES, 'UTF-8');
    $title = htmlspecialchars($ins['title'] ?? '', ENT_QUOTES, 'UTF-8');
    $accept = htmlspecialchars($ins['accept'] ?? '', ENT_QUOTES, 'UTF-8');
    $required = !empty($ins['requerido']);
    $multiple = !empty($ins['multiple']);
    $maxFiles = isset($ins['max_files']) ? (int)$ins['max_files'] : null;
    $fileTypes = isset($ins['file_types']) ? htmlspecialchars($ins['file_types'], ENT_QUOTES, 'UTF-8') : '';
    ?>
    
    <label for="<?= $name ?>" class="control-label">
        <?= $title ?>
        <?php if ($required): ?>
            <small id="asterisco-requerido-<?= $name ?>" class="asterisco-danger text-danger">*</small>
        <?php endif; ?>
        <?php if ($fileTypes): ?>
            <small class="text-muted ml-2">(<?= $fileTypes ?>)</small>
        <?php endif; ?>
    </label>
    
    <div class="file-loading">
        <input 
            type="file"
            id="<?= $name ?>"
            name="<?= $name ?><?= $multiple ? '[]' : '' ?>"
            class="form-control"
            <?= $required ? 'required' : '' ?>
            <?= $multiple ? 'multiple' : '' ?>
            <?= $maxFiles ? 'data-max-files="'.$maxFiles.'"' : '' ?>
            accept="<?= $accept ?>"
            <?= isset($ins['disabled']) && $ins['disabled'] ? 'disabled' : '' ?>
            <?= isset($ins['data-attributes']) ? $ins['data-attributes'] : '' ?>
        >
    </div>
    
    <?php if (isset($ins['help_text'])): ?>
        <small class="form-text text-muted"><?= htmlspecialchars($ins['help_text'], ENT_QUOTES, 'UTF-8') ?></small>
    <?php endif; ?>
    
    <div class="messages_error_eva" id="messages_error_<?= $name ?>"></div>
    
    <?php if ($maxFiles): ?>
        <small class="form-text text-info">Máximo <?= $maxFiles ?> archivo(s)</small>
    <?php endif; ?>

    <div id="preview-imagen-<?= $name ?>" class="position-relative preview-imagen mt-2 d-none">
        <img src="" alt="Imagen recortada" class="rounded">
        <button type="button" value="preview-imagen-<?= $name ?>" data-btn="btn-delete-img" class="btn btn-danger btn-sm position-absolute top-0 end-0"><i class="bi bi-trash"></i></button>
    </div>
</div>