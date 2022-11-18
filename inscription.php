<?php

//###### ETAPE 1- Inclusion de init.php
require_once "inc/init.php";

//######### ETAPE 2 - traitement des donnés du formulaire
 // je vérifie si le formulaire a été validé. s'il a été validé je peux traiter les données.
 // ATTENTION je ne peux pas traiter les données si le formulaire n'a pas été envoyé.
if ( !empty($_POST)){
    
    debug($_POST);
    // ETAPE de vérification des données
    
        if (empty($_POST['username'])) {
            $errorMessage = "Merci d'indiquer un Pseudo <br>";
        }
            // strlen()permet de récupérer la longueur d'une chaine de caractère. Attention les caractères spéciaux compte 2. exemple éé a pour 4 caractères 
            //iconv-strlen () permet de résoudre ce problème . chaque caractère comptera comme l exemple : éé comptera pour 2 caractère
            if (iconv_strlen(trim($_POST['username'])) < 3 || iconv_strlen( trim($_POST['username'])) > 20) {
                $errorMessage = "Le Pseudo doit contenir entre 3 et 20 caractères <br>";
                
            }
            if (empty($_POST['password']) || iconv_strlen(trim($_POST['password'])) < 8) {
                $errorMessage .= "Merci d'indiquer un mot de passe de minimum 8 caractères <br>";
            }

            if (empty($_POST['lastname']) || iconv_strlen(trim($_POST['lastname'])) > 70) {
                    $errorMessage .= "Merci d'indiquer un mot de passe de minimum 70 caractères <br>";
                }

            if (empty($_POST['firstname']) || iconv_strlen(trim($_POST['firstname'])) > 70) {
                        $errorMessage .= "Merci d'indiquer un mot de passe de minimum 70 caractères <br>"; 
            }

            if (empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) ) {
                $errorMessage .= "L'email n'est pas valider <br>"; 
            }



        
    //FIN de vérification des données
    //ETAPE de sécurisation des données
    //$_POST['username'] = htmlspecialchars($_POST['username']);
    foreach ($_POST as $key => $value) {
        $_POST[$key] = htmlspecialchars($value);
    }
    //FIN de sécurisation ddes données
    //ETAPE envoi des données
        if (empty($errorMessage)) {
        $requete = $bdd->prepare("INSERT INTO membre VALUES (NULL, :username, :password, :lastname, :firstname, :email, :status)");
        $success = $requete->execute([
            ":username" => $_POST['username'],
            ":password" => password_hash($_POST['password'], PASSWORD_DEFAULT), // la fonction password_hash permet de hasher un mdp. on doit lui indiqueren paramètre le type d'algorythme que l'on souhaite utiliser. ici on prend l'algorythme par défaut
            ":lastname" => $_POST['lastname'],
            ":firstname" => $_POST['firstname'],
            ":email" => $_POST['email'],
            ":status" => "user"
        ]);

        if ($success) {
            $successMessage = "Message envoyer";

            header("location:connexion.php");
            exit;
        } else {
            $errorMessage = "Message non envoyer";
        }

        }
    // FIN envoie des données
}

require_once "inc/header.php";
?>


            <h1 class="text-center">Inscription</h1>

        <?php if (!empty($successMessage)) { ?>
            <div class="alert alert-success col-md-6 text-center mx-auto">
                <?php echo $successMessage ?>
            </div>
        <?php } ?>

        <?php if (!empty($errorMessage)) { ?>
            <div class="alert alert-danger col-md-6 text-center mx-auto">
                <?php echo $errorMessage ?>
            </div>
        <?php } ?>




            

<form action="" method="post" class="col-md-6 mx-auto">

        <label for="username" class="form-label">Pseudo</label>
        <input 
        type="text" 
            name="username" 
            id="username" 
            class="form-control" 
            value="<?= $_POST['username'] ?? "" ?>"
        >
        <!-- si $_POST['username'] existe alors j affiche sa valeur SINON j affiche une chaine de caractère vide
        on utilise ici l operateur NULL COALESCENT -->
        <div class="invalid-feedback"></div>

        <label for="password" class="form-label">Mot de Passe</label>
        <input 
        type="password" 
            name="password" 
            id="password" 
            class="form-control" 
        >
        <div class="invalid-feedback"></div>

        <label for="lastname" class="form-label">Nom</label>
        <input 
            type="text" 
            name="lastname" 
            id="lastname" 
            class="form-control"
            value="<?= $_POST['lastname'] ?? "" ?>"
        >
        <div class="invalid-feedback"></div>

        <label for="firstname" class="form-label">Prénom</label>
        <input 
        type="text" 
            name="firstname" 
            id="firstname" 
            class="form-control"
            value="<?= $_POST['firstname'] ?? "" ?>"
        >
        <div class="invalid-feedback"></div>

        <label for="email" class="form-label">Email</label>
        <input 
        type="email" 
            name="email" 
            id="email" 
            class="form-control"
            value="<?= $_POST['email'] ?? "" ?>"
        >
        <div class="invalid-feedback"></div>

        <button class="btn btn-success d-block mx-auto mt-3">S'inscrire</button>

    </form>

    <?php
    require_once "inc/footer.php"; ?>