<?php

$documento_obra = $this->documento->getDocumentoObra($obr['id_obra']);
$_GET['tipo'] = isset($_COOKIE['select_etapas']) ? $_COOKIE['select_etapas'] : '0';
?>
<section class="content-header">
	<ol class="breadcrumb" style="    top: -17px;">
		<li><a href="<?php echo BASE_URL; ?>financeiro/obra/<?php echo $obr['id_obra']; ?> ">Financeiro</a></li>
		<li><a href="<?php echo BASE_URL; ?>comercial/edit/<?php echo $obr['id_obra']; ?> ">Comercial</a></li>
	</ol>
</section>
<!-- <div class="col-md-2">
	<div class="box box-solid">
		<div class="box-header with-border">
			<h3 class="box-title">Folders</h3>

			<div class="box-tools">
				<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
				</button>
			</div>
		</div>
		<div class="box-body no-padding">
			<ul class="nav nav-pills nav-stacked">
				<li class="active"><a href="#"><i class="fa fa-inbox"></i> Inbox
						<span class="label label-primary pull-right">12</span></a></li>
				<li><a href="#"><i class="fa fa-envelope-o"></i> Sent</a></li>
				<li><a href="#"><i class="fa fa-file-text-o"></i> Drafts</a></li>
				<li><a href="#"><i class="fa fa-filter"></i> Junk <span class="label label-warning pull-right">65</span></a>
				</li>
				<li><a href="#"><i class="fa fa-trash-o"></i> Trash</a></li>
			</ul>
		</div>
		 /.box-body 
	</div>
</div>-->

<div class="col-md-12">
	<div class="nav-tabs-custom">
		<div class="tab-content">
			<div class="box box-default box-solid">
				<div class="row">
					<form id="obra" method="POST" enctype="multipart/form-data" action="<?php echo BASE_URL ?>obras/edit_action/<?php echo $obr['id_obra']; ?>">
						<input type="hidden" class="form-control" name="id" id="id" autocomplete="off" value="<?php echo $obr['id_obra']; ?>">

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

								<div class="col-md-12" style="margin-bottom:6px;">
									<label>Descrição da Obra</label>
									<input type="text" class="form-control" name="descricao" id="descricao" value="<?php echo $obr['descricao']; ?>" autocomplete="off" >
								</div>
							</div>

							<?php include_once('include/departamento.php');
							?>
							<?php include_once('include/endereco.php');
							?>

							<div class="col-md-12 col-sm-12">
								<div class="box box-default box-solid">
									<div class="row">
										<div class="col-md-12">
											<div class="box-header with-border text-center">
												<h3 class="box-title ">Informações Importantes</h3>

											</div>
											<div class="box-body" style="">
												<div class="row">
													<div class="col-md-12">
														<div class="form-group">
															<textarea type="text" style="width: 100%; height: 150px; resize: none;" class="form-control" name="obra_infor" id="obra_infor"> <?php echo $obr['obr_informacoes']; ?> </textarea>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</form>

					<div class="col-md-12">
						<div class="box-body">
							<div class="box box-primary">
								<div class="box-header ">
									<i class="ion ion-clipboard"></i>
									<h3 class="box-title title-tipo">
										Etapas
									</h3>
									<div class="box-tools pull-right select_obras">

										<div class="form-group">
											<select class="form-control select2" style="width: 100%;" name="select-etapas" id="select-etapas">
												<option <?php echo (isset($_GET['tipo']) && $_GET['tipo'] == '')  ?  'selected' : '' ?> value="">Todos</option>
												<option <?php echo (isset($_GET['tipo']) && $_GET['tipo'] == '2') ?  'selected' : '' ?> value="<?php echo CONCESSIONARIA; ?>">Concessionaria</option>
												<option <?php echo (isset($_GET['tipo']) && $_GET['tipo'] == '1') ?  'selected' : '' ?> value="<?php echo ADMINISTRATIVA; ?>">Administrativo</option>
												<option <?php echo (isset($_GET['tipo']) && $_GET['tipo'] == '3') ?  'selected' : '' ?> value="<?php echo OBRA; ?>">Obra</option>
												<option <?php echo (isset($_GET['tipo']) && $_GET['tipo'] == '4') ?  'selected' : '' ?> value="<?php echo COMPRA; ?>">Compra</option>
											</select>
										</div>
									</div>
								</div>
								<div class="box-body">
									<?php include_once('etapas/obraEtapaTipo.php') ?>
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
									<li><a href="<?php echo BASE_URL; ?>obras/gerar/<?php echo $obr['id_obra']; ?>">Gerar Winrar</a></li>
								</ul>
							</div>
						</div>
						<div class="box-body">

							<div id="new_obra" style="display:none">
								<form action="<?php echo BASE_URL ?>ajax/getPreview/<?php echo $obr['id_obra']; ?>/<?php echo $obr['id_cliente']; ?>" class="dropzone" id="dropzoneFrom"></form>


								<br>
								<div align="center">
									<button type="submit" class="btn btn-info" id="submit-all" style="display:none">Enviar</button>
								</div>
							</div>
							<div class="col-md-12 col-sm-12" id="obra_ok" style="display:">
								<ul class="mailbox-attachments clearfix" id="preview">
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="modal-footer">
			<div type="submit" id="formobra" class="btn btn-primary">Salvar</div>
			<a href="<?php echo BASE_URL; ?>obras" class="btn btn-danger">Voltar</a>

			<div class="pull-left">
				<label class="popver_urgencia" style="margin-right: 17px;">
					<input type="checkbox" id="checkUrgenciaObra" <?php echo isset($obr['urgencia']) && $obr['urgencia'] == '1' ? 'checked' : ''; ?> class="checkbox_desgn" name="timeline-photo" value="">
					<span>
						<span class="icon unchecked">
							<span class="mdi mdi-check"></span>
						</span>
						Marcar Urgencia
					</span>
				</label>

				<label class="popver_myList" style="margin-right: 17px;">
					<input type="checkbox" id="checkMyListObra"  class="checkbox_desgn" name="timeline-photo" value="">
					<span>
						<span class="icon unchecked">
							<span class="mdi mdi-check"></span>
						</span>
						Adicionar a minha lista
					</span>
				</label>

			</div>
		</div>


	</div>
</div>

<script type="text/javascript">
	Dropzone.autoDiscover = false;
	var submitButton = document.querySelector('#submit-all');

	$(document).ready(function() {

		$('.popver_urgencia').webuiPopover({
			content: 'Quando selecionada, essa obra passa a ter prioridades',
			trigger: 'hover',
			placement: 'top'
		});

		$('.popver_myList').webuiPopover({
			content: 'Quando selecionada, essa obra é adicionada a sua Lista de Obras',
			trigger: 'hover',
			placement: 'top'
		});

		list_image();
		getListObra();



		var myDropzone = new Dropzone(".dropzone", {
			url: BASE_URL + "ajax/getPreview/<?php echo $obr['id_obra']; ?>/<?php echo $obr['id_cliente']; ?>",
			autoProcessQueue: false,
			dictDefaultMessage: "Arraste seus arquivos para cá!",
			acceptedFiles: ".png,.jpg,.gif,.bmp,.jpeg,.pdf,.docx,.xls,.xlsx,.zip,.dwg",
			dictRemoveFile: "Remover",
			addRemoveLinks: true,
			parallelUploads: 100,
			init: function() {
				var submitButton = document.querySelector('#submit-all');
				this.on("addedfile", function(event) {

					submitButton.style.display = 'list-item';

				});
				myDropzone = this;
				submitButton.addEventListener("click", function() {
					myDropzone.processQueue();
				});
				this.on("queuecomplete", function() {
					if (this.getQueuedFiles().length == 0 && this.getUploadingFiles().length == 0) {

						var _this = this;
						_this.removeAllFiles();
					}
					list_image();
					submitButton.style.display = 'none';
					toastr.success('documento enviado com sucesso');
				});
			}
		});

		function toastAlertDelete(id_documento, id_obra) {
			href = BASE_URL + 'documentos/delete/' + id_documento + '/' + id_obra + '/' + id_documento

			toastr.options = {
				"closeButton": true,
				"debug": false,
				"newestOnTop": false,
				"progressBar": false,
				"positionClass": "toast-top-right",
				"preventDuplicates": true,
				"onclick": null,
				"showDuration": "300",
				"hideDuration": "1000",
				"timeOut": 0,
				"extendedTimeOut": 0,
				"showEasing": "swing",
				"hideEasing": "linear",
				"showMethod": "fadeIn",
				"hideMethod": "fadeOut",
				"tapToDismiss": true
			}
			toastr.warning("<br><a type='button' href='" + href + "' class='btn btn-danger btn-flat'>Sim</a>", "Deseja deletar esse documento")
		}




		//$(document).on('click', '.remove_doc', function() {
		//	var name = $(this).attr('id');
		//	$.ajax({
		//		url: BASE_URL + "ajax/getPreview",
		//		method: "POST",
		//		data: {
		//			name: name
		//		},
		//		success: function(data) {
		//			list_image();
		//		}
		//	})
		//});

	});

	function list_image() {
		$.ajax({
			url: "<?php echo BASE_URL; ?>ajax/getPreview/<?php echo $obr['id_obra']; ?>/<?php echo $obr['id_cliente']; ?>",
			success: function(data) {
				$('#preview').html(data);
			}
		});
	}

	$('#checkUrgenciaObra').click(function() {
		var checked = ($('#checkUrgenciaObra').is(':checked')) ? '1' : '0';
		var id_obra = <?php echo $obr['id_obra']; ?>;
		$.ajax({
			url: BASE_URL + "ajax/checkUrgenceObra",
			method: "POST",
			dataType: 'json',

			data: {
				checked: checked,
				id_obra: id_obra
			},
			success: function(data) {
				checked == 1 ? toastr.success('obra marcada como urgencia') : toastr.warning('obra desmarcada como urgencia');

			},
			error: function() {
				toastr.warning('Essa obra não esta em sua lista, primeiro adicione ela, depois marque urgencia');
				$("#checkUrgenciaObra").prop('checked', false);

			}
		})
	});

	$('#checkMyListObra').click(function() {
		var checked = ($('#checkMyListObra').is(':checked')) ? '1' : '0';
		var id_obra = <?php echo $obr['id_obra']; ?>;
		$.ajax({
			url: BASE_URL + "ajax/checkMyListObra",
			method: "POST",
			dataType: 'json',

			data: {
				checked: checked,
				id_obra: id_obra
			},
			success: function(data) {
				checked == 1 ? toastr.success('obra adicionada a sua lista') : toastr.warning('obra excluida da sua lista');

			},
			error: function() {
				toastr.error('Contate o administrador do sistema, Erro ADLISTO1');
				$("#checkMyListObra").prop('checked', false);


			}
		})
	});

	function getListObra() {
		var id_obra = <?php echo $obr['id_obra']; ?>;
		$.ajax({
			url: BASE_URL + "ajax/getListObra",
			method: "GET",
			dataType: 'json',
			data: {
				id_obra: id_obra
			},
			success: function(data) {
				
				data.urgencia == 1 ? $("#checkUrgenciaObra").prop('checked', true) : $("#checkUrgenciaObra").prop('checked', false);
				data.atv == 1 ? $("#checkMyListObra").prop('checked', true) : $("#checkMyListObra").prop('checked', false);
			},
			error: function() {

			}
		})
	};

	$(function() {

		$("#formobra").click(function() {
			$("#obra").submit();
		});

	});
</script>