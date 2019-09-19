<?php require_once("cadastrar.php"); ?>
<div class="col-xs-12">
	<div class="box box-primary">
		<div class="box-header with-border">
			<h3 class="box-title">Serviços</h3>
			<div class="box-tools pull-right">
				<div class="has-feedback">

					<button class="btn btn-sm btn-info pop" onclick="openFiltro('<?php echo $viewData['pageController']; ?>')">
						<i class="glyphicon glyphicon-search"></i>
					</button>
					<?php if ($this->user->hasPermission('servico_view') && $this->user->hasPermission('servico_add')) : ?>
						<button class="btn btn-sm btn-info pop" data-toggle="modal" data-target="#modalCadastro">
							<i class="fa fa-fw fa-plus-circle"></i>
						</button>
					<?php endif; ?>
					<a href="<?php echo BASE_URL; ?>servicos" type="button" class="btn btn-default btn-sm"><i class="fa fa-refresh"></i></a>
					<a data-toggle="modal" data-target="#modalImportar" class="btn btn-default btn-sm"><i class="fa fa-file-excel-o"></i></a>
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
												<th>ID</th>
												<th>Nome</th>
											</tr>
											<?php foreach ($tableDados as $inf) : ?>
												<tr>
													<td>
														<?php if ($this->user->hasPermission('servico_view') && $this->user->hasPermission('servico_edit')) : ?>
															<a type="button" class="btn btn-info" href="<?php echo BASE_URL ?>servicos/edit/<?php echo $inf['id'] ?>"><i class="fa fa-fw fa-edit"></i></a>
														<?php endif; ?>
														<button class="btn btn-danger" data-toggle="popover" title="Remover?" data-content="<a href='<?php echo BASE_URL ?>servicos/delete/<?php echo $inf['id'] ?>' class='btn btn-danger'>Sim</a> <button type='button' class='btn btn-default pop-hide'>Não</button>">
															<i class="fa fa-fw fa-trash"></i>
														</button>
													</td>
													<td><?php echo $inf['id'] ?></td>
													<td><?php echo $inf['sev_nome'] ?></td>
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
				<p> Quantidade de serviços: <?php echo $getCount; ?> </p>
			</div>
		</div>
		<div class="box-footer no-padding">
			<div class="mailbox-controls">
				<ul class="pagination pagination-sm pull-right">
					<?php for ($q = 1; $q <= $p_count; $q++) : ?>
						<li class="<?php echo ($q == $p) ? 'active' : '' ?> ">
							<a href="<?php echo BASE_URL; ?>servicos?p=<?php $w = $_GET;
																			$w['p'] = $q;
																			echo http_build_query($w); ?>"><?php echo $q; ?></a>
						</li>
					<?php endfor; ?>
				</ul>
			</div>
		</div>
	</div>
</div>
<?php include("excel.php"); ?>