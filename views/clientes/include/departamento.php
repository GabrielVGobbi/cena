<div class="box box-default box-solid">
    <div class="row">
        <div class="col-md-12">
            <div class="box-header with-border">
                <h3 class="box-title">Departamento</h3>
                <div class="box-tools pull-right">
                    <button id="addDepartamento" type="button" class="btn btn-default btn-sm"><i class="fa fa-fw fa-plus-circle"></i> Novo</button>
                </div>
            </div>
            <div class="box-body" style="">
                <?php $departamento = $this->cliente->getDepartamentoClienteById($tableInfo['id']); ?>
                <?php if ($departamento && count($departamento) > 0) : ?>
                    <?php foreach ($departamento as $dep) : ?>
                        <input type="hidden" class="form-control" name="dep[id_departamento][]" id="id_departamento" value="<?php echo $dep['id_departamento']; ?>">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Responsavel</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-fw fa-user-plus"></i>
                                    </div>
                                    <input type="text" class="form-control" name="dep[dep_responsavel][]" id="dep_responsavel" value="<?php echo $dep['dep_responsavel']; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Email</label>
                                <div class="input-group">
                                    <div id="copyEmail" class="input-group-addon">
                                        <i class="fa fa-envelope"></i>
                                    </div>
                                    <input type="text" class="form-control" name="dep[dep_email][]" id="dep_email" value="<?php echo $dep['dep_email']; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Telefone Fixo</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-phone"></i>
                                    </div>
                                    <input type="text" class="form-control" name="dep[dep_telefone_fixo][]" id="dep_telefone_fixo" value="<?php echo $dep['dep_telefone_fixo']; ?>" data-inputmask='"mask": "(99) 9999-9999"' data-mask>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Telefone Celular</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-phone"></i>
                                    </div>
                                    <input type="text" class="form-control" name="dep[dep_telefone_celular][]" id="dep_telefone_celular" value="<?php echo $dep['dep_telefone_celular']; ?>" data-inputmask='"mask": "(99) 9 9999-9999"' data-mask>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Função</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-fw fa-suitcase"></i>
                                    </div>
                                    <input type="text" class="form-control" name="dep[dep_funcao][]" id="dep_funcao" value="<?php echo $dep['dep_funcao']; ?>">
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else : ?>

                    <div class="row">

                        <input type="hidden" class="form-control" name="dep[id_departamento][]" id="id_departamento">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Responsavel</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-fw fa-user-plus"></i>
                                    </div>
                                    <input type="text" class="form-control" name="dep[dep_responsavel][]" id="dep_responsavel">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label >Email</label>
                                <div  class="input-group">
                                    <div  class="input-group-addon">
                                        <i class="fa fa-envelope"></i>
                                    </div>
                                    <input type="text" class="form-control" name="dep[dep_email][]" id="dep_email">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Telefone Fixo</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-phone"></i>
                                    </div>
                                    <input type="text" class="form-control" name="dep[dep_telefone_fixo][]" id="dep_telefone_fixo" data-inputmask='"mask": "(99) 9999-9999"' data-mask>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Telefone Celular</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-phone"></i>
                                    </div>
                                    <input type="text" class="form-control" name="dep[dep_telefone_celular][]" id="dep_telefone_celular" data-inputmask='"mask": "(99) 9 9999-9999"' data-mask>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Função</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-fw fa-suitcase"></i>
                                    </div>
                                    <input type="text" class="form-control" name="dep[dep_funcao][]" id="dep_funcao">
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                <div class="addDepartamento"></div>
            </div>
        </div>
    </div>
</div>
