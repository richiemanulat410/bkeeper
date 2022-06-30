<?php
session_start();

if (!isset($_SESSION['role'])) {
    echo '<script>window.location.href="login.php"</script>';
}
require("connection.php");

// if(!isset($_GET['id'])){
//     echo '<script>window.location.href="admin-documents.php"</script>';
// }
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
                <h1 class="mt-4">Welcome to BKEEPER MANAGEMENT SYSTEM!</h1>
                <?php
                $success = false;

                function decrypt_file($file, $extension, $passphrase)
                {
                    $iv = substr(md5("\x1B\x3C\x58" . $passphrase, true), 0, 8);
                    $key = substr(md5("\x2D\xFC\xD8" . $passphrase, true) .
                        md5("\x2D\xFC\xD9" . $passphrase, true), 0, 24);
                    $opts = array('iv' => $iv, 'key' => $key);
                    $fp = fopen($file, 'rb');
                    stream_filter_append($fp, 'string.rot13', STREAM_FILTER_READ, $opts);

                    $contents = fread($fp, filesize($file));
                    $filename = getRandomString(5) . '.' . $extension;
                    file_put_contents($filename, $contents);
                    return $filename;
                }

                function getBaseUrl()
                {
                    if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
                        $link = "https";
                    else $link = "http";

                    // Here append the common URL characters.
                    $link .= "://";

                    // Append the host(domain name, ip) to the URL.
                    $link .= $_SERVER['HTTP_HOST'];

                    // Append the requested resource location to the URL
                    return $link;
                }

                function getRandomString($n)
                {
                    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                    $randomString = '';

                    for ($i = 0; $i < $n; $i++) {
                        $index = rand(0, strlen($characters) - 1);
                        $randomString .= $characters[$index];
                    }

                    return $randomString;
                }
                ?>
                <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $file_id = $_POST['file_for_id'];
                    $password = $_POST['password'];
                    $sql2 = "SELECT * FROM users WHERE password = '" . $password . "' AND id = '" . $_SESSION['user_id']."'";
                    $result2 = mysqli_query($conn, $sql2);
                    if (mysqli_num_rows($result2) > 0) {
                        $sql = "SELECT * FROM bkeeps WHERE id = '" . $file_id . "'";
                        $result = mysqli_query($conn, $sql);
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                $extension = explode(".", $row['file']);
                                $ext = $extension[1];
                                $dec_url = $_SERVER['DOCUMENT_ROOT'] . '/bkeeps/' . $row['file'];
                                // Output to inline PDF
                                $decrypted = decrypt_file($dec_url, $ext, 'secretPasswords');
                                echo "<a class='btn btn-primary' href='" . $decrypted . "' target='_blank'>Decrypted File</a> 
                            <a class='btn btn-danger' href='admin-documents.php'>Back</a>";
                                $success = true;
                            }
                        }
                    }else{
                        echo '<div class="alert alert-danger" role="alert">
                                            Password was incorrect
                                        </div>';
                    }
                }
                ?>

                <?php
                if ($success === false) :
                ?>
                    <p>Are you sure you want to download the Decrypted File?</p>
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                        <input type="hidden" value="<?php echo $_GET["id"] ?>" name="file_for_id" id="file_for_id" />
                        <div class="form-group col-md-4 mb-2">
                            <label for="password">Please Enter Your password to decrypt file</label>
                            <input type="password" name="password" class="form-control" />
                        </div>
                        <button type="submit" class="btn btn-primary">Yes</button>
                        <a href="admin-documents-content.php?id=<?php echo $_GET['id']; ?>" class="btn btn-danger">No</a>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="dashboard/js/scripts.js"></script>
</body>

</html>