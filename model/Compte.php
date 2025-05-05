<?php

	require_once("../utils/IEntity.php");
	require_once("../utils/AbstractEntity.php");

	class Compte extends AbstractEntity implements IEntity {
		private $idCompte;
		private $email;
		private $password;
		private $dateCreation;
		private $dateModification;

		private $enAttenteDeModeration;
		private $estSupprime;

		private $role;

		private $estSignale;
		private $estBanni;
		private $username;

		function __contruct() { /* RAS */ }

		function getIdCompte() : int {
			return $this->idCompte;
		}

		function setIdCompte(int $id) {
			$this->idCompte = $id;
		}

		function getEmail() : string {
			return $this->email;
		}

		function setEmail(string $email) {
			$this->email = $email;
		}

		function getPassword() : string {
			return $this->password;
		}

		function setPassword(?string $pwd) {
			$this->password = $pwd;
		}

		function getDateCreation() : DateTime {
			return $this->dateCreation;
		}

		function setDateCreation(DateTime $date) {
			$this->dateCreation = $date;
		}

		function getDateModification() : DateTime {
			return $this->dateModification;
		}

		function setDateModification(DateTime $date) {
			$this->dateModification = $date;
		}

		function enAttenteDeModeration() : bool {
			return $this->enAttenteDeModeration;
		}

		function setEnAttenteDeModeration(bool $b) {
			$this->enAttenteDeModeration = $b;
		}

		function estSupprime() : bool {
			return $this->estSupprime;
		}

		function setEstSupprime(bool $b) {
			$this->estSupprime = $b;
		}

		function estSignale() : bool {
			return $this->estSignale;
		}

		function setEstSignale(bool $b) {
			$this->estSignale = $b;
		}

		function setEstBanni(bool $b) {
			$this->estBanni = $b;
		}

		function estBanni() : bool {
			return $this->estBanni;
		}

		function getUsername() : string {
			return $this->username;
		}

		function setUsername(string $s) {
			$this->username = $s;
		}

		function getRole() : Role {
			return $this->role;
		}

		function setRole(Role $Role) {
			$this->role = $Role;
		}

		public static function createFromRow($row, bool $keepPassword = false) {
			$compte = new Compte();
			$compte->setIdCompte( intval($row->id_compte) );
			$compte->setEmail( $row->email );
			$compte->setUsername($row->username); // ICI
			$compte->setPassword( $keepPassword ? $row->password : NULL );
			$compte->setDateCreation( new DateTime($row->dateCreation) );
			$compte->setDateModification( new DateTime($row->dateModification) );
			$compte->setEnAttenteDeModeration( boolval($row->enAttenteDeModeration) );
			$compte->setEstSupprime( boolval($row->estSupprime) );
			$compte->setEstSignale( boolval($row->estSignale) ); // ICI
			$compte->setEstBanni( boolval($row->estBanni) ); // ICI
			return $compte;
		}

		public static function create($email, $username, $password) {
			$compte = new Compte();
			$compte->setEmail( $email );
			$compte->setUsername($username); // ICI
                        $compte->setPassword( $password );
                        $compte->setDateCreation( new DateTime() );
                        $compte->setDateModification( new DateTime() );
			$compte->setEnAttenteDeModeration( true );
                        $compte->setEstSupprime( false );
			$compte->setEstSignale( false ); // ICI
			$compte->setEstBanni( false ); // ICI
			return $compte;
		}

	}

?>