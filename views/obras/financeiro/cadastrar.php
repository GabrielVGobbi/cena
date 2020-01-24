<div class="box box-default ">
    <div class="box-header with-border">
        <h3 class="box-title">Cadastro</h3>
    </div>

    <div class="box-body" style="">
        <form method="POST" enctype="multipart/form-data" action="<?php echo BASE_URL; ?>financeiro/add_action">
            <div class="box box-default box-solid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="box-header with-border">
                            <h3 class="box-title">Dados</h3>
                        </div>
                        <div class="box-body" style="">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Valor de Custo</label>
                                    <input type="text" class="form-control" name="valor_custo" onKeyPress="return(moeda(this,'.',',',event))" value="" id="valor_custo" autocomplete="off">
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Valor da Proposta</label>
                                    <input type="text" class="form-control" name="valor_proposta" required value="" id="totalProposta" autocomplete="off">
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Valor de Desconto</label>
                                    <input type="text" class="form-control" onkeyup="updateDesconto()" value="" name="valor_desconto" id="valor_desconto" autocomplete="off">
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Valor Negociado</label>
                                    <input type="text" class="form-control" name="valor_negociado" value="" id="Totalnegociado" autocomplete="off">
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Obra</label>
                                    <select class="form-control select2" style="width: 100%;" name="id_obra" id="id_obra" aria-hidden="true" required>
                                        <option value="">selecione</option>
                                        <?php foreach ($viewData['obras'] as $obr) : ?>
                                            <?php echo $id_obra; ?>
                                            
                                            <option <?php echo((isset($id_obra) && $id_obra == $obr['id'])) ?  'selected' : '' ?> value="<?php echo $obr['id']; ?>"><?php echo $obr['obr_razao_social'] ?></option>
                                            
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="pull-right">
                <button type="submit" class="btn btn-primary">Salvar</button>
            </div>
        </form>
    </div>
</div>

<script>

</script>

<script src="<?php BASE_URL?>/views/comercial/parametros/comercial.js"></script>


