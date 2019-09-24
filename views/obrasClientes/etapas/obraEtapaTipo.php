<?php
$etapas = array();
if (isset($_GET['tipo'])) {
    $tipo = $_GET['tipo'];
} else {
    $tipo = '';
}
$etapas = $this->obra->getEtapas($obr[0], $tipo);
?>

<?php foreach ($etapas as $etp) : ?>



    <div class="no-border">
        <ul class="todo-list ">
            <li>




                    <?php

                        $tipo = '';

                        $etapa = $etp['id_etapa_obra'] - 1;

                        //pegar o registro anterior para ver se ta 0 ou 1 
                        $etapaCheck = $this->etapa->check($etapa, $obr[0], $etp['tipo']);

                        if($etp['parcial_check'] == 1){
                            $tipo = 'PARCIAL';
                        }

                        controller::loadEtapaCheckCliente($etapaCheck, $etp, $obr[0], $tipo);
                    ?>
     


                    <span class="text"><?php echo $etp['etp_nome_etapa_obra']; ?></span>
                    
                    <?php if (isset($etp['check']) && $etp['check'] == 1) : ?>
                        <span style="font-size: 12px" class="label label-success"><i class="fa fa-clock-o"></i> Concluido </span>
                    <?php endif; ?>



              

            </li>

            <div id="collapse<?php echo $etp['id_etapa_obra']; ?>" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                <div class="box-body">
                    <?php controller::loadEtapaByTipo($etp['id_etapa_obra']); ?>
                </div>
            </div>



        </ul>
    </div>

    <script>
        $(function() {
            $('#checkEtapa' + <?php echo $etp['id_etapa_obra']; ?>).on('ifChecked', function(event) {
                var q = $(this).val();
                checked = '1';
                idobra = <?php echo $obr[0]; ?>;
                tipo = '0';
                <?php if (isset($_GET['tipo'])) : ?>
                    <?php if ($_GET['tipo'] == '') : ?>
                        tipo = '0';
                    <?php else : ?>
                        tipo = <?php echo $_GET['tipo']; ?>;
                    <?php endif; ?>

                <?php endif; ?>

                $.ajax({

                    url: BASE_URL + 'ajax/updateEtapa',
                    type: 'POST',
                    data: {
                        id_etapa: q,
                        checked: checked,
                        id_obra: idobra
                    },
                    dataType: 'json',
                    success: function(json) {

                        window.location.href = BASE_URL + "obras/edit/" + idobra + '?tipo=' + tipo;

                    },
                });
            });


            $('#checkEtapa' + <?php echo $etp['id_etapa_obra']; ?>).on('ifUnchecked', function(event) {
                var q = $(this).val();
                checked = '0';
                idobra = <?php echo $obr[0]; ?>;
                tipo = '0';
                <?php if (isset($_GET['tipo'])) : ?>
                    <?php if ($_GET['tipo'] == '') : ?>
                        tipo = '0';
                    <?php else : ?>
                        tipo = <?php echo $_GET['tipo']; ?>;
                    <?php endif; ?>

                <?php endif; ?>
                $.ajax({

                    url: BASE_URL + 'ajax/updateEtapa',
                    type: 'POST',
                    data: {
                        id_etapa: q,
                        checked: checked,
                        id_obra: idobra
                    },
                    dataType: 'json',
                    success: function(json) {

                        window.location.href = BASE_URL + "obras/edit/" + idobra + '?tipo=' + tipo;

                    },
                });
            });


        });
    </script>


<?php endforeach; ?>