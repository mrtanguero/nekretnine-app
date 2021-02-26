<?php
$db = new mysqli('localhost', 'root', '', 'nekretnine_db');
if (mysqli_connect_errno()) {
  echo '<p>Error: Could not connect to database.<br/>
Please try again later.</p>';
  exit;
}
