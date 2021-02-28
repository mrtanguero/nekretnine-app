<?php
include 'db.php';
// var_dump($_POST);
// echo "<br />";
// var_dump($_FILES);

$id = $_POST['id'];
// Da izvučem stari status i stari datum
$query = "SELECT status, datum_prodaje FROM nekretnine WHERE id=$id";
$stmt = $db->prepare($query);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($stari_status, $datum_prodaje);
$stmt->fetch();

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
$novi_status = isset($_POST['prodato-izdato']) ? 1 : 0;

if ($stari_status == 0 && $novi_status == 1) {
  $datum_prodaje = date('Y-m-d');
}

if ($stari_status == 1 && $novi_status == 0) {
  $datum_prodaje = null;
}


$query = "UPDATE nekretnine 
  SET
    naziv = ?,
    povrsina = ?,
    cijena = ?,
    godina_izgradnje = ?,
    opis = ?,
    grad = ?,
    tip_oglasa = ?,
    tip_nekretnine = ?,
    status = ?,
    datum_prodaje = ?
  WHERE id = ?
  ";

$db->begin_transaction();

$stmt = $db->prepare($query);
$stmt->bind_param(
  'siiisiiiisi',
  $naziv,
  $povrsina,
  $cijena,
  $godina_izgradnje,
  $opis,
  $grad,
  $tip_oglasa,
  $tip_nekretnine,
  $novi_status,
  $datum_prodaje,
  $id
);
$stmt->execute();

if (mysqli_errno($db)) {
  $db->rollback();
  exit("Nešto nije bilo u redu sa unosom u bazu (dio podataka bez slika)");
}

// OVAJ DIO TREBA DA UBACI SLIKE   
if ($files['name'][0] != '') {
  for ($i = 0; $i < $number_of_files; $i++) {
    if (!is_dir("./uploads/$id")) {
      $oldumask = umask(0);
      mkdir("./uploads/$id", 0777);
      umask($oldumask);
    }
    $file_for_upload = "./uploads/$id/" . $files['name'][$i];

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
      $id
    );
    $stmt->execute();

    if ($stmt->affected_rows == 0) {
      $db->rollback();
      exit("Nešto nije bilo u redu sa unosom slike $i u bazu");
    }
  }
}
$db->commit();
$db->close();
header("Location: ./index.php?message=edit-success");
