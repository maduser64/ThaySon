<?php
session_start(); //Session should always be active

$app_id				= '874752525895731';  //localhost
$app_secret 		= 'b09804872241d68fec5b9eac6a6cc582';
$required_scope 	= 'user_about_me,user_actions.books,user_actions.fitness,user_actions.music,user_actions.news,user_actions.video,user_birthday,user_education_history,user_events,user_friends,user_games_activity,user_hometown,user_likes,user_location,user_managed_groups,user_photos,user_posts,user_relationship_details,user_relationships,user_religion_politics,user_status,user_tagged_places,user_videos,user_website,user_work_history,ads_management,ads_read,email,manage_pages,publish_actions,publish_pages,read_custom_friendlists,read_insights,read_page_mailboxes,rsvp_event'; //Permissions required
$redirect_url 		= 'http://nvluyen.com/tritueviet/ThaySon/index2.php'; //FB redirects to this page with a code


require_once __DIR__ . "/facebook-php-sdk-v4-4.0-dev/autoload.php"; //include autoload from SDK folder

//import required class to the current scope
use Facebook\FacebookSession;
use Facebook\FacebookRequest;
use Facebook\GraphUser;
use Facebook\FacebookRedirectLoginHelper;
use Facebook\FacebookSDKException;

FacebookSession::setDefaultApplication($app_id , $app_secret);
$helper = new FacebookRedirectLoginHelper($redirect_url);
echo "chay <br>";

try {
   $session = $helper->getSessionFromRedirect();
} catch(FacebookRequestException $ex) {
  die(" Error : " . $ex->getMessage());
} catch(\Exception $ex) {
  die(" Error : " . $ex->getMessage());
}

if(isset($_GET["log-out"]) && $_GET["log-out"]==1){
	unset($_SESSION["fb_user_details"]);
	exit(header("location: ". $redirect_url));
}

if ($session){ 
	$user_profile = (new FacebookRequest($session, 'GET', '/me'))->execute()->getGraphObject(GraphUser::className());
	$_SESSION["fb_user_details"] = $user_profile->asArray(); 
	$user_profile = (new FacebookRequest($session, 'GET', '/me?fields=groups'))->execute()->getGraphObject(GraphUser::className());
	$_SESSION["fb_user_groups"] = $user_profile->asArray(); 
	
	//exit(header("location: ". $redirect_url));
	
	print 'Hi '.$_SESSION["fb_user_details"]["name"].' you are logged in! [ <a href="?log-out=1">log-out</a> ] ';
		print '<pre>';
		print_r($_SESSION["fb_user_details"]);
		print '</pre>';
		
		print '<pre>';
		print_r($_SESSION["fb_user_groups"]);
		print '</pre>';
	
	
}else{ 
	echo "chay 2 <br>";
	if(isset($_SESSION["fb_user_details"])){
		
		print 'Hi '.$_SESSION["fb_user_details"]["name"].' you are logged in! [ <a href="?log-out=1">log-out</a> ] ';
		print '<pre>';
		print_r($_SESSION["fb_user_details"]);
		print '</pre>';
		
		print '<pre>';
		print_r($_SESSION["fb_user_groups"]);
		print '</pre>';
	}
	else{
		$login_url = $helper->getLoginUrl( array( 'scope' => $required_scope ) );
		echo '<a href="'.$login_url.'">Login with Facebook</a>'; 
	}
}
