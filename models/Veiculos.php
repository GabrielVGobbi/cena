<?php
class Veiculos extends model

{

	public $veiculoInfo;
	
	public $row = 0;

	protected $table = 'veiculos';

	public $result = array();

	public function __construct($offset = 0, $filtro = array(), $id_veiculo = 0)
	{
		parent::__construct();

		$id_veiculo != 0 ? $this->getInfo($id_veiculo) : $this->getAll($offset, $filtro);
		
	}

	public function getAll($offset, $filtro, $id_company = 0)
	{

		$where = $this->buildWhere($filtro, $id_company);

		$sql = "SELECT * FROM veiculos vei WHERE " . implode(' AND ', $where) . " LIMIT $offset, 10";

		$sql = $this->db->prepare($sql);

		$this->bindWhere($filtro, $sql);

		$sql->execute();

		if ($sql->rowCount() > 0) {
			$this->veiculoInfo = $sql->fetchAll();
			$this->row = $sql->rowCount();
		}
		
		return $this->veiculoInfo;
	}

	private function buildWhere($filtro)
	{
		$where = array(
			'1=1'
		);


		if (!empty($filtro['razao_social'])) {

			if ($filtro['razao_social'] != '') {

				$where[] = "sev.sev_nome LIKE :razao_social";
			}
		}

		if (!empty($filtro['id'])) {

			if ($filtro['id'] != '') {

				$where[] = "sev.id = :id";
			}
		}

		return $where;
	}

	private function bindWhere($filtro, &$sql)
	{

		if (!empty($filtro['razao_social'])) {
			if ($filtro['razao_social'] != '') {
				$sql->bindValue(":razao_social", '%' . $filtro['razao_social'] . '%');
			}
		}

		if (!empty($filtro['id'])) {
			if ($filtro['id'] != '') {
				$sql->bindValue(":id", $filtro['id']);
			}
		}
	}

	public function getCount($offset, $filtro){
		
		return $this->row;

	}

	public function getInfo($id_veiculo){

		$sql = "SELECT * FROM veiculos vei WHERE id_veiculo = :id_veiculo LIMIT 1";

		$sql = $this->db->prepare($sql);
		$sql->bindValue(':id_veiculo', $id_veiculo);
		$sql->execute();

		if ($sql->rowCount() == 1) {
			$this->veiculoInfo = $sql->fetch();
		}
		
		return $this->veiculoInfo;
	}

}
