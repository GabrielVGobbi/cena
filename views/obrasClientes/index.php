<div class="col-xs-12">
	<div class="box box-primary">
		<div class="box-header with-border">
			<h3 class="box-title">Obras cadastradas em seu nome</h3>
			<div class="box-tools pull-right">
				<div class="has-feedback">
					
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
												<th style="width: 22%;">Ações</th>
												<th>Nome</th>
												<th>Serviço</th>

											</tr>
											<?php foreach ($tableDados as $obr) : ?>
												<tr>
													<td>
														<a type="button" class="btn btn-info" data-toggle="modal" href="<?php echo BASE_URL;?>home/visualizar/<?php echo $obr['id_obra'];?>"><i class="fa fa-fw fa-info"></i></a>

													</td>
													<td><?php echo $obr['obr_razao_social'] ?></td>
													<td><?php echo $obr['sev_nome']; ?></td>

													
												</tr>

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
			</div>
		</div>
		<div class="box-footer no-padding">
			
		</div>
	</div>
</div>
