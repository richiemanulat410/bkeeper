<?php
session_start();

if(isset($_SESSION['role'])){
    if($_SESSION['role'] === 'client'){
        echo '<script>window.location.href="admin-dashboard.php"</script>';
    }
    else{
        echo '<script>window.location.href="bkeeper-dashboard.php"</script>';
    }
}
require("connection.php");
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>BKeeper</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <!-- <link href="assets/img/favicon.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon"> -->

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Jost:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="assets/css/style.css" rel="stylesheet">

    <!-- =======================================================
  * Template Name: Arsha - v4.7.1
  * Template URL: https://bootstrapmade.com/arsha-free-bootstrap-html-template-corporate/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

    <!-- ======= Header ======= -->

    <?php
    include('header.php');
    ?>



    <!-- ======= Hero Section ======= -->
    <section id="hero" class="d-flex align-items-center" style="height: 0vh !important; padding:40px 0px !important">

        <div class=" container">
            <div class="row">
                <div class="col-lg-6 d-flex flex-column justify-content-center pt-4 pt-lg-0 order-2 order-lg-1" data-aos="fade-up" data-aos-delay="200">

                </div>
            </div>

    </section><!-- End Hero -->
    <!-- ======= Hero Section ======= -->

    <main id="main">


        <!-- ======= Contact Section ======= -->
        <section id="contact" class="contact">
            <div class="container" data-aos="fade-up">

                <div class="section-title">
                    <h2>Login</h2>
                    <!-- <p>Magnam dolores commodi suscipit. Necessitatibus eius consequatur ex aliquid fuga eum quidem. Sit sint consectetur velit. Quisquam quos quisquam cupiditate. Et nemo qui impedit suscipit alias ea. Quia fugiat sit in iste officiis commodi quidem hic quas.</p> -->
                </div>
                <div class="row">
                    <div class="col-lg-4 d-flex align-items-stretch">
                    </div>

                    <div class="col-lg-4 mt-5 mt-lg-0 d-flex align-items-stretch">
                        <?php
                        if ($_SERVER["REQUEST_METHOD"] == "POST") {
                            $email = $_POST['email'];
                            $password = $_POST['password'];

                            $sql = "SELECT id, name,email, role, profile_picture FROM users WHERE email = '" . $email . "' AND password = '" . $password . "' ";
                            $result = mysqli_query($conn, $sql);
                            if (mysqli_num_rows($result) > 0) {
                                $success = true;
                                echo "Login Successfully";
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $_SESSION['user_id'] = $row["id"];
                                    $_SESSION['name'] = $row["name"];
                                    $_SESSION['email'] = $row["email"];
                                    $_SESSION['role'] = $row['role'];
                                    $_SESSION['profile_picture'] = $row['profile_picture'];

                                    if ($row['role'] == "client") {
                                        echo '<script>window.location.href="admin-dashboard.php"</script>';
                                    } 
                                    else if($row['role'] == 'admin'){
                                        echo '<script>window.location.href="developer-dashboard.php"</script>';
                                    }
                                    else {
                                        echo '<script>window.location.href="bkeeper-dashboard.php"</script>';
                                    }
                                }
                            } else {
                                echo '
                            <div class="alert alert-danger php-email-form" role="alert">
                               Login Failed!
                            </div><br />
                        ';
                            }
                        }
                        ?>
                    </div>

                    <div class="col-lg-4 d-flex align-items-stretch">
                    </div>
                </div>
                <div class="row">

                    <div class="col-lg-4 d-flex align-items-stretch">
                    </div>

                    <div class="col-lg-4 mt-5 mt-lg-0 d-flex align-items-stretch">

                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="php-email-form">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" name="email" id="email" required>
                            </div>

                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" name="password" id="password" required>
                            </div>
                            <a href="forgot-password.php">Forgot Password</a>
                            <div class="text-center">
                                <button type="submit">Login</button>
                            </div>
                        </form>
                    </div>

                    <div class="col-lg-4 d-flex align-items-stretch">
                    </div>

                </div>

            </div>
        </section><!-- End Contact Section -->

        <?php
        // include('team.php');
        ?>

        <?php
        //include('services.php');
        ?>

        <?php
       // include('about.php');
        ?>


    </main><!-- End #main -->

    <!-- ======= Footer ======= -->
    <footer id="footer">

        <!-- <div class="footer-newsletter">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-6">
                        <h4>Join Our Newsletter</h4>
                        <p>Tamen quem nulla quae legam multos aute sint culpa legam noster magna</p>
                        <form action="" method="post">
                            <input type="email" name="email"><input type="submit" value="Subscribe">
                        </form>
                    </div>
                </div>
            </div>
        </div> -->

        <!-- <div class="footer-top">
            <div class="container">
                <div class="row">

                    <div class="col-lg-3 col-md-6 footer-contact">
                        <h3>Arsha</h3>
                        <p>
                            A108 Adam Street <br>
                            New York, NY 535022<br>
                            United States <br><br>
                            <strong>Phone:</strong> +1 5589 55488 55<br>
                            <strong>Email:</strong> info@example.com<br>
                        </p>
                    </div>

                    <div class="col-lg-3 col-md-6 footer-links">
                        <h4>Useful Links</h4>
                        <ul>
                            <li><i class="bx bx-chevron-right"></i> <a href="#">Home</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="#">About us</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="#">Services</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="#">Terms of service</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="#">Privacy policy</a></li>
                        </ul>
                    </div>

                    <div class="col-lg-3 col-md-6 footer-links">
                        <h4>Our Services</h4>
                        <ul>
                            <li><i class="bx bx-chevron-right"></i> <a href="#">Web Design</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="#">Web Development</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="#">Product Management</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="#">Marketing</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="#">Graphic Design</a></li>
                        </ul>
                    </div>

                    <div class="col-lg-3 col-md-6 footer-links">
                        <h4>Our Social Networks</h4>
                        <p>Cras fermentum odio eu feugiat lide par naso tierra videa magna derita valies</p>
                        <div class="social-links mt-3">
                            <a href="#" class="twitter"><i class="bx bxl-twitter"></i></a>
                            <a href="#" class="facebook"><i class="bx bxl-facebook"></i></a>
                            <a href="#" class="instagram"><i class="bx bxl-instagram"></i></a>
                            <a href="#" class="google-plus"><i class="bx bxl-skype"></i></a>
                            <a href="#" class="linkedin"><i class="bx bxl-linkedin"></i></a>
                        </div>
                    </div>

                </div>
            </div>
        </div> -->

        <!-- <div class="container footer-bottom clearfix">
            <div class="copyright">
                &copy; Copyright <strong><span>BKeeper</span></strong>. All Rights Reserved
            </div>
            <div class="credits"> -->
                <!-- All the links in the footer should remain intact. -->
                <!-- You can delete the links only if you purchased the pro version. -->
                <!-- Licensing information: https://bootstrapmade.com/license/ -->
                <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/arsha-free-bootstrap-html-template-corporate/ -->
            </div>
        </div>
    </footer><!-- End Footer -->

    <div id="preloader"></div>
    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="assets/vendor/aos/aos.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
    <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
    <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
    <script src="assets/vendor/waypoints/noframework.waypoints.js"></script>
    <script src="assets/vendor/php-email-form/validate.js"></script>

    <!-- Template Main JS File -->
    <script src="assets/js/main.js"></script>

</body>

</html>