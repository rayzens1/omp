<?php

	require_once(ROOT . "/utils/service/AbstractService.php");
	require_once(ROOT . "/utils/service/IService.php");
	require_once(ROOT . "/utils/dao/IDao.php");
	require_once(ROOT . "/dao/CompteDao.php");

	class CompteService extends AbstractService implements IService {
		private CompteDao $dao;

		function __construct() {
			$this->dao = new CompteDao();
		}

		function getDao() : IDao {
			return $this->dao;
		}

		function isValidCredential(Compte $compte) : ?int {
			return $this->dao->isValidCredential($compte);
		}

	}

?>