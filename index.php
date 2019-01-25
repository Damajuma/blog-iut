<?php
session_start();
require_once 'config/init.conf.php';
require_once 'config/bdd.conf.php';
require_once 'include/fonction.inc.php';
require_once 'include/connexion.inc.php';
//On insert les parties HTML du site
include_once 'include/header.inc.php';
include_once 'include/nav.inc.php';

if (isset($_SESSION['notification'])) {
    $color_notification = $_SESSION['notification']['result'] == TRUE ? 'success' : 'danger';
}

$page_courante = !empty($_GET['page']) ? $_GET['page'] : 1;

$index_depart_MYSQL = indexPagination($page_courante, _nb_art_par_page);

$nb_total_article_publie = nb_total_article_publie($bdd);

$nb_pages = ceil($nb_total_article_publie / _nb_art_par_page);

// Je teste pour savoir si j'ai quelque chose dans POST
if (isset($_GET['search'])) {
    // J'ai quelque chose donc je peux continuer

    $search = $_GET['search'];

    /* @var $bdd PDO */
    $sql_search = "SELECT id "
            . "FROM article "
            . "WHERE texte like '$search%' ";
    /* @var $bdd PDO */
    $sth = $bdd->prepare($sql_search);

    $result = $sth->execute();
    var_dump($result);
}
?>


<!-- Page Content -->
<div class="container">
    <div class="row">
        <div class="col-lg-12 text-center mb-5">
            <h1 class="mt-5">Accueil du blog</h1>
            <?php if (isset($_SESSION['notification'])) { ?>
                <div class="alert alert-<?= $color_notification ?> alert-dismissible fade show" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <?= $_SESSION['notification']['message'] ?>
                    <?php unset($_SESSION['notification']) ?>
                </div>
            <?php } ?>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 text-center">

            <?php
            $sql_select = "SELECT "
                    . "id, "
                    . "titre, "
                    . "texte, "
                    . "publie, "
                    . "DATE_FORMAT(date, '%d/%m/%y') as date_fr "
                    . "FROM Bootstrap "
                    . "WHERE publie = :publie "
                    . "LIMIT :index_depart, :nb_limit";
            /* @var $bdd PDO */
            $sth = $bdd->prepare($sql_select);

            $sth->bindValue(':publie', 1, PDO::PARAM_BOOL);
            $sth->bindValue(':index_depart', $index_depart_MYSQL, PDO::PARAM_INT);
            $sth->bindValue(':nb_limit', _nb_art_par_page, PDO::PARAM_INT);

            $sth->execute();
            $tab_bootstrap = $sth->fetchAll(PDO::FETCH_ASSOC);

            //print_r2($tab_bootstrap);

            foreach ($tab_bootstrap as $value) {
                ?>
                <div class="card mb-5">
                    <img class="card-img-top" src="img/<?= $value['id']; ?>.jpg" alt="Card image cap">
                    <div class="card-body">
                        <h5 class="card-title"><?= $value['titre']; ?></h5>
                        <p class="card-text"><?= $value['texte']; ?></p>
                        <a href="#" class="btn btn-primary"><?= $value['date_fr']; ?></a>
                        <?php if (($is_connect) == "TRUE") { ?>
                            <a href="article.php?action=modifier&id=<?= $value['id']; ?>" class="btn btn-warning" value="Modifier">Modifier</a>
                        <?php } ?>
                        <?php if (($is_connect) == "TRUE") { ?>
                            <a href="article.php?action=supprimer&id=<?= $value['id']; ?>" class="btn btn-danger" value="Supprimer">Supprimer</a>
                        <?php } ?>
                    </div>
                </div>

    <?php
}
?>
        </div>
        <div class="col-md-12">
            <nav aria-label="Page navigation example">
                <ul class="pagination justify-content-center">
<?php for ($i = 1; $i <= $nb_pages; $i++) { ?>
                        <li class="page-item"><a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                    <?php } ?>
                </ul>
            </nav>
        </div>

<?php
//On insert les parties HTML du site
include_once 'include/footer.inc.php';
?>
    </div>
</div>
