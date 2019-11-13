<?php $etapasConcessionaria = $this->etapa->getEtapasByTipo($offset = 0, 'OBRA', $tableInfo['id_concessionaria'], $tableInfo['id_servico']); ?>

<div class="box box-default box-solid collapsed-box " id="boxobra">
    <a type="button" class="boxobra" style="cursor:pointer">
        <div class="box-header with-border">
            <i class="ion ion-clipboard"></i>
            <h3 class="box-title">Etapas Obras</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool"><i class="fa fa-plus-circle"></i></button>
            </div>

        </div>
    </a>
    <div class="box-body" style="">
        <div class="row">
            <div class="col-md-6">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Todas as Etapas Obras</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <div class="box-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th style="width:120px;"> Ações </th>
                                    <th style="width:;">Nome da Etapa</th>
                                    <th style="width:10%; ">&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($etapasConcessionaria as $etpObra) : ?>
                                    <?php include('modalEditarEtapa.php'); ?>

                                    <tr>
                                        <td>
                                            <a type="button" data-toggle="tooltip" title="" data-original-title="Deletar" class="btn btn-danger" href="<?php echo BASE_URL ?>concessionarias/delete_etapa/<?php echo $etpObra['id']; ?>/<?php echo $tableInfo['id_concessionaria']; ?>/<?php echo $tableInfo['id_servico']; ?>/obra"><i class="ion ion-trash-a"></i></a>
                                            <a type="button" class="btn btn-info" onclick="modalEditar(<?php echo $etpObra['id']; ?>, 'Obr')"><i class="ion-android-create"></i></a>
                                        </td>
                                        <td><?php echo $etpObra['etp_nome']; ?></td>
                                        <td>
                                            <a href="<?php echo BASE_URL; ?>concessionarias/add_etapa/<?php echo $tableInfo['id_concessionaria']; ?>/<?php echo $tableInfo['id_servico']; ?>/<?php echo $etpObra['id']; ?>/obra" class="btn btn-primary btn-xs pull-right"><i class="fa fa-arrow-right"></i> Adicionar</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                <tr>
                                    <td colspan="2"><input placeholder="Add Etapa Obra" id="etapa_input_obra" type="text" value="" name="add_etapa"></td>
                                    <td>
                                        <button id="new_etapa_obr" class="btn btn-primary btn-xs pull-right"><i class="fa fa-arrow-right"></i> Novo</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
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
                                <?php $etapasByServiceConcessionaria = $this->etapa->getEtapasByServicoConcessionaria('OBRA', $tableInfo['id_concessionaria'], $tableInfo['id_servico']); ?>
                                <?php foreach ($etapasByServiceConcessionaria as $etpSC) : ?>
                                    <tr>
                                        <td><?php echo $etpSC['etp_nome']; ?></td>
                                        <td>
                                            <a href="<?php echo BASE_URL; ?>concessionarias/remove_etapa/<?php echo $tableInfo['id_concessionaria']; ?>/<?php echo $tableInfo['id_servico']; ?>/<?php echo $etpSC['id']; ?>/obra" class="btn btn-primary btn-xs pull-right"><i class="fa fa-arrow-left"></i> Remover</a>
                                            <a href="<?php echo BASE_URL; ?>concessionarias/order/<?php echo $tableInfo['id_concessionaria']; ?>/<?php echo $tableInfo['id_servico']; ?>/<?php echo $etpSC['id_ord_m']; ?>/obr/up" class="btn btn-primary btn-xs pull-right"><i class="fa fa-arrow-up"></i></a>
                                            <a href="<?php echo BASE_URL; ?>concessionarias/order/<?php echo $tableInfo['id_concessionaria']; ?>/<?php echo $tableInfo['id_servico']; ?>/<?php echo $etpSC['id_ord_m']; ?>/obr/down" class="btn btn-primary btn-xs pull-right"><i class="fa fa-arrow-down"></i></a>
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


<script>
    $(function() {
        $('#new_etapa_obr').on('click', function(event) {

            var q = $('#etapa_input_obra').val();
            tipo = 3;
            id_concessionaria = <?php echo $tableInfo['id_concessionaria']; ?>;
            id_servico = <?php echo $tableInfo['id_servico']; ?>;

            $.ajax({

                url: BASE_URL + 'ajax/add_etapa',
                type: 'POST',
                data: {
                    nome: q,
                    tipo: tipo,
                    id_servico: id_servico,
                    id_concessionaria: id_concessionaria
                },
                dataType: 'json',
                success: function(json) {

                    window.location.href = BASE_URL + "concessionarias/editService/" + id_concessionaria + '/' + id_servico + '?tipo=obra';
                },
            });
        });
    });
</script>