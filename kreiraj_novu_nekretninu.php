<?php
include 'db.php';

$naziv = $_POST['naziv_nekretnine'];
$povrsina = intval($_POST['povrsina']);
$cijena = intval($_POST['cijena']);
$godina_izgradnje = intval($_POST['godina_izgradnje']);
$opis = $_POST['opis'];
$grad = intval($_POST['grad']);
$tip_oglasa = intval($_POST['tip_oglasa']);
$tip_nekretnine = intval($_POST['tip_nekretnine']);
$files = $_FILES['photos'];
$number_of_files = count($files['name']);

$query = "INSERT INTO nekretnine (
  naziv,
  povrsina,
  cijena,
  godina_izgradnje,
  opis,
  grad,
  tip_oglasa,
  tip_nekretnine
  )
  VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

$db->begin_transaction();

$stmt = $db->prepare($query);
$stmt->bind_param(
  'siiisiii',
  $naziv,
  $povrsina,
  $cijena,
  $godina_izgradnje,
  $opis,
  $grad,
  $tip_oglasa,
  $tip_nekretnine
);
$stmt->execute();

if ($stmt->affected_rows == 0) {
  $db->rollback();
  exit("Nešto nije bilo u redu sa unosom u bazu (dio podataka bez slika)");
}

// OVAJ DIO TREBA DA UBACI SLIKE   
$query = "SELECT LAST_INSERT_ID()";
$stmt = $db->prepare($query);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($id);
$stmt->fetch();
$last_id = $id;
$stmt->free_result();

for ($i = 0; $i < $number_of_files; $i++) {
  if ($i == 0) {
    $oldumask = umask(0);
    mkdir("./uploads/$last_id", 0777);
    umask($oldumask);
  }
  $file_for_upload = "./uploads/$last_id/" . $files['name'][$i];

  if (is_uploaded_file($files['tmp_name'][$i])) {
    if (!move_uploaded_file($files['tmp_name'][$i], $file_for_upload)) {
      $db->rollback();
      exit('Problem: Nešto nije bilo u redu sa prebacivanjem slike u odgovarajući folder');
    }
  } else {
    $db->rollback();
    exit("Problem: Mogući file upload napad. Filename: " . $files['name'][$i]);
  }
  // Smještanje slike u tabelu
  $query = "INSERT INTO fotografije (
    foto_url,
    nekretnina_id
  )
  VALUES (?, ?)";
  $stmt = $db->prepare($query);

  $stmt->bind_param(
    'si',
    $file_for_upload,
    $last_id
  );
  $stmt->execute();

  if ($stmt->affected_rows == 0) {
    $db->rollback();
    exit("Nešto nije bilo u redu sa unosom slike $i u bazu");
  }
}
$db->commit();
$db->close();
header("Location: ./index.php?message=success");
