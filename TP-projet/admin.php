<?php session_start(); 

// if (isset($_SESSION['pseudo'])) {
// }else {
//     header('location:login.php');
// }
try {
    $pdo = new PDO(
      'mysql:host=localhost;dbname=miniboutique;port=3306',
      'root',
      '',
      array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    /*Sélectionne toutes les valeurs dans la table users*/
    $sth = $pdo->prepare("SELECT * FROM products");
    $sth->execute();


    $resultat = $sth->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
  }

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ma petite boutique</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link rel="stylesheet" href="css/style.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>



</head>

<body>

    <nav>
        <div class="nav-wrapper">
            <a href="index.php" class="brand-logo"><img class="logo" src='uploads/logo.png' /></a>

            <ul id="nav-mobile" class="right hide-on-med-and-down">
                <?php if (isset($_SESSION['pseudo'])) {
                    echo "<li class='hello'>Bonjour " . $_SESSION['pseudo'] . "</h4></li>";
                } ?>
                <li><a href="index.php">Ma petite boutique</a></li>
                <li><a href="logout.php">Déconnexion</a></li>
            </ul>
        </div>
    </nav>

    <h2 class="center-align">Ajouter un nouveau produit</h2>
    <div class="row center-align">
        <div class="col s2"></div>
        <div class="col s8">
            <form action="form-products.php" method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="input-field col s10">
                        <label for="name">Nom du produit</label>
                        <input type="text" name="name" class="validate" />
                    </div>
                    <div class="input-field col s2">
                        <label for="name">Prix du produit en €</label>
                        <input type="number" name="price" class="validate" />
                    </div>
                </div>
                <form class="col s12">
                    <div class="row">
                        <div class="input-field col s8">
                            <textarea id="textarea1" class="materialize-textarea" name="description"></textarea>
                            <label for="description">Description du produit</label>
                        </div>
                        <div class="input-field col s4">
                            <label for="name">Catégorie du produit</label>
                            <input type="text" name="category" class="validate" />
                        </div>
                    </div>
                    <div class="file-field input-field">
                        <div class="btn">
                            <span>Photo</span>
                            <input type="file" name="fileToUpload" id="fileToUpload">
                        </div>
                        <div class="file-path-wrapper">
                            <input class="file-path validate" type="text">
                        </div>
                    </div>
                    <button class="btn waves-effect waves-light" type="submit" name="action">Ajouter le produit
                        <i class="material-icons right ">add</i>
                    </button>
                </form>
        </div>
        <div class="col s2"></div>
    </div>

    <table>
        <tr>
            <th>Nom du produit</th>
            <th>Description</th>
            <th>Prix</th>
            <th></th>
            <th></th>
            <th></th>
        </tr>
<?php foreach ($resultat as $key => $value) { ?>
        <tr>
            <td><?php echo $value['name'] ?></td>
            <td><?php echo $value['description'] ?></td>
            <td><?php echo $value['price'] ?>€</td>
            <td><img src="<?php echo $value['image'] ?>" width=50 height=50></td>
            <td><a href="updateProd.php?id=<?php echo $value['id'] ?>">Modifier</a></td>
            <td><a href="deleteProd.php?id=<?php echo $value['id'] ?>">Supprimer</a></td>
            <td></td>
        </tr>
  <?php  
    }
?>
    </table>

    <h2 class="center-align">Ajouter un nouvel utilisateur</h2>
    <div class="row center-align">
        <div class="col s2"></div>
        <div class="col s8">
            <form action="form-users.php" method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="input-field col s12">
                        <label for="name">Pseudo</label>
                        <input type="text" name="pseudo" class="validate" />
                    </div>

                </div>
                <form class="col s12">
                    <div class="row">
                        <div class="input-field col s12">
                            <label for="name">Mot de passe</label>
                            <input type="password" name="mdp" class="validate" />
                        </div>
                    </div>
                    <button class="btn waves-effect waves-light" type="submit" name="action">Ajouter un utilisateur
                        <i class="material-icons right ">add</i>
                    </button>
                </form>
        </div>
        <div class="col s2"></div>
    </div>
    <footer class="page-footer">
        <div class="footer-copyright">
            <div class="container">
                © 2020 Copyright Text
                <a class="grey-text text-lighten-4 right" href="#!">Créé par Nicolas Gicquel - Arinfo Saint Nazaire</a>
            </div>
        </div>
    </footer>

</body>

</html>