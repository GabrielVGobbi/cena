<section class="content">
  <div class="row">

    <div class="col-md-3 col-sm-6 col-xs-12">
      <div class="info-box">
        <a href="<?php echo BASE_URL; ?>obras?filtros%5Bobra_nota_numero%5D=&filtros%5Bnome_obra%5D=&filtros%5Bcliente_nome%5D=&filtros%5Bsituacao%5D="> <span class="info-box-icon bg-aqua"><i class="fa fa-building-o"></i></span></a>

        <div class="info-box-content">
          <span class="info-box-text">Todas as Obras</span> </a>
          <span class="info-box-number"><?php echo $count_obras; ?></span>
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
    </div>

    <div class="col-md-3 col-sm-6 col-xs-12">
      <div class="info-box">
        <a href="<?php echo BASE_URL; ?>obras"> <span class="info-box-icon bg-green"><i class="fa fa-building-o"></i></span></a>

        <div class="info-box-content">
          <span class="info-box-text">Obras Ativas</span>
          <span class="info-box-number"><?php echo $count_obrasAtivas; ?></span>
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
    </div>
    <!-- /.col -->
    <div class="col-md-3 col-sm-6 col-xs-12">
      <div class="info-box">
        <a href="<?php echo BASE_URL; ?>clientes"> <span class="info-box-icon bg-red"><i class="ion ion-person-add"></i></span></a>

        <div class="info-box-content">
          <span class="info-box-text">Clientes</span>
          <span class="info-box-number"><?php echo $count_cliente; ?></span>
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
    </div>
    <!-- /.col -->




    <!-- /.col -->
    <div class="col-md-3 col-sm-6 col-xs-12">
      <div class="info-box">
        <a href="<?php echo BASE_URL; ?>servicos"> <span class="info-box-icon bg-yellow"><i class="ion ion-pie-graph"></i></span>

          <div class="info-box-content">
            <span class="info-box-text">Serviços</span>
        </a>
        <span class="info-box-number"><?php echo $count_servico; ?></span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <!-- /.col -->

  <div class="col-md-6 col-sm-12 col-xs-12">
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">Etapas Pendentes</h3>

        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
          </button>
        </div>

      </div>
      <div class="box-body">
        <ul class="products-list product-list-in-box">
          <?php foreach ($etapas_pendentes as $etpp) : ?>
            <li class="item">

              <div class="product-info">
                <a href="<?php echo BASE_URL ?>obras/edit/<?php echo $etpp['id_obra']; ?> " class="product-title"><?php echo $etpp['etp_nome_etapa_obra']; ?>
                  <div class="pull-right">
                    <?php controller::loadTempo($etpp['prazo_atendimento'], $etpp['data_abertura'], $etpp['check']); ?>
                  </div>
                </a>
                <span class="product-description">
                  Cliente: <?php echo $etpp['cliente_nome']; ?><br>
                  Obra: <?php echo $etpp['obr_razao_social']; ?>

                </span>
              </div>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>

    </div>
  </div>

  <?php if ($this->userInfo['user']->hasPermission('financeiro_view')) : ?>
    <div class="col-md-6 col-sm-12 col-xs-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Etapas Pendentes Financeiro</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
          </div>

        </div>
        <div class="box-body">
          <ul class="products-list product-list-in-box">
            <?php foreach ($etapas_pendentes_financeiro as $etpf) : ?>
              <li class="item">

                <div class="product-info">
                  <a href="<?php echo BASE_URL ?>financeiro/obra/<?php echo $etpf['id_obra']; ?>?hist=<?php echo $etpf['histf_id']; ?> " class="product-title"><?php echo $etpf['etp_nome']; ?>

                  </a>
                  <span class="product-description">
                    Obra: <?php echo $etpf['obr_razao_social']; ?><br>
                    Valor a Receber: <?php echo 'R$ ' . controller::number_format($etpf['valor_receber']); ?>
                  </span>
                </div>
              </li>
            <?php endforeach; ?>
          </ul>
        </div>

      </div>
      <div class="box-footer text-center">
        <div>Total: <?php echo 'R$ '.controller::number_format($total_etapas_financeiro); ?></div>
      </div>
    </div>
  <?php endif; ?>

  </div>
  </div>