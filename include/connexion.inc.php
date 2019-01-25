<?php

$is_connect = FALSE;

if (isset($_COOKIE['sid']) AND ! empty($_COOKIE['sid'])) {
    /* @var $bddPDO */
    $select = "SELECT * "
            . "FROM utilisateur "
            . "WHERE sid = :sid";
    $sth = $bdd->prepare($select);

    $sth->bindValue(':sid', $_COOKIE['sid'], PDO::PARAM_STR);

    $sth->execute();

    if ($sth->rowCount() > 0) {

        $tab_result_connexion = $sth->fetch(PDO::FETCH_ASSOC);

        $is_connect = TRUE;
        $nom_connect = $tab_result_connexion['nom'];
        $prenom_connect = $tab_result_connexion['prenom'];
        ;
    }
}
