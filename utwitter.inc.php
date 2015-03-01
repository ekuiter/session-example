<?php

require_once 'session.inc.php';

function get_tweets() {
  return connect()->query("SELECT * FROM tweets ORDER BY timestamp DESC");
}

function get_user($tweet) {
  $mysqli = connect();
  $result = $mysqli->query("SELECT * FROM users WHERE id=" . $mysqli->real_escape_string($tweet['user_id']));
  return $result->fetch_assoc();
}

// Fehlermeldung; graphische Darstellung

function post_tweet($tweet, $user_id) {
  if (!$tweet)
    return;
  if (strlen($tweet) > 160) {
    $tweetGreen = substr($tweet, 0, 160);
    $tweetRed = substr($tweet, 160); 
    return ">160 Zeichen <br>  $tweetGreen<span style='color:red'>$tweetRed</span>";
  }
  $mysqli = connect();
  $escaped_tweet = $mysqli->real_escape_string(htmlspecialchars($tweet));
  $mysqli->query("INSERT INTO tweets (tweet, user_id, timestamp)
    VALUES ('" . $escaped_tweet . "', " . $mysqli->real_escape_string($user_id) . ", NOW())");
}
  
?>