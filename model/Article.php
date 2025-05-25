<?php

	require_once(ROOT . "/utils/entity/IEntity.php");
	require_once(ROOT . "/utils/entity/AbstractEntity.php");

	class Article extends AbstractEntity implements IEntity {
		private $idArticle;
		private $titre;
		private $contenu;
		private $dateCreation;
		private $dateModification;
		private $estPublic;
		private $enAttenteDeModeration;
		private $estSupprime;
		private $fk_auteur;
		private $auteur;
		// private $compte;
		private $moderePar;
		private $dateModeration;
		private $moderationDescription;

		function __contruct() { /* RAS */ }

		function getIdArticle() : int {
			return $this->idArticle;
		}
		function setIdArticle(int $id) {
			$this->idArticle = $id;
		}
		function setTitre(string $titre) {
			$this->titre = $titre;
		}
		function getTitre() : string {
			return $this->titre;
		}

		function setContenu(string $contenu) {
			$this->contenu = $contenu;
		}

		function getContenu() : string {
			return $this->contenu;
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

		function setEstPublic(bool $estPublic) {
			$this->estPublic = $estPublic;
		}
		function getEstPublic() : bool {
			return $this->estPublic;
		}

		function setEnAttenteDeModeration(bool $enAttenteDeModeration) {
			$this->enAttenteDeModeration = $enAttenteDeModeration;
		}
		function getEnAttenteDeModeration() : bool {
			return $this->enAttenteDeModeration;
		}

		function setEstSupprime(bool $estSupprime) {
			$this->estSupprime = $estSupprime;
		}
		function getEstSupprime() : bool {
			return $this->estSupprime;
		}

		function setFkAuteur(int $fk_auteur) {
			$this->fk_auteur = $fk_auteur;
		}
		function getFkAuteur() : int {
			return $this->fk_auteur;
		}

		function setAuteur(Compte $compte) {
			$this->auteur = $compte;
		}

		function getModerePar() : Compte {
			return $this->moderePar;
		}
		function setModerePar(Compte $compte) {
			$this->moderePar = $compte;
		}

		function getAuteur() : Compte {
			return $this->auteur;
		}

		function setDateModeration(string $dateModeration) {
			$this->dateModeration = $dateModeration;
		}

		function getDateModeration() : string {
			return $this->dateModeration;
		}

		function setModerationDescription(string $moderationDescription) {
			$this->moderationDescription = $moderationDescription;
		}

		function getModerationDescription() : string {
			return $this->moderationDescription;
		}

		public static function createFromRow($row) {
			$compteService = new CompteService(); // Enlever
			$compte = $compteService->findById($row->fk_auteur); // Enlever

			$article = new Article();
			$article->setIdArticle( intval($row->id_article) );
			$article->setTitre( $row->titre );
			$article->setContenu( $row->contenu );
			$article->setDateCreation( $row->dateCreation );
			$article->setDateModification( $row->dateModification );
			$article->setEstPublic( $row->estPublic );
			$article->setEnAttenteDeModeration( $row->enAttenteDeModeration );
			$article->setEstSupprime( $row->estSupprime );

			if( $row->fk_moderePar ) {
				$moderePar = $compteService->findById($row->fk_moderePar);
				$article->setModerePar($moderePar);
			}
			if( $row->dateModeration ) {
				$article->setDateModeration($row->dateModeration);
			}
			if( $row->moderationDescription ) {
				$article->setModerationDescription($row->moderationDescription);
			}
			
			$article->setAuteur( $compte );
			
			return $article;
		}

		public static function createFromForm($form) {
			$article = new Article();
			$article->setTitre( $form['titre'] );
			$article->setContenu( $form['contenu'] );
			
			return $article;
		}
	}
?>