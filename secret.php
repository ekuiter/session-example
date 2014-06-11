<?php
  
// Session starten / wiederaufnehmen
require_once 'session.inc.php';

// wenn kein Benutzer angemeldet ist ...
if (!isset($_SESSION['logged_in']) or $_SESSION['logged_in'] === false)
  header('Location: login.php'); // zur Anmeldeseite umleiten

// sonst Ausgabe der geheimen Seite:
  
?>
<!DOCTYPE html>
<html>
<head>
  <?php echo $header ?>
</head>
<body>
  <?php echo $navigation ?>
  <div class="row">
    <div class="large-6 columns">
      <h1>Secret Page</h1>
      <p>Hey <strong><?php echo $_SESSION['username'] ?></strong>,</p>
      <p>This page's content is <strong>REEEALLY</strong> classified.</p>
      <p><strong>Nobody</strong> must know about this page.</p>
      <p>Seriously, just forget it already.</p>
      <p>Better log out <strong>ASAP</strong>.</p>
      <p><a href="logout.php" class="button">Log out</a></p>
    </div>
    <div class="large-6 columns">
      <img src="secret.jpg" alt="TOP SECRET" />
    </div>
  </div>
</body>
</html>