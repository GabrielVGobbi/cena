<div class="box box-default ">
	<div class="box-header with-border">
		<h3 class="box-title">Editar</h3>
	</div>

	<div class="box-body" style="">
		<form method="POST" id="cliete_edit" enctype="multipart/form-data" action="<?php echo BASE_URL ?>clientes/edit/<?php echo $tableInfo['id']; ?>">
			<div class="tab-content">
				<input type="hidden" class="form-control" name="id_cliente" id="id_cliente" autocomplete="off" value="<?php echo $tableInfo['id']; ?>">
				<input type="hidden" class="form-control" name="id_endereco" id="id_endereco" autocomplete="off" value="<?php echo (isset($tableInfo['clend_id']) ? $tableInfo['clend_id'] : ''); ?>">
				<input type="hidden" class="form-control" name="validate" id="validate" autocomplete="off" value="true">

				<div class="box box-default box-solid">
					<div class="row">
						<div class="col-md-12">
							<div class="box-header with-border">
								<h3 class="box-title">Dados</h3>
							</div>
							<div class="box-body" style="">
								<div class="col-md-4">
									<div id="formnome" class="form-group">
										<label>Razão Social</label>
										<div class="input-group">
											<div class="input-group-addon">
												<i class="fa fa-fw fa-user"></i>
											</div>
											<input type="text" data-name="<?php echo $tableInfo['cliente_nome']; ?>" class="form-control" name="cliente_nome" id="cliente_nome" value="<?php echo $tableInfo['cliente_nome']; ?>">
										</div>
									</div>
								</div>

								<div class="col-md-4">
									<div id="" class="form-group">
										<label>Nome Fantasia</label>
										<div class="input-group">
											<div class="input-group-addon">
												<i class="fa fa-fw fa-user"></i>
											</div>
											<input type="text" class="form-control" name="cliente_apelido" id="cliente_apelido" value="<?php echo $tableInfo['cliente_apelido']; ?>">
										</div>
									</div>
								</div>
								<div class="col-md-4">
									<div id="formcpnj" class="form-group">
										<label>CNPJ / CPF</label>
										<div class="input-group">
											<div class="input-group-addon">
												<i class="fa fa-fw fa-cc"></i>
											</div>
											<input id="cpfcnpj" type="text" class="form-control" name="cliente_cnpj" value="<?php echo $tableInfo['cliente_cnpj']; ?>">
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				<?php #include_once("include/endereco.php"); 
				?>
				<?php include_once("include/departamento.php"); ?>
				<?php if ($tableInfo['acesso_criado']) : ?>
					<?php $userCliente = $this->user->getUserCliente($tableInfo['id'], $tableInfo['id_company']); ?>
					<?php if ($userCliente) : ?>
						<input type="hidden" class="form-control" name="id_usuario" id="id_usuario" value="<?php echo $userCliente['id']; ?>">

						<div class="box box-default box-solid">
							<div class="row">
								<div class="col-md-12">
									<div class="box-header with-border">
										<h3 class="box-title">Dados Login</h3>
									</div>
									<div class="box-body" style="">
										<div class="col-md-4">
											<div id="formnome" class="form-group">
												<label>Login</label>
												<div class="input-group">
													<div class="input-group-addon">
														<i class="fa fa-fw fa-user"></i>
													</div>
													<input type="text" class="form-control" name="login" id="login" value="<?php echo $userCliente['login']; ?>">
												</div>
											</div>
										</div>

										<div class="col-md-4">
											<div id="" class="form-group">
												<label>Trocar Senha </label><span> * Só escreva algo, caso vá trocar a senha</span>
												<div class="input-group">
													<div class="input-group-addon">
														<i class="fa fa-fw fa-lock"></i>
													</div>
													<input type="password" class="form-control" name="token" id="user_senha" value="">
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					<?php endif; ?>

				<?php endif; ?>


				<div class="modal-footer">
					<div id="submit" class="btn btn-primary">Salvar</div>
					<a href="<?php echo BASE_URL; ?><?php echo $viewData['pageController']; ?>" class="btn btn-danger">Voltar</a>
				</div>
			</div>
		</form>
	</div>
</div>

<script src="<?php BASE_URL ?>/views/<?php echo $viewData['pageController']; ?>/parametros/<?php echo $viewData['pageController']; ?>.js"></script>