<?php 

Class permissionsController extends controller {

	public function __construct(){
		parent::__construct();

		$u = new Users();
		if($u->isLogged() == false){

			header("Location: ".BASE_URL."login");
			exit();

		}

	}

	public function index(){
		$data = array();
		$u = new Users();
		$u->setLoggedUser();

		$company = new Companies($u->getCompany());
		$data['company_name'] = $company->getName();
		$data['user_email'] = $u->getEmail(); 

		if($u->hasPermission('permission_view')){

			$permissions = new Permissions();
			$data['permissions_list'] = $permissions->getList($u->getCompany());
			$data['permissions_groups_list'] = $permissions->getGroupList($u->getCompany());



			$this->loadTemplate('permissions', $data);
		} else {
			
			echo "<html><SCRIPT LANGUAGE='JavaScript'>

			window.alert('Usuario não autorizado')
			window.history.go(-1);
		</SCRIPT>

		</html>";

	}
}
public function add() {
	$data = array();
	$u = new Users();
	$u->setLoggedUser();

	$company = new Companies($u->getCompany());
	$data['company_name'] = $company->getName();
	$data['user_email'] = $u->getEmail(); 

	if($u->hasPermission('permission_view') && $u->hasPermission('permission_add')){
		$permissions = new Permissions();
		
		if(isset($_POST['name']) && !empty($_POST['name'])){

			$pname = addslashes($_POST['name']);
			$permissions->add($pname, $u->getCompany());
			header("Location: ".BASE."permissions");

		 }


		 //se namepost existe e ta preenchido

		 $this->loadTemplate('permissions_add', $data);

		} else {

			echo "<html><SCRIPT LANGUAGE='JavaScript'>

			window.alert('USUARIO NÃO AUTORIZADO!!')
			window.history.go(-1);
		</SCRIPT>

		</html>";

	} 
}

public function add_Group() {
	$data = array();
	$u = new Users();
	$u->setLoggedUser();

	$company = new Companies($u->getCompany());
	$data['company_name'] = $company->getName();
	$data['user_email'] = $u->getEmail(); 

	if($u->hasPermission('permission_view') && $u->hasPermission('permission_add_group')){
		$permissions = new Permissions();
		
		if(isset($_POST['name']) && !empty($_POST['name'])){

			$pname = addslashes($_POST['name']);
			$plist = $_POST['permissions'];
			$permissions->addGroup($pname,$plist, $u->getCompany());
			header("Location: ".BASE."permissions");

		 }//se namepost existe e ta preenchido

		 $data['permissions_list'] =  $permissions->getList($u->getCompany());
		

		 $this->loadTemplate('permissions_add_group', $data);

		} else {

			echo "<html><SCRIPT LANGUAGE='JavaScript'>

			window.alert('USUARIO NÃO AUTORIZADO!!')
			window.history.go(-1);
		</SCRIPT>

		</html>";

	} 
}

public function edit_Group($id) {
	$data = array();
	$u = new Users();
	$u->setLoggedUser();

	$company = new Companies($u->getCompany());
	$data['company_name'] = $company->getName();
	$data['user_email'] = $u->getEmail(); 

	if($u->hasPermission('permission_view') && $u->hasPermission('permission_edit_group')){
		
		$permissions = new Permissions();
		
		if(isset($_POST['name']) && !empty($_POST['name'])){

			$pname = addslashes($_POST['name']);
			$plist = $_POST['permissions'];

			$permissions->editGroup($pname,$plist, $id, $u->getCompany());
			header("Location: ".BASE."permissions");

		 }//se namepost existe e ta preenchido

		  $data['permissions_list'] =  $permissions->getList($u->getCompany());
		  $data['group_info'] = $permissions->getGroup($id, $u->getCompany());


		 $this->loadTemplate('permission_edit_group', $data);

		} else {

			echo "<html><SCRIPT LANGUAGE='JavaScript'>

			window.alert('USUARIO NÃO AUTORIZADO!!')
			window.history.go(-1);
		</SCRIPT>

		</html>";

	} 
}

public function delete($id){

	$data = array();
	$u = new Users();
	$u->setLoggedUser();

	$company = new Companies($u->getCompany());
	$data['company_name'] = $company->getName();
	$data['user_email'] = $u->getEmail(); 

	if($u->hasPermission('permission_view') && $u->hasPermission('permission_delete')){
		
		$permissions = new Permissions();
		header("Location: ".BASE."permissions#tab_2");
		


		$permissions->delete($id);


		echo "<html><SCRIPT LANGUAGE='JavaScript'>

		window.alert('Permissão Excluida com Sucesso!!')
		window.history.go(-1);
	</SCRIPT>

	</html>";





} else {

	echo "<html><SCRIPT LANGUAGE='JavaScript'>

	window.alert('Você não tem permissão para excluir!!')
	window.history.go(-1);
</SCRIPT>

</html>";

}
}

public function delete_group($id){

	$data = array();
	$u = new Users();
	$u->setLoggedUser();

	$company = new Companies($u->getCompany());
	$data['company_name'] = $company->getName();
	$data['user_email'] = $u->getEmail(); 

	if($u->hasPermission('permission_view') && $u->hasPermission('permission_delete_group')){
		
		$permissions = new Permissions();
		header("Location: ".BASE."permissions#tab_2");
		


		$permissions->deleteGroup($id);


		echo "<html><SCRIPT LANGUAGE='JavaScript'>

		window.alert('Grupo excluido com Sucesso!!')
		window.history.go(-1);
	</SCRIPT>

	</html>";





} else {

	echo "<html><SCRIPT LANGUAGE='JavaScript'>

	window.alert('Você não tem permissão para excluir!!')
	window.history.go(-1);
</SCRIPT>

</html>";

}
}


























































}