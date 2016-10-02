<?php

// khởi tạo 1 session
session_start();
require_once '/../models/groups.php';
require_once '/../dao/daoGroups.php';
require_once '/../models/feeds.php';
require_once '/../dao/daoFeeds.php';
require_once '/../models/comments.php';
require_once '/../dao/daoComments.php';
ob_start();

include 'config.php';

$web_root = "http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']);
$redirect_url = $web_root.'/FbToCSDL_Feed.php'; // Khi đăng nhập xong sẽ tự động chuyển hướng sang trang web này, nếu k điền j thì mặc đinh đường link cài đặt trong app

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
        $link = '/' . $_SESSION['group_id'] . '?fields=feed.since(' . $_SESSION['date_start'] . ').until(' . $_SESSION['date_end'] . ').limit(1150){id,message,from,created_time,updated_time,comments.limit(1150){id,message,from,created_time}}';
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

    $feedEdge = $responseFeed->getGraphNode();
//    echo '<br> ---: ' . $feedEdge['feed']->count();

    echo '<br><br>------------------------------------------<br>  ';
    $feed = new Feeds();
    foreach ($feedEdge['feed'] as $status) {
//        echo '<br><br>------------------------------------------<br>  ' . $status;
//        echo $status->getProperty("message");
        try {
            echo '<br><br>------------------------------------------<br>  ' . $status->getProperty("id");
            $feed->setFacebookIdFeed($status->getProperty("id"));
        } catch (Exception $ex) {
            
        }
        try {
            echo '<br><br>------------------------------------------<br>  ' . $status->getProperty("message");
            $feed->setMessage($status->getProperty("message"));
        } catch (Exception $ex) {
            
        }
        try {
            echo '<br><br>------------------------------------------<br>  ' . $status->getProperty("from")['id'];
            $feed->setFacebookUserIdFeed($status->getProperty("from")['id']);
        } catch (Exception $ex) {
            
        }
        $feed->setStatusId((int) '1');
        $feed->setGroupId((int) ('' . $_SESSION['id_group_csdl']));
        echo '<br><br>------------------------------------------<br>  ' . $feed->getStatusId() . '  ' . $feed->getGroupId();

        try {
            $dtime = new DateTime();
            $unixtime = $dtime->format('U');
            $dtime = $status->getField("created_time");
            $localtz = new DateTimeZone("Asia/Calcutta");         //choose the correct PHP timezone
            $dtime->setTimeZone($localtz);                        //we apply the timezone
            $stringtime = $dtime->format('Y-m-d H:i:s');
            $feed->setCreateFeedTime('' . $stringtime);
            echo '<br><br>------------------------------------------<br>  ' . $feed->getCreateFeedTime();
        } catch (Exception $ex) {
            
        }
        try {
            $dtime = new DateTime();
            $unixtime = $dtime->format('U');
            $dtime = $status->getField("updated_time");
            $localtz = new DateTimeZone("Asia/Calcutta");         //choose the correct PHP timezone
            $dtime->setTimeZone($localtz);                        //we apply the timezone
            $stringtime = $dtime->format('Y-m-d H:i:s');
            $feed->setUpdateFeedTime('' . $stringtime);
            echo '<br><br>------------------------------------------<br>  ' . $feed->getUpdateFeedTime();
        } catch (Exception $ex) {
            
        }
 //--------------------------------------------------------------------------------------------------------       
         
        $comment = new Comments();
        $idFeedCSDL= createFeeds($feed);
        foreach ($status["comments"] as $status2) {
            try {
                echo '<br><br>------------------------------------------<br>  ' . $status2->getProperty("id");
                $comment->setFacebookIdComment($status2->getProperty("id"));
            } catch (Exception $ex) {
                
            }
            try {
                echo '<br><br>------------------------------------------<br>  ' . $status2->getProperty("message");
                $comment->setMessage($status2->getProperty("message"));
            } catch (Exception $ex) {
                
            }
            try {
                echo '<br><br>------------------------------------------<br>  ' . $status2->getProperty("from")['id'];
                $comment->setFacebookUserIdComment($status2->getProperty("from")['id']);
            } catch (Exception $ex) {
                
            }
            $comment->setStatusId((int) '1');
            $comment->setFeedId($idFeedCSDL);
            echo '<br><br>------------------------------------------<br>  ' . $comment->getStatusId() . '  ' . $comment->getFeedId();

            try {
                $dtime = new DateTime();
                $unixtime = $dtime->format('U');
                $dtime = $status2->getField("created_time");
                $localtz = new DateTimeZone("Asia/Calcutta");         //choose the correct PHP timezone
                $dtime->setTimeZone($localtz);                        //we apply the timezone
                $stringtime = $dtime->format('Y-m-d H:i:s');
                $comment->setCreateCommentTime('' . $stringtime);
                echo '<br><br>------------------------------------------<br>  ' . $comment->getCreateCommentTime();
            } catch (Exception $ex) {
                
            }
            echo createComments($comment);
        }
    }
    $direct= "Location: ../feedView.php?facebookGroupId=".$_SESSION['group_id']."&groupId=".$_SESSION['id_group_csdl']."&pageNum=".$_SESSION['pageNum'];
    echo $direct;
    header($direct);
} else {
//  nếu k có accesstoken thì chuyển hướng sang trang đăng nhập
    $loginUrl = $helper->getLoginUrl($redirect_url, $permissions);
    exit(header("location: " . $loginUrl));
//  trước đó có lệnh exit chuyển hướng sang trang đăng nhập, nếu k có lệnh exit kia thì sẽ hiện thẻ <a để chọn nút đăng nhập
    echo '<a href="' . $loginUrl . '">Login with Facebook</a>';
}
?>
