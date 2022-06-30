<?php
session_start();

if (!isset($_SESSION['role'])) {
    echo '<script>window.location.href="login.php"</script>';
}
require("connection.php");
$id = '';
if (isset($_GET['id'])) {
    $id = $_GET['id'];
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
        include('developer-sidebar.php');
        ?>
        <!-- Page content wrapper-->
        <div id="page-content-wrapper">
            <?php
            include('developer-nav.php');
            ?>
            <!-- Page content-->
            <div class="container-fluid">

                <?php
                if (isset($_POST['deny_button'])) {
                    $id = $_POST['id'];
                    $sql = "UPDATE users SET status=null WHERE id=".$id;

                    if ($conn->query($sql) === TRUE) {
                        echo '<h1 class="mt-4 text-danger">User was Deactivated!</h1>';
                    } else {
                        echo '<h1 class="text-danger">Error updating record: ' . $conn->error.'</h1>';
                    }
                } else {
                    echo '<h1 class="mt-4">Are you Sure you want to Approve User?</h1>';
                }
                ?>
                <?php
                $sql = "SELECT * FROM users WHERE id=" . $id;
                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<img src="/profile_pictures/' . $row['profile_picture'] . '" width="80px" />
                        <h1>' . $row['name'] . '</h1>
                        <div class="badge bg-warning">' . $row['role'] . '</div>
                        <p>' . $row['email'] . '</p>
                        <p>' . $row['address'] . '</p>
                        <p>' . $row['gender'] . '</p>
                        <p>' . $row['date_created'] . '</p>
                        <img src="/valid_ids/' . $row['valid_id'] . '" width="200px" />
                        ';
                    }
                }
                ?>
                <hr />
                <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <input name="id" value="<?php echo $_GET['id'] ?>" type="hidden" />
                    <?php
                    if (isset($_POST['deny_button'])) {
                    } else {
                        echo ' <button class="btn btn-danger" type="submit" name="deny_button">Deactivate User</button>
                    <a href="/developer-dashboard.php" class="btn btn-secondary">Cancel</a>';
                    }
                    ?>

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