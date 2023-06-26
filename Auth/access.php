<?php

    function is_admin(){
        if ($_SESSION['rol'] == 0 || $_SESSION['rol'] == 1) {
            return true;
        }
        else {
            return false;
        }
    }

    function is_superAdmin(){
        if ($_SESSION['rol'] == 1) {
            return true;
        }
        else {
            return false;
        }
    }



?>