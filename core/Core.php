<?php
class Core {

	public function run() {

		$url = '/';
		if(isset($_GET['url'])){
			$url .= $_GET['url'];
		}

		$params = array();


		if(!empty($url) && $url != '/' && $url != 'assets/images/anuncios'){

			$url = explode('/', $url);
			array_shift($url);


			if($url[0].'Controller' != 'assetsController'){
				$currentController = $url[0].'Controller';
				array_shift($url);
			}

			if(isset($url[0]) && !empty($url[0])) {
				$currentAction = $url[0];
				array_shift($url);
			}else {
				$currentAction = 'index';
			}

			if(count($url) > 0) {
				$params = $url;
			}


		}else {
			$currentController = 'homeController';
			$currentAction = 'index';
		}
		
		if(isset($currentController)){
			if($currentController != ''){
				$c = new $currentController();
				call_user_func_array(array($c, $currentAction), $params);
			}
		}









       /* $url = explode('index.php', $_SERVER['PHP_SELF']);
        $url = end($url);

		$params = array();
		if(!empty($url) && $url != '/') {
			$url = explode('/', $url);
			array_shift($url);

			$currentController = $url[0].'Controller';
			array_shift($url);

			if(isset($url[0])) {
				$currentAction = $url[0];
				array_shift($url);
			} else {
				$currentAction = 'index';
			}

			if(count($url) > 0) {
				$params = $url;
			}

		} else {
			$currentController = 'homeController';
			$currentAction = 'index';
		}

		if(!file_exists('controllers/'.$currentController.'.php') || !method_exists($currentController, $currentAction)){
			$currentController = 'notFoundController';
			$currentAction = 'index';
		}

		$c = new $currentController();
		call_user_func_array(array($c, $currentAction), $params);*/
	}

}