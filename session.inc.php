<?php

error_reporting(-1); ini_set('display_errors', 1);
date_default_timezone_set('Europe/Berlin');

// Session starten / wiederaufnehmen
session_start();

// Datenbank-Zugang merken
$cfg = array(
  'server' => 'myserver.com', 
  'username' => 'myuser', 
  'password' => 'mypass',
  'database' => 'mydb'
);

function connect() {
  global $cfg;
  // Verbindung zur Datenbank aufbauen
  return new mysqli($cfg['server'], $cfg['username'], $cfg['password'], $cfg['database']);
}

connect()->multi_query("
  CREATE TABLE IF NOT EXISTS `users` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `username` varchar(40) NOT NULL,
    `password` varchar(40) NOT NULL,
    PRIMARY KEY `id` (`id`)
  ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

  CREATE TABLE IF NOT EXISTS `tweets` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `tweet` varchar(160) NOT NULL,
    `user_id` int(11) NOT NULL,
    `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
  ) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
");

// einen Benutzer anmelden
function login($username, $password) {
  // wenn die Benutzername-Passwort-Kombination richtig ist ...
  if ($user = is_valid($username, $password)) {
    $_SESSION['logged_in'] = true; // einloggen
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['username'] = $username; // und Nutzername merken
    header('Location: index.php'); // und zur geheimen Seite umleiten
  }
}

// überprüfen, ob der Benutzer mit $username und $password existiert
function is_valid($username, $password) {
  global $cfg;
  $mysqli = connect();
  // Abfrage: "Suche alle Benutzer, die den Benutzernamen $username und das Passwort $passwort haben"
  $sql = "SELECT * FROM users WHERE username='" . $mysqli->real_escape_string($username) .
                             "' AND password='" . md5($password) . "'";
  $result = $mysqli->query($sql); // Abfrage durchführen
  if ($result->num_rows > 0) { // falls ein Benutzer mit dem Passwort vorhanden ist ...
    return $result->fetch_assoc(); // gibt is_valid den Benutzer zurück
  } else // falls nicht ...
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
  <title>µTwitter</title>
  <link rel="stylesheet" type="text/css" href="assets/style.css">
  <link rel="icon" href="assets/favicon.png" type="image/png"/>
  <link rel="shortcut icon" href="assets/favicon.png" type="image/png"/>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css">
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
code;

$body = '
  <img src="assets/utwitter_logo.png" alt="uTwitter" />
  <img src="assets/ugly_u.png" alt="uTwitter" height="220" />
';  
  
?>

