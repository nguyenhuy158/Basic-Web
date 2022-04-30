<?php

if (!empty($_POST['path']) && !empty($_POST['content'])) {
    $path = $_POST['path'];
    $content = $_POST['content'];
    $file_handle = fopen($path, 'w');
    fwrite($file_handle, $content);

    echo "success";
} else if (!empty($_POST['path'])) {
    $path = $_POST['path'];

    mkdir($path);
    echo "success";
} else {
    echo "fail";
}
