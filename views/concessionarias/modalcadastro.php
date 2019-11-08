<div class="modal fade bd-example-modal-lg" id="modalCadastro" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="POST" id="form_etapa_compra" >
                <input type="hidden" value="<?php echo $tableInfo['id_concessionaria']; ?>" name="id_concessionaria">
                <input type="hidden" value="<?php echo $tableInfo['id_servico']; ?>" name="id_servico">

                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <h2 class="modal-title fc-center" align="center" id="">Cadasto de nova etapa</h2>
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
                                                    <label>Nome da Etapa</label>
                                                    <input class="form-control" id="etapa_input_compra" type="text" value="" name="add_etapa_compra" autocomplete="off">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>Quantidade</label>
                                                    <input class="form-control" id="etapa_input_quant" type="text" value="" name="quantidade">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>Preço</label>
                                                    <input class="form-control" value="R$ " id="etapa_input_preco" type="text" value="" name="preco">
                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>Tipo</label>
                                                    <input class="form-control" id="etapa_input_tipo" type="text" value="" name="tipo_compra">

                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="box box-primary collapsed-box">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Variaveis</h3>

                                    <div class="box-tools pull-right">
                                        <a data-widget="collapse" type="button" class="btn btn-default btn-sm"><i class="fa fa-fw fa-plus-circle"></i> Novo</a>
                                    </div>
                                </div>
                                <div class="box-body" style="display: none;">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Nome da Variavel</label>
                                                <input type="text" class="form-control" name="variavel[nome_variavel][]" id="nome_variavel" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label>Preço</label>
                                                <input value="R$ " type="text" class="form-control" name="variavel[preco_variavel][]" id="preco_variavel" autocomplete="off">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <a class="btn btn-sm btn-info btn-flat pull-left new_variavel" style="position: relative;top: 27px;"> <i class="fa fa-fw fa-plus-circle"></i></a>
                                        </div>
                                    </div>
                                    <div id="new_variavel"> </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="submit" id="new_etapa_compra" class="btn btn-primary"><i class="fa fa-arrow-right"></i> Salvar</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>