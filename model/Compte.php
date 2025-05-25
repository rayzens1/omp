<?php

	require_once(ROOT . "/utils/entity/IEntity.php");
	require_once(ROOT . "/utils/entity/AbstractEntity.php");

	class Compte extends AbstractEntity implements IEntity {
		private $idCompte;
		private $login;
		private $password;
		private $pseudo;
		private $dateCreation;
		private $dateModification;
		private $estSupprime;
		private $estSignale;
		private $estBanni;
		private $enAttenteDeModeration;
		private $fk_role;
		private $role;

		function __contruct() { /* RAS */ }

		function getIdCompte() : int {
			return $this->idCompte;
		}
		function setIdCompte(int $id) {
			$this->idCompte = $id;
		}
		function setLogin(string $login) {
			$this->login = $login;
		}
		function getLogin() : string {
			return $this->login;
		}

		function setPassword(string $password) {
			$this->password = $password;
		}

		function getPassword() : string {
			return $this->password;
		}

		function setPseudo(string $pseudo) {
			$this->pseudo = $pseudo;
		}
		function getPseudo() : string {
			return $this->pseudo;
		}

		function setDateCreation(string $dateCreation) {
			$this->dateCreation = $dateCreation;
		}
		function getDateCreation() : string {
			return $this->dateCreation;
		}

		function setDateModification(string $dateModification) {
			$this->dateModification = $dateModification;
		}
		function getDateModification() : string {
			return $this->dateModification;
		}

		function setEstSupprime(bool $estSupprime) {
			$this->estSupprime = $estSupprime;
		}
		function getEstSupprime() : bool {
			return $this->estSupprime;
		}

		function setEstSignale(bool $estSignale) {
			$this->estSignale = $estSignale;
		}
		function getEstSignale() : bool {
			return $this->estSignale;
		}

		function setEstBanni(bool $estBanni) {
			$this->estBanni = $estBanni;
		}
		function getEstBanni() : bool {
			return $this->estBanni;
		}

		function setEnAttenteDeModeration(bool $enAttenteDeModeration) {
			$this->enAttenteDeModeration = $enAttenteDeModeration;
		}
		function getEnAttenteDeModeration() : bool {
			return $this->enAttenteDeModeration;
		}

		function setFkRole(int $fk_role) {
			$this->fk_role = $fk_role;
		}
		function getFkRole() : int {
			return $this->fk_role;
		}

		function setRole(Role $role) {
			$this->role = $role;
		}

		function getRole() : Role {
			return $this->role;
		}

		public static function createFromRow($row) {
			$roleService = new RoleService(); // Enlever
			$role = $roleService->findById($row->fk_role); // Enlever

			$compte = new Compte();
			$compte->setIdCompte( intval($row->id_compte) );
			$compte->setLogin( $row->login );
			$compte->setPassword( $row->password );
			$compte->setPseudo( $row->pseudo );
			$compte->setDateCreation( $row->dateCreation );
			$compte->setDateModification( $row->dateModification );
			$compte->setEstSupprime( $row->estSupprime );
			$compte->setEstSignale( $row->estSignale );
			$compte->setEstBanni( $row->estBanni );
			$compte->setEnAttenteDeModeration( $row->enAttenteDeModeration );
			// $compte->setFkRole( intval($row->fk_role) );
			$compte->setRole( $role );
			
			return $compte;
		}

		public static function createFromForm($form) {
			$compte = new Compte();
			$compte->setLogin( $form['login'] );
			$compte->setPassword( $form['password'] );
			$compte->setPseudo( $form['pseudo'] );
			
			return $compte;
		}

		public static function createForCredential(string $login, string $password) {
            $compte = new Compte();
            $compte->setLogin( $login );
            $compte->setPassword( $password );
            return $compte;
        }

		public static function createForRegister(string $login, string $pseudo) {
            $compte = new Compte();
            $compte->setLogin( $login );
			$compte->setPseudo( $pseudo );
            return $compte;
        }
	}
?>