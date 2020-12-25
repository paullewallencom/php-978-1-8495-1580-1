<?php
require_once 'StatusPoster.php';

if (isset($_POST['status'])) {
    $statusStr = trim($_POST['status']);
    $length = mb_strlen($statusStr);
    $success = false;
    
    if ($length > 0 && $length < 500) {
        $success = $status->insertStatus(array(
                'name' => 'M A Hossain Tonu', 
                'image' => 'tonu.jpg', 
                'status' => $statusStr, 
                'timestamp' => time()
                ));
    }
    
    if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest') {
        echo ($success) ? '{"success":true}' : '{"error":"Error posting status"}';
        exit;
    }
}

$result = $status->getStatusPosts();
define('BASE_URL', 'http://localhost/chapter3/');
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Status updater</title>
        <link href="<?=BASE_URL?>styles/styles.css" media="screen" rel="stylesheet" type="text/css" />
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js"></script>
        <script src="<?=BASE_URL?>js/status.js"></script>

    </head>
    <body>
        <div id="container" class="container">

            <h1>Status Poster</h1>
            <div class="inputbox">
                <form id="statusFrom" action="index.php" method="post" >
                    <textarea name="status" id="status_box">Write your status here</textarea>
                    <input class="right" type="submit" name="submit" id="submit" value="Share" />
                    <div id="postStatus" class="postStatus clearer hidden">loading</div>
                </form>
            </div>

            <ul>
        <?php
        if (is_array($result))
        foreach ($result as $row) {
            echo '
                <li>
                    <a href="#">
                        <img class="left" src="images/user/' . $row['image'] . '" alt="picture">
                    </a>
                    <div class="content left">
                        <a href="#">' . $row['name'] . '</a>
                        <div class="status">' . $row['status'] . '</div>
                        <span class="localtime" data-timestamp="' . $row['timestamp'] . '"></span>
                    </div>
                    <div class="clearer"></div>
                </li>
                    ';
        }
        ?>
            </ul>

        </div>
        <div id="statusTemplate" class="hidden">
            <li>
                <a href="#">
                    <img class="left" src="#SRC" alt="picture">
                </a>
                <div class="content left">
                    <a href="#">#NAME</a>
                    <div class="status">#STATUS</div>
                    <span class="localtime">#TIME</span>
                </div>
                <div class="clearer"></div>
            </li>
        </div>

    </body>
</html>