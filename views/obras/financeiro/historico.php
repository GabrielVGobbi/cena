<div class="modal fade bd-example-modal-xl" tabindex="-1" id="modalHistorico<?php echo $etpF['histf_id']; ?>" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title text-center">Lançamento de Faturamento</h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" id="hist_faturamento" action="<?php echo BASE_URL; ?>financeiro/add_historico">
                    <div class="box box-danger" id="boxDanger">
                        <div class="box-header with-border">
                            <h3 class="box-title"><?php echo $etpF['etp_nome_etapa_obra']; ?> </h3>
                            <span id="spanValor<?php echo $etpF['histf_id']; ?>" class="pull-right"></span>
                            <input type="hidden" class="form-control" data-value="<?php echo $etpF['valor_receber']; ?>" value="" name="valor_receber" id="valor_receber<?php echo $etpF['histf_id']; ?>" required="" autocomplete="off">
                            <input type="hidden" class="form-control" value="<?php echo $etpF['id_obra']; ?>" name="id_obra" id="id_obra" required="" autocomplete="off">
                            <input type="hidden" class="form-control" value="<?php echo $etpF['id_etapa']; ?>" name="id_etapa" id="id_etapa<?php echo $etpF['histf_id']; ?>" required="" autocomplete="off">
                        </div>
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <label>Coluna de Faturamento</label>
                                    <select class="form-control select2 select2-hidden-accessible " id="coluna_faturamento<?php echo $etpF['histf_id']; ?>" style="width: 100%;">
                                        <option value="0"> Escolha a coluna </option>
                                        <option value="Cena Admin"> Faturamento Cena Admin </option>
                                        <option value="Cena MO"> Faturamento Cena MO </option>
                                        <option value="Materiais"> Faturamento Materiais </option>
                                        <option value="Terceiros"> Faturamento Terceiros </option>
                                    </select>
                                </div>

                                <div class="col-md-2">
                                    <div id="formnf<?php echo $etpF['histf_id']; ?>" class="form-group">
                                        <label> NF Nº </label>
                                        <input type="text" class="form-control" name="nf_n" id="nf_n<?php echo $etpF['histf_id']; ?>" required="" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div id="fordata_emissao<?php echo $etpF['histf_id']; ?>" class="form-group">
                                        <label> Emissão </label>
                                        <input type="text" value="<?php echo date('d/m/Y'); ?>" class="form-control" name="data_emissao" id="data_emissao<?php echo $etpF['histf_id']; ?>" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask autocomplete="off">
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div id="fordata_vencimento<?php echo $etpF['histf_id']; ?>" class="form-group">
                                        <label> Vencimento </label>
                                        <input type="text" class="form-control" name="data_vencimento" id="data_vencimento<?php echo $etpF['histf_id']; ?>" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask autocomplete="off">
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div id="forvalor<?php echo $etpF['histf_id']; ?>" class="form-group">
                                        <label> Valor </label>
                                        <input type="text" class="form-control" name="valor_faturamento" id="valor_faturamento<?php echo $etpF['histf_id']; ?>" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="box box-default box-solid">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Historico</h3>
                                </div>
                                <input type="hidden" id="valor_etapa_receber_historico" onchange="verificarTotal()" value="" class="form-control">
                                <div class="box-body" style="">
                                    <div class="col-md-12">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Ação</th>
                                                    <th>Etapa</th>
                                                    <th>Faturamento</th>
                                                    <th>NF Nº</th>
                                                    <th>Emissão</th>
                                                    <th>Vencimento</th>
                                                    <th>Valor</th>
                                                    <th>Status</th>
                                                    <th>Recebido</th>
                                                </tr>
                                            </thead>
                                            <tbody class="id_historico_etapa">
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <div id="submit<?php echo $etpF['histf_id']; ?>" class="btn btn-primary">Salvar</div>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(function() {

        var id = <?php echo $etpF['histf_id']; ?>;

        $(document).ready(gethistorico);
        $(document).ready(valorReceber);



        $("#submit" + id).click(function() {

            var nf_n = $('#nf_n' + id).val();
            var data_vencimento = $('#data_vencimento' + id).val();
            var data_emissao = $('#data_emissao' + id).val();
            var valor_faturamento = $('#valor_faturamento' + id).val();

            nf_n.length != '' ?
                $("#formnf" + id).removeClass("has-error") :
                $("#formnf" + id).addClass("has-error") + toastr.error('Nome é Obrigatorio')

            data_vencimento.length != '' ?
                $("#fordata_vencimento" + id).removeClass("has-error") :
                $("#fordata_vencimento" + id).addClass("has-error") + toastr.error('Data de Vencimento é Obrigatorio')

            data_emissao.length != '' ?
                $("#fordata_emissao" + id).removeClass("has-error") :
                $("#fordata_emissao" + id).addClass("has-error") + toastr.error('Data de Emissão é Obrigatorio')

            valor_faturamento.length != '' ?
                $("#forvalor" + id).removeClass("has-error") :
                $("#forvalor" + id).addClass("has-error") + toastr.error('Valor é Obrigatorio')

            $(document).ready(submit);

        });

        function submit() {
            if (!$(".form-group").hasClass("has-warning") && !$(".form-group").hasClass("has-error")) {

                var nf_n = $('#nf_n' + id).val();
                var data_vencimento = $('#data_vencimento' + id).val();
                var data_emissao = $('#data_emissao' + id).val();
                var valor_faturamento = $('#valor_faturamento' + id).val();
                var id_obra = $('#id_obra').val();
                var id_etapa = $('#id_etapa' + id).val();
                var data_value = $("#valor_receber" + id).attr('data-value');

                var coluna_faturamento = $('#coluna_faturamento' + id).select2('data');
                var coluna = coluna_faturamento[0].id;

                if (coluna != '0') {

                    var id_obra = <?php echo $etpF['id_obra']; ?>

                    if (id_obra != 0) {

                        var id_obra = $('#id_obra').val();

                        $.ajax({

                            url: BASE_URL + 'ajax/addHistoricoFaturamento',
                            type: 'POST',
                            data: {
                                id_obra: id_obra,
                                id_etapa: id_etapa,
                                id: id,
                                coluna: coluna,
                                nf_n: nf_n,
                                data_vencimento: data_vencimento,
                                data_emissao: data_emissao,
                                valor_faturamento: valor_faturamento,
                                data_value: data_value
                            },
                            dataType: 'json',
                            success: function(json) {


                                toastr.success('Concluido');


                                window.location.replace(BASE_URL + 'financeiro/obra/' + id_obra + '?hist=' + id)


                            },
                        });

                    } else {
                        toastr.error('Selecione a coluna');

                    }

                } else {
                    /*$("#addHistorico").css("display", "none");*/

                    toastr.error('Selecione a coluna');
                }
            } else {}

        }

        $("#valor_faturamento" + id).on("input", function() {

            var valor_digitado = $('#valor_faturamento' + id).val();
            var valor_receber = $('#valor_receber' + id).val();

            valor_receber = valor_receber.replace('R$ ', '');
            valor_receber = valor_receber.replace('R$', '');
            valor_receber = valor_receber.replace(',00', '');
            valor_receber = valor_receber.replace('.', '');
            valor_digitado = valor_digitado.trim();

            if (valor_digitado != '') {

                if (parseInt(valor_digitado) > parseInt(valor_receber)) {

                    toastr.error('o valor de lançamento não pode ser maior que o de receber');
                    $('#valor_faturamento' + id).val('0,00');
                    $(document).ready(valorReceber);

                } else {
                    var total = parseInt(valor_receber) - parseInt(valor_digitado);

                    $("#spanValor" + id).html('R$ ' + formata(total));
                    $("#valor_receber" + id).attr('data-value', total);

                    // $(document).ready(valorReceber);

                }
            } else {


                $(document).ready(valorReceber);

            }
        });



        function valorReceber() {
            $.ajax({
                url: BASE_URL + 'ajax/valorReceber',
                type: 'GET',
                data: {
                    q: <?php echo $etpF['histf_id']; ?>
                },
                dataType: 'JSON',
                success: function(json) {

                    if (json == '') {

                        $("#spanValor" + id).html('R$ ' + formata('<?php echo $etpF['valor_receber']; ?>'));
                        $('#valor_receber' + id).val('R$ ' + formata(<?php echo $etpF['valor_receber']; ?>));

                    } else {

                        $("#spanValor" + id).html('R$ ' + formata(json));
                        $('#valor_receber' + id).val('R$ ' + formata(json));

                        //$("#boxDanger").css("display", "none");
                    }
                    if (json == 0) {
                        //$("#boxDanger").css("display", "none");
                        $("#submit" + <?php echo $etpF['histf_id']; ?>).css("display", "none");

                    } else {
                        $("#boxDanger").css("display", "");
                        $("submit" + <?php echo $etpF['histf_id']; ?>).css("display", "");
                    }
                }
            });

        }

    });

    function receberFaturamento(v) {
        var id_historico = $(v).attr('data-id');
        var id_obra = $('#id_obra').val();
        var id = <?php echo $etpF['histf_id']; ?>;
        var id_etapa = $(v).attr('data-etapa');


        $.ajax({
            url: BASE_URL + 'ajax/receberFaturamento',
            type: 'POST',
            data: {
                q: $(v).val(),
                histfa_id: id_historico,
                id_obra: id_obra,
                id_etapa: id_etapa,
            },
            dataType: 'JSON',
            success: function(json) {

                if (json == 1) {
                    toastr.success('Etapa Recebida');

                } else {
                    toastr.warning('Etapa DesRecebida');
                }


                gethistorico();

            }
        });


    }

    function gethistorico() {

        var id_obra = $('#id_obra').val();
        var getName = '<?php echo isset($_GET['histNota']) ? $_GET['histNota'] : 'none';?>';

        $.getJSON(BASE_URL + 'ajax/getHistoricoFaturamento/?search=', {
            id_obra: $('#id_obra').val(),
            ajax: 'true'
        }, function(j) {
            var options = '';
            var result = 0;
            if (j.length != 0) {
                for (var i = 0; i < j.length; i++) {

                    var check = j[i].recebido_status == 1 ? 'checked' : '';

                    var color = (getName == j[i].nf_n) ? 'background-color: #f98e8e;' : '';
                    console.log(color);

                    options += '<tr style="'+ color + '" >';
                    options += '<td><a type="button" data-toggle="tooltip" title="" data-original-title="Deletar" class="btn btn-danger" href="<?php echo BASE_URL; ?>financeiro/deleteHistoricoFaturamento/' + j[i].histfa_id + '/' + j[i].id_historico + '/<?php echo $etpF['id_obra']; ?>"><i class="ion ion-trash-a"></i></a></td>';
                    options += '<td>' + j[i].etp_nome + '</td>';

                    options += '<td>' + j[i].coluna_faturamento + '</td>';
                    options += '<td>' + j[i].nf_n + '</td>';
                    options += '<td>' + j[i].data_emissao + '</td>';
                    options += '<td>' + j[i].data_vencimento + '</td>';
                    options += '<td>' + 'R$ '+formata(j[i].valor) + '</td>';

                    if (check == 'checked') {
                        options += '<td><span data-toggle="tooltip" title=""  data-original-title="Etapa Recebida" class="label label-success">Recebido</span></td>';
                    } else {
                        options += '<td><span data-toggle="tooltip" title=""  data-original-title="Etapa Faturada" class="label label-success">Faturado</span></td>'

                    }
                    options += '<td class="text-center"><input ' + check + ' onclick="receberFaturamento(this)" value="' + j[i].recebido_status + '" name="recebido_check" id="checkRecebido" data-id="' + j[i].histfa_id + '" data-etapa="' + j[i].id_etapa_historico_faturamento + '" type="checkbox" ></td>';
                    options += '<input type="hidden" class="form-control"  value="' + j[i].valor + '"  name="valor_guardado" id="valor_guardado' + j[i].id_historico + '" autocomplete="off">';
                    options += '<input type="hidden" class="form-control"  value="' + j[i].histfa_id + '"  id="id_historico"  autocomplete="off">';
                    options += '<input type="hidden" class="form-control"  value="' + j[i].id_etapa_historico_faturamento + '"  id="id_etapa_historico_faturamento"  autocomplete="off">';
                    
                }

                $('.id_historico_etapa').html(options).show();


            } else {

            }

        });


    }
</script>