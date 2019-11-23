<div class="modal fade bd-example-modal-lg" id="modalCadastro" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <form method="POST" id="cliete_edit" enctype="multipart/form-data" action="<?php echo BASE_URL ?>clientes/add_action">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h2 class="modal-title fc-center" align="center" id="">Cadastro de Cliente</h2>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div id="formnome" class="form-group">
                                <label>Razão Social</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-fw fa-user"></i>
                                    </div>
                                    <input type="text" class="form-control" name="cliente_nome" id="cliente_nome">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div id="formcpnj" class="form-group">
                                <label>CNPJ</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-fw fa-cc"></i>
                                    </div>
                                    <input id="cpfcnpj" type="text" class="form-control" name="cliente_cnpj" id="cliente_cnpj">
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="box box-default collapsed-box">
                        <div class="box-header with-border">
                            <h3 class="box-title">Departamento Principal</h3>
                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                                </button>
                            </div>
                        </div>

                        <div class="box-body" style="">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Email</label>
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-envelope"></i>
                                            </div>
                                            <input type="text" class="form-control" name="dep_email" id="dep_email">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Responsavel</label>
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-fw fa-user-plus"></i>
                                            </div>
                                            <input type="text" class="form-control" name="dep_responsavel" id="dep_responsavel">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Telefone Fixo</label>
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-phone"></i>
                                            </div>
                                            <input type="text" class="form-control" name="dep_telefone_fixo" id="dep_telefone_fixo" data-inputmask='"mask": "(99) 9999-9999"' data-mask>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Telefone Celular</label>
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-phone"></i>
                                            </div>
                                            <input type="text" class="form-control" name="dep_telefone_celular" id="dep_telefone_celular" data-inputmask='"mask": "(99) 9 9999-9999"' data-mask>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="box box-default collapsed-box">
                        <div class="box-header with-border">
                            <h3 class="box-title">Endereço</h3>
                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                                </button>
                            </div>
                        </div>

                        <div class="box-body" style="">
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>CEP</label>
                                        <input type="text" class="form-control" name="cep" id="cep" value="" size="10" maxlength="9" onblur="pesquisacep(this.value);" data-inputmask="'mask': ['99999-999']" data-mask>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Rua</label>
                                        <input type="text" class="form-control" name="rua" id="rua" value="">
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Nº</label>
                                        <input type="text" class="form-control" name="numero" id="numero" value="">
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Bairro</label>
                                        <input type="text" class="form-control" name="bairro" id="bairro" value="">
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Cidade</label>
                                        <input type="text" class="form-control" name="cidade" id="cidade" value="">
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Estado</label>
                                        <input type="text" class="form-control" name="estado" id="uf" value="">
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Complemento</label>
                                        <input type="text" class="form-control" name="complemento" id="complemento" value="">
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Inscr. Estadual</label>
                                        <input type="text" class="form-control" name="inscEstado" id="inscEstado" value="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="modal-footer">
                    <div  id="submit" class="btn btn-primary">Salvar</div>
                </div>
            </div>
        </div>
    </form>
</div>

<script src="<?php BASE_URL?>/views/<?php echo $viewData['pageController'];?>/parametros/<?php echo $viewData['pageController'];?>.js"></script>

