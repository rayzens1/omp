<?php
	require_once(ROOT."/utils/dao/IDao.php");
    require_once(ROOT."/utils/entity/IEntity.php");
	require_once(ROOT."/exceptions/HttpStatusException.php");
	require_once(ROOT."/utils/BddSingleton.php");

    abstract class AbstractDao implements IDao {
		
		abstract function getTableName() : string;

		abstract function getPrimaryKey() : string;

		abstract function createEntityFromRow($row) : IEntity;

		function findById(int $id) : IEntity {
			$pdo = BddSingleton::getInstance()->getPdo();
			$sql = "SELECT * FROM ".$this->getTableName()." t WHERE t.".$this->getPrimaryKey()." = ?";
			$stmt = $pdo->prepare($sql);
			$stmt->bindParam(1, $id, PDO::PARAM_INT);
			$stmt->setFetchMode(PDO::FETCH_OBJ);
			$stmt->execute();
			$row = $stmt->fetch();
			if (!$row) {
				throw new HttpStatusException("Entity ".$this->getTableName()." not found ". $id, 404);
			}

			return $this->createEntityFromRow($row);
		}

    }
?>