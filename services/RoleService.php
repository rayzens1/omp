<?php

	require_once(ROOT . "/utils/service/IService.php");
	require_once(ROOT . "/utils/service/AbstractService.php");
	require_once(ROOT . "/utils/dao/IDao.php");
	require_once(ROOT . "/dao/RoleDao.php");

	class RoleService extends AbstractService implements IService {
		private RoleDao $dao;

		function __construct() {
			$this->dao = new RoleDao();
		}

		function getDao() : IDao {
			return $this->dao;
		}

		function getRole(int $roleId) : Role {
			$role = $this->dao->findById($roleId);
			if ($role == null) {
				throw new HttpStatusException(404, "Role not found");
			}
			return $role;
		}
	}

?>