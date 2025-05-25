<?php
	require_once(ROOT."/utils/dao/IDao.php");
	require_once(ROOT."/model/Article.php");
	require_once(ROOT."/exceptions/HttpStatusException.php");
	require_once(ROOT."/utils/BddSingleton.php");
	require_once(ROOT."/utils/dao/AbstractDao.php");

    class ArticleDao extends AbstractDao implements IDao {
		
		function getTableName() : string {
			return "article";
		}

		function getPrimaryKey() : string {
			return "id_article";
		}

		function createEntityFromRow($row) : IEntity {
			return Article::createFromRow($row);
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

		function insert(IEntity $article) : int {
			/** @var Article $article */
			
			$titre = $article->getTitre();
			$contenu = $article->getContenu();
			$dateCreation = $article->getDateCreation();
			$dateModification = $article->getDateModification();
			$estPublic = $article->getEstPublic();
			$estEnAttenteDeModeration = $article->getEnAttenteDeModeration();
			$estSupprime = $article->getEstSupprime();
			$fk_auteur = $article->getAuteur()->getIdCompte(); // 1 = ROLE_USER

			$pdo = BddSingleton::getInstance()->getPdo();

			$sql = "INSERT INTO Article (titre, contenu, dateCreation, dateModification, estPublic, enAttenteDeModeration, estSupprime, fk_auteur) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
			$stmt = $pdo->prepare($sql);
			$stmt->bindParam(1, $titre, PDO::PARAM_STR);
			$stmt->bindParam(2, $contenu, PDO::PARAM_STR);
			$stmt->bindParam(3, $dateCreation, PDO::PARAM_STR);
			$stmt->bindParam(4, $dateModification, PDO::PARAM_STR);
			$stmt->bindParam(5, $estPublic, PDO::PARAM_STR);
			$stmt->bindParam(6, $estEnAttenteDeModeration, PDO::PARAM_INT);
			$stmt->bindParam(7, $estSupprime, PDO::PARAM_INT);
			$stmt->bindParam(8, $fk_auteur, PDO::PARAM_INT);

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

			/** @var Article $entity */
			$idArticle = $entity->getIdArticle();
			$titre = $entity->getTitre();
			$contenu = $entity->getContenu();
			$dateCreation = $entity->getDateCreation();
			$dateModification = $entity->getDateModification();
			$estPublic = $entity->getEstPublic();
			$enAttenteDeModeration = $entity->getEnAttenteDeModeration();
			$estSupprime = $entity->getEstSupprime();
			$fk_auteur = $entity->getAuteur()->getIdCompte();

			$pdo = BddSingleton::getInstance()->getPdo();

			// Le login existe en table ?
			$sql = "
					UPDATE ".$this->getTableName()."
					SET 
						titre                  = :titre,
						contenu               = :contenu,
						dateCreation           = :dateCreation,
						dateModification       = :dateModification,
						estPublic            = :estPublic,
						enAttenteDeModeration             = :enAttenteDeModeration,
						estSupprime               = :estSupprime,
						fk_auteur                = :fk_auteur
					WHERE ".$this->getPrimaryKey()." = :idArticle
					";
			$stmt = $pdo->prepare($sql);
			$stmt->bindParam(1, $login, PDO::PARAM_STR);
			$stmt->setFetchMode(PDO::FETCH_OBJ);
			$stmt->execute([
				':titre'                   => $titre,
				':contenu'                => $contenu,
				':dateCreation'            => $dateCreation,
				':dateModification'        => $dateModification,
				':estPublic'             => $estPublic,
				':enAttenteDeModeration'              => $enAttenteDeModeration,
				':estSupprime'                => $estSupprime,
				':fk_auteur'                 => $fk_auteur,
				':idArticle'                => $idArticle,
			]);
			$affectedRows = $stmt->rowCount();
			if (!$affectedRows>0) {
				throw new HttpStatusException(404, "Nothing updated.");
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

