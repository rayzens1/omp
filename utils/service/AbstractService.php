<?php

	require_once(ROOT . "/utils/service/IService.php");
	require_once(ROOT . "/utils/dao/IDao.php");
	require_once(ROOT . "/utils/entity/IEntity.php");

	abstract class AbstractService implements IService {

		abstract function getDao() : IDao;

		function findAll() : array {
            return $this->getDao()->findAll();
        }
		
		function findById(int $id) : IEntity {
            return $this->getDao()->findById($id);
        }

		function insert(IEntity $entity) : int {
            return $this->getDao()->insert($entity);
        }
        
		function delete(int $id) {
            return $this->getDao()->delete($id);
        }

		function update(IEntity $entity) {
            return $this->getDao()->update($entity);
        }
	}

?>