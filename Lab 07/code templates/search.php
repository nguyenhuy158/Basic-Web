<?php

// if (!empty($_POST['path']) && !empty($_POST['query'])) {
if (!empty($_POST['path']) && !empty($_POST['query'])) {
    $path = $_POST['path'];
    $query = $_POST['query'];
    $listDirectory = array_diff(scandir($path), array('.', '..'));
    $result = array();

    foreach ($listDirectory as $key => $value) {
        if (strpos(strtolower($value), strtolower($query)) !== false) {
            array_push($result, $value);
        }
    }
    echo json_encode($result);
} else if (!empty($_POST['path'])) {
    $path = $_POST['path'];
    $query = $_POST['query'];
    $listDirectory = array_diff(scandir($path), array('.', '..'));
    $result = array();

    foreach ($listDirectory as $key => $value) {
        array_push($result, $value);
    }
    echo json_encode($result);
} else {
    echo "fail";
}
