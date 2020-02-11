<?php include_once("cadastrar.php"); ?>
<?php
$checkUrgencia = isset($_COOKIE['urgencia_lista']) && $_COOKIE['urgencia_lista'] == 'checked' ? 'checked' : 'noCheck';
$checkLista = isset($_COOKIE['minha_lista']) && $_COOKIE['minha_lista'] == 'checked' ? 'checked' : 'noCheck';
$myList = isset($_COOKIE['myListOnly']) && $_COOKIE['myListOnly'] == 'checked' ? 'checked' : 'noCheck';

?>

<div class="col-md-12">
	<div class="box box-primary">
		<div class="box-header with-border">
			<h3 class="box-title"><?php echo ucfirst($viewData['pageController']); ?></h3>
			<div class="box-tools pull-right">

				<div class="has-feedback">

					<button class="btn btn-sm btn-info pop" data-toggle="tooltip" title="" data-original-title="Filtro Avançado" onclick="openFiltro('<?php echo $viewData['pageController']; ?>')">
						<i class="glyphicon glyphicon-search"></i>
					</button>
					<a href="<?php echo BASE_URL; ?>obras" type="button" class="btn btn-default btn-sm"><i class="fa fa-refresh"></i></a>

					<?php if ($this->user->hasPermission('cliente_view') && $this->user->hasPermission('cliente_add')) : ?>
						<button class="btn btn-default btn-sm" data-toggle="modal" data-target="#modalCadastro">
							<i class="fa fa-fw fa-plus-circle"></i> Novo
						</button>
					<?php endif; ?>
					<button type="button" id="quadr" data-toggle="tooltip" title="" data-original-title="Mudar Visualização Blocos" class="btn btn-default btn-sm"><i class="fa fa-building-o"></i></button>


				</div>
			</div>
		</div>
		<?php include_once("filtro.php"); ?>
		<div class="box-body">
			<div class="table-responsive mailbox-messages">
				<table class="table table-hover table-striped table-bordered">
					<tbody>
						<div class="box">
							<div class="box-body table-responsive no-padding">
								<table id="table" class="table table-hover table-bordered dataTable" style="width:100%">
									<tbody>
										<tr>

											<label class="popver_urgencia" style="margin-right: 17px;">
												<input type="checkbox" id="checkUrgencia" class="checkbox_desgn" <?php echo $checkUrgencia; ?> name="timeline-photo" value="">
												<span>
													<span class="icon unchecked">
														<span class="mdi mdi-check"></span>
													</span>
													Com Urgencia
												</span>
											</label>

											<!--<label class="popver_myListOnly">
												<input type="checkbox" id="checkListOnly" class="checkbox_desgn" <?php echo $myList; ?> name="timeline-photo" value="">
												<span>
													<span class="icon unchecked">
														<span class="mdi mdi-check"></span>
													</span>
													Mostrar apenas minha lista
												</span>
											</label>-->
											<label class="popver_lista" style="margin-right: 17px;">
												<input type="checkbox" class="checkbox_desgn" name="timeline-photo" <?php echo $checkLista; ?> value="">
												<span>
													<span class="icon unchecked">
														<span class="mdi mdi-check"></span>
													</span>
													Minha Lista
												</span>
											</label>
										</tr>
									</tbody>
									<div class="col-md-12">
										<thead>
											<tr role="row">
												<th style="width: 16%;"> Ação </th>
												<th> Razão Social </th>
												<th> Cliente </th>
												<th> Serviço </th>
												<th> Concessionaria </th>
												<th> Nota </th>
												<th> Etapas </th>
											</tr>
										</thead>
									</div>
								</table>
							</div>
						</div>
					</tbody>
				</table>
			</div>
		</div>


		<!-- <div class="col-md-3">
		<div class="box box-primary">
			<div class="box-header ui-sortable-handle" style="cursor: move;">
				<i class="ion ion-clipboard"></i>

				<h3 class="box-title">To Do List</h3>

				<div class="box-tools pull-right">
					<ul class="pagination pagination-sm inline">
						<li><a href="#">«</a></li>
						<li><a href="#">1</a></li>
						<li><a href="#">2</a></li>
						<li><a href="#">3</a></li>
						<li><a href="#">»</a></li>
					</ul>
				</div>
			</div>
			<div class="box-body">
				<ul class="todo-list ui-sortable">
					<li>
						<span class="handle ui-sortable-handle">
							<i class="fa fa-ellipsis-v"></i>
							<i class="fa fa-ellipsis-v"></i>
						</span>
						<input type="checkbox" value="">
						<span class="text">Design a nice theme</span>
						<small class="label label-danger"><i class="fa fa-clock-o"></i> 2 mins</small>
						<div class="tools">
							<i class="fa fa-edit"></i>
							<i class="fa fa-trash-o"></i>
						</div>
					</li>
					<li>
						<span class="handle ui-sortable-handle">
							<i class="fa fa-ellipsis-v"></i>
							<i class="fa fa-ellipsis-v"></i>
						</span>
						<input type="checkbox" value="">
						<span class="text">Make the theme responsive</span>
						<small class="label label-info"><i class="fa fa-clock-o"></i> 4 hours</small>
						<div class="tools">
							<i class="fa fa-edit"></i>
							<i class="fa fa-trash-o"></i>
						</div>
					</li>
					<li>
						<span class="handle ui-sortable-handle">
							<i class="fa fa-ellipsis-v"></i>
							<i class="fa fa-ellipsis-v"></i>
						</span>
						<input type="checkbox" value="">
						<span class="text">Let theme shine like a star</span>
						<small class="label label-warning"><i class="fa fa-clock-o"></i> 1 day</small>
						<div class="tools">
							<i class="fa fa-edit"></i>
							<i class="fa fa-trash-o"></i>
						</div>
					</li>
					<li>
						<span class="handle ui-sortable-handle">
							<i class="fa fa-ellipsis-v"></i>
							<i class="fa fa-ellipsis-v"></i>
						</span>
						<input type="checkbox" value="">
						<span class="text">Let theme shine like a star</span>
						<small class="label label-success"><i class="fa fa-clock-o"></i> 3 days</small>
						<div class="tools">
							<i class="fa fa-edit"></i>
							<i class="fa fa-trash-o"></i>
						</div>
					</li>
					<li>
						<span class="handle ui-sortable-handle">
							<i class="fa fa-ellipsis-v"></i>
							<i class="fa fa-ellipsis-v"></i>
						</span>
						<input type="checkbox" value="">
						<span class="text">Check your messages and notifications</span>
						<small class="label label-primary"><i class="fa fa-clock-o"></i> 1 week</small>
						<div class="tools">
							<i class="fa fa-edit"></i>
							<i class="fa fa-trash-o"></i>
						</div>
					</li>
					<li>
						<span class="handle ui-sortable-handle">
							<i class="fa fa-ellipsis-v"></i>
							<i class="fa fa-ellipsis-v"></i>
						</span>
						<input type="checkbox" value="">
						<span class="text">Let theme shine like a star</span>
						<small class="label label-default"><i class="fa fa-clock-o"></i> 1 month</small>
						<div class="tools">
							<i class="fa fa-edit"></i>
							<i class="fa fa-trash-o"></i>
						</div>
					</li>
				</ul>
			</div>
			<div class="box-footer clearfix no-border">
				<button type="button" class="btn btn-default pull-right"><i class="fa fa-plus"></i> Add item</button>
			</div>
		</div>
	</div>-->


		<script>
			$(function() {
				$('.popver_lista').webuiPopover({
					content: 'Apenas as obras que estão em sua lista vão ser listadas ',
					trigger: 'hover',
					placement: 'bottom'
				});
				$('.popver_urgencia').webuiPopover({
					content: 'Todas as obras que você marcou em Urgencia<br> vão aparecer em primeiro',
					trigger: 'hover',
					placement: 'bottom'
				});
				$('.popver_myListOnly').webuiPopover({
					content: 'Mostrar somente as obras que estão em sua lista',
					trigger: 'hover',
					placement: 'bottom'
				});

				$('.popver_lista').click(function() {
					var checkLista = '<?php echo $checkLista; ?>';

					if (checkLista == 'noCheck') {
						setCookie('minha_lista', 'checked', 1000)

					} else {
						setCookie('minha_lista', 'noCheck', 1000)
					}

					window.location.href = BASE_URL + 'obras';

				})

				$('.popver_urgencia').click(function() {

					var checkUrgencia = '<?php echo $checkUrgencia; ?>';

					if (checkUrgencia == 'noCheck') {
						setCookie('urgencia_lista', 'checked', 1000)

					} else {
						setCookie('urgencia_lista', 'noCheck', 1000)
					}

					window.location.href = BASE_URL + 'obras';

				})

				$('#quadr').on('click', function() {
					setCookie('obras', 'obras/lista', 25);
					window.location.href = BASE_URL + 'obras/lista';
				});
			});
		</script>