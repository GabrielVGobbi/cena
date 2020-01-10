<?php

$documento_obra = $this->documento->getDocumentoObra($obr[0]);
$_GET['tipo'] = isset($_COOKIE['select_etapas']) ? $_COOKIE['select_etapas'] : '0';
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
													<div class="col-md-3">
														<div class="form-group">
															<textarea type="text" class="form-control" name="obra_infor" id="obra_infor" style="margin: 0px -772px 0px 0px; width: 1004px; height: 138px;"> <?php echo $obr['obr_informacoes']; ?> </textarea>
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
									<li><a href="<?php echo BASE_URL; ?>obras/gerar/<?php echo $obr[0]; ?>">Gerar Winrar</a></li>
								</ul>
							</div>
						</div>
						<div class="box-body">

							<div id="new_obra" style="display:none">
								<form action="<?php echo BASE_URL; ?>ajax/getPreview/<?php echo $obr['0']; ?>/<?php echo $obr['id_cliente']; ?>" class="dropzone" id="dropzoneFrom"></form>


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
		</div>

	</div>
</div>

<script type="text/javascript">
	Dropzone.autoDiscover = false;
	var submitButton = document.querySelector('#submit-all');

	list_image();
	$(document).ready(function() {



		var myDropzone = new Dropzone(".dropzone", {
			autoProcessQueue: false,
			dictDefaultMessage: "Arraste seus arquivos para cá!",
			acceptedFiles: ".png,.jpg,.gif,.bmp,.jpeg,.pdf,.docx,.xls,.xlsx,.zip,.dwg",
			dictRemoveFile: "Remover",
			addRemoveLinks: true,
			parallelUploads: 100,
			url: BASE_URL + "ajax/getPreview/<?php echo $obr[0]; ?>/<?php echo $obr['id_cliente']; ?>",
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
			url: "<?php echo BASE_URL; ?>ajax/getPreview/<?php echo $obr[0]; ?>/<?php echo $obr['id_cliente']; ?>",
			success: function(data) {
				$('#preview').html(data);
			}
		});
	}
</script>