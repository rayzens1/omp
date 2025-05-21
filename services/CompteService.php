<?php

	require_once(ROOT . "/utils/service/AbstractService.php");
	require_once(ROOT . "/utils/service/IService.php");
	require_once(ROOT . "/utils/dao/IDao.php");
	require_once(ROOT . "/dao/CompteDao.php");
	require_once(ROOT . "/model/Compte.php");
	require_once(ROOT . "/services/RoleService.php");

	class CompteService extends AbstractService implements IService {
		private CompteDao $dao;
		private RoleService $roleService;

		function __construct() {
			$this->dao = new CompteDao();
			$this->roleService = new RoleService();
		}

		function getDao() : IDao {
			return $this->dao;
		}

		function isValidCredential(Compte $compte) : ?int {
			return $this->dao->isValidCredential($compte);
		}

		function isValidLogin(Compte $compte) : ?bool {
			return $this->dao->isValidLogin($compte);
		}
		function isValidPseudo(Compte $compte) : ?bool {
			return $this->dao->isValidPseudo($compte);
		}
		
		function insert(IEntity $compte) : int {
			/** @var Compte $compte */

			$compte->setDateCreation((new DateTime())->format('Y-m-d H:i:s'));
			$compte->setDateModification( (new DateTime())->format('Y-m-d H:i:s') );
			$compte->setEstSupprime(0);
			$compte->setEstSignale(0);
			$compte->setEstBanni(0);
			$compte->setEnAttenteDeModeration(1);
			// $compte->setFkRole(1);
			$compte->setRole($this->roleService->findById(1));

			return $this->dao->insert($compte); // parent::insert($compte)  est égale à $this->dao->insert($compte)
		}

	}

?>