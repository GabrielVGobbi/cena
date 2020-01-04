<?php

$documento_obra = $this->documento->getDocumentoObra($obr[0]);

?>
<section class="content-header">

	<ol class="breadcrumb" style="    top: -17px;">
		<li><a href="<?php echo BASE_URL; ?>financeiro/obra/<?php echo $obr[0]; ?> ">Financeiro</a></li>
		<li><a href="<?php echo BASE_URL; ?>comercial/edit/<?php echo $obr[0]; ?> ">Comercial</a></li>
	</ol>
</section>

<div class="col-md-12">

	<div class="nav-tabs-custom">

		<div class="tab-content">

			<div class="box box-default box-solid">

				<div class="row">

					<form id="obra" method="POST" enctype="multipart/form-data" action="<?php echo BASE_URL ?>obras/edit_action/<?php echo $obr[0]; ?>">
						<input type="hidden" class="form-control" name="id" id="id" autocomplete="off" value="<?php echo $obr[0]; ?>">

						<div class="col-md-12">
							<div class="box-header with-border">
								<h3 class="box-title">Dados</h3>
							</div>
							<div class="box-body" style="">
								<div class="col-md-3">
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

								<div class="col-md-3">
									<div class="form-group">
										<label>Tipo de Obra/Serviço</label>
										<input type="text" class="form-control" disabled name="servico_nome" id="servico_nome" value="<?php echo $obr['sev_nome']; ?>" autocomplete="off">
									</div>
								</div>

								<div class="col-md-2" style="margin-bottom:6px;">
									<label>Data de Criação</label>
									<input type="text" class="form-control" name="data_obra" id="data_obra" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask="" value="<?php echo $obr['data_obra']; ?>" autocomplete="off" required>
								</div>
							</div>

							<?php include_once('include/departamento.php'); ?>
							<?php include_once('include/endereco.php'); ?>
						</div>
					</form>

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
											} else if ($_GET['tipo'] == COMPRA) {
												echo ' de Compra';
											}
										}

										?> </h3>
									<div class="box-tools pull-right select_obras">

										<div class="form-group">
											<select class="form-control select2" style="width: 100%;" name="select-etapas" id="select-etapas">
												<option <?php echo (isset($_GET['tipo']) && $_GET['tipo'] == '') ?  'selected' : '' ?> value="">Todos</option>
												<option <?php echo (isset($_GET['tipo']) && $_GET['tipo'] == '2') ?  'selected' : '' ?> value="<?php echo CONCESSIONARIA; ?>">Concessionaria</option>
												<option <?php echo (isset($_GET['tipo']) && $_GET['tipo'] == '1') ?  'selected' : '' ?> value="<?php echo ADMINISTRATIVA; ?>">Administrativo</option>
												<option <?php echo (isset($_GET['tipo']) && $_GET['tipo'] == '3') ?  'selected' : '' ?> value="<?php echo OBRA; ?>">Obra</option>
												<option <?php echo (isset($_GET['tipo']) && $_GET['tipo'] == '4') ?  'selected' : '' ?> value="<?php echo COMPRA; ?>">Compra</option>
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
								<button type="button" class="btn btn-box-tool new_obra"><i class="fa fa-plus-circle"></i></button>
								<button type="button" class="btn btn-box-tool dropdown-toggle " data-toggle="dropdown" aria-expanded="true">
									<i class="fa fa-wrench"></i>
								</button>
								<ul class="dropdown-menu" role="menu">
									<li><a href="<?php echo BASE_URL; ?>obras/gerar/<?php echo $obr[0]; ?>">Gerar Winrar</a></li>
								</ul>
							</div>
						</div>
						<div class="box-body" style="">
							<div id="obra_ok">
								<?php if (count($documento_obra) > 0) : ?>
									<?php foreach ($documento_obra as $doc) : ?>
										<div class="col-md-12 col-xs-12">
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
							<div class="col-md-10 col-xs-12" style="display:none;" id="new_obra">
								<label>Adicionar novo Documento</label>
								<div class="input-group">
									<input class="form-control" name="documento_nome" placeholder="Nome do Documento">
									<div class="input-group-btn">
										<div class="btn btn-default btn-file">
											<i class="fa fa-paperclip"></i> PDF
											<input type="file" class="btn btn-success file_doc">
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="modal-footer">
			<div type="submit" id="formobra" class="btn btn-primary">Salvar</div>
			<a href="<?php echo BASE_URL; ?>obras" class="btn btn-danger">Voltar</a>
		</div>

	</div>
</div>
<script type="text/javascript">
	$('#select-etapas').on('change', function() {
		var tipo = $("#select-etapas option:selected").val();
		window.location.href = BASE_URL + 'obras/edit/<?php echo $obr[0]; ?>?tipo=' + tipo;
	});

	$(function() {

		$("#formobra").click(function() {
			$("#obra").submit();
		});

	});
</script>