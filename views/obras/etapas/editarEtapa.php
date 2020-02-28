<?php
$check = 'danger';
$msg = 'prazo';
$nome = $this->user->getName();
            
$Iniciais = controller::Iniciais($nome);
$data_hoje = date('d/m');

?>

<div class="modal fade" id="editarEtapa<?php echo $array[0]['id_etapa_obra']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form method="POST" enctype="multipart/form-data" action="<?php echo BASE_URL ?>obras/editEtapaObra/<?php echo $array[0]['id_etapa_obra']; ?>?tipo=<?php echo (isset($_GET['tipo']) ? $_GET['tipo'] : '') ?>">
        <input type="hidden" class="form-control" name="id" id="id" autocomplete="off" value="<?php echo $array[0]['id_etapa_obra']; ?>">
        <input type="hidden" class="form-control" name="id_obra" autocomplete="off" value="<?php echo $array[0]['id_obra']; ?>">
        <input type="hidden" class="form-control" name="server" autocomplete="off" value="<?php echo (isset($_GET['tipo']) ? $_GET['tipo'] : '0') ?>">
        <input type="hidden" class="form-control" name="cliente" autocomplete="off" value="<?php echo $cliente; ?>">

        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
              <h2 class="modal-title fc-center" align="center" id=""><?php echo $array[0]['etp_nome']; ?></h2>
            </div>

            <div class="modal-body">
              <div class="box box-default box-solid">
                <div class="row">
                  <div class="col-md-12">
                    <div class="box-header with-border">
                      <h3 class="box-title">Dados</h3>
                    </div>
                    <div class="box-body" style="">


                      <?php if ($array[0]['nome'] === 'ADMINISTRATIVA') : ?>
                        <input type="hidden" class="form-control" name="tipo" id="" autocomplete="off" value="ADMINISTRATIVA">

                        <div class="col-md-12">
                          <div class="form-group">
                            <label>Nome Etapa</label>
                            <input type="text" class="form-control" name="nome_etapa_obra" id="nome_etapa_obra" value="<?php echo $array[0]['etp_nome_etapa_obra']; ?>" autocomplete="off">
                          </div>
                        </div>

                        <div class="col-md-4">
                          <div class="form-group">
                            <label>Responsável</label>
                            <input type="text" class="form-control" name="responsavel_administrativo" id="responsavel_administrativo" value="<?php echo $array[0]['responsavel']; ?>" value="<?php echo $array[0]['etp_nome']; ?>" autocomplete="off">
                          </div>
                        </div>

                        <div class="col-md-2">
                          <div class="form-group">
                            <label>Data do Pedido</label>
                            <input type="text" class="form-control" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask="" name="data_pedido_administrativo" id="data_pedido_administrativo" value="<?php echo $array[0]['data_pedido']; ?>" autocomplete="off">
                          </div>
                        </div>

                        <div class="col-md-2">
                          <div class="form-group">
                            <label>Data Meta</label>
                            <input type="text" class="form-control" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask="" name="meta_etapa" id="meta_etapa" value="<?php echo $array[0]['meta_etapa']; ?>" autocomplete="off">
                          </div>
                        </div>

                        <div class="col-md-4">
                          <div class="form-group">
                            <label>Cliente Responsável</label>
                            <input type="text" class="form-control" name="cliente_responsavel_administrativo" id="cliente_responsavel_administrativo" value="<?php echo $array[0]['cliente_responsavel']; ?>" autocomplete="off">
                          </div>
                        </div>

                        <div class="col-md-12">
                          <div class="form-group">
                            <label>Observações</label>
                            <input type="text" class="form-control" value="<?php echo $array[0]['observacao']; ?>" name="observacao" id="observacao" autocomplete="off">
                          </div>
                        </div>
                        <?php if($this->userInfo['user']->hasPermission('obra_edit')): ?>
                        <div class="col-md-12">
                          <div class="form-group">
                            <label>Observações do sistema</label>
                            <textarea type="text" class="form-control" name="observacao_sistema" id="observacao_sistema" autocomplete="off" rows="5" cols="33"><?php echo $array[0]['observacao_sistema']; ?>&#10;<?php echo $data_hoje.' ('.($Iniciais).')'; ?> </textarea>
                          </div>
                        </div>
                        <?php endif;?>


                      <?php elseif ($array[0]['nome'] === 'COMPRA') : ?>
                        <input type="hidden" class="form-control" name="tipo" id="compra" autocomplete="off" value="COMPRA">

                        <div class="col-md-12">
                          <div class="form-group">
                            <label>Nome Etapa</label>
                            <input type="text" class="form-control" name="nome_etapa_obra" id="nome_etapa_obra" value="<?php echo $array[0]['etp_nome_etapa_obra']; ?>" autocomplete="off">
                          </div>
                        </div>

                        <div class="col-md-3">
                          <div class="form-group">
                            <label>Quantidade</label>
                            <input type="text" class="form-control" name="quantidade" id="quantidade" value="<?php  echo $array[0]['quantidade_obra']; ?>" autocomplete="off">
                          </div>
                        </div>

                        <div class="col-md-3">
                          <div class="form-group">
                            <label>Preço</label>
                            <input type="text" class="form-control" name="preco" id="preco" value="<?php echo  (isset($array[0]['preco_obra'])? 'R$ '.controller::number_format($array[0]['preco']): ''); ?>" autocomplete="off">
                          </div>
                        </div>

                        <div class="col-md-3">
                          <div class="form-group">
                            <label>Tipo</label>
                            <input type="text" class="form-control" name="tipo_compra" id="tipo_compra" value="<?php echo $array[0]['tipo_compra_obra']; ?>" autocomplete="off">
                          </div>
                        </div>

                        <div class="col-md-3">
                          <div class="form-group">
                            <label>Data Meta</label>
                            <input type="text" class="form-control" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask="" name="meta_etapa" id="meta_etapa" value="<?php echo $array[0]['meta_etapa']; ?>" autocomplete="off">
                          </div>
                        </div>
                        <?php if($this->userInfo['user']->hasPermission('obra_edit')): ?>
                          <div class="col-md-12">
                            <div class="form-group">
                              <label>Observações do sistema</label>
                              <textarea type="text" class="form-control" name="observacao_sistema" id="observacao_sistema" autocomplete="off" rows="5" cols="33"><?php echo $array[0]['observacao_sistema']; ?>&#10;<?php echo $data_hoje.' ('.($Iniciais).')'; ?></textarea>
                            </div>
                          </div>
                        <?php endif; ?>

                      <?php elseif ($array[0]['nome'] === 'CONCESSIONARIA') : ?>
                        <input type="hidden" class="form-control" name="tipo" id="CONCESSIONARIA" autocomplete="off" value="CONCESSIONARIA">

                        <div class="col-md-12">
                          <div class="form-group">
                            <label>Nome Etapa</label>
                            <input type="text" class="form-control" name="nome_etapa_obra" id="nome_etapa_obra" value="<?php echo $array[0]['etp_nome_etapa_obra']; ?>" autocomplete="off">
                          </div>
                        </div>

                        <div class="col-md-4">
                          <div class="form-group">
                            <label>Nº Nota</label>
                            <input type="text" class="form-control" name="nota_numero_concessionaria" id="nota_numero_concessionaria" value="<?php echo $array[0]['nota_numero']; ?>" autocomplete="off">
                          </div>
                        </div>

                        <div class="col-md-2">
                          <div class="form-group">
                            <label>Data de Abertura</label>
                            <input type="text" class="form-control" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask="" name="data_abertura_concessionaria" id="data_abertura_concessionaria" value="<?php echo $array[0]['data_abertura']; ?>" autocomplete="off">
                          </div>
                        </div>

                        <div class="col-md-2">
                          <div class="form-group">
                            <label>Data Meta</label>
                            <input type="text" class="form-control" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask="" name="meta_etapa" id="meta_etapa" value="<?php echo $array[0]['meta_etapa']; ?>" autocomplete="off">
                          </div>
                        </div>


                        <div class="col-md-4">
                          <label>Prazo de Atendimento</label>
                          <div class="input-group">
                            <input type="text" class="form-control" value="<?php echo $array[0]['prazo_atendimento']; ?>" name="prazo_atendimento_concessionaria" id="prazo_atendimento_concessionaria" autocomplete="off">
                            <div class="input-group-btn">
                              <div class="btn btn-default">
                                <i></i> Dias
                              </div>
                            </div>
                          </div>
                        </div>
                        <?php if($this->userInfo['user']->hasPermission('obra_edit')): ?>
                        <div class="col-md-12" style="margin-bottom: 13px;margin-top:5px">
                          <div class="input-group">
                            <span class="input-group-addon">
                              <input class="flat-blue" name="check_nota" type="checkbox" value="1">

                            </span>
                            <span type="text"  class="form-control">Salvar como ultima nota</span>
                          </div>
                          <!-- /input-group -->
                        </div>
                        <?php endif; ?>



                      <?php elseif ($array[0]['nome'] === 'OBRA') : ?>
                        <input type="hidden" class="form-control" name="tipo" id="" autocomplete="off" value="OBRA">

                        <div class="col-md-12">
                          <div class="form-group">
                            <label>Nome Etapa</label>
                            <input type="text" class="form-control" name="nome_etapa_obra" id="nome_etapa_obra" value="<?php echo $array[0]['etp_nome_etapa_obra']; ?>" autocomplete="off">
                          </div>
                        </div>

                        <div class="col-md-3">
                          <div class="form-group">
                            <label>Responsável</label>
                            <input type="text" class="form-control" name="responsavel_obra" id="cliente_nome" value="<?php echo $array[0]['responsavel']; ?>" autocomplete="off">
                          </div>
                        </div>

                        <div class="col-md-2">
                          <div class="form-group">
                            <label>Data Programada</label>
                            <input type="text" class="form-control" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask="" name="data_programada_obra" id="data_programada_obra" value="<?php echo $array[0]['data_programada']; ?>" autocomplete="off">
                          </div>
                        </div>

                        <div class="col-md-2">
                          <div class="form-group">
                            <label>Data Iniciada </label>
                            <input type="text" class="form-control" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask="" name="data_iniciada_obra" id="data_iniciada_obra" value="<?php echo $array[0]['data_iniciada']; ?>" autocomplete="off">
                          </div>
                        </div>

                        <div class="col-md-2">
                          <div class="form-group">
                            <label>Data Meta</label>
                            <input type="text" class="form-control" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask="" name="meta_etapa" id="meta_etapa" value="<?php echo $array[0]['meta_etapa']; ?>" autocomplete="off">
                          </div>
                        </div>

                        <div class="col-md-3">
                          <div class="form-group">
                            <label>Tempo de Atividade</label>
                            <input type="text" class="form-control" name="tempo_atividade_obra" id="tempo_atividade_obra" value="<?php echo $array[0]['tempo_atividade']; ?>" autocomplete="off">
                          </div>
                        </div>

                        <div class="col-md-12">
                          <div class="form-group">
                            <label>Observações</label>
                            <input type="text" class="form-control" value="<?php echo $array[0]['observacao']; ?>" name="observacao" id="observacao" autocomplete="off">
                          </div>
                        </div>
                        <?php if($this->userInfo['user']->hasPermission('obra_edit')): ?>
                          <div class="col-md-12">
                            <div class="form-group">
                              <label>Observações do sistema</label>
                              <textarea type="text" class="form-control" name="observacao_sistema" id="observacao_sistema" autocomplete="off" rows="5" cols="33"><?php echo $array[0]['observacao_sistema']; ?>&#10;<?php echo $data_hoje.' ('.($Iniciais).')'; ?></textarea>
                            </div>
                          </div>
                        <?php endif; ?>


                      <?php endif; ?>
                    </div>
                  </div>
                </div>
              </div>

              <div class="box box-default box-solid">
                <div class="row">
                  <div class="col-md-12">
                    <div class="box-header with-border">
                      <h3 class="box-title">Documentos</h3>
                      <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" id='click<?php echo $array[0]['id_etapa_obra']; ?>'><i class="fa fa-plus-circle"></i></button>
                      </div>
                    </div>
                    <div class="box-body" style="">
                      <div id="etapa_ok<?php echo $array[0]['id_etapa_obra']; ?>">
                        <?php $documento_etapa = controller::getDocumentoEtapaObra($array[0]['id_etapa_obra']); ?>

                        <?php if (count($documento_etapa) > 0) : ?>
                          <?php foreach ($documento_etapa as $doc) : ?>
                            <div class="col-md-12">
                              <div class="input-group" style="width: 50%;">
                                <input type="text" class="form-control" autocomplete="off" value="<?php echo $doc['docs_nome']; ?>">
                                <div class="input-group-btn">
                                  <a href="<?php echo BASE_URL ?>assets/documentos/<?php echo $doc['docs_nome']; ?>" target="_blank" class="btn btn-info btn-flat" data-toggle="tooltip" title="" data-original-title="Ver Documento">
                                    <i class="fa fa-info"></i>
                                  </a>
                                  <a href="<?php echo BASE_URL ?>documentos/delete/<?php echo $doc['id']; ?>/<?php echo $array[0]['id_obra']; ?>/<?php echo $array[0]['id_etapa_obra']; ?>" class="btn btn-danger btn-flat" data-toggle="tooltip" title="" data-original-title="Deletar">
                                    <i class="fa fa-trash"></i>
                                  </a>
                                </div>
                              </div>
                            </div>
                          <?php endforeach; ?>
                        <?php else : ?>
                          Não foram encontrados resultados.
                        <?php endif; ?>
                      </div>

                      <div class="col-md-10" style="display:none;" id="new_etapa<?php echo $array[0]['id_etapa_obra']; ?>">
                        <label>Adicionar novo Documento</label>
                        <div class="input-group">
                          <input class="form-control" name="documento_etapa_nome" placeholder="Nome do Documento">
                          <div class="input-group-btn">
                            <div class="btn btn-default btn-file">
                              <i class="fa fa-paperclip"></i> PDF
                              <input type="file"  class="btn btn-success file_doc" name="documento_arquivo">
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <?php if($this->userInfo['user']->hasPermission('obra_edit')): ?>
              <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Salvar</button>
              </div>
            <?php endif; ?>
          </div>
        </div>
    </div>
  </div>

</div>


<script>
  $(function() {

    $('#click' + <?php echo $array[0]['id_etapa_obra']; ?>).on('click', function(e) {

      $('#new_etapa' + <?php echo $array[0]['id_etapa_obra']; ?>).toggle();
      $('#etapa_ok' + <?php echo $array[0]['id_etapa_obra']; ?>).toggle();


    });

  });
</script>