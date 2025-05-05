<?php
// fichier testdao.php à la racine du projet
// pour tester un objet Dao (et Entity)

    require_once("../model/Compte.php");
    require_once("../dao/CompteDao.php");

    require_once("../services/CompteService.php");

    $user = new Compte();
    $user->setEmail('kevin@gmail.com');
    $user->setPassword('Azert123');
    $user->setUsername('RayZens');
    $user->setDateCreation(new DateTime());
    $user->setDateModification(new DateTime());
    $user->setEstSupprime(false);
    $user->setEstSignale(false);
    $user->setEstBanni(false);
    $user->setEnAttenteDeModeration(true);

    $roleDao = new RoleDao();
    $role = $roleDao->findById(1); // 1 = Rédacteur

    $dao = new CompteService();
    $dao->insert($user);

?>
