<?php
include 'db.php';

if (count($_POST) != 0) {
  var_dump($_POST);
  if (isset($_POST['flag'])) {
    $naziv = trim($_POST['tip_nekretnine']);

    $query = "INSERT INTO tipovi_nekretnina (tip_nekretnine)
    VALUES (?)";
    $stmt = $db->prepare($query);
    $stmt->bind_param('s', $naziv);
    $stmt->execute();
    if ($stmt->affected_rows) {
      header("Location: ./tipovi_nekretnina.php?message=create-success");
    }
  } else {
    $id = intval($_POST['id']);
    $naziv = trim($_POST['tip_nekretnine']);

    $query = "UPDATE tipovi_nekretnina
      SET
        tip_nekretnine = ?
      WHERE id = ?";
    $stmt = $db->prepare($query);
    $stmt->bind_param('si', $naziv, $id);
    $stmt->execute();
    if ($stmt->affected_rows) {
      header("Location: ./tipovi_nekretnina.php?message=update-success");
    }
  }
} elseif (count($_GET) != 0 && isset($_GET['obrisi'])) {
  $id = intval($_GET['obrisi']);
  $query = "DELETE FROM tipovi_nekretnina WHERE id=$id";
  $stmt = $db->prepare($query);
  $stmt->execute();
  if ($stmt->affected_rows) {
    header("Location: ./tipovi_nekretnina.php?message=delete-success");
  }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tipovi nekretnina</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.0/font/bootstrap-icons.css">
</head>

<body>
  <div class="container">
    <h1 class="text-center mt-3">Tipovi nekretnina</h1>

    <?php
    $query = "SELECT id, tip_nekretnine FROM tipovi_nekretnina";
    $stmt = $db->prepare($query);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $naziv); ?>

    <table class="table table-striped table-hover w-50 mx-auto">
      <thead>
        <th>Naziv</th>
        <th>
          <button class="btn btn-sm btn-primary w-100" data-bs-toggle='modal' data-bs-target='#newModal'>
            Novi tip nekretnine
          </button>
        </th>
      </thead>
      <tbody>
        <?php
        while ($stmt->fetch()) {
          echo "<tr class='align-middle'>";
          echo "<td>$naziv</a></td>";
          echo "<td style='width: 150px' class='text-end'>
              <button 
                type='button' 
                class='btn btn-sm btn-primary' 
                data-bs-toggle='modal' 
                data-bs-id='$id'  
                data-bs-ime='$naziv'  
                data-bs-target='#editModal'>
                <i class='bi bi-pencil-square'></i>
              </button>
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

  <!-- Modal za brisanje -->
  <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="deleteModalLabel">UPOZORENJE:</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          Da li ste sigurni da želite da obrišete ovaj tip nekretnine?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Ipak ne</button>
          <a href="#" type="button" class="btn btn-danger">Obriši</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal za edit -->
  <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editModalLabel">Izmjena tipa nekretnine</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="" method="POST">
          <div class="modal-body">
            <input type="hidden" name="id" id="id-tipa-nekretnine" />
            <input type="text" class="form-control" name="tip_nekretnine" id="naziv-tipa-nekretnine" />
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Odustani</button>
            <button id="edit-btn" type="submit" class="btn btn-primary">Sačuvaj</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Modal za novi tip nekretnine -->
  <div class="modal fade" id="newModal" tabindex="-1" aria-labelledby="newModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="newModalLabel">Unesite novi tip nekretnine</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="" method="POST">
          <div class="modal-body">
            <input type="hidden" value="create" name="flag" id="novi" />
            <input type="text" class="form-control" name="tip_nekretnine" id="tip-nekretnine-novi" />
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Odustani</button>
            <button id="new-btn" type="submit" class="btn btn-primary">Sačuvaj</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <footer>
    <div class="d-flex justify-content-center">
      <a href="index.php" class="me-3">Home</a>
      <a href="gradovi.php">Gradovi</a>
    </div>
  </footer>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
  <script src="./js/tipoviNekretnina.js"></script>
</body>

</html>