<?php
// fichier testdao.php à la racine du projet
// pour tester un objet Dao (et Entity)

    define("ROOT", dirname(__FILE__).'/..' );
    require_once(ROOT . "/dao/CompteDao.php") ;

    $objCompteDao = new CompteDao() ;

    $objCompte = $objCompteDao->findById(1) ;

//    var_dump($objCompte) ;

    echo '<br/><br/>Utilisateur 1<br/><br/>' ;

    echo json_encode($objCompte) ;

    echo '<br/><br/>Utilisateur 10<br/><br/>' ;

    echo json_encode($objCompteDao->findById(10)) ;

?>
