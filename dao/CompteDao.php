<?php
	require_once(ROOT."/utils/dao/IDao.php");
	require_once(ROOT."/model/Compte.php");

    class CompteDao implements IDao {

        function findAll() {
			throw new Exception("Not implemented");
		}

		function findById(int $id) : IEntity {
			$compte = new Compte();
			$compte->setIdCompte($id);
			$compte->setLabel("Kévin");
			return $compte;
		}

		function getDao() : IDao {
			return $this;
			throw new Exception("Not implemented");
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
    }
?>