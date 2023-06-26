<?php

    // define("URL", str_replace("route.php","",(isset($_SERVER['HTTPS'])? "https" : "http").
    // "://".$_SERVER['HTTP_HOST'].$_SERVER["PHP_SELF"]));

    require('include/dbcon.php') ;

    
    function sendJSON($infos){
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json");
        echo json_encode($infos, JSON_UNESCAPED_UNICODE);
    } 


            ####################################################---- Gestion des archives ----################################################################
    // recupère tous les archives
    function getArchive(){
        global $connect;

        
        $query = "SELECT  a.id, a.titreDocument, a.categorie, a.descriptions, a.fichierArchive, a.dateSauvegarde,u.id as id_admin, u.nom
        from archives a inner join users u on a.id_admin = u.id";
        $result = mysqli_query($connect, $query);
        

        if ($result) {
            if (mysqli_num_rows($result) > 0) {
                $res = mysqli_fetch_all($result, MYSQLI_ASSOC);
                sendJSON($res);
                // $data =[
                //     'status' => 200,
                //     'message' => 'utilisateur trouvé avec succès',
                //     'data' => $res,
                // ];
                // header("HTTP/1.0 200  utilisateur trouvé avec succès");
                // return json_encode($data);
            }else {
                $data =[
                    'status' => 404,
                    'message' => 'Aucun utilisateur trouvé',
                ];
                header("HTTP/1.0 404  Aucun utilisateur trouvé");
                sendJSON($data);
            }
        }else {
            $data =[
                'status' => 500,
                'message' => 'Internal Server Error',
            ];
            header("HTTP/1.0 500  Internal Server Error");
            sendJSON($data);;
        }
    }

    // recherche tous les archives par une valeur (archives/nomValeurARecherhé_nomValeur)
    function getArchiveByValeur($categorie){
        global $connect;

         // extraction du type de la valeur passée en paramètre
        $underscore_pos = strpos($categorie, '_');
        $type = substr($categorie, 0, $underscore_pos);

        // traitement en fonction du type
        if ($type === 'categorie') {
            // recherche par categorie
            $categorie_value = substr($categorie, $underscore_pos + 1);
            $query = "SELECT  a.id, a.titreDocument, a.categorie, a.descriptions, a.fichierArchive, a.dateSauvegarde,u.id as id_admin, u.nom
            from archives a inner join users u on a.id_admin = u.id WHERE categorie='$categorie_value'";
            $result = mysqli_query($connect, $query);
        } else if ($type === 'id') {
            // recherche par id d'une archive
            $id_value = substr($categorie, $underscore_pos + 1);
            $query = "SELECT titreDocument, categorie, descriptions, fichierArchive FROM archives WHERE id='$id_value'";
            $result = mysqli_query($connect, $query);
        }else if ($type === 'lieu') {
            // recherche par lieu
            $lieu_value = substr($categorie, $underscore_pos + 1);
            $query = "SELECT * FROM archives WHERE lieu='$lieu_value'";
            $result = mysqli_query($connect, $query);
        }else if ($type === 'contrat') {
            // recherche par type de poste
            $contrat_value = substr($categorie, $underscore_pos + 1);
            $query = "SELECT * FROM archives WHERE typePoste='$contrat_value'";
            $result = mysqli_query($connect, $query);
        }
        // $query = "SELECT * FROM offres WHERE parcours='$parcours'";
        // $result = mysqli_query($connect, $query);

        if ($result) {
            if (mysqli_num_rows($result) > 0) {
                $res = mysqli_fetch_all($result, MYSQLI_ASSOC);
                sendJSON($res);
            }else {
                $data =[
                    'status' => 404,
                    'message' => 'Aucune donnée trouvé',
                ];
                header("HTTP/1.0 404  Aucune donnée trouvé");
                sendJSON($data);
            }
        }else {
            $data =[
                'status' => 500,
                'message' => 'Internal Server Error',
            ];
            header("HTTP/1.0 500  Internal Server Error");
            sendJSON($data);
        }
    }

            ####################################################---- Gestion des archives ----################################################################

            ####################################################---- Gestion des Utilisateurs ----################################################################
    // recupère tous les utilisateurs
    function getUtilisateur(){
        global $connect;

        $query = "SELECT id, username, nom, imgProfile, rol FROM users";
        $result = mysqli_query($connect, $query);

        if ($result) {
            if (mysqli_num_rows($result) > 0) {
                $res = mysqli_fetch_all($result, MYSQLI_ASSOC);
                foreach ($res as &$row) {
                    if ($row['rol'] == 0) {
                        $row['rol'] = "admin";
                    } elseif ($row['rol'] == 1) {
                        $row['rol'] = "superAdmin";
                    }
                }
                sendJSON($res);
                // $data =[
                //     'status' => 200,
                //     'message' => 'utilisateur trouvé avec succès',
                //     'data' => $res,
                // ];
                // header("HTTP/1.0 200  utilisateur trouvé avec succès");
                // return json_encode($data);
            }else {
                $data =[
                    'status' => 404,
                    'message' => 'Aucun utilisateurs trouvé',
                ];
                header("HTTP/1.0 404  Aucun utilisateurs trouvé");
                sendJSON($data);
                // return json_encode($data);
            }
        }else {
            $data =[
                'status' => 500,
                'message' => 'Internal Server Error',
            ];
            header("HTTP/1.0 500  Internal Server Error");
            sendJSON($data);
        }
    }


    function getUtilisateurById($id){
        global $connect;

        $query = "SELECT * FROM users WHERE id='$id'";
        $result = mysqli_query($connect, $query);

        if ($result) {
            if (mysqli_num_rows($result) > 0) {
                $res = mysqli_fetch_all($result, MYSQLI_ASSOC);
                sendJSON($res);
            }else {
                $data =[
                    'status' => 404,
                    'message' => 'Aucun utilisateur trouvé',
                ];
                header("HTTP/1.0 404  Aucun utilisateur trouvé");
                sendJSON($data);
            }
        }else {
            $data =[
                'status' => 500,
                'message' => 'Internal Server Error',
            ];
            header("HTTP/1.0 500  Internal Server Error");
            sendJSON($data);
        }
    }

            ####################################################---- Gestion des utilisateurs ----################################################################

            
            ####################################################---- Gestion de la corbeille ----################################################################

    function getCorbeille(){

        global $connect;

        // recupère les données de la corbeille par jointure à la table users
        $query = "SELECT 
        c.id, c.deleteArchive, c.dateSuppression, u.nom
        from corbeille c 
        inner join users u on c.id_admin = u.id";

        $result = mysqli_query($connect, $query);

        if ($result) {
            if (mysqli_num_rows($result) > 0) {
                $res = mysqli_fetch_all($result, MYSQLI_ASSOC);
                sendJSON($res);
            }else {
                $data =[
                    'status' => 404,
                    'message' => 'Aucune souscription trouvée',
                ];
                header("HTTP/1.0 404  Aucune souscription trouvée");
                sendJSON($data);
            }
        }else {
            $data =[
                'status' => 500,
                'message' => 'Internal Server Error',
            ];
            header("HTTP/1.0 500  Internal Server Error");
            sendJSON($data);
        }
    }

            ####################################################---- Gestion de la corbeille ----################################################################


            ####################################################---- Gestion de l'historique ----################################################################


    function getHistorique($categorie){

        global $connect;

        // $underscore_pos = strpos($categorie, '_');
        // $type = substr($categorie, 0, $underscore_pos);

        if ($categorie === 'archives') {
            // recherche par archives
            // $categorie_value = substr($categorie, $underscore_pos + 1);
            $query = "SELECT  h.id, h.valeurPrecedente, h.valeurActuelle, h.dateModification, u.nom
            from historique h inner join users u on h.id_user = u.id WHERE nomTable='$categorie'";
            $result = mysqli_query($connect, $query);
        } else if ($categorie === 'users') {
            
            // $categorie_value = substr($categorie, $underscore_pos + 1);
            $query = "SELECT  h.id, h.valeurPrecedente, h.valeurActuelle, h.dateModification, u.nom
            from historique h inner join users u on h.id_user = u.id WHERE nomTable='$categorie'";
            $result = mysqli_query($connect, $query);
        }

        if ($result) {
            if (mysqli_num_rows($result) > 0) {
                $res = mysqli_fetch_all($result, MYSQLI_ASSOC);
                sendJSON($res);
            }else {
                $data =[
                    'status' => 404,
                    'message' => 'Aucune souscription trouvée',
                ];
                header("HTTP/1.0 404  Aucune souscription trouvée");
                sendJSON($data);
            }
        }else {
            $data =[
                'status' => 500,
                'message' => 'Internal Server Error',
            ];
            header("HTTP/1.0 500  Internal Server Error");
            sendJSON($data);
        }
    }

    function getHistoriqueByValeur($categorie){
        global $connect;

         // extraction du type de la valeur passée en paramètre
        // $underscore_pos = strpos($categorie, '_');
        // $type = substr($categorie, 0, $underscore_pos);

        // traitement en fonction du type
        if ($categorie === 'Modification') {
            // recherche par categorie
            // $categorie_value = substr($categorie, $underscore_pos + 1);
            $query = "SELECT  h.id, h.valeurPrecedente, h.valeurActuelle, h.dateModification, u.nom
            from historique h inner join users u on a.id_users = u.id WHERE actions='$categorie'";
            $result = mysqli_query($connect, $query);
        } else if ($type === 'Création') {
            // recherche par id d'une archive
            $id_value = substr($categorie, $underscore_pos + 1);
            $query = "SELECT titreDocument, categorie, descriptions, fichierArchive FROM archives WHERE id='$id_value'";
            $result = mysqli_query($connect, $query);
        }else if ($type === 'Suppression') {
            // recherche par lieu
            $lieu_value = substr($categorie, $underscore_pos + 1);
            $query = "SELECT * FROM archives WHERE lieu='$lieu_value'";
            $result = mysqli_query($connect, $query);
        }else if ($type === 'contrat') {
            // recherche par type de poste
            $contrat_value = substr($categorie, $underscore_pos + 1);
            $query = "SELECT * FROM archives WHERE typePoste='$contrat_value'";
            $result = mysqli_query($connect, $query);
        }
        // $query = "SELECT * FROM offres WHERE parcours='$parcours'";
        // $result = mysqli_query($connect, $query);

        if ($result) {
            if (mysqli_num_rows($result) > 0) {
                $res = mysqli_fetch_all($result, MYSQLI_ASSOC);
                sendJSON($res);
            }else {
                $data =[
                    'status' => 404,
                    'message' => 'Aucune donnée trouvé',
                ];
                header("HTTP/1.0 404  Aucune donnée trouvé");
                sendJSON($data);
            }
        }else {
            $data =[
                'status' => 500,
                'message' => 'Internal Server Error',
            ];
            header("HTTP/1.0 500  Internal Server Error");
            sendJSON($data);
        }
    }

    function getSouscription(){

        global $connect;

        // recupère les donnée des offre et etudiants par jointure à la table offre
        $query = "SELECT 
        s.id, s.id_offre, s.id_etudiant, o.titreOffre, o.nomStructure, o.imageJob, u.nom
        from souscriptions s 
        inner join offres o on s.id_offre = o.id 
        inner join users u on s.id_etudiant = u.id";

        $result = mysqli_query($connect, $query);

        if ($result) {
            if (mysqli_num_rows($result) > 0) {
                $res = mysqli_fetch_all($result, MYSQLI_ASSOC);
                sendJSON($res);
            }else {
                $data =[
                    'status' => 404,
                    'message' => 'Aucune souscription trouvée',
                ];
                header("HTTP/1.0 404  Aucune souscription trouvée");
                sendJSON($data);
            }
        }else {
            $data =[
                'status' => 500,
                'message' => 'Internal Server Error',
            ];
            header("HTTP/1.0 500  Internal Server Error");
            sendJSON($data);
        }
    }
    
    function getSouscriptionByID($id){
        global $connect;

        $query = "SELECT 
        s.id, s.id_offre, s.id_etudiant, s.responseMessage, o.titreOffre, o.nomStructure, o.imageJob 
        from souscriptions s inner join offres o on s.id_offre = o.id WHERE id_etudiant='$id'";
        $result = mysqli_query($connect, $query);
        if ($result) {
            if (mysqli_num_rows($result) > 0) {
                $res = mysqli_fetch_all($result, MYSQLI_ASSOC);
                sendJSON($res);
            }
            // else {
            //     $data =[
            //         'status' => 404,
            //         'message' => 'Aucun utilisateur trouvé',
            //     ];
            //     header("HTTP/1.0 404  Aucun utilisateur trouvé");
            //     sendJSON($data);
            // }
        }else {
            $data =[
                'status' => 500,
                'message' => 'Internal Server Error',
            ];
            header("HTTP/1.0 500  Internal Server Error");
            sendJSON($data);
        }
    }

            ####################################################---- Gestion de l'historique ----################################################################



            ####################################################---- Gestion des notifications ----################################################################
    
    function getNotificationByID($id){
        global $connect;

        $query = "SELECT s.responseMessage, o.titreOffre, o.imageJob
        from souscriptions s 
        inner join offres o on s.id_offre = o.id
        WHERE id_etudiant='$id'";
        $result = mysqli_query($connect, $query);
        if ($result) {
            if (mysqli_num_rows($result) > 0) {
                $res = mysqli_fetch_all($result, MYSQLI_ASSOC);
                sendJSON($res);
            }
        }else {
            $data =[
                'status' => 500,
                'message' => 'Internal Server Error',
            ];
            header("HTTP/1.0 500  Internal Server Error");
            sendJSON($data);
        }
    }


            ####################################################---- Gestion des notifications ----################################################################

            // $underscore_pos = strpos($categorie, '_');
            // $type = substr($categorie, 0, $underscore_pos);
    
            // if ($type === 'archives') {
            //     // recherche par archives
            //     $categorie_value = substr($categorie, $underscore_pos + 1);
            //     $query = "SELECT  h.id, h.valeurPrecente, h.valeurActuelle, h.dateModification, u.nom
            //     from historique h inner join users u on h.id_user = u.id WHERE nomTable='$categorie_value'";
            //     $result = mysqli_query($connect, $query);
            // } else if ($type === 'users') {
                
            //     $categorie_value = substr($categorie, $underscore_pos + 1);
            //     $query = "SELECT  h.id, h.valeurPrecente, h.valeurActuelle, h.dateModification, u.nom
            //     from historique h inner join users u on h.id_user = u.id WHERE nomTable='$categorie_value'";
            //     $result = mysqli_query($connect, $query);
            // }


?>