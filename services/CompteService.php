<?php

	require_once("../utils/IService.php");
	require_once("../utils/AbstractService.php");
	require_once("../utils/IDao.php");
	require_once("../dao/CompteDao.php");
	require_once("../services/RoleService.php");
	require_once("../model/Compte.php");

	// Service => Règles métier

	class CompteService extends AbstractService implements IService {
		private CompteDao $dao;
		private RoleService $roleService;

		function __construct() {
			$this->dao = new CompteDao();
			$this->roleService = new RoleService();
		}

		function getDao() : IDao { // définie dans la classe abstrataire
			return $this->dao;
		}

		function insert(IEntity $c) : int {
			// Code métier, un compte est forcément un Rédacteur
			$role = $this->roleService->findById(1);
			$c->setRole($role);
            return $this->getDao()->insert($c);
		}		

		// A Faire
		function login($compte) {
			return $this->getDao()->login($compte);
		}

	}

?>