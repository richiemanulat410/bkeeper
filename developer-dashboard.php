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
</head>

<body>
    <div class="d-flex" id="wrapper">
        <?php
        include('developer-sidebar.php');
        ?>
        <!-- Page content wrapper-->
        <div id="page-content-wrapper">
            <?php
            include('developer-nav.php');
            ?>
            <!-- Page content-->
            <div class="container-fluid">
                <h1 class="mt-4">Welcome to BKEEPER MANAGEMENT SYSTEM!</h1>
            </div>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <th></th>
                        <th>#</th>
                        <th>Name</th>
                        <th>Role</th>
                        <th>Email</th>
                        <th>Address</th>
                        <th>Gender</th>
                        <th>Joined Since</th>
                        <th>Status</th>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT * FROM users WHERE role != 'admin' ORDER BY status ASC";
                        $result = mysqli_query($conn, $sql);
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                $action = '';
                                if($row['status'] === null)
                                {
                                    $action = '<a href="/developer-approve.php?id='.$row['id'].'" class="btn btn-success"><i class="fa fa-check"></i></a>';
                                } else {
                                    $action = '<a href="/developer-deny.php?id='.$row['id'].'" class="btn btn-warning"><i class="fa fa-edit"></i></a>';
                                }
                                echo '<tr>
                                    <td><img src="/profile_pictures/' . $row['profile_picture'] . '" width="50px" /></td>
                                    <td>'.$row['id'].'</td>
                                    <td>'.$row['name'].'</td>
                                    <td>'.$row['role'].'</td>
                                    <td>'.$row['email'].'</td>
                                    <td>'.$row['address'].'</td>
                                    <td>'.$row['gender'].'</td>
                                    <td>'.$row['date_created'].'</td>
                                    <td>'.$action.'</td>
                                </tr>';
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="dashboard/js/scripts.js"></script>
</body>

</html>