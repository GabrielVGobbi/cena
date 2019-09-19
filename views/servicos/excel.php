<div class="modal" id="modalImportar" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <form action="<?php echo BASE_URL ?>servicos/importar" method="POST" enctype="multipart/form-data">
      <div class="modal-content">
        <div class="modal-header">
          <h2 class="modal-title text-center">Importar</h2>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">


          <div class="box box-danger">
            <div class="box-header with-border">
              <h3 class="box-title">Opções</h3>
            </div>
            <div class="box-body">
              <div class="row">

                <div class="col-xs-5">
                  <div class="btn btn-default btn-file">
                    <i class="fa fa-paperclip"></i> Arquivo
                    <input type="file" name="arquivo" />
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