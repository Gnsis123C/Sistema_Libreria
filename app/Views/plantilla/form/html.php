<div class="row">
    <input type="hidden" name="action" id="action" value="<?= $action ?>">
    <?= csrf_field() ?>

    <?php foreach ($attrform as $ins): ?>
        <?php if ($ins['type'] === 'hidden'): ?>
            <input type="hidden" 
                   name="<?= $ins['name'] ?>" 
                   value="<?= $ins['value'] ?>"  
                   id="<?= $ins['name'] ?>">
        <?php else: ?>
            <div class="mb-3 <?= $ins['column'] ?? 'col-md-12' ?>" id="column-<?= $ins['name'] ?>">
                
                <?php switch ($ins['type']):
                    case 'text':
                    case 'email':
                    case 'nickname':
                    case 'password':
                        echo view('plantilla/form/inputs/normal', compact('ins', 'action'));
                        break;

                    case 'color': ?>
                        <?= view('plantilla/form/inputs/color', compact('ins')) ?>
                        <?php break;

                    case 'readonly': ?>
                        <?= view('plantilla/form/inputs/readonly', compact('ins')) ?>
                        <?php break;

                    case 'textAndNumber': ?>
                        <?= view('plantilla/form/inputs/textAndNumber', compact('ins')) ?>
                        <?php break;

                    case 'number':
                    case 'money': ?>
                        <?= view('plantilla/form/inputs/number', compact('ins')) ?>
                        <?php break;

                    case 'select': ?>
                        <?= view('plantilla/form/inputs/select', compact('ins')) ?>
                        <?php break;

                    case 'multiple': ?>
                        <?= view('plantilla/form/inputs/multiple', compact('ins')) ?>
                        <?php break;

                    case 'selectajax': ?>
                        <?= view('plantilla/form/inputs/selectajax', compact('ins')) ?>
                        <?php break;

                    case 'textarea':
                    case 'textareaAdvanced': ?>
                        <?= view('plantilla/form/inputs/textarea', compact('ins')) ?>
                        <?php break;

                    case 'file': ?>
                        <?= view('plantilla/form/inputs/file', compact('ins', 'action')) ?>
                        <?php break;

                    case 'time': ?>
                        <?= view('plantilla/form/inputs/time', compact('ins')) ?>
                        <?php break;

                    case 'date': ?>
                        <?= view('plantilla/form/inputs/date', compact('ins')) ?>
                        <?php break;

                    case 'daterange': ?>
                        <?= view('plantilla/form/inputs/daterange', compact('ins')) ?>
                        <?php break;

                    // Otros tipos personalizados
                    default:
                    ?>
                        <p class="text-danger">⚠️ Tipo de campo no soportado: <?= $ins['type'] ?></p>
                <?php endswitch; ?>
            </div>
        <?php endif; ?>
    <?php endforeach; ?>
</div>

<div class="row">
    <div class="col-md-12 pt-0 d-grid d-sm-block">
        <button class="btn btn-<?= $action=='add'?'success':'info' ?>" type="submit" id="boton_submit">
            <span id="loading" class="fa fa-save"></span>
            <span id="caption"><?= ($action=='add'?'Crear':'Editar') ?> Registro</span>
        </button>
        <button class="btn btn-outline-<?= $action=='add'?'success':'info' ?> ms-0 ms-sm-2 mt-2 mt-sm-0" type="button" id="cancelar">
            Regresar al listado
        </button>
    </div>
</div>