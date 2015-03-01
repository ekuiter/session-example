<?php
  
// Session starten / wiederaufnehmen
require_once 'session.inc.php';
  
// wenn ein Benutzer angemeldet ist ...
if (isset($_SESSION['logged_in']) and $_SESSION['logged_in'] === true)
  logout(); // Abmeldung durchführen
else
  header('Location: login.php'); // sonst zur Anmeldeseite zurückkehren

?>