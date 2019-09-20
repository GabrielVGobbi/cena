<?php require_once("cadastrar.php"); ?>
<div class="col-xs-12">
	<div class="box box-primary">
		<div class="box-header with-border">
			<h3 class="box-title">Usuarios</h3>
			<div class="box-tools pull-right">
				<div class="has-feedback">
					<button class="btn btn-sm btn-info pop" onclick="openFiltro('<?php echo $viewData['pageController']; ?>')">
						<i class="glyphicon glyphicon-search"></i>
					</button>
					<?php if ($this->user->hasPermission('user_view') && $this->user->hasPermission('user_add')) : ?>
						<button class="btn btn-sm btn-info pop" data-toggle="modal" data-target="#modalCadastro">
							<i class="fa fa-fw fa-plus-circle"></i>
						</button>
					<?php endif; ?>
					<a href="<?php echo BASE_URL; ?>usuario" type="button" class="btn btn-default btn-sm"><i class="fa fa-refresh"></i></a>
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
												<th>Usuario</th>
												<th>Email</th>
												<th>Tipo</th>
											</tr>
											<?php foreach ($tableDados as $inf) : ?>
												<tr <?php echo ($inf['id'] == $_SESSION['ccUser'] ? "class='table-danger'" : ""); ?>>
													<td>
														<?php if ($this->user->hasPermission('user_view') && $this->user->hasPermission('user_edit')) : ?>
															<a type="button" class="btn btn-info" href="<?php echo BASE_URL ?>usuario/edit/<?php echo $inf['id'] ?>"><i class="fa fa-fw fa-edit"></i></a>
														<?php endif; ?>
														<?php if ($this->user->hasPermission('user_delet') && $_SESSION['ccUser'] != $inf['id']) : ?>
															<a type="button" href="<?php echo BASE_URL ?>usuario/delete/<?php echo $inf['id'] ?>" class="<?php echo ($inf['usu_ativo'] == ATIVO ? "btn btn-success" : "btn btn-default");	?>"><i class="fa fa-fw fa-toggle-on"></i></a>
														
															
															<?php endif; ?>
													</td>
													<td><?php echo $inf['login'] ?></td>
													<td><?php echo $inf['email'] ?></td>
													<td><?php echo strtoupper($inf['usr_info']) ?></td>

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
				<p> Quantidade de Usuarios: <?php echo $user_cont; ?> </p>
			</div>
		</div>
		<div class="box-footer no-padding">
			<div class="mailbox-controls">
				<ul class="pagination pagination-sm pull-right">
					<?php for ($q = 1; $q <= $p_count; $q++) : ?>
						<li class="<?php echo ($q == $p) ? 'active' : '' ?> ">
							<a href="<?php echo BASE_URL; ?>usuario?p=<?php $w = $_GET;
																				$w['p'] = $q;
																				echo http_build_query($w); ?>"><?php echo $q; ?></a>
						</li>
					<?php endfor; ?>
				</ul>
			</div>
		</div>
	</div>
</div>