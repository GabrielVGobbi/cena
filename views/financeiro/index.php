<div class="col-xs-12">
	<div class="box box-primary">
		<div class="box-header with-border">
			<h3 class="box-title">Financeiro</h3>
			<div class="box-tools pull-right">
				<div class="has-feedback">
					<button class="btn btn-sm btn-info pop" onclick="openFiltro('<?php echo $viewData['pageController']; ?>')">
						<i class="glyphicon glyphicon-search"></i>
					</button>
					<a href="<?php echo BASE_URL; ?>financeiro" type="button" class="btn btn-default btn-sm"><i class="fa fa-refresh"></i></a>
					
				</div>
			</div>
		</div>

		<div class="box-body no-padding">
			<?php include_once("filtro.php"); ?>
			<div class="table-responsive mailbox-messages">
				<table class="table table-hover table-striped table-bordered">
					<?php if (count($tableDados) > 0) : ?>
						<tbody>
							<div class="box">
								<div class="box-body table-responsive no-padding">
									<table class="table table-hover">
										<tbody>
											<tr>
												<th>Nome da Obra</th>
												<th>Valor Negociado</th>
												<th>Valor a Receber</th>
												<th>Valor Recebido</th>
												<th>Liberado Faturar</th>
												<th>Saldo</th>
											</tr>
											<?php foreach ($tableDados as $inf) : ?>
			

												<tr onclick="javascript:location.href='<?php echo BASE_URL ?>financeiro/obra/<?php echo $inf['id_obra'] ?>'">
													
													<td><?php echo $inf['obr_razao_social'] ?></td>
													<td>R$ <?php echo $inf['valor_negociado'] != '' ? controller::number_format($inf['valor_negociado']) : '0,00' ?></td>
													<td>R$ <?php echo $inf['receber'] != '' ? controller::number_format($inf['receber']) : '0,00'?></td>
													<td>R$ <?php echo $inf['recebido'] != '' ? controller::number_format($inf['recebido']) : '0,00' ?></td>
													<td>R$ <?php echo $inf['faturar'] != '' ? controller::number_format($inf['faturar']) : '0,00' ?></td>
													<td>R$ <?php 
													$saldo = intval($inf['valor_negociado']) - intval($inf['faturado']); 
													echo $saldo != '' ? controller::number_format($saldo) : '0,00';
													?></td>

												</tr>
											<?php endforeach; ?>
												<tr style="background: aliceblue;">
													<td colspan="1">Total</td>
													<td> R$
													<?php echo $tableTotal['valor_negociado']; ?>

													</td>
													<td >R$ <?php echo $tableTotal['valor_receber']; ?></td>
													<td colspan="">R$ <?php echo $tableTotal['recebido']; ?></td>
													<td >R$ <?php echo $tableTotal['faturar']; ?></td>
													<td>R$ <?php 
													
													echo $tableTotal['saldo']; 
													
													?></td>

												</tr>
										</tbody>
									</table>
								</div>
							</div>
						</tbody>
					<?php else : ?>
					<?php endif; ?>
				</table>
			</div>
		</div>
		<div class="box-footer no-padding">
			<div class="mailbox-controls">
				<ul class="pagination pagination-sm pull-right">
					<?php for ($q = 1; $q <= $p_count; $q++) : 
					?>
					<li class="<?php echo ($q == $p) ? 'active' : '' 
								?> ">
						<a href="<?php  echo BASE_URL; 
									?>financeiro?p=<?php $w = $_GET;
																		$w['p'] = $q;
																		echo http_build_query($w); 
																		?>"><?php echo $q; 
																										?></a>
					</li>
					<?php endfor; 
					?>
				</ul>
			</div>
		</div>
	</div>
</div>