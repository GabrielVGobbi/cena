<div class="box box-default ">
    <div class="box-header with-border">
        <h3 class="box-title">Selecione as Etapas Para: <?php echo $titlePage; ?></h3>

        <a type="button" data-toggle="tooltip" title="" data-original-title="Duplicar" class="btn btn-warning pull-right" onclick="openImport()"><i class="fa fa-paste"></i></a>

    </div>

    <div class="box-body" style="">
        <div class="box-body">
            <div class="row">
                <?php include_once('etapasConcessionaria.php'); ?>
                <?php include_once('etapasAdministrativa.php'); ?>
                <?php include_once('etapasObra.php'); ?>
                <?php include_once('etapasCompra.php'); ?>
            </div>
            <div class="pull-right">
                <a href="<?php echo BASE_URL; ?>concessionarias/edit/<?php echo $tableInfo['id_concessionaria']; ?>" type="" class="btn btn-primary">Voltar</a>
            </div>
        </div>
    </div>

    <div class="modal" id="modalImportar" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="formDuplicar" action="<?php echo BASE_URL ?>concessionarias/duplicarEtapa" method="POST">
                    <input type="hidden" class="form-control" name="id_concessionaria" id="id_concessionaria" value="<?php echo $tableInfo['id_concessionaria']; ?>" autocomplete="off">
                    <input type="hidden" class="form-control" name="id_servico" id="id_servico" value="<?php echo $tableInfo['id_servico']; ?>" autocomplete="off">
                    <div class="modal-header">
                        <h2 class="modal-title text-center">Duplicação de "<?php echo $tableInfo['sev_nome']; ?>" x "<?php echo $tableInfo['razao_social']; ?>"</h2>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="box-body">
                            <div class="row">

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Nome do Serviço</label>
                                        <input type="text" class="form-control" name="sev_nome" id="sev_nome" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Salvar</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $(function() {
            <?php if (isset($_GET['tipo'])) : ?>
                var tipo = '<?php echo $_GET['tipo']; ?>';

                $('#box' + tipo).boxWidget('toggle');

            <?php endif; ?>


            $('.boxcom').on('click', function(e) {
                $('#boxcom').boxWidget('toggle');
                $('#boxadm').boxWidget('collapse');
                $('#boxobra').boxWidget('collapse');
                $('#boxcompra').boxWidget('collapse');

            });

            $('.boxadm').on('click', function(e) {
                $('#boxcom').boxWidget('collapse');
                $('#boxadm').boxWidget('toggle');
                $('#boxobra').boxWidget('collapse');
                $('#boxcompra').boxWidget('collapse');

            });

            $('.boxobra').on('click', function(e) {
                $('#boxcom').boxWidget('collapse');
                $('#boxadm').boxWidget('collapse');
                $('#boxcompra').boxWidget('collapse');
                $('#boxobra').boxWidget('toggle');

            });

            $('.boxcompra').on('click', function(e) {
                $('#boxcom').boxWidget('collapse');
                $('#boxadm').boxWidget('collapse');
                $('#boxcompra').boxWidget('toggle');
                $('#boxobra').boxWidget('collapse');

            });
        });

        function openImport() {

            $('#modalImportar').modal('toggle');
        }
    </script>