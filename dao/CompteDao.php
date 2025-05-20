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

		function insert(IEntity $compte) : int {
			$login = $compte->getLogin();
			$password = $compte->getPassword();
			$pseudo = $compte->getPseudo();
			$dateCreation = $compte->getDateCreation()->format("Y-m-d H:i:s");
			$dateModification = $compte->getDateModification()->format("Y-m-d H:i:s");
			$estSupprime = $compte->getEstSupprime();
			$estSignale = $compte->getEstSignale();
			$estBanni = $compte->getEstBanni();
			$enAttenteDeModeration = $compte->getEnAttenteDeModeration();
			$fk_role = $compte->getFkRole();
			$hash = password_hash($password, PASSWORD_DEFAULT);

			$pdo = BddSingleton::getInstance()->getPdo();

			$sql = "INSERT INTO Compte (login, password, pseudo, dateCreation, dateModification, estSupprime, estSignale, estBanni, enAttenteDeModeration, fk_role) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
			$stmt = $pdo->prepare($sql);
			$stmt->bindParam(1, $login, PDO::PARAM_STR);
			$stmt->bindParam(2, $hash, PDO::PARAM_STR);
			$stmt->bindParam(3, $pseudo, PDO::PARAM_STR);
			$stmt->bindParam(4, $dateCreation, PDO::PARAM_STR);
			$stmt->bindParam(5, $dateModification, PDO::PARAM_STR);
			$stmt->bindParam(6, $estSupprime, PDO::PARAM_INT);
			$stmt->bindParam(7, $estSignale, PDO::PARAM_INT);
			$stmt->bindParam(8, $estBanni, PDO::PARAM_INT);
			$stmt->bindParam(9, $enAttenteDeModeration, PDO::PARAM_INT);
			$stmt->bindParam(10, $fk_role, PDO::PARAM_INT);

			$stmt->execute();
			$id = $pdo->lastInsertId();
			if ($id == 0) {
				throw new HttpStatusException(500, "Impossible d'ajouter le compte");
			}
			return $id;
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

