<?php
	require_once(ROOT."/utils/dao/IDao.php");
	require_once(ROOT."/model/Role.php");

    class RoleDao implements IDao {

        function findAll() {
			throw new Exception("Not implemented");
		}

		function findById(int $id) : IEntity {
			$role = new Role();
			$role->setIdRole($id);
			$role->setLabel("Admin");
			return $role;
		}

		function getDao() : IDao {
			return $this;
			throw new Exception("Not implemented");
		}

		function insert(IEntity $entity) : int {
			$entity->setIdRole(4);
			return $entity->getIdRole();
			throw new Exception("Not implemented");
		}

		function delete(int $id) {
			throw new Exception("Not implemented");
		}

		function update(IEntity $entity) {
			throw new Exception("Not implemented");
		}
    }
?>