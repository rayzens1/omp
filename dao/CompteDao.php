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

		function getDao() : IDao {
			return $this;
		}

		function insert(IEntity $compte) : int {
			/** @var Compte $compte */
			
			$login = $compte->getLogin();
			$password = $compte->getPassword();
			$pseudo = $compte->getPseudo();
			$dateCreation = $compte->getDateCreation();
			$dateModification = $compte->getDateModification();
			$estSupprime = $compte->getEstSupprime();
			$estSignale = $compte->getEstSignale();
			$estBanni = $compte->getEstBanni();
			$enAttenteDeModeration = $compte->getEnAttenteDeModeration();
			$fk_role = $compte->getRole()->getIdRole(); // 1 = ROLE_USER
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

			try {
				$stmt->execute();
			} catch (PDOException $ex) {
				if(str_starts_with($ex->getMessage(), "SQLSTATE[23000]")) {
					$msg = explode(": ", $ex->getMessage())[2];
					if( str_starts_with($msg, "1062")) {
						$msg = explode(" ", $msg)[6];
						throw new HttpStatusException(499, $msg." - already exists");
					}
				} else {
					throw new HttpStatusException(500, "Erreur SQL : ".$ex->getMessage());
				}
			}
		
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

			/** @var Compte $entity */
			$idCompte = $entity->getIdCompte();
			$login = $entity->getLogin();
			$password = $entity->getPassword();
			$pseudo = $entity->getPseudo();
			$dateCreation = $entity->getDateCreation();
			$dateModification = $entity->getDateModification();
			$estSupprime = $entity->getEstSupprime();
			$estSignale = $entity->getEstSignale();
			$estBanni = $entity->getEstBanni();
			$enAttenteDeModeration = $entity->getEnAttenteDeModeration();
			$fk_role = $entity->getRole()->getIdRole();

			$pdo = BddSingleton::getInstance()->getPdo();

			// Le login existe en table ?
			$sql = "
					UPDATE ".$this->getTableName()."
					SET 
						login                  = :login,
						password               = :password,
						pseudo                 = :pseudo,
						dateCreation           = :dateCreation,
						dateModification       = :dateModification,
						estSupprime            = :estSupprime,
						estSignale             = :estSignale,
						estBanni               = :estBanni,
						enAttenteDeModeration  = :enAttenteDeModeration,
						fk_role                = :fk_role
					WHERE ".$this->getPrimaryKey()." = :idCompte
					";
			$stmt = $pdo->prepare($sql);
			$stmt->bindParam(1, $login, PDO::PARAM_STR);
			$stmt->setFetchMode(PDO::FETCH_OBJ);
			$stmt->execute([
				':login'                   => $login,
				':password'                => $password,
				':pseudo'                  => $pseudo,
				':dateCreation'            => $dateCreation,
				':dateModification'        => $dateModification,
				':estSupprime'             => $estSupprime,
				':estSignale'              => $estSignale,
				':estBanni'                => $estBanni,
				':enAttenteDeModeration'   => $enAttenteDeModeration,
				':fk_role'                 => $fk_role,
				':idCompte'                => $idCompte,
			]);
			$affectedRows = $stmt->rowCount();
			if (!$affectedRows>0) {
				throw new HttpStatusException(404, "Nothing updated.");
			}
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
			if (password_verify($password, $bddhash)) {
				return $idCompte;
			} else {
				return null;
			}
		}

		function isValidLogin(Compte $compte) : ?bool {
			$login = $compte->getLogin();

			$pdo = BddSingleton::getInstance()->getPdo();

			// Le login existe en table ?
			$sql = "SELECT login FROM Compte WHERE login = ? LIMIT 1";
			$stmt = $pdo->prepare($sql);
			$stmt->bindParam(1, $login, PDO::PARAM_STR);
			$stmt->setFetchMode(PDO::FETCH_OBJ);
			$stmt->execute();
			$row = $stmt->fetch();
			if (!$row) {
				// Le login n'existe pas
				return true;
			}
			return false;
		}

		function isValidPseudo(Compte $compte) : ?bool {
			$pseudo = $compte->getPseudo();

			$pdo = BddSingleton::getInstance()->getPdo();

			// Le pseudo existe en table ?
			$sql = "SELECT pseudo FROM Compte WHERE pseudo = ? LIMIT 1";
			$stmt = $pdo->prepare($sql);
			$stmt->bindParam(1, $pseudo, PDO::PARAM_STR);
			$stmt->setFetchMode(PDO::FETCH_OBJ);
			$stmt->execute();
			$row = $stmt->fetch();
			if (!$row) {
				return true;
			}
			return false;
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

