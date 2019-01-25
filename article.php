<?php
session_start();
require_once 'config/init.conf.php';
require_once 'config/bdd.conf.php';
require_once 'include/fonction.inc.php';
require_once 'include/connexion.inc.php';
//On insert les parties HTML du site
include_once 'include/header.inc.php';
include_once 'include/nav.inc.php';
if ($is_connect == TRUE) {
    $action = $_GET['action'];
    $publie = isset($_POST['publie']) ? $_POST['publie'] : 0;

    if ($action == 'supprimer') {
        $id_update_article = $_GET['id'];

        /* @var $bdd PDO */
        $sql_select = "DELETE FROM "
                . "Bootstrap "
                . "WHERE id = :id ";
        /* @var $bdd PDO */
        $sth = $bdd->prepare($sql_select);

        //Déclaration des Paramètres
        $sth->bindValue(':id', $id_update_article, PDO::PARAM_INT);

        $sth->execute();
        header("Location:index.php");
        exit();
    }

    if (isset($_GET['id'])) {
        $id_update_article = $_GET['id'];

        /* @var $bdd PDO */
        $sql_select = "SELECT "
                . "titre, "
                . "texte, "
                . "publie "
                . "FROM Bootstrap "
                . "WHERE id = :id ";
        /* @var $bdd PDO */
        $sth = $bdd->prepare($sql_select);

        //Déclaration des Paramètres
        $sth->bindValue(':id', $id_update_article, PDO::PARAM_INT);

        $sth->execute();
        $tab_update = $sth->fetchall(PDO::FETCH_ASSOC);

        foreach ($tab_update as $valueUpdate) {
            $titre = $valueUpdate['titre'];
            $texte = $valueUpdate['texte'];
            $publie = $valueUpdate['publie'];
        }
    } else {
        $id_update_article = "";
    }

    if (isset($_POST['submit'])) {
        print_r2($_POST);
        print_r2($_FILES);

        $publie = isset($_POST['publie']) ? $_POST['publie'] : 0;
        $date = date("Y-m-d");

        if ($_POST['submit'] == 'ajouter') {

            /* @var $bdd PDO */
            $sql_insert = "INSERT INTO Bootstrap "
                    . "(titre, texte, publie, date)"
                    . "VALUES (:titre, :texte, :publie, :date);";

            $sth = $bdd->prepare($sql_insert);

            $sth->bindValue(':titre', $_POST['titre'], PDO::PARAM_STR);
            $sth->bindValue(':texte', $_POST['texte'], PDO::PARAM_STR);
            $sth->bindValue(':publie', $publie, PDO::PARAM_BOOL);
            $sth->bindValue(':date', $date, PDO::PARAM_STR);
        } else {
            /* @var $bdd PDO */
            $sql_update = "UPDATE Bootstrap SET "
                    . "titre= :titre, "
                    . "texte= :texte, "
                    . "publie= :publie "
                    . "WHERE id = :id";


            $sth = $bdd->prepare($sql_update);

            $sth->bindValue(':titre', $_POST['titre'], PDO::PARAM_STR);
            $sth->bindValue(':texte', $_POST['texte'], PDO::PARAM_STR);
            $sth->bindValue(':publie', $publie, PDO::PARAM_BOOL);
            $sth->bindValue(':id', $_POST['id'], PDO::PARAM_STR);
        }
        $result = $sth->execute();

        var_dump($result);

        if ($_POST['submit'] == 'ajouter') {
            $id_update_article = $bdd->lastInsertId();
        } else {
            $id_update_article = $_POST['id'];
        }
        if ($_FILES['image']['error'] == 0) {
            $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            $extension = strtolower($extension);

            $result_img = move_uploaded_file($_FILES['image']['tmp_name'], 'img/' . $id_update_article . '.' . $extension);
        }

        $notification = '<b>Félicitation</b> votre article a été inséré dans la bdd.';
        $result_notification = TRUE;

        $_SESSION['notification']['message'] = $notification;
        $_SESSION['notification']['result'] = $result_notification;

        header("Location:index.php");
        exit();
    } else {
        ?>

        <!-- Page Content -->
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h1 class="mt-5"><?= ucfirst($action) ?> un Article</h1>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 text-center">
                    <form action="article.php" method="post" enctype="multipart/form-data" id="form_article">

                        <div class="form-group">
                            <input type="hidden" class="form-control" id="id" name="id" value="<?php if (($action) == "modifier") { ?><?= $id_update_article ?><?php } ?>">
                        </div>

                        <div class="form-group">
                            <label for="titre" class="col-form-label">Titre</label>
                            <input type="text" class="form-control" id="titre" name="titre" value="<?php if (($action) == "modifier") { ?><?= $titre ?><?php } ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="texte">Texte</label>
                            <textarea class="form-control" id="texte" name="texte" rows="3"required><?php if (($action) == "modifier") { ?><?= $texte ?><?php } ?></textarea>
                        </div>

                        <div class="form-group">
                            <div class="custom-file">
                                <input type="file"  id="image" name="image" class="custom-file-input">
                                <label class="custom-file-label" for="image">Choisir un fichier</label>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="form-check">
                                <label for="publie" class="form-check-label">
                                    <input type="checkbox"  id="publie" name="publie" class="form-check-input" value="1"<?php if (($publie) == "1") { ?>checked<?php } ?>>Publié?
                                </label>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary" name="submit" value="<?= $action ?>"><?= ucfirst($action) ?> l'article</button>
                    </form>
                </div>
            </div>
        </div>

        <?php
    }
}
//On insert les parties HTML du site
include_once 'include/footer.inc.php';
?>
