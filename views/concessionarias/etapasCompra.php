<?php $etapasConcessionaria = $this->etapa->getEtapasByTipo('COMPRA', $tableInfo['id_concessionaria'], $tableInfo['id_servico']); ?>
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
                    <div class="box-header with-border">
                        <h3 class="box-title">Todas as Etapas de Compras</h3>
                    </div>

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
                                <?php foreach ($etapasConcessionaria as $etpComp) : ?>
                                    <?php include('modalEditarEtapa.php'); ?>

                                    <tr>
                                        <td>
                                            <a type="button" data-toggle="tooltip" title="" data-original-title="Deletar" class="btn btn-danger" href="<?php echo BASE_URL ?>concessionarias/delete_etapa/<?php echo $etpComp['id']; ?>/<?php echo $tableInfo['id_concessionaria']; ?>/<?php echo $tableInfo['id_servico']; ?>/compra"><i class="ion ion-trash-a"></i></a>
                                            <a type="button" class="btn btn-info" onclick="modalEditar(<?php echo $etpComp['id']; ?>, 'Comp')"><i class="ion-android-create"></i></a>
                                        </td>
                                        <td><?php echo $etpComp['etp_nome']; ?></td>
                                        <td>
                                            <a href="<?php echo BASE_URL; ?>concessionarias/add_etapa/<?php echo $tableInfo['id_concessionaria']; ?>/<?php echo $tableInfo['id_servico']; ?>/<?php echo $etpComp['id']; ?>/compra" class="btn btn-primary btn-xs pull-right"><i class="fa fa-arrow-right"></i> Adicionar</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                <tr>
                                    <td colspan="2">

                                    </td>

                                    <td>

                                        <button data-toggle="modal" data-target="#modalCadastro" class="btn btn-primary btn-xs pull-right"><i class="fa fa-arrow-right"></i> Novo</button>

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

        
    });
</script>