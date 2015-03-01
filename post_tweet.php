<?php
  
// Session starten / wiederaufnehmen
require_once 'session.inc.php';
require_once 'utwitter.inc.php';

// wenn kein Benutzer angemeldet ist ...
if (!isset($_SESSION['logged_in']) or $_SESSION['logged_in'] === false)
  header('Location: login.php'); // zur Anmeldeseite umleiten

$tweet = $_POST['tweet'];
$message = post_tweet($tweet, $_SESSION['user_id']);

header("Location: index.php?message=$message");
  
?>