<?php

	require_once("../utils/IEntity.php");
	require_once("../utils/AbstractEntity.php");

    class Role extends AbstractEntity implements IEntity {
        private $idRole;
        private $label;

        function __construct() { /* RAS */ }

        function getIdRole() : int {
            return $this->idRole;
        }

        function setIdRole(int $id) {
            $this->idRole = $id;
        }

        function getLabel() : string {
            return $this->label;
        }

        function setLabel(string $label) {
            $this->label = $label;
        }

        static function createFromRow($row) : Role {
            $role = new Role();
            $role->setIdRole($row->id_role);
            $role->setLabel($row->label);
            return $role;
        }
    }

?>