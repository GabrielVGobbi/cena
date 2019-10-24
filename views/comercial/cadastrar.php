<div class="box box-default ">
    <div class="box-header with-border">
        <h3 class="box-title">Cadastrar</h3>
    </div>

    <div class="box-body" style="">
        <form method="POST" enctype="multipart/form-data" action="<?php echo BASE_URL; ?>comercial/add_action">
            <div class="box box-default box-solid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="box-header with-border">
                            <h3 class="box-title">Dados</h3>
                        </div>
                        <div class="box-body" style="">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Nome da Obra</label>
                                    <input type="text" class="form-control" name="obra_nome" id="obra_nome" autocomplete="off" required>
                                </div>
                            </div>

                            <div class="col-md-8">
                                <div class="form-group">
                                    <label>Descrição</label>
                                    <input type="text" class="form-control" name="comercial_descricao" id="comercial_descricao" autocomplete="off" required>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Concessionaria</label>
                                    <select class="form-control select2 concessionaria_select" style="width: 100%;" name="concessionaria" id="id_concessionaria" aria-hidden="true" required>
                                        <option value="">selecione</option>
                                        <?php foreach ($viewData['concessionaria'] as $com) : ?>
                                            <option value="<?php echo $com['id']; ?>"><?php echo $com['razao_social'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Tipo de Obra/Serviço</label>
                                    <select class="form-control select2 service_select" style="width: 100%;" name="servico" data-tipo="true" id="id_servico" required>
                                        <option value="">selecione a concessionaria</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4" style="margin-bottom:6px;">
                                <label>Cliente</label>
                                <div class="input-group">
                                    <input type="hidden" name="id_cliente" id="id_cliente" class="form-control">
                                    <input type="text" class="form-control" name="cliente" id="cliente" required data-type="search_cliente" required="" autocomplete="off">
                                    <span onclick="add_cliente()" style="cursor: pointer;border-color: #f00;border-left: 1%;" class="input-group-addon span-cliente"><i class="fa fa-check has-error"></i></span>
                                </div>
                                <div id="art" type="hidden">

                                    <span class="span-dropdown">
                                        <span class="span-dropdown-2">
                                            <ul class="ul-span-dropdown">
                                                <div class="searchresultscliente">

                                                </div>
                                            </ul>
                                        </span>
                                    </span>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--
            
            -->

            <div class="box box-primary span_etapa" style="display:none;">
                <div class="box-header">
                    <i class="ion ion-clipboard"></i>
                    <h3 class="box-title tarefas-tittle">Compras de ""</h3>
                </div>
                <div class="box-body">
                    <ul class="todo-list">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>Quantidade</th>
                                    <th>Tipo</th>
                                    <th>Preço Uni.</th>
                                    <th>Sub-Total</th>
                                </tr>
                            </thead>
                            <tbody id="id_sub_etapas">
                            </tbody>
                            <tr>
                                <td colspan="3">Total </td>
                                <td colspan="1" id="total"> </td>
                                <td id="totalSub"> </td>
                            </tr>
                        </table>
                    </ul>
                </div>

                <div class="box box-default box-solid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box-header with-border">
                                <h3 class="box-title">Financeiro</h3>
                            </div>
                            <div class="box-body" style="">

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Valor da Proposta</label>
                                        <input type="text" class="form-control" name="valor_proposta" required value="" id="totalProposta" autocomplete="off">
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Valor de Desconto</label>
                                        <input type="text" class="form-control" onkeyup="updateDesconto()" value="" name="valor_desconto" id="valor_desconto" autocomplete="off">
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Valor Negociado</label>
                                        <input type="text" disabled class="form-control" name="valor_negociado" value="" id="Totalnegociado" autocomplete="off">
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Data de Envio</label>
                                        <input type="text" class="form-control" name="data_envio" value="<?php echo date('d/m/y'); ?>" autocomplete="off" required="">
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="box box-primary result_null" style="display:none;">
                <div class="box-header">

                </div>
                <div class="box-body">
                    <div style="text-align: center;">
                        <span class="" id="result_null"> </span>
                    </div>
                </div>

            </div>

            <div class="pull-right">
                <button type="submit" class="btn btn-primary">Salvar</button>
            </div>
        </form>
    </div>
</div>

<script src="<?php BASE_URL?>/views/<?php echo $viewData['pageController'];?>/parametros/<?php echo $viewData['pageController'];?>.js"></script>
