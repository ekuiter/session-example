<?php

// Session starten / wiederaufnehmen
session_start();

// Datenbank-Zugang merken
$cfg = array(
  'server' => 'myserver.com', 
  'username' => 'myuser', 
  'password' => 'mypass',
  'database' => 'mydb'
);

// einen Benuzter anmelden
function login($username, $password) {
  // wenn die Benutzername-Passwort-Kombination richtig ist ...
  if (is_valid($username, $password)) {
    $_SESSION['logged_in'] = true; // einloggen
    $_SESSION['username'] = $username; // und Nutzername merken
    header('Location: secret.php'); // und zur geheimen Seite umleiten
  }
}

// überprüfen, ob der Benutzer mit $username und $password existiert
function is_valid($username, $password) {
  // Verbindung zur Datenbank aufbauen
  global $cfg;
  $mysqli = new mysqli($cfg['server'], $cfg['username'], $cfg['password'], $cfg['database']);
  // Abfrage: "Suche alle Benutzer, die den Benutzernamen $username und das Passwort $passwort haben"
  $sql = "SELECT * FROM users WHERE username='" . $mysqli->real_escape_string($username) .
                             "' AND password='" . md5($password) . "'";
  $result = $mysqli->query($sql); // Abfrage durchführen
  $mysqli->close(); // Verbindung schließen
  if ($result->num_rows > 0) // falls ein Benutzer mit dem Passwort vorhanden ist ...
      return true; // gibt is_valid "true" zurück
  else // falls nicht ...
    return false; // gibt is_valid "false" zurück
}

// einen Benutzer abmelden
function logout() {
  session_destroy(); // die Session (das Session-Cookie) löschen
  header('Location: login.php'); // zur Anmeldeseite zurückkehren
}

// Kopf der Seite
$header = <<<code
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Session Example</title>
  <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/foundation/5.2.3/css/normalize.css">
  <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/foundation/5.2.3/css/foundation.min.css">
  <script src="//cdnjs.cloudflare.com/ajax/libs/foundation/5.2.3/js/vendor/modernizr.js"></script>
code;

// Navigationsleiste der Seite
$navigation = <<<code
  <div class="contain-to-grid">
    <nav class="top-bar" data-topbar>
      <ul class="title-area">
        <li class="name">
          <h1><a href="#">Session Example</a></h1>
        </li>
      </ul>
      <section class="top-bar-section">
        <ul class="right">
          <li><a href="#">&copy; 2014 sf256</a></li>
        </ul>
      </section>
    </nav>
  </div>
  <div class="row">&nbsp;</div>
code;
  
?>