<div class="col-md-12">
    <div class="box-body">
        <div class="box box-primary collapsed-box">
            <div class="box-header with-border">
                <h3 class="box-title">Endereço</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                    </button>
                </div>
            </div>
            <div class="box-body" style="">
                <?php if (($obr['id_endereco_obra'] != 0)) : ?>
                    <input type="hidden" class="form-control" name="id_endereco" id="id_endereco" autocomplete="off" value="<?php echo $obr['id_endereco_obra']; ?>">

                    <div class="row">

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Razão Social</label>
                                <input type="text" class="form-control" name="razao_social_obra_cliente" id="razao_social_obra_cliente" value="<?php echo $obr['razao_social_obra_cliente']; ?>">
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label>CEP</label>
                                <input type="text" class="form-control" name="cep" id="cep" value="<?php echo $obr['cep']; ?>" size="10" maxlength="9" onblur="pesquisacep(this.value);" data-inputmask="'mask': ['99999-999']" data-mask>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Rua</label>
                                <input type="text" class="form-control" Readonly name="rua" id="rua" value="<?php echo $obr['rua']; ?>">
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Nº</label>
                                <input type="text" class="form-control" name="numero" id="numero" value="<?php echo $obr['numero']; ?>">
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Bairro</label>
                                <input type="text" class="form-control" Readonly name="bairro" id="bairro" value="<?php echo $obr['bairro']; ?>">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Cidade</label>
                                <input type="text" class="form-control" Readonly name="cidade" id="cidade" value="<?php echo $obr['cidade']; ?>">
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Estado</label>
                                <input type="text" class="form-control" Readonly name="estado" id="uf" value="<?php echo $obr['estado']; ?>">
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Complemento</label>
                                <input type="text" class="form-control" name="complemento" id="complemento" value="<?php echo $obr['complemento']; ?>">
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label>CEI</label>
                                <input type="text" class="form-control" name="inscEstado" id="inscEstado" value="<?php echo $obr['inscEstado']; ?>">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div id="formcpnj" class="form-group">
                                <label>CNPJ</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-fw fa-cc"></i>
                                    </div>
                                    <input id="cpfcnpj" type="text" class="form-control" name="obra_cnpj" value="<?php echo $obr['cnpj_obra']; ?>">
                                </div>
                            </div>
                        </div>
                    </div>

                <?php else : ?>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Razão Social</label>
                            <input type="text" class="form-control" name="razao_social_obra_cliente" id="razao_social_obra_cliente">
                        </div>
                    </div>


                    <div class="col-md-2">
                        <div class="form-group">
                            <label>CEP</label>
                            <input type="text" class="form-control" name="cep" id="cep" size="10" maxlength="9" onblur="pesquisacep(this.value);" data-inputmask="'mask': ['99999-999']" data-mask>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Rua</label>
                            <input type="text" class="form-control" Readonly name="rua" id="rua">
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Nº</label>
                            <input type="text" class="form-control" name="numero" id="numero">
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Bairro</label>
                            <input type="text" class="form-control" Readonly name="bairro" id="bairro">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Cidade</label>
                            <input type="text" class="form-control" Readonly name="cidade" id="cidade">
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Estado</label>
                            <input type="text" class="form-control" Readonly name="estado" id="uf">
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Complemento</label>
                            <input type="text" class="form-control" name="complemento" id="complemento">
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label>CEI</label>
                            <input type="text" class="form-control" name="inscEstado" id="inscEstado">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div id="formcpnj" class="form-group">
                            <label>CNPJ</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-fw fa-cc"></i>
                                </div>
                                <input id="cpfcnpj" type="text" class="form-control" name="obra_cnpj">
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
    var maskCpfOuCnpj = IMask(document.getElementById('cpfcnpj'), {
        mask: [{
                mask: '000.000.000-00',
                maxLength: 11
            },
            {
                mask: '00.000.000/0000-00'
            }
        ]
    });



</script>