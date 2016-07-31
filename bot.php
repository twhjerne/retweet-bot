<?php
require_once('config.php');
require_once('twitteroauth/twitteroauth/twitteroauth.php');

$db_conn = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
if (mysqli_connect_errno()) {
    die('Could not connect: ' . mysqli_connect_error());
}

$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, OAUTH_TOKEN, OAUTH_TOKEN_SECRET);
$tweets = $connection->get('search/tweets', array('q' => SEARCH_WORD));

foreach ($tweets->statuses as $tweet) {

        $existing_tweet = mysqli_query($db_conn, 'SELECT * FROM retweets WHERE id = "' . $tweet->id . '"');

        if (!mysqli_num_rows($existing_tweet) && substr($tweet->text, 0, 2) != 'RT' && substr($tweet->text, 0, 1) != '@') {
            $retweet = $connection->post('statuses/retweet/' . $tweet->id);
            $result = mysqli_query($db_conn, "INSERT INTO retweets (id, text, screen_name) VALUES ('" . $tweet->id . "','" . utf8_decode($tweet->t$
            $follow = $connection->post('friendships/create', array('user_id' => $tweet->user->id, 'follow' => true));
        }
}
