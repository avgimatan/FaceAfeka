<?php include "templates/header.php" ?>
<?php require_once "php/functions.php" ?>
<?php
check_auth();
db_connect();
?>
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.min.js"></script>
  <script src="js\search.js"></script>

<!-- main -->
<main class="container">
    <div class="row">
        <div class="col-md-3">
            <!-- profile brief -->
            <div class="panel panel-default">
                <div class="panel-body">
                    <p>Hello,</p>
                    <h4><?php echo $_SESSION['user_username'] ?></h4>
                </div>
            </div>
            <!-- ./profile brief -->

            <!-- friend requests -->
            <div class="panel panel-default">
                <div class="panel-body">
                <h4>Friends Requests</h4>
                <?php
                    $sql = "SELECT * FROM friend_requests WHERE friend_id = {$_SESSION['user_id']}";

                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        ?><ul><?php

                        while($f_request = $result->fetch_assoc()) {
                            ?><li><?php

                            $u_sql = "SELECT * FROM users WHERE id = {$f_request['user_id']} LIMIT 1";
                            $u_result = $conn->query($u_sql);
                            $fr_user = $u_result->fetch_assoc();

                            ?><a href="profile.php?username=<?php echo $fr_user['username']; ?>">
                                <?php echo $fr_user['username']; ?>
                            </a> 

                            <a class="text-success" href="php/accept_request.php?uid=<?php echo $fr_user['id']; ?>">
                                [accept]
                            </a> 

                            <a class="text-danger" href="php/remove_request.php?uid=<?php echo $fr_user['id']; ?>">
                                [decline]
                            </a>

                            </li><?php
                        }

                        ?></ul><?php
                    } else {
                        ?><p class="text-center">No Friends Requests!</p><?php
                    }
                ?>
                </div>
            </div>
            <!-- ./friend requests -->
    
        </div>
        <div class="col-md-6">
            <!-- post form -->

            <form method="post" action="php/create_post.php" id="add_post" enctype="multipart/form-data">
                <div >
                    <input class="form-control" type="text" name="content" placeholder="Make a post…">
                </div>
                <div>
                    <input class="btn btn-primary" type="file" id="uploadFile" name="uploadFile[]" multiple />               
                    <div id="image_preview"></div>
                </div>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="privateChec" name="privatePost" value="true">
                    <label class="form-check-label" for="privateChec">Private Post</label>
                </div>
                <div>
                    <button class="btn btn-success" type="submit" name="post">Post</button>
                </div>
            </form>
            <hr>
            <!-- ./post form -->
            <!-- feed -->
            <div>
                <!-- post -->
                <?php
                $sql = "SELECT posts.id as post_id, posts.*, users.* FROM posts LEFT JOIN users ON posts.user_id = users.id WHERE posts.user_id = {$_SESSION['user_id']} OR (posts.user_id != {$_SESSION['user_id']} AND posts.isPrivate = 0) ORDER BY date DESC";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($post = $result->fetch_assoc()) {
                        ?>
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <p><?php echo $post['text']; ?></p>
                            </div>
                            <?php
                            $query = $conn->query("SELECT * FROM images WHERE post_id={$post['post_id']}");
                            if($query->num_rows > 0){
                                ?> 
                                <div id="post_image_preview"> 
                                    <?php
                                        while($row = $query->fetch_assoc()){
                                            $imageURL = 'uploads/'.$row["file_name"];
                                    ?>
                                    <a target="_blank" href="<?php echo $imageURL; ?>">
                                        <img src="<?php echo $imageURL; ?>" alt="" />
                                    </a>
                                    <?php } ?>
                                </div>
                            <?php } ?> 
                            <div class="panel-footer">
                                <span>Posted <?php echo $post['date']; ?> by <?php echo $post['username']; ?></span>
                                <span class="text-muted">
                                    <?php 
                                        if ($post['isPrivate'] == 1) 
                                            echo '(Private)';
                                        else
                                            echo '(Public)';
                                    ?> 
                                </span>
                                <?php if ($post['user_id'] == $_SESSION['user_id']) {?>
                                    <span class="pull-right"><a class="text-danger" href="php/delete_post.php?id=<?php echo $post['post_id']; ?>">[delete]</a></span>
                                    <a href="php/update_permission.php?id=<?php echo $post['post_id']; ?>&permission=<?php echo $post['isPrivate']; ?>">
                                    <?php 
                                        if ($post['isPrivate'] == 1) 
                                            echo '[Make public]';
                                        else
                                            echo '[Make private]';
                                    ?> 
                                    </a>
                                <?php } ?>
                            </div>
                            <!-- post comments -->
                            <div class="panel-body">
                                <?php
                                    $commentSql = "SELECT post_comments.id as comment_id, post_comments.user_id as user_id, post_comments.*, users.* FROM post_comments LEFT JOIN users ON post_comments.user_id = users.id WHERE post_comments.post_id = {$post['post_id']} ORDER BY post_comments.id ASC";
                                    $commentsResult = $conn->query($commentSql);
                                    if ($commentsResult->num_rows > 0){
                                        while ($comment = $commentsResult->fetch_assoc()){
                                        ?>
                                            <li>
                                                <span><?php echo $comment['comment']; ?> (commented by <?php echo $comment['username']; ?>)</span>
                                                <?php if ($comment['user_id'] == $_SESSION['user_id']) {?>
                                                    <span class="pull-rght"> <a class="text-danger" href="php/delete_comment.php?id=<?php echo $comment['comment_id']; ?>">[delete]</a></span>
                                                <?php } ?>
                                            </li>
                                        <?php
                                        }
                                    }
                                    else{
                                        ?>
                                            <p class="text-center">No comments yet!</p>
                                        <?php
                                        
                                    }
                                ?>
                            </div>
                            <div class="pannel-footer">
                                <form method="post" action="php/create_comment.php">
                                    <div class="input-group">
                                        <input class="form-control" type="text" name="comment" placeholder="Add a comment..." required>
                                        <input class="sr-only" type="text" name="post_id" value="<?php echo $post['post_id']?>">
                                        <span class="input-group-btn">
                                            <button class="btn btn-success" type="submit" name="post">Add</button>
                                        </span>
                                    </div>
                                </form>
                            </div>
                        </div><!-- end main post div-->
                    <?php
                    }
                } else {
                    ?>
                    <p class="text-center">No posts yet!</p>
                <?php
                }
                ?>
                <!-- ./post -->
            </div>
            <!-- ./feed -->
        </div>
        <div class="col-md-3">
            <!-- add friend -->
            <div class="panel panel-default">
                <div class="panel-body">
                    <h4>Add Friends</h4>
                    <?php
                        $sql = "SELECT id, username, (SELECT COUNT(*) FROM user_friends WHERE user_friends.user_id = users.id AND user_friends.friend_id = {$_SESSION['user_id']}) AS is_friend FROM users WHERE id != {$_SESSION['user_id']} HAVING is_friend = 0";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {                           
                            $allNames = [];
                            while($fc_user = $result->fetch_assoc()) {                              
                                array_push($allNames, $fc_user['username']);
                            }
                            sort($allNames);
                            ?> 
                            <form autocomplete="off" action="php/add_friend.php">
                                <div class="autocomplete" style="width:160px;">
                                    <input class="form-control" id="myInput" type="text" name="uname" placeholder="Type here...">
                                </div>
                                <input class="btn btn-primary" type="submit" value="Send">
                            </form>
                            <div id="content"></div>
                            <script type="text/javascript">
                                var passedNamesArray = <?php echo '["' . implode('", "', $allNames) . '"]' ?>;                             
                                autocomplete(document.getElementById("myInput"), passedNamesArray);
                            </script>
                            <?php
                        } else {
                            ?><p class="text-center">No users to add!</p><?php
                        }
                    ?>
                </div>
            </div>
            <!-- ./add friend -->

            <!-- friends -->
            <div class="panel panel-default">
                <div class="panel-body">
                   <h4>Friends</h4>
                    <?php
                        $sql = "SELECT id, username, (SELECT COUNT(*) FROM user_friends WHERE user_friends.user_id = users.id AND user_friends.friend_id = {$_SESSION['user_id']}) AS is_friend FROM users WHERE id != {$_SESSION['user_id']} HAVING is_friend > 0 ";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            ?><ul><?php
                            while($fc_user = $result->fetch_assoc()) {
                                ?><li>
                                    <?php echo $fc_user['username']; ?>
                                    <a href="php/unfriend.php?uid=<?php echo $fc_user['id']; ?>">[unfriend]</a>
                                </li><?php
                            }

                            ?></ul><?php
                        } else {
                            ?><p class="text-center">No friends yet!</p><?php
                        }
                    ?>
                </div>
            </div>
            <!-- ./friends -->
            <!-- Game -->
              <div class="panel panel-default">
                <div class="panel-body">
                <h4>Memory Game</h4>
                <button onclick="goToGame()" class="btn btn-primary">Start Play!</button>
                <br></br>
                <h5>Sending request form:</h5>                    
                <form method="post" action="php/create_game_request.php">
                    <div class="form-group">
                        <input id="url" class="form-control" type="text" name="url" placeholder="Enter game url">
                    </div>
                    <div class="form-group">                    
                    <select id="inputFriend" name="to_user" class="form-control"> 
                        <option selected>Choose friend...</option>
                        <?php
                            $sql = "SELECT id, username, (SELECT COUNT(*) FROM user_friends WHERE user_friends.user_id = users.id AND user_friends.friend_id = {$_SESSION['user_id']}) AS is_friend FROM users WHERE id != {$_SESSION['user_id']} HAVING is_friend > 0 ";
                            $result = $conn->query($sql);
                            if ($result->num_rows > 0) {
                                while($fc_user = $result->fetch_assoc()) {
                                ?>
                                    <option value = <?php echo $fc_user['id']; ?>> <?php echo $fc_user['username']; ?> </option>
                                <?php
                                }
                            }
                        ?>
                    </select>
                    </div>
                    <input class="btn btn-primary" type="submit" value="Send request">
                </form>
                <script>
                    function goToGame() {             
                        window.open("http://localHost:3001");
                    }
                </script>
                  <?php
                        $sql = "SELECT game_requests.id as request_id, users.username as from_user, game_requests.url as url FROM game_requests LEFT JOIN users ON game_requests.from_user = users.id WHERE game_requests.to_user = {$_SESSION['user_id']}";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            ?><ul><?php
                            while($game_req = $result->fetch_assoc()) {
                                ?><li>                                 
                                  Game with: <button class="btn btn-default btn-xs" type="button" onclick="open_in_new_tab_and_reload('<?php echo $game_req['url']; ?>',<?php echo $game_req['request_id']; ?>)"> <?php echo $game_req['from_user']; ?></a>
                                </li>                            
                                <?php
                            }
                            ?></ul><?php
                        } else {
                            ?><p class="text-center">No game requests!</p><?php
                        }
                    ?>
                    <script type="text/javascript">
                        function open_in_new_tab_and_reload(url, req_id) {
                            // Open game in new tab
                            window.open(url);
                            // reload current page
                            window.location.href = "php/start_game.php?request_id=" + req_id;
                        }
                    </script>
                    

                <!--  ./Game -->
        </div>
    </div>
</main>
<!-- ./main -->

<?php include "templates/footer.php" ?>