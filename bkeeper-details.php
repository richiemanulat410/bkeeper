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
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
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
                <h1 class="mt-4 text-center text-info">MY RESUME</h1>
                <?php
                if (isset($_POST['save_resume'])) {

                    $sql = "SELECT * FROM bkeeper_content WHERE bkeeper_id = " . $_SESSION['user_id'];
                    $result = mysqli_query($conn, $sql);
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            $sql2 = "UPDATE bkeeper_content SET content = '" . htmlspecialchars(base64_encode($_POST['content'])) . "' WHERE bkeeper_id=" .
                                $_SESSION['user_id'];

                            if ($conn->query($sql2) === TRUE) {
                                echo '<h1 class="mt-4 text-success">Successfully Updated Resume</h1>';
                            } else {
                                echo '<h1 class="text-danger">Error updating record: ' . $conn->error . '</h1>';
                            }
                        }
                        
                    } else {
                        $sql3 = "INSERT INTO bkeeper_content (content, bkeeper_id)
                        VALUES ('" . htmlspecialchars(base64_encode($_POST['content'])) . "', '" . $_SESSION['user_id'] . "')";

                        if (mysqli_query($conn, $sql3)) {
                            echo '<h1 class="mt-4 text-success">Successfully Saved Resume</h1>';
                        } else {
                            echo "Error: " . $sql3 . "<br>" . mysqli_error($conn);
                        }
                    }


                }
                ?>
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <textarea name="content" id="your_summernote" class="form-control" rows="5">
                               <?php
                                $sql = "SELECT * FROM bkeeper_content WHERE bkeeper_id = " . $_SESSION['user_id'];
                                $result = mysqli_query($conn, $sql);
                                if (mysqli_num_rows($result) > 0) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                       echo base64_decode($row['content']);
                                    }
                                }
                               ?>
                        </textarea>
                    </div>
                    <button class="btn btn-primary btn-lg" type="submit" name="save_resume">SAVE RESUME</button>
                </form>
            </div>
        </div>
    </div>
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="dashboard/js/scripts.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js""></script>
    <!-- <script src=" https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script> -->

    <!-- Summernote JS - CDN Link -->
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#your_summernote").summernote({
                height: 500
            });
            $('.dropdown-toggle').dropdown();
        });
    </script>

</body>

</html>