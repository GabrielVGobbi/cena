<?php

$data_hoje = date('Y-m-d h:i:s');

?>
<div class="col-xs-7" style="display:none"> <h1> em teste </h1>
	<section class="content">

		<!-- row -->
		<div class="row">
			<div class="col-md-12">
				<!-- The time line -->
				<ul class="timeline">


					<!-- aqui -->

					<li class="time-label">
						<span class="bg-red">
							10 Fev. 2014
						</span>
					</li>
					<li>
						<i class="fa fa-file-pdf-o bg-blue"></i>
						<div class="timeline-item">
							<span class="time"><i class="fa fa-clock-o"></i> 12:05</span>
							<h3 class="timeline-header"><a href="#">Luana Varella</a> adicionou um novo documento </h3>
						</div>
					</li>

					<li>
						<i class="fa fa-file-pdf-o bg-blue"></i>
						<div class="timeline-item">
							<span class="time"><i class="fa fa-clock-o"></i> 12:05</span>
							<h3 class="timeline-header"><a href="#">Luana Varella</a> adicionou um novo documento </h3>
						</div>
					</li>

					<li>
						<i class="fa fa-file-pdf-o bg-blue"></i>
						<div class="timeline-item">
							<span class="time"><i class="fa fa-clock-o"></i> 12:05</span>
							<h3 class="timeline-header"><a href="#">Luana Varella</a> adicionou um novo documento </h3>
						</div>
					</li>

					<li>
						<i class="fa fa-file-pdf-o bg-blue"></i>
						<div class="timeline-item">
							<span class="time"><i class="fa fa-clock-o"></i> 12:05</span>
							<h3 class="timeline-header"><a href="#">Luana Varella</a> adicionou um novo documento </h3>
						</div>
					</li>


					<!-- aqui -->

				</ul>
			</div>
		</div>



	</section>
</div>



<div class="col-xs-5">
	<div class="box box-primary">
		<div class="box-header ui-sortable-handle" style="cursor: ;">
			<i class="ion ion-clipboard"></i>
			<h3 class="box-title">Lista</h3>
			<div class="box-tools pull-right">
				<!--<ul class="pagination pagination-sm inline">
					<li><a href="#">«</a></li>
					<li><a href="#">1</a></li>
					<li><a href="#">2</a></li>
					<li><a href="#">3</a></li>
					<li><a href="#">»</a></li>
				</ul>-->
			</div>
		</div>
		<div class="box-body">
			<ul class="todo-list ui-sortable" id="toDoDiv">
				
			</ul>
		</div>
		<div class="box-footer clearfix no-border">
		</div>
	</div>
</div>
<script>
	$(document).ready(getToDo(<?php echo $this->user->getId() ?>));
</script>























<!-- <div class="box box-primary">
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

			<div class="box-body" style="margin-top:20px;">
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
									<span class="text">Por: <?php echo $not['nome_usuario']; ?></span>

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
							<a href="<?php echo BASE_URL; ?>notificacao?p=<?php $w = $_GET;
																			$w['p'] = $q;
																			echo http_build_query($w); ?>"><?php echo $q; ?></a>
						</li>
					<?php endfor; ?>
				</ul>
			</div>
		</div>
	</div>-->