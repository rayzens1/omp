<?php

	require_once(ROOT . "/model/Compte.php");

	define("START_TIME", "startTime");
	define("COMPTE_ID", "compteId");

	function initSession() {
		// Aucun time out donc on le met en place
		if ( ! isset($_SESSION[START_TIME]) ) {
			$_SESSION[START_TIME] = time();
		} else if ( isLogged() ) {
			// L'utilisateur est loggué, on veut retarder la fin de la session
			$_SESSION[START_TIME] = time();
		}
	}

	function reinitSession() {
		session_destroy();
		session_start();
		initSession();
	}

	function manageSession() {
		session_start();
		initSession();
		if ( ($_SESSION[START_TIME] + getMaxTime() ) < time()) {
			reinitSession();
		}
	}

	function isLogged() : bool {
		return isset($_SESSION[COMPTE_ID]);
	}

	function getCompteIdFromSession() : ?int {
		return isLogged() ? $_SESSION[COMPTE_ID] : NULL;
	}

	function getTimeOut() : int {
		return $_SESSION[START_TIME] + getMaxTime();
	}

	function getMaxTime() {
		return 15 * 60; // 15 minutes
	}

	function getStartTime() {
		return $_SESSION[START_TIME];
	}

	function login(Compte $compte) {
		$_SESSION[COMPTE_ID] = $compte->getIdCompte();
	}
?>