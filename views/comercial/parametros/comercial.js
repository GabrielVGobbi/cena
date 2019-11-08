
    $(function() {


        $('#totalProposta').keyup(function() {

            var valor = $('#totalProposta').val();

            valor = valor.replace('R$', '');
            valor = valor.replace(',00', '');
            valor = valor.replace('.', '');
            
            
            if (valor == '') {
                $('#Totalnegociado').val('R$ 1');
                $('#totalProposta').val('');
                $('#valor_desconto').val('');
            } else {
                $('#valor_desconto').val('');
                
                setTimeout(function() {
                    $('#Totalnegociado').val('R$ ' + formata(valor));
                    $('#totalProposta').val('R$ ' + formata(valor));
                    
                }, 2000);

                updateDesconto();
            }

            
        });


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
                $('#valor_etapa_receber').val('R$ ' + formata(total));
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
                            options += '';

                            precoformatado = 'R$ ' + formata(j[i].preco);


                            subtotal = j[i].preco * j[i].quantidade;

                            result += parseInt(j[i].preco);

                            options += '<td>' + j[i].nome_sub_categoria + '</td>';
                            
                            

                            if(j[i].variavel != ''){
                                options += '<td>' + '<select class="form-control select2" onchange="updatePriceVariavel(this)" id="select-variavel" style="width: 80%;" name="select-variavel" </td>'; 
                                options += '<option> selecione </option>'
                                for (var l = 0; l < j[i].variavel.length; l++) {
                                    
                                    options += '<option data-id="' + j[i].quantidade + '"  value="' + j[i].variavel[l].preco_variavel +'">' + j[i].variavel[l].nome_variavel +'  </option>';
                                    
                                    preco = '0';
                                    subtotal = preco * parseInt(j[i].quantidade);

                                    precoformatado = '0';
                                    id = j[i].variavel[l].id_variavel_etapa;
                                    

                                }

                                options += '<td>' + '<input type="number" id="preco_variavel" name="compra_quantidade[' + j[i].id + ']" onchange="updateSubTotal(this)"  data-price="" style="width: 30%;text-align:center" class="p_quant" value=' + j[i].quantidade + ' />' + '</td>';


                                options += '</select>';   
                                
                                
                                

                            }else {
                                options += '<td></td>'; 
                                options += '<td>' + '<input type="number" name="compra_quantidade[' + j[i].id + ']" onchange="updateSubTotal(this)"  data-price="' + j[i].preco + '" style="width: 30%;text-align:center" class="p_quant" value=' + j[i].quantidade + ' />' + '</td>';


                            }
                            
                            options += '<td>' + j[i].tipo_compra + '</td>';
                            options += '<td class="unitario">' + precoformatado + '</td>';
                            options += '<td class="subtotal">' + 'R$ ' + formata(subtotal) + '</td>';
                            options += '</tr>';

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
                }, function(j) {
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

        $(function() {
            $('#comercialStatusSelect').on('change', function(event) {
                $.ajax({

                    url: BASE_URL + 'ajax/changeStatusComercial',
                    type: 'POST',
                    data: {
                        tipo: itemSelecionado.val(),
                        id_obra: id_obra
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
        console.log(obj);

        var quantidade = $(obj).val();
        if (quantidade <= 0) {
            $(obj).val(1);
            quantidade = 1;
        }
        var price = $(obj).attr('data-price');
        var subtotal = quantidade * price;


        $(obj).closest('tr').find('.subtotal').html('R$ ' + formata(subtotal));
        updateTotal();


    }

    function updatePrice(){

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
        var total = 0;
        var desconto = $('input[id=valor_desconto]').val();
        var proposto = $('input[id=totalProposta]').val();

        desconto = desconto.replace('R$ ', '');
        proposto = proposto.replace('R$', '');
        proposto = proposto.replace(',00', '');
        proposto = proposto.replace('.', '');

        if ($('input[id=valor_desconto]').val() == '') {
            proposto = $('input[id=totalProposta]').val();
            $('input[id=Totalnegociado]').val('R$ ' + formata(proposto));
        } else {
            total = parseInt(proposto) - parseInt(desconto);
            $('input[id=Totalnegociado]').val('R$ ' + formata(total));
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

$(function () {


    if($('#id_obra').val() != undefined){
        $( document ).ready( readyFn );
        $( document ).ready( gethistorico );
    }
    

    function gethistorico() {  
        
        var id_obra_1 = $('#id_obra').val()

        $.getJSON(BASE_URL + 'ajax/getHistorico/?search=', {
            id_obra: $('#id_obra').val(),
            ajax: 'true'
        }, function(j) {
            var options = '';
            var result = 0;

            if (j.length != 0) {
                for (var i = 0; i < j.length; i++) {

                    if(j[i].metodo == 'valor'){
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
                        options += '<td>' + 'R$ '+formata(j[i].valor_receber) + '</td>';
                        options += '<td>';
                        options += '<a type="button" data-toggle="tooltip" title="" data-original-title="Deletar" class="btn btn-danger" href="'+ BASE_URL +'/comercial/deleteHistorico/'+id_obra_1+'/'+id_historico+'"><i class="ion ion-trash-a"></i></a></td>';

                    options += '</tr>';
                }

                $('#id_historico_etapa').html(options).show();
                var valor_historico = $('#valor_etapa_receber_historico').val(result);

                var total = $('#Totalnegociado').val();
                var totalReplaceRS = total.replace('R$ ', '');
                var totalReplaceZero = totalReplaceRS.replace(',00', '');
                var totalReplacePonto = totalReplaceZero.replace('.', '');

                if(parseInt(valor_historico[0].value) >= parseInt(totalReplacePonto)){
                    
                    $("#addHistorico").css("display","none")
                }

                

            } else {
                options = 'Não existem Etapas desse serviço com essa concessionaria. Por favor, refaça a busca'
                $('.span_etapa').hide();

                $('#result_null').html(options).show();
                $('.result_null').show();
            }

        });
    }
    function readyFn( jQuery ) {
        var id_obra = $('#id_obra').val()
        $.getJSON(BASE_URL + 'ajax/getEtapa/?search=', {
            id_servico: $('#id_servico').val(),
            id_concessionaria: $('#id_concessionaria').val(),
            id_obra: id_obra,
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

       
    }

    //Adicionar Historico 
    $('#addHistorico').on('click', function (event) {

        var metodo_selecionado = $('.metodo_etapa').select2('data');
        var etapa_selecionado = $('.etapa_selecionado').select2('data');

        var metodo = metodo_selecionado[0].id;

        if(metodo == 1){
            var metodo_valor = $('#input_porcentagem').val();
        }else {
            var metodo_valor = $('#input_valor').val();

        }

        var id_etapa = etapa_selecionado[0].id;
        var valor_receber = $('#valor_etapa_receber').val();


        if(id_etapa != 0){
           
            var id_obra =  $('#id_obra').val();

            if (metodo_valor != '') {

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
                alert('preencha todos os campos');
            }
        } else {
            alert('selecione a etapa')
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

    $('#metodo_porcentagem').keyup(function() {

        var negociado = $('#Totalnegociado').val();
        var porcentagem = $('#input_porcentagem').val();

        if (porcentagem > 100) {
            alert('Maximo 100');
            $('#input_porcentagem').val('');
            $('#valor_etapa_receber').val('');


        } else {
            negociado = negociado.replace('R$', '');
            negociado = negociado.replace(',00', '');
            negociado = negociado.replace('.', '');

            var total = negociado * (porcentagem / 100);

            $('#valor_etapa_receber').val('R$ ' + formata(total));
        }

    });

    $('#input_valor').keyup(function() {

        var metodo_valor = $('#input_valor').val();

        $('#valor_etapa_receber').val('R$ ' +formata(metodo_valor));

    });

    

});