<?php

	define("MYSQL_DATE_FORMAT", "Y-m-d h:m:s");

	function headerAndDie($header) {
		header($header);
		die();
	}

	function headerCustom(int $code, string $label) {
		headerAndDie("HTTP/1.1 " . $code . " " . $label);
	}

	function _400_Bad_Request($msg = "") {
		headerAndDie("HTTP/1.1 400 Bad Request " . $msg);
	}

	function _401_Unauthorized() {
		headerAndDie("HTTP/1.1 401 Unauthorized");
	}

	function _404_Not_Found($msg = "") {
		headerAndDie("HTTP/1.1 404 Not Found " . $msg);
	}

	function _405_Method_Not_Allowed() {
		headerAndDie("HTTP/1.1 405 Method Not Allowed");
	}

	function _500_Internal_Server_Error($msg) {
		headerAndDie("HTTP/1.1 5OO Internal Server Error " . $msg);
	}

	function extractForm() {
		switch ($_SERVER['REQUEST_METHOD']) {
		case 'GET' : return $_GET;
		case 'POST' : return $_POST;
		case 'PUT' : // Non géré en php, il va falloir extraire depuis le formulaire brut
			$raw = file_get_contents('php://input'); 	// Le formulaire brut
			$form = [];					// mon futur tableau associatif
			parse_str($raw, $form);	// Function interne de transfert du raw vers mon $form
			return $form;
		case 'DELETE' : return $_GET;
		default : _405_Method_Not_Allowed();
		}
	}

	/**
	 * Cette fonction va extraire le paramètre "route" du formulaire
	 * puis le retourner, SI il n'est pas présent, le serveur retournera
	 * une erreur 400 Bad Request car on considère que l'on ne comprend
	 * pas la demande du client.
	 */
	function extractRoute($FORM) {
		if ( ! isset( $FORM['route'] ) ) {
			// Fall back au cas où on arrive sans aucun paramètre
			// On va à l'accueil, dans le cas des Web Services
			// Le développeur devrait tout le temps spécifier une route
			return "Accueil";
		}
		// On veut sécuriser la syntaxe de la route
		$ROUTE = $FORM['route'];
		if ( preg_match("/^[A-Za-z]{1,64}$/", $ROUTE) ) {
			return $ROUTE;
		}
		_400_Bad_Request("Wrong route syntax '" . $ROUTE . "'");
	}

	function createController($FORM, $ROUTE) {
		// Je récupère la méthode, par exemple GET, je veux Get
		$METHOD = strtolower( $_SERVER['REQUEST_METHOD'] ); // Tout en minuscule
		$METHOD = ucfirst($METHOD); // Première lettre en Majuscule
		// Je construis le nom de mon controlleur, je vais le réutiliser ailleurs
		$CONTROLLER_NAME = $ROUTE . $METHOD . "Controller";
		$FILE = ROOT . "/controllers/" . $CONTROLLER_NAME . ".php";
		if ( ! file_exists($FILE) ) {
			_404_Not_Found("Unknown Controller " . $ROUTE . $METHOD);
		}
		// Mon fichier PHP existe, je peux le require, puis charger la classe
		require($FILE);
		$controller = new $CONTROLLER_NAME($FORM, $CONTROLLER_NAME);
		return $controller;
	}

	function isEmail($email) {
		return true;
	}

	function checkPassword($password) {
		return true;
	}

	function hashPassword(string $str) {
		return password_hash($str, PASSWORD_BCRYPT);
	}

?>