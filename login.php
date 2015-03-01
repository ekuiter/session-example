<?php
  
// Session starten / wiederaufnehmen
require_once 'session.inc.php';

// wenn ein Benutzer angemeldet ist ...
if (isset($_SESSION['logged_in']) and $_SESSION['logged_in'] === true)
  header('Location: index.php'); // zur geheimen Seite umleiten
  
// sonst:

// Nachricht vorbereiten
$message = 'To view this page, you need to sign in.'; 

// falls ein Loginversuch unternommen wird ...
if (isset($_POST['username']) and isset($_POST['password'])) {
  // versuche den Benutzer mit den eingegeben Daten anzumelden
  $login_successful = login($_POST['username'], $_POST['password']);
  // wenn dies fehlschlägt, erstelle eine Fehlermeldung
  if (!$login_successful)
    $message = 'Incorrect user name or password.';
}

// gib die Anmeldeseite aus:

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
      </div>
    </nav>
<div class="container">
    <?php echo $body ?>
    <h1>Log in</h1>
    <p><?php echo $message ?></p>
    <form action="login.php" method="post">
      <input type="text" name="username" placeholder="User name" />
      <input type="password" name="password" placeholder="Password" />
      <input type="submit" class="button" value="Log in" />
    </form>
</div>
</body>
</html>
