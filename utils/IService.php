<?php

	require_once("../utils/IDao.php");
	require_once("../utils/IEntity.php");

	// Définit les opérations de base pour tout service
	interface IService {
		function findAll();

		function findById(int $id) : ?IEntity;

		function getDao() : IDao;

		function insert(IEntity $entity) : int;

		function delete(int $id);

		function update(IEntity $entity);
	}

?>
