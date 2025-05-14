<?php

	require_once(ROOT . "/utils/entity/IEntity.php");
	require_once(ROOT . "/utils/entity/AbstractEntity.php");

	class Compte extends AbstractEntity implements IEntity {
		private $idCompte;
		private $label;
		function __contruct() { /* RAS */ }
		function getIdCompte() : int {
			return $this->idCompte;
		}
		function setIdCompte(int $id) {
			$this->idCompte = $id;
		}
		function getLabel() : string {
			return $this->label;
		}
		function setLabel(string $l) {
			$this->label = $l;
		}
		public static function createFromRow($row) {
			$compte = new Compte();
			$compte->setIdCompte( intval($row->id_compte) );
			$compte->setLabel( $row->label );
			return $compte;
		}
	}
?>