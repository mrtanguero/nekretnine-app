<?php
include 'db.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Kreiraj novu nekretninu</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
</head>

<body>
  <div class="container">
    <div class="card mt-3">
      <div class="card-body">
        <!-- FORMA -->
        <form action="kreiraj_novu_nekretninu.php" method="POST" enctype="multipart/form-data">
          <!-- naziv nekretnine -->
          <div class="mb-3">
            <label for="naziv_nekretnine" class="form-label">Naziv nekretnine</label>
            <input type="text" name="naziv_nekretnine" class="form-control" id="naziv_nekretnine" />
          </div>
          <!-- povrsina -->
          <div class="mb-3">
            <label for="povrsina" class="form-label">Površina (m2)</label>
            <input type="text" name="povrsina" class="form-control" id="povrsina" />
          </div>
          <!-- cijena -->
          <div class="mb-3">
            <label for="cijena" class="form-label">Cijena (EUR)</label>
            <input type="text" name="cijena" class="form-control" id="cijena" />
          </div>
          <!-- Godina izgradnje -->
          <div class="mb-3">
            <label for="godina-izgradnje" class="form-label">
              Godina izgradnje
            </label>
            <input type="text" name="godina_izgradnje" class="form-control" id="godina-izgradnje" />
          </div>
          <!-- Opis -->
          <div class="mb-3">
            <label for="opis" class="form-label">
              Opis nekretnine
            </label>
            <textarea type="text" name="opis" class="form-control" id="opis" rows="4" /></textarea>
          </div>
          <!-- Grad -->
          <div class="mb-3">
            <label for="grad" class="form-label">
              Grad
            </label>
            <select name="grad" class="form-select" id="grad">
              <option selected>-- Odaberite grad --</option>
              <?php
              $query = "SELECT * FROM gradovi";
              $stmt = $db->prepare($query);
              $stmt->execute();
              $stmt->store_result();
              $stmt->bind_result($id, $ime_grada);

              while ($stmt->fetch()) {
                echo "<option value=\"$id\">$ime_grada</option>";
              }
              $stmt->free_result();
              ?>
            </select>
          </div>
          <!-- Tip oglasa -->
          <div class="mb-3">
            <label for="tip-oglasa" class="form-label">
              Tip oglasa
            </label>
            <select name="tip_oglasa" class="form-select" id="tip-oglasa">
              <option selected>-- Odaberite tip oglasa --</option>
              <?php
              $query = "SELECT * FROM tipovi_oglasa";
              $stmt = $db->prepare($query);
              $stmt->execute();
              $stmt->store_result();
              $stmt->bind_result($id, $tip_oglasa);

              while ($stmt->fetch()) {
                echo "<option value=\"$id\">$tip_oglasa</option>";
              }
              $stmt->free_result();
              ?>
            </select>
          </div>
          <!-- Tip nekretnine -->
          <div class="mb-3">
            <label for="tip-nekretnine" class="form-label">
              Tip nekretnine
            </label>
            <select name="tip_nekretnine" class="form-select" id="tip-nekretnine">
              <option selected>-- Odaberite tip nekretnine --</option>
              <?php
              $query = "SELECT * FROM tipovi_nekretnina";
              $stmt = $db->prepare($query);
              $stmt->execute();
              $stmt->store_result();
              $stmt->bind_result($id, $tip_nekretnine);

              while ($stmt->fetch()) {
                echo "<option value=\"$id\">$tip_nekretnine</option>";
              }
              $stmt->free_result();
              $db->close();
              ?>
            </select>
          </div>
          <!-- Slike -->
          <div class="mb-3">
            <label for="photos" class="form-label">Fotografije</label>
            <input type="file" name="photos[]" class="form-control" id="photos" multiple required />
          </div>

          <button class="btn btn-primary" type="submit">Sačuvaj</button>
        </form>
      </div>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
</body>

</html>