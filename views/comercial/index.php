<div class="col-xs-12">
	<div class="box box-primary">
		<div class="box-header with-border">
			<h3 class="box-title">Comercial</h3>
			<div class="box-tools pull-right">
				<div class="has-feedback">
					<button class="btn btn-sm btn-info pop" onclick="openFiltro('<?php echo $viewData['pageController']; ?>')">
						<i class="glyphicon glyphicon-search"></i>
					</button>
					<a href="<?php echo BASE_URL; ?>comercial" type="button" class="btn btn-default btn-sm"><i class="fa fa-refresh"></i></a>
					<?php if ($this->user->hasPermission('comercial_view') && $this->user->hasPermission('comercial_add')) : ?>
						<a href="<?php echo BASE_URL; ?>comercial/add" type="button" class="btn btn-default btn-sm"><i class="fa fa-fw fa-plus-circle"></i> Novo</a>
					<?php endif; ?>
				</div>
			</div>
		</div>

		<div class="box-body no-padding">
			<?php include_once("filtro.php"); ?>
			<div class="table-responsive mailbox-messages">
				<table class="table table-hover table-striped table-bordered">
					<?php if (count($tableDados) > 0) : ?>
						<tbody>
							<div class="box">
								<div class="box-body table-responsive no-padding">
									<table class="table table-hover">
										<tbody>
											<tr>
												<th style="width: 10%;">Ações</th>
												<th>ID</th>
												<th>Nome da Obra</th>
												<th>Responsável</th>
												<th>Concessionaria</th>
												<th>Serviço</th>
												<th style="width: 10%;" class="text-center">Status</th>
											</tr>
											<?php foreach ($tableDados as $inf) : ?>
												<tr>
													<td>
														<?php if ($this->user->hasPermission('comercial_view') && $this->user->hasPermission('comercial_edit')) : ?>
															<a type="button" data-toggle="tooltip" title="" data-original-title="Editar" class="btn btn-info" href="<?php echo BASE_URL ?>comercial/edit/<?php echo $inf['id_comercial'] ?>"><i class="fa fa-fw fa-edit"></i></a>
														<?php endif; ?>
													</td>
													<td><?php echo $inf['id_comercial'] ?></td>
													<td><?php echo $inf['nome_obra'] ?></td>
													<td><?php echo $inf['cliente_responsavel'] ?></td>
													<td><?php echo $inf['razao_social'] ?></td>
													<td><?php echo $inf['sev_nome'] ?></td>
													<td class="text-center">
														<select class="form-control select2" style="width: 100%;" name="select-etapas" id="comercialStatusSelect<?php echo $inf['id_comercial']; ?>">
															<option <?php echo $inf['id_status'] == ELABORACAO ?  'selected' : '' ?> value="1">ELABORAÇÃO</option>
															<option <?php echo $inf['id_status'] == ENVIADA    ?  'selected' : '' ?> value="2">ENVIADA</option>
															<option <?php echo $inf['id_status'] == APROVADA   ?  'selected' : '' ?> value="3">APROVADA</option>
															<option <?php echo $inf['id_status'] == RECUSADA   ?  'selected' : '' ?> value="4">RECUSADA</option>
														</select>
													</td>

												</tr>

												<script>
													$(function() {
														$('#comercialStatusSelect' + <?php echo $inf['id_comercial']; ?>).on('change', function(event) {

															var item = '#comercialStatusSelect' + <?php echo $inf['id_comercial']; ?>;
															var itemSelecionado = $(item + " option:selected");
															var id_comercial = <?php echo $inf['id_comercial']; ?>;
															var obra_nome = '<?php echo $inf['nome_obra']; ?>';

															var id_concessionaria = <?php echo $inf['id_concessionaria']; ?>;
															var id_servico		  = <?php echo $inf['id_servico']; ?>;
															var id_cliente 		  = <?php echo $inf['id_cliente']; ?>;		
															var id_comercial 	  = <?php echo $inf['id_comercial']; ?>;											


															$.ajax({

																url: BASE_URL + 'ajax/changeStatusComercial',
																type: 'POST',
																data: {
																	tipo: itemSelecionado.val(),
																	id_comercial: id_comercial
																},
																dataType: 'json',
																success: function(json) {

																},
															});

															if (itemSelecionado.val() == 3) {

																swal({
																		title: "Proposta foi aprovada",
																		text: "Fazer o cadastro da obra: " + obra_nome,
																		icon: "warning",
																		buttons: true,
																		dangerMode: true,
																	})
																	.then((willDelete) => {
																		if (willDelete) {
																			$.ajax({

																				url: BASE_URL + 'ajax/add_obra',
																				type: 'POST',
																				data: {
																					servico: id_servico,
																					concessionaria: id_concessionaria,
																					id_cliente: id_cliente,
																					obra_nome: obra_nome,
																					id_comercial: id_comercial
																				},
																				dataType: 'json',
																				success: function(json) {
																					swal({
																						title: "Sucesso!",
																						text: "Cadastro efetuado com sucesso",
																						icon: "success",

																					})

																					setInterval(window.location.href = BASE_URL+'obras/edit/'+json, 2000);
																					
																					
																				},
																				error: function(data) {
																					swal({
																						title: "Oops!!",
																						text: "Essa obra ja foi criada",
																						icon: "warning",

																					})
																				}

																			});
																		} else {

																		}
																	});
															}

														});
													});
												</script>
											<?php endforeach; ?>
										</tbody>
									</table>
								</div>
							</div>
						</tbody>
					<?php else : ?>
						<tr>
							<td style="width: 50%;text-align: center;"> Não foram encontrados resultados </td>
						</tr>
					<?php endif; ?>
				</table>
			</div>
			<div class="pull-left" style="right: 10px;">
				<p> Quantidade Propostas: <?php echo $getCount; ?> </p>
			</div>
		</div>
		<div class="box-footer no-padding">
			<div class="mailbox-controls">
				<ul class="pagination pagination-sm pull-right">
					<?php for ($q = 1; $q <= $p_count; $q++) : ?>
						<li class="<?php echo ($q == $p) ? 'active' : '' ?> ">
							<a href="<?php echo BASE_URL; ?>comercial?p=<?php $w = $_GET;
																			$w['p'] = $q;
																			echo http_build_query($w); ?>"><?php echo $q; ?></a>
						</li>
					<?php endfor; ?>
				</ul>
			</div>
		</div>
	</div>
</div>