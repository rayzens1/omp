<?php
	require_once(ROOT . "/utils/IController.php");
	require_once(ROOT . "/utils/functions.php");

	abstract class AbstractController implements IController {

		protected $form;
		protected $controllerName;
		protected $response;

		// Constructeur, permet de faire new ClassName(...)
		public function __construct($form, $controllerName) {
			$this->form = $form;
			$this->controllerName = $controllerName;
		}

		function execute() {
			$this->checkForm();		// Vérifier les données de formulaires
			$this->checkCybersec();		// Vérifier la cybersécurité
			$this->checkRights();		// Controller les droits d'accès
			$this->processRequest();	// traiter la requete
			$this->processResponse();	// fournir la réponse
		}

		function processResponse() {
			if (is_null($this->response)) {
				_404_Not_Found();
			}
			echo json_encode($this->response);
		}

		abstract function checkForm();
		abstract function checkCybersec();
		abstract function checkRights();
		abstract function processRequest();
	}

?>