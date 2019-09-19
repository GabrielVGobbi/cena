<div class="box box-default ">
    <div class="box-header with-border">
        <h3 class="box-title">Selecione as Etapas Para: <?php echo $titlePage; ?></h3>
    </div>

    <div class="box-body" style="">
        <div class="box-body">
            <div class="row">
                <?php include_once('etapasConcessionaria.php'); ?>
                <?php include_once('etapasAdministrativa.php'); ?>
                <?php include_once('etapasObra.php'); ?>
            </div>
            <div class="pull-right">
                <a href="<?php echo BASE_URL; ?>concessionarias/edit/<?php echo $tableInfo['id_concessionaria']; ?>" type="" class="btn btn-primary">Voltar</a>
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
            });

            $('.boxadm').on('click', function(e) {
                $('#boxcom').boxWidget('collapse');
                $('#boxadm').boxWidget('toggle');
                $('#boxobra').boxWidget('collapse');
            });

            $('.boxobra').on('click', function(e) {
                $('#boxcom').boxWidget('collapse');
                $('#boxadm').boxWidget('collapse');
                $('#boxobra').boxWidget('toggle');
            });
        });
    </script>