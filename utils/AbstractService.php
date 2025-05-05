<?php
	require_once("../utils/IService.php");
	require_once("../utils/IDao.php");

	abstract class AbstractService implements IService {
		// Chaque Service concret me fournira son DAO
		// Le polymorphisme fera le boulot
		abstract function getDao() : IDao;

		function findAll() {
			return $this->getDao()->findAll();
		}

                function findById(int $id) : ?IEntity {
			return $this->getDao()->findById($id);
		}

                function insert(IEntity $entity) : int {
			return $this->getDao()->insert($entity);
		}

                function delete(int $id) {
			$this->getDao()->delete($id);
		}

                function update(IEntity $entity) {
			$this->getDao()->update($entity);
		}
	}
?>
