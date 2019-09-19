<div class="modal" id="modalImportar" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <form action="<?php echo BASE_URL ?>documentos/importar" method="POST" enctype="multipart/form-data">
      <div class="modal-content">
        <div class="modal-header">
          <h2 class="modal-title text-center">Gerar Winrar</h2>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">


          <div class="box box-danger">
            <div class="box-header with-border">
              <h3 class="box-title">Selecione os documentos</h3>
            </div>
            <div class="box-body">
              <div class="row">

                <div class="col-xs-12">
                  <div class="form-group">
                    <select class="form-control select2 select2-hidden-accessible" multiple style="width: 100%;" name="documentos[]" id="documentos" data-placeholder="Selecione os documentos">
                      <?php foreach ($tableDados as $a) : ?>
                        <option value="<?php echo $a['id']; ?>"><?php echo $a['docs_nome'] ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                </div>
              </div>
            </div>
            <!-- /.box-body -->
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Aplicar</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
        </div>
      </div>
    </form>
  </div>
</div>