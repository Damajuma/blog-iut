
<!-- Page Content -->
<div class="container">
    <div class="row">
        <div class="col-lg-12 text-center">
            <h1 class ="mt-5">Ajouter un utilisateur</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 text-center">
            <form action="utilisateur.php" method="post" enctype="multipart/form-data" id="form_article">
                <div class="form-group">
                    <label for="nom" class="col-form-label">Nom</label>
                    <input type="text" class="form-control" id="nom" name="nom" placeholder="Nom" value="" required>
                </div>

                <div class="form-group">
                    <label for="prenom" class="col-form-label">Prénom</label>
                    <input type="text" class="form-control" id="prenom" name="prenom" placeholder="Prénom" value="" required>
                </div>

                <div class="form-group">
                    <label for="email" class="col-form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="" required>
                </div>

                <div class="form-group">
                    <label for="mdp" class="col-form-label">Mot de passe</label>
                    <input type="password" class="form-control" id="mdp" name="mdp" placeholder="Mot de passe" value="" required>
                </div>

                <button type="submit" class="btn btn-primary" name="submit" value="ajouter">Ajouter l'utilisateur</button>
            </form>
        </div>
    </div>
</div>