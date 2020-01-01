<div class="box box-default box-solid collapsed" id="filtro_<?php echo $viewData['pageController']; ?>" style="display:;">
    <div class="box-body" style="">
        <form method="GET">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Obra</label>
                            <select class="form-control select2" style="width: 100%;" name="filtros['obra']" id="filtros['obra']" aria-hidden="true" >
                                <option value="">selecione</option>
                                <?php foreach ($viewData['obras'] as $obr) : ?>
                                    <?php echo $id_obra; ?>

                                    <option <?php echo ((isset($id_obra) && $id_obra == $obr['id'])) ?  'selected' : '' ?> value="<?php echo $obr['id']; ?>"><?php echo $obr['obr_razao_social'] ?></option>

                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Cliente</label>
                            <select class="form-control select2" style="width: 100%;" name="filtros['cliente']" id="filtros['cliente']" aria-hidden="true">
                                <option value="">selecione</option>
                                <?php foreach ($viewData['clientes'] as $cli) : ?>
                                    <?php echo $id_obra; ?>

                                    <option value="<?php echo $cli['id']; ?>"><?php echo $cli['cliente_nome'] ?></option>

                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                </div>

                <div class="pull-right">
                    <button type="submit" class="btn btn-primary">Buscar</button>
                </div>
            </div>
        </form>
    </div>
</div>