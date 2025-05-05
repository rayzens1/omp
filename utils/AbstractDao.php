<?php

	require_once("../utils/IDao.php");

	abstract class AbstractDao implements IDao {

                function findAll() { throw new Exception("Not implemented"); }

                function findById(int $id) : ?IEntity { throw new Exception("Not implemented"); }

                function getDao() : IDao { throw new Exception("Not implemented"); }

                function insert(IEntity $entity) : int { throw new Exception("Not implemented"); }

                function delete(int $id) { throw new Exception("Not implemented"); }

                function update(IEntity $entity) { throw new Exception("Not implemented"); }

	}

?>
