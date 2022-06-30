<?php
session_start();

if (!isset($_SESSION['role'])) {
    echo '<script>window.location.href="login.php"</script>';
}
$client_id = $_GET['id'];
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
        include('bkeeper-sidebar.php');
        ?>
        <!-- Page content wrapper-->
        <div id="page-content-wrapper">
            <?php
            include('bkeeper-nav.php');
            ?>
            <!-- Page content-->
            <div class="container-fluid">
                <h1 class="mt-4">Messages</h1>
                <!-- <p>The starting state of the menu will appear collapsed on smaller screens, and will appear non-collapsed on larger screens. When toggled using the button below, the menu will change.</p> -->
                <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $sql = "INSERT INTO messages (`sender_id`, `receiver_id`, `message`, `date`)
                                VALUES ('" . $_SESSION['user_id'] . "',' " . $client_id . "', '" . $_POST['message']
                        . "', '" . date('Y-m-d H:i:s') . "')";

                    if (mysqli_query($conn, $sql)) {
                        echo "<p class='text-success'>Messsage Sent!</p>";
                    } else {
                        echo "<p class='text-danger>' Error message sending : " . $conn->error . '</p>';
                    }
                }
                ?>
                <div class="card p-5 shadow" style="overflow-y: auto; height:350px;">
                    <?php
                    $sql = "SELECT * FROM messages join users on messages.sender_id = users.id WHERE sender_id = " . $client_id . " OR receiver_id = " . $client_id . " OR sender_id = " . $_SESSION['user_id'] . " OR receiver_id = " . $_SESSION['user_id'] . " ORDER BY date ASC";
                    $result = mysqli_query($conn, $sql);
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            if ($row['sender_id'] === $_SESSION['user_id']) {
                                echo ' <div class="row mb-2">
                        <div class="col-md-6"></div>
                        <div class="col-md-6 bg-primary p-3" style="border-radius:15px">
                            <h6 class="text-light">' . $row['name'] . '</h6>
                            <p class="text-light">' . $row['message'] . '</p>
                            <span class="text-light">' . $row['date'] . '</span>
                        </div>
                    </div>';
                            } else {
                                echo '<div class="row mb-2">
                                    <div class="col-md-6 bg-default p-3 mb-3" style="border:1px solid #ccc;  border-radius:15px">
                                        <h6>' . $row['name'] . '</h6>
                                        <p>' . $row['message'] . '</p>
                                        <span class="text-muted">' . $row['date'] . '</span>
                                    </div>
                                </div>';
                            }
                        }
                    }
                    ?>



                </div>
                <!-- end card -->
                <form action="" method="POST" class="mt-3 shadow mb-5 p-2">
                    <div class="form-group mb-2">
                        <input type="hidden" name="client_id" value="<?php echo $client_id ?>" />
                        <textarea class="form-control" name="message" id="" cols="30" rows="5"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Send <i class="fa fa-paper-plane"></i></button>

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