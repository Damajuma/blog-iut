<?php

//Fonction de cryptage
function cryptPassword($mdp) {
    $mdp_crypt = sha1($mdp);
    return $mdp_crypt;
}

function sid($email) {
    $sid = md5($email . time());
    return $sid;
}

function indexPagination($page_courante, $nb_articles_par_page) {
    $index = ($page_courante - 1) * $nb_articles_par_page;
    return $index;
}

function nb_total_article_publie($bdd) {
    /* @var $bdd PDO */
    $sql = "SELECT COUNT(*) as nb_total_article_publie "
            . "FROM bootstrap "
            . "WHERE publie = 1 ";

    $sth = $bdd->prepare($sql);
    $sth->execute();
    $tab_result = $sth->fetch(PDO::FETCH_ASSOC);

    return $tab_result['nb_total_article_publie'];
}

function nb_total_article_publie_like($bdd, $search) {
    /* @var $bdd PDO */
    $sql = "SELECT COUNT(*) as nb_total_article_publie "
            . "FROM bootstrap "
            . "WHERE publie = 1 "
            . "AND (titre LIKE :search OR texte LIKE :search)";

    $sth = $bdd->prepare($sql);
    $sth->bindValue(':search', '%' . $_GET['search'] . '%', PDO::PARAM_STR);
    $sth->execute();
    $tab_result = $sth->fetch(PDO::FETCH_ASSOC);

    return $tab_result['nb_total_article_publie'];
}
