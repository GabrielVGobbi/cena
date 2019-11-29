<section class="invoice">
	<!-- title row 
	<div class="row">
		<div class="col-xs-12">
			<h2 class="page-header">
				<i class="fa fa-fw fa-money"></i> 
				<small class="pull-right">Date: 02/10/2019</small>
			</h2>
		</div>
	</div>-->
	<!-- info row -->
	<div class="row invoice-info">
		<div class="col-md-12">
			<div class="box box-solid">
				<div class="box-header with-border">
					<i class="fa fa-fw fa-money"></i>

					<h3 class="box-title"><?php echo $tableInfo['obr_razao_social']; ?></h3>
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					<dl class="dl-horizontal">
						<dt>Descrição</dt>
						<dd><?php echo $tableInfo['descricao']; ?></dd>
						<dt>Endereço: </dt>
						<dd><?php echo $tableInfo['rua']; ?></dd>
						<dt>CNPJ</dt>
						<dd><?php #echo $tableInfo['cpnj']; ?></dd>
						<dt>Inscrição Estadual</dt>
						<dd>
							<?php echo $tableInfo['inscEstado']; ?>
						</dd>
					</dl>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-xs-12 table-responsive">
			<table class="table table-striped">
				<thead>
					<tr>
						<th>Etapa de Faturamento</th>
						<th>Valor</th>
						<th>Total</th>
						<th>Status</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($etapasFinanceiro as $etpF) : ?>

						<tr>
							<td><?php echo $etpF['etp_nome_etapa_obra']; ?></td>
							<td><?php echo $etpF['metodo'] == 'porcentagem' ? $etpF['metodo_valor'] . '%' : 'R$ ' . controller::number_format($etpF['metodo_valor']); ?></td>
							<td><?php echo 'R$ ' . controller::number_format($etpF['valor_receber']); ?></td>
							<td>
								<?php if ($etpF['id_status'] == PENDENTE) : ?>
									<span data-toggle="tooltip" title="" data-original-title="Etapa ainda não foi concluida" class="label label-warning">Pendente</span>
								<?php elseif ($etpF['id_status'] == FATURAR) : ?>
									<a data-toggle="modal" data-target="#modalHistorico<?php echo $etpF['histf_id']; ?>"><span data-toggle="tooltip" title="" data-original-title="clique para faturar" class="label label-primary">Faturar</span></a>

									<!--<a id="faturarEtapaObra" data-name="<?php #echo $etpF['histf_id']; 
																					?> " href="#"></a> -->
								<?php elseif ($etpF['id_status'] == FATURADO ) : ?>
									<span data-toggle="tooltip" title="" data-original-title="Etapa Faturada" class="label label-success">Faturado</span>
								<?php endif; ?>
								<?php include('historico.php'); ?>
							</td>

						</tr>

					<?php endforeach; ?>
				</tbody>
			</table>
			<h2 class="page-header"></h2>
		</div>
	</div>
	<div class="row">
		<!-- accepted payments column -->
		<div class="col-xs-6">
			<p class="lead">Observações do Sistema:</p>
			<p class="text-muted well well-sm no-shadow text-center" style="position: relative;top: -12px;height: 66px;">
				nada informado.
			</p>
		</div>
		<!-- /.col -->
		<div class="col-xs-6">
			<div class="table-responsive">
				<table class="table">
					<tbody>
						<tr>
							<th style="width:50%">Total a Receber: </th>
							<td>R$ <?php echo controller::number_format($tableInfo['valor_negociado']); ?></td>
						</tr>
						<tr>
							<th>A Faturar: </th>
							<td>R$ <?php echo $totalFaturar != '' ? controller::number_format($totalFaturar) : '0,00'; ?> </td>
						</tr>
						<tr>
							<th>Faturado: </th>
							<td>R$ <?php echo $totalFaturado != '' ? controller::number_format($totalFaturado) : '0,00'; ?></td>
						</tr>
						<tr>
							<th>Recebido: </th>
							<td></td>
						</tr>

					</tbody>
				</table>
			</div>
		</div>
	</div>

	<div class="row no-print">
		<div class="col-xs-12">
			<a href="invoice-print.html" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> Imprimir</a>
			<button type="button" class="btn btn-success pull-right"><i class="fa fa-fw fa-send"></i> Enviar
			</button>
			<button type="button" class="btn btn-primary pull-right" style="margin-right: 5px;">
				<i class="fa fa-download"></i> Gerar PDF
			</button>
		</div>
	</div>
</section>

<script>
	$(function() {


		$('#faturarEtapaObra').on('click', function() {

			var id_obra = <?php echo $tableInfo['id_obra']; ?>;
			var id_etapa = $('#faturarEtapaObra').attr('data-name');
			var id_historico = $('#faturarEtapaObra').attr('data-id');


			$.ajax({
				url: BASE_URL + 'ajax/faturarEtapa',
				type: 'POST',
				data: {
					id_etapa: id_etapa,
					id_obra: id_obra,
					id_historico: id_historico
				},
				dataType: 'JSON',
				success: function(json) {
					toastr.success('Etapa Faturada com sucesso');

					window.setTimeout(function() {
						window.location.reload()
					}, 1000);


				}
			});


		});

	});
</script>