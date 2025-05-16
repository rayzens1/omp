<?php

    require_once(ROOT . "/utils/dao/IDao.php");
    require_once(ROOT . "/utils/entity/IEntity.php");

    interface IService {
        function findAll() : array;
        function findById(int $id);
        function getDao(): IDao;
        function insert(IEntity $entity) : int;
        function delete(int $id);
        function update(IEntity $entity);
    }

?>