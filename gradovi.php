<?php
include 'db.php';

if (count($_POST) != 0) {
  if (isset($_POST['flag'])) {
    $naziv = trim($_POST['naziv_grada']);

    $query = "INSERT INTO gradovi (ime_grada)
    VALUES (?)";
    $stmt = $db->prepare($query);
    $stmt->bind_param('s', $naziv);
    $stmt->execute();
    if ($stmt->affected_rows) {
      header("Location: ./gradovi.php?message=create-success");
    }
  } else {
    $id = intval($_POST['id']);
    $naziv = trim($_POST['naziv_grada']);

    $query = "UPDATE gradovi
      SET
        ime_grada = ?
      WHERE id = ?";
    $stmt = $db->prepare($query);
    $stmt->bind_param('si', $naziv, $id);
    $stmt->execute();
    if ($stmt->affected_rows) {
      header("Location: ./gradovi.php?message=update-success");
    }
  }
} elseif (count($_GET) != 0 && isset($_GET['obrisi'])) {
  $id = intval($_GET['obrisi']);
  $query = "DELETE FROM gradovi WHERE id=$id";
  $stmt = $db->prepare($query);
  $stmt->execute();
  if ($stmt->affected_rows) {
    header("Location: ./gradovi.php?message=delete-success");
  }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gradovi</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.0/font/bootstrap-icons.css">
</head>

<body>
  <div class="container">
    <h1 class="text-center mt-3">Gradovi</h1>

    <?php
    $query = "SELECT id, ime_grada FROM gradovi";
    $stmt = $db->prepare($query);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $naziv); ?>

    <table class="table table-striped table-hover w-50 mx-auto">
      <thead>
        <th>Naziv</th>
        <th>
          <button class="btn btn-sm btn-primary w-100" data-bs-toggle='modal' data-bs-target='#newModal'>
            Novi grad
          </button>
        </th>
      </thead>
      <tbody>
        <?php
        while ($stmt->fetch()) {
          echo "<tr class='align-middle'>";
          echo "<td>$naziv</a></td>";
          echo "<td style='width: 100px' class='text-end'>
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
          Da li ste sigurni da želite da obrišete ovaj grad?
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
          <h5 class="modal-title" id="editModalLabel">Izmjena imena grada</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="" method="POST">
          <div class="modal-body">
            <input type="hidden" name="id" id="id-grada" />
            <input type="text" class="form-control" name="naziv_grada" id="naziv-grada" />
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Odustani</button>
            <button id="edit-btn" type="submit" class="btn btn-primary">Sačuvaj</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Modal za novi grad -->
  <div class="modal fade" id="newModal" tabindex="-1" aria-labelledby="newModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="newModalLabel">Unesite ime novog grada</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="" method="POST">
          <div class="modal-body">
            <input type="hidden" value="create" name="flag" id="novi" />
            <input type="text" class="form-control" name="naziv_grada" id="naziv-grada-novi" />
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
      <a href="tipovi_nekretnina.php">Tipovi nekretnina</a>
    </div>
  </footer>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
  <script src="./js/gradovi.js"></script>
</body>

</html>