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
                <h1 class="mt-4">Are you sure you want to Apply to this Client?</h1>
                <div class="row">
                    <?php
                    if (isset($_POST['submit_yes'])) {
                        $client_id = $_POST['client_id'];

                        $sql = "INSERT INTO applicants (bkeeper_id, client_id, status)
                                VALUES (" . $_SESSION['user_id'] . ", " . $client_id . ", 0)";

                        if (mysqli_query($conn, $sql)) {
                            echo '<script>alert("Successfully Applied to Client!"); window.location.href="bkeeper-clients.php";</script>';
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
                            if ($row['status']) {
                            } else {
                                echo '<span class="fa fa-star checked"></span>
                                                        <span class="fa fa-star "></span>
                                                        <span class="fa fa-star "></span>
                                                        <span class="fa fa-star"></span>
                                                        <span class="fa fa-star"></span>';
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
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <input type="hidden" name="client_id" value="<?php echo $_GET['id'] ?>" />
                    <input class="btn btn-primary px-4" type="submit" value="Yes" name="submit_yes" />
                    <a href="bkeeper-find-client.php" class="btn btn-danger px-4">No</a>
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