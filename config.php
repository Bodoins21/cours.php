<?php
session_start();
$stmt=null;
$con=null;
   if($_SERVER["REQUEST_METHOD"] =="POST"){  
   $erreurs =[];
// Nous allons mettre nom,prenom,email et mot de passe dans les variables
$nom =$_POST['nom'] ?? '';
$prenom =$_POST['prenom'] ?? '' ;
$email =$_POST['email'] ?? '';
$mot_de_passe =$_POST['mot_de_passe'] ?? '';
if(empty($nom)) {
   $erreurs[] ="Le champ 'nom'est obligatoire.";
}elseif(!preg_match("/^[a-zA-Z-']*$/",$nom)){
$erreurs[] ="Le nom ne doit contenir que des lettres et des espaces.";
}
if(empty($prenom)) {
   $erreurs[] ="Le champ 'prenom'est obligatoire.";
}elseif(!preg_match("/^[a-zA-Z-']*$/",$prenom)){
$erreurs[] ="Le prenom ne doit contenir que des lettres et des espaces.";
}
if(empty($email)) {
   $erreurs[] ="Le champ 'email'est obligatoire.";
}elseif(!filter_var($email,FILTER_VALIDATE_EMAIL)){
$erreurs[] ="L'adresse email n'est pas valide.";
}
if(empty($mot_de_passe)) {
   $erreurs[] ="Le champ 'mot_de_passe'est obligatoire.";
}elseif(strlen($mot_de_passe)<8){
  $erreurs[] = "Le mot de passe doit contenir au moins 8 caractères.";
} elseif (!preg_match("/[A-Z]/", $mot_de_passe)) {
        $erreurs[] = "Le mot de passe doit contenir au moins une lettre majuscule.";
      } elseif (!preg_match("/[a-z]/", $mot_de_passe)) {
        $erreurs[] = "Le mot de passe doit contenir au moins une lettre minuscule.";
   } elseif (!preg_match("/[0-9]/", $mot_de_passe)) {
        $erreurs[] = "Le mot de passe doit contenir au moins un chiffre.";
   }
}
if(isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['email']) && isset($_POST['mot_de_passe'])) {//on verifie ici si l'utilisateur a rentre des informations
 mysqli_report(MYSQLI_REPORT_ERROR, MYSQLI_REPORT_STRICT);  
 $nom_serveur ="Localhost";
$utilisateur ="root";
$mot_de_passe_db ="";
$nom_base_données ="formulaire_d_insription" ;
$con =new mysqli($nom_serveur, $utilisateur, $mot_de_passe, $nom_base_données) ;
 if ($con->connect_error) {
     die("La connexion à la base de données a échoué : " . $con->connect_error);
        }
               // Préparer la requête SQL pour insérer les données (pour éviter les injections SQL)
        $stmt = $con->prepare("INSERT INTO utilisateurs (nom, prenom, email, mot_de_passe) VALUES (?, ?, ?, ?)");
                $stmt->bind_param("ssss", $nom, $prenom, $email, $mot_de_passe); // "ssss" indique 4 chaînes de caractères
                if ($stmt->execute()) {
  echo "<p>Bienvenue</p>" ;
} else {
    // L'insertion a échoué pour une raison liée à la base de données
    echo "Erreur lors de l'inscription. Veuillez réessayer. Erreur: " . $stmt->error;
}

}

?>