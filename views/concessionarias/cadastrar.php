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
                            <label>Razão Social</label>
                            <input type="text" placeholder="Nome da Concessionara" class="form-control" name="razao_social" id="razao_social" required="" autocomplete="off">
                        </div>
                    </div>

                    <div class="col-md-8" style="display:;">
                        <div class="input-group">
                            <label>Selecione o Serviço</label>
                            <select class="form-control select2-add-service select2-hidden-accessible" data-placeholder="Selecione o serviço" style="width: 100%;" name="servico" aria-hidden="true" required>
                                <option> selecione </option>
                                <?php foreach ($servico as $sev) : ?>
                                    <option value="<?php echo $sev['id']; ?>"><?php echo $sev['sev_nome'] ?></option>
                                <?php endforeach; ?>
                            </select>
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