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
						<dd>Descrição da obra</dd>
						<dt>Endereço: </dt>
						<dd>Endereço obra.</dd>
						<dt>CNPJ</dt>
						<dd>CNPJ.</dd>
						<dt>Inscrição Estadual</dt>
						<dd>
							dados.
						</dd>
					</dl>
				</div>
			</div>
		</div>
	</div>

	<!-- Table row -->
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
					<?php $etapasFinanceiro = $this->financeiro->getEtapasFinanceiro($tableInfo['id_obra']); ?>
					<?php foreach ($etapasFinanceiro as $etpF) : ?>
						<tr>
							<td><?php echo $etpF['etp_nome_etapa_obra']; ?></td>
							<td><?php echo $etpF['metodo'] == 'porcentagem' ? $etpF['metodo_valor'] . '%' : 'R$ ' . controller::number_format($etpF['metodo_valor']); ?></td>
							<td><?php echo 'R$ ' . controller::number_format($etpF['valor_receber']); ?></td>
							<td>
								<?php if ($etpF['id_status'] == PENDENTE) : ?>
									<span data-toggle="tooltip" title="" data-original-title="Etapa ainda não foi concluida" class="label label-warning">Pendente</span>
								<?php elseif ($etpF['id_status'] == FATURAR) : ?>
									<span data-toggle="tooltip" title="" data-original-title="clique para faturar" class="label label-primary">Faturar</span>
								<?php elseif ($etpF['id_status'] == FATURARADO) : ?>
									<span data-toggle="tooltip" title="" data-original-title="Etapa Faturada" class="label label-success">Faturado</span>
								<?php endif; ?>
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
							<th style="width:50%">Faturamento:</th>
							<td>R$ <?php echo controller::number_format($tableInfo['valor_negociado']); ?></td>
						</tr>
						<tr>
							<th>A Faturar:</th>
							<td></td>
						</tr>
						<tr>
							<th>Total a receber:</th>
							<td></td>
						</tr>

					</tbody>
				</table>
			</div>
		</div>
		<!-- /.col -->
	</div>
	<!-- /.row -->

	<!-- this row will not appear when printing -->
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