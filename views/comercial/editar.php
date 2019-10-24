

<div class="box box-default ">
	<div class="box-header with-border">
		<h3 class="box-title">Editar</h3>
	</div>

	<div class="box-body" style="">
		<form method="POST" enctype="multipart/form-data" action="<?php echo BASE_URL ?>comercial/edit/<?php echo $tableInfo['id_comercial']; ?>">
			<div class="tab-content">
				<input type="hidden" class="form-control" name="id_comercial" id="id_comercial" autocomplete="off" value="<?php echo $tableInfo['id_comercial']; ?>">
				<input type="hidden" class="form-control" name="id_concessionaria" id="id_concessionaria" autocomplete="off" value="<?php echo $tableInfo['id_concessionaria']; ?>">
				<input type="hidden" class="form-control" name="id_servico" id="id_servico" autocomplete="off" value="<?php echo $tableInfo['id_servico']; ?>">

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
										<input type="text" class="form-control" name="nome_obra" id="nome_obra" value="<?php echo $tableInfo['nome_obra']; ?>" autocomplete="off">
									</div>

								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label>Concessionaria</label>
										<input type="text" class="form-control" disabled name="concessionaria_nome" id="concessionaria_nome" value="<?php echo $tableInfo['razao_social']; ?>" autocomplete="off">
									</div>
								</div>

								<div class="col-md-4">
									<div class="form-group">
										<label>Tipo de Obra/Serviço</label>
										<input type="text" class="form-control" disabled name="servico_nome" id="servico_nome" value="<?php echo $tableInfo['sev_nome']; ?>" autocomplete="off">
									</div>
								</div>

								<div class="col-md-10" style="margin-bottom:6px;">
									<label>Cliente</label>
									<input type="text" class="form-control" disabled name="cliente_nome" id="cliente_nome" value="<?php echo $tableInfo['cliente_nome']; ?>" autocomplete="off">
								</div>

								<div class="col-md-2" style="margin-bottom:6px;">
									<label>Data de Criação</label>
									<input type="text" class="form-control" name="data_obra" id="data_obra" data-inputmask="'alias': 'dd/mm/yy'" data-mask="" value="<?php echo $tableInfo['data_envio']; ?>" autocomplete="off" required>
								</div>
							</div>
						</div>

					</div>
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
                                        <input type="text" class="form-control" name="valor_proposta" id="totalProposta" autocomplete="off" value="R$ <?php echo number_format($tableInfo['valor_proposta'], 2, ',', '.'); ?>">
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Valor de Desconto</label>
                                        <input type="text" class="form-control"  name="valor_desconto" id="valor_desconto" autocomplete="off" value="R$ <?php echo ($tableInfo['valor_desconto'] != '' ? number_format($tableInfo['valor_desconto'], 2, ',', '.') : '' ); ?>">
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Valor Negociado</label>
                                        <input type="text" class="form-control" name="valor_negociado" id="Totalnegociado" autocomplete="off" value="R$ <?php echo number_format($tableInfo['valor_negociado'], 2, ',', '.'); ?>">
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Data de Envio</label>
                                        <input type="text" class="form-control" name="data_envio"  value="<?php echo $tableInfo['data_envio']; ?>" autocomplete="off" required="">
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

				<div class="box box-default box-solid">
					<div class="row">
						<div class="col-md-12">
							<div class="box-header with-border">
								<h3 class="box-title">Método de Pagamento</h3>
							</div>
							<div class="box-body" style="">

								<div class="col-md-4">
									<div class="form-group">
										<label>Selecione a Etapa</label>
										<select class="form-control select2 etapa_selecionado" style="width: 100%;" name="etapa" id="id_sub_etapas_todas" aria-hidden="true" required>
											<option value="0">selecione</option>
										</select>
									</div>
								</div>

								<div class="col-md-2">
									<div class="form-group">
										<label>Método</label>
										<select class="form-control select2 metodo_etapa" style="width: 80%;" name="metodo_etapa" id="metodo_etapa" aria-hidden="true" required>
											<option selected value="1">%</option>
											<option value="2">R$</option>
										</select>
									</div>
								</div>

								<div class="col-md-2" id="metodo_valor" style="display:none;right: 27px;">
									<label>Valor</label>
									<div class="input-group">
										<span class="input-group-addon">R$</span>
										<input type="text" value="" id="input_valor" onkeyup="atualizarValorReceber()" class="form-control">
									</div>
								</div>

								<div class="col-md-2" style="right: 27px;" id="metodo_porcentagem">
									<label>Porcentagem</label>
									<div class="input-group">
										<input type="text" id="input_porcentagem" class="form-control">
										<span class="input-group-addon">%</span>
									</div>
								</div>
								
								<div class="col-md-2" style="right: 27px;">
									<label>Valor a receber</label>
									<div class="input-group">
										<input type="text" id="valor_etapa_receber"  value="" class="form-control">
									</div>
								</div>
								
								<div class="col-md-2">
									<label></label>
									<button type="button" style=" top: 5px;position: relative;" class="btn btn-block btn-primary" id="addHistorico">Adicionar</button>
								</div>
							</div>

						</div>
					</div>
				</div>

				<div class="box box-default box-solid">
					<div class="row">
						<div class="col-md-12">
							<div class="box-header with-border">
								<h3 class="box-title">Historico</h3>
							</div>
							<input type="hidden" id="valor_etapa_receber_historico" onchange="verificarTotal()" value="" class="form-control">
							<div class="box-body" style="">

								<div class="col-md-12">

									<table class="table table-striped">
										<thead>
											<tr>
												<th>Nome</th>
												<th>Método</th>
												<th>Valor</th>
												<th>Ação</th>

											</tr>
										</thead>
										<tbody id="id_historico_etapa">
													
										</tbody>
										
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="modal-footer">
					<button type="submit" class="btn btn-primary">Salvar</button>
					<a href="<?php echo BASE_URL; ?>comercial" class="btn btn-danger">Voltar</a>
				</div>
		</form>
	</div>



</div>


<script src="<?php BASE_URL?>/views/<?php echo $viewData['pageController'];?>/parametros/<?php echo $viewData['pageController'];?>.js"></script>