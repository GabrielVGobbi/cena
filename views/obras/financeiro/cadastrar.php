<div class="box box-default ">
    <div class="box-header with-border">
        <h3 class="box-title">Cadastrar</h3>
    </div>

    <div class="box-body" style="">
        <form method="POST" enctype="multipart/form-data" action="<?php echo BASE_URL; ?>concessionarias/add_action">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Nome da Obra</label>
                            <input type="text" placeholder="Nome da Concessionara" class="form-control" name="razao_social" id="razao_social" required="" autocomplete="off">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Descrição </label>
                            <input type="text" class="form-control" value="<?php echo $tableInfo['descricao'];?>" name="razao_social" id="razao_social" required="" autocomplete="off">
                        </div>
                    </div>
                </div>
            </div>
            <div class="pull-right">
                <button type="submit" class="btn btn-primary">Avançar</button>
            </div>
        </form>
    </div>
</div>