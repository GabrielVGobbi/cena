<?php
$etapas = array();
if (isset($_GET['tipo'])) {
    $tipo = $_GET['tipo'];
} else {
    $tipo = '';
}
$etapas = $this->obra->getEtapas($obr[0], $tipo);

?>

<?php foreach ($etapas as $etp) :  ?>


    <?php if ($etp['tipo'] == COMPRA && $etp['quantidade_obra'] == 0) : ?>

    <?php else : ?>
        <div class="no-border">
            <ul class="todo-list ">
                <li>

                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $etp['id_etapa_obra']; ?>" aria-expanded="false" class="collapsed">



                        <?php


                                controller::loadEtapaCheck($etp['id_etapa_obra'], $etp['ordem'], $obr[0], $etp['tipo'], $etp);

                                ?>



                        <span class="text"><?php echo $etp['etp_nome_etapa_obra']; ?></span>

                        <?php $meta = 'warning'; 
					        $data_hoje = date('d-m-Y');
                            $data_meta = $etp['meta_etapa'];

                            if($etp['meta_etapa'] !=''):
                                $data_meta = str_replace('/', '-', $data_meta);

                                if(strtotime(date('d-m-Y')) > strtotime($data_meta)){
                                    $meta = 'danger';
                                }

                                
                        ?>
                        <span style="font-size: 12px" class="label label-<?php echo $meta; ?>"><i class="fa fa-clock-o"></i> <?php echo $etp['meta_etapa']; ?></span>
                        <?php endif; ?>




                        <?php if (isset($etp['prazo_atendimento']) && isset($etp['data_abertura'])) : ?>
                            <?php controller::loadTempo($etp['prazo_atendimento'], $etp['data_abertura'], $etp['check']);  ?>
                        <?php endif; ?>

                        <span class="text pull-right"> <?php echo ($etp['observacao'] != '' ? 'Obs: ' . mb_strimwidth($etp['observacao'], 0, 60, "...") : ''); ?></span>
                        <?php controller::qntDocumentoEtapa($etp['id_etapa_obra'], $obr[0]); ?>

                        <!-- se dados não estiverem vazio aparece o info -->

                    </a>
                    <?php controller::loadInfo($etp); ?>




                </li>

                <div id="collapse<?php echo $etp['id_etapa_obra']; ?>" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                    <div class="box-body">
                        <?php controller::loadEtapaByTipo($etp['id_etapa_obra'], $obr['cliente_nome']); ?>
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
    <?php endif; ?>
<?php endforeach; ?>