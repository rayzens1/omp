<?php

	require_once(ROOT . "/utils/service/IService.php");
	require_once(ROOT . "/utils/dao/IDao.php");
	require_once(ROOT . "/dao/RoleDao.php");

	class RoleService implements IService {
		private RoleDao $dao;

		function __construct() {
			$this->dao = new RoleDao();
		}

		function getDao() : IDao {
			return $this->dao;
		}

		function findAll() { 
			return $this->getDao()->findAll();
		}
		
		function findById(int $id) : IEntity {
            return $this->getDao()->findById($id);
		}

		function insert(IEntity $entity) : int {
			return $this->getDao()->insert($entity);
		}

		function delete(int $id) {
			$this->getDao()->delete($id);
		}

		function update(IEntity $entity) {
			$this->getDao()->update($entity);
		}
	}

?>