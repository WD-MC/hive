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
    <title>Profil | Hive</title>

    <!-- ========== All CSS files linkup ========= -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="assets/css/lineicons.css" />
    <link rel="stylesheet" href="assets/css/materialdesignicons.min.css" />
    <link rel="stylesheet" href="assets/css/fullcalendar.css" />
    <link rel="stylesheet" href="assets/css/main.css" />
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
                <a href="accueil_admin.php"> Hive Books </a>
              </li>
              <li>
                <a href="new_archive.php"> Créer une archive  </a>
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

          <li class="nav-item">
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
                      <a href="../Auth/logoutAdmin.php"> <i class="lni lni-exit"></i> Déconnexion </a>
                    </li>
                  </ul>
                </div>
                <!-- profile end -->
              </div>
            </div>
          </div>
        </div>
      </header>
      <!-- ========== header end ========== -->

      <!-- ========== section start ========== -->
      <section class="section">
        <div class="container-fluid">
          <!-- ========== title-wrapper start ========== -->
          <div class="title-wrapper pt-30">
            <div class="row align-items-center">
              <div class="col-md-6">
                <div class="titlemb-30">
                  <h2>PROFIL</h2>
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
                        Profil
                      </li>
                    </ol>
                  </nav>
                </div>
              </div>
              <!-- end col -->
            </div>
            <!-- end row -->
            
            <?php
              if (isset($_SESSION['error_message'])) {
                  echo '<div id = "message" class="alert alert-danger">'.$_SESSION['error_message'].'</div>';
                  unset($_SESSION['error_message']);
              }
            ?>
          </div>
          <!-- ========== title-wrapper end ========== -->

          <div class="row">
            <div class="col-lg-12">
              <div class="card-style settings-card-1 mb-30">
                <div
                  class="
                    title
                    mb-30
                    d-flex
                    justify-content-between
                    align-items-center
                  "
                >
                  <h4><strong>Mon profil</strong> </h4>
                </div>
                <form action="../API/dataManager/create.php" method="post" enctype="multipart/form-data">
                  <input type="hidden" name="action" value="updateProfil">
                  <div class="profile-info">
                    <div class="d-flex align-items-center mb-30">
                      <div class="profile-image">
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
                        <div class="update-image">
                          <input type="file" name="docfichier"/>
                          <label for=""
                            ><i class="lni lni-cloud-upload"></i
                          ></label>
                        </div>
                      </div>
                      <div class="profile-meta">
                        <h5 class="text-bold text-dark mb-10"><?= $user -> username?></h5>
                      </div>
                    </div>
                    <div class="col-12">
                      <input Type="submit" name="Deleteprofil" class="main-btn danger-btn btn-hover" value="Supprimer"/>
                      <input Type="submit" name="profil" class="main-btn success-btn btn-hover" value="Modifier"/>
                    </div>
                    <hr>
                    <h4><strong>Mes informations</strong> </h4>
                    <hr>
                    <div class="input-style-1">
                      <label>Nom d'utilisateur</label>
                      <input
                        type="text" name="username"
                        value="<?= $user -> username?>"
                      />
                    </div>
                    <div class="input-style-1">
                      <label>Nom </label>
                      <input
                        type="text" name="name"
                        value="<?= $user -> nom?>"
                      />
                    </div>
                    <div class="col-12 text-end">
                      <input Type="submit" name="information" class="main-btn success-btn btn-hover" value="Modifier"/>
                    </div>
                    <hr>
                    <h4><strong>Sécurité</strong> </h4>
                    <hr> 
                    <div class="input-style-1">
                      <label>Ancien mot de passe</label>
                      <input type="password"  name="password" />
                    </div>
                    <div class="input-style-1">
                      <label>Nouveau mot de passe</label>
                      <input type="password" name="Npassword" />
                    </div>
                    <div class="input-style-1">
                      <label>Confirmez le mot de passe</label>
                      <input type="password" name="Vpassword" />
                    </div>
                    <div class="col-12 text-end">
                      <input Type="submit" name="securite" class="main-btn success-btn btn-hover" value="Modifier"/>
                    </div>
                  </div>
                </form>
              </div>
              <!-- end card -->
            </div>
            <!-- end col -->
          </div>
          <!-- end row -->
        </div>
        <!-- end container -->
      </section>
      
      <?php endforeach; ?>
      <!-- ========== section end ========== -->

      <!-- ========== footer start =========== -->
      <footer class="footer">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-6 order-last order-md-first">
              <div class="copyright text-center text-md-start">
                <p class="text-sm">
                  Designed and Developed by
                  <a
                    href="https://www.hive-technology.net/"
                  >
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
    <script>
      setTimeout(function() {
          document.getElementById("message").style.display = "none";
      }, 10000);
    </script>
  </body>
</html>
