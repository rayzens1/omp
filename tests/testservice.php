<?php
// fichier testservice.php à la racine du projet
// pour tester un objet Service

    define("ROOT", dirname(__FILE__).'/..' );
    require_once(ROOT . "/services/CompteService.php") ;

    $objCompteService = new CompteService() ;

    $objCompte = $objCompteService->findById(1) ;

//    var_dump($objCompte) ;

    echo '<br/><br/>Utilisateur 1<br/><br/>' ;

    echo json_encode($objCompte) ;

    echo '<br/><br/>Utilisateur 10<br/><br/>' ;

    echo json_encode($objCompteService->findById(10)) ;

?>
