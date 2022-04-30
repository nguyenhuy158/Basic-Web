<?php

if (!empty($_POST['directory'])) {
    $directory = $_POST['directory'];
    $path = $_FILES['path'];

    // echo $path['name'];
    // echo $path['type'];
    // echo $path['tmp_name'];
    // echo $path['error'];
    // echo $path['size'];
    echo move_uploaded_file($path['tmp_name'], $directory . '\\' . $path['name']);
    echo "success";
} else {
    echo "fail";
}
