<?php
require 'includes/init.php';

if(isset($_SESSION['user_id']) && isset($_SESSION['email'])){
    $user_data = $user_obj->find_user_by_id($_SESSION['user_id']);
    if($user_data === false){
        header('Location: logout.php');
        exit;
    }
}
else{
    header('Location: logout.php');
    exit;
}

//total requests
$get_req_num = $friend_obj->req_notification($_SESSION['user_id'], false);
//total friends
$get_friends_num = $friend_obj->get_all_friends($_SESSION['user_id'], false);
$get_all_req_sender = $friend_obj->req_notification($_SESSION['user_id'], true);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo  $user_data->username;?></title>
    <link rel="stylesheet" href="./style.css">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700" rel="stylesheet">
</head>
<body>
    <div class="profile_container">
        <div class="inner_profile">
            <div class="img">
            <img src="profile_images/<?php echo $user_data->user_image; ?>" class="Profile Image">
            </div>
            <h1><?php echo $user_data->username; ?> </h1>
        </div>
        <nav>
            <ul>
                <li><a href="profile.php" rel="noopener noreferrer">Home</a> </li>
                <li><a href="notifications.php" rel="noopener noreferrer" class="active">Requests<span class="badge" <?php
                        if($get_req_num>0){
                            echo 'redBadge';
                        }
                        ?><?php echo $get_req_num; ?></span></a>  </li>
                <li><a href="friends.php" rel="noopener noreferrer">Friends<span class="badge"><?php echo $get_friends_num;?></span></a></li>
                <li><a href="logout.php" rel="noopener noreferrer" >Logout </a></li>
            </ul>
        </nav>
        <div class="all_users">
            <h3>All requests</h3>
            <div class="usersWrapper">
                <?php
                if($get_req_num>0){
                    foreach ($get_all_req_sender as $row){
                        echo '<div class="user_box">
                                <div class="user_img"><img src="profile_images/'.$row->user_image.'" alt="Profile_image"></img></div>
                                <div class="user_info"><span>'.$row->username.'</span>
                                <span><a href="user_profile.php?id='.$row->sender.'" class="see_profileBtn">See Profile</a></div>
                                </div>';
                    }
                }
                else{
                    echo '<h4>You have no friend requests!</h4>';
                }
                ?>
            </div>
        </div>
        
    </div>

</body>
</html>
