<?php

require_once '/../models/groups.php';
require_once '/../dao/daoGroups.php';
require_once '/../models/user_group.php';
require_once '/../dao/daoUser_Group.php';
require_once '/../models/members.php';
require_once '/../dao/daoMembers.php';
// khởi tạo 1 session
session_start();
ob_start();

include 'config.php';
$web_root = "http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']);
$redirect_url = $web_root.'/FbToCSDL_Group.php'; // Khi đăng nhập xong sẽ tự động chuyển hướng sang trang web này, nếu k điền j thì mặc đinh đường link cài đặt trong app

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
//    echo '<br><br>'.$responseGroup->get;
    echo '<br><br> ---: ' . $feedEdge;
    echo '<br><br> ---: ' . $responseGroup->getBody();
//    echo '<br><br> ---: ' . $fb->next($feedEdge->getGraphEdge());
    $group = new Groups();
    try {
        $group->setFacebookGroupId($_SESSION['group_id']);
        echo '</br>' . $group->getFacebookGroupId();
    } catch (Exception $ex) {
        
    }
    try {
        echo '<br><br>------------------------------------------<br>  ' . $feedEdge->getField("name");
        $group->setName(html_entity_decode(@mysql_real_escape_string($feedEdge->getField("name"))));
    } catch (Exception $ex) {
        
    }
    try {
        echo '<br><br>------------------------------------------<br>  ' . $feedEdge->getField("privacy");
        $group->setPrivacy(html_entity_decode(@mysql_real_escape_string($feedEdge->getField("privacy"))));
    } catch (Exception $ex) {
        
    }
    try {
        echo '<br><br>------------------------------------------<br>  ' . $feedEdge->getField("icon");
        $group->setIcon(html_entity_decode(@mysql_real_escape_string($feedEdge->getField("icon"))));
    } catch (Exception $ex) {
        
    }
    try {
        echo '<br><br>------------------------------------------<br>  ' . $feedEdge->getField("email");
        $group->setEmail(html_entity_decode(@mysql_real_escape_string($feedEdge->getField("email"))));
    } catch (Exception $ex) {
        
    }

    try {
        if($feedEdge->getField("owner")!=null){
            echo '<br><br>------------------------------------------<br>  ' . $feedEdge["owner"]->getField("id",null);
            $group->setOwner(html_entity_decode(@mysql_real_escape_string($feedEdge["owner"]->getField("id",null))));
        } else {
            echo '<br><br>empty owner';
        }
    } catch (Exception $ex) {
        echo '<br><br>errors owner';
    }

    $id_group = createGroups($group);
    echo '<br><br>--->'.$id_group;
    $user_group = new User_group();
    $user_group->setUserId($_SESSION['user_id']);
    $user_group->setGroupId($id_group);

    echo $id_group . ' ' . createUser_Group($user_group);
//    echo '<br><br> paging: '.$feedEdge["members"]->getField("2");
//    echo '<br><br> paging: '.implode(" ",$feedEdge["members"]->getField("2"));
    $member = new Members();
    foreach ($feedEdge["members"] as $status2) {
        echo '<br><br>'. $status2;
        try {
            echo '<br><br>------------------------------------------<br>  ' . $status2->getProperty("id");
            $member->setFacebookIdMember($status2->getProperty("id"));
        } catch (Exception $ex) {
            
        }
        try {
            echo '<br><br>------------------------------------------<br>  ' . $status2->getProperty("name");
            $member->setName(html_entity_decode(@mysql_real_escape_string($status2->getProperty("name"))));
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
