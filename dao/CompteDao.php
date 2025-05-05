<?php
	require_once(ROOT . "/utils/IDao.php");
	require_once(ROOT . "/utils/AbstractDao.php");
	require_once(ROOT . "/utils/BddSingleton.php");
	require_once(ROOT . "/model/Compte.php");
	require_once(ROOT . "/dao/RoleDao.php");

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

			$compte->setRole($this->roleDao->findById($row['fk_role']));

			return $compte ;
		}

		function insert(IEntity $compte) : int {
			$pdo = BddSingleton::getInstance()->getPdo();
			$sql = "INSERT INTO Compte ("
				. "login, password, pseudo, dateCreation, dateModification, estSupprime, estSignale, estBanni, enAttenteDeModeration, fk_role) "
				. " VALUES (:log, :pwd, :pseudo, :dCreation, :dMod, :estSupp, :estSign, :estBan, :enAttMod, :idRole)";
			$stmt = $pdo->prepare($sql);
			$stmt->bindValue(":log", $compte->getLogin() );
			$stmt->bindValue(":pwd", hashPassword( $compte->getPassword() ) );
			$stmt->bindValue(":pseudo", $compte->getPseudo() );
			$stmt->bindValue(":dCreation", $compte->getDateCreation()->format(MYSQL_DATE_FORMAT) );
			$stmt->bindValue(":dMod", $compte->getDateModification()->format(MYSQL_DATE_FORMAT) );
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
