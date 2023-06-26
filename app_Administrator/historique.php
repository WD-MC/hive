<?php 
  session_start();
  require('../Auth/access.php');
  if (isset($_SESSION['user_id'])){
    if (is_admin()) {
      // $username = $_SESSION['username'];
      $id = $_SESSION['user_id'];
      $users = json_decode(file_get_contents("http://localhost/Hive/API/utilisateurs/".$id));
      if (!$users) {
          http_response_code(404);
          include('../../Erreur_serveur/erreur_404.html');
          exit();
      }
      // if (isset($_GET['parcours']) && !empty($_GET['parcours'])){
      //   $offres = json_decode(@file_get_contents("http://localhost/Hive/API/offres/parcours_".$_GET['parcours']));
        
      //   if (!$offres) {
      //     http_response_code(404);
      //     include('../Erreur_serveur/erreur_404.html');
      //     exit();
      //   }
      // }
      // else {
      //   $offres = json_decode(file_get_contents("http://localhost/BE_TWF/API/offres"));
        
      //   if (!$offres) {
      //     http_response_code(404);
      //     include('../Erreur_serveur/erreur_404.html');
      //     exit();
      //   }
      // }
    }
    else {
      header('Location: signin.php');
    }

      
  }else {
    // Rediriger l'utilisateur vers la page de connexion
    header('Location: ../app_Administrator/signin.php');
    exit();
  }

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
      rel="shortcut icon"
      href="assets/images/logo2.png"
      type="image/x-icon"
    />
    <title>Historique | Hive</title>

    <!-- ========== All CSS files linkup ========= -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="assets/css/lineicons.css" />
    <link rel="stylesheet" href="assets/css/materialdesignicons.min.css" />
    <link rel="stylesheet" href="assets/css/fullcalendar.css" />
    <link rel="stylesheet" href="assets/css/main.css" />
    <link rel="stylesheet" href="assets/css/historique.css" />
    <link rel="stylesheet" href="../../Hive/app_Administrator/assets/css/font-awesome-4.7.0/css/font-awesome.css">

  </head>
  <body>
    <!-- ======== sidebar-nav start =========== -->
    <aside class="sidebar-nav-wrapper">
      <div class="navbar-logo">
        <a href="accueil_admin.php">
          <img src= 'assets/images/logo2.png' alt='logo' style=" height: 150px;">
        </a>
      </div>
      <nav class="sidebar-nav">
        <ul>
          <li class="nav-item nav-item-has-children">
            <a
              href="#0"
              class="collapsed"
              data-bs-toggle="collapse"
              data-bs-target="#ddmenu_1"
              aria-controls="ddmenu_1"
              aria-expanded="false"
              aria-label="Toggle navigation"
            >
              <span class="icon">
                <svg width="22" height="22" viewBox="0 0 22 22">
                  <path
                    d="M17.4167 4.58333V6.41667H13.75V4.58333H17.4167ZM8.25 4.58333V10.0833H4.58333V4.58333H8.25ZM17.4167 11.9167V17.4167H13.75V11.9167H17.4167ZM8.25 15.5833V17.4167H4.58333V15.5833H8.25ZM19.25 2.75H11.9167V8.25H19.25V2.75ZM10.0833 2.75H2.75V11.9167H10.0833V2.75ZM19.25 10.0833H11.9167V19.25H19.25V10.0833ZM10.0833 13.75H2.75V19.25H10.0833V13.75Z"
                  />
                </svg>
              </span>
              <span class="text">Dashboard</span>
            </a>
            <ul id="ddmenu_1" class="collapse show dropdown-nav">
              <li>
                <a href="accueil_admin.php">Hive Books </a>
              </li>
              <li>
                <a href="new_archive.php"> Créer une archive </a>
              </li>
            </ul>
          </li>

          <span class="divider"><hr /></span>
          <?php
            if (is_superAdmin()) {
              echo("
                <li class='nav-item'>
                  <a 
                    href='utilisateur.php'>
                    <span class='icon'>
                      <svg
                        width='22'
                        height='22'
                        viewBox='0 0 22 22'
                        fill='none'
                        xmlns='http://www.w3.org/2000/svg'
                      >
                        <path
                          d='M4.58333 3.66675H17.4167C17.9029 3.66675 18.3692 3.8599 18.713 4.20372C19.0568 4.54754 19.25 5.01385 19.25 5.50008V16.5001C19.25 16.9863 19.0568 17.4526 18.713 17.7964C18.3692 18.1403 17.9029 18.3334 17.4167 18.3334H4.58333C4.0971 18.3334 3.63079 18.1403 3.28697 17.7964C2.94315 17.4526 2.75 16.9863 2.75 16.5001V5.50008C2.75 5.01385 2.94315 4.54754 3.28697 4.20372C3.63079 3.8599 4.0971 3.66675 4.58333 3.66675ZM4.58333 7.33341V11.0001H10.0833V7.33341H4.58333ZM11.9167 7.33341V11.0001H17.4167V7.33341H11.9167ZM4.58333 12.8334V16.5001H10.0833V12.8334H4.58333ZM11.9167 12.8334V16.5001H17.4167V12.8334H11.9167Z'
                        />
                      </svg>
                    </span>
                    <span class='text'>Utilisateurs</span>
                  </a>
                </li>
              ");
            }
          ?> 
          <li class="nav-item active">
            <a href="historique.php">
              <span class="icon">
                <i class= "fa fa-calendar"></i>
              </span>
              <span class="text">Historisation</span>
            </a>
          </li>
          <li class="nav-item">
            <a href="commentaire.php">
              <span class="icon">
                <i class= "fa fa-bell-o"></i>
              </span>
              <span class="text">Commentaires</span>
            </a>
          </li>
          <?php
            if (is_superAdmin()) {
              echo("
                <li class='nav-item'>
                  <a href='corbeille.php'>
                    <span class='icon'>
                      <i class= 'fa fa-trash'></i>
                    </span>
                    <span class='text'>Corbeille</span>
                  </a>
                </li>
              ");
            }
          ?> 

          <span class="divider"><hr /></span>
          <li class="nav-item nav-item-has-children">
            <a
              href="#0"
              class="collapsed"
              data-bs-toggle="collapse"
              data-bs-target="#ddmenu_3"
              aria-controls="ddmenu_3"
              aria-expanded="false"
              aria-label="Toggle navigation"
            >
              <span class="icon">
                <svg
                  width="22"
                  height="22"
                  viewBox="0 0 22 22"
                  fill="none"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path
                    d="M12.9067 14.2908L15.2808 11.9167H6.41667V10.0833H15.2808L12.9067 7.70917L14.2083 6.41667L18.7917 11L14.2083 15.5833L12.9067 14.2908ZM17.4167 2.75C17.9029 2.75 18.3692 2.94315 18.713 3.28697C19.0568 3.63079 19.25 4.0971 19.25 4.58333V8.86417L17.4167 7.03083V4.58333H4.58333V17.4167H17.4167V14.9692L19.25 13.1358V17.4167C19.25 17.9029 19.0568 18.3692 18.713 18.713C18.3692 19.0568 17.9029 19.25 17.4167 19.25H4.58333C3.56583 19.25 2.75 18.425 2.75 17.4167V4.58333C2.75 3.56583 3.56583 2.75 4.58333 2.75H17.4167Z"
                  />
                </svg>
              </span>
              <span class="text">Auth</span>
            </a>
            <ul id="ddmenu_3" class="collapse dropdown-nav">
              <li>
                <a href="../Auth/logoutAdmin.php"> Déconnexion </a>
              </li>
            </ul>
          </li>

    </aside>
    <div class="overlay"></div>
    <!-- ======== sidebar-nav end =========== -->

    <!-- ======== main-wrapper start =========== -->
    <main class="main-wrapper">
      <!-- ========== header start ========== -->
      <header class="header">
        <div class="container-fluid">
          <div class="row">
            <div class="col-lg-5 col-md-5 col-6">
              <div class="header-left d-flex align-items-center">
                <div class="menu-toggle-btn mr-20">
                  <button
                    id="menu-toggle"
                    class="main-btn primary-btn btn-hover"
                  >
                    <i class="lni lni-chevron-left me-2"></i> Menu
                  </button>
                </div>
                
              </div>
            </div>
            <div class="col-lg-7 col-md-7 col-6">
              <div class="header-right">
                <?php foreach ($users as $user):?>
                <!-- profile start -->
                <div class="profile-box ml-15">
                  <button
                    class="dropdown-toggle bg-transparent border-0"
                    type="button"
                    id="profile"
                    data-bs-toggle="dropdown"
                    aria-expanded="false"
                  >
                    <div class="profile-info">
                      <div class="info">
                        <div class="image">
                          <?php 
                            if ($user -> imgProfile == "") {
                                echo("
                                  <img src= '../../Hive/API/documents/profil/person.png' alt='user avatar'>
                                ");
                            } 
                            else {?>
                              <?php echo("
                                  <img src=". $user -> imgProfile ." alt=user avatar>
                            ");
                          }?>
                          <span class="status"></span>
                        </div>
                      </div>
                    </div>
                    <i class="lni lni-chevron-down"></i>
                  </button>
                  <ul
                    class="dropdown-menu dropdown-menu-end"
                    aria-labelledby="profile"
                  >
                    <li>
                      <a href="profil.php">
                        <i class="lni lni-user"></i> Mon Profil
                      </a>
                    </li>
                    <li>
                      <a href="../Auth/logoutAdmin.php"> <i class="lni lni-exit"></i> Déconexion </a>
                    </li>
                  </ul>
                </div>
                <?php endforeach; ?>
                <!-- profile end -->
              </div>
            </div>
          </div>
        </div>
      </header>
      <!-- ========== header end ========== -->

      <!-- ========== notification-wrapper start ========== -->
      <div class="notification-wrapper">
        <div class="container-fluid">
          <!-- ========== title-wrapper start ========== -->
          <div class="title-wrapper pt-30">
            <div class="row align-items-center">
              <div class="col-md-6">
                <div class="title mb-30">
                  <h2>Historique</h2>
                </div>
              </div>
              <!-- end col -->
              <div class="col-md-6">
                <div class="breadcrumb-wrapper mb-30">
                  <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item">
                        <a href="#0"></a>
                      </li>
                      <li class="breadcrumb-item active" aria-current="page">
                        Historique
                      </li>
                    </ol>
                  </nav>
                </div>
              </div>
              <!-- end col -->
            </div>
            <!-- end row -->
          </div>
          <!-- ========== title-wrapper end ========== -->

          <div class="card-style">
            <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4">
              <div class="col">
                <div class="card radius-10 border-start border-0 border-3 border-info">
                  <div class="card-body">
                    <div class="d-flex align-items-center">
                      <div>
                        <p class="mb-0 text-secondary">Utilisateurs</p>
                        <h4 class="my-1 text-info">2</h4>  
                      </div>
                      <div class="widgets-icons-2 rounded-circle bg-gradient-scooter text-white ms-auto"><i class="fa fa-users"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col">
                <div class="card radius-10 border-start border-0 border-3 border-danger">
                  <div class="card-body">
                    <div class="d-flex align-items-center">
                      <div>
                        <p class="mb-0 text-secondary">Archives</p>
                        <h4 class="my-1 text-danger">10</h4>
                      </div>
                    <div class="widgets-icons-2 rounded-circle bg-gradient-bloody text-white ms-auto"><i class="fa fa-leanpub "></i>
                  </div>
                </div>
              </div>
                  </div>
                  </div>
              <div class="col">
                <div class="card radius-10 border-start border-0 border-3 border-success">
                  <div class="card-body">
                    <div class="d-flex align-items-center">
                      <div>
                        <p class="mb-0 text-secondary">Commentaires</p>
                        <h4 class="my-1 text-success">12</h4>
                      </div>
                    <div class="widgets-icons-2 rounded-circle bg-gradient-ohhappiness text-white ms-auto"><i class="fa fa-bell-o"></i>
                  </div>
                </div>
              </div>
                  </div>
                  </div>
              <div class="col">
                <div class="card radius-10 border-start border-0 border-3 border-warning">
                  <div class="card-body">
                    <div class="d-flex align-items-center">
                      <div>
                        <p class="mb-0 text-secondary">Total Customers</p>
                        <h4 class="my-1 text-warning">10</h4>
                      </div>
                    <div class="widgets-icons-2 rounded-circle bg-gradient-blooker text-white ms-auto"><i class="fa fa-users"></i>
                  </div>
                </div>
              </div>
            </div>
          </div> 
          </div>
          </div>
          <div class="col">
    <div class="e-tabs mb-3 px-3">
      <ul class="nav nav-tabs">
        <li class="nav-item"><a class="nav-link active" href="#">Utilisateurs</a></li>
      </ul>
    </div>

    <div class="row flex-lg-nowrap">
      <div class="col mb-3">
        <div class="e-panel card">
          <div class="card-body">
            <div class="card-title">
              <h6 class="mr-2"><span>Users</span><small class="px-1">Be a wise leader</small></h6>
            </div>
            <div class="e-table">
              <div class="table-responsive table-lg mt-3">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th class="align-top">
                        <div class="custom-control custom-control-inline custom-checkbox custom-control-nameless m-0">
                          <input type="checkbox" class="custom-control-input" id="all-items">
                          <label class="custom-control-label" for="all-items"></label>
                        </div>
                      </th>
                      <th>Photo</th>
                      <th class="max-width">Name</th>
                      <th class="sortable">Date</th>
                      <th> </th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td class="align-middle">
                        <div class="custom-control custom-control-inline custom-checkbox custom-control-nameless m-0 align-top">
                          <input type="checkbox" class="custom-control-input" id="item-1">
                          <label class="custom-control-label" for="item-1"></label>
                        </div>
                      </td>
                      <td class="align-middle text-center">
                        <div class="bg-light d-inline-flex justify-content-center align-items-center align-top" style="width: 35px; height: 35px; border-radius: 3px;"><i class="fa fa-fw fa-photo" style="opacity: 0.8;"></i></div>
                      </td>
                      <td class="text-nowrap align-middle">Adam Cotter</td>
                      <td class="text-nowrap align-middle"><span>09 Dec 2017</span></td>
                      <td class="text-center align-middle"><i class="fa fa-fw text-secondary cursor-pointer fa-toggle-on"></i></td>
                      <td class="text-center align-middle">
                        <div class="btn-group align-top">
                            <button class="btn btn-sm btn-outline-secondary badge" type="button" data-toggle="modal" data-target="#user-form-modal">Edit</button>
                            <button class="btn btn-sm btn-outline-secondary badge" type="button"><i class="fa fa-trash"></i></button>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td class="align-middle">
                        <div class="custom-control custom-control-inline custom-checkbox custom-control-nameless m-0 align-top">
                          <input type="checkbox" class="custom-control-input" id="item-2">
                          <label class="custom-control-label" for="item-2"></label>
                        </div>
                      </td>
                      <td class="align-middle text-center">
                        <div class="bg-light d-inline-flex justify-content-center align-items-center align-top" style="width: 35px; height: 35px; border-radius: 3px;"><i class="fa fa-fw fa-photo" style="opacity: 0.8;"></i></div>
                      </td>
                      <td class="text-nowrap align-middle">Pauline Noble</td>
                      <td class="text-nowrap align-middle"><span>26 Jan 2018</span></td>
                      <td class="text-center align-middle"><i class="fa fa-fw text-secondary cursor-pointer fa-toggle-off"></i></td>
                      <td class="text-center align-middle">
                        <div class="btn-group align-top">
                            <button class="btn btn-sm btn-outline-secondary badge" type="button" data-toggle="modal" data-target="#user-form-modal">Edit</button>
                            <button class="btn btn-sm btn-outline-secondary badge" type="button"><i class="fa fa-trash"></i></button>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td class="align-middle">
                        <div class="custom-control custom-control-inline custom-checkbox custom-control-nameless m-0 align-top">
                          <input type="checkbox" class="custom-control-input" id="item-3">
                          <label class="custom-control-label" for="item-3"></label>
                        </div>
                      </td>
                      <td class="align-middle text-center">
                        <div class="bg-light d-inline-flex justify-content-center align-items-center align-top" style="width: 35px; height: 35px; border-radius: 3px;"><i class="fa fa-fw fa-photo" style="opacity: 0.8;"></i></div>
                      </td>
                      <td class="text-nowrap align-middle">Sherilyn Metzel</td>
                      <td class="text-nowrap align-middle"><span>27 Jan 2018</span></td>
                      <td class="text-center align-middle"><i class="fa fa-fw text-secondary cursor-pointer fa-toggle-on"></i></td>
                      <td class="text-center align-middle">
                        <div class="btn-group align-top">
                            <button class="btn btn-sm btn-outline-secondary badge" type="button" data-toggle="modal" data-target="#user-form-modal">Edit</button>
                            <button class="btn btn-sm btn-outline-secondary badge" type="button"><i class="fa fa-trash"></i></button>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td class="align-middle">
                        <div class="custom-control custom-control-inline custom-checkbox custom-control-nameless m-0 align-top">
                          <input type="checkbox" class="custom-control-input" id="item-4">
                          <label class="custom-control-label" for="item-4"></label>
                        </div>
                      </td>
                      <td class="align-middle text-center">
                        <div class="bg-light d-inline-flex justify-content-center align-items-center align-top" style="width: 35px; height: 35px; border-radius: 3px;"><i class="fa fa-fw fa-photo" style="opacity: 0.8;"></i></div>
                      </td>
                      <td class="text-nowrap align-middle">Terrie Boaler</td>
                      <td class="text-nowrap align-middle"><span>20 Jan 2018</span></td>
                      <td class="text-center align-middle"><i class="fa fa-fw text-secondary cursor-pointer fa-toggle-on"></i></td>
                      <td class="text-center align-middle">
                        <div class="btn-group align-top">
                            <button class="btn btn-sm btn-outline-secondary badge" type="button" data-toggle="modal" data-target="#user-form-modal">Edit</button>
                            <button class="btn btn-sm btn-outline-secondary badge" type="button"><i class="fa fa-trash"></i></button>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td class="align-middle">
                        <div class="custom-control custom-control-inline custom-checkbox custom-control-nameless m-0 align-top">
                          <input type="checkbox" class="custom-control-input" id="item-5">
                          <label class="custom-control-label" for="item-5"></label>
                        </div>
                      </td>
                      <td class="align-middle text-center">
                        <div class="bg-light d-inline-flex justify-content-center align-items-center align-top" style="width: 35px; height: 35px; border-radius: 3px;"><i class="fa fa-fw fa-photo" style="opacity: 0.8;"></i></div>
                      </td>
                      <td class="text-nowrap align-middle">Rutter Pude</td>
                      <td class="text-nowrap align-middle"><span>13 Jan 2018</span></td>
                      <td class="text-center align-middle"><i class="fa fa-fw text-secondary cursor-pointer fa-toggle-off"></i></td>
                      <td class="text-center align-middle">
                        <div class="btn-group align-top">
                            <button class="btn btn-sm btn-outline-secondary badge" type="button" data-toggle="modal" data-target="#user-form-modal">Edit</button>
                            <button class="btn btn-sm btn-outline-secondary badge" type="button"><i class="fa fa-trash"></i></button>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td class="align-middle">
                        <div class="custom-control custom-control-inline custom-checkbox custom-control-nameless m-0 align-top">
                          <input type="checkbox" class="custom-control-input" id="item-6">
                          <label class="custom-control-label" for="item-6"></label>
                        </div>
                      </td>
                      <td class="align-middle text-center">
                        <div class="bg-light d-inline-flex justify-content-center align-items-center align-top" style="width: 35px; height: 35px; border-radius: 3px;"><i class="fa fa-fw fa-photo" style="opacity: 0.8;"></i></div>
                      </td>
                      <td class="text-nowrap align-middle">Clifford Benjamin</td>
                      <td class="text-nowrap align-middle"><span>25 Jan 2018</span></td>
                      <td class="text-center align-middle"><i class="fa fa-fw text-secondary cursor-pointer fa-toggle-on"></i></td>
                      <td class="text-center align-middle">
                        <div class="btn-group align-top">
                            <button class="btn btn-sm btn-outline-secondary badge" type="button" data-toggle="modal" data-target="#user-form-modal">Edit</button>
                            <button class="btn btn-sm btn-outline-secondary badge" type="button"><i class="fa fa-trash"></i></button>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td class="align-middle">
                        <div class="custom-control custom-control-inline custom-checkbox custom-control-nameless m-0 align-top">
                          <input type="checkbox" class="custom-control-input" id="item-7">
                          <label class="custom-control-label" for="item-7"></label>
                        </div>
                      </td>
                      <td class="align-middle text-center">
                        <div class="bg-light d-inline-flex justify-content-center align-items-center align-top" style="width: 35px; height: 35px; border-radius: 3px;"><i class="fa fa-fw fa-photo" style="opacity: 0.8;"></i></div>
                      </td>
                      <td class="text-nowrap align-middle">Thedric Romans</td>
                      <td class="text-nowrap align-middle"><span>12 Jan 2018</span></td>
                      <td class="text-center align-middle"><i class="fa fa-fw text-secondary cursor-pointer fa-toggle-off"></i></td>
                      <td class="text-center align-middle">
                        <div class="btn-group align-top">
                            <button class="btn btn-sm btn-outline-secondary badge" type="button" data-toggle="modal" data-target="#user-form-modal">Edit</button>
                            <button class="btn btn-sm btn-outline-secondary badge" type="button"><i class="fa fa-trash"></i></button>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td class="align-middle">
                        <div class="custom-control custom-control-inline custom-checkbox custom-control-nameless m-0 align-top">
                          <input type="checkbox" class="custom-control-input" id="item-8">
                          <label class="custom-control-label" for="item-8"></label>
                        </div>
                      </td>
                      <td class="align-middle text-center">
                        <div class="bg-light d-inline-flex justify-content-center align-items-center align-top" style="width: 35px; height: 35px; border-radius: 3px;"><i class="fa fa-fw fa-photo" style="opacity: 0.8;"></i></div>
                      </td>
                      <td class="text-nowrap align-middle">Haily Carthew</td>
                      <td class="text-nowrap align-middle"><span>27 Jan 2018</span></td>
                      <td class="text-center align-middle"><i class="fa fa-fw text-secondary cursor-pointer fa-toggle-on"></i></td>
                      <td class="text-center align-middle">
                        <div class="btn-group align-top">
                            <button class="btn btn-sm btn-outline-secondary badge" type="button" data-toggle="modal" data-target="#user-form-modal">Edit</button>
                            <button class="btn btn-sm btn-outline-secondary badge" type="button"><i class="fa fa-trash"></i></button>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td class="align-middle">
                        <div class="custom-control custom-control-inline custom-checkbox custom-control-nameless m-0 align-top">
                          <input type="checkbox" class="custom-control-input" id="item-9">
                          <label class="custom-control-label" for="item-9"></label>
                        </div>
                      </td>
                      <td class="align-middle text-center">
                        <div class="bg-light d-inline-flex justify-content-center align-items-center align-top" style="width: 35px; height: 35px; border-radius: 3px;"><i class="fa fa-fw fa-photo" style="opacity: 0.8;"></i></div>
                      </td>
                      <td class="text-nowrap align-middle">Dorothea Joicey</td>
                      <td class="text-nowrap align-middle"><span>12 Dec 2017</span></td>
                      <td class="text-center align-middle"><i class="fa fa-fw text-secondary cursor-pointer fa-toggle-on"></i></td>
                      <td class="text-center align-middle">
                        <div class="btn-group align-top">
                            <button class="btn btn-sm btn-outline-secondary badge" type="button" data-toggle="modal" data-target="#user-form-modal">Edit</button>
                            <button class="btn btn-sm btn-outline-secondary badge" type="button"><i class="fa fa-trash"></i></button>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td class="align-middle">
                        <div class="custom-control custom-control-inline custom-checkbox custom-control-nameless m-0 align-top">
                          <input type="checkbox" class="custom-control-input" id="item-10">
                          <label class="custom-control-label" for="item-10"></label>
                        </div>
                      </td>
                      <td class="align-middle text-center">
                        <div class="bg-light d-inline-flex justify-content-center align-items-center align-top" style="width: 35px; height: 35px; border-radius: 3px;"><i class="fa fa-fw fa-photo" style="opacity: 0.8;"></i></div>
                      </td>
                      <td class="text-nowrap align-middle">Mikaela Pinel</td>
                      <td class="text-nowrap align-middle"><span>10 Dec 2017</span></td>
                      <td class="text-center align-middle"><i class="fa fa-fw text-secondary cursor-pointer fa-toggle-off"></i></td>
                      <td class="text-center align-middle">
                        <div class="btn-group align-top">
                            <button class="btn btn-sm btn-outline-secondary badge" type="button" data-toggle="modal" data-target="#user-form-modal">Edit</button>
                            <button class="btn btn-sm btn-outline-secondary badge" type="button"><i class="fa fa-trash"></i></button>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td class="align-middle">
                        <div class="custom-control custom-control-inline custom-checkbox custom-control-nameless m-0 align-top">
                          <input type="checkbox" class="custom-control-input" id="item-11">
                          <label class="custom-control-label" for="item-11"></label>
                        </div>
                      </td>
                      <td class="align-middle text-center">
                        <div class="bg-light d-inline-flex justify-content-center align-items-center align-top" style="width: 35px; height: 35px; border-radius: 3px;"><i class="fa fa-fw fa-photo" style="opacity: 0.8;"></i></div>
                      </td>
                      <td class="text-nowrap align-middle">Donnell Farries</td>
                      <td class="text-nowrap align-middle"><span>03 Dec 2017</span></td>
                      <td class="text-center align-middle"><i class="fa fa-fw text-secondary cursor-pointer fa-toggle-on"></i></td>
                      <td class="text-center align-middle">
                        <div class="btn-group align-top">
                            <button class="btn btn-sm btn-outline-secondary badge" type="button" data-toggle="modal" data-target="#user-form-modal">Edit</button>
                            <button class="btn btn-sm btn-outline-secondary badge" type="button"><i class="fa fa-trash"></i></button>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td class="align-middle">
                        <div class="custom-control custom-control-inline custom-checkbox custom-control-nameless m-0 align-top">
                          <input type="checkbox" class="custom-control-input" id="item-12">
                          <label class="custom-control-label" for="item-12"></label>
                        </div>
                      </td>
                      <td class="align-middle text-center">
                        <div class="bg-light d-inline-flex justify-content-center align-items-center align-top" style="width: 35px; height: 35px; border-radius: 3px;"><i class="fa fa-fw fa-photo" style="opacity: 0.8;"></i></div>
                      </td>
                      <td class="text-nowrap align-middle">Letizia Puncher</td>
                      <td class="text-nowrap align-middle"><span>09 Dec 2017</span></td>
                      <td class="text-center align-middle"><i class="fa fa-fw text-secondary cursor-pointer fa-toggle-off"></i></td>
                      <td class="text-center align-middle">
                        <div class="btn-group align-top">
                            <button class="btn btn-sm btn-outline-secondary badge" type="button" data-toggle="modal" data-target="#user-form-modal">Edit</button>
                            <button class="btn btn-sm btn-outline-secondary badge" type="button"><i class="fa fa-trash"></i></button>
                        </div>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="d-flex justify-content-center">
                <ul class="pagination mt-3 mb-0">
                  <li class="disabled page-item"><a href="#" class="page-link">‹</a></li>
                  <li class="active page-item"><a href="#" class="page-link">1</a></li>
                  <li class="page-item"><a href="#" class="page-link">2</a></li>
                  <li class="page-item"><a href="#" class="page-link">3</a></li>
                  <li class="page-item"><a href="#" class="page-link">4</a></li>
                  <li class="page-item"><a href="#" class="page-link">5</a></li>
                  <li class="page-item"><a href="#" class="page-link">›</a></li>
                  <li class="page-item"><a href="#" class="page-link">»</a></li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
        <!-- end container -->
      </div>
      <!-- ========== notification-wrapper start ========== -->
      <!-- ========== footer start =========== -->
      <footer class="footer">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-6 order-last order-md-first">
              <div class="copyright text-center text-md-start">
                <p class="text-sm">
                  Designed and Developed by
                  <a href="https://www.hive-technology.net/">
                    Hive Technology
                  </a>
                </p>
              </div>
            </div>
            <!-- end col-->
            <div class="col-md-6">
              <div
                class="
                  terms
                  d-flex
                  justify-content-center justify-content-md-end
                "
              >
                <a href="#0" class="text-sm">Term & Conditions</a>
                <a href="#0" class="text-sm ml-15">Privacy & Policy</a>
              </div>
            </div>
          </div>
          <!-- end row -->
        </div>
        <!-- end container -->
      </footer>
      <!-- ========== footer end =========== -->
    </main>
    <!-- ======== main-wrapper end =========== -->

    <!-- ========= All Javascript files linkup ======== -->
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/Chart.min.js"></script>
    <script src="assets/js/dynamic-pie-chart.js"></script>
    <script src="assets/js/moment.min.js"></script>
    <script src="assets/js/fullcalendar.js"></script>
    <script src="assets/js/jvectormap.min.js"></script>
    <script src="assets/js/world-merc.js"></script>
    <script src="assets/js/polyfill.js"></script>
    <script src="assets/js/main.js"></script>
  </body>
</html>
