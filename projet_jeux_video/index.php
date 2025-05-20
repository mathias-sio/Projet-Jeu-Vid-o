<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Gestion des Utilisateurs</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-image: url('image/image_technicien.jpg');
      background-size: cover;
      background-repeat: no-repeat;
      background-position: center;
      background-attachment: fixed;
      padding: 30px;
      margin: 0;
      min-height: 100vh;
      text-align: center;
    }
    h1 {
      color: red;
    }
    h2 {
      color: red;
    }
    .menu {
      display: flex;
      justify-content: center;
      gap: 20px;
      flex-wrap: wrap;
      margin-top: 40px;
    }
    .menu a {
      display: inline-block;
      padding: 15px 25px;
      background-color:blue;
      color: white;
      text-decoration: none;
      border-radius: 8px;
      transition: background-color 0.3s ease;
    }
    .menu a:hover {
      background-color: #2980b9;
    }

    .section {
      background-color: rgba(255, 255, 255, 0.85);
      padding: 20px;
      border-radius: 10px;
      width: 60%;
      margin: 50px auto;
    }
  </style>
</head>
<body>
  <h1> Bienvenue dans mon projet de jeux video </h1>
  <div class= class>
    <a href="../../projet_jeux_video/image/image_technicien.jpg">Voir l'image</a>
  </div>
  <h1>Bienvenue dans le module Utilisateur </h1>
  <div class=section>
     <h2>Espace utilisateur </h2>
     <div class="menu">
       <a href="utilisateur/formulaire.php">Formulaire de demande d'assistance aux techniciens </a>
     </div>
  </div>
  <div class=section style="background-image: url('image/image_technicien.jpg'); background-size: cover; background-repeat: no-repeat; padding: 20px;">
   <h1>Bienvenue dans le module Technicien </h1>
   <h2>Espace technicien </h2>
     <div class="menu">
       <a href="technician/acceuil.php">rechercher un tickets </a>
       <a href="technician/ajouter_technicien.php">ajouter un compte technicien </a>
       <a href="technician/admin_tickets.php">changer le statut d'un ticket </a>
       <a href="technician/login.php">Connectes toi ici pour voir les ticktes </a>
       <a href="technician/consulter_ticket.php">Modifier un ticket </a>
     </div>
  </div>



</body>
</html>
