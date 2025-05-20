<?php
	require_once(ROOT."/utils/dao/IDao.php");
	require_once(ROOT."/model/Compte.php");
	require_once(ROOT."/exceptions/HttpStatusException.php");
	require_once(ROOT."/utils/BddSingleton.php");
	require_once(ROOT."/utils/dao/AbstractDao.php");

    class CompteDao extends AbstractDao implements IDao {
		
		function getTableName() : string {
			return "Compte";
		}

		function getPrimaryKey() : string {
			return "id_compte";
		}

		function createEntityFromRow($row) : IEntity {
			return Compte::createFromRow($row);
		}

        function findAll() {
			throw new Exception("Not implemented");
		}

		function getDao() : IDao {
			return $this;
		}

		function insert(IEntity $entity) : int {
			throw new Exception("Not implemented");
		}

		function delete(int $id) {
			throw new Exception("Not implemented");
		}

		function update(IEntity $entity) {
			throw new Exception("Not implemented");
		}

		function isValidCredential(Compte $compte) : ?int {
			$login = $compte->getLogin();
			$password = $compte->getPassword();

			$pdo = BddSingleton::getInstance()->getPdo();

			// Le login existe en table ?
			$sql = "SELECT id_compte, password FROM Compte WHERE login = ? LIMIT 1";
			$stmt = $pdo->prepare($sql);
			$stmt->bindParam(1, $login, PDO::PARAM_STR);
			$stmt->setFetchMode(PDO::FETCH_OBJ);
			$stmt->execute();
			$row = $stmt->fetch();
			if (!$row) {
				return null;
			}
			$idCompte = $row->id_compte;
			$bddhash = $row->password;
			error_log("password : $password");
			error_log("bddhash : $bddhash");
			$passwordhash = password_hash($password, PASSWORD_DEFAULT);
			if (password_verify($password, $bddhash)) {
				return $idCompte;
			} else {
				return null;
			}
		}
    }



	
		// function findById(int $id) : IEntity {
		// 	$pdo = BddSingleton::getInstance()->getPdo();
		// 	$sql = "SELECT * FROM Compte t WHERE t.id_compte = ?";
		// 	$stmt = $pdo->prepare($sql);
		// 	$stmt->bindParam(1, $id, PDO::PARAM_INT);
		// 	$stmt->setFetchMode(PDO::FETCH_OBJ);
		// 	$stmt->execute();
		// 	$row = $stmt->fetch();
		// 	if (!$row) {
		// 		throw new HttpStatusException("Entity Compte not found ". $id, 404);
		// 	}

		// 	return Compte::createFromRow($row);
		// }
?>

