<?php
include 'db.php';
include 'funkcije.php';

$id = intval($_GET['id']);

$db->begin_transaction();

$query = "DELETE FROM nekretnine 
  WHERE id=$id";
$stmt = $db->prepare($query);
$stmt->execute();
if ($stmt->affected_rows == 0) {
  $db->rollback();
  header("Location: ./index.php?message=delete-fail");
  exit("Brisanje nekretnine koja ima ID $id nije uspjelo");
}

if (!deleteDirectory("./uploads/$id")) {
  $db->rollback();
  header("Location: ./index.php?message=delete-fail");
  exit("Brisanje foldera sa fotografijama neuspješno");
}

$db->commit();
$db->close();
header("Location: ./index.php?message=delete-success");
