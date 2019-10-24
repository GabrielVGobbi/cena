$(function () {

    $( document ).ready( readyFn );
    $( document ).ready( gethistorico );
    

    function gethistorico() {  
        
    
        var id_comercial_1 = $('#id_comercial').val()

        $.getJSON(BASE_URL + 'ajax/getHistorico/?search=', {
            id_comercial: $('#id_comercial').val(),
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
                        options += '<td>';
                        options += '<a type="button" data-toggle="tooltip" title="" data-original-title="Deletar" class="btn btn-danger" href="'+ BASE_URL +'/comercial/deleteHistorico/'+id_comercial_1+'/'+id_historico+'"><i class="ion ion-trash-a"></i></a></td>';

                    options += '</tr>';
                }

                $('#id_historico_etapa').html(options).show();
                var valor_historico = $('#valor_etapa_receber_historico').val(result);

                var total = $('#Totalnegociado').val();
                var totalReplaceRS = total.replace('R$ ', '');
                var totalReplaceZero = totalReplaceRS.replace(',00', '');
                var totalReplacePonto = totalReplaceZero.replace('.', '');


                if(valor_historico[0].value >= totalReplacePonto){
                    
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

        $.getJSON(BASE_URL + 'ajax/getEtapa/?search=', {
            id_servico: $('#id_servico').val(),
            id_concessionaria: $('#id_concessionaria').val(),
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
           
            var id_comercial =  $('#id_comercial').val();

            if (metodo_valor != '') {

                $.ajax({

                    url: BASE_URL + 'ajax/addHistoricoComercial',
                    type: 'POST',
                    data: {
                        metodo_valor: metodo_valor,
                        metodo: metodo,
                        id_etapa: id_etapa,
                        id_comercial: id_comercial,
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