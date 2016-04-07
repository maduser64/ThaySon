<!DOCTYPE html>
<html>
    <body>

        <form action="upload.php" method="post" enctype="multipart/form-data">
            Select file to upload:
            <input type="file" name="fileToUpload" id="fileToUpload">
            <input type="submit" value="Upload Image" name="submit">
        </form>

    </body>
</html>

<?php
session_start();

require_once __DIR__ . '/host.php';
require_once $ROOT . '/readExcel.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
}


if (isset($_POST["submit"])) {
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
//$target_file = $target_dir . $_SESSION['user_id'] . '.xlsx';

    $uploadOk = 1;
    $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
    //if (file_exists($target_file)) {
    //    echo "Sorry, file already exists.";
    //}
    //if ($_FILES["fileToUpload"]["size"] > 500000) {
    //    echo "Sorry, your file is too large.";
    //    $uploadOk = 0;
    //}
    if ($imageFileType != "xlsx") {
        echo "Sorry, only xlsx files are allowed.";
        $uploadOk = 0;
    }
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            echo "The file " . basename($_FILES["fileToUpload"]["name"]) . " has been uploaded.";

            $sheetData = getListMemberFromExel($target_file);
            $count = sizeof($sheetData);
            //var_dump($sheetData);
            echo '<br> chay bai 2 :  - -- - - ';
            echo 'count: ' . $count . '<br>';
            for ($i = 1; $i <= $count; $i++) {
                for ($j = 'A'; $j <= 'M'; $j++) {
                    echo $sheetData[$i][$j] . ' ';
                }
                echo '<br>';
            }
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}
?>