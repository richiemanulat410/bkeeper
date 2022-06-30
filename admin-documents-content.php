<?php
session_start();

if (!isset($_SESSION['role'])) {
    echo '<script>window.location.href="login.php"</script>';
}
require("connection.php");
if (isset($_GET['id'])) {
    $_SESSION["id"] = $_GET['id'];
}
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
        include('admin-sidebar.php');
        ?>
        <!-- Page content wrapper-->
        <div id="page-content-wrapper">
            <?php
            include('admin-nav.php');
            ?>
            <!-- Page content-->
            <div class="container-fluid">
                <h1 class="mt-4">Document Content</h1>
                <!-- <p>The starting state of the menu will appear collapsed on smaller screens, and will appear non-collapsed on larger screens. When toggled using the button below, the menu will change.</p> -->

                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="admin-documents.php">Documents</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Content</li>
                    </ol>
                </nav>

                <div class="row">
                    <div class="col-md-5">
                        <?php

                        $currentDate = new DateTime();

                        if (isset($_POST['add_comment'])) {
                            echo "payts";
                            $sql3 = "INSERT INTO comments (comment, user_id, document_id, date)
                        VALUES ('".$_POST['comment']."', '".$_SESSION['user_id']."', '".$_SESSION['id']."', '". $currentDate->format('Y-m-d H:i:s')."')";

                            if (mysqli_query($conn, $sql3)) {
                                echo '<h1 class="mt-4 text-success">Saved Comment!</h1>';
                            } else {
                                echo "Error: " . $sql3 . "<br>" . mysqli_error($conn);
                            }
                        }
                        ?>

                        <?php
                        $sql = "SELECT *, 
                    (SELECT name from users WHERE users.id = bkeeps.user_id) as `name`,
                    (SELECT role from users WHERE users.id = bkeeps.user_id) as `role`
                     FROM bkeeps WHERE id = " . $_SESSION["id"];
                        $result = mysqli_query($conn, $sql);
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo '
                                    <div class="card mb-3 shadow bg-body rounded">
                                        <div class="row g-0">
                                            <div class="card-body">
                                                <h4 class="card-title text-primary">' . $row['title'] . '';

                                $extension = explode(".", $row['file']);
                                if ($extension[1] === "plain") {
                                    echo ' <i class="fa fa-file-text"></i>  ';
                                } else if ($extension[1] === "docx") {
                                    echo ' <i class="fa fa-file-word"></i>  ';
                                } else if ($extension[1] === "xlsx") {
                                    echo ' <i class="fa fa-file-excel"></i>  ';
                                }


                                echo '</h4>
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
                                                <a href="admin-decrypt-file.php?id=' . $_SESSION["id"] . '" class="btn btn-outline-primary">Download Decrypted File</a>
                                                <a href="admin-decrypt-file-email.php?id=' . $_SESSION["id"] . '" class="btn btn-primary">Send Decrypted File on Email</a>
                                            </div>
                                        </div>
                                    </div>';
                            }
                        }
                        ?>
                        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                            <div class="form-group">
                                <textarea class="form-control" name="comment" id="" rows="5" placeholder="Give Feedback or Comment . . ."></textarea>
                            </div>
                            <button class="btn btn-primary" type="submit" name="add_comment">Add Comment</button>
                        </form>
                    </div>
                    <div class="col-md-5">
                        <h4 class="text-primary">Comments</h4>
                        <?php
                        $sql = "SELECT date, comment, document_id, 
                        (SELECT name from users where id = '" . $_SESSION['user_id'] . "') as `name` FROM comments
                          WHERE document_id = " . $_SESSION["id"] ." ORDER BY date ASC";
                        $result = mysqli_query($conn, $sql);

                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo '
                                    <span class="text-muted">'. $row['date']. '</span> <br />
                                    <span class="text-muted">By: '.$row['name']. ' </span>
                                    <p><b>' . $row['comment'] . '</b></p>
                                ';
                            }
                        }
                        ?>
                    </div>
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