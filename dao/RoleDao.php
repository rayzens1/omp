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
			$pdo = BddSingleton::getInstance()->getPdo();
			$sql = "SELECT * FROM " . $this->getTableName();
			$stmt = $pdo->prepare($sql);
			$stmt->setFetchMode(PDO::FETCH_OBJ);
			$stmt->execute();
			$row = $stmt->fetch();
			if (!$row) {
				throw new HttpStatusException(404, "Table ".$this->getTableName()." empty ");
			}
			$count = $stmt->rowCount();

			$response = [];
			$response['count'] = $count;

			$entity = $this->createEntityFromRow($row);
			$response['data'][0] = $entity;

			for ($i = 1; $i < $count; $i++) {
				$row = $stmt->fetch();
				if (!$row) {
					throw new HttpStatusException(404, "Entity ".$i." empty in ".$this->getTableName());
				}
				$entity = $this->createEntityFromRow($row);
				$response['data'][$i] = $entity;
			}

			return $response;
		}

		function insert(IEntity $entity) : int {
			// /** @var Role $entity */
			// $entity->setIdRole(4);
			// return $entity->getIdRole();
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