<div class="modal fade bd-example-modal-lg" id="modalEditarAdm<?php echo $etpAdm['id'];?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="POST" enctype="multipart/form-data" action="<?php echo BASE_URL ?>concessionarias/edit_etapa/<?php echo $tableInfo['id_concessionaria'];?>/<?php echo $tableInfo['id_servico'];?>/adm">
            <input type="hidden" class="form-control" name="id_etapa" value="<?php echo $etpAdm['id'];?>" >

                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <h2 class="modal-title fc-center" align="center" id="">Editar "<?php echo $etpAdm['etp_nome'];?>"</h2>
                        </div>

                        <div class="modal-body">
                            <div class="box box-default box-solid">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="box-header with-border">
                                            <h3 class="box-title">Dados</h3>
                                        </div>
                                        <div class="box-body" style="">
                                            <div class="col-md-12">
                                                <div class="input-group">
                                                    <label for="">Nome da Etapa</label>
                                                    <input class="form-control" name="nome_etapa" value="<?php echo $etpAdm['etp_nome'];?>" placeholder="Nome da Etapa">
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Salvar</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade bd-example-modal-lg" id="modalEditarCon<?php echo $etpCon['id'];?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="POST" enctype="multipart/form-data" action="<?php echo BASE_URL ?>concessionarias/edit_etapa/<?php echo $tableInfo['id_concessionaria'];?>/<?php echo $tableInfo['id_servico'];?>/com">
            <input type="hidden" class="form-control" name="id_etapa" value="<?php echo $etpCon['id'];?>" >

                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <h2 class="modal-title fc-center" align="center" id="">Editar "<?php echo $etpCon['etp_nome'];?>"</h2>
                        </div>

                        <div class="modal-body">
                            <div class="box box-default box-solid">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="box-header with-border">
                                            <h3 class="box-title">Dados</h3>
                                        </div>
                                        <div class="box-body" style="">
                                            <div class="col-md-12">
                                                <div class="input-group">
                                                    <label for="">Nome da Etapa</label>
                                                    <input class="form-control" name="nome_etapa" value="<?php echo $etpCon['etp_nome'];?>" placeholder="Nome da Etapa">
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Salvar</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="modal fade bd-example-modal-lg" id="modalEditarObr<?php echo $etpObra['id'];?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="POST" enctype="multipart/form-data" action="<?php echo BASE_URL ?>concessionarias/edit_etapa/<?php echo $tableInfo['id_concessionaria'];?>/<?php echo $tableInfo['id_servico'];?>/obra">
            <input type="hidden" class="form-control" name="id_etapa" value="<?php echo $etpObra['id'];?>" >

                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <h2 class="modal-title fc-center" align="center" id="">Editar "<?php echo $etpObra['etp_nome'];?>"</h2>
                        </div>

                        <div class="modal-body">
                            <div class="box box-default box-solid">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="box-header with-border">
                                            <h3 class="box-title">Dados</h3>
                                        </div>
                                        <div class="box-body" style="">
                                            <div class="col-md-12">
                                                <div class="input-group">
                                                    <label for="">Nome da Etapa</label>
                                                    <input class="form-control" name="nome_etapa" value="<?php echo $etpObra['etp_nome'];?>" placeholder="Nome da Etapa">
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Salvar</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
