<?php
//error_log(print_r($viewData, 1));
?>

<div class="col-md-12">
	<div class="nav-tabs-custom">
		<form method="POST" enctype="multipart/form-data">
			<div class="tab-content">
				<input type="hidden" class="form-control" name="id" id="id" autocomplete="off" value="<?php echo $tableInfo['id']; ?>">
				<div class="tab-pane active" id="dados">
					<div class="box box-default box-solid">
						<div class="row">
							<div class="col-md-12">
								<div class="box-header with-border">
									<h3 class="box-title">Dados</h3>
								</div>
								<div class="box-body" style="">
									<div class="col-md-6">
										<div class="form-group">
											<label>Razão Social</label>
											<input type="text" class="form-control" name="razao_social" id="razao_social" autocomplete="off" value="<?php echo $tableInfo['razao_social']; ?>">
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
									<h3 class="box-title">Serviços</h3>
									<div class="box-tools pull-right">
										<button type="button" class="btn btn-box-tool new_service"><i class="fa fa-plus-circle"></i></button>
									</div>
								</div>
								<div class="box-body" style="">
									<div id="service_ok">
										<table class="table table-striped">
											<thead>
												<tr>
													<th style="width: 10%">Ações</th>
													<th>#</th>
													<th>Nome do Serviço</th>
													<th style="width: 240px">&nbsp;</th>
												</tr>
											</thead>
											<tbody>
												<?php foreach ($servicos_concessionaria as $scon) : ?>
													<tr>
														<td>
															<a type="button" data-toggle="tooltip" title="" data-original-title="Tarefas" class="btn btn-info" href="<?php echo BASE_URL; ?>concessionarias/editService/<?php echo $tableInfo['id']; ?>/<?php echo $scon['id']; ?>"><i class="ion ion-clipboard"></i></a>
															<a type="button" data-toggle="tooltip" title="" data-original-title="Deletar" class="btn btn-danger" href="<?php echo BASE_URL ?>servicos/delete/<?php echo $scon['id']; ?>"><i class="ion ion-trash-a"></i></a>
														</td>
														<td><?php echo $scon['id']; ?></td>
														<td><?php echo $scon['sev_nome']; ?></td>
														<td></td>
													</tr>
												<?php endforeach; ?>
											</tbody>
										</table>
									</div>
									<div class="col-md-10" style="display:none;" id="new_service">
										<div class="input-group">
											<label>Adicionar novo Serviço</label>
											<select class="form-control select2-add-service select2-hidden-accessible service_add" data-placeholder="Selecione o serviço" style="width: 100%;" name="servico" id="new_servico[]" aria-hidden="true" required>
												<option> selecione </option>
												<?php foreach ($tableInfo['servico_not_concessionaria'] as $sev) : ?>
													<option value="<?php echo $sev['id']; ?>"><?php echo $sev['sev_nome'] ?></option>
												<?php endforeach; ?>
											</select>
											<!--<span onclick="add_service()" style="cursor: pointer;border-color: #f00;border-left: 1%;" class="input-group-addon span-artist"><i class="fa fa-check has-error"></i></span>-->
										</div>
									</div>

								</div>

							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-primary">Salvar</button>
				<a href="<?php echo BASE_URL; ?>concessionarias" class="btn btn-danger">Voltar</a>
			</div>
		</form>
	</div>



</div>

</div>