<?php
$check = 'danger';
$msg = 'prazo';
$nome = $this->user->getName();
$Iniciais = controller::Iniciais($nome);
$data_hoje = date('d/m');
?>
<div class="list-etapas"></div>

<div class="modal fade" id="modal_form" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="POST" id="form_update" enctype="multipart/form-data" action="">

                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <h2 class="modal-title fc-center" align="center" id=""></h2>
                        </div>

                        <div class="modal-body">
                            <br>
                           

                            <div id="dados_" style="display: ">
                                <div class="box box-default box-solid">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="box-header with-border">
                                                <h3 class="box-title">Dados</h3>
                                            </div>
                                            <div class="box-body" style="">

                                            
                                        

                                                <input type="hidden" class="form-control" name="tipo" id="tipo" autocomplete="off" value="ADMINISTRATIVA">
                                                <input type="hidden" class="form-control" name="id_etapa_obra" id="id_etapa_obra" autocomplete="off">
                                                <input type="hidden" class="form-control" name="id_obra" id="id_obra" autocomplete="off">
                                                <input type="hidden" class="form-control" name="cliente" id="cliente" autocomplete="off">
                                                <input type="hidden" class="form-control" name="server" id="server" autocomplete="off">
                                                <input type="hidden" class="form-control" name="cliente_nome" id="cliente_nome" autocomplete="off">



                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label>Nome Etapa</label>
                                                        <input type="text" class="form-control" name="nome_etapa_obra" id="nome_etapa_obra" autocomplete="off">
                                                    </div>
                                                </div>

                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label>Data Meta</label>
                                                        <input type="text" class="form-control" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask="" name="meta_etapa" id="meta_etapa" autocomplete="off">
                                                    </div>
                                                </div>


                                                <div id="ADMINISTRATIVA" style="display: none">

                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label>Data do Pedido</label>
                                                            <input type="text" class="form-control" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask="" name="data_pedido_administrativo" id="data_pedido_administrativo" autocomplete="off">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Responsável</label>
                                                            <input type="text" class="form-control" name="responsavel_administrativo" id="responsavel_administrativo" autocomplete="off">
                                                        </div>
                                                    </div>



                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Cliente Responsável</label>
                                                            <input type="text" class="form-control" name="cliente_responsavel_administrativo" id="cliente_responsavel_administrativo" autocomplete="off">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div id="COMPRA" style="display: none">
                                                    <input type="hidden" class="form-control" name="tipo" id="" autocomplete="off" value="COMPRA">

                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label>Quantidade</label>
                                                            <input type="text" class="form-control" name="quantidade" id="quantidade" autocomplete="off">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label>Preço</label>
                                                            <input type="text" class="form-control" name="preco" id="preco" autocomplete="off">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label>Tipo</label>
                                                            <input type="text" class="form-control" name="tipo_compra" id="tipo_compra" autocomplete="off">
                                                        </div>
                                                    </div>


                                                </div>

                                                <div id="CONCESSIONARIA" style="display: none">
                                                    <input type="hidden" class="form-control" name="tipo" id="" autocomplete="off" value="CONCESSIONARIA">

                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label>Data de Abertura</label>
                                                            <input type="text" class="form-control" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask="" name="data_abertura_concessionaria" id="data_abertura_concessionaria" autocomplete="off">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label>Nº Nota</label>
                                                            <input type="text" class="form-control" name="nota_numero_concessionaria" id="nota_numero_concessionaria" autocomplete="off">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <label>Prazo de Atendimento</label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" name="prazo_atendimento_concessionaria" id="prazo_atendimento_concessionaria" autocomplete="off">
                                                            <div class="input-group-btn">
                                                                <div class="btn btn-default">
                                                                    <i></i> Dias
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php if ($this->userInfo['user']->hasPermission('obra_edit')) : ?>
                                                        <div class="col-md-12" style="margin-bottom: 13px;margin-top:5px">
                                                            <div class="input-group">
                                                                <span class="input-group-addon">
                                                                    <input class="flat-blue" name="check_nota" type="checkbox" value="1">
                                                                </span>
                                                                <span type="text" class="form-control">Salvar como ultima nota</span>
                                                            </div>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>

                                                <div id="OBRA" style="display: none">
                                                    <input type="hidden" class="form-control" name="tipo" id="" autocomplete="off" value="OBRA">


                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label>Responsável</label>
                                                            <input type="text" class="form-control" name="responsavel_obra" id="cliente_nome" autocomplete="off">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label>Data Programada</label>
                                                            <input type="text" class="form-control" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask="" name="data_programada_obra" id="data_programada_obra" autocomplete="off">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label>Data Iniciada </label>
                                                            <input type="text" class="form-control" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask="" name="data_iniciada_obra" id="data_iniciada_obra" autocomplete="off">
                                                        </div>
                                                    </div>


                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label>Tempo de Atividade</label>
                                                            <input type="text" class="form-control" name="tempo_atividade_obra" id="tempo_atividade_obra" autocomplete="off">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label>Observações</label>
                                                        <input type="text" class="form-control" name="observacao" id="observacao" autocomplete="off">
                                                    </div>
                                                </div>
                                                <?php if ($this->userInfo['user']->hasPermission('obra_edit')) : ?>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label>Observações do sistema</label>
                                                            <textarea type="text" class="form-control" name="observacao_sistema" id="observacao_sistema" autocomplete="off" rows="5" cols="33"> </textarea>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            

                                <div class="box box-default box-solid">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="box-header with-border">
                                                <h3 class="box-title">Documentos</h3>

                                            </div>
                                            <div class="box-body" style="">
                                                <div class="col-md-10" style="margin-bottom:20px">
                                                    <label>Adicionar novo Documento</label>
                                                    <div class="input-group">
                                                        <input class="form-control" name="documento_etapa_nome" id="documento_etapa_nome" placeholder="Nome do Documento">
                                                        <div class="input-group-btn">
                                                            <div class="btn btn-default btn-file">
                                                                <i class="fa fa-paperclip"></i> PDF
                                                                <input type="file" id="file" class="btn btn-success file_doc" name="documento_arquivo">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-10">
                                                    <div class="etapa_documento">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <?php if ($this->userInfo['user']->hasPermission('obra_edit')) : ?>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">Salvar</button>


                                        <div class="btn btn-danger btn-flat pull-left delete_etapa" data-toggle="popover" title="Remover Etapa?" data-content="">
                                            <i class="fa fa-trash"></i>
                                        </div>

                                    </div>
                                <?php endif; ?>


                            </div>

                            <div class="overlay" style="display:none">
                              <i class="fa fa-refresh fa-spin"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>




<script>
    $(function() {

        $(document).ready(gethistorico);


        var cookie = getCookie('select_etapas');
        var tipo = $("#select-etapas option:selected").val();
        setCookie('select_etapas', tipo, 25)

        $('#select-etapas').on('change', function() {
            var tipo = $("#select-etapas option:selected").val();
            setCookie('select_etapas', tipo, 25)
            $(document).ready(gethistorico);
        });

        $("#form_update").on("submit", function(event) {
            event.preventDefault();
            var data = new FormData(this);

            tipo = getCookie('select_etapas');

            id_etapa_obra = $('[name="id_etapa_obra"]').val()
            id_obra = $('[name="id_obra"]').val();

            $.ajax({
                url: BASE_URL + 'obras/editEtapaObra/' + id_etapa_obra,
                type: 'POST',
                data: data,
                dataType: 'json',
                beforeSend: function ( xhr ) {
                    $('.overlay').toggle();
                    $('#dados_').toggle();
                },
                success: function(json) {
                    toastr.success('Editado com sucesso');
                    $('#documento_etapa_nome').val('');
                    $('#file').val('');

                    window.location.href = BASE_URL + 'obras/edit/'+id_obra;
                    

                },
                cache: false,
                contentType: false,
                processData: false,
                xhr: function() { // Custom XMLHttpRequest
                    var myXhr = $.ajaxSettings.xhr();
                    if (myXhr.upload) { // Avalia se tem suporte a propriedade upload
                        myXhr.upload.addEventListener('progress', function() {}, false);
                    }
                    return myXhr;
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    toastr.error('Erro contate o administrador, Codigo XXDOC_1');
                }
            });
        });

    });

    function gethistorico() {

        var id_obra = <?php echo $obr['id_obra']; ?>;

        var tipo = $("#select-etapas option:selected").val();

        $.getJSON(BASE_URL + 'ajax/getEtapas/?search=', {
            id_obra: id_obra,
            tipo: tipo,

            ajax: 'true'
        }, function(j) {
            var options = '';
            var result = 0;
            if (j.length != 0) {
                for (var i = 0; i < j.length; i++) {

                    var id_etapa_obra = j[i].id_etapa_obra;
                    var data_abertura = j[i].data_abertura;
                    var id_etapa = j[i].id_etapa;
                    var check = j[i].check
                    var string = j[i].observacao
                    var length = 40;
                    var trimmedString = string != null ? string.substring(0, length) + '...' : '';
                    var etp_nome_etapa_obra = j[i].etp_nome_etapa_obra != null ? j[i].etp_nome_etapa_obra.substring(0, length) : '';


                    if (j[i].data_abertura != null || j[i].data_abertura != null ||
                        j[i].prazo_atendimento != null || j[i].data_pedido != null ||
                        j[i].data_programada != null || j[i].data_iniciada != null ||
                        j[i].tempo_atividade != null
                    ) {
                        info = '<i data-toggle="tooltip" title="" data-original-title="informações" style="color:#002bff" class="fa fa-fw fa-info"></i>';
                    } else {
                        info = '';
                    }

                    var checked = (check == '1' ? 'checked' : '');

                    array = loadTempo(j[i].prazo_atendimento, j[i].data_abertura, check);

                    var documento = (j[i].documento != '' ? 'true' : 'false');
                    var documentoNome = String(j[i].documento);

                    options += '<div class="no-border">'
                    options += '<input type="hidden" id="id_etapa_obra" value="' + j[i].id_etapa_obra + '">'
                    options += '     <ul class="todo-list">'
                    options += '        <li>';
                    options += '            <div class="icheckbox_flat-blue ' + checked + '" onclick="checkEtapa(' + id_etapa + ',' + check + ')" aria-checked="true" aria-disabled="false" style="position: relative;"><input id="checkEtapa" class="flat-blue" type="checkbox"  value="' + id_etapa_obra + '" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div>'
                    options += '            <a href="javascript:;" onclick="edit_etapa(' + j[i].id_etapa_obra + ')" >';
                    options += '                <span class="text">' + etp_nome_etapa_obra + '</span>';
                    options += info;
                    options += '            </a>';
                    if (documento == 'true') {
                        options += '<i data-toggle="tooltip" onclick="getDocumento(this)" id="' + documentoNome + '" title="" data-original-title="documento" style="color:#002bff;cursor:pointer" class="fa fa-book"></i>';
                    }
                    if (array.msg != "") {
                        options += '            <span style="font-size: 12px" class="label label-' + array.type + '"><i class="fa fa-clock-o"></i> ' + array.msg + '</span>'
                    }
                    if (j[i].meta_etapa != null && j[i].meta_etapa != '' && check != 1) {
                        options += '              <span style="font-size: 12px" class="label label-success"><i class="fa fa-clock-o"></i>Meta: ' + j[i].meta_etapa + '</span>'
                    }
                    options += '            <span class="text pull-right"> ' + trimmedString + ' </span>'
                    options += '        </li>';
                    options += '    </ul>';
                    options += '</div>';
                }


                $('.list-etapas').html(options).show();



            } else {

                $(".list-etapas").css("display", "none");



            }
        });
    }

    function checkEtapa(id_etapa, tipo) {
        tipo = (tipo == 1 ? '0' : '1');
        idobra = <?php echo $obr['id_obra']; ?>;

        $.ajax({

            url: BASE_URL + 'ajax/updateEtapa',
            type: 'POST',
            data: {
                id_etapa: id_etapa,
                checked: tipo,
                id_obra: idobra
            },
            dataType: 'json',
            success: function(json) {
                $(document).ready(gethistorico);
                var alerta = (tipo == 1 ? toastr.success('Etapa Concluida') : toastr.error('Etapa Desconcluida'));
            },
            error: function(xhr, ajaxOptions, thrownError) {
                toastr.error('Erro contate o administrador');
            }
        });

    }

    function edit_etapa(id) {
        save_method = 'update';


        $('#form_update')[0].reset();
        $('.form-group').removeClass('has-error');
        $('.help-block').empty();

        
        $(".etapa_documento").css("display", "none");

        $("#CONCESSIONARIA").css("display", "none");
        $("#OBRA").css("display", "none");
        $("#COMPRA").css("display", "none");
        $("#ADMINISTRATIVA").css("display", "none");



        //Ajax Load data from ajax
        $.ajax({
            url: BASE_URL + 'ajax/getIdEtapaObra/' + id,
            type: "GET",
            dataType: "JSON",
            success: function(data) {

                checkDocumentoEtapa(id, data.id_obra);


                $("#" + data.nome).css("display", "");

                $('[name="id_etapa_obra"]').val(data.id_etapa_obra);
                $('[name="nome_etapa_obra"]').val(data.etp_nome_etapa_obra);
                $('[name="tipo"]').val(data.nome);
                $('.modal-title').text('Etapa"' + data.etp_nome + '"');

                $('[name="id_obra"]').val(data.id_obra);
                $('[name="cliente"]').val('<?php echo $obr['id_cliente']; ?>');
                $('[name="cliente_nome"]').val('<?php echo $obr['cliente_nome']; ?>');

                $('[name="server"]').val(data.tipo);

                if (data.nome == 'ADMINISTRATIVA') {

                    $('[name="responsavel_administrativo"]').val(data.responsavel);
                    $('[name="data_pedido_administrativo"]').val(data.data_pedido);
                    $('[name="cliente_responsavel_administrativo"]').val(data.cliente_responsavel);

                } else if (data.nome == 'CONCESSIONARIA') {

                    $('[name="nota_numero_concessionaria"]').val(data.nota_numero);
                    $('[name="data_abertura_concessionaria"]').val(data.data_abertura);
                    $('[name="prazo_atendimento_concessionaria"]').val(data.prazo_atendimento);

                } else if (data.nome == 'OBRA') {

                    $('[name="responsavel_obra"]').val(data.responsavel);
                    $('[name="data_programada_obra"]').val(data.data_programada);
                    $('[name="data_iniciada_obra"]').val(data.data_iniciada);
                    $('[name="tempo_atividade_obra"]').val(data.tempo_atividade);


                } else if (data.nome == 'COMPRA') {

                    $('[name="quantidade"]').val(data.quantidade_obra);
                    $('[name="preco"]').val(data.preco_obra);
                    $('[name="tipo_compra"]').val(data.tipo_compra_obra);
                    $('[name="tempo_atividade_obra"]').val(data.tempo_atividade);

                }

                observacao_sistema = data.observacao_sistema != null ? data.observacao_sistema : '';

                $('[name="meta_etapa"]').val(data.meta_etapa);
                $('[name="observacao"]').val(data.observacao);
                $('[name="observacao_sistema"]').val(observacao_sistema);

                $(".delete_etapa").attr("data-content", "<a  href='" + BASE_URL + 'obras/obra_etapa_delete/' + data.id_etapa_obra + '/' + data.id_obra + "' class='btn btn-danger'>Sim</a> <button type='button' class='btn btn-default pop-hide'>Não</button>");


                $('#modal_form').modal('show');


               


            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error get data from ajax');
            },
        });


    }

    function loadTempo(prazo, abertura, check) {

        var array = [];

        if (check == 0) {
            if (abertura) {
                if (prazo) {

                    var minhaData = moment(abertura, "DD/MM/YYYY");
                    var inicio = minhaData.add(prazo, 'days').format("DD/MM/YYYY");



                    inicio = inicio.replace('/', '-')
                    inicio = inicio.replace('/', '-')



                    const dataSplit = inicio.split('-');

                    const day = dataSplit[0]; // 10
                    const month = dataSplit[1]; // 01
                    const year = dataSplit[2]; // 2020

                    const now = dataFormatada(new Date());

                    var antes = moment(now);
                    var depois = moment(year + '-' + month + '-' + day);

                    var days = depois.diff(antes, 'days');
                    var years = depois.diff(antes, 'years');
                    var months = depois.diff(antes, 'month');




                    mes = (months != '' ? months + ' mese(s) e ' : '');
                    var msg = 'Restam: ' + months + '' + days + ' Dia(s)';

                    if (days == '0') {
                        array.msg = 'Entrega Hoje';
                        array.type = 'warning';
                    } else if (antes > depois) {
                        array.msg = 'Atrasado em ' + mes + days + ' Dia(s)';
                        array.type = 'danger';

                    } else if (antes < depois) {
                        array.msg = mes + days + ' Dia(s) Restante(s)';
                        array.type = 'success';
                    }


                } else {
                    array.type = 'warning';
                    array.msg = 'Foi dado Abertura, mas sem prazo';
                }


            } else {
                array.type = '';
                array.msg = '';
            }

        } else {
            array.type = '';
            array.msg = '';
        }

        return array;

    }

    function checkDocumentoEtapa(id, id_obra) {
        msgConfirm = "'" + 'Deseja deletar esse documento?' + "'"
        $.ajax({
            url: BASE_URL + 'ajax/getDocumentoEtapaObra/' + id,
            type: "GET",
            dataType: "JSON",
            success: function(j) {
                var options = '';
                if (j.length != 0) {
                    for (var i = 0; i < j.length; i++) {

                        options += '<div class="input-group" style="width: 100%;">'
                        options += '<input type="text" class="form-control" autocomplete="off" value="' + j[i].docs_nome + '">'
                        options += '<div class="input-group-btn">'
                        options += '<a href="' + BASE_URL + 'assets/documentos/' + j[i].docs_nome + '" target="_blank" class="btn btn-info btn-flat" data-toggle="tooltip" title="" data-original-title="Ver Documento">'
                        options += '    <i class="fa fa-info"></i>'
                        options += '</a>'
                        options += '<a    onclick="toastAlertDelete(' + j[i].id_documento + ', ' + id_obra + ')" class="btn btn-danger btn-flat" data-toggle="tooltip" title="" data-original-title="Deletar">'
                        options += '    <i class="fa fa-trash"></i>'
                        options += '</a>'
                        options += '</div>'
                        options += '</div>'
                    }

                    $('.etapa_documento').html(options).show();
                }

            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error get data from ajax');
            },
        });

    }

    function getDocumento(docNome) {
        var id = docNome.id;

        window.open(
            BASE_URL + "assets/documentos/" + id,
            '_blank' // <- This is what makes it open in a new window.
        );
    }

    function toastAlertDelete(id_documento, id_obra) {
        href = BASE_URL + 'documentos/delete/' + id_documento + '/' + id_obra + '/' + id_documento

        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": false,
            "progressBar": false,
            "positionClass": "toast-top-right",
            "preventDuplicates": true,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": 0,
            "extendedTimeOut": 0,
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut",
            "tapToDismiss": true
        }
        toastr.warning("<br><a type='button' href='" + href + "' class='btn btn-danger btn-flat'>Sim</a>", "Deseja deletar esse documento")


    }

    function dataFormatada() {
        var data = new Date();
        var dia = data.getDate();
        if (dia.toString().length == 1) {
            dia = "0" + dia;
        }
        var mes = data.getMonth() + 1;
        if (mes.toString().length == 1) {
            mes = "0" + mes;
        }
        var ano = data.getFullYear();

        return ano + "-" + mes + "-" + dia;
    }
</script>