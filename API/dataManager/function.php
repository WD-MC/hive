<?php

    require('../include/dbcon.php') ;


            ####################################################---- Gestion des Authentifications ----################################################################
    
    
    function error422($message){
        
        $data =[
            'status' => 422,
            'message' => $message,
        ];
        header("HTTP/1.0 422  Unprocessable Entity");
        echo json_encode($data);
        exit();
    }
    

    // gerer l'authentification des administrateurs
    function connectAdmin($userInput){
        
        session_start();
        global $connect;
        $username = mysqli_real_escape_string($connect, $userInput['username']);
        $password = mysqli_real_escape_string($connect, $userInput['password']);
        $password = md5($password);
        // Récupérer l'utilisateur de la base de données
        $sql = "SELECT * FROM users WHERE username='$username' && mdpasse = '$password' ";
        $result = $connect->query($sql);
        
        if ($result->num_rows > 0) {
            $resulta = mysqli_query($connect,"SELECT rol FROM users WHERE username='$username'");
            $row0 = mysqli_fetch_row($resulta);
            $rol=$row0[0];

            if ($_POST["superadmin"] === "1") {
                if ($rol == "1") {
                    $user_superAdmin = $result->fetch_assoc();
                    // Connexion réussie, enregistrer les informations de l'utilisateur dans la session
                    $_SESSION['user_id'] = $user_superAdmin['id'];
                    $_SESSION['username'] = $user_superAdmin['username'];
                    $_SESSION['nom'] = $user_superAdmin['nom'];
                    $_SESSION['rol'] = $user_superAdmin['rol'];
                    header('Location: ../../app_Administrator/accueil_admin.php');
                    exit;
                }else {
                    $_SESSION['error_message'] = "Accès refusé !";
                    echo $_SESSION['error_message'];
                    header('Location:../../Auth/signin.php');
                    exit;
                }
            }else {
                $user_admin = $result->fetch_assoc();
                // // Connexion réussie, enregistrer les informations de l'utilisateur dans la session
                $_SESSION['user_id'] = $user_admin['id'];
                $_SESSION['username'] = $user_admin['username'];
                $_SESSION['nom'] = $user_admin['nom'];
                $_SESSION['rol'] = $user_admin['rol'];
                
                header('Location: ../../app_Administrator/accueil_admin.php');
                exist;
            }

            
        } else {
            $_SESSION['error_message'] = "Nom d'utilisateur ou mot de passe incorrect!";
            header('Location:../../Auth/signin.php');
            exit;
        }
        // Fermer la connexion à la base de données
        $connect->close();
    }

            ####################################################---- Gestion des Authentifications ----################################################################


            ####################################################---- Create ----################################################################
    
    
    // Save new user
    function saveUser($userInput){
        session_start();
        global $connect;

        $name = mysqli_real_escape_string($connect, $userInput['name']);
        $username = mysqli_real_escape_string($connect, $userInput['username']);
        $password = mysqli_real_escape_string($connect, $userInput['password']);
        $Vpassword = mysqli_real_escape_string($connect, $userInput['Vpassword']);

        if (trim($password) == trim($Vpassword)) {

            $password = md5($password);
            session_start();
            $reg = mysqli_query($connect,"SELECT * FROM users WHERE username='$username' || nom ='$name'");
            $rows = mysqli_num_rows($reg);
            
            if($rows==0){

            #insere les donnees dans la base de donnee
                $query = "INSERT INTO users (nom, username, mdpasse) VALUES ('$name','$username','$password')";
                $result = mysqli_query($connect,$query);
                header("Location: ../../Auth/signin.php"); // Redirige vers la page de connexion
                exit();
            }else {
                $_SESSION['error_message'] = "Ce nom d'utilisateur ou Nom existe déjà!";
                header('Location:../../Auth/signup.php');
                exit;
            }
        }else {
            $_SESSION['error_message'] = "Les mots de passe ne correspondent pas!";
            header('Location:../../Auth/signup.php');
            exit;
        }
    }

    // add document
    function addArchive($userInput){
        session_start();
        global $connect;

        $userId = $_SESSION['user_id'];
        $titreDocument = mysqli_real_escape_string($connect, $userInput['titredocument']);
        $categorie =mysqli_real_escape_string($connect, $userInput['categorie']);
        $commentaire = mysqli_real_escape_string($connect, $userInput['commentaire']);


        if(isset($_FILES['docfichier'])){
            $docfichier_name = $_FILES['docfichier']['name'];
            $docfichier_size = $_FILES['docfichier']['size'];
            $docfichier_tmp = $_FILES['docfichier']['tmp_name'];
            $docfichier_type = $_FILES['docfichier']['type'];
            $docfichier_ext = strtolower(end(explode('.', $_FILES['docfichier']['name'])));

            $extensions = array("pdf", "docx");

            // Vérifier si l'extension de fichier est autorisée
            if(in_array($docfichier_ext, $extensions) === true){

                // Vérifier la taille du fichier
                if($file_size < 104857600){
                    $new_docfichier_name = $userId . "_" . $docfichier_name;
                    if (!empty($docfichier_tmp )) {
                        $destination = "../../API/documents/archives/".$new_docfichier_name;
                        //Déplacer le fichier téléchargé vers le dossier images/profil
                        move_uploaded_file($docfichier_tmp , $destination);
                        // echo($new_docfichier_name);
                        
                    }else{
                        $_SESSION['error_message'] = "Le chemin vers le fichier est absent";
                        header('Location:../../app_Administrator/new_document.php');
                        exit;
                    }
                    // echo ($docfichier_name. $docfichier_size.  $docfichier_tmp. $docfichier_type. $docfichier_ext);
                }
                else {
                    $_SESSION['error_message'] = "Le fichier est trop volumineux. Veuillez sélectionner un fichier de moins de 100 Mo.";
                    header('Location:../../app_Administrator/new_archive.php');
                    exit;
                }
                
            }
            else {
                $_SESSION['error_message'] = "Extension non autorisée. Veuillez sélectionner un fichier pdf ou word";
                header('Location:../../app_Administrator/new_archive.php');
                exit;
            }

        }
        $docfichier_link =  "http://localhost/Hive/API/documents/archives/" . $new_docfichier_name;

        $data = array(
            'titreDocument' => $titreDocument,
            'categorie' => $categorie,
            'descriptions' => $commentaire,
            'fichierArchive' => $docfichier_link,
        );
        $jsonData = json_encode($data);

        $jsonData = mysqli_real_escape_string($connect, $jsonData);
        $id_admin = mysqli_real_escape_string($connect, $userId);


        #insere les donnees dans la base de donnee
        $query = "INSERT INTO archives (titreDocument, categorie,descriptions,fichierArchive,id_admin) VALUES 
        ('$titreDocument','$categorie','$commentaire','$docfichier_link','$userId')";
        $result = mysqli_query($connect,$query);


        $sql = "INSERT INTO historique (nomTable,id_user,valeurPrecedente,valeurActuelle,actions) VALUES 
        ('archives','$id_admin','$jsonData','$jsonData','Création')";
        $resulta = mysqli_query($connect,$sql);

        header("Location: ../../app_Administrator/accueil_admin.php"); 
        
        
        if(!$result){
            $_SESSION['error_message'] = "Erreur lors de l'insertion des données.";
            header('Location:../../app_Administrator/new_archive.php');
            exit;
        }
        if(!$resulta){
            $_SESSION['error_message'] = "Erreur lors de l'insertion des données.";
            header('Location:../../app_Administrator/new_archive.php');
            exit;
        }
    }

    
            ####################################################---- Create ----################################################################


            ####################################################---- Update ----################################################################
    
    // Update user data 
    function updateUser($userInput){
        session_start();
        global $connect;

        $userId = $_SESSION['user_id'];

        if (isset($_POST['profil'])) {
            if(isset($_FILES['docfichier'])){
                $docfichier_name = $_FILES['docfichier']['name'];
                $docfichier_size = $_FILES['docfichier']['size'];
                $docfichier_tmp = $_FILES['docfichier']['tmp_name'];
                $docfichier_type = $_FILES['docfichier']['type'];
                $docfichier_ext = strtolower(end(explode('.', $_FILES['docfichier']['name'])));
            }
            $extensions = array("jpeg","jpg","png");

            // Vérifier si l'extension de fichier est autorisée
            if(in_array($docfichier_ext, $extensions) === true){
                
                // Vérifier la taille du fichier
                if($docfichier_size < 3145728){
                    
                    $new_file_name = $userId . "_" . $docfichier_name;
                    if (!empty($docfichier_tmp )) {
                        $destination = "../../API/documents/profil/".$new_file_name; 
                        //Déplacer le fichier téléchargé vers le dossier images/profil
                        move_uploaded_file($docfichier_tmp , $destination);
                        $img = imagecreatefromjpeg($destination);
                        $new_img = imagecreatetruecolor(315, 315);
                        imagecopyresampled($new_img, $img, 0, 0, 0, 0, 320, 315, imagesx($img), imagesy($img));
                        imagejpeg($new_img, $destination);
                        
                    }else{
                        $_SESSION['error_message'] = "Le chemin vers le fichier est absent";
                        header('Location:../../app_Administrator/profil.php');
                        exit;
                    }
                }else {
                    
                    $_SESSION['error_message'] = "Le fichier est trop volumineux. Veuillez sélectionner un fichier de moins de 5 Mo.";
                    header('Location:../../app_Administrator/profil.php');
                    exit;
                }
            }else {
                $_SESSION['error_message'] = "Extension non autorisée. Veuillez sélectionner un fichier JPG ou PNG.";
                header('Location:../../app_Administrator/profil.php');
                exit;
            }
            
            $image_link = "http://localhost/Hive/API/documents/profil/" . $new_file_name;

            //historisation update de l'image
            $sql = "SELECT * FROM users WHERE id='$userId'";
            $result = $connect->query($sql);
            $row0 = mysqli_fetch_row($result);
            
            $imgProfile=$row0[4];

            if ($rol == "0") {
                $statut = "admin";
            }
            if ($rol == "1") {
                $statut = "Super Admin";
            }
            
            $data = array(
                'imgProfile' => $imgProfile,
            );
            
            $data1 = array(
                'N_imgProfile' => $image_link,
            );

            $jsonData = json_encode($data);
            $jsonData1 = json_encode($data1);

            $jsonData = mysqli_real_escape_string($connect, $jsonData);
            $jsonData1 = mysqli_real_escape_string($connect, $jsonData1);
            $id_admin = mysqli_real_escape_string($connect, $userId);

            $sql1 = "INSERT INTO historique (nomTable,id_user,valeurPrecedente,valeurActuelle,actions) VALUES 
            ('users','$id_admin','$jsonData','$jsonData1','Modification')";
            $result = mysqli_query($connect,$sql1);
            //historisation update de l'image

            // Mettre à jour le lien de l'image dans la table users
            $query = "UPDATE users SET imgProfile='$image_link' WHERE id='$userId'";
            $result = mysqli_query($connect, $query);
            header('Location:Location:../../app_Administrator/profil.php');
            exit;
        }

        if (isset($_POST['information'])) {
            $name = mysqli_real_escape_string($connect, $userInput['name']);
            $username = mysqli_real_escape_string($connect, $userInput['username']);
            if (empty($name) || empty($username) ) {
                $_SESSION['error_message'] = "Veuillez remplir tous les champs!";
                header('Location:../../app_Administrator/profil.php');
                exit;
            }
            $reg = mysqli_query($connect,"SELECT * FROM users WHERE (username='$username' || nom ='$name') && id !='$userId'");
            $rows = mysqli_num_rows($reg);
            
            if($rows==0){
                //historisation update des informations
                $sql = "SELECT * FROM users WHERE id='$userId'";
                $result = $connect->query($sql);
                $row0 = mysqli_fetch_row($result);
                
                $P_username=$row0[1];
                $P_nom=$row0[2];
                
                if ($username != $P_username && $name == $P_nom) {
                    $data = array(
                        'username' => $P_username,
                    );
                    $data1 = array(
                        'N_username' => $username,
                    );
                }elseif ($username==$P_username && $name != $P_nom) {
                    $data = array(
                        'nom' => $P_nom,
                    );
                    $data1 = array(
                        'N_nom' => $name,
                    );
                }elseif ($username!=$P_username && $name != $P_nom) {
                    $data = array(
                        'username' => $P_username,
                        'nom' => $P_nom,
                    );
                    $data1 = array(
                        'N_username' => $username,
                        'N_nom' => $name,
                    );
                }
                $jsonData = json_encode($data);
                $jsonData1 = json_encode($data1);

                $jsonData = mysqli_real_escape_string($connect, $jsonData);
                $jsonData1 = mysqli_real_escape_string($connect, $jsonData1);
                $id_admin = mysqli_real_escape_string($connect, $userId);

                $sql1 = "INSERT INTO historique (nomTable,id_user,valeurPrecedente,valeurActuelle,actions) VALUES 
                ('users','$id_admin','$jsonData','$jsonData1','Modification')";
                $result = mysqli_query($connect,$sql1);
                //historisation update des informations

                $query = "UPDATE users SET username='$username', nom = '$name' WHERE id='$userId'";
                $result = mysqli_query($connect, $query);
                header('Location:Location:../../app_Administrator/profil.php');
                exit;
            }else {
                $_SESSION['error_message'] = "Ce nom d'utilisateur et nom existe déjà!";
                header('Location:../../app_Administrator/profil.php');
                exit;
            }
        }
        if (isset($_POST['securite'])) {
            $aPassword = mysqli_real_escape_string($connect, $userInput['password']);
            $nPassword = mysqli_real_escape_string($connect, $userInput['Npassword']);
            $confPassword = mysqli_real_escape_string($connect, $userInput['Vpassword']);
            
            if (empty($aPassword) || empty($nPassword) || empty($confPassword) ) {
                $_SESSION['error_message'] = "Veuillez remplir tous les champs!";
                header('Location:../../app_Administrator/profil.php');
                exit;
            }

            $aPassword = md5($aPassword);
            $nPassword = md5($nPassword);
            $confPassword = md5($confPassword);
            // Vérifier si le mot de passe est correct
            $userQuery = "SELECT * FROM users WHERE id = $userId";
            $userExistsResult = mysqli_query($connect, $userQuery);
            $user = mysqli_fetch_assoc($userExistsResult);
            $mdpasse = $user['mdpasse'];
            if ($aPassword == $mdpasse) {
                if ($nPassword == $confPassword) {
                    // Mettre à jour le mot de passe dans la table users
                    $query = "UPDATE users SET  mdpasse = '$nPassword'  WHERE id='$userId'";
                    $result = mysqli_query($connect, $query);
                    header('Location:../../app_Administrator/profil.php');
                    exit;
                }
                else {
                    $_SESSION['error_message'] = "Les mots de passe ne correspondent pas!";
                    header('Location:../../app_Administrator/profil.php');
                    exit;
                }
            }else {
                $_SESSION['error_message'] = "L'ancien mot de passe est incorrect";
                header('Location:../../app_Administrator/profil.php');
                exit;
            }
        }
        if (isset($_POST['Deleteprofil'])) {
            
            //historisation update de l'image
            $sql = "SELECT * FROM users WHERE id='$userId'";
            $result = $connect->query($sql);
            $row0 = mysqli_fetch_row($result);
            
            $imgProfile=$row0[4];

            if ($rol == "0") {
                $statut = "admin";
            }
            if ($rol == "1") {
                $statut = "Super Admin";
            }
            
            $data = array(
                'imgProfile' => $imgProfile,
            );
            
            $data1 = array(
                'N_imgProfile' => "",
            );

            $jsonData = json_encode($data);
            $jsonData1 = json_encode($data1);

            $jsonData = mysqli_real_escape_string($connect, $jsonData);
            $jsonData1 = mysqli_real_escape_string($connect, $jsonData1);
            $id_admin = mysqli_real_escape_string($connect, $userId);

            $sql1 = "INSERT INTO historique (nomTable,id_user,valeurPrecedente,valeurActuelle,actions) VALUES 
            ('users','$id_admin','$jsonData','$jsonData1','Suppression')";
            $result = mysqli_query($connect,$sql1);
            //historisation update de l'image

            $query = "UPDATE users SET imgProfile = NULL WHERE id='$userId'";
            $result = mysqli_query($connect, $query);
            header('Location:../../app_Administrator/profil.php');
            exit;
        }
        
        
    }

    // change the status
    function changeStatus($userInput){
        session_start();
        global $connect;

        $userId = $_SESSION['user_id'];
        $id = mysqli_real_escape_string($connect, $userInput['id']);
        $status = mysqli_real_escape_string($connect, $userInput['statut']);
        
        $statusText = "";
        $N_statut = "";

        if ($status === "users-status-active") {
            $statusText = "0";
            $N_statut = "admin";
        } elseif ($status === "users-status-disabled") {
            $statusText = "1";
            $N_statut = "Super Admin";
        }

        
        //historisation mise à jour du status
        $sql = "SELECT * FROM users WHERE id='$id'";
        $result = $connect->query($sql);
        $row0 = mysqli_fetch_row($result);

        $rol=$row0[5];
        $P_status="";

        if ($rol == "0") {
            $P_statut = "admin";
        }
        if ($rol == "1") {
            $P_statut = "Super Admin";
        }

        if ($N_statut != $P_statut) {

            $data = array(
                'statut' => $P_statut,
            );
            
            $data1 = array(
                'N_statut' => $N_statut,
            );
    
            $jsonData = json_encode($data);
            $jsonData1 = json_encode($data1);
    
            $jsonData = mysqli_real_escape_string($connect, $jsonData);
            $jsonData1 = mysqli_real_escape_string($connect, $jsonData1);
            $id_admin = mysqli_real_escape_string($connect, $userId);
    
            $sql1 = "INSERT INTO historique (nomTable,id_user,valeurPrecedente,valeurActuelle,actions) VALUES 
            ('users','$id_admin','$jsonData','$jsonData1','Modification')";
            $result = mysqli_query($connect,$sql1);
            //historisation mise à jour du status
    
            // Mettre à jour du statut dans la table users
            $query = "UPDATE users SET  rol = '$statusText'  WHERE id='$id'";
            $result = mysqli_query($connect, $query);
            header('Location:../../app_Administrator/utilisateur.php');
            exit;
        }else {
            $_SESSION['error_message'] = " cet utilisateur est déjà ".$P_statut;
            header('Location:../../app_Administrator/utilisateur.php');
            exit;
        }
        
        
    }

    //change the archive
    function updateArchive($userInput){
        session_start();
        global $connect;

        $userId = $_SESSION['user_id'];
        $id_Archive = mysqli_real_escape_string($connect, $userInput['archive_id']);

        if (isset($_POST['modifierTitre'])) {
            $titreDocument = mysqli_real_escape_string($connect, $userInput['titreDocument']);
            if (empty($titreDocument)) {
                $_SESSION['error_message'] = "Vous n'avez modifier le titre!";
                header('Location:../../app_Administrator/accueil_admin.php');
                exit;
            }
            //historisation du titreDocument
            $sql = "SELECT * FROM archives WHERE id='$id_Archive'";
            $result = $connect->query($sql);
            $row0 = mysqli_fetch_row($result);

            $titre=$row0[1];

            $data = array(
                'titreDocument' => $titre,
            );
            
            $data1 = array(
                'N_titreDocument' => $titreDocument,
            );

            $jsonData = json_encode($data);
            $jsonData1 = json_encode($data1);

            $jsonData = mysqli_real_escape_string($connect, $jsonData);
            $jsonData1 = mysqli_real_escape_string($connect, $jsonData1);
            $id_admin = mysqli_real_escape_string($connect, $userId);

            $sql1 = "INSERT INTO historique (nomTable,id_user,valeurPrecedente,valeurActuelle,actions) VALUES 
            ('archives','$id_admin','$jsonData','$jsonData1','Modification')";
            $resulta = mysqli_query($connect,$sql1);
            //historisation du titreDocument

            $query = "UPDATE archives SET  titreDocument = '$titreDocument'  WHERE id='$id_Archive'";
            $result = mysqli_query($connect, $query);
            header('Location:../../app_Administrator/accueil_admin.php');
            exit;

        } elseif (isset($_POST['modifierCategorie'])) {

            $categorie =mysqli_real_escape_string($connect, $userInput['categorie']);
            if (empty($categorie)) {
                $_SESSION['error_message'] = "Vous n'avez modifier la categorie!";
                header('Location:../../app_Administrator/accueil_admin.php');
                exit;
            }

            //historisation categorie
            $sql = "SELECT * FROM archives WHERE id='$id_Archive'";
            $result = $connect->query($sql);
            $row0 = mysqli_fetch_row($result);

            $cat=$row0[2];

            $data = array(
                'categorie' => $cat
            );
            $data1 = array(
                'N_categorie' => $categorie,
            );

            $jsonData = json_encode($data);
            $jsonData1 = json_encode($data1);

            echo($jsonData." ".$jsonData1);

            $jsonData = mysqli_real_escape_string($connect, $jsonData);
            $jsonData1 = mysqli_real_escape_string($connect, $jsonData1);
            $id_admin = mysqli_real_escape_string($connect, $userId);

            $sql1 = "INSERT INTO historique (nomTable,id_user,valeurPrecedente,valeurActuelle,actions) VALUES 
            ('archives','$id_admin','$jsonData','$jsonData1','Modification')";
            $resulta = mysqli_query($connect,$sql1);
            //historisation categorie

            $query = "UPDATE archives SET  categorie = '$categorie'  WHERE id='$id_Archive'";
            $result = mysqli_query($connect, $query);
            header('Location:../../app_Administrator/accueil_admin.php');
            exit;

        } elseif (isset($_POST['modifierFichier'])) {

            if(isset($_FILES['docfichier'])){
                $docfichier_name = $_FILES['docfichier']['name'];
                $docfichier_size = $_FILES['docfichier']['size'];
                $docfichier_tmp = $_FILES['docfichier']['tmp_name'];
                $docfichier_type = $_FILES['docfichier']['type'];
                $docfichier_ext = strtolower(end(explode('.', $_FILES['docfichier']['name'])));
                if (empty($docfichier_name)) {
                    $_SESSION['error_message'] = "Vous n'avez modifier le fichier!";
                    header('Location:../../app_Administrator/accueil_admin.php');
                    exit;
                }
                $extensions = array("pdf", "docx");

                // Vérifier si l'extension de fichier est autorisée
                if(in_array($docfichier_ext, $extensions) === true){

                    // Vérifier la taille du fichier
                    if($file_size < 104857600){
                        $new_docfichier_name = $userId . "_" . $docfichier_name;
                        if (!empty($docfichier_tmp )) {
                            $destination = "../../API/documents/archives/".$new_docfichier_name;
                            move_uploaded_file($docfichier_tmp , $destination);
                            
                        }else{
                            $_SESSION['error_message'] = "Le chemin vers le fichier est absent";
                            header('Location:../../app_Administrator/accueil_admin.php');
                            exit;
                        }
                        // echo ($docfichier_name. $docfichier_size.  $docfichier_tmp. $docfichier_type. $docfichier_ext);
                    }
                    else {
                        $_SESSION['error_message'] = "Le fichier est trop volumineux. Veuillez sélectionner un fichier de moins de 100 Mo.";
                        header('Location:../../app_Administrator/accueil_admin.php');
                        exit;
                    }
                    
                }
                else {
                    $_SESSION['error_message'] = "Extension non autorisée. Veuillez sélectionner un fichier pdf ou word";
                    header('Location:../../app_Administrator/accueil_admin.php');
                    exit;
                }
                
                $docfichier_link =  "http://localhost/Hive/API/documents/archives/" . $new_docfichier_name;

                //historisation fichier
                $sql = "SELECT * FROM archives WHERE id='$id_Archive'";
                $result = $connect->query($sql);
                $row0 = mysqli_fetch_row($result);

                $fichier=$row0[4];

                $data = array(
                    'fichierArchive' => $fichier,
                );
                
                $data1 = array(
                    'N_fichierArchive' => $docfichier_link,
                );

                $jsonData = json_encode($data);
                $jsonData1 = json_encode($data1);

                $jsonData = mysqli_real_escape_string($connect, $jsonData);
                $jsonData1 = mysqli_real_escape_string($connect, $jsonData1);
                $id_admin = mysqli_real_escape_string($connect, $userId);

                $sql1 = "INSERT INTO historique (nomTable,id_user,valeurPrecedente,valeurActuelle,actions) VALUES 
                ('archives','$id_admin','$jsonData','$jsonData1','Modification')";
                $resulta = mysqli_query($connect,$sql1);
                //historisation fichier

                $query = "UPDATE archives SET  fichierArchive = '$docfichier_link'  WHERE id='$id_Archive'";
                $result = mysqli_query($connect, $query);
                header('Location:../../app_Administrator/accueil_admin.php');
                exit;
            }

        } elseif (isset($_POST['modifierCommentaire'])) {

            $commentaire = mysqli_real_escape_string($connect, $userInput['commentaire']);
            if (empty($commentaire)) {
                $_SESSION['error_message'] = "Vous n'avez modifier le commentaire!";
                header('Location:../../app_Administrator/accueil_admin.php');
                exit;
            }

            //historisation commentaire
            $sql = "SELECT * FROM archives WHERE id='$id_Archive'";
            $result = $connect->query($sql);
            $row0 = mysqli_fetch_row($result);

            $comment=$row0[3];

            $data = array(
                'descriptions' => $comment,
            );
            
            $data1 = array(
                'N_descriptions' => $commentaire,
            );

            $jsonData = json_encode($data);
            $jsonData1 = json_encode($data1);

            $jsonData = mysqli_real_escape_string($connect, $jsonData);
            $jsonData1 = mysqli_real_escape_string($connect, $jsonData1);
            $id_admin = mysqli_real_escape_string($connect, $userId);

            $sql1 = "INSERT INTO historique (nomTable,id_user,valeurPrecedente,valeurActuelle,actions) VALUES 
            ('archives','$id_admin','$jsonData','$jsonData1','Modification')";
            $resulta = mysqli_query($connect,$sql1);
            //historisation commentaire

            $query = "UPDATE archives SET  descriptions = '$commentaire'  WHERE id='$id_Archive'";
            $result = mysqli_query($connect, $query);
            header('Location:../../app_Administrator/accueil_admin.php');
            exit;
            
        }
        
    }

            ####################################################---- Update ----################################################################


            ####################################################---- Delete ----################################################################


    function Delete($userInput){
        session_start();
        global $connect;

        $userId = $_SESSION['user_id'];

        if (isset($_POST['deleteArchive'])) {
            $id_Archive = mysqli_real_escape_string($connect, $userInput['id']);

            $sql = "SELECT * FROM archives WHERE id='$id_Archive'";
            $result = $connect->query($sql);
            $row0 = mysqli_fetch_row($result);
            
            $titreDocument=$row0[1];
            $categorie=$row0[2];
            $descriptions=$row0[3];
            $fichierArchive=$row0[4];
            $dateSauvegarde=$row0[5];
            $id_admin=$row0[6];
            
            $data = array(
                'titreDocument' => $titreDocument,
                'categorie' => $categorie,
                'descriptions' => $descriptions,
                'fichierArchive' => $fichierArchive,
                'dateSauvegarde' => $dateSauvegarde,
            );
            $jsonData = json_encode($data);

            $jsonData = mysqli_real_escape_string($connect, $jsonData);
            $id_admin = mysqli_real_escape_string($connect, $id_admin);

            $query = "INSERT INTO corbeille (deleteArchive,id_admin) VALUES 
            ('$jsonData','$id_admin')";
            $result = mysqli_query($connect,$query);

            $query = " DELETE FROM  archives WHERE id='$id_Archive'";
            $result = mysqli_query($connect, $query);
            header('Location:../../app_Administrator/accueil_admin.php');
            exit;

            // $query = " DELETE FROM  archives WHERE id='$id_Archive'";
            // $result = mysqli_query($connect, $query);

            // $queryInsert = " DELETE FROM  archives WHERE id='$id_Archive'";
            // $result = mysqli_query($connect, $queryInsert);
            // header('Location:../../app_Administrator/accueil_admin.php');
            // exit;
        }
    }
            ####################################################---- Delete ----################################################################



?>