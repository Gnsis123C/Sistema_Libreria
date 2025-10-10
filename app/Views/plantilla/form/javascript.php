<script>
    $(function(){
        <?php for ($i = 0; $i < count($attrform); $i++) { ?>
            <?php $ins = $attrform[$i]; ?>
            <?php if ($ins['type'] == 'text') { ?>
                $('#<?= $ins['name'] ?>').on('input',function(){ 
					this.value = this.value.replace(/[^a-zA-ZñÑáéíóúÁÉÍÓÚ\s]/g,'');
				});
                $("#<?= $ins['name'] ?>").on('keypress', function() {
                    var limit = $("#<?= $ins['name'] ?>").attr('maxlength');
                    var init = $(this).val().length;
                    if(init<limit){
                        init++;
                        $('#caracteres_<?= $ins['name'] ?>').text(`${init} caracteres, máximo ${limit}`); 
                    }
                });
            <?php } ?>
            <?php if ($ins['type'] == 'email' || $ins['type'] == 'textarea') { ?>
                $('#<?= $ins['name'] ?>').on('input',function(){ 
                    this.value = this.value.replace(/[^a-zA-Z@.ñÑáéíóúÁÉÍÓÚ_\-0-9\s]/g,'');
                });
                $("#<?= $ins['name'] ?>").on('keypress', function() {
                    var limit = $("#<?= $ins['name'] ?>").attr('maxlength');
                    var init = $(this).val().length;
                    if(init<limit){
                        init++;
                        $('#caracteres_<?= $ins['name'] ?>').text(`${init} caracteres, máximo ${limit}`); 
                    }
                });
            <?php } ?>
            <?php if ($ins['type'] == 'number') { ?>
                $('#<?= $ins['name'] ?>').on('input',function(){ 
                    this.value = this.value.replace(/[^0-9]/g,'');
                });
            <?php } ?>
            <?php if ($ins['type'] == 'textAndNumber') { ?>
                $('#<?= $ins['name'] ?>').on('input',function(){ 
                    this.value = this.value.replace(/[^a-zA-ZñÑáéíóúÁÉÍÓÚ\-_0-9,.\s]/g,'');
				});
                $("#<?= $ins['name'] ?>").on('keypress', function() {
                    var limit = $("#<?= $ins['name'] ?>").attr('maxlength');
                    var init = $(this).val().length;
                    if(init<limit){
                        init++;
                        $('#caracteres_<?= $ins['name'] ?>').text(`${init} caracteres, máximo ${limit}`); 
                    }
                });
            <?php } ?>
            <?php if ($ins['type'] == 'nickname') { ?>
                $('#<?= $ins['name'] ?>').on('input',function(){ 
                    this.value = this.value.replace(/[^a-zA-ZñÑáéíóúÁÉÍÓÚ_0-9]/g,'');
				});
            <?php } ?>
            <?php if ($ins['type'] == 'money') { ?>
                $('#<?= $ins['name'] ?>').on('input',function(){ 
                    this.value = this.value.replace(/[^0-9.]/g,'');
                });
            <?php } ?>
            <?php if ($ins['type'] == 'Grados') { ?>
                $('#<?= $ins['name'] ?>').on('input',function(){ 
                    this.value = this.value.replace(/[^0-9.,°]/g,'');
                });
            <?php } ?>
            <?php if ($ins['type'] == 'textarea' || $ins['type'] == 'textareaAdvanced') { ?>
                $("<?= $ins['name'] ?>").bind('input propertychange', function() {  
                    var maxLength = $(this).attr('maxlength');  
                    if ($(this).val().length > maxLength) {  
                        $(this).val($(this).val().substring(0, maxLength));  
                    }  
                });
            <?php } ?>
            <?php if ($ins['type'] == 'datalist') { ?>
                var init_flex_<?= $ins['name'] ?> = function() {
                    $('#<?= $ins['name'] ?>').flexdatalist({
                        minLength: 1,
                        searchIn: <?= json_encode($ins['option']['searchIn']) ?>,
                        textProperty: '<?= $ins['option']['textProperty'] ?>',
                        visibleProperties: <?= json_encode($ins['option']['visibleProperties']) ?>,
                        valueProperty: '<?= $ins['option']['valueProperty'] ?>',
                        selectionRequired: true,
                        cache: false,
                        searchByWord: true,
                        searchContain:true,
                        groupBy: '<?= (isset($ins['option']['groupBy'])?$ins['option']['groupBy']:'') ?>',
                        noResultsText: 'Ningún resultado para "{keyword}"',
                        requestType: 'POST',
                        "options": {
                            "url": ""
                        },
                        data: '<?= base_url($ins['url']) ?>/datalist'
                    });
                    $('#<?= $ins['name'] ?>').on('select:flexdatalist', function(event, set, options) {
                        $('#form_global').formValidation('revalidateField', '<?= $ins['name'] ?>');
                        //console.log(set.text);
                    });
                }
                init_flex_<?= $ins['name'] ?>();
                $('#actualizar_<?= $ins['name'] ?>').click(function() {
                    init_flex_<?= $ins['name'] ?>();
                    var ht = $('#actualizar_<?= $ins['name'] ?>').html();
                    $(this).html('<i class="fa fa-refresh fa-spin"></i>');
                    setTimeout(function() {
                        $('#actualizar_<?= $ins['name'] ?>').html(ht)
                    }, 1200);
                });
            <?php } ?>
            
            
            <?php if ($ins['type'] == 'selectajax') { ?>
                $("#<?= $ins['name'] ?>").select2({
                    placeholder: '<?= $ins['title'] ?>',
                    theme: '<?= $ins['theme'] ?>',
                    width: '75%',
                    ajax: {
                        url: '<?= $ins['url_select'] ?>',
                        dataType: 'json',
                        type: "post",
                        delay: 250,
                        data: function (data) {
                            var query = {
                                "<?= csrf_token() ?>": "<?= csrf_hash() ?>",
                                searchTerm: data.term,
                                page: data.page || 1,
                                size: data.size || <?= $ins['per_page'] ?>
                            }
                            // Query parameters will be ?search=[term]&page=[page]
                            return query;
                        },
                        processResults: function (data) {
                            return {
                                results: $.map(data.results, function(obj) {
                                    //const texto = "<?= $ins['results']['text'] ?>",
                                    //regex = /([^}]*){}/g;
                                    //regex = /}([^}]*){/g;
                                    /*var grupos;
                                    var i = 0;
                                    while ((grupos = regex.exec(texto)) !== null) {
                                        console.log(grupos);
                                    }*/
                                    return { 
                                        id: obj.<?= $ins['results']['id'] ?>, 
                                        text: obj.<?= $ins['results']['text'] ?>
                                    };
                                }),
                                pagination: {
                                    more: ((data.page * data.size) < data.count_filtered)
                                }
                            };
                        },
                        templateResult: function(item) {
                            // Display institution name as tag option
                            return $("<div>" + item.name + "</div>");
                        },
                        instructions: 'To find a book, search the <strong>Book\'s Title</strong>, <strong>ISBN</strong>, or <strong>Authors</strong>',
                        cache: true,
                        allowClear: true,
                        minimumInputLength: 1
                    }
                });
            <?php } ?>

            <?php if ($ins['type'] == 'multipleselectajax') { ?>
                $("#<?= $ins['name'] ?>").select2({
                    tags: true,
                    tokenSeparators: [',', '|'],
                    multiple:true,
                    maximumSelectionLength: 1,
                    placeholder: '<?= $ins['title'] ?>',
					theme: '<?= $ins['theme'] ?>',
                    ajax: {
                        url: '<?= base_url($ins['url']) ?>/select',
                        dataType: 'json',
                        type: "post",
                        delay: 250,
                        data: function (data) {
                            var query = {
                                searchTerm: data.term,
                                page: data.page || 1,
                                size: data.size || <?= $ins['per_page'] ?>
                            }
                            // Query parameters will be ?search=[term]&page=[page]
                            return query;
                        },
                        processResults: function (data) {
                            return {
                                results: $.map(data.results, function(obj) {
                                    //const texto = "<?= $ins['results']['text'] ?>",
                                    //regex = /([^}]*){}/g;
                                    //regex = /}([^}]*){/g;
                                    /*var grupos;
                                    var i = 0;
                                    while ((grupos = regex.exec(texto)) !== null) {
                                        console.log(grupos);
                                    }*/
                                    return { 
                                        id: obj.<?= $ins['results']['id'] ?>, 
                                        text: obj.<?= $ins['results']['text'] ?>
                                    };
                                }),
                                pagination: {
                                    more: ((data.page * data.size) < data.count_filtered)
                                }
                            };
                        },
                        templateResult: function(item) {
                            // Display institution name as tag option
                            return $("<div>" + item.name + "</div>");
                        },
                        instructions: 'To find a book, search the <strong>Book\'s Title</strong>, <strong>ISBN</strong>, or <strong>Authors</strong>',
                        cache: true,
                        allowClear: true,
                        minimumInputLength: 1
                    }
                });
            <?php } ?>
    <?php } ?>

    $("input[type='password'][data-eye]").each(function(i) {
        var $this = $(this),
            id = 'eye-password-' + i,
            el = $('#' + id);

        $this.wrap($("<div/>", {
            style: 'position:relative',
            id: id
        }));

        $this.css({
            paddingRight: 60
        });
        $this.after($("<div/>", {
            html: 'Ver',
            class: 'btn btn-primary btn-sm pass',
            id: 'passeye-toggle-'+i,
        }).css({
                position: 'absolute',
                right: 5,
                //top: ($this.outerHeight() / 2) - 35,
                padding: '2px 7px',
                fontSize: 12,
                cursor: 'pointer',
        }));

        $this.after($("<input/>", {
            type: 'hidden',
            id: 'passeye-' + i
        }));

        var invalid_feedback = $this.parent().parent().find('.invalid-feedback');

        if(invalid_feedback.length) {
            $this.after(invalid_feedback.clone());
        }

        $this.on("keyup paste", function() {
            $("#passeye-"+i).val($(this).val());
        });
        $("#passeye-toggle-"+i).on("click", function() {
            //alert($("#passeye-"+i).val())
            if($this.hasClass("show")) {
                $this.attr('type', 'password');
                $this.removeClass("show");
                $(this).html("Ver");
                $(this).removeClass("btn-outline-primary");
            }else{
                $this.attr('type', 'text');
                //$this.val($("#passeye-"+i).val());                
                $this.addClass("show");
                $(this).html("Ocultar");
                $(this).addClass("btn-outline-primary");
            }
        });
    });
    });
</script>