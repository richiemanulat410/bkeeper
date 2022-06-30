<?php
session_start();

if (!isset($_SESSION['role'])) {
    echo '<script>window.location.href="login.php"</script>';
}
require("connection.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>BKEEPER</title>
    <!-- Favicon-->
    <!-- <link href="assets/img/favicon.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon"> -->

    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="dashboard/css/styles.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .avatar {
            vertical-align: middle;
            border-radius: 50%;
        }

        .checked {
            color: orange;
        }
    </style>
</head>

<body>
    <div class="d-flex" id="wrapper">
        <?php
        include('admin-sidebar.php');
        ?>
        <!-- Page content wrapper-->
        <div id="page-content-wrapper">
            <?php
            include('admin-nav.php');
            ?>
            <!-- Page content-->
            <div class="container-fluid">
                <h1 class="mt-4">Find BookKeepers</h1>
                <!-- <p>The starting state of the menu will appear collapsed on smaller screens, and will appear non-collapsed on larger screens. When toggled using the button below, the menu will change.</p> -->
                <div class="row">
                    <div class="col-md-4">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="Search for BookKeepers" aria-label="Recipient's username" aria-describedby="button-addon2">
                            <button class="btn btn-outline-secondary" type="button" id="button-addon2">Search</button>
                        </div>
                    </div>
                </div>
                <div class="row">

                    <?php
                    $sql = "SELECT * FROM users WHERE role = 'bkeeper' AND users.id NOT IN (SELECT bkeeper_id from bkeepers WHERE client_id = " . $_SESSION['user_id'] . " )";
                    $result = mysqli_query($conn, $sql);
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {


                            echo '
                            <div class="col-lg-6 col-md-6">
                                <div class="card mb-3 shadow bg-body rounded">
                                    <div class="row g-0">
                                        <div class="col-md-4">
                                            <img src="profile_pictures/' . $row['profile_picture'] . '" width="100px" height="100px" alt="Avatar" class="avatar my-5 mx-3">
                                        </div>
                                        <div class="col-md-8">
                                            <div class="card-body">
                                                <h4 class="card-title text-primary">' . $row['name'] . '
                                                </h4>
                                                ';
                                                //  <h4 class="card-title text-primary">' . $row['name'] . '
                                                //     <a href="admin-add-bkeeper.php?id=' . $row['id'] . '" class="btn btn-primary btn-sm"><i class="fa fa-user-plus"></i> Add</a>
                                                // </h4>

                            $sql2 = "SELECT * FROM bkeeper_content WHERE bkeeper_id =" . $row['id'];
                            $result2 = mysqli_query($conn, $sql2);
                            if (mysqli_num_rows($result2) > 0) {
                                while ($row2 = mysqli_fetch_assoc($result2)) {

                                    $string = strip_tags(base64_decode($row2['content']));
                                    if (strlen($string) > 300) {

                                        // truncate string
                                        $stringCut = substr(
                                            $string,
                                            0,
                                            300
                                        );
                                        $endPoint = strrpos($stringCut, ' ');

                                        //if the string doesn't contain any space then it will cut without word basis.
                                        $string = $endPoint ? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
                                        $string .= '... <a class="btn btn-primary" href="admin-bkeeper-moreinfo.php?id='.$row['id'].'">Read More</a>';
                                    }else{
                                        echo base64_decode($row2['content']);
                                    }
                                    echo $string;
                                }
                            }

                            if ($row['status']) {
                            } else {
                                $stars = $row['ratings'];
                                $no_stars = 5 - $stars;

                                $count2 = 1;
                                while ($count2 <= $stars) {
                                    echo '<span class="fa fa-star checked"></span>';
                                    $count2++;
                                }

                                $count3 = 1;

                                while ($count3 <= $no_stars) {
                                    echo '<span class="fa fa-star"></span>';
                                    $count3++;
                                }
                            }
                            echo '<hr />
                                                <p class="card-text"></p>
                                                <p class="card-text"><small class="text-muted">' . $row['date_created'] . '</small></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            ';
                        }
                    }
                    ?>

                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="dashboard/js/scripts.js"></script>
</body>

</html>