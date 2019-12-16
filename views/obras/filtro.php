<div class="box box-default box-solid collapsed" id="filtro_<?php echo $viewData['pageController']; ?>" style="display:;">
    <div class="box-body" style="">
        <form method="GET">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="fl_art_nome">ID</label>
                            <input class="form-control" id="filtro_obra_nota_numero" name="filtros[obra_nota_numero]" placeholder="" autocomplete="off">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="fl_art_nome">Razão Social</label>
                            <input class="form-control" id="filtro_descricao" name="filtros[nome_obra]" placeholder="" autocomplete="off">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="fl_art_nome">Cliente</label>
                            <input class="form-control" id="filtro_descricao" name="filtros[cliente_nome]" placeholder="" autocomplete="off">
                        </div>
                    </div>

                    <div class="col-md-2">
                        <label for="fl_art_nome">Situação</label>
                        <div class="form-group">
                            <select class="form-control select2" style="width: 100%;" name="filtros[situacao]" id="filtros[situacao]">
                                <option <?php echo ((isset($viewData['filtro']['situacao']) && $viewData['filtro']['situacao'] == '')) ?  'selected' : '' ?> value="">Todos</option>
                                <option <?php echo ((isset($viewData['filtro']['situacao']) && $viewData['filtro']['situacao'] == '1')) ? 'selected' : '' ?> value="1">Ativos</option>
                                <option <?php echo ((isset($viewData['filtro']['situacao']) && $viewData['filtro']['situacao'] == '3')) ? 'selected' : '' ?> value="3">Inativos</option>
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

