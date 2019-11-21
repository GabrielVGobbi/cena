<div class="modal fade bd-example-modal-lg" id="modalCadastro" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <form method="POST" enctype="multipart/form-data" action="<?php echo BASE_URL ?>clientes/add_action">
        <div class="modal-dialog modal-dialog-centered">
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
                            <div class="form-group">
                                <label>Nome</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-fw fa-user"></i>
                                    </div>
                                    <input type="text" class="form-control" name="cliente_nome" id="cliente_nome" data-inputmask="(999) 999-9999" data-mask="">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Email</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-envelope"></i>
                                    </div>
                                    <input type="text" class="form-control" name="cliente_email" id="cliente_email" data-inputmask="(999) 999-9999" data-mask="">
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
                                    <input type="text" class="form-control" name="cliente_responsavel" id="cliente_responsavel" data-inputmask="(999) 999-9999" data-mask="">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Telefone</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-phone"></i>
                                    </div>
                                    <input type="text" class="form-control" name="cliente_telefone" id="cliente_telefone" data-inputmask="(999) 999-9999" data-mask="">
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