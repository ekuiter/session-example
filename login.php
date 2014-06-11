<?php
  
// Session starten / wiederaufnehmen
require_once 'session.inc.php';

// wenn ein Benutzer angemeldet ist ...
if (isset($_SESSION['logged_in']) and $_SESSION['logged_in'] === true)
  header('Location: secret.php'); // zur geheimen Seite umleiten
  
// sonst:

// Nachricht vorbereiten
$message = '<div class="alert-box">To view this page, you need to sign in.</div>'; 

// falls ein Loginversuch unternommen wird ...
if (isset($_POST['username']) and isset($_POST['password'])) {
  // versuche den Benutzer mit den eingegeben Daten anzumelden
  $login_successful = login($_POST['username'], $_POST['password']);
  // wenn dies fehlschlägt, erstelle eine Fehlermeldung
  if (!$login_successful)
    $message = '<div class="alert-box alert">Incorrect user name or password.</div>';
}

// gib die Anmeldeseite aus:

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
      <h1>Log in</h1>
      <p><?php echo $message ?></p>
      <form action="login.php" method="post">
        <input type="text" name="username" placeholder="User name" />
        <input type="password" name="password" placeholder="Password " />
        <input type="submit" class="button" value="Log in" />
      </form>
    </div>
    <div class="large-6 columns">
      <img src="secret.jpg" alt="TOP SECRET" />
    </div>
  </div>
</body>
</html>