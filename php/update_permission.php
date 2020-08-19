<?php
    require_once "functions.php";
    db_connect();
    if ($_GET['permission'] == "0") {
        $updated_permission = "1";
    } else {
        $updated_permission = "0";
    }
    $sql = "UPDATE posts SET posts.isPrivate = {$updated_permission} WHERE posts.id = {$_GET['id']}";
    $statement = $conn->prepare($sql);
    if ($statement->execute()) {
        redirect_to('/dashboard.php');
    }
