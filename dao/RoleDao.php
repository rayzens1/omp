<?php
	require_once(ROOT."/utils/dao/IDao.php");
	require_once(ROOT."/model/Role.php");
	require_once(ROOT."/exceptions/HttpStatusException.php");
	require_once(ROOT."/utils/BddSingleton.php");
	require_once(ROOT."/utils/dao/AbstractDao.php");

    class RoleDao extends AbstractDao implements IDao {

		function getTableName() : string {
			return "Role";
		}

		function getPrimaryKey() : string {
			return "id_role";
		}

		function createEntityFromRow($row) : IEntity {
			return Role::createFromRow($row);
		}

        function findAll() {
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