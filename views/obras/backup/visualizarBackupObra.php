<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="modalVisualizar<?php echo $obr[0]; ?>">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="POST" enctype="multipart/form-data" action="<?php echo BASE_URL ?>obras/add_action">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <h2 class="modal-title fc-center" align="center" id="">Visualização de Obra</h2>
                        </div>

                        <div class="modal-body">
                            <div class="box box-default box-solid">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="box-header with-border">
                                            <h3 class="box-title">Dados</h3>
                                        </div>
                                        <div class="box-body" style="">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Nome da Obra</label>
                                                    <input type="text" class="form-control" name="obra_nome" id="obra_nome" value="<?php echo $obr['obr_razao_social']; ?>" autocomplete="off" required>
                                                </div>

                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Concessionaria</label>
                                                    <select class="form-control select2 concessionaria_select_edit" style="width: 100%;" name="concessionaria" id="id_concessionaria_edit" aria-hidden="true" required>
                                                        <?php foreach ($viewData['concessionaria'] as $com) : ?>
                                                            <option <?php echo ($com['id'] == $obr['id_concessionaria']  ? "selected" : ""); ?> value="<?php echo $com['id']; ?>"><?php echo $com['razao_social'] ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Tipo de Obra/Serviço</label>

                                                </div>
                                            </div>

                                            <div class="col-md-12" style="margin-bottom:6px;">
                                                <label>Cliente</label>
                                                <input type="text" class="form-control" name="cliente_nome" id="cliente_nome" value="<?php echo $obr['cliente_nome']; ?>" autocomplete="off" required>

                                            </div>

                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="box-body">
                                            <div class="box box-primary">
                                                <div class="box-header ">
                                                    <i class="ion ion-clipboard"></i>
                                                    <h3 class="box-title">Etapas</h3>
                                                </div>
                                                <div class="box-body">
                                                    <ul class="todo-list ">
                                                        <?php $etapas = array();
                                                        $etapas = $this->servico->getEtapas($obr['id_concessionaria'], $obr['id_servico']); ?>
                                                        <?php foreach ($etapas as $etp) : ?>
                                                            <li>
                                                                <input type="checkbox" value="">
                                                                <span class="text"><?php echo $etp['etp_nome']; ?></span>
                                                                <small class="label label-danger"><i class="fa fa-clock-o"></i> 2 mins</small>
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


                            </div>

                            <div class="box box-default box-solid">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="box-header with-border">
                                            <h3 class="box-title">Documentos</h3>
                                            <div class="box-tools pull-right">
                                                <button type="button" class="btn btn-box-tool new_obra"><i class="fa fa-plus-circle"></i></button>
                                            </div>
                                        </div>
                                        <div class="box-body" style="">
                                            <div id="obra_ok">
                                                <?php $documento_obra = $this->documento->getDocumentoObra($obr[0]); ?>
                                                <?php if (count($documento_obra) > 0) : ?>
                                                    <?php foreach ($documento_obra as $doc) : ?>
                                                        <div class="col-md-12">
                                                            <div class="input-group" style="width: 50%;">
                                                                <input type="text" class="form-control" name="servico_concessionaria" id="servico_concessionaria" autocomplete="off" value="<?php echo $doc['sev_nome']; ?>">
                                                                <div class="input-group-btn">
                                                                    <div class="btn btn-info" title="" data-toggle="modal" data-target="#view_tarefas<?php echo $doc['id']; ?>" data-original-title="Ver Tarefas">
                                                                        <i class="ion ion-clipboard"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php endforeach; ?>
                                                <?php else : ?>
                                                    Não foram encontrados resultados.
                                                <?php endif; ?>
                                            </div>

                                            <div class="col-md-10" style="display:none;" id="new_obra">
                                            <label>Adicionar novo Documento</label>
                                                <div class="input-group">
                                                    <input class="form-control" name="docs_nome" placeholder="Nome do Documento">
                                                    <div class="input-group-btn">
                                                        <div class="btn btn-default btn-file">
                                                            <i class="fa fa-paperclip"></i> PDF
                                                            <input type="file" class="btn btn-success" name="documento_arquivo">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                        </div>

                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary pull-right" style="margin-right: 5px;">
                                <i class="fa fa-download"></i> Generate PDF
                            </button> </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>