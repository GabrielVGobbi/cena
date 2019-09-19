<div class="box box-default box-solid collapsed" id="filtro_<?php echo $viewData['pageController']; ?>" style="display:none;">
    <div class="box-body" style="">
        <form method="GET">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-1">
                        <div class="form-group">
                            <label for="fl_art_nome">ID</label>
                            <input class="form-control" id="filtro_id_inventario" name="filtros[id]" placeholder="" autocomplete="off">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="fl_art_nome">Nome</label>
                            <input class="form-control" id="filtro_descricao" name="filtros[razao_social]" placeholder="" autocomplete="off">
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