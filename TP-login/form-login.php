<?php 
try{
    $pdo = new PDO('mysql:host=localhost;dbname=tplogin;port=3308','root','',
    array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
    
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


//  Récupération de l'utilisateur et de son pass hashé

$pseudo = $_POST['pseudo'];

$sql = $pdo->prepare('SELECT id, mdp FROM users WHERE pseudo = :pseudo');
$sql->execute(array(
    'pseudo' => $pseudo));
$resultat = $sql->fetch();
var_dump($resultat);

// Comparaison du pass envoyé via le formulaire avec la base
$isPasswordCorrect = password_verify($_POST['mdp'], $resultat['mdp']);

if (!$resultat)
{
    echo 'Mauvais identifiant ou mot de passe !';
}
else
{
    if ($isPasswordCorrect) {
        session_start();
        $_SESSION['id'] = $resultat['id'];
        $_SESSION['pseudo'] = $pseudo;
        echo 'Vous êtes connecté !';
    }
    else {
        echo 'Mauvais identifiant ou mot de passe !';
    }
}



}catch(PDOException $e){
    echo "Erreur : " . $e->getMessage();
}

echo $_SESSION['pseudo'];


