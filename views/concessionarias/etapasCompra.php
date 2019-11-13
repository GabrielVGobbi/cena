<?php

$etapasConcessionaria = $this->etapa->getEtapasByTipo($ffset = 0, 'COMPRA', $tableInfo['id_concessionaria'], $tableInfo['id_servico']);

?>









<?php include_once("modalcadastro.php"); ?>

<div class="box box-default box-solid collapsed-box " id="boxcompra">
    <a type="button" class="boxcompra" style="cursor:pointer">
        <div class="box-header with-border">
            <i class="ion ion-clipboard"></i>
            <h3 class="box-title">Etapas Compras</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool"><i class="fa fa-plus-circle"></i></button>
            </div>

        </div>
    </a>
    <div class="box-body" style="">
        <div class="row">
            <div class="col-md-6">
                <div class="box box-primary">
                    <div class="box-body">
                        <div class="card-body">
                            <table id="listar-etapas" class="table table-bordered table-striped dataTable" style="width:100%">

                                <thead>
                                    <tr role="row">
                                        <th style="width: 20%;"> Ação </th>
                                        

                                        <th> Nome</th>

                                    </tr>
                                </thead>
                            </table>
                            <button data-toggle="modal" data-target="#modalCadastro" class="btn btn-primary btn-xs pull-right"><i class="fa fa-arrow-right"></i> Novo</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="box box-success">
                    <div class="box-header with-border">
                        <h3 class="box-title">Etapas Selecionadas</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <div class="box-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Nome da Etapa</th>
                                    <th style="width: 240px">&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $etapasByServiceConcessionaria = $this->etapa->getEtapasByServicoConcessionaria('COMPRA', $tableInfo['id_concessionaria'], $tableInfo['id_servico']); ?>
                                <?php foreach ($etapasByServiceConcessionaria as $etpSC) : ?>
                                    <tr>
                                        <td><?php echo $etpSC['etp_nome']; ?></td>
                                        <td>
                                            <a href="<?php echo BASE_URL; ?>concessionarias/remove_etapa/<?php echo $tableInfo['id_concessionaria']; ?>/<?php echo $tableInfo['id_servico']; ?>/<?php echo $etpSC['id']; ?>/compra" class="btn btn-primary btn-xs pull-right"><i class="fa fa-arrow-left"></i> Remover</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<div class="modal fade bd-example-modal-lg" id="modal_form" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h2 class="modal-title fc-center" align="center">/h2>
            </div>
            <div class="modal-body form">
                <form action="#" id="form" class="form-horizontal">
                    <input type="hidden" value="" name="id" />
                    <div class="box box-default box-solid">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Dados</h3>
                                </div>
                                <div class="box-body" style="">

                                    <div class="col-md-4">
                                        <div class="input-group">
                                            <label for="">Nome da Etapa</label>
                                            <input class="form-control" name="nome_etapa" value="" placeholder="Nome da Etapa">

                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="input-group">
                                            <label for="">Quantidade</label>
                                            <input class="form-control" name="quantidade" value="" placeholder="Nome da Etapa">
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="input-group">
                                            <label for="">Tipo</label>
                                            <input class="form-control" name="tipo_compra" value="" placeholder="Nome da Etapa">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="input-group">
                                            <label for="">Preço</label>
                                            <input class="form-control" name="preco" value="" placeholder="Nome da Etapa">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                  
                    
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Variaveis</h3>

                            <div class="box-tools pull-right">
                            </div>
                        </div>
                        <div class="box-body" id="variavel_etapa">
                            
                                

                        </div>

                    </div>
                   
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Save</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(function() {



        $("#form_etapa_compra").on("submit", function(event) {
            event.preventDefault();
            var data = $(this).serialize();

            id_concessionaria = <?php echo $tableInfo['id_concessionaria']; ?>;
            id_servico = <?php echo $tableInfo['id_servico']; ?>;

            $.ajax({

                url: BASE_URL + 'ajax/add_etapa',
                type: 'POST',
                data: data,
                dataType: 'json',
                success: function(json) {

                    window.location.href = BASE_URL + "concessionarias/editService/" + id_concessionaria + '/' + id_servico + '?tipo=compra';
                },
            });
        });

        $(document).ready(function() {
            id_concessionaria = <?php echo $tableInfo['id_concessionaria']; ?>;
            id_servico = <?php echo $tableInfo['id_servico']; ?>;


            var myTable = $('#listar-etapas').DataTable({
                "processing": true,
                "serverSide": true,
                "autoWidth": false,
                "language": {
                    "sEmptyTable": "Nenhum registro encontrado",
                    "sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
                    "sInfoEmpty": "Mostrando 0 até 0 de 0 registros",
                    "sInfoFiltered": "(Filtrados de _MAX_ registros)",
                    "sInfoPostFix": "",
                    "sInfoThousands": ".",
                    "sLengthMenu": "_MENU_ resultados por página",
                    "sLoadingRecords": "Carregando...",
                    "sProcessing": "Processando...",
                    "sZeroRecords": "Nenhum registro encontrado",
                    "sSearch": "Pesquisar",
                },
                "oPaginate": {
                    "sNext": "Próximo",
                    "sPrevious": "Anterior",
                    "sFirst": "Primeiro",
                    "sLast": "Último"
                },
                paginate: true, //Queremos paginas
                filter: true,
                "ajax": {
                    "url": BASE_URL + "ajax/buscarEtapa",
                    "type": "POST",
                    "data": {
                        id_concessionaria: id_concessionaria,
                        id_servico: id_servico
                    }

                },
            });

        });


    });

    function edit_person(id) {
        save_method = 'update';
        $('#form')[0].reset();
        $('.form-group').removeClass('has-error');
        $('.help-block').empty();

        //Ajax Load data from ajax
        $.ajax({
            url: BASE_URL + 'ajax/getEtapaComprabyId/' + id,
            type: "GET",
            dataType: "JSON",
            success: function(data) {

                $('[name="id"]').val(data.id);
                $('[name="nome_etapa"]').val(data.etp_nome);
                $('[name="quantidade"]').val(data.quantidade);
                $('[name="tipo_compra"]').val(data.tipo_compra);
                $('[name="preco"]').val('R$ '+formata(data.preco));
                $('#modal_form').modal('show');
                $('.modal-title').text('Editar Etapa "' + data.etp_nome + '"');

            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error get data from ajax');
            },
        });

        $.ajax({
            url: BASE_URL + 'ajax/getVariavelEtapa/' + id,
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                options = '';
                

                for (var i = 0; i < data.length; i++) {

                    console.log(data);

                    options += '<input type="hidden" class="form-control" value="" name="variavel['+data[i].id_variavel_etapa+'][id]" id="id_variavel" autocomplete="off">'
                    options += '<div class="row" style="    left: 10px;position: relative;">'
                    options += '    <div class="col-md-4">'
                    options += '        <div class="form-group" style="margin-right: 26px;margin-left: -10px;">'
                    options += '            <label>Nome da Variavel</label>'
                    options += '            <input type="text" class="form-control" value="'+data[i].nome_variavel+'" name="variavel['+data[i].id_variavel_etapa+'][nome_variavel]" id="nome_variavel" autocomplete="off">'
                    options += '        </div>'
                    options += '    </div>'
                    
                    options += '    <div class="col-md-2">'
                    options += '        <div class="form-group"  style="margin-right: 26px;margin-left: -10px;">'
                    options += '            <label>Preço</label>'
                    options += '            <input type="text" class="form-control" name="variavel['+data[i].nome_variavel+'][preco_variavel]" value="R$ '+data[i].preco_variavel+'" id="preco_variavel" autocomplete="off">'
                    options += '        </div>'
                    options += '    </div>'
                    options += '    <div class="col-md-2">'
                    options += '        <button type="button" style="position: relative;top: 25px;" data-toggle="tooltip" title="" onclick="deleteVariavelEtapa('+data[i].id_variavel_etapa+')" data-original-title="Deletar" class="btn btn-danger"><i class="ion ion-trash-a"></i></button>'
                    options += '    </div>'
                    options += '</div>'

                }
                $('#variavel_etapa').html(options).show();

            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error get data from ajax');
            },
        });


    }
</script>