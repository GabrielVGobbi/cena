<div class="col-md-12">
	<div class="nav-tabs-custom">
		<form method="POST" enctype="multipart/form-data" action="">
			<div class="tab-content">
				<div class="tab-pane active" id="dados">
					<div class="box box-default box-solid">
						<div class="row">
							<div class="col-md-12">
								<div class="box-header with-border">
									<h3 class="box-title">Dados</h3>
								</div>
								<div class="box-body">
									<div class="box-body">
										<input type="hidden" class="form-control" name="id_veiculo" id="id_veiculo" autocomplete="off" value="<?php echo $tableInfo['id_veiculo']; ?>">
										<div class="col-md-3">
											<div class="form-group">
												<label>Nome do Veiculo</label>
												<input type="text" class="form-control" name="nome_veiculo" id="nome_veiculo" autocomplete="off" value="<?php echo $tableInfo['nome_veiculo']; ?>">
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-group">
												<label>Placa</label>
												<input type="text" class="form-control" name="placa_veiculo" id="placa_veiculo" autocomplete="off" value="<?php echo $tableInfo['placa_veiculo']; ?>">
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label>Observações</label>
												<input type="text" class="form-control" name="observacoes_veiculo" id="observacoes_veiculo" autocomplete="off" value="<?php echo $tableInfo['observacoes_veiculo']; ?>">
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
				<button type="submit" class="btn btn-primary">Salvar</button>
				<a href="<?php echo BASE_URL; ?>veiculos" class="btn btn-danger">Voltar</a>
			</div>
		</form>
	</div>
</div>

</div>