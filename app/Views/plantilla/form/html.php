
<!--col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12-->
<div class="row">
        <input type="hidden" name="action" id="action" value="<?= $action ?>">
        <?= csrf_field() ?>
        <?php for ($i = 0; $i < count($attrform); $i++) { ?>
            <?php $ins = $attrform[$i]; ?>
            <?php if ($ins['type'] == 'hidden') { ?>
                <input type="<?= $ins['type'] ?>" name="<?= $ins['name'] ?>" value="<?= $ins['value'] ?>"  id="<?= $ins['name'] ?>">
            <?php }else{ ?>
                <div class="mb-3 <?= $ins['column'] ?? 'col-md-12' ?>" id="column-<?= $ins['name'] ?>">

                    <?php if (in_array($ins['type'], ['text', 'email', 'password'])): ?>
                        <?= view('plantilla/form/inputs/normal', ['ins' => $ins, 'action' => $action]) ?>
                    <?php endif; ?>

                    <?php if ($ins['type'] == 'color') { ?>
                        <div class="form-group position-relative">
                            <label for="<?= $ins['name'] ?>" class="control-label ">
                                <?= $ins['title'] ?> <small id="asterisco-requerido-<?= $ins['name'] ?>" class="asterisco-danger text-danger"><?= $ins['requerido']?'*':'' ?></small>
                            </label>
                            <span id="caracteres_<?= $ins['name'] ?>" class="badge badge-primary ml-3 txaCount" ></span>
                            <div class="position-relative ">
                                <input  placeholder="<?= isset($ins['placeholder'])?$ins['placeholder']:'' ?>" autocomplete="off" type="color" name="<?= $ins['name'] ?>" value="<?= $ins['value'] ?>" <?= ($ins['requerido']==false?'':'required=""') ?> id="<?= $ins['name'] ?>" maxlength="<?= $ins['max'] ?>" class="form-control">
                            </div>
                            <datalist id="<?= $ins['name'] ?>_list">
                            </datalist>
                        </div>
                    <?php } ?>
                    <?php if ($ins['type'] == 'textAndNumber') { ?>
                        <?= view('plantilla/form/inputs/textAndNumber', ['ins' => $ins, 'action' => $action]) ?>
                    <?php } ?>
                    <?php if ($ins['type'] == 'readonly') { ?>
                        <div class="form-group position-relative">
                            <label for="<?= $ins['name'] ?>" class="control-label ">
                                <?= $ins['title'] ?> <small id="asterisco-requerido-<?= $ins['name'] ?>" class="asterisco-danger text-danger"><?= $ins['requerido']?'*':'' ?></small>
                            </label>
                            <span id="caracteres_<?= $ins['name'] ?>" class="badge badge-primary ml-3 txaCount" ></span>
                            <div class="position-relative group-b-4">
                                <input readonly  placeholder="<?= isset($ins['placeholder'])?$ins['placeholder']:'' ?>" autocomplete="off" type="text" value="<?= $ins['value'] ?>" id="<?= $ins['name'] ?>" maxlength="<?= $ins['max'] ?>" class="form-control">
                            </div>
                            <datalist id="<?= $ins['name'] ?>_list">
                            </datalist>
                        </div>
                    <?php } ?>
                    <?php if ($ins['type'] == 'textAdvanced') { ?>
                        <div class="form-group position-relative">
                            <label for="<?= $ins['name'] ?>" class="control-label ">
                                <?= $ins['title'] ?> <small id="asterisco-requerido-<?= $ins['name'] ?>" class="asterisco-danger text-danger"><?= $ins['requerido']?'*':'' ?></small>
                            </label>
                            <span id="caracteres_<?= $ins['name'] ?>" class="badge badge-primary ml-3 txaCount" ></span>
                            <div class="position-relative group-b-4">
                                <input  placeholder="<?= isset($ins['placeholder'])?$ins['placeholder']:'' ?>" autocomplete="off" type="text" name="<?= $ins['name'] ?>" value="<?= $ins['value'] ?>" <?= ($ins['requerido']==false?'':'required=""') ?> id="<?= $ins['name'] ?>" maxlength="<?= $ins['max'] ?>" class="form-control">
                            </div>
                            <datalist id="<?= $ins['name'] ?>_list">
                            </datalist>
                        </div>
                    <?php } ?>
                    
                    <?php if ($ins['type'] == 'Grados') { ?>
                        <div class="form-group position-relative">
                            <label for="<?= $ins['name'] ?>" class="control-label ">
                                <?= $ins['title'] ?> <small id="asterisco-requerido-<?= $ins['name'] ?>" class="asterisco-danger text-danger"><?= $ins['requerido']?'*':'' ?></small>
                            </label>
                            <div class="input-group  bootstrap-touchspin bootstrap-touchspin-injected">
                                <span class="input-group-addon input-group-prepend bootstrap-touchspin-prefix">
                                    <span class="input-group-text">Grado (°)</span>
                                </span>
                                <div class="position-relative group-b-4">
                                    <input placeholder="<?= isset($ins['placeholder'])?$ins['placeholder']:'' ?>" autocomplete="off" type="text" name="<?= $ins['name'] ?>" value="<?= $ins['value'] ?>" <?= ($ins['requerido']==false?'':'required=""') ?> id="<?= $ins['name'] ?>" maxlength="<?= $ins['max'] ?>" class="form-control">
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    <?php if ($ins['type'] == 'number' || $ins['type'] == 'money') { ?>
                        <div class="form-group position-relative">
                            <label for="<?= $ins['name'] ?>" class="control-label ">
                                <?= $ins['title'] ?> <small id="asterisco-requerido-<?= $ins['name'] ?>" class="asterisco-danger text-danger"><?= $ins['requerido']?'*':'' ?></small>
                            </label>
                            <span id="caracteres_<?= $ins['name'] ?>" class="badge badge-primary ml-3 txaCount" ></span>
                            <div class="position-relative group-b-4">
                                <div class="group-b-4">
                                    <input placeholder="<?= isset($ins['placeholder'])?$ins['placeholder']:'' ?>" autocomplete="off" type="text" name="<?= $ins['name'] ?>" value="<?= $ins['value'] ?>" <?= ($ins['requerido']==false?'false':'required=""') ?> id="<?= $ins['name'] ?>" maxlength="<?= $ins['max'] ?>" class="form-control"> 
                                    <!--<div class="input-group-append">
                                      <button type="button" class="btn btn-outline-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-exclamation-triangle"></i>
                                      </button>
                                      <div class="dropdown-menu dropdown-menu-right">
                                        <div class="px-2 py-2">
                                            <ul>
                                                <li>sdsdkf sdfj</li>
                                            </ul>
                                        </div>
                                      </div>
                                    </div>-->
                                </div>
                            </div>
                        </div>
                        <div class="messages_error_eva" id="messages_error_<?= $ins['name'] ?>"></div>
                    <?php } ?>
                    <?php if ($ins['type'] == 'datalist') { ?>
                        <div class="position-relative group-b-4">
                            <label for="<?= $ins['name'] ?>" class="control-label ">
                                <?= $ins['title'] ?> <small id="asterisco-requerido-<?= $ins['name'] ?>" class="asterisco-danger text-danger"><?= $ins['requerido']?'*':'' ?></small>
                            </label>
                            <div class="input-group">
                                <input placeholder="<?= $ins['title'] ?>" autocomplete="off" type="text" name="<?= $ins['name'] ?>" value="<?= $ins['value'] ?>" <?= ($ins['requerido']==false?'':'required=""') ?> id="<?= $ins['name'] ?>" maxlength="<?= $ins['max'] ?>" class="form-control">
                                
                                <div class="input-group-append">
                                    <small class="input-group-text" data-toggle="modal" data-target="#modal_<?= $ins['name'] ?>"><i class="fa fa-search"></i></small>
                                    <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Acción <i class="fa fa-plus"></i></button>
                                    <div class="dropdown-menu dropdown-right">
                                        <a class="dropdown-item" href="#" id="actualizar_<?= $ins['name'] ?>">Actualizar</a>
                                        <div role="separator" class="dropdown-divider"></div>
                                        <a class="dropdown-item" data-toggle="modal" data-target="#modal_<?= $ins['name'] ?>" href="#">Ver listado</a>
                                    </div>
                                </div>
                            </div>
                            <div class="messages_error_eva" id="messages_error_<?= $ins['name'] ?>"></div>
                        </div>
                    <?php } ?>
                    <?php if ($ins['type'] == 'textarea' || $ins['type'] == 'textareaAdvanced') { ?>
                        <div class="form-group position-relative">
                            <label for="<?= $ins['name'] ?>" class="control-label ">
                                <?= $ins['title'] ?> <small id="asterisco-requerido-<?= $ins['name'] ?>" class="asterisco-danger text-danger"><?= $ins['requerido']?'*':'' ?></small>
                            </label>
                            <div class="position-relative group-b-4">
                                <textarea maxlength="<?= $ins['max'] ?>" name="<?= $ins['name'] ?>" id="<?= $ins['name'] ?>" rows="4" cols="<?= $ins['max'] ?>" class="form-control textarea_auto"><?= (!isset($ins['value'])?'':$ins['value']) ?></textarea>
                            </div>                    
                        </div>
                    <?php } ?>
                    <?php if ($ins['type'] == 'file') { ?>
                        <?= view('plantilla/form/inputs/file', ['ins' => $ins, 'action' => $action]) ?>
                    <?php } ?>
                    <?php if ($ins['type'] == 'time') { ?>
                        <div class="form-group position-relative">
                                <label for="<?= $ins['name'] ?>" class="control-label ">
                                    <?= $ins['title'] ?> <small id="asterisco-requerido-<?= $ins['name'] ?>" class="asterisco-danger text-danger"><?= $ins['requerido']?'*':'' ?></small>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fas fa-clock"></i>
                                    </span>
                                    <input placeholder="<?= isset($ins['placeholder'])?$ins['placeholder']:'' ?>" autocomplete="off" type="text" name="<?= $ins['name'] ?>" value="<?= $ins['value'] ?>" <?= ($ins['requerido']==false?'':'required=""') ?> id="<?= $ins['name'] ?>" maxlength="<?= $ins['max'] ?>" class="form-control timepicker">
                                </div>
                                <div class="messages_error_eva" id="messages_error_<?= $ins['name'] ?>"></div>
    
                            </div>
                    <?php } ?>
                    <?php if ($ins['type'] == 'date') { ?>
                        <div class=" pb-3" style="padding-bottom: 15px;">
                            <label for="<?= $ins['name'] ?>" class="control-label  pl-0">
                                <?= $ins['title'] ?> <small id="asterisco-requerido-<?= $ins['name'] ?>" class="asterisco-danger text-danger"><?= $ins['requerido']?'*':'' ?></small>
                            </label>
                            <div class="input-group ">
                                <input placeholder="<?= isset($ins['placeholder'])?$ins['placeholder']:'' ?>" autocomplete="off" type="text" name="<?= $ins['name'] ?>" value="<?= $ins['value'] ?>" <?= ($ins['requerido']==false?'':'required=""') ?> id="<?= $ins['name'] ?>" maxlength="<?= $ins['max'] ?>" class="form-control timepicker">
                                <div class="input-group-addon">
                                  <span class="input-group-text" ><i class="fa fa-calendar"></i></span>
                                </div>
                            </div>
                            <div class="messages_error_eva" id="messages_error_<?= $ins['name'] ?>"></div>
                        </div>
                    <?php } ?>
                    <?php if ($ins['type'] == 'daterange') { ?>
                        <div class="bootstrap-timepicker">
                            <div class="form-group position-relative">
                                <label for="<?= $ins['title'] ?>">
                                    <?= $ins['title'] ?> <small id="asterisco-requerido-<?= $ins['name'] ?>" class="asterisco-danger text-danger"><?= $ins['requerido']?'*':'' ?></small>
                                </label>
                                <div class="input-daterange input-group date">
                                    <input placeholder="<?= isset($ins['placeholder'])?$ins['placeholder']:'' ?>" type="text" name="<?= $ins['data'][0]['name'] ?>" value="<?= $ins['data'][0]['value'] ?>" required="" id="<?= $ins['data'][0]['name'] ?>" maxlength="<?= $ins['data'][0]['name'] ?>" class="form-control">
                                    <span class="input-group-addon">Hasta</span>
                                    <input placeholder="<?= isset($ins['placeholder'])?$ins['placeholder']:'' ?>" type="text" name="<?= $ins['data'][1]['name'] ?>" value="<?= $ins['data'][1]['value'] ?>" required="" id="<?= $ins['data'][1]['name'] ?>" maxlength="<?= $ins['data'][1]['name'] ?>" class="form-control">
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    <?php if ($ins['type'] == 'select') { ?>
                        <div class="form-group position-relative">
                            <label for="<?= $ins['name'] ?>" class="control-label ">
                                <?= $ins['title'] ?> <small id="asterisco-requerido-<?= $ins['name'] ?>" class="asterisco-danger text-danger"><?= $ins['requerido']?'*':'' ?></small>
                            </label>
                            <div class="position-relative group-b-4">
                                <select autocomplete="off" name="<?= $ins['name'] ?>" style="width: 100%" <?= ($ins['requerido']==false?'':'required=""') ?> id="<?= $ins['name'] ?>" class="form-select custom-select form-control">
                                    <?php for ($j = 0; $j < count($ins['option']); $j++) { ?>
                                        <option 
                                            <?php foreach ($ins['option'][$j]['attr'] as $attr_key => $attr_val): ?>
                                                <?php if (isset($attr_val['text'])): ?>
                                                    <?php if ($attr_val['text']!=''): ?>
                                                        <?= $attr_val['text'] ?> = "<?= $attr_val['value'] ?>"
                                                    <?php endif ?>
                                                <?php endif ?>
                                            <?php endforeach ?>
                                         value="<?= $ins['option'][$j]['value'] ?>" <?= ($ins['option'][$j]['selected']?'selected':'') ?>  >
                                            <?= $ins['option'][$j]['text'] ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                            
                        </div>
                    <?php } ?>
                    <?php if ($ins['type'] == 'multiple') { ?>
                        <div class="form-group position-relative">
                            <label for="<?= $ins['name'] ?>" class="control-label ">
                                <?= $ins['title'] ?> <small id="asterisco-requerido-<?= $ins['name'] ?>" class="asterisco-danger text-danger"><?= $ins['requerido']?'*':'' ?></small>
                            </label>
                            <div class="position-relative group-b-4">
                                <select autocomplete="off" multiple name="<?= $ins['name'] ?>[]" style="width: 100%" <?= ($ins['requerido']==false?'':'required=""') ?> id="<?= $ins['name'] ?>" class="form-select">
                                    <?php for ($j = 0; $j < count($ins['option']); $j++) { ?>
                                        <option 

                                        <?php foreach ($ins['option'][$j]['attr'] as $attr_key => $attr_val): ?>
                                            <?= $attr_val['text'] ?> = "<?= $attr_val['value'] ?>"
                                        <?php endforeach ?>

                                         value="<?= $ins['option'][$j]['value'] ?>" <?= ($ins['option'][$j]['selected']?'selected':'') ?>  >
                                            <?= $ins['option'][$j]['text'] ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                            
                        </div>
                    <?php } ?>
                    <?php if ($ins['type'] == 'selectajax') { ?>
                        <?= view('plantilla/form/inputs/selectajax', ['ins' => $ins, 'action' => $action]) ?>
                        
                    <?php } ?>
                    <?php if ($ins['type'] == 'multipleselectajax') { ?>
                        
                        <div class="form-group position-relative">
                            <label for="<?= $ins['name'] ?>" class="control-label ">
                                <?= $ins['title'] ?> <small id="asterisco-requerido-<?= $ins['name'] ?>" class="asterisco-danger text-danger"><?= $ins['requerido']?'*':'' ?></small>
                            </label>
                            <div class=" select-cr" style="">
                                
                                <div class="input-group mb-3">
                                    <select style="width:100%" multiple autocomplete="off" name="<?= $ins['name'] ?>[]" style="width: 100%" <?= ($ins['requerido']==false?'':'required=""') ?> id="<?= $ins['name'] ?>" class="custom-select">
                                        <?php if ($action == 'editar') { ?>
                                            <?php if (count($ins['option']) > 0 ): ?>
                                                <?php if (isset($ins['option'][0]['attr'])): ?>
                                                    <?php for ($j = 0; $j < count($ins['option']); $j++) { ?>
                                                        <option <?= ($ins['option'][$j]['attr']['text']) ?>=<?= ($ins['option'][$j]['attr']['value']) ?> value="<?= $ins['option'][$j]['value'] ?>" <?= ($ins['option'][$j]['selected']?'selected':'') ?>  >
                                                            <?= $ins['option'][$j]['text'] ?>
                                                        </option>
                                                    <?php } ?>
                                                <?php endif ?>
                                            <?php endif ?>
                                        <?php } ?>
                                    </select>
                                  <div class="input-group-btn">
                                    <a class="btn btn-primary" target="_blank" href="<?= base_url($ins['url']) ?>">Añadir <i class="fa fa-plus"></i></a>
                                  </div>
                                </div>

                                
                            </div>
                            <div class="messages_error_eva" id="messages_error_<?= $ins['name'] ?>"></div>
                        </div>
                        
                    <?php } ?>
                </div>
            <?php } ?>
        <?php } ?>
    </div>
    <div class="row">
        <div class="col-md-12 pt-0">
            <button class="btn btn-<?= $action=='add'?'primary':'info' ?>" type="submit" id="boton_submit">
                <span id="loading" class="fa fa-save"></span>
                <span id="caption"><?= ($action=='add'?'Crear':'Editar') ?> Registro</span>
            </button>
            <button class="btn btn-outline-<?= $action=='add'?'primary':'info' ?> ms-2" type="button" id="cancelar">
                Regresar al listado
            </button>
        </div>
    
    </div>