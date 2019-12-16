<div class="modal fade bd-example-modal-lg" id="modalCadastro" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="POST" enctype="multipart/form-data" action="<?php echo BASE_URL ?>obras/add_action">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <h2 class="modal-title fc-center" align="center" id="">Cadastro de Obra</h2>
                        </div>
                        <?php if ($this->concessionaria->getCount($this->userInfo['user']->getCompany()) == 0) : ?>
                        <div>
                            <h3 class="text-center text-red">Para fazer o cadastro de obra, precisa ter uma concessionaria Cadastrada</h3>
                            <div class="modal-footer">
                                <a href="<?php echo BASE_URL;?>concessionarias/?modalcadastro=true" class="btn btn-primary btn-salvar">Cadastrar</a>
                            </div>
                        </div>
                        <?php else : ?>
                        <div class="modal-body">
                            <div class="box box-default box-solid">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="box-header with-border">
                                            <h3 class="box-title">Dados</h3>
                                        </div>
                                        <div class="box-body" style="">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Nome da Obra</label>
                                                    <input type="text" class="form-control" name="obra_nome" id="obra_nome" autocomplete="off" required>
                                                </div>

                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Concessionaria</label>
                                                    <select class="form-control select2 concessionaria_select" style="width: 100%;" name="concessionaria" id="id_concessionaria" aria-hidden="true" required>
                                                        <option value="">selecione</option>
                                                        <?php foreach ($viewData['concessionaria'] as $com) : ?>
                                                        <option value="<?php echo $com['id']; ?>"><?php echo $com['razao_social'] ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Tipo de Obra/Serviço</label>
                                                    <select class="form-control select2 service_select" style="width: 100%;" name="servico" id="id_servico" required>
                                                        <option value="">selecione a concessionaria</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-12" style="margin-bottom:6px;">
                                                <label>Cliente</label>
                                                <div class="input-group">
                                                    <input type="hidden" name="id_cliente" id="id_cliente" class="form-control">
                                                    <input type="text" class="form-control" name="cliente" id="cliente" required data-type="search_cliente" required="" autocomplete="off">
                                                    <span onclick="add_cliente()" style="cursor: pointer;border-color: #f00;border-left: 1%;" class="input-group-addon span-cliente"><i class="fa fa-check has-error"></i></span>
                                                </div>
                                                <div id="art" type="hidden">

                                                    <span class="span-dropdown">
                                                        <span class="span-dropdown-2">
                                                            <ul class="ul-span-dropdown">
                                                                <div class="searchresultscliente">

                                                                </div>
                                                            </ul>
                                                        </span>
                                                    </span>

                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="box box-primary span_etapa" style="display:none;">
                                                    <div class="box-header">
                                                        <i class="ion ion-clipboard"></i>
                                                        <h3 class="box-title tarefas-tittle">Tarefas de ""</h3>
                                                    </div>
                                                    <div class="box-body">
                                                        <ul class="todo-list">

                                                            <div class="" id="id_sub_etapas">
                                                            </div>

                                                        </ul>
                                                    </div>
                                                    <!--<div class="box-footer clearfix no-border">
                                                        <button type="button" class="btn btn-default pull-right"><i class="fa fa-plus"></i> Add item</button>
                                                    </div>-->
                                                </div>

                                                <div class="box box-primary result_null" style="display:none;">
                                                    <div class="box-header">

                                                    </div>
                                                    <div class="box-body">
                                                        <div style="text-align: center;">
                                                            <span class="" id="result_null"> </span>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary btn-salvar">Salvar</button>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>


<script type="text/javascript">
    $(function() {



        $('#id_concessionaria').change(function() {

            var select = $('.concessionaria_select').select2('data');
            if (select) {

            }

            if ($(this).val()) {
                $.getJSON('ajax/searchServicoByConcessionaria?search=', {
                    id_concessionaria: select[0].id,
                    ajax: 'true'
                }, function(j) {
                    var options = '<option value="">selecione</option>';

                    if (j.length != 0) {
                        for (var i = 0; i < j.length; i++) {
                            options += '<option value="' + j[i].id_servico + '">' + j[i].sev_nome + '</option>';

                        }
                        $('#id_servico').html(options).show();
                        $('.span_etapa').hide();



                    } else {

                    }


                });
            } else {
                options = 'Selecione o Serviço'
                $('.span_etapa').hide();

                $('#result_null').html(options).show();
                $('.result_null').show();
            }
        });



        $('#id_servico').change(function() {

            var select = $('.concessionaria_select').select2('data');
            if (select) {}
            service = $('.service_select').select2('data');


            if ($(this).val()) {
                $.getJSON('ajax/search_categoria?search=', {
                    id_servico: $(this).val(),
                    id_concessionaria: select[0].id,
                    ajax: 'true'
                }, function(j) {
                    var options = '';


                    if (j.length != 0) {
                        for (var i = 0; i < j.length; i++) {

                            options += '<li style="    border-radius: 2px;padding: 10px;background: #f4f4f4;margin-bottom: 2px;border-left: 2px solid #e6e7e8;color: #444;">';
                            options += '<span class="text" name="etapa_obra[]" >' + j[i].nome_sub_categoria + '</span>';
                            options += '';
                            options += '</li>';

                            $('.tarefas-tittle').html('Tarefas de ' + service[0].text)

                        }
                        $('#id_sub_etapas').html(options).show();
                        $('.span_etapa').show();
                        $('.result_null').hide();

                    } else {
                        options = 'Não existem Etapas desse serviço com essa concessionaria. Por favor, refaça a busca'
                        $('.span_etapa').hide();

                        $('#result_null').html(options).show();
                        $('.result_null');
                    }


            } else {
                options = 'Selecione o Serviço'
                $('.span_etapa').hide();

                $('#result_null').html(options).show();
                $('.result_null').show();
            }
        });

        $('#cliente').on('keyup', function() {
            var datatype = $(this).attr('data-type');
            var q = $(this).val();

            if (datatype != '') {
                $.ajax({
                    url: BASE_URL + 'ajax/' + datatype,
                    type: 'GET',
                    data: {
                        q: q
                    },
                    dataType: 'JSON',
                    success: function(json) {
                        if ($('.searchresultscliente').length == 0) {
                            $('#art').after('<div class="searchresultscliente"></div>');

                        }

                        $('.searchresultscliente').css('left', $('#art').offset().left + 'px');
                        $('.searchresultscliente').css('top', $('#art').offset().top + $('#art').height() + 5 + 'px');

                        var html = '';

                        for (var i in json) {
                            html += '<li class="select2-results__option"  role="treeitem" aria-selected="true" href="javascript:;" onclick="selectcliente(this)" data-id="' + json[i].id + '">' + json[i].apelido + '</li>';
                        }

                        $('.searchresultscliente').html(html);
                        $('.searchresultscliente').show();
                    }
                });
            }

        });



    });

    function selectcliente(obj) {
        var id = $(obj).attr('data-id');
        var name = $(obj).html();

        $(".span-cliente").css("border-color", "#09a916");
        $('.searchresultscliente').hide();
        $('#cliente').val(name);
        $('#id_cliente').val(id);
    }

    function add_cliente(obj) {
        var name = $('#cliente').val();

        if (name != '') {

            swal({
                    title: "Tem certeza",
                    text: "Você esta adicionando um cliente: " + name,
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        $.ajax({

                            url: BASE_URL + 'ajax/add_cliente',
                            type: 'POST',
                            data: {
                                name: name
                            },
                            dataType: 'json',
                            success: function(json) {
                                swal({
                                    title: "Sucesso!",
                                    text: "Cadastro efetuado com sucesso",
                                    icon: "success",


                                })
                                $(".span-cliente").css("border-color", "#09a916");
                                $('.searchresultscliente').hide();

                                $('#id_cliente').val(json.id);

                            },
                            error: function(data) {
                                swal({
                                    title: "Oops!!",
                                    text: "Ja existe um cliente: " + name,
                                    icon: "warning",


                                })
                            }

                        });
                    } else {

                    }
                });
        }
    }
</script>