<!DOCTYPE html>
<html lang="fr">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>inscription a la bdd</title>
</head>

<body>
   <?php
   $serveur = "localhost";
   $login = "root";
   $mdp = "";

   try {
      $connexion = new PDO("mysql:host=$serveur;port=3306;dbname=dragon;charset=utf8", $login, $mdp);
      $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $connexion->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
      echo "Connexion réussie à la base de données.";
   } catch (PDOException $e) {
      echo "Erreur de connexion : " . $e->getMessage();
   }
   ?>
   <h1>Formulaire D'inscription</h1>
   <form method="post" action="">
      <label for="nom">Nom :</label>
      <input type="text" id="nom" name="nom" placeholder="Nom" required>

      <label for="prenom">Prénom :</label>
      <input type="text" id="prenom" name="prenom" placeholder="Prénom" required>

      <label for="email">Email :</label>
      <input type="email" id="email" name="email" placeholder="Email" required>

      <label for="pass">Mot de passe :</label>
      <input type="password" id="pass" name="pass" placeholder="Mot de passe" required>

      <input type="submit" value="S'inscrire" name="to">
   </form>
   <?php
   if (isset($_POST['to'])) {
      $nom = $_POST['nom'];
      $prenom = $_POST['prenom'];
      $email = $_POST['email'];
      $pass = $_POST['pass'];


      $pass_hache = password_hash($pass, PASSWORD_DEFAULT);


      $token = bin2hex(random_bytes(16));


      $requete = $connexion->prepare("INSERT INTO ball (nom, prenom, email, pass, token) VALUES (:nom, :prenom, :email, :pass, :token)");
      $success = $requete->execute(array(
         ':nom' => $nom,
         ':prenom' => $prenom,
         ':email' => $email,
         ':pass' => $pass_hache,
         ':token' => $token
      ));

      if ($success) {
         echo "Inscription réussie.";
      } else {
         echo "Erreur lors de l'inscription.";
      }
   }


   ?>
</body>

</html>