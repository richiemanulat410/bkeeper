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
        include('admin-sidebar.php');
        ?>
        <!-- Page content wrapper-->
        <div id="page-content-wrapper">
            <?php
            include('admin-nav.php');
            ?>
            <!-- Page content-->
            <div class="container-fluid">
                <h1 class="mt-4">Add Document</h1>
                <!-- <p>The starting state of the menu will appear collapsed on smaller screens, and will appear non-collapsed on larger screens. When toggled using the button below, the menu will change.</p> -->

                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="admin-documents.php">Documents</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Add Document</li>
                    </ol>
                </nav>
                <?php
                function encrypt_file($file, $destination, $passphrase)
                {
                    // Open the file and returns a file pointer resource.
                    $handle = fopen($file, "rb") or die("Could not open a file.");
                    // Returns the read string.
                    $contents = fread($handle, filesize($file));
                    // Close the opened file pointer.
                    fclose($handle);

                    $iv = substr(md5("\x1B\x3C\x58" . $passphrase, true), 0, 8);
                    $key = substr(md5("\x2D\xFC\xD8" . $passphrase, true) . md5("\x2D\xFC\xD9" . $passphrase, true), 0, 24);
                    $opts = array('iv' => $iv, 'key' => $key);
                    $fp = fopen($destination, 'wb') or die("Could not open file for writing.");
                    // Add the Mcrypt stream filter with Triple DES
                    stream_filter_append($fp, 'string.rot13', STREAM_FILTER_WRITE, $opts);
                    // Write content in the destination file.
                    fwrite($fp, $contents) or die("Could not write to file.");
                    // Close the opened file pointer.
                    fclose($fp);
                }

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
                    $title = $_POST['title'];
                    $description = $_POST['description'];
                    $currentDate = new DateTime();
                    $filename = $_FILES["UploadFileName"]["tmp_name"];
                    $ext = pathinfo($_FILES["UploadFileName"]['name'], PATHINFO_EXTENSION);


                    $file_with_xtension = getRandomString(8) . '.' . $ext;

                    encrypt_file($filename, $_SERVER['DOCUMENT_ROOT'] . '/bkeeps/' . $file_with_xtension, 'secretPassword');

                    $sql = "INSERT INTO bkeeps (title, description, file, status, user_id, date)
                        VALUES ('" . $title . "','" . $description . "','" . $file_with_xtension . "' , 1,'" . $_SESSION['user_id'] . "','" . $currentDate->format('Y-m-d H:i:s') . "')";

                    if (mysqli_query($conn, $sql)) {
                        echo '<div class="alert alert-success" role="alert">
                                                    Document was succcessfully saved!
                                                </div>';
                    } else {
                        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                    }

                    mysqli_close($conn);

                }
                ?>

                <div class="col-md-4">
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" role="form" class="php-email-form" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" name="title" id="title" required>
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea name="description" id="description" cols="30" rows="4" class="form-control"></textarea>
                        </div>
                        <div class="form-group mb-2">
                            <label for="UploadFileName">Upload File</label>
                            <input type="file" class="form-control" name="UploadFileName" id="UploadFileName" required>
                        </div>
                        <button class="btn btn-primary" type="submit">Add Document</button>
                    </form>
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