<?php
session_start();

if (isset($_SESSION['role'])) {
    if ($_SESSION['role'] === 'client') {
        echo '<script>window.location.href="admin-dashboard.php"</script>';
    } else {
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
        <div class="container">
            <div class="row">
            </div>
        </div>
    </section><!-- End Hero -->
    <!-- ======= Hero Section ======= -->

    <main id="main">


        <!-- ======= Contact Section ======= -->
        <section id="contact" class="contact">
            <div class="container" data-aos="fade-up">

                <div class="section-title">
                    <h2>Signup</h2>
                    <!-- <p>Magnam dolores commodi suscipit. Necessitatibus eius consequatur ex aliquid fuga eum quidem. Sit sint consectetur velit. Quisquam quos quisquam cupiditate. Et nemo qui impedit suscipit alias ea. Quia fugiat sit in iste officiis commodi quidem hic quas.</p> -->
                </div>
                <div class="row">
                    <div class="col-lg-4 d-flex align-items-stretch">
                    </div>

                    <div class="col-lg-4 mt-5 mt-lg-0 d-flex align-items-stretch">
                        <?php

                        function getRandomString($n)
                        {
                            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                            $randomString = '';

                            for ($i = 0; $i < $n;
                                $i++
                            ) {
                                $index = rand(0, strlen($characters) - 1);
                                $randomString .= $characters[$index];
                            }

                            return $randomString;
                        }
                        
                        if ($_SERVER["REQUEST_METHOD"] == "POST") {
                            $name = $_POST['name'];
                            $email = $_POST['email'];
                            $password = $_POST['password'];
                            $role = $_POST['role'];
                            $address = $_POST['address'];
                            $birthdate = $_POST['birthdate'];
                            $gender = $_POST['gender'];

                            $valid_id_name = getRandomString(8);
                            $profile_picture = getRandomString(8);

                            $imageFileType1 = strtolower(pathinfo($_FILES["valid_id"]["name"], PATHINFO_EXTENSION));
                            $imageFileType2 = strtolower(pathinfo($_FILES["profile_picture"]["name"], PATHINFO_EXTENSION));

                            $valid_id_name = $valid_id_name .'.'. $imageFileType1;
                            $profile_picture = $profile_picture .'.'. $imageFileType2;

                            $target_dir1 = "valid_ids/";
                            $target_file1 = $target_dir1 . basename($valid_id_name);

                            $target_dir2 = "profile_pictures/";
                            $target_file2 = $target_dir2 . basename($profile_picture);

                            

                            // Check if image file is a actual image or fake image
                            $check1 = getimagesize($_FILES["valid_id"]["tmp_name"]);
                            $check2 = getimagesize($_FILES["profile_picture"]["tmp_name"]);

                            

                            if ($check1 !== false && $check2 !== false) {
                              
                                $uploadOk = 1;

                                if (move_uploaded_file($_FILES["valid_id"]["tmp_name"], $target_file1) &&
                                    move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $target_file2)) {

                                    $currentDate = new DateTime();

                                    $sql = "INSERT INTO users (name, email, address, birthdate, gender, valid_id, profile_picture, password, date_created, role)
                                    VALUES ('" .
                                        $name . "', '" .
                                            $email . "', '" .
                                            $address . "', '" .
                                            $birthdate . "', '" .
                                            $gender . "', '" .
                                            $valid_id_name . "', '" .
                                            $profile_picture . "', '" .
                                            $password . "', '" .
                                            $currentDate->format('Y-m-d H:i:s') . "', '" .
                                            $role . "')";

                                        if (mysqli_query($conn, $sql)) {
                                            echo '<div class="alert alert-success" role="alert">
                                                You Registered Successfully!
                                            </div>';
                                            echo "<script>window.location.href='https://bkeeper.club/login.php'</script>";
                                        } else {
                                            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                                        }

                                        mysqli_close($conn);
                                }else{
                                    echo '<div class="alert alert-danger" role="alert">
                                            File was not uploaded
                                        </div>';
                                }

                                
                            } else {
                                echo '<div class="alert alert-danger" role="alert">
                                            File is not an image
                                        </div>';
                            }
                        }
                        ?>
                    </div>

                    <div class="col-lg-4 d-flex align-items-stretch">
                    </div>
                </div>
                <div class="row">

                    <div class="col-lg-2 d-flex align-items-stretch">
                    </div>

                    <div class="col-lg-8 mt-5 mt-lg-0 d-flex align-items-stretch">
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" role="form" class="php-email-form" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input type="text" class="form-control" name="name" id="name" required>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="address">Address</label>
                                        <input type="text" name="address" id="address" class="form-control">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="birthdate">Birthdate</label>
                                        <input type="date" name="birthdate" id="birthdate" class="form-control">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="gender">Gender</label>
                                        <select name="gender" id="gender" class="form-control">
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="role">Role</label>
                                        <select name="role" id="role" class="form-control">
                                            <option value="client">Client</option>
                                            <option value="bkeeper">Bookkeeper</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" class="form-control" name="email" id="email" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="password">Password</label>
                                        <input type="password" class="form-control" name="password" id="password" required>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="password_confirmation">Password Confirmation</label>
                                        <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" required>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="valid_id">Valid ID</label>
                                        <input type="file" name="valid_id" id="valid_id" class="form-control">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="profile_picture">Profile Picture</label>
                                        <input type="file" name="profile_picture" id="profile_picture" class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="my-3">
                                <div class="loading">Loading</div>
                                <div class="error-message"></div>
                                <div class="sent-message">Your message has been sent. Thank you!</div>
                            </div>
                            <div class="text-center"><button type="submit">Sign Up</button></div>
                        </form>
                    </div>

                     <div class="col-lg-2 d-flex align-items-stretch">
                    </div> 

                </div>

            </div>
        </section><!-- End Contact Section -->

        <?php
        // include('team.php');
        ?>

        <?php
        // include('services.php');
        ?>

        <?php
        // include('about.php');
        ?>



    </main><!-- End #main -->

    <!-- ======= Footer ======= -->
    <!-- <footer id="footer">

        <div class="footer-newsletter">
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
            <!-- </div>
        </div> -->
   <!-- </footer> End Footer -->

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