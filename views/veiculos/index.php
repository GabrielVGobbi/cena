<div class="col-xs-12">
	<div class="box box-primary">
		<div class="box-header with-border">
			<h3 class="box-title">Veiculos</h3>
			<div class="box-tools pull-right">
				<div class="has-feedback">
					<button class="btn btn-sm btn-info pop" onclick="openFiltro('<?php echo $viewData['pageController']; ?>')">
						<i class="glyphicon glyphicon-search"></i>
					</button>
					<a href="<?php echo BASE_URL; ?>veiculos" type="button" class="btn btn-default btn-sm"><i class="fa fa-refresh"></i></a>
					<?php if ($this->user->hasPermission('veiculos_view') && $this->user->hasPermission('veiculos_add')) : ?>
						<a href="<?php echo BASE_URL; ?>veiculos/add" type="button" class="btn btn-default btn-sm"><i class="fa fa-fw fa-plus-circle"></i> Novo</a>
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
												<!-- <th style="width: 10%;">Ações</th> -->
												<th>Nome do Veiculo</th>
												<th>Placa</th>
												<th>Ultimo Motorista</th>
											</tr>
											<?php foreach ($tableDados as $vei) : ?>
												<a type="button" href="">
													<tr onclick="javascript:location.href='<?php echo BASE_URL ?>veiculos/edit/<?php echo $vei['id_veiculo'] ?>'">
														<td><?php echo $vei['nome_veiculo'] ?></td>
														<td><?php echo $vei['placa_veiculo'] ?></td>
														<td><?php echo $vei['observacoes_veiculo'] ?></td>
													</tr>
												</a>
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
				<p> Quantidade de Veiculos: <?php echo $getCount; ?> </p>
			</div>
		</div>
		<div class="box-footer no-padding">
			<div class="mailbox-controls">
				<ul class="pagination pagination-sm pull-right">
					<?php for ($q = 1; $q <= $p_count; $q++) : ?>
						<li class="<?php echo ($q == $p) ? 'active' : '' ?> ">
							<a href="<?php echo BASE_URL; ?>veiculos?p=<?php $w = $_GET;
																			$w['p'] = $q;
																			echo http_build_query($w); ?>"><?php echo $q; ?></a>
						</li>
					<?php endfor; ?>
				</ul>
			</div>
		</div>
	</div>
</div>