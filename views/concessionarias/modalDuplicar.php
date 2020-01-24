<div class="modal" id="modalImportar<?php echo $scon['id']; ?>" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="formDuplicar<?php echo $scon['id']; ?>" action="<?php echo BASE_URL ?>concessionaria/duplicarEtapa" method="POST">
                <input type="hidden" class="form-control" name="id_concessionaria" id="id_concessionaria" value="<?php echo $tableInfo['id']; ?>" autocomplete="off">
                <input type="hidden" class="form-control" name="id_servico" id="id_servico" value="<?php echo $scon['id_servico']; ?>" autocomplete="off">
                <div class="modal-header">
                    <h2 class="modal-title text-center">Duplicação de "<?php echo $scon['sev_nome']; ?>" x "<?php echo $tableInfo['razao_social']; ?>"</h2>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="box-body">
                        <div class="row">

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Nome do Serviço</label>
                                    <input type="text" class="form-control" name="sev_nome" id="sev_nome" autocomplete="off">
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <div onclick="formSubmit(<?php echo $scon['id']; ?>)" class="btn btn-primary">Duplicar</div>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                </div>
            </form>
        </div>
    </div>
</div>


<script>
    function formSubmit(id) {

        $("#formDuplicar" + id).submit();

    }
</script>