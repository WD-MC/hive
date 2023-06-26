
<?php
    // fichier qui permet de traiter les demandes qui seront reçu via l'url 
    require_once("dataManager/read.php");

    try{
        if(!empty($_GET['demande'])){
            //decompose l'url et recupere la demande a traite
            $url = explode("/", filter_var($_GET['demande'],FILTER_SANITIZE_URL));
            
            //verifie si la demande est celle souhaitee
            switch ($url[0]) {
                
                case 'archives': 
                    
                    if (empty($url[1])) {
                        getArchive();
                    }else {
                        getArchiveByValeur($url[1]);
                    }
                break;

                case 'utilisateurs': 
                    if (empty($url[1])) {
                        getUtilisateur();
                    }else {
                        getUtilisateurById($url[1]);
                    }
                break;

                case 'corbeille':
                    getCorbeille();
                break;

                case 'historique': 
                    if (empty($url[2])) {
                        getHistorique($url[1]);
                    }else {
                        getHistoriqueByValeur($url[2]);
                    }
            
                break;

                case 'notifications':
                    getNotificationByID($url[1]);
                break;    
                default:
                    throw new Exception("La demande n'est pas valide verifier l'url");
                    
                break;
            }
        }else {
            throw new Exception("Probleme de recuperation de donnees");
            
        }
    } catch (Exception $e) {
        $erreur = [
            "message" => $e->getMessage(),
            "code" => $e->getCode()
        ];
        print_r($erreur);
    }
        