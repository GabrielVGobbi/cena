<div class="box box-default ">
    <div class="box-header with-border">
        <h3 class="box-title">Cadastrar</h3>
    </div>

    <div class="box-body" style="">
        <form method="POST" enctype="multipart/form-data" action="<?php echo BASE_URL; ?>comercial/add_action">
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

                            <div class="col-md-8">
                                <div class="form-group">
                                    <label>Descrição</label>
                                    <input type="text" class="form-control" name="comercial_descricao" id="comercial_descricao" autocomplete="off" required>
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
                                    <select class="form-control select2 service_select" style="width: 100%;" name="servico" data-tipo="true" id="id_servico" required>
                                        <option value="">selecione a concessionaria</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4" style="margin-bottom:6px;">
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
                        </div>
                    </div>
                </div>
            </div>
            <!--
            
            -->

            <div class="box box-primary span_etapa" style="display:none;">
                <div class="box-header">
                    <i class="ion ion-clipboard"></i>
                    <h3 class="box-title tarefas-tittle">Compras de ""</h3>
                </div>
                <div class="box-body">
                    <ul class="todo-list">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>Quantidade</th>
                                    <th>Tipo</th>
                                    <th>Preço Uni.</th>
                                    <th>Sub-Total</th>
                                </tr>
                            </thead>
                            <tbody id="id_sub_etapas">
                            </tbody>
                            <tr>
                                <td colspan="3">Total </td>
                                <td colspan="1" id="total"> </td>
                                <td id="totalSub"> </td>
                            </tr>
                        </table>
                    </ul>
                </div>

                <div class="box box-default box-solid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box-header with-border">
                                <h3 class="box-title">Financeiro</h3>
                            </div>
                            <div class="box-body" style="">

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Valor da Proposta</label>
                                        <input  type="text" class="form-control" name="valor_proposta" id="totalProposta" autocomplete="off">
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Valor de Desconto</label>
                                        <input  type="text" class="form-control" onkeyup="updateDesconto()" name="valor_desconto" id="valor_desconto" autocomplete="off">
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Valor Negociado</label>
                                        <input  type="text" class="form-control" name="valor_negociado" id="Totalnegociado" autocomplete="off">
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Data de Envio</label>
                                        <input type="text" class="form-control" name="data_envio"  value="<?php echo date('d/m/y');?>" autocomplete="off" required="">
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
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

            <div class="pull-right">
                <button type="submit" class="btn btn-primary">Salvar</button>
            </div>
        </form>
    </div>
</div>


<script type="text/javascript">
    $(function() {

       

        $('#input_valor').keyup(function() {

            var total = $('#input_valor').val();
            var negociado = $('#Totalnegociado').val();

            negociado = negociado.replace('R$', '');
            negociado = negociado.replace(',00', '');
            negociado = negociado.replace('.', '');

            if (parseInt(negociado) < parseInt(total)) {
                alert('valor para receber é maior que valor negociado');
                $('#input_valor').val('');
                $('#valor_etapa_receber').val('');

            } else {
                $('#valor_etapa_receber').val('R$ ' +formata(total));
            }
        });


        $('#metodo_etapa').change(function() {
            var selecionado = $('.metodo_etapa').select2('data');

            if (selecionado[0].id == 1) {
                $('#metodo_valor').hide();
                $('#metodo_porcentagem').show();
                $('#valor_etapa_receber').val('');

            } else {
                $('#metodo_valor').show();
                $('#metodo_porcentagem').hide();
                $('#valor_etapa_receber').val('');
            }

        });

        $('#id_concessionaria').change(function() {

            var select = $('.concessionaria_select').select2('data');
            if (select) {

            }

            if ($(this).val()) {
                $.getJSON(BASE_URL + 'ajax/searchServicoByConcessionaria/true?search=', {
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

            if ($(this).attr('data-tipo') == true) {
                var tipo = true;
            } else {
                var tipo = false;
            }

            if ($(this).val()) {
                $.getJSON(BASE_URL + 'ajax/search_categoria/' + tipo + '?search=', {
                    id_servico: $(this).val(),
                    id_concessionaria: select[0].id,
                    ajax: 'true'
                }, function(j) {
                    var options = '';
                    var result = 0;

                    if (j.length != 0) {
                        for (var i = 0; i < j.length; i++) {


                            options += '<tr>';
                            //options += '<span class="text" name="etapa_obra[]" >' + j[i].nome_sub_categoria + '</span>';
                            options += '';

                            preco = 'R$ ' +formata(j[i].preco);


                            subtotal = j[i].preco * j[i].quantidade;

                            result += parseInt(j[i].preco);

                            options += '<td>' + j[i].nome_sub_categoria + '</td>';
                            options += '<td>' + '<input type="number" name="compra_quantidade[' + j[i].id + ']" onchange="updateSubTotal(this)"  data-price="' + j[i].preco + '" style="width: 30%;text-align:center" class="p_quant" value=' + j[i].quantidade + ' />' + '</td>';
                            options += '<td>' + j[i].tipo_compra + '</td>';
                            options += '<td>' + preco + '</td>';
                            options += '<td class="subtotal">' + 'R$ ' +formata(subtotal) + '</td>';
                            options += '</tr>';

                            $('.tarefas-tittle').html('Compras de ' + service[0].text)
                            $('#total').html('R$ ' +formata(result))
                        }
                        $('#id_sub_etapas').html(options).show();
                        $('.span_etapa').show();
                        $('.result_null').hide();

                        updateTotal();

                    } else {
                        options = 'Não existem Etapas desse serviço com essa concessionaria. Por favor, refaça a busca'
                        $('.span_etapa').hide();

                        $('#result_null').html(options).show();
                        $('.result_null').show();
                    }

                });

                $.getJSON(BASE_URL + 'ajax/search_categoria/?search=', {
                    id_servico: $(this).val(),
                    id_concessionaria: select[0].id,
                    ajax: 'true'
                }, function(j) {
                    var options = '';
                    var result = 0;

                    if (j.length != 0) {
                        for (var i = 0; i < j.length; i++) {

                            options += '<option value="'+ j[i].id +'">' + j[i].nome_sub_categoria + '</option>';

                        }
                        $('#id_sub_etapas_todas').html(options).show();


                    } else {
                        options = 'Não existem Etapas desse serviço com essa concessionaria. Por favor, refaça a busca'
                        $('.span_etapa').hide();

                        $('#result_null').html(options).show();
                        $('.result_null').show();
                    }


                });
            } else {
                options = 'Selecione o Serviço'
                $('.span_etapa').hide();

                $('#result_null').html(options).show();
                $('.result_null').show();
            }
        });

        $(function() {
            $('#comercialStatusSelect').on('change', function(event) {
                $.ajax({

                    url: BASE_URL + 'ajax/changeStatusComercial',
                    type: 'POST',
                    data: {
                        tipo: itemSelecionado.val(),
                        id_comercial: id_comercial
                    },
                    dataType: 'json',
                    success: function(json) {

                    },
                });
            });
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
                            html += '<li class="select2-results__option"  role="treeitem" aria-selected="true" href="javascript:;" onclick="selectcliente(this)" data-id="' + json[i].id + '">' + json[i].name + '</li>';
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

    

    function updateSubTotal(obj) {
        var quantidade = $(obj).val();
        if (quantidade <= 0) {
            $(obj).val(1);
            quantidade = 1;
        }
        var price = $(obj).attr('data-price');
        var subtotal = quantidade * price;


        $(obj).closest('tr').find('.subtotal').html('R$ ' +formata(subtotal));
        updateTotal();


    }

    function updateDesconto() {
        var total = 0;
        var desconto = $('input[id=valor_desconto]').val();
        var proposto = $('input[id=totalProposta]').val();

        desconto = desconto.replace('R$ ', '');
        proposto = proposto.replace('R$', '');
        proposto = proposto.replace(',00', '');
        proposto = proposto.replace('.', '');

        if ($('input[id=valor_desconto]').val() == '') {
            proposto = $('input[id=totalProposta]').val();
            $('input[id=Totalnegociado]').val('R$ ' +formata(proposto));
        } else {
            total = parseInt(proposto) - parseInt(desconto);
            $('input[id=Totalnegociado]').val('R$ ' +formata(total));
        }



    }

    function formataNumbero(){

        var valor = $(this).val();

        return 'R$ ' +formata(valor);

    }

    function updateTotal() {

        var total = 0;

        for (var q = 0; q < $('.subtotal').length; q++) {

            var quantidade = $('.p_quant').eq(q);
            var price = quantidade.attr('data-price');
            var subtotal = price * parseInt(quantidade.val());

            total += subtotal;
        }

        $('#totalSub').html('R$ ' +formata(total));
        $('input[id=totalProposta]').val('R$ ' +formata(total));
        $('input[id=Totalnegociado]').val('R$ ' +formata(total));

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