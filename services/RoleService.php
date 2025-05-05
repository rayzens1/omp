<?php

	require_once("../utils/IService.php");
	require_once("../utils/AbstractService.php");
	require_once("../utils/IDao.php");
	require_once("../dao/RoleDao.php");
	require_once("../model/Role.php");

	class RoleService extends AbstractService implements IService {
		private RoleDao $dao;

		function __construct() {
			$this->dao = new RoleDao();
		}

		function getDao() : IDao { // définie dans la classe abstrataire
			return $this->dao;
		}

		function findById(int $id) : ?IEntity {
            return $this->getDao()->findById($id);
		}		
	}

?>