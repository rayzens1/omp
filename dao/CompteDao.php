<?php
	require_once("../utils/IDao.php");
	require_once("../utils/AbstractDao.php");
	require_once("../utils/BddSingleton.php");
	require_once("../model/Compte.php");
	require_once("../dao/RoleDao.php");

	// Dao => Accès aux données

	class CompteDao extends AbstractDao implements IDao {

		private $roleDao;

		function __construct() {
			$this->roleDao = new RoleDao();
		}

		function findById(int $id) : ?Compte {
			$pdo = BddSingleton::getinstance()->getPdo();
			$stmt = $pdo->prepare("SELECT * FROM Compte WHERE id_compte = ?");
			$stmt->bindParam(1, $id);
			$stmt->setFetchMode(PDO::FETCH_OBJ);
			$stmt->execute();
			$row = $stmt->fetch();
			if ( ! $row ) {
				return NULL;
			}

			$compte = Compte::createFromRow($row) ;

			var_dump($row);	
			$compte->setRole($this->roleDao->findById($row->fk_role));

			return $compte ;
		}

		function insert(IEntity $compte) : int {
			$pdo = BddSingleton::getInstance()->getPdo();
			$sql = "INSERT INTO Compte ("
				. "email, password, username, dateCreation, dateModification, estSupprime, estSignale, estBanni, enAttenteDeModeration, fk_role) "
				. " VALUES (:mail, :pwd, :username, :dCreation, :dMod, :estSupp, :estSign, :estBan, :enAttMod, :idRole)";
			$stmt = $pdo->prepare($sql);
			$stmt->bindValue(":mail", $compte->getEmail() );
			$stmt->bindValue(":pwd", password_hash( $compte->getPassword(), PASSWORD_BCRYPT) );
			$stmt->bindValue(":username", $compte->getUsername() );
			$stmt->bindValue(":dCreation", $compte->getDateCreation()->format('Y-m-d H:i:s') );
			$stmt->bindValue(":dMod", $compte->getDateModification()->format('Y-m-d H:i:s') );
			$stmt->bindValue(":estSupp", $compte->estSupprime(), PDO::PARAM_BOOL);
			$stmt->bindValue(":estSign", $compte->estSignale(), PDO::PARAM_BOOL);
			$stmt->bindValue(":estBan", $compte->estBanni(), PDO::PARAM_BOOL);
			$stmt->bindValue(":enAttMod", $compte->enAttenteDeModeration(), PDO::PARAM_BOOL);
			$stmt->bindValue(":idRole", $compte->getRole()->getIdRole() );
			try {
				$stmt->execute();
				return $pdo->lastInsertId();
			} catch (PDOException $ex) {
				$newEx = wrapPDOException($ex);
				// var_dump($newEx);
				throw $newEx;
			}
		}




	}

?>
