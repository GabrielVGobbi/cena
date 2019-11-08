<?php require_once("cadastrar.php");  ?>

<div class="col-xs-12">
	<div class="box box-primary">
		<div class="box-header with-border">
			<h3 class="box-title"><?php echo ucfirst($viewData['pageController']); ?></h3>
			<div class="box-tools ">
				<div class="has-feedback">
					<button class="btn btn-sm btn-info pop" data-toggle="tooltip" title="" data-original-title="Filtro Avançado" onclick="openFiltro('<?php echo $viewData['pageController']; ?>')">
						<i class="glyphicon glyphicon-search"></i>
					</button>
					<?php if ($this->user->hasPermission('obra_view') && $this->user->hasPermission('obra_add')) : ?>
						<button class="btn btn-sm btn-info pop" data-toggle="modal" data-target="#modalCadastro">
							<i class="fa fa-fw fa-plus-circle"></i>
						</button>
					<?php endif; ?>
					<a href="<?php echo BASE_URL; ?>obras" type="button" class="btn btn-default btn-sm"><i class="fa fa-refresh"></i></a>
				</div>
			</div>
		</div>

		<?php
		include_once("filtro.php");
		$atraso = 'success';
		?>
		<?php if (count($tableDados) > 0) : ?>
			<?php foreach ($tableDados as $obr) : ?>

				<div class="col-md-4" style="margin-top:20px;">

					<div class="box box-default">
						<a data-toggle="modal" href="<?php echo BASE_URL; ?>obras/edit/<?php echo $obr[0]; ?>" style="color: #000;    cursor: pointer; ">
							<div class="box-header with-border">
								<i class="fa fa-building-o"></i>

								<h3 class="box-title"><?php echo $obr['obr_razao_social']; ?></h3>
							</div>
							<div class="box-body">
								<div class="col-sm-12 invoice-col">
									<b>Ultima nota: NTA - <?php echo $obr['obra_nota_numero']; ?></b><br>
									<br>
									<b>Cliente:</b> <?php echo $obr['cliente_nome']; ?><br>
									<b>Serviço:</b> <?php echo $obr['sev_nome']; ?><br>
									<b>Concessionaria:</b> <?php echo $obr['razao_social']; ?><br>
									<div class="progress-group" style="margin-top: 14px;">
										<span class="progress-text">Etapas Concluidas</span>
										<span class="progress-number"><b><?php echo $etapas = $this->obra->getEtapasConcluidas($obr[0]); ?></b>/<?php echo $etapas = count($this->obra->getEtapas($obr[0], '')); ?></span>
										<?php
												$soma = (100) / count($this->obra->getEtapas($obr[0], ''));
												if ($this->obra->getEtapasConcluidas($obr[0]) != 0) {
													$soma_etapa = $soma * $this->obra->getEtapasConcluidas($obr[0]);
												} else {
													$soma_etapa = 0;
												}
												?>
										<div class="progress sm">
											<div class="progress-bar progress-bar-green" style="width: <?php echo $soma_etapa; ?>%"></div>
										</div>
									</div>
								</div>
							</div>
						</a>
						<div class="box-footer clearfix">
							<?php if($obr['atv'] == 1): ?>
								<a href="<?php echo BASE_URL; ?>obras/concluir/<?php echo $obr[0]; ?>" class="btn btn-sm btn-info btn-flat pull-left">Concluir Obra</a>
							<?php else: ?>
								<a href="<?php echo BASE_URL; ?>obras/desconcluir/<?php echo $obr[0]; ?>" class="btn btn-sm btn-warning btn-flat pull-left">Desconcluir Obra</a>
							<?php endif;?>

							<?php if ($this->user->hasPermission('obra_view') && $this->user->hasPermission('obra_delete')) : ?>
								<button class="btn btn-sm btn-danger btn-flat pull-right" data-toggle="popover" title="Remover?" data-content="<a href='<?php echo BASE_URL; ?>obras/delete/<?php echo $obr[0]; ?>' class='btn btn-danger'>Sim</a> <button type='button' class='btn btn-default pop-hide'>Não</button>">
									Excluir Obra
								</button>
							<?php endif; ?>
							<?php if ($this->user->hasPermission('financeiro_view')) : ?>
								<a href="<?php echo BASE_URL;?>financeiro/obra/<?php echo $obr[0]; ?>" class="btn btn-sm btn-warning btn-flat text-center" style="    left: 10%;position: relative;" >
									Financeiro
								</a>
							<?php endif; ?>
						</div>
					</div>

				</div>


			<?php endforeach; ?>
		<?php else : ?>
			<div class="col-md-12" style="margin-top:20px;text-align: center;">
				Não foi encontrado nenhum resultado
			</div>

		<?php endif; ?>
	</div>


	<script>
		<?php if (isset($_GET['id']) && $_GET['id'] != '') : ?>

			$(function() {
				$('#modalVisualizar' + id).modal('show');
			});

		<?php endif; ?>
	</script>