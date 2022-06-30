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
    $filename = getRandomString(5) .'.'. $extension;
    file_put_contents($filename, $contents);
    return $filename;
}

function getBaseUrl(){
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

    if (isset($_POST['upload_file'])) {
        $filename = $_FILES["UploadFileName"]["tmp_name"];
        $ext = pathinfo($_FILES["UploadFileName"]['name'], PATHINFO_EXTENSION);
        encrypt_file($filename, $_SERVER['DOCUMENT_ROOT'] . '/sample.'.$ext, 'secretPassword');
    }
    
    if(isset($_POST['decrypt_file']))
    {
        $ext="xlsx";
        $dec_url = $_SERVER['DOCUMENT_ROOT'] . '/sample.'.$ext;
        // Output to inline PDF
        $decrypted = decrypt_file($dec_url, $ext , 'secretPasswords');
        echo "<a href='". $decrypted. "' target='_blank'>Decrypted File</a>";
    }
    
?>


<form method="post" enctype="multipart/form-data">
    <input type="file" name="UploadFileName">
    <input type="submit" name="upload_file">
    <input type="submit" name="decrypt_file" value="decrypt fissle">
</form>