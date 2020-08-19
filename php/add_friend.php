<?php
    require_once "functions.php";
    db_connect();
    $sql = "INSERT INTO friend_requests (user_id, friend_id) VALUES (?, ?)";
    $statement = $conn->prepare($sql);

    // get all members that are not friends with the session user.
    $sql = "SELECT id, username, (SELECT COUNT(*) FROM user_friends WHERE user_friends.user_id = users.id AND user_friends.friend_id = {$_SESSION['user_id']}) AS is_friend FROM users WHERE id != {$_SESSION['user_id']} HAVING is_friend = 0";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {      
        while($fc_user = $result->fetch_assoc()) {
            if($fc_user["username"] == $_GET['uname']) {
                $id = $fc_user["id"];
            }
        }
    }
    $statement->bind_param('ii', $_SESSION['user_id'], $id);
    if ($statement->execute()) {
        redirect_to("/dashboard.php?request_sent=true");
    } elseif (!isset($id)) {
        echo "There isnt a member with this name. Please go back and try again.";
    } else {
        echo "Error: " . $conn->error;
    }
