<?php
	require_once("../utils/IDao.php");
	require_once("../utils/AbstractDao.php");
	require_once("../utils/BddSingleton.php");
	require_once("../model/Role.php");

    class RoleDao extends AbstractDao implements IDao {

        private $Rolepdo;

        function findById(int $id) : ?Role {
			$pdo = BddSingleton::getinstance()->getPdo();
			$stmt = $pdo->prepare("SELECT * FROM Role WHERE id_role = ?");
			$stmt->bindParam(1, $id);
			$stmt->setFetchMode(PDO::FETCH_OBJ);
			$stmt->execute();
			$row = $stmt->fetch();
			if ( ! $row ) {
				return NULL;
			}

			$role = Role::createFromRow($row);

			return $role ;
		}
    }
?>