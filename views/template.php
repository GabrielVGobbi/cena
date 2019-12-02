<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Admin</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

  <script src="<?php echo BASE_URL; ?>assets/css/AdminLTE-2.4.5/bower_components/jquery/dist/jquery.min.js"></script>
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


  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <link rel="shortcut icon" href="data:image/x-icon;," type="image/x-icon">
  <script src="https://unpkg.com/imask"></script>
  <script src="<?php echo BASE_URL; ?>assets/js/script.js"></script>

  
  

</head>

<body class="fixed skin-blue layout-top-nav" style="background-color:##ededed">
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
                <?php  $location = isset($_COOKIE['obras']) ? $_COOKIE['obras'] : 'obras';  ?>

                <li class=""><a href="<?php echo BASE_URL; ?><?php echo $location;?>">Obras <span class="sr-only">(current)</span></a></li>
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
                  <a href="#" class="dropdown-toggle drop-notific" data-toggle="dropdown" aria-expanded="false">
                    <i class="fa fa-bell-o"></i>
                    <span class="label label-success notificacao-mensagem "></span>
                  </a>
                  <ul class="dropdown-menu" style="width:310px;">
                    <li class="header notificacao-mensagem-header"></li>
                    <li>
                      <ul class="menu">
                        <?php
                          foreach ($this->userInfo['notificacao'] as $not) :
                            $propriedades = json_decode($not['propriedades']);
                            $tempo = controller::diferenca($not['data_notificacao']);

                            ?>
                          <li>
                            <a onclick="lerMensagem(<?php echo $not['id_not_user']; ?>,'<?php echo $not['link']; ?>')" style="cursor: pointer">
                              <h4>
                                <?php echo $not['notificacao_tipo']; ?>
                                <small><i class="fa fa-clock-o"></i> <?php echo $tempo; ?></small>
                              </h4>
                              <p><?php echo '"' . $propriedades->msg . '"'; ?></p>
                              <p> <?php echo 'Por ' . $not['nome_usuario']; ?></p>
                            </a>
                          </li>
                        <?php endforeach; ?>
                      </ul>
                    </li>
                    <li class="footer"><a href="<?php echo BASE_URL; ?>notificacao">Ver todas</a></li>
                  </ul>
                </li>

                <li class="dropdown tasks-menu">


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
          <b>Version</b> 0.0.1
        </div>
        <strong></strong> All rights reserved.
      </div>
    </footer>
  </div>

  <aside class="control-sidebar control-sidebar-dark" id="notepad" style="background: #f1f1f1;">

    <div class="tab-content">

      <h3 style="color:#000">Bloco de notas</h3>
      <?php $notepad = $this->userInfo['user']->getNotepad($this->userInfo['user']->getId(), $this->userInfo['user']->getCompany()); ?>
      <?php if($notepad): ?>
        <textarea id="story" style="color:#000; padding: 18px 9px;resize: none;" name="story" rows="30" cols="93"><?php echo $notepad['notepad']; ?></textarea>
      <?php else: ?>
        <textarea id="story" style="color:#000; padding: 18px 9px;resize: none;" name="story" rows="30" cols="93"></textarea>
      <?php endif;?>

      <div>
        <span id="saveding" style="color:#000; display: none;"> salvando...</span>
        <span id="saved" style="color:#000; display: none;"> salvo</span>

      </div>

  </aside>

  <?php if (isset($_SESSION['alert']) && !empty($_SESSION['alert'])) : ?>
    <script>
        $(function() {  
            toastr.<?php echo $_SESSION['alert']['tipo'];?>('<?php echo $_SESSION['alert']['mensagem'] ?>');
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


          if (json['qtn'] > 0) {
            $('.notificacao-mensagem').html(json['qtn']);
            $('.notificacao-mensagem-header').html('Você tem ' + json['qtn'] + ' Notificações Pendente<a href="<?php echo BASE_URL; ?>notificacao/lertudo">ler tudo</a>');


          } else {
            $('.notificacao-mensagem').html('0');
            $('.notificacao-mensagem-header').html('Você não tem nenhuma notificação');
            $('.notificacao-mensagem').removeClass('fa-blink');
          }

        }
      });

    }

    $(function() {
      //setInterval(verificarNotificacao, 2000);
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

<?php if (isset($_SESSION['form']['delete'])) : ?>
    <script type="text/javascript">
      var title = '<?php echo $_SESSION['form']['delete']; ?>';
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
            
            window.location.href = BASE_URL+'obras/delete/'+id_obra;
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
            swal("Ainda não disponivel!");
            //window.location.href = BASE_URL+'financeiro/add/'+id_obra;

          } else {
            <?php unset($_SESSION['form']); ?>
            /*window.location.href = BASE_URL+pageController;*/
          }
        });
    </script>

  <?php endif; ?>

  <script src="<?php echo BASE_URL;?>assets/js/validateJquery/dist/jquery.validate.min.js"></script>


  <script type="text/javascript">
    var save_method; //for save method string
    var table;

    $(function() {

      $(document).ready(function() {

        var filtro = <?php echo json_encode($_GET); ?>;

        var myTable = $('#table').DataTable({
          "processing": true,
          "serverSide": true,
          "autoWidth": false,
          "displayLength": 10,
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
          paginate: true,
          filter: true,
          "ajax": {
            "url": BASE_URL + "<?php echo $viewData['pageController']; ?>/getAll",
            "type": "POST",
            "data": {
              filtro,
              
            }

          },
        });
      });
    });
  </script>



</body>

</html>