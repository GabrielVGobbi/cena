<?php

$data_hoje = date('Y-m-d h:i:s');

?>

<div class="col-xs-12">
	<div class="box box-primary">
		<div class="box-header with-border">
			<h3 class="box-title">Suas Notificações</h3>
			<div class="box-tools pull-right">
				<div class="has-feedback">

					<div class="btn-group" data-toggle="btn-toggle">
						<button type="button" class="btn btn-default btn-sm active" data-toggle="tooltip" title="" data-original-title="Todas"><i class="fa fa-square text-green"></i>
						</button>
						<button type="button" class="btn btn-default btn-sm" data-toggle="tooltip" title="" data-original-title="Não lidas"><i class="fa fa-square text-red"></i></button>
					</div>


				</div>
			</div>
		</div>


		<div class="box box-primary">

			<!-- /.box-header -->
			<div class="box-body" style="margin-top:20px;">
				<!-- See dist/js/pages/dashboard.js to activate the todoList plugin -->
				<ul class="todo-list">
					<?php if (count($tableDados) > 0) : ?>
						<?php foreach ($tableDados as $not) : ?>
							<?php $propriedades = json_decode($not['propriedades']); ?>
							<?php
									$data1 = new DateTime($data_hoje);
									$data2 = new DateTime($not['data_notificacao']);

									$tempo = controller::diferenca($not['data_notificacao']);

									?>

							<li>
								<a href="<?php echo $not['link']; ?>">
									<span class="">
										<i class="fa fa-ellipsis-v"></i>
										<i class="fa fa-ellipsis-v"></i>
									</span>
									<span class="text"><?php echo $propriedades->msg; ?></span>
									<span class="text">Por: <?php echo $not['login']; ?></span>

									<small class="label label-info"><i class="fa fa-clock-o"></i> <?php echo $tempo ?></small>
									<div class="tools">
										<i class="fa fa-edit"></i>
										<i class="fa fa-trash-o"></i>
									</div>
								</a>

							</li>
						<?php endforeach; ?>
					<?php else : ?>

						<tr>
							<td style="width: 50%;text-align: center;"> Não foram encontrados resultados </td>
						</tr>
					<?php endif; ?>
				</ul>
			</div>

		</div>

		<div class="box-footer no-padding">
			<div class="mailbox-controls">
				<ul class="pagination pagination-sm pull-right">
					<?php for ($q = 1; $q <= $p_count; $q++) : ?>
						<li class="<?php echo ($q == $p) ? 'active' : '' ?> ">
							<a href="<?php echo BASE_URL; ?>concessionarias?p=<?php $w = $_GET;
																					$w['p'] = $q;
																					echo http_build_query($w); ?>"><?php echo $q; ?></a>
						</li>
					<?php endfor; ?>
				</ul>
			</div>
		</div>
	</div>
</div>