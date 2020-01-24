<div class="col-md-12">
	<div class="nav-tabs-custom">
		<ul class="nav nav-tabs">
			<li class="active"><a href="#dados" data-toggle="tab">Dados</a></li>
			<li><a href="#permission" data-toggle="tab">Permissões</a></li>



			<div class="btn-group pull-right">
				<button type="button" class="btn btn-box-tool dropdown-toggle " data-toggle="dropdown" aria-expanded="true">
					<i class="fa fa-wrench"></i>
				</button>
				<ul class="dropdown-menu" role="menu">
					<li><a id="marcarTodos">Marcar todos</a></li>
					<li><a id="desmarcarTodos">Desmarcar Todos</a></li>

				</ul>
			</div>
		</ul>
		<form method="POST">
			<div class="tab-content">
				<input type="hidden" class="form-control" name="id_usuario" id="id_usuario" autocomplete="off" value="<?php echo $tableInfo['id']; ?>">
				<input type="hidden" class="form-control" name="token" id="token" autocomplete="off" value="<?php echo $tableInfo['password']; ?>">

				<div class="tab-pane active" id="dados">
					<div class="box box-default box-solid">
						<div class="row">
							<div class="col-md-12">
								<div class="box-body" style="">
									<div class="col-md-6">
										<div class="form-group">
											<label>Usuario</label>
											<input type="text" class="form-control" name="login" id="login" autocomplete="off" value="<?php echo $tableInfo['login']; ?>">
										</div>
									</div>

									<div class="col-md-4">
										<label>Email</label>
										<div class="input-group">
											<input type="text" class="form-control" name="email" id="email" value="<?php echo $tableInfo['email']; ?>">
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="tab-pane" id="permission">
					<div class="box box-default box-solid">
						<div class="row">
							<div class="col-md-6">
								<div class="box-body" style="">

									<?php foreach ($permission as $p) : ?>
										<div class="col-md-5">
											<div class="form-group">
												<label>
													<input type="checkbox" value="<?php echo $p['id'] ?>" name="permission_check[]" class="check" <?php echo ($this->user->hasPermissionByidSearch($p['name'], $tableInfo['id'], $tableInfo['id_company']) ? "checked" : ""); ?>>
													<span> <?php echo $p['name'] ?> </span>
												</label>
											</div>
										</div>
									<?php endforeach; ?>

								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="tab-pane" id="tab_3">

				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary">Salvar</button>
					<a href="<?php echo BASE_URL; ?>usuario" class="btn btn-danger">Cancelar</a>
				</div>

			</div>
		</form>


	</div>

</div>

<script>
	$('#marcarTodos').on('click', function(event) {
		$('.check').each(function() {
			$(this).iCheck('check');
		});
		
	});

	//Desmarcar todos os checkbox 
	$('#desmarcarTodos').on('click', function(event) {
		$('.check').each(function() {
			$(this).iCheck('uncheck');
		});
	});
</script>