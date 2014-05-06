<?php
require_once('config.php');
require_once('twitteroauth/twitteroauth/twitteroauth.php');

$db_conn = mysql_connect(DB_HOST, DB_USERNAME, DB_PASSWORD);
if (!$db_conn) {
    die('Could not connect: ' . mysql_error());
}
mysql_select_db(DB_NAME, $db_conn);

$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, OAUTH_TOKEN, OAUTH_TOKEN_SECRET);
$tweets = $connection->get('search/tweets', array('q' => SEARCH_WORD));

foreach ($tweets->statuses as $tweet) {

	$existing_tweet = mysql_query('SELECT * FROM retweets WHERE id = "' . $tweet->id . '"');

	if (!mysql_num_rows($existing_tweet) && substr($tweet->text, 0, 2) != 'RT' && substr($tweet->text, 0, 1) != '@') {
		$retweet = $connection->post('statuses/retweet/' . $tweet->id);
		$result = mysql_query("INSERT INTO retweets (id, text, screen_name) VALUES ('" . $tweet->id . "','" . utf8_decode($tweet->text) . "','" . utf8_decode($tweet->user->screen_name) . "')");

		$follow = $connection->post('friendships/create', array('user_id' => $tweet->user->id, 'follow' => true));

	}
}
