<div class="box box-default box-solid">
    <div class="row">
        <div class="col-md-12">
            <div class="box-header with-border">
                <h3 class="box-title">Endereço</h3>
            </div>
            <div class="box-body" style="">
                <?php if (($tableInfo['clend_id'] != 0)) : ?>
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>CEP</label>
                                <input type="text" class="form-control" name="cep" id="cep" value="<?php echo $tableInfo['cep']; ?>" size="10" maxlength="9" onblur="pesquisacep(this.value);" data-inputmask="'mask': ['99999-999']" data-mask>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Rua</label>
                                <input type="text" class="form-control" Readonly name="rua" id="rua" value="<?php echo $tableInfo['rua']; ?>">
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Nº</label>
                                <input type="text" class="form-control" name="numero" id="numero" value="<?php echo $tableInfo['numero']; ?>">
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Bairro</label>
                                <input type="text" class="form-control" Readonly name="bairro" id="bairro" value="<?php echo $tableInfo['bairro']; ?>">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Cidade</label>
                                <input type="text" class="form-control" Readonly name="cidade" id="cidade" value="<?php echo $tableInfo['cidade']; ?>">
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Estado</label>
                                <input type="text" class="form-control" Readonly name="estado" id="uf" value="<?php echo $tableInfo['estado']; ?>">
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Complemento</label>
                                <input type="text" class="form-control" name="complemento" id="complemento" value="<?php echo $tableInfo['complemento']; ?>">
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Inscr. Estadual</label>
                                <input type="text" class="form-control" name="inscEstado" id="inscEstado" value="<?php echo $tableInfo['inscEstado']; ?>">
                            </div>
                        </div>
                    </div>

                <?php else : ?>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label>CEP</label>
                            <input type="text" class="form-control" name="cep" id="cep" size="10" maxlength="9" onblur="pesquisacep(this.value);" data-inputmask="'mask': ['99999-999']" data-mask>
                        </div>
                    </div>

                    <div class="col-md-6">
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
                            <label>Inscr. Estadual</label>
                            <input type="text" class="form-control" name="inscEstado" id="inscEstado">
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>