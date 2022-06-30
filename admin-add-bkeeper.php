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
                <h1 class="mt-4">Are you sure you want to add BKeeper?</h1>
                <div class="row">
                    <?php
                    if (isset($_POST['submit_yes'])) {
                        $bkeeper_id = $_POST['bkeeper_id'];

                        $sql = "INSERT INTO bkeepers (client_id, bkeeper_id, status)
                                VALUES (" . $_SESSION['user_id'] . ", " . $bkeeper_id . ", 1)";

                        $sql2 = "DELETE FROM applicants WHERE bkeeper_id =".$bkeeper_id;

                        if (mysqli_query($conn, $sql)) {
                            mysqli_query($conn, $sql2);

                            echo '<script>alert("Successfully Added a BKeeper!"); window.location.href="admin-my-bkeepers.php";</script>';
                        } else {
                            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                        }
                    }
                    ?>
                    <?php
                    $sql = "SELECT * FROM users WHERE id = " . $_GET['id'];
                    $result = mysqli_query($conn, $sql);
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo
                            '<div class="col-lg-8 col-md-12">
                                <div class="card mb-3 shadow bg-body rounded">
                                   <div class="card-body">
                                    <div class="container">

                                      <img src="profile_pictures/' . $row['profile_picture'] . '" width="100px" height="100px" alt="Avatar" class="avatar mt-5 mx-3">

                                                <h2 class="card-title text-primary">' . $row['name'] .
                                '</h2>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <h6 class="text-muted">
                                                            <div class="row">
                                                                <div class="col-md-1">
                                                                <i class="fa fa-envelope"></i> 
                                                                </div>
                                                                <div class="col-md-11">
                                                                ' . $row['email'] . '
                                                                </div>
                                                            </div>
                                                        </h6>

                                                        <h6 class="text-muted">
                                                            <div class="row">
                                                                <div class="col-md-1">
                                                                <i class="fa fa-map-marker"></i> 
                                                                </div>
                                                                <div class="col-md-11">
                                                                ' . $row['address'] . '
                                                                </div>
                                                            </div>
                                                        </h6>
                                                    </div>
                                                </div>
                                                ';
                            //  <h4 class="card-title text-primary">' . $row['name'] . '
                            //     <a href="admin-add-bkeeper.php?id=' . $row['id'] . '" class="btn btn-primary btn-sm"><i class="fa fa-user-plus"></i> Add</a>
                            // </h4>

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

                            $sql2 = "SELECT * FROM bkeeper_content WHERE bkeeper_id =" . $row['id'];
                            $result2 = mysqli_query($conn, $sql2);
                            if (mysqli_num_rows($result2) > 0) {
                                while ($row2 = mysqli_fetch_assoc($result2)) {
                                    echo base64_decode($row2['content']);
                                }
                            }

                            echo '<hr />
                                    <p class="card-text"><small class="text-muted"> Joined Since ' . $row['date_created'] . '</small></p>
                                    </div>
                                </div>
                                </div>
                            </div>
                            ';
                        }
                    }
                    ?>

                </div>
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <input type="hidden" name="bkeeper_id" value="<?php echo $_GET['id'] ?>" />
                    <input class="btn btn-primary px-4" type="submit" value="Yes" name="submit_yes" />
                    <a href="admin-find-bkeepers.php" class="btn btn-danger px-4">No</a>
                </form>
            </div>
        </div>
    </div>
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="dashboard/js/scripts.js"></script>
</body>

</html>