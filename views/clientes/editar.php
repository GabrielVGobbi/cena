<div class="col-md-12">
	<div class="nav-tabs-custom">
		
		<form method="POST">
			<div class="tab-content">
			<input type="hidden" class="form-control" name="id" id="id" autocomplete="off" value="<?php echo $tableInfo['id'];?>">
				<div class="tab-pane active" id="dados">
					<div class="box box-default box-solid">
						<div class="row">
							<div class="col-md-12">
								<div class="box-body" style="">
									<div class="col-md-6">
										<div class="form-group">
											<label>Nome</label>
											<input type="text" class="form-control" name="cliente_nome" id="cliente_nome" autocomplete="off" value="<?php echo $tableInfo['cliente_nome'];?>">
										</div>
									</div>

									<div class="col-md-2">
										<label>Email</label>
										<div class="input-group">
											<input type="text" class="form-control" name="cliente_email" id="cliente_email"  value="<?php echo $tableInfo['cliente_email'];?>">
										</div>
                                    </div>
                                    
                                    <div class="col-md-2">
										<label>Responsavel</label>
										<div class="input-group">
											<input type="text" class="form-control" name="cliente_responsavel" id="cliente_responsavel"  value="<?php echo $tableInfo['cliente_responsavel'];?>">
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				
				<div class="tab-pane" id="tab_3">

				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary">Salvar</button>
					<a href="<?php echo BASE_URL;?>clientes" class="btn btn-danger">Voltar</a>
				</div>

			</div>
		</form>


	</div>

</div>