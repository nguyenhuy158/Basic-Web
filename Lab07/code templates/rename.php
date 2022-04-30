<?php

if (!empty($_POST['path']) && !empty($_POST['newName'])) {
    $path = $_POST['path'];
    $newName = $_POST['newName'];
    rename($path, $newName);
    echo "success";
} else {
    echo "fail";
}
