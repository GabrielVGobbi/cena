
$(function () {


    var temporiza;
    $("#totalProposta").on("input", function () {

        var valor = $('#totalProposta').val();

        valor = valor.replace('R$ ', '');
        valor = valor.replace('R$', '');
        valor = valor.replace(',00', '');
        valor = valor.replace('.', '');
        valor = valor.trim();

        clearTimeout(temporiza);

        if (valor == '' || valor == 'NaN') {
            $('#Totalnegociado').val('R$ 0');
            $('#totalProposta').val('');
            $('#valor_desconto').val('');
        } else {
            $('#valor_desconto').val('');

            temporiza = setTimeout(function () {
                $('#totalProposta').val('R$ '+formata(valor));
                $('#Totalnegociado').val('R$ '+formata(valor));
            }, 1500);
            updateDesconto();
        }


    });


    $('#input_valor').keyup(function () {

        var total = $('#input_valor').val();
        var negociado = $('#Totalnegociado').val();

        negociado = negociado.replace('R$', '');
        negociado = negociado.replace(',00', '');
        negociado = negociado.replace('.', '');

        if (parseInt(negociado) < parseInt(total)) {
            toastr.error('valor para receber é maior que valor negociado');
            $('#input_valor').val('');
            $('#valor_etapa_receber').val('');

        } else {
            $('#valor_etapa_receber').val('R$ ' + formata(total));
        }
    });


    $('#metodo_etapa').change(function () {
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

    $('#id_concessionaria').change(function () {

        var select = $('.concessionaria_select').select2('data');
        if (select) {

        }

        if ($(this).val()) {
            $.getJSON(BASE_URL + 'ajax/searchServicoByConcessionaria/true?search=', {
                id_concessionaria: select[0].id,
                ajax: 'true'
            }, function (j) {
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



    $('#id_servico').change(function () {

        var select = $('.concessionaria_select').select2('data');
        if (select) { }
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
            }, function (j) {
                var options = '';
                var result = 0;

                if (j.length != 0) {
                    for (var i = 0; i < j.length; i++) {




                        options += '<tr>';
                        options += '';

                        precoformatado = 'R$ ' + formata(j[i].preco);


                        subtotal = j[i].preco * j[i].quantidade;

                        result += parseInt(j[i].preco);






                        if (j[i].variavel == '') {

                            options += '<td>' + j[i].nome_sub_categoria + '</td>';

                            options += '<td>' + '<input type="number" name="compra_quantidade[' + j[i].id + ']" onchange="updateSubTotal(this)"  data-price="' + j[i].preco + '" style="width: 30%;text-align:center" class="p_quant" value=' + j[i].quantidade + ' />' + '</td>';
                            options += '<td>' + j[i].tipo_compra + '</td>';
                            options += '<td class="unitario">' + precoformatado + '</td>';
                            options += '<td class="subtotal">' + 'R$ ' + formata(subtotal) + '</td>';
                            options += '</tr>';


                        } else {
                            options += '<td colspan="5"><div style="color:#ff0000" onclick="openVariavel(' + j[i].id + ')">' + j[i].nome_sub_categoria + '</div></td>'


                            options += '<tr >'
                            options += '<td colspan="5">'
                            options += '<div style="display: none;position: relative;border-radius: 12px;margin-bottom: 20px;box-shadow: 0 0px 1px rgba(0, 0, 0, 0.1);border-left: 1px solid #000000;border-right: 1px solid #0a0a0a;border-bottom: 1px solid #000000;" id="open_' + j[i].id + '">'

                            options += '<table class="table table-striped">'
                            options += '<thead>'
                            options += '<tr>'
                            options += '<th>Nome</th>'
                            options += '<th style="width: 24%;">Quantidade</th>'
                            options += '<th>Tipo</th>'
                            options += '<th>Preço Uni.</th>'
                            options += '<th>Sub-Total</th>'
                            options += '</tr>'
                            options += '</thead>'

                            for (var l = 0; l < j[i].variavel.length; l++) {
                                options += '<input type="hidden" name="variavel[id_variavel][]" value="'+j[i].variavel[l].id_variavel_etapa+'"></input>'
                                options += '<input type="hidden" name="variavel[id_etapa][]" value="'+j[i].id+'"></input>'


                                options += '<tr>';
                                options += '<td>' + j[i].variavel[l].nome_variavel + '</td>';
                                options += '<td>' + '<input type="number" id="preco_variavel" data-price="' + j[i].variavel[l].preco_variavel + '" name="variavel[compra_quantidade][]" onchange="updateSubTotal(this)"  data-price="" style="width: 30%;text-align:center" class="p_quant" value=' + j[i].quantidade + ' />' + '</td>';
                                options += '<td>' + j[i].tipo_compra + '</td>';
                                options += '<td class="unitario">' + 'R$ ' + formata(j[i].variavel[l].preco_variavel) + '</td>';

                                options += '<td class="subtotal">' + 'R$ ' + formata(subtotal) + '</td>';
                                options += '</tr>';

                            }

                            options += '</table>'

                            options += '</div>'
                            options += '</td>'
                            options += '</tr>'


                        }



                        $('.tarefas-tittle').html('Compras de ' + service[0].text)
                        //$('#total').html('R$ ' + formata(result))
                    }
                    $('#id_sub_etapas').html(options).show();
                    $('.span_etapa').show();
                    $('.result_null').hide();

                    updateTotal();

                } else {
                    options = 'Não existem compras desse serviço com essa concessionaria. Por favor, refaça a busca'
                    $('.span_etapa').hide();

                    $('#result_null').html(options).show();
                    $('.result_null').show();
                }

            });



            $.getJSON(BASE_URL + 'ajax/search_categoria/?search=', {
                id_servico: $(this).val(),
                id_concessionaria: select[0].id,
                ajax: 'true'
            }, function (j) {
                var options = '';
                var result = 0;

                if (j.length != 0) {
                    for (var i = 0; i < j.length; i++) {

                        options += '<option value="' + j[i].id + '">' + j[i].nome_sub_categoria + '</option>';

                    }
                    // $('#id_sub_etapas_todas').html(options).show();


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

    $(function () {
        $('#comercialStatusSelect').on('change', function (event) {
            $.ajax({

                url: BASE_URL + 'ajax/changeStatusComercial',
                type: 'POST',
                data: {
                    tipo: itemSelecionado.val(),
                    id_obra: id_obra
                },
                dataType: 'json',
                success: function (json) {

                },
            });
        });

        $("a[id^=show_]").click(function(event) {
            $("#extra_" + $(this).attr('id').substr(5)).slideToggle("slow");
            event.preventDefault();
        });



    });

    $('#cliente').on('keyup', function () {
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
                success: function (json) {
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

function openVariavel(id) {

    $('#open_' + id).toggle();



}




function updateSubTotal(obj) {

    var quantidade = $(obj).val();


    if (quantidade < 0) {
        $(obj).val(0);
        quantidade = 0;
    }
    var price = $(obj).attr('data-price');
    var subtotal = quantidade * price;




    $(obj).closest('tr').find('.subtotal').html('R$ ' + formata(subtotal));
    updateTotal();


}

function updatePrice() {

    var itemSelecionado = $('#select-variavel' + " option:selected");



    return itemSelecionado.val();

}

function updatePriceVariavel(obj) {


    var itemSelecionado = $('#select-variavel' + " option:selected");

    quantidade = $('#preco_variavel').val();

    $("#preco_variavel").attr('data-price', itemSelecionado.val());

    $(obj).closest('tr').find('.unitario').html('R$ ' + formata(itemSelecionado.val()));

    updateTotal();

    total = itemSelecionado.val() * parseInt(quantidade);

    $(obj).closest('tr').find('.subtotal').html('R$ ' + formata(total));



}

function updateDesconto() {

    if($('#totalProposta').val() != ''){

        var total = 0;
        var desconto = $('input[id=valor_desconto]').val();
        var proposto = $('input[id=totalProposta]').val();

        desconto = desconto.replace('R$ ', '');
        proposto = proposto.replace('R$', '');
        proposto = proposto.replace(',00', '');
        proposto = proposto.replace('.', '');
        proposto = proposto.trim();


        if ($('input[id=valor_desconto]').val() == '') {

            proposto = $('input[id=totalProposta]').val();
            proposto = proposto.replace('R$', '');
            proposto = proposto.replace(',00', '');
            proposto = proposto.replace('.', '');
            proposto = proposto.trim();
            $('input[id=Totalnegociado]').val('R$ ' + formata(proposto));

        } else {
            total = parseInt(proposto) - parseInt(desconto);
            $('input[id=Totalnegociado]').val('R$ ' + formata(total));
        }
    } else { 
        $('#valor_desconto').val('');
        $( "#totalProposta" ).focus();
         toastr.error('Digite um valor para a proposta');
        
    }

}

function formataNumbero() {

    var valor = $(this).val();

    return 'R$ ' + formata(valor);

}

function updateTotal() {

    var total = 0;

    for (var q = 0; q < $('.subtotal').length; q++) {

        var quantidade = $('.p_quant').eq(q);
        var price = quantidade.attr('data-price');
        var subtotal = price * parseInt(quantidade.val());

        total += subtotal;
    }

    $('#totalSub').html('R$ ' + formata(total));
    $('input[id=totalProposta]').val('R$ ' + formata(total));
    $('input[id=valor_custo]').val('R$ ' + formata(total));
    $('input[id=Totalnegociado]').val('R$ ' + formata(total));

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
                        success: function (json) {
                            swal({
                                title: "Sucesso!",
                                text: "Cadastro efetuado com sucesso",
                                icon: "success",


                            })
                            $(".span-cliente").css("border-color", "#09a916");
                            $('.searchresultscliente').hide();

                            $('#id_cliente').val(json.id);

                        },
                        error: function (data) {
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

$(function () {


    if ($('#id_obra').val() != undefined) {
        $(document).ready(readyFn);
        $(document).ready(gethistorico);
    }


    function gethistorico() {

        var id_obra_1 = $('#id_obra').val()

        $.getJSON(BASE_URL + 'ajax/getHistorico/?search=', {
            id_obra: $('#id_obra').val(),
            ajax: 'true'
        }, function (j) {
            var options = '';
            var result = 0;

            if (j.length != 0) {
                for (var i = 0; i < j.length; i++) {

                    if (j[i].metodo == 'valor') {
                        var tipo = 'R$ ' + formata(j[i].metodo_valor);
                    } else {
                        var tipo = j[i].metodo_valor + '%';

                    }
                    var id_historico = j[i].id_historico;

                    result += parseInt(j[i].valor_receber)

                    options += '<tr>';
                    options += '<td>' + j[i].etapa_nome + '</td>';
                    options += '<td>' + j[i].metodo + '</td>';
                    options += '<td>' + tipo + '</td>';
                    options += '<td>' + 'R$ ' + formata(j[i].valor_receber) + '</td>';
                    options += '<td>';
                    options += '<a type="button" data-toggle="tooltip" title="" data-original-title="Deletar" class="btn btn-danger" href="' + BASE_URL + '/comercial/deleteHistorico/' + id_obra_1 + '/' + id_historico + '"><i class="ion ion-trash-a"></i></a></td>';

                    options += '</tr>';
                }

                $('#id_historico_etapa').html(options).show();
                var valor_historico = $('#valor_etapa_receber_historico').val(result);

                var total = $('#Totalnegociado').val();
                var totalReplaceRS = total.replace('R$ ', '');
                var totalReplaceZero = totalReplaceRS.replace(',00', '');
                var totalReplacePonto = totalReplaceZero.replace('.', '');

                if (parseInt(valor_historico[0].value) >= parseInt(totalReplacePonto)) {

                    $("#addHistorico").css("display", "none")
                }



            } else {
                options = 'Não existem Etapas desse serviço com essa concessionaria. Por favor, refaça a busca'
                $('.span_etapa').hide();

                $('#result_null').html(options).show();
                $('.result_null').show();
            }

        });
    }
    function readyFn(jQuery) {
        var id_obra = $('#id_obra').val()
        $.getJSON(BASE_URL + 'ajax/getEtapa/?search=', {
            id_servico: $('#id_servico').val(),
            id_concessionaria: $('#id_concessionaria').val(),
            id_obra: id_obra,
            ajax: 'true'
        }, function (j) {
            var options = '';
            var result = 0;

            if (j.length != 0) {
                for (var i = 0; i < j.length; i++) {

                    options += '<option value="' + j[i].id + '">' + j[i].nome_sub_categoria + '</option>';

                }
                $('#id_sub_etapas_todas').html(options).show();

            } else {
                $("#id_sub_etapas_todas").empty();
                $("#addHistorico").css("display", "none");

            }
        });


    }

    //Adicionar Historico 
    $('#addHistorico').on('click', function (event) {

        var metodo_selecionado = $('.metodo_etapa').select2('data');
        var etapa_selecionado = $('.etapa_selecionado').select2('data');

        var metodo = metodo_selecionado[0].id;

        if (metodo == 1) {
            var metodo_valor = $('#input_porcentagem').val();
        } else {
            var metodo_valor = $('#input_valor').val();

        }
        if (etapa_selecionado != '') {
            var id_etapa = etapa_selecionado[0].id;
            var valor_receber = $('#valor_etapa_receber').val();

            if (id_etapa != 0) {

                var id_obra = $('#id_obra').val();

                if (metodo_valor != '') {
                    $("#formporcent").removeClass("has-error");
                    $.ajax({

                        url: BASE_URL + 'ajax/addHistoricoComercial',
                        type: 'POST',
                        data: {
                            metodo_valor: metodo_valor,
                            metodo: metodo,
                            id_etapa: id_etapa,
                            id_obra: id_obra,
                            valor_receber: valor_receber
                        },
                        dataType: 'json',
                        success: function (json) {
                            readyFn();
                            gethistorico();
                        },
                    });

                } else {
                    toastr.error('preencha todos os campos');
                    $("#formporcent").addClass("has-error");
                }
            } else {
                toastr.error('selecione a etapa');

            }
        } else {
            $("#addHistorico").css("display", "none");

            toastr.error('selecione a etapa');

        }


    });

    $('#metodo_etapa').change(function () {
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

    $('#metodo_porcentagem').keyup(function () {

        var negociado = $('#Totalnegociado').val();
        var porcentagem = $('#input_porcentagem').val();

        if (porcentagem > 100) {
            toastr.error('Maximo 100');
            $("#formporcent").addClass("has-error");
            $('#input_porcentagem').val('');
            $('#valor_etapa_receber').val('');


        } else {
            negociado = negociado.replace('R$', '');
            negociado = negociado.replace(',00', '');
            negociado = negociado.replace('.', '');

            var total = negociado * (porcentagem / 100);

            $('#valor_etapa_receber').val('R$ ' + formata(total));
            $("#formporcent").removeClass("has-error");
        }

    });

    $('#input_valor').keyup(function () {

        var metodo_valor = $('#input_valor').val();

        $('#valor_etapa_receber').val('R$ ' + formata(metodo_valor));

    });



});