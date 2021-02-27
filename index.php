<?php
include 'db.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Nekretnine DB</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
</head>

<body>
  <div class="container">
    <div class="header d-flex mt-3">
      <h1 class="flex-grow-1">Nekretnine 'Nekretnizam'</h1>
      <a href="nova_nekretnina.php" class="btn btn-primary px-5" style="line-height: 2.2em;">Dodaj nekretninu</a>
    </div>
    <?php
    $query = "SELECT 
        nekretnine.id as id, 
        naziv, 
        povrsina, 
        cijena, 
        ime_grada as grad 
      FROM nekretnine 
      JOIN gradovi 
      WHERE nekretnine.grad = gradovi.id";
    $stmt = $db->prepare($query);
    // $stmt->bind_param('s', $searchterm);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $naziv, $povrsina, $cijena, $grad);
    echo "<p>Rezultata: " . $stmt->num_rows . "</p>"; ?>
    <table class="table table-striped table-hover">
      <thead>
        <th>ID</th>
        <th>Naziv</th>
        <th>Površina</th>
        <th>Cijena</th>
        <th>Grad</th>
      </thead>
      <tbody>
        <?php
        while ($stmt->fetch()) {
          echo "<tr>";
          echo "<td>$id</td>";
          echo "<td>$naziv</td>";
          echo "<td>$povrsina</td>";
          echo "<td>$cijena</td>";
          echo "<td>$grad</td>";
          echo "</tr>";
        }
        $stmt->free_result();
        $db->close();
        ?>
      </tbody>
    </table>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
</body>

</html>