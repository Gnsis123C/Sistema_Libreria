<div class="form-group position-relative">
    
    <?= view('plantilla/form/partials/label', ['ins' => $ins]) ?>
    <div class=" select-cr" style="">
        
        <div class="input-group mb-1">
            <select style="width:100%" autocomplete="off" name="<?= $ins['name'] ?>" style="width: 100%" <?= ($ins['requerido']==false?'':'required=""') ?> id="<?= $ins['name'] ?>" class="custom-select">
                <?php if ($action == 'edit') { ?>
                    <?php for ($j = 0; $j < count($ins['option']); $j++) { ?>
                        <option <?= ($ins['option'][$j]['attr']['text']) ?>=<?= ($ins['option'][$j]['attr']['value']) ?> value="<?= $ins['option'][$j]['value'] ?>" <?= ($ins['option'][$j]['selected']?'selected':'') ?>  >
                            <?= $ins['option'][$j]['text'] ?>
                        </option>
                    <?php } ?>
                <?php } ?>
            </select>
            
            <a class="btn btn-primary" target="_blank" href="<?= $ins['url'] ?>">Añadir <i class="fa fa-plus"></i></a>
        </div>

    </div>
    <div class="messages_error_eva" id="messages_error_<?= $ins['name'] ?>"></div>
</div>