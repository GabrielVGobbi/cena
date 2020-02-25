<div class="col-xs-12">
	<div class="box box-primary">
		<div class="box-header with-border">
			<h3 class="box-title">Faturamento</h3>
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
					<?php if (isset($tableDados) && count($tableDados) > 0) : ?>
						<tbody>
							<div class="box">
								<div class="box-body table-responsive no-padding">
									<table class="table table-hover">
										<tbody>
											<tr>
												<th>Nome da Obra</th>
												<th>Coluna Faturada</th>
												<th>Numero de Nota</th>
												<th>Data emitida</th>
												<th>Data de Vencimento</th>
                                                <th>Valor</th>
												<th>Recebido</th>
											</tr>
											<?php foreach ($tableDados as $inf) : ?>
												<tr>
													<td><?php echo $inf['obr_razao_social'] ?></td>
                                                    <td><?php echo $inf['coluna_faturamento']; ?></td>
													<td><?php echo $inf['nf_n']; ?></td>
													<td><?php echo $inf['data_emissao']; ?></td>
													<td><?php echo $inf['data_vencimento']; ?></td>
                                                    <td>R$ <?php echo controller::number_format($inf['valor']); ?></td>
                                                    <td onclick="javascript:location.href='<?php echo BASE_URL ?>financeiro/obra/<?php echo $inf['id_obra'].'?hist='.$inf['histf_id'].'&histNota='.$inf['nf_n'] ?> '">             <?php echo $inf['recebido_status'] == 1 ? '<span data-toggle="tooltip" title="" data-original-title="Recebido" class="label label-success">Recebido</span>' : '<span data-toggle="tooltip" title="" data-original-title="não recebido" class="label label-warning">Não Recebido</span>'; ?></td>
												</tr>
											<?php endforeach; ?>
											
										</tbody>
									</table>
								</div>
							</div>
                        </tbody>
                    <?php else: ?>
                    <tr>
                        <td class="text-center"> não foram encontrados resultados </td>
                    </tr>
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
							<a href="<?php echo BASE_URL;
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