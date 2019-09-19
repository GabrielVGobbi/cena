<?php
class controller
{

	protected $db;
	private $userInfo;

	public function __construct()
	{


		$u = new Users;
		$u->setLoggedUser();

		$this->userInfo = array(
			'userName' 	  	=> $u->getInfo($u->getId(), $u->getCompany()),
			'user'			=> $u,
			'notificacao'   => $u->getNotificacao($u->getId(), $u->getCompany())
		);
	}

	public function loadView($viewName, $viewData = array())
	{
		extract($viewData);
		include 'views/' . $viewName . '.php';
	}

	public function loadTemplate($viewName, $viewData = array())
	{
		extract($viewData);

		include 'views/template.php';
	}

	public function loadViewInTemplate($viewName, $viewData)
	{
		extract($viewData);
		include 'views/' . $viewName . '.php';
	}

	public function loadViewError()
	{
		include 'views/notAutorized/404.php';
	}

	public static function alert($tipo, $mensagem)
	{

		$_SESSION['alert']['mensagem'] = $mensagem;
		$_SESSION['alert']['tipo'] = $tipo;

		return $_SESSION['alert'];
	}

	public static function ReturnValor($valor)
	{

		$valor = trim($valor);
		$valor = ucfirst($valor);

		return $valor;
	}

	public static function PriceSituation($valor)
	{

		$valor = trim($valor);
		$valor = str_replace(' ', '', $valor);
		$valor = str_replace('R$', '', $valor);
		$valor = explode(',', $valor);
		$valor = str_replace('.', '', $valor);

		return $valor[0];
	}

	public static function returnDate($valor)
	{

		$valor = trim($valor);
		$valor = str_replace('/', '-', $valor);


		return $valor;
	}

	public static function ReturnFormatLimpo($valor)
	{
		$valor = trim($valor);
		$valor = str_replace(' ', '', $valor);
		$valor = str_replace('-', '', $valor);
		$valor = str_replace('.', '', $valor);
		$valor = str_replace('/', '', $valor);

		return $valor;
	}

	public static function returnMobile()
	{
		$iphone = strpos($_SERVER['HTTP_USER_AGENT'], "iPhone");
		$ipad = strpos($_SERVER['HTTP_USER_AGENT'], "iPad");
		$android = strpos($_SERVER['HTTP_USER_AGENT'], "Android");
		$palmpre = strpos($_SERVER['HTTP_USER_AGENT'], "webOS");
		$berry = strpos($_SERVER['HTTP_USER_AGENT'], "BlackBerry");
		$ipod = strpos($_SERVER['HTTP_USER_AGENT'], "iPod");
		$symbian =  strpos($_SERVER['HTTP_USER_AGENT'], "Symbian");

		if ($iphone || $ipad || $android || $palmpre || $ipod || $berry || $symbian == true) {
			$mobile = true;
		} else {
			$mobile = false;
		}

		return $mobile;
	}

	public  static function SomarData($data, $dias, $meses = 0, $ano = 0)
	{
		if ($data != '') {
			//passe a data no formato dd-mm-yyyy
			//yyyy-mm-dd
			$data = explode("-", $data);
			$newData = date("d-m-Y", mktime(0, 0, 0, $data[1] + $meses, $data[0] + $dias, $data[2] + $ano));

			return $newData;
		}
	}

	public function loadEtapaByTipo($id)
	{
		$etp = new Etapa('etapas');

		$array = $etp->getIdEtapaObra($id);

		$nome_tela = strtolower($array[0]['nome']);

		include 'views/obras/etapas/' . $nome_tela . '.php';
		include "views/obras/etapas/editarEtapa.php";
	}

	public function loadEtapaCheck($check, $etp, $id_obra, $tipo)
	{



		include 'views/obras/etapas/check.php';
	}

	public function getQuntDocEtapa($id_etapa_obra)
	{
		$a = new Etapa('Etapa');

		return $a->getQntDocumentoEtapa($id_etapa_obra);
	}

	public function loadTempo($prazo_atendimento, $data_abertura, $check)
	{
		
		
		if($check == 0){
			if($prazo_atendimento != '' && $data_abertura != ''){
				if ($check == 1) {

					$msg = 'Concluido';
					$check = 'success';
					$atraso = 'success';
					echo '0';
				} else {
					$data_abertura = $data_abertura;
					$data_abertura = str_replace('/', '-', $data_abertura);
					$prazo_restante =  date('d-m-y', strtotime('+' . $prazo_atendimento . 'days', strtotime($data_abertura)));
					$data_hoje = date('d-m-Y');

					$nova_data = controller::SomarData($data_abertura, $prazo_atendimento);

					$data1 = new DateTime($data_hoje);
					$data2 = new DateTime($nova_data);

					$intervalo = $data1->diff($data2);

					$mes = ($intervalo->m != '0' ? $intervalo->m . ' meses e ' : "");
					$msg = 'Restam: ' . $mes . '' . $intervalo->d . ' Dia(s)';

					if (strtotime(date('d-m-Y')) > strtotime($nova_data)) {
						$check = 'danger';
						$atraso = 'danger';
						$msg = 'Atrasado em ' . $mes . $intervalo->d . ' Dia(s)';
					} elseif (strtotime(date('d-m-Y')) == strtotime($nova_data)) {
						$check = 'warning';
						$msg = 'Entrega Hoje';
					} elseif (strtotime(date('d-m-Y')) < strtotime($nova_data)) {
						$check = 'success';
						$msg = $mes . $intervalo->d . ' Dia(s) Restante(s)';
					}
					
				}

				
			}else {
			
				$check = 'warning';
				$msg = 'não foi definido prazo';
				
			}
			
			include 'views/obras/tempo.php';

		}else {
			
		}

	}

	public function loadEtapaObraByTipo($id_obra, $tipo)
	{

		$etp = new Obras();
		$etapas = array();
		$etapas = $etp->getEtapas($id_obra, '');

		include 'views/obras/etapas/obraEtapaTipo.php';
	}

	public function getDocumentoEtapaObra($id_etapa_obra)
	{

		$doc = new Documentos();
		$array = array();
		$array = $doc->getDocumentoEtapa($id_etapa_obra);

		return $array;
	}

	static public function diferenca($dt)
	{
		$time = strtotime($dt);
		$now = time();
		$dif = $now - $time;

		if ($dif > ((24 * 60) * 60)) {
			// dias
			$dif = (($dif / 60) / 60);

			$t = floor($dif / 24);
			return $t . ' dia' . (($t == 1) ? '' : 's');
		} else {
			// horas
			$dif = (($dif / 60) / 60);

			if (floor($dif * 60 * 60) < 60) {
				$t = floor($dif * 60 * 60);
				return $t . ' segundo' . (($t == 1) ? '' : 's');
			} elseif ($dif < 1) {
				$t = floor($dif * 60);
				return $t . ' minuto' . (($t == 1) ? '' : 's');
			} else {
				$t = floor($dif);
				return $t . ' hora' . (($t == 1) ? '' : 's');
			}
		}

		return $dif;
	}
}
