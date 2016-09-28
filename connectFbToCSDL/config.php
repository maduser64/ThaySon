<?php
	$app_id = '1691004334522901';  //moi v2.7
	$app_secret = '854cd2879b9566a957ccba3d8ee15363';
	
    //$app_id = '874752525895731';  //that
	//$app_secret = 'b09804872241d68fec5b9eac6a6cc582';
	
	//$app_id = '884706364900347';  //localhost
	//$app_secret = '2af0cda1f97283ae232449fc618ddbb5';
	
	$permissions = ['user_about_me', 'user_actions.books', 'user_actions.fitness', 'user_actions.music', 'user_actions.news', 'user_actions.video', 'user_birthday', 'user_education_history', 'user_events', 'user_friends', 'user_games_activity', 'user_hometown', 'user_likes', 'user_location', 'user_managed_groups', 'user_photos', 'user_posts', 'user_relationship_details', 'user_relationships', 'user_religion_politics', 'user_status', 'user_tagged_places', 'user_videos', 'user_website', 'user_work_history', 'ads_management', 'ads_read', 'email', 'manage_pages', 'publish_actions', 'publish_pages', 'read_custom_friendlists', 'read_insights', 'read_page_mailboxes', 'rsvp_event']; //Permissions required
	
	//require_once "/../facebook-php-sdk-v4-5.0-dev/src/Facebook/autoload.php"; //include autoload from SDK folder
	//require_once "/facebook-php-sdk-v4-master/src/Facebook/autoload.php"; //include autoload from SDK folder
	require_once "/../php-graph-sdk-master/src/Facebook/autoload.php"; //include autoload from SDK folder

?>