<div class="modal fade bd-example-modal-lg" id="view_tarefas<?php echo $scon['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="box box-primary">
                <div class="box-header">
                    <i class="ion ion-clipboard"></i>
                    <h3 class="box-title">Tarefas de "<?php echo $scon['sev_nome']; ?>"</h3>
                </div>
                <div class="box-body">
                    <ul class="todo-list">
                        <?php $etapas = array();
                        $etapas = $this->servico->getEtapas($tableInfo['id'], $scon['id']); ?>
                        <?php foreach ($etapas as $etp) : ?>

                            <li>
                                <span class="text"><?php echo $etp['etp_nome']; ?></span>
                                <small class="label label-danger"><i class="fa fa-clock-o"> </i><?php echo ' '.$etp['prazo_etapa']; ?> dias </small>
                                <div class="tools">
                                 
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div class="box-footer clearfix no-border">
                </div>
            </div>
        </div>
    </div>
</div>