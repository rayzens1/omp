<?php

	require_once(ROOT . "/utils/IService.php");
	require_once(ROOT . "/utils/AbstractService.php");
	require_once(ROOT . "/utils/IDao.php");
	require_once(ROOT . "/dao/CompteDao.php");
	require_once(ROOT . "/services/RoleService.php");
	require_once(ROOT . "/model/Compte.php");

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

		function login($compte) {
			return $this->getDao()->login($compte);
		}

	}

?>