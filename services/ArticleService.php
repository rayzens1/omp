<?php

	require_once(ROOT . "/utils/service/AbstractService.php");
	require_once(ROOT . "/utils/service/IService.php");
	require_once(ROOT . "/utils/dao/IDao.php");
	require_once(ROOT . "/dao/ArticleDao.php");
	require_once(ROOT . "/model/Article.php");
	require_once(ROOT . "/services/CompteService.php");

	class ArticleService extends AbstractService implements IService {
		private ArticleDao $dao;
		private CompteService $compteService;

		function __construct() {
			$this->dao = new ArticleDao();
			$this->compteService = new CompteService();
		}

		function getDao() : IDao {
			return $this->dao;
		}
		
		function insert(IEntity $article) : int {
			/** @var Article $article */

			$article->setDateCreation((new DateTime())->format('Y-m-d H:i:s'));
			$article->setDateModification( (new DateTime())->format('Y-m-d H:i:s') );
			$article->setEstPublic(0);
			$article->setEnAttenteDeModeration(0);
			$article->setEstSupprime(0);

			return $this->dao->insert($article); // parent::insert($compte)  est égale à $this->dao->insert($compte)
		}

	}

?>