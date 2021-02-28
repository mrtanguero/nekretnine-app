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
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.0/font/bootstrap-icons.css">
  <link rel="stylesheet" href="./css/custom-style.css">
</head>

<body>
  <div class="container">
    <div class="header d-flex mt-3">
      <h3 class="flex-grow-1">Nekretnine 'Nekretnizam'</h3>
      <a href="nova_nekretnina.php" class="btn btn-primary px-5" style="line-height: 2.5em;">Dodaj nekretninu</a>
    </div>
    <div class="search-box">
      <p>Ovdje će ići search funkcionalnost</p>
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
      ON nekretnine.grad = gradovi.id";
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
        <th></th>
      </thead>
      <tbody>
        <?php
        while ($stmt->fetch()) {
          echo "<tr class='align-middle'>";
          echo "<td>$id</td>";
          echo "<td><a href='./detalji.php?id=$id'>$naziv</a></td>";
          echo "<td>$povrsina</td>";
          echo "<td>$cijena</td>";
          echo "<td>$grad</td>";
          echo "<td style='text-align: right;'>
              <a class='btn btn-sm btn-primary' href='./izmijeni.php?id=$id'>
                <i class='bi bi-pencil-square'></i></a>
              <button 
                type='button' 
                class='btn btn-sm btn-danger' 
                data-bs-toggle='modal' 
                data-bs-id='$id'  
                data-bs-target='#deleteModal'>
                  <i class='bi bi-trash'></i>
              </button>
            </td>";
          echo "</tr>";
        }
        $stmt->free_result();
        $db->close();
        ?>
      </tbody>
    </table>
  </div>

  <!-- Modal -->
  <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="deleteModalLabel">UPOZORENJE:</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          Da li ste sigurni da želite da obrišete ovaj oglas?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Ipak ne</button>
          <a href="#" type="button" class="btn btn-danger">Obriši</a>
        </div>
      </div>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
  <script src="./js/modal-skripta.js"></script>
</body>

</html>