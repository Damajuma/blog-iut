<?php

session_start();
include_once 'config/bdd.conf.php';
include_once 'config/init.conf.php';
//on insert les parties HTML
require_once 'include/connexion.inc.php';
include_once 'include/header.inc.php';
include_once 'include/nav.inc.php';
include_once 'include/fonction.inc.php';
require_once 'templates/utilisateur.tpl';
require_once 'libs/Smarty.class.php';


if (isset($_POST['submit'])) {
    print_r2($_POST);
    print_r2($_FILES);

    $sid = isset($_POST['sid']) ? $_POST['sid'] : 0;

    /* @var $bddPDO */
    $sql_insert = "INSERT INTO utilisateur"
            . "(nom, prenom, email, mdp, sid)"
            . "VALUES (:nom, :prenom, :email, :mdp, :sid);";
    $sth = $bdd->prepare($sql_insert);

    $sth->bindvalue(':nom', $_POST['nom'], PDO::PARAM_STR);
    $sth->bindvalue(':prenom', $_POST['prenom'], PDO::PARAM_STR);
    $sth->bindvalue(':email', $_POST['email'], PDO::PARAM_STR);
    $sth->bindvalue(':mdp', cryptPassword($_POST['mdp']), PDO::PARAM_STR);
    $sth->bindvalue(':sid', $sid, PDO::PARAM_STR);

    $result = $sth->execute();

    var_dump($result);

    $id_utilisateur = $bdd->lastInsertId();

    $notification = '<b>Félicitation</b> votre utilisateur a été inséré dans la base de données.';
    $result_notification = TRUE;

    $_SESSION['notification']['message'] = $notification;
    $_SESSION['notification']['result'] = $result_notification;

    header("Location: index.php");
    exit();
} else {
    $smarty = new Smarty();

    $smarty->setTemplateDir('templates/');
    $smarty->setCompileDir('templates_c/');
//$smarty->setConfigDir('/web/www.example.com/guestbook/configs/');
//$smarty->setCacheDir('/web/www.example.com/guestbook/cache/');
//$smarty->assign('name','prenom');
//** un-comment the following line to show the debug console
//$smarty->debugging = true;
//$smarty->display('smarty-test.tpl');
}
include_once 'include/footer.inc.php';
?>

