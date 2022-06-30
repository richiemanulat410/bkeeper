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
        include('bkeeper-sidebar.php');
        ?>
        <!-- Page content wrapper-->
        <div id="page-content-wrapper">
            <?php
            include('bkeeper-nav.php');
            ?>
            <!-- Page content-->
            <div class="container-fluid">
                <h1 class="mt-4 text-center text-info">BOOKKEEPER MANAGEMENT SYSTEM</h1>
                <div class="row">
                    <div class="col-md-4">
                        <div class="card px-3 py-5 shadow bg-primary">
                            <div class="row">
                                <div class="col-md-4">
                                    <h1 class="text-light" style="font-size: 60px">23</h1>
                                </div>
                                <div class="col-md-8">
                                    <h2 class="text-light">No. of Clients</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card px-3 py-5 shadow bg-success">
                            <div class="row">
                                <div class="col-md-4">
                                    <h1 class="text-light" style="font-size: 60px">23</h1>
                                </div>
                                <div class="col-md-8">
                                    <h2 class="text-light">No. of Transactions</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card px-3 py-5 shadow bg-warning">
                            <div class="row">
                                <div class="col-md-4">
                                    <h1 class="text-light" style="font-size: 60px">23</h1>
                                </div>
                                <div class="col-md-8">
                                    <h2 class="text-light">No. of Documents</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- <p>The starting state of the menu will appear collapsed on smaller screens, and will appear non-collapsed on larger screens. When toggled using the button below, the menu will change.</p>
                <p>
                    Make sure to keep all page content within the
                    <code>#page-content-wrapper</code>
                    . The top navbar is optional, and just for demonstration. Just create an element with the
                    <code>#sidebarToggle</code>
                    ID which will toggle the menu when clicked.
                </p> -->
            </div>
        </div>
    </div>
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="dashboard/js/scripts.js"></script>
</body>

</html>