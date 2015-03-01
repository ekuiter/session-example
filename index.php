<?php
  
// Session starten / wiederaufnehmen
require_once 'session.inc.php';
require_once 'utwitter.inc.php';

// wenn kein Benutzer angemeldet ist ...
if (!isset($_SESSION['logged_in']) or $_SESSION['logged_in'] === false)
  header('Location: login.php'); // zur Anmeldeseite umleiten

// Tweets aus der Datenbank holen
$tweets = get_tweets();
  
?>
<!DOCTYPE html>
<html>
<head>
  <?php echo $header ?>
</head>
<body>
<nav class="navbar navbar-inverse" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">µTwitter</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="#">Tweets</a></li>
            <li><a href="logout.php">Logout</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>
  <div class="container">
    <?php echo $body ?>
  <h2>Hallo <?php echo $_SESSION['username'] ?>!</h2>
  <?php
    if (isset($_GET["message"])) {
      echo "<p>$_GET[message]</p>";
    }
  ?>
  <form action="post_tweet.php" method="post">
    <textarea name="tweet" rows="4" cols="60">
    </textarea>
    <br />
    <input type="submit" value="Tweeten!" />
  </form>
  <h2>Tweets</h2>
  <div id="tweets">
    <?php while($tweet = $tweets->fetch_assoc()) { ?>
      <?php $user = get_user($tweet) ?>
      <div class="tweet">
        <p>
          <?php echo $tweet['tweet'] ?>
        </p>
        <small><?php echo $user['username'] ?> (<?php echo date_format(date_create($tweet['timestamp']), 'd.m. H:i') ?>)</small>
      </div>
    <?php } ?>
  </div>  
  </div>
</body>
</html>
