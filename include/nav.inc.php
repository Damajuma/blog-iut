<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark static-top">
    <div class="container">
        <a class="navbar-brand" href="#">BLOG</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="index.php">Home
                        <span class="sr-only">(current)</span>
                    </a>
                </li>
                <?php if (($is_connect) == "TRUE") {
                    echo'
            <li class="nav-item">
              <a class="nav-link" href="article.php?action=ajouter">Créer un Article</a>
            </li>';
                }
                ?>
                <?php if (($is_connect) == FALSE) {
                    echo'
            <li class="nav-item">
              <a class="nav-link" href="utilisateur.php">Utilisateur</a>
            </li>';
                }
                ?>
                <?php if (($is_connect) == FALSE) {
                    echo'
            <li class="nav-item">
              <a class="nav-link" href="connexion.php">Connexion</a>
            </li>';
                }
                ?>
<?php if (($is_connect) == "TRUE") {
    echo'
            <li class="nav-item">
              <a class="nav-link" href="deconnexion.php">Deconnexion</a>
            </li>';
}
?>
            </ul>
        </div>
    </div>
</nav>



