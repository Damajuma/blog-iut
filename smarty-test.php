<?php

include_once 'config/bdd.conf.php';
include_once 'config/init.conf.php';
//on insert les parties HTML
require_once 'include/connexion.inc.php';
include_once 'include/fonction.inc.php';

require_once('libs/Smarty.class.php');

$prenom = 'Maxime';

$smarty = new Smarty();

$smarty->setTemplateDir('templates/');
$smarty->setCompileDir('templates_c/');
//$smarty->setConfigDir('/web/www.example.com/guestbook/configs/');
//$smarty->setCacheDir('/web/www.example.com/guestbook/cache/');

$smarty->assign('name', 'prenom');

//** un-comment the following line to show the debug console
//$smarty->debugging = true;

$smarty->display('smarty-test.tpl');
?>
