
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
      rel="shortcut icon"
      href="../app_Administrator/assets/images/logo2.png"
      type="image/x-icon"
    />
    <title>Sign In | Hive</title>

    <!-- ========== All CSS files linkup ========= -->
    <link rel="stylesheet" href="../app_Administrator/assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="../app_Administrator/assets/css/lineicons.css" />
    <link rel="stylesheet" href="../app_Administrator/assets/css/materialdesignicons.min.css" />
    <link rel="stylesheet" href="../app_Administrator/assets/css/fullcalendar.css" />
    <link rel="stylesheet" href="../app_Administrator/assets/css/main.css" />
  </head>
  <body>
    

    <!-- ======== main-wrapper start =========== -->
    <main class="">
      <!-- ========== header start ========== -->
      <header class="header">
        <div class="container-fluid">

        </div>
      </header>
      <!-- ========== header end ========== -->

      <!-- ========== signin-section start ========== -->
      <section class="signin-section">
        <div class="container-fluid">

          <div class="row g-0 auth-row">
            <div class="col-lg-6">
              <div class="auth-cover-wrapper bg-primary-100">
                <div class="auth-cover">
                  <div class="title text-center">
                    <h1 class="text-primary mb-10">Bienvenue</h1>
                    <p class="text-medium">
                      Connectez-vous pour continuer
                    </p>
                  </div>
                  <div class="cover-image">
                    <img src="../app_Administrator/assets/images/auth/signin-image.svg" alt="" />
                  </div>
                  <div class="shape-image">
                    <img src="../app_Administrator/assets/images/auth/shape.svg" alt="" />
                  </div>
                </div>
              </div>
            </div>
            <!-- end col -->
            <div class="col-lg-6">
              <div class="signin-wrapper">
                <div class="form-wrapper">
                  <div class = "row">
                    <div class ="col-md-5">
                      <h5 class="mb-15">Formulaire de connexion</h5>
                    </div>
                    <div class="col-md-7 text-end">
                      <span>
                        <h5 class="mb-15">
                          Pas de compte? 
                          <a href="signup.php" class="hover-underline">
                            Inscrivez-vous
                          </a>
                        </h5>
                      </span>
                  </div>
                  <br><br>
                  <?php
                    session_start();
                    if (isset($_SESSION['error_message'])) {
                      echo '<div id = "message" class="alert alert-danger">'.$_SESSION['error_message'].'</div>';
                      unset($_SESSION['error_message']);
                    }
                  ?>
                  <form action="../API/dataManager/create.php" method = "POST">
                    <div class="row">
                      <div class="col-12">

                        <input type="hidden" name="action" value="connexion_admin">

                        <div class="input-style-1">
                          <label>Username</label>
                          <input type="text" placeholder="Username" name = "username" required />
                        </div>
                      </div>
                      <!-- end col -->
                      <div class="col-12">
                        <div class="input-style-1">
                          <label>Password</label>
                          <input type="password" placeholder="Password" name = "password" required/>
                        </div>
                      </div>
                      <!-- end col -->
                      
                      <div class="col-xxl-6 col-lg-12 col-md-6">
                        <div class="form-check checkbox-style mb-30">
                          <input
                            class="form-check-input"
                            type="checkbox"
                            value="1"
                            name="superadmin"
                            id="checkbox-remember"
                          />
                          <label
                            class="form-check-label"
                            for="checkbox-remember"
                          >
                            Super Admin?</label
                          >
                        </div>
                      </div>
                      <!-- end col -->
                      <div class="col-xxl-6 col-lg-12 col-md-6">
                        <div
                          class="
                            text-start text-md-end text-lg-start text-xxl-end
                            mb-30
                          "
                        >
                          <a href="#0" class="hover-underline"
                            >Mot de passe oublié?
                          </a>
                        </div>
                      </div>
                      <!-- end col -->
                      <br><br><br><br>
                      <div class="text-end pt-1 mb-5 pb-1">
                          <input type="submit" class=" btn btn-primary " name="submit" value="Connexion"/>
                      </div>
                      
                    </div>
                    <!-- end row -->
                  </form>
                  
                </div>
              </div>
            </div>
            <!-- end col -->
          </div>
          <!-- end row -->
        </div>
      </section>
      <!-- ========== signin-section end ========== -->
      <br><br><br>
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
    <script>
        setTimeout(function() {
            document.getElementById("message").style.display = "none";
        }, 3000);
    </script>
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
