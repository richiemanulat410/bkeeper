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
                <h1 class="mt-4">Your Documents</h1>
                <!-- <p>The starting state of the menu will appear collapsed on smaller screens, and will appear non-collapsed on larger screens. When toggled using the button below, the menu will change.</p> -->
                <div class="row">
                    <div class="col-md-4">
                        <div class="input-group mb-3 mr-2">
                            <input type="text" class="form-control" placeholder="Search for Documents">
                            <button class="btn btn-outline-secondary" type="button" id="button-addon2">Search</button>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <a href="bkeeper-add-document.php?id=<?php echo $_GET['id']?>" class="btn btn-outline-success" id="button-addon2">Add Document <i class="fa fa-file"></i></a>

                    </div>
                </div>
                <div class="row">
                    <?php
               
                    $sql = "SELECT *, 
                    (SELECT name from users WHERE users.id = bkeeps.user_id) as `name`,
                    (SELECT role from users WHERE users.id = bkeeps.user_id) as `role`
                     FROM bkeeps WHERE user_id = " . $_SESSION['user_id']. "  OR user_id IN (SELECT bkeeper_id FROM bkeepers WHERE client_id = " . $_GET['id'] . ")";
                    $result = mysqli_query($conn, $sql);
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo '<div class="col-md-3">
                                    <div class="card mb-3 shadow bg-body rounded">
                                        <div class="row g-0">
                                            <div class="card-body">
                                                <h4 class="card-title text-primary"><a class="text-decoration-none" 
                                                href="bkeeper-documents-content.php?id=' . $row['id'] . '">' . $row['title'] . '';

                            $extension = explode(".", $row['file']);
                            if ($extension[1] === "plain") {
                                echo ' <i class="fa fa-file-text"></i>  ';
                            } else if ($extension[1] === "docx") {
                                echo ' <i class="fa fa-file-word"></i>  ';
                            } else if ($extension[1] === "xlsx") {
                                echo ' <i class="fa fa-file-excel"></i>  ';
                            }


                            echo '</a></h4>

                                                <hr />
                                                <p class="card-text">' . $row['description'] . '</p>
                                                <small class="text-muted">Uploader: ' . $row['name'] . '';

                            if ($row['role'] == 'client') {
                                echo ' <span class="badge bg-primary">Owner</span>';
                            } else {
                                echo ' <span class="badge bg-success">Bkeeper</span>';
                            }
                            echo '</small>
                                                <p class="card-text"><small class="text-muted">' . $row['date'] . '</small></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>';
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