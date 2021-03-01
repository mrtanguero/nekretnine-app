<?php
include 'db.php';
$id = intval($_GET['id']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Izmijeni oglas - <?= $id ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.0/font/bootstrap-icons.css">

</head>

<body>
  <?php
  $query = "SELECT
      nekretnine.id as id,
      naziv,
      povrsina,
      cijena,
      godina_izgradnje,
      grad,
      opis,
      tip_oglasa,
      tip_nekretnine,
      status,
      datum_prodaje
    FROM nekretnine
    WHERE nekretnine.id = ?";

  $stmt = $db->prepare($query);
  $stmt->bind_param('i', $id);
  $stmt->execute();
  $stmt->store_result();
  $stmt->bind_result(
    $id,
    $naziv,
    $povrsina,
    $cijena,
    $godina_izgradnje,
    $grad,
    $opis,
    $tip_oglasa,
    $tip_nekretnine,
    $status,
    $datum_prodaje
  );
  $stmt->fetch();
  ?>
  <div class="container mb-3 mt-3" style="max-width: 800px;">
    <h1 class="text-center"><?= $naziv ?> </h1>
    <div class="card mt-3">
      <div class="card-body">
        <!-- FORMA -->
        <form action="snimi_izmjenu.php" method="POST" enctype="multipart/form-data">
          <input type="hidden" name="id" value="<?= $id ?>" />
          <!-- naziv nekretnine -->
          <div class="mb-3">
            <label for="naziv_nekretnine" class="form-label">Naziv nekretnine</label>
            <input type="text" value="<?= $naziv ?>" name="naziv_nekretnine" class="form-control" id="naziv_nekretnine" />
          </div>
          <!-- povrsina -->
          <div class="mb-3">
            <label for="povrsina" class="form-label">Površina (m2)</label>
            <input type="text" value="<?= $povrsina ?>" name="povrsina" class="form-control" id="povrsina" />
          </div>
          <!-- cijena -->
          <div class="mb-3">
            <label for="cijena" class="form-label">Cijena (EUR)</label>
            <input type="text" value="<?= $cijena ?>" name="cijena" class="form-control" id="cijena" />
          </div>
          <!-- Godina izgradnje -->
          <div class="mb-3">
            <label for="godina-izgradnje" class="form-label">
              Godina izgradnje
            </label>
            <input type="text" value="<?= $godina_izgradnje ?>" name="godina_izgradnje" class="form-control" id="godina-izgradnje" />
          </div>
          <!-- Opis -->
          <div class="mb-3">
            <label for="opis" class="form-label">
              Opis nekretnine
            </label>
            <textarea type="text" name="opis" class="form-control" id="opis" rows="4" /><?= $opis ?></textarea>
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
              $stmt->bind_result($grad_id, $ime_grada);

              while ($stmt->fetch()) {
                $selected = $grad == $grad_id ? 'selected' : '';
                echo "<option value=\"$grad_id\" $selected>$ime_grada</option>";
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
              <?php
              $query = "SELECT * FROM tipovi_oglasa";
              $stmt = $db->prepare($query);
              $stmt->execute();
              $stmt->store_result();
              $stmt->bind_result($tip_oglasa_id, $tip_oglasa_name);

              while ($stmt->fetch()) {
                $selected = $tip_oglasa == $tip_oglasa_id ? 'selected' : '';
                echo "<option value=\"$tip_oglasa_id\" $selected>
                  $tip_oglasa_name
                </option>";
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
              <?php
              $query = "SELECT * FROM tipovi_nekretnina";
              $stmt = $db->prepare($query);
              $stmt->execute();
              $stmt->store_result();
              $stmt->bind_result($tip_nekretnine_id, $tip_nekretnine_ime);

              while ($stmt->fetch()) {
                $selected = $tip_nekretnine == $tip_nekretnine_id ? 'selected' : '';
                echo "<option value=\"$tip_nekretnine_id\" $selected>$tip_nekretnine_ime</option>";
              }
              $stmt->free_result();
              $db->close();
              ?>
            </select>
          </div>
          <!-- Prodata/izdata -->
          <div class="form-check mb-3">
            <?php
            $checked = $status == false ? '' : 'checked';
            ?>
            <input class="form-check-input" name="prodato-izdato" type="checkbox" value="checked" id="prodato-izdato" <?= $checked ?> />
            <label class="form-check-label" for="prodato-izdato">
              Prodato/izdato
            </label>
          </div>
          <?php
          if ($status) {
            echo "<p>Datum prodaje/izdavanja: $datum_prodaje</p>";
          }
          ?>
          <!-- Slike -->
          <div class="mb-4">
            <label for="photos" class="form-label">Dodaj još fotografija</label>
            <input type="file" name="photos[]" class="form-control" id="photos" multiple />
          </div>

          <button class="btn btn-primary w-100" type="submit">Sačuvaj</button>
        </form>
      </div>
    </div>
  </div>
  <footer>
    <div class="d-flex justify-content-center mb-4">
      <a href="index.php" class="me-3">Home</a>
      <a href="gradovi.php" class="me-3">Gradovi</a>
      <a href="tipovi_nekretnina.php">Tipovi nekretnina</a>
    </div>
  </footer>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
</body>

</html>