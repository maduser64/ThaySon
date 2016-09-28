<?php

require_once '/models/groups.php';
require_once '/dao/daoGroups.php';
require_once '/models/user_group.php';
require_once '/dao/daoUser_Group.php';
require_once '/models/members.php';
require_once '/dao/daoMembers.php';
// khởi tạo 1 session
session_start();
ob_start();
//$app_id = '874752525895731';  //that
//$app_secret = 'b09804872241d68fec5b9eac6a6cc582';
$app_id = '884706364900347';  //localhost
$app_secret = '2af0cda1f97283ae232449fc618ddbb5';
$permissions = ['user_about_me', 'user_actions.books', 'user_actions.fitness', 'user_actions.music', 'user_actions.news', 'user_actions.video', 'user_birthday', 'user_education_history', 'user_events', 'user_friends', 'user_games_activity', 'user_hometown', 'user_likes', 'user_location', 'user_managed_groups', 'user_photos', 'user_posts', 'user_relationship_details', 'user_relationships', 'user_religion_politics', 'user_status', 'user_tagged_places', 'user_videos', 'user_website', 'user_work_history', 'ads_management', 'ads_read', 'email', 'manage_pages', 'publish_actions', 'publish_pages', 'read_custom_friendlists', 'read_insights', 'read_page_mailboxes', 'rsvp_event']; //Permissions required
$redirect_url = 'http://localhost/ThaySon/connectFbToCSDL/FbToCSDL_Group.php'; // Khi đăng nhập xong sẽ tự động chuyển hướng sang trang web này, nếu k điền j thì mặc đinh đường link cài đặt trong app
require_once "/facebook-php-sdk-v4-5.0-dev/src/Facebook/autoload.php"; //include autoload from SDK folder
//require_once "/facebook-php-sdk-v4-master/src/Facebook/autoload.php"; //include autoload from SDK folder
//thêm thư viện
//use Facebook\FacebookSession;
//use Facebook\FacebookRequest;
//use Facebook\GraphUser;
//use Facebook\FacebookRedirectLoginHelper;
//use Facebook\FacebookSDKException;
// khai báo bắt buộc
$fb = new Facebook\Facebook([
    'app_id' => $app_id,
    'app_secret' => $app_secret,
    'default_graph_version' => 'v2.2',
        ]);
$helper = $fb->getRedirectLoginHelper();

try {
    $accessToken = $helper->getAccessToken();
} catch (FacebookRequestException $ex) {
    die(" Error : " . $ex->getMessage()) . '<br>';
} catch (\Exception $ex) {
    die(" Error : " . $ex->getMessage()) . '<br>';
}
// nếu là sự kiện đăng xuất thì xóa session
if (isset($_GET["log-out"]) && $_GET["log-out"] == 1) {
    unset($_SESSION["fb_user_details"]);
    exit(header("location: " . $redirect_url));
}
//  nếu tồn tại accessToken thì thực hiện lệnh
if (isset($accessToken)) {
    $_SESSION['facebook_access_token'] = (string) $accessToken;

    $fb->setDefaultAccessToken($_SESSION['facebook_access_token']);

    try {
//        $responseUser = $fb->get('/me');
//        $userNode = $responseUser->getGraphUser();
        $link = '/' . $_SESSION['group_id'] . '?fields=name,owner,privacy,icon,email,updated_time,description,id,members.limit(1150){administrator,name,id}';
        echo $link;
        $responseGroup = $fb->get($link);
//        $responseFeed = $fb->get('/me/feed?fields=id,message&limit=5');
    } catch (Facebook\Exceptions\FacebookResponseException $e) {
// When Graph returns an error
        echo 'Graph returned an error: ' . $e->getMessage() . '<br>';
        exit;
    } catch (Facebook\Exceptions\FacebookSDKException $e) {
// When validation fails or other local issues
        echo 'Facebook SDK returned an error: ' . $e->getMessage() . '<br>';
        exit;
    }

//    echo 'Logged in as ' . $userNode->getName();
//    echo 'group ' . $responseGroup->getBody();


    $feedEdge = $responseGroup->getGraphGroup();
    echo '<br> ---: ' . $feedEdge;
    $group = new Groups();
    try {
        $group->setFacebookGroupId($_SESSION['group_id']);
        echo '</br>' . $group->getFacebookGroupId();
    } catch (Exception $ex) {
        
    }
    try {
        echo '<br><br>------------------------------------------<br>  ' . $feedEdge->getProperty("name");
        $group->setName($feedEdge->getProperty("name"));
    } catch (Exception $ex) {
        
    }
    try {
        echo '<br><br>------------------------------------------<br>  ' . $feedEdge->getProperty("privacy");
        $group->setPrivacy($feedEdge->getProperty("privacy"));
    } catch (Exception $ex) {
        
    }
    try {
        echo '<br><br>------------------------------------------<br>  ' . $feedEdge->getProperty("icon");
        $group->setIcon($feedEdge->getProperty("icon"));
    } catch (Exception $ex) {
        
    }
    try {
        echo '<br><br>------------------------------------------<br>  ' . $feedEdge->getProperty("email");
        $group->setEmail($feedEdge->getProperty("email"));
    } catch (Exception $ex) {
        
    }

    try {
        if($feedEdge->getField("owner")!=null){
            echo '<br><br>------------------------------------------<br>  ' . $feedEdge["owner"]->getField("id",null);
            $group->setOwner($feedEdge["owner"]->getProperty("id",null));
        }
    } catch (Exception $ex) {
        
    }

    $id_group = createGroups($group);

    $user_group = new User_group();
    $user_group->setUserId($_SESSION['user_id']);
    $user_group->setGroupId($id_group);

    echo $id_group . ' ' . createUser_Group($user_group);

    $member = new Members();
    foreach ($feedEdge["members"] as $status2) {
        try {
            echo '<br><br>------------------------------------------<br>  ' . $status2->getProperty("id");
            $member->setFacebookIdMember($status2->getProperty("id"));
        } catch (Exception $ex) {
            
        }
        try {
            echo '<br><br>------------------------------------------<br>  ' . $status2->getProperty("name");
            $member->setName($status2->getProperty("name"));
        } catch (Exception $ex) {
            
        }
        try {
            echo '<br><br>------------------------------------------<br>  ' . $status2->getProperty("administrator");
            $member->setAdministrator($status2->getProperty("administrator"));
        } catch (Exception $ex) {
            
        }
        $member->setGroupId($id_group);
        createMembers($member);
    }


    header("Location: ../subGroup.php");
} else {
//  nếu k có accesstoken thì chuyển hướng sang trang đăng nhập
    $loginUrl = $helper->getLoginUrl($redirect_url, $permissions);
    exit(header("location: " . $loginUrl));
//  trước đó có lệnh exit chuyển hướng sang trang đăng nhập, nếu k có lệnh exit kia thì sẽ hiện thẻ <a để chọn nút đăng nhập
    echo '<a href="' . $loginUrl . '">Login with Facebook</a>';
}
?>
