<?php
function delTree($dir)
{
    $files = array_diff(scandir($dir), array('.', '..'));

    foreach ($files as $file) {
        (is_dir("$dir/$file")) ? delTree("$dir/$file") : unlink("$dir/$file");
    }

    return rmdir($dir);
}

if (!empty($_POST['path'])) {
    $path = $_POST['path'];
    if (is_file($path)) {
        // echo 'file';
        unlink($path);
    } else {
        // rmdir($path);
        // echo 'not file';
        delTree($path);
    }
    echo "\n";
    echo "success";
} else {
    echo "fail";
}
