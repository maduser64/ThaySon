<?php

require_once __DIR__ . '/host.php';
require_once $ROOT . '/models/groups.php';
require_once $ROOT . '/dao/daoGroups.php';
require_once $ROOT . '/models/feeds.php';
require_once $ROOT . '/dao/daoFeeds.php';
require_once $ROOT . '/models/Comments.php';
require_once $ROOT . '/dao/daoComments.php';
// khởi tạo 1 session
session_start();

$app_id = '884706364900347';  //localhost
$app_secret = '2af0cda1f97283ae232449fc618ddbb5';
$permissions = ['user_about_me', 'user_actions.books', 'user_actions.fitness', 'user_actions.music', 'user_actions.news', 'user_actions.video', 'user_birthday', 'user_education_history', 'user_events', 'user_friends', 'user_games_activity', 'user_hometown', 'user_likes', 'user_location', 'user_managed_groups', 'user_photos', 'user_posts', 'user_relationship_details', 'user_relationships', 'user_religion_politics', 'user_status', 'user_tagged_places', 'user_videos', 'user_website', 'user_work_history', 'ads_management', 'ads_read', 'email', 'manage_pages', 'publish_actions', 'publish_pages', 'read_custom_friendlists', 'read_insights', 'read_page_mailboxes', 'rsvp_event']; //Permissions required
$redirect_url = 'http://localhost/ThaySon/connectFbToCSDL/FbToCSDL_Comment.php'; // Khi đăng nhập xong sẽ tự động chuyển hướng sang trang web này, nếu k điền j thì mặc đinh đường link cài đặt trong app
require_once $ROOT . "/facebook-php-sdk-v4-5.0-dev/src/Facebook/autoload.php"; //include autoload from SDK folder
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
        $link = '/' . $_SESSION['feed_id_fb'] . '?fields=comments{from,message,id,created_time}';
        echo $link;
        $responseFeed = $fb->get($link);
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
    $commentEdge = $responseFeed->getGraphObject();
    echo '<br> ---: ' . $commentEdge;
    echo '<br><br>------------------------------------------<br>  ';
    $comment = new Comments();
    foreach ($commentEdge['comments'] as $status) {
//        echo '<br><br>------------------------------------------<br>  ' . $status;
//        echo $status->getProperty("message");
        try {
            echo '<br><br>------------------------------------------<br>  ' . $status->getProperty("id");
            $comment->setFacebookIdComment($status->getProperty("id"));
        } catch (Exception $ex) {
            
        }
        try {
            echo '<br><br>------------------------------------------<br>  ' . $status->getProperty("message");
            $comment->setMessage($status->getProperty("message"));
        } catch (Exception $ex) {
            
        }
        try {
            echo '<br><br>------------------------------------------<br>  ' . $status->getProperty("from")['id'];
            $comment->setFacebookUserIdComment($status->getProperty("from")['id']);
        } catch (Exception $ex) {
            
        }
        $comment->setStatusId((int) '1');
        $comment->setFeedId( (int)('' . $_SESSION['id_feed_csdl']));
        echo '<br><br>------------------------------------------<br>  ' . $comment->getStatusId() . '  ' . $comment->getFeedId();

        try {
            $dtime = new DateTime();
            $unixtime = $dtime->format('U');
            $dtime=$status->getField("created_time");
            $localtz = new DateTimeZone("Asia/Calcutta");         //choose the correct PHP timezone
            $dtime->setTimeZone($localtz);                        //we apply the timezone
            $stringtime=$dtime->format('Y-m-d H:i:s'); 
            $comment->setCreateCommentTime('' . $stringtime);
            echo '<br><br>------------------------------------------<br>  ' . $comment->getCreateCommentTime();
        } catch (Exception $ex) {
        }
        echo createComments($comment);
    }
//    header("Location: pages/login-registration-system/index.php");
} else {
//  nếu k có accesstoken thì chuyển hướng sang trang đăng nhập
    $loginUrl = $helper->getLoginUrl($redirect_url, $permissions);
    exit(header("location: " . $loginUrl));
//  trước đó có lệnh exit chuyển hướng sang trang đăng nhập, nếu k có lệnh exit kia thì sẽ hiện thẻ <a để chọn nút đăng nhập
    echo '<a href="' . $loginUrl . '">Login with Facebook</a>';
}
?>
