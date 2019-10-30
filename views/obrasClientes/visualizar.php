<?php

$documento_obra = $this->documento->getDocumentoObra($obr[0]);

?>

<div class="col-md-12">
	<div class="nav-tabs-custom">

			<div class="tab-content">
				<input type="hidden" class="form-control" name="id" id="id" autocomplete="off" value="<?php echo $obr[0]; ?>">
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
										<input type="text" class="form-control" name="obra_nome" id="obra_nome" value="<?php echo $obr['obr_razao_social']; ?>" autocomplete="off">
									</div>

								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label>Concessionaria</label>
										<input type="text" class="form-control" disabled name="concessionaria_nome" id="concessionaria_nome" value="<?php echo $obr['razao_social']; ?>" autocomplete="off">
									</div>
								</div>

								<div class="col-md-4">
									<div class="form-group">
										<label>Tipo de Obra/Serviço</label>
										<input type="text" class="form-control" disabled name="servico_nome" id="servico_nome" value="<?php echo $obr['sev_nome']; ?>" autocomplete="off">
									</div>
								</div>

								<div class="col-md-10" style="margin-bottom:6px;">
									<label>Cliente</label>
									<input type="text" class="form-control" disabled name="cliente_nome" id="cliente_nome" value="<?php echo $obr['cliente_nome']; ?>" autocomplete="off">
								</div>

								<div class="col-md-2" style="margin-bottom:6px;">
									<label>Data de Criação</label>
									<input type="text" class="form-control" name="data_obra" id="data_obra" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask="" value="<?php echo $obr['data_obra']; ?>" autocomplete="off" required>
								</div>
							</div>
						</div>

						<div class="col-md-12">
							<div class="box-body">
								<div class="box box-primary">
									<div class="box-header ">
										<i class="ion ion-clipboard"></i>
										<h3 class="box-title title-tipo">Etapas
											<?php if (isset($_GET['tipo'])) {
												if ($_GET['tipo'] == CONCESSIONARIA) {
													echo 'Concessionaria';
												} else if ($_GET['tipo'] == ADMINISTRATIVA) {
													echo 'Administativo';
												} else if ($_GET['tipo'] == OBRA) {
													echo 'Obra';
												}
											}

											?> </h3>
										<div class="box-tools pull-right" style="width: 14%;">

											<div class="form-group">
												<select class="form-control select2" style="width: 100%;" name="select-etapas" id="select-etapas">
													<option <?php echo (isset($_GET['tipo']) && $_GET['tipo'] == '') ?  'selected' : '' ?> value="">Todos</option>
													<option <?php echo (isset($_GET['tipo']) && $_GET['tipo'] == '2') ?  'selected' : '' ?> value="<?php echo CONCESSIONARIA; ?>">Concessionaria</option>
													<option <?php echo (isset($_GET['tipo']) && $_GET['tipo'] == '1') ?  'selected' : '' ?> value="<?php echo ADMINISTRATIVA; ?>">Administrativo</option>
													<option <?php echo (isset($_GET['tipo']) && $_GET['tipo'] == '3') ?  'selected' : '' ?> value="<?php echo OBRA; ?>">Obra</option>
												</select>
											</div>

										</div>
									</div>

									<div class="box-body">

										<?php include('etapas/obraEtapaTipo.php') ?>

									</div>


									<div class="box-footer clearfix no-border">
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
								<h3 class="box-title">Documentos</h3>
								<div class="box-tools pull-right">
									<button type="button" class="btn btn-box-tool dropdown-toggle " data-toggle="dropdown" aria-expanded="true">
										<i class="fa fa-wrench"></i>
									</button>
									<ul class="dropdown-menu" role="menu">
										<li><a href="<?php echo BASE_URL;?>obras/gerar/<?php echo $obr[0];?>">Gerar Winrar</a></li>

									</ul>
								</div>
							</div>
							<div class="box-body" style="">
								<div id="obra_ok">
									<?php if (count($documento_obra) > 0) : ?>
										<?php foreach ($documento_obra as $doc) : ?>
											<div class="col-md-12">
												<div class="input-group" style="width: 50%;">
													<input type="text" class="form-control" autocomplete="off" value="<?php echo $doc['docs_nome']; ?>">
													<div class="input-group-btn">
														<a href="<?php echo BASE_URL ?>assets/documentos/<?php echo $doc['docs_nome']; ?>" target="_blank" class="btn btn-info btn-flat" data-toggle="tooltip" title="" data-original-title="Ver Documento">
															<i class="fa fa-info"></i>
														</a>
													</div>
												</div>
											</div>
										<?php endforeach; ?>
									<?php else : ?>
										Não foram encontrados resultados.
									<?php endif; ?>
								</div>

								
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				
				<a href="<?php echo BASE_URL; ?>home" class="btn btn-danger">Voltar</a>
			</div>

	</div>



</div>


<script type="text/javascript">
	$('#select-etapas').on('change', function() {
		var tipo = $("#select-etapas option:selected").val();

		window.location.href = BASE_URL + 'home/visualizar/<?php echo $obr[0]; ?>?tipo=' + tipo;


	});

    
</script>