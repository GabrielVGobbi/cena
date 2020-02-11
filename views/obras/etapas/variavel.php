<div class="modal fade" id="editarVariavel<?php echo $var['etcc_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="POST" enctype="multipart/form-data" action="<?php echo BASE_URL ?>obras/editEtapaObra/<?php echo $array[0]['id_etapa_obra']; ?>?tipo=<?php echo (isset($_GET['tipo']) ? $_GET['tipo'] : '') ?>">
                <input type="hidden" class="form-control" name="id" id="id" autocomplete="off" value="<?php echo $array[0]['id_etapa_obra']; ?>">
                <input type="hidden" class="form-control" name="id_obra" autocomplete="off" value="<?php echo $array[0]['id_obra']; ?>">
                <input type="hidden" class="form-control" name="server" autocomplete="off" value="<?php echo (isset($_GET['tipo']) ? $_GET['tipo'] : '0') ?>">
                <input type="hidden" class="form-control" name="cliente" autocomplete="off" value="<?php echo $cliente; ?>">



                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <h2 class="modal-title fc-center" align="center" id=""><?php echo $array[0]['etp_nome']; ?></h2>
                        </div>

                        <div class="modal-body">
                            <div class="box box-default box-solid">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="box-header with-border">
                                            <h3 class="box-title">Dados</h3>
                                        </div>
                                        <div class="box-body" style="">

                                            <input type="hidden" class="form-control" name="tipo" id="" autocomplete="off" value="COMPRA">

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Nome Variavel</label>
                                                    <input type="text" class="form-control" name="nome_etapa_obra" id="nome_etapa_obra" value="<?php echo $var['nome_variavel']; ?>" autocomplete="off">
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Quantidade Variavel</label>
                                                    <input type="text" class="form-control" name="quantidade" id="quantidade" value="<?php echo $var['etcc_quantidade']; ?>" autocomplete="off">
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Preço Variavel</label>
                                                    <input type="text" class="form-control" name="preco" id="preco" value="<?php echo (isset($var['preco_variavel']) ? 'R$ ' . controller::number_format($var['preco_variavel']) : ''); ?>" autocomplete="off">
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Tipo</label>
                                                    <input type="text" class="form-control" name="tipo_compra" id="tipo_compra" value="<?php echo $array[0]['tipo_compra_obra']; ?>" autocomplete="off">
                                                </div>
                                            </div>

                                           
                                            <?php if ($this->userInfo['user']->hasPermission('obra_edit')) : ?>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label>Observações do sistema</label>
                                                        <textarea type="text" class="form-control" name="observacao_sistema" id="observacao_sistema" autocomplete="off" rows="5" cols="33"><?php echo $array[0]['observacao_sistema']; ?></textarea>
                                                    </div>
                                                </div>
                                            <?php endif; ?>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>