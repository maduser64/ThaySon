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
        $link = '/' . $_SESSION['group_id'] . '?fields=feed.since(' . $_SESSION['date_start'] . ').until(' . $_SESSION['date_end'] . ').limit(1150){id,message,from,created_time,updated_time,comments.limit(1150){id,message,from,created_time}}';
        echo $link;
        $responseFeed = $fb->get($link);
    } catch (Facebook\Exceptions\FacebookResponseException $e) {
// When Graph returns an error
        echo 'Graph returned an error: ' . $e->getMessage() . '<br>';
        exit;
    } catch (Facebook\Exceptions\FacebookSDKException $e) {
// When validation fails or other local issues
        echo 'Facebook SDK returned an error: ' . $e->getMessage() . '<br>';
        exit;
    }
//    $feedEdge = $responseFeed->getGraphNode();
    $varJsonDecode = json_decode($responseFeed->getBody(), true)["feed"];
    
    if (count($varJsonDecode["data"])>0){
//>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
        echo '<br><br>---------------------------------------------------------------------------------------------------------------------------------------------<br>  ';
        do {
            $feed = new Feeds();
            $i = 0;
            foreach ($varJsonDecode["data"] as $status) {
                try {
                    echo '<br><br>------------------------------------------<br>  ' . $status["id"];
                    $feed->setFacebookIdFeed($status["id"]);
                } catch (Exception $ex) {}
                try {
                    echo '<br><br>------------------------------------------<br>  ' . $status["message"];
                    $feed->setMessage(html_entity_decode(@mysql_real_escape_string($status["message"])));
                } catch (Exception $ex) {}
                try {
                    echo '<br><br>------------------------------------------<br>  ' . $status["from"]["id"];
                    $feed->setFacebookUserIdFeed($status["from"]["id"]);
                } catch (Exception $ex) {}
                $feed->setStatusId((int) '1');
                $feed->setGroupId((int) ('' . $_SESSION['id_group_csdl']));
                echo '<br><br>------------------------------------------<br>  ' . $feed->getStatusId() . '  ' . $feed->getGroupId();
                echo '<br>' .$status["created_time"] . '  ' .$status["updated_time"];
                try {
                    $date = new DateTime($status["created_time"], new DateTimeZone('GMT'));
                    $date->setTimezone(new DateTimeZone('Asia/Bangkok'));
                    $stringtime = $date->format('Y-m-d H:i:s');
                    $feed->setCreateFeedTime('' . $stringtime);
                    echo '<br><br>------------------------------------------<br>  ' . $feed->getCreateFeedTime();
                } catch (Exception $ex) {}
                try {
                    $date = new DateTime($status["updated_time"], new DateTimeZone('GMT'));
                    $date->setTimezone(new DateTimeZone('Asia/Bangkok'));
                    $stringtime = $date->format('Y-m-d H:i:s');
                    $feed->setUpdateFeedTime('' . $stringtime);
                    echo '<br><br>------------------------------------------<br>  ' . $feed->getUpdateFeedTime();
                } catch (Exception $ex) {}
                $idFeedCSDL= createFeeds($feed);
//<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<

                echo '<br>+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++<br>';
                $varComments = $varJsonDecode["data"][$i]["comments"];
                if (count($varComments["data"])>0) {
                    do {
                        $comment = new Comments();
                        foreach ($varComments["data"] as $status2) {
                            try {
                                echo '<br><br>------------------------------------------<br>  ' . $status2["id"];
                                $comment->setFacebookIdComment($status2["id"]);
                            } catch (Exception $ex) {}
                            try {
                                echo '<br><br>------------------------------------------<br>  ' . $status2["message"];
                                $comment->setMessage(html_entity_decode(@mysql_real_escape_string($status2["message"])));
                            } catch (Exception $ex) {}
                            try {
                                echo '<br><br>------------------------------------------<br>  ' . $status2["from"]["id"];
                                $comment->setFacebookUserIdComment($status2["from"]["id"]);
                            } catch (Exception $ex) {}
                            try {
                                $date = new DateTime($status2["created_time"], new DateTimeZone('GMT'));
                                $date->setTimezone(new DateTimeZone('Asia/Bangkok'));
                                $stringtime = $date->format('Y-m-d H:i:s');
                                $comment->setCreateCommentTime('' . $stringtime);
                                echo '<br><br>------------------------------------------<br>  ' . $comment->getCreateCommentTime();
                            } catch (Exception $ex) {}

                            $comment->setStatusId((int) '1');
                            $comment->setFeedId($idFeedCSDL);

                            createComments($comment);
                        }
                        if(!isset($varComments["paging"]["next"])){
                            break;
                        }
                        $varComments = json_decode(file_get_contents($varComments["paging"]["next"]), true);
                        if (count($varComments["data"])<=0){
                            break;
                        }
                    } while (true);
                }
                $i++;
            }
            
            if(!isset($varJsonDecode["paging"]["next"])){
                break;
            }
            $varJsonDecode = json_decode(file_get_contents($varJsonDecode["paging"]["next"]), true);
            if (count($varJsonDecode["data"])<=0){
                break;
            }
        } while(true);
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
