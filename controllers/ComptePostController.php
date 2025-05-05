<?php

	require_once(ROOT . "/utils/IController.php");
	require_once(ROOT . "/utils/AbstractController.php");
	require_once(ROOT . "/utils/functions.php");
	require_once(ROOT . "/services/CompteService.php");
	require_once(ROOT . "/exceptions/ConstraintUniqueException.php");

	class ComptePostController extends AbstractController implements IController {

		private CompteService $service;

		private string $email;
		private string $pseudo;
		private string $password;

		public function __construct($form, $controllerName) {
			// Appel du constructeur de la classe mère AbstractController
			parent::__construct($form, $controllerName);
			$this->service = new CompteService();
		}

		function checkForm() {
			// email, pseudo, password, password confirmation
			if ( ! isset( $this->form['email'], $this->form['pseudo'], $this->form['pwd'], $this->form['pwdc'] )) {
				error_log("CYBERSEC Receive bad request");
				_400_Bad_Request();
			}
			// OK
		}

                function checkCybersec() {
			if ( ! isEmail($this->form['email']) ) {
				error_log("CYBERSEC Receive bad request");
                                _400_Bad_Request();
			}
			$this->email = $this->form['email'];
			if ( ! isPseudo( $this->form['pseudo'] ) ) {
				error_log("CYBERSEC Receive bad request");
                                _400_Bad_Request();
			}
			$this->pseudo = $this->form['pseudo'];
			if ( $this->form['pwd'] != $this->form['pwdc']) {
				error_log("CYBERSEC Receive bad request");
                                _400_Bad_Request();
			}
			if ( ! checkPassword($this->form['pwd']) ) { // Complexicité du mot de passe
				error_log("CYBERSEC Receive bad request");
                                _400_Bad_Request();
			}
			$this->password = $this->form['pwd'];
		}

                function checkRights() {
			error_log($this->controllerName . "->" . __FUNCTION__ .
				"TODO - la fonction isLogged est bouchonnée, terminer le job");
			if ( isLogged() ) {
				headerCustom(499, "Already Authenticated");
			}
		}

                function processRequest() {
			$compte = Compte::create($this->email, $this->pseudo, $this->password);
			try {
				$this->response = $this->service->insert($compte);
			} catch (ConstraintUniqueException $ex) {
// var_dump($ex);
				headerCustom(498, "Business Error " . $ex->getCode() . " " . $ex->getMessage() );
			} catch (Exception $ex) {
				var_dump($ex);
			}
			// ???? sur les cas de tests ???
		}

	}

?>