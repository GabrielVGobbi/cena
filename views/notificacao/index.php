<?php if ($this->user->getId() == /*63*/46  ) : ?>
<aside class="skeleton-aside">
	<div class="asidenav">
		<div class="asidenav-group">
			<div class="asidenav-title"><b> Admin </b></div>
			<div id="myDiv">
				<ul>
					<li class="navConfig active" data-id="toDo"><a href="#">Tarefas</a></li>
					<li class="navConfig" data-id="obrNotVist"><a href="#">Obras não visualizadas</a></li>
					<li class="navConfig" data-id="log"><a href="#">Log</a></li>

				</ul>
			</div>
		</div>
	</div>
</aside>
<?php endif; ?>
<section class="skeleton-content hide-on-medium-and-down tela" id="toDo" style="display:">
	<div class="col-xs-12 col-md-12">
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
</section>

<section class="skeleton-content hide-on-medium-and-down tela" id="obrNotVist" style="display:none">
	
<div class="col-xs-12 col-md-12">
	<div class="box box-primary">
		<div class="box-header ui-sortable-handle" style="cursor: ;">
			<i class="ion ion-clipboard"></i>
			<h3 class="box-title">Obras não visualizadas</h3>
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
			<?php foreach ($obrasNotVist as $obrV) : ?>
				<?php if (isset($obrV['notificacao']) && count($obrV['notificacao']) != 0) : ?>
					<blockquote>
						<p><?php echo ucfirst($obrV['login']); ?></p>

						<?php foreach ($obrV['notificacao'] as $userNotify) : ?>
							<?php
							$obra = json_decode($userNotify['tar_dataJson']);
							$id_obra = $obra->id_obra;
							$arrayObra = $this->obra->getObraById($id_obra);
							if (isset($arrayObra) && count($arrayObra) > 0) :
							?>
								<h6>Obra não vista: <cite title="Source Title"><?php echo $arrayObra['obr_razao_social']; ?></cite></h6>
							<?php endif; ?>
						<?php endforeach; ?>

					</blockquote>
				<?php endif; ?>
			<?php endforeach; ?>
		</div>


		<div class="box-footer clearfix no-border">
		</div>
	</div>
</div>
</section>



<script>
	$(document).ready(getToDo(<?php echo $this->user->getId() ?>));
	$(window).on('load', function() {
		$('.navConfig').click(function() {
			$('.navConfig').removeClass('active');
			$('.tela').hide();
			$(this).addClass('active');
			var id = $(this).attr('data-id');
			$('#' + id).show('slow');
		});
	});
</script>