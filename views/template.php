<?php
$title = ucfirst($viewData['titlePage']);
if (isset($viewData['tableDados']['obr_razao_social'])) {
  $title = $viewData['tableDados']['obr_razao_social'];
} else if (isset($viewData['tableInfo']['obr_razao_social'])) {
  $title = $viewData['tableInfo']['obr_razao_social'];
} else if (isset($viewData['obr']['obr_razao_social'])) {
  $title = $viewData['obr']['obr_razao_social'];
}

?>

<!DOCTYPE html>
<html>

<head>
  <!-- Global site tag (gtag.js) - Google Analytics -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=UA-93575432-1"></script>
  <script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
      dataLayer.push(arguments);
    }
    gtag('js', new Date());

    gtag('config', 'UA-93575432-1');
  </script>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo $title; ?></title>




  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

  <script src="<?php echo BASE_URL; ?>assets/css/AdminLTE-2.4.5/bower_components/jquery/dist/jquery.min.js"></script>
  <script src="<?php echo BASE_URL; ?>assets/js/script.js"></script>

  <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/template.css">

  <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/AdminLTE-2.4.5/bower_components/bootstrap-daterangepicker/daterangepicker.css">
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/AdminLTE-2.4.5/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/AdminLTE-2.4.5/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/AdminLTE-2.4.5/bower_components/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/AdminLTE-2.4.5/bower_components/Ionicons/css/ionicons.min.css">
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/AdminLTE-2.4.5/dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/AdminLTE-2.4.5/plugins/iCheck/all.css">
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/AdminLTE-2.4.5/dist/css/skins/_all-skins.min.css">
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/AdminLTE-2.4.5/bower_components/select2/dist/css/select2.min.css">
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/AdminLTE-2.4.5/plugins/datatables-bs4/css/dataTables.bootstrap4.css">
  <script src="<?php echo BASE_URL; ?>assets/css/AdminLTE-2.4.5/plugins/iCheck/icheck.min.js"></script>

  <script src='https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.4.0/dropzone.js' type='text/javascript'></script>

  <link href='https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.4.0/dropzone.css' type='text/css' rel='stylesheet'>



  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <link rel="shortcut icon" href="data:image/x-icon;," type="image/x-icon">
  <script src="https://unpkg.com/imask"></script>




</head>

<body class="fixed skin-blue layout-top-nav" style="background-color:#ededed">
  <div class="wrapper">

    <header class="main-header">
      <nav class="navbar navbar-static-top">
        <div class="container">
          <div class="navbar-header">
            <a href="<?php echo BASE_URL; ?>/home" class="navbar-brand"><b>Admin</b>CENA</a>
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
              <i class="fa fa-bars"></i>
            </button>
          </div>

          <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
            <ul class="nav navbar-nav">
              <?php if ($this->userInfo['user']->hasPermission('user_view')) : ?>
                <li class=""><a href="<?php echo BASE_URL; ?>usuario">Usuarios <span class="sr-only">(current)</span></a></li>
              <?php endif; ?>

              <?php if ($this->userInfo['user']->hasPermission('cliente_view')) : ?>
                <li class=""><a href="<?php echo BASE_URL; ?>clientes">Clientes <span class="sr-only">(current)</span></a></li>
              <?php endif; ?>

              <?php if ($this->userInfo['user']->hasPermission('servico_view')) : ?>
                <li class=""><a href="<?php echo BASE_URL; ?>servicos">Serviços <span class="sr-only">(current)</span></a></li>
              <?php endif; ?>


              <?php if ($this->userInfo['user']->hasPermission('concessionaria_view')) : ?>
                <li class=""><a href="<?php echo BASE_URL; ?>concessionarias">Concessionarias <span class="sr-only">(current)</span></a></li>
              <?php endif; ?>

              <?php if ($this->userInfo['user']->hasPermission('comercial_view')) : ?>
                <li class=""><a href="<?php echo BASE_URL; ?>comercial">Comercial <span class="sr-only">(current)</span></a></li>
              <?php endif; ?>

              <?php if ($this->userInfo['user']->hasPermission('obra_view')) : ?>
                <?php $location = isset($_COOKIE['obras']) ? $_COOKIE['obras'] : 'obras';  ?>

                <li class=""><a href="<?php echo BASE_URL; ?><?php echo $location; ?>">Obras <span class="sr-only">(current)</span></a></li>
              <?php endif; ?>

              <?php if ($this->userInfo['user']->hasPermission('documento_view')) : ?>
                <!--<li class="active"><a href="<?php echo BASE_URL; ?>documentos">Documentos <span class="sr-only">(current)</span></a></li>-->
              <?php endif; ?>

            </ul>

          </div>


          <?php if ($this->userInfo['user']->usr_info() != 'cliente') : ?>
            <div class="navbar-custom-menu">
              <ul class="nav navbar-nav">
                <li class="dropdown messages-menu">
                  <a href="<?php echo BASE_URL;?>notificacao" class="dropdown-toggle drop-notific">
                    <i class="fa fa-bell-o"></i>
                    <span class="label label-success notificacao-mensagem "></span>
                  </a>
                 
                </li>

                <li class="dropdown messages-menu">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                    <i class="fa fa-fw fa-dollar"></i>
                    <span class="label label-success"><?php echo $total_recebido != 0 ? $total_recebido : ''; ?></span>
                  </a>
                  <ul class="dropdown-menu">
                    <li class="header">Total Faturamento Receber: <?php echo $total_recebido != 0 ? $total_recebido : '0'; ?></li>
                    <li>
                      <ul class="menu">
                        <?php if (isset($recebido) && count($recebido) > 0) : ?>
                          <?php foreach ($recebido as $pdr) : ?>
                            <li>
                              <a href="<?php echo BASE_URL; ?>financeiro/obra/<?php echo $pdr['id_obra']; ?>">
                                <h4>
                                  <?php echo ($pdr['obr_razao_social']); ?>
                                  <!--<small><i class="fa fa-clock-o"></i> 5 mins</small>-->
                                </h4>
                                <p>R$ <?php echo controller::number_format($pdr['valor']); ?></p>

                              </a>
                            </li>
                          <?php endforeach; ?>
                        <?php endif; ?>
                      </ul>
                    </li>
                    <!--<li class="footer"><a href="#">See All Messages</a></li>-->
                  </ul>
                </li>
                <li class="dropdown user user-menu">
                  <a href="<?php echo BASE_URL; ?>/login/logout">
                    <span class="hidden-xs"> <?php echo ucfirst($this->userInfo['userName']['login']); ?></span>
                  </a>
                </li>

                <li>
                  <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                </li>

              </ul>
            </div>
          <?php else : ?>
            <div class="navbar-custom-menu">

              <ul class="nav navbar-nav">


                <li class="dropdown user user-menu">
                  <a href="<?php echo BASE_URL; ?>login/logout">

                    <span class="hidden-xs"> <?php echo ucfirst($this->userInfo['userName']['login']); ?></span>
                  </a>
                  <ul class="dropdown-menu">
                    <li class="user-header">

                      <p>
                        <?php echo $this->userInfo['userName']['login']; ?>
                      </p>
                    </li>
                    <!-- Menu Body -->
                    <li class="user-body">
                      <div class="row">
                        <div class="col-xs-4 text-center">
                          <a href="#">Followers</a>
                        </div>
                        <div class="col-xs-4 text-center">
                          <a href="#">Sales</a>
                        </div>
                        <div class="col-xs-4 text-center">
                          <a href="#">Friends</a>
                        </div>
                      </div>
                    </li>
                    <li class="user-footer">
                      <div class="pull-left">
                        <a href="#" class="btn btn-default btn-flat">Profile</a>
                      </div>
                      <div class="pull-right">
                        <a href="<?php echo BASE_URL; ?>login/logout" class="btn btn-default btn-flat">Sign out</a>
                      </div>
                    </li>
                  </ul>
                </li>

              </ul>
            </div>

            <h3 style="font-size: 18px;text-align: center;position: relative;left: -15px;top: -6px;color: #fff;"> Bem Vindo </h3>

          <?php endif; ?>
        </div>
      </nav>
    </header>
    <div class="content-wrapper">
      <div class="container<?php echo (($viewData['titlePage'] == 'financeiro' || isset($viewData['fluid'])) ? '-fluid' : '') ?>">
        <section class="content-header">
          <h1 style="text-align: center;">

            <?php echo ucfirst($viewData['titlePage']) ?>

          </h1>
        </section>

        <section class="content">


          <?php $this->loadViewInTemplate($viewName, $viewData); ?>
        </section>
      </div>
    </div>

    <footer class="main-footer">
      <div class="container">
        <div class="pull-right hidden-xs">
        </div>
        <strong></strong> All rights reserved.
      </div>
    </footer>
  </div>
  <?php if (!$this->user->cliente()) : ?>
    <div style="    position: fixed;z-index: 999999;right: 12px;bottom: 3px;">
      <div id="chat" class="" style=" width: 70px;    display: block;;">
        <div id="colapse" class="box box-info direct-chat direct-chat-info collapsed-box" style="margin-bottom: 31px;">
          <div class="box-header with-border">
            <h3 class="box-title chat-title"></h3>

            <div class="box-tools pull-right">
              <span data-toggle="tooltip" title="" class="badge bg-info titlemensagem" data-original-title=""></span>
              <button type="button" onclick="openChat(this)" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
              </button>
            </div>
          </div>
          <div class="box-body">
            <br>
            <div class="direct-chat-messages" style="overflow: auto; display: flex;flex-direction: column-reverse; height:250px;margin-bottom: 0px;">

              <div id="chatFor"></div>

            </div>
            <div class="box-footer">
              <form action="<?php echo BASE_URL; ?>ajax/newMensageChat" id="newMensageChat" method="post">
                <div class="input-group">
                  <input type="text" name="message" placeholder="nova mensagem" class="form-control">
                  <span class="input-group-btn">
                    <button type="submit" id="buttonChat" class="btn btn-info btn-flat">Enviar</button>
                  </span>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  <?php endif; ?>


  <aside class="control-sidebar control-sidebar-dark" id="notepad" style="background: #f1f1f1;">

    <div class="tab-content">

      <h3 style="color:#000">Bloco de notas</h3>
      <?php $notepad = $this->userInfo['user']->getNotepad($this->userInfo['user']->getId(), $this->userInfo['user']->getCompany()); ?>
      <?php if ($notepad) : ?>
        <textarea id="story" style="color:#000; padding: 18px 9px;resize: none;" name="story" rows="30" cols="93"><?php echo $notepad['notepad']; ?></textarea>
      <?php else : ?>
        <textarea id="story" style="color:#000; padding: 18px 9px;resize: none;" name="story" rows="30" cols="93"></textarea>
      <?php endif; ?>

      <div>
        <span id="saveding" style="color:#000; display: none;"> salvando...</span>
        <span id="saved" style="color:#000; display: none;"> salvo</span>

      </div>

  </aside>



  <aside class=" control-sidebar-dark control-sidebar-open" style="display:none;position: absolute;top: 0;right: 5px;width: 21%;margin-top: 100px;max-height: 531px;">
    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
      <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
    </ul>
    <div class="tab-content">
      <div class="tab-pane" id="control-sidebar">
        
      </div>
    </div>
  </aside>













  <?php if (isset($_SESSION['alert']) && !empty($_SESSION['alert'])) : ?>
    <script>
      $(function() {
        toastr.<?php echo $_SESSION['alert']['tipo']; ?>('<?php echo $_SESSION['alert']['mensagem'] ?>');
      });
    </script>
    <?php unset($_SESSION['alert']); ?>
  <?php endif; ?>

  <script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function() {
      setTimeout(function() {

        $("#control-side_meu").slideToggle("slow");
        $("#goaway").fadeOut().empty();
      }, 3000);

    }, false);


    function verificarNotificacao() {

      $.ajax({
        url: BASE_URL + 'ajax/verificarMensagem',
        type: 'POST',
        dataType: 'json',
        success: function(json) {
        
          if (json.quantidade > 0) {
            $('.notificacao-mensagem').html(json.quantidade);
            $(".notificacao-mensagem").addClass("fa-blink")
            


          } else {
            $('.notificacao-mensagem').html('0');
            $('.notificacao-mensagem-header').html('Você não tem nenhuma notificação');
            $('.notificacao-mensagem').removeClass('fa-blink');
          }

        }
      });

    }

    $(function() {

      //setInterval(verificarNotificacao, 50000);
      //verificarNotificacao();

      $('.drop-notific').on('click', function() {
        $('.notificacao-mensagem').removeClass('fa-blink');

      });

      $('.addNotif').on('click', function() {
        $.ajax({
          url: 'add.php'
        });
      });

    });
  </script>


  <link href="<?php echo BASE_URL; ?>node_modules/toastr/build/toastr.min.css" rel="stylesheet" type="text/css" />

  <script src="<?php echo BASE_URL; ?>node_modules/toastr/build/toastr.min.js"></script>
  <script src="<?php echo BASE_URL; ?>node_modules/sweetalert/dist/sweetalert.min.js"></script>
  <script src="<?php echo BASE_URL; ?>assets/css/AdminLTE-2.4.5/plugins/datatables/jquery.dataTables.js"></script>
  <script src="<?php echo BASE_URL; ?>assets/css/AdminLTE-2.4.5/plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>

  <script src="<?php echo BASE_URL; ?>assets/css/AdminLTE-2.4.5/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
  <script src="<?php echo BASE_URL; ?>assets/css/AdminLTE-2.4.5/plugins/input-mask/jquery.inputmask.js"></script>
  <script src="<?php echo BASE_URL; ?>assets/css/AdminLTE-2.4.5/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
  <script src="<?php echo BASE_URL; ?>assets/css/AdminLTE-2.4.5/plugins/input-mask/jquery.inputmask.extensions.js"></script>
  <script src="<?php echo BASE_URL; ?>assets/css/AdminLTE-2.4.5/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
  <script src="<?php echo BASE_URL; ?>assets/css/AdminLTE-2.4.5/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
  <script src="<?php echo BASE_URL; ?>assets/css/AdminLTE-2.4.5/bower_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>
  <script src="<?php echo BASE_URL; ?>assets/css/AdminLTE-2.4.5/plugins/timepicker/bootstrap-timepicker.min.js"></script>
  <script src="<?php echo BASE_URL; ?>assets/css/AdminLTE-2.4.5/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
  <script src="<?php echo BASE_URL; ?>assets/css/AdminLTE-2.4.5/bower_components/fastclick/lib/fastclick.js"></script>
  <script src="<?php echo BASE_URL; ?>assets/css/AdminLTE-2.4.5/dist/js/adminlte.min.js"></script>
  <script src="<?php echo BASE_URL; ?>assets/css/AdminLTE-2.4.5/dist/js/demo.js"></script>
  <script src="<?php echo BASE_URL; ?>assets/css/AdminLTE-2.4.5/bower_components/select2/dist/js/select2.full.min.js"></script>
  <script src="<?php echo BASE_URL; ?>assets/css/AdminLTE-2.4.5/bower_components/moment/min/moment.min.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/jquery.webui-popover/1.2.1/jquery.webui-popover.min.css">
  <script src="https://cdn.jsdelivr.net/jquery.webui-popover/1.2.1/jquery.webui-popover.min.js"></script>




  <script type="text/javascript">
    var BASE_URL = '<?php echo BASE_URL; ?>';
    var temporiza;
    $("#story").on("input", function() {

      $("#saveding").show();
      $("#saved").hide();

      clearTimeout(temporiza);

      var text = $("#story").val();

      temporiza = setTimeout(function() {
        $.ajax({
          url: BASE_URL + 'ajax/saveNotepad',
          type: 'POST',
          data: {
            text: text,

          },
          dataType: 'json',
          success: function(json) {
            $("#saveding").hide();
            $("#saved").show();
          }
        });

      }, 2500);
    });
  </script>

  <?php if (isset($_SESSION['form']['info'])) : ?>
    <script type="text/javascript">
      var title = '<?php echo  $_SESSION['form']['info']; ?>';
      var text = '<?php echo $_SESSION['form']['mensagem']; ?>';
      var icon = '<?php echo $_SESSION['form']['type']; ?>';
      var pageController = '<?php echo $viewData['pageController']; ?>';
      var id_obra = '<?php echo isset($_SESSION['form']['id_obra']) ? $_SESSION['form']['id_obra'] : ''; ?>';
      var buttons = true;

      var type = '<?php echo  $_SESSION['form']['buttom']; ?>'

      <?php if (isset($_SESSION['form']['buttons'])) : ?>
        var buttons = {
          cancel: 'Cancelar',
          criar: 'Criar',
        }
      <?php endif; ?>


      swal({
          title: title,
          text: text,
          icon: icon,
          buttons: buttons,
          dangerMode: true,

        })
        .then((willDelete) => {
          if (willDelete) {

            window.location.href = BASE_URL + 'obras/' + type + '/' + id_obra;
            <?php unset($_SESSION['form']); ?>

          } else {
            <?php unset($_SESSION['form']); ?>
            /*window.location.href = BASE_URL+pageController;*/
          }
        });
    </script>

  <?php endif; ?>

  <?php if (isset($_SESSION['form'])) : ?>
    <script type="text/javascript">
      var title = '<?php echo $_SESSION['form']['success']; ?>';
      var text = '<?php echo $_SESSION['form']['mensagem']; ?>';
      var icon = '<?php echo $_SESSION['form']['type']; ?>';
      var pageController = '<?php echo $viewData['pageController']; ?>';
      var id_obra = '<?php echo isset($_SESSION['form']['id_obra']) ? $_SESSION['form']['id_obra'] : ''; ?>';
      var buttons = true;


      <?php if (isset($_SESSION['form']['buttons'])) : ?>
        var buttons = {
          cancel: 'Cancelar',
          criar: 'Criar',
        }
      <?php endif; ?>


      swal({
          title: title,
          text: text,
          icon: icon,
          buttons: buttons,
          dangerMode: true,

        })
        .then((willDelete) => {
          if (willDelete) {
            window.location.href = BASE_URL + 'financeiro/add/' + id_obra;
            return;

          } else {
            <?php unset($_SESSION['form']); ?>
            /*window.location.href = BASE_URL+pageController;*/
          }
        });
    </script>

  <?php endif; ?>

  <script src="<?php echo BASE_URL; ?>assets/js/validateJquery/dist/jquery.validate.min.js"></script>

<script>
  <?php if($this->userInfo['notificacao']['quantidade'] != '0' ): ?>
      setInterval("verificarNotificacao()", 10000);
  <?php endif; ?>

</script>
  <script type="text/javascript">
    var save_method; //for save method string

    $(function() {

      setInterval("getMensageNaoLidas()", 10000)
      setInterval("getMensage()", 10000)
      
      



      $('#table').on('length.dt', function(e, settings, len) {
        localStorage.setItem('max_obras', len);
      });

      $('#table').on('page.dt', function() {
        var table = $('#table').DataTable();
        var info = table.page.info();
      });

      $(document).ready(getMensage());
      $(document).ready(getMensageNaoLidas());
      $(document).ready(verificarNotificacao());

      $(document).ready(function() {

        var filtro = <?php echo json_encode($_GET); ?>;

        var max_obras = localStorage.getItem('max_obras')
        max_obras = max_obras == null ? '10' : max_obras;

        var myTable = $('#table').DataTable({
          stateSave: true,
          stateSaveCallback: function(settings, data) {
            localStorage.setItem('DataTables_' + settings.sInstance, JSON.stringify(data))
          },
          stateLoadCallback: function(settings) {
            return JSON.parse(localStorage.getItem('DataTables_' + settings.sInstance))
          },
          createdRow: function(row, data, index) {
            if (data[7] == 1) {
              $(row).css('background', 'rgba(247, 161, 161, 0.78)');
            }
          },
          "processing": true,
          "serverSide": true,
          "autoWidth": false,
          "displayLength": max_obras,
          "language": {
            "sEmptyTable": "Nenhum registro encontrado",
            "sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registro(s)",
            "sInfoEmpty": "Mostrando 0 até 0 de 0 registros",
            "sInfoFiltered": "(Filtrados de _MAX_ registros)",
            "sInfoPostFix": "",
            "sInfoThousands": ".",
            "sLengthMenu": "_MENU_",
            "sLoadingRecords": "Carregando...",
            "sProcessing": "Processando...",
            "sZeroRecords": "Nenhum registro encontrado",
            "sSearch": "Pesquisa Rapida",
          },
          "oPaginate": {
            "sNext": "Próximo",
            "sPrevious": "Anterior",
            "sFirst": "Primeiro",
            "sLast": "Último"
          },
          "pages": 2,
          paginate: true,
          filter: true,
          "ajax": {
            "url": BASE_URL + "<?php echo $viewData['pageController']; ?>/getAll",
            "type": "GET",
            "data": {
              filtro,
            },
            error: function(jqXHR, textStatus, errorThrown) {
              window.location.href = BASE_URL + 'obras';
            },

          },
        });
      });
    });
  </script>



</body>

</html>