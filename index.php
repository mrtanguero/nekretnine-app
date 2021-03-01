<?php
include 'db.php';
$pretraga_aktivna = false;

// Obrada search forme
if (count($_POST) != 0) {
  $elementi_pretrage = [];

  if (trim($_POST['naziv']) != '') {
    $naziv = trim($_POST['naziv']);
    $naziv_search_term = "%$naziv%";
    $elementi_pretrage[] = "naziv COLLATE utf8_general_ci LIKE '$naziv_search_term'";
    $pretraga_aktivna = true;
  }

  if (trim($_POST['opis']) != '') {
    $opis = trim($_POST['opis']);
    $opis_search_term = "%$opis%";
    $elementi_pretrage[] = "opis COLLATE utf8_general_ci LIKE '$opis_search_term'";
    $pretraga_aktivna = true;
  }

  if (trim($_POST['min-cijena']) != '') {
    $min_cijena = intval(trim($_POST['min-cijena']));
    $elementi_pretrage[] = "cijena >= $min_cijena";
    $pretraga_aktivna = true;
  }

  if (trim($_POST['max-cijena']) != '') {
    $max_cijena = intval(trim($_POST['max-cijena']));
    if ($max_cijena != 0) {
      $elementi_pretrage[] = "cijena <= $max_cijena";
    }
    $pretraga_aktivna = true;
  }

  if (trim($_POST['min-povrsina']) != '') {
    $min_povrsina = intval(trim($_POST['min-povrsina']));
    $elementi_pretrage[] = "povrsina >= $min_povrsina";
    $pretraga_aktivna = true;
  }

  if (trim($_POST['max-povrsina']) != '') {
    $max_povrsina = intval(trim($_POST['max-povrsina']));
    if ($max_povrsina != 0) {
      $elementi_pretrage[] = "povrsina <= $max_povrsina";
    }
    $pretraga_aktivna = true;
  }

  if (trim($_POST['min-godina']) != '') {
    $min_godina = intval(trim($_POST['min-godina']));
    $elementi_pretrage[] = "godina >= $min_godina";
    $pretraga_aktivna = true;
  }

  if (trim($_POST['max-godina']) != '') {
    $max_godina = intval(trim($_POST['max-godina']));
    if ($max_godina != 0) {
      $elementi_pretrage[] = "godina <= $max_godina";
    }
    $pretraga_aktivna = true;
  }

  if ($_POST['grad'] != '0') {
    $grad = intval($_POST['grad']);
    $elementi_pretrage[] = "grad = $grad";
    $pretraga_aktivna = true;
  }

  if ($_POST['tip_oglasa'] != '0') {
    $tip_oglasa = intval($_POST['tip_oglasa']);
    $elementi_pretrage[] = "tip_oglasa = $tip_oglasa";
    $pretraga_aktivna = true;
  }

  if ($_POST['tip_nekretnine'] != '0') {
    $tip_nekretnine = intval($_POST['tip_nekretnine']);
    $elementi_pretrage[] = "tip_nekretnine = $tip_nekretnine";
    $pretraga_aktivna = true;
  }

  if ($_POST['prodato_izdato'] != '0') {
    $prodato_izdato = intval($_POST['prodato_izdato']) - 1;
    $elementi_pretrage[] = "status = $prodato_izdato";
    $pretraga_aktivna = true;
  }


  $string_pretrage = implode(' AND ', $elementi_pretrage);
  $string_pretrage = 'WHERE ' . $string_pretrage;
}
if (!$pretraga_aktivna) {
  $string_pretrage = '';
}
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
</head>

<body>
  <div class="container">
    <div class="header d-flex mt-3">
      <h3 class="flex-grow-1">Nekretnine 'Nekretnizam'</h3>
      <a href="nova_nekretnina.php" class="btn btn-sm btn-primary px-4 lh-lg text-uppercase fw-bolder">
        Dodaj nekretninu
      </a>
    </div>
    <div class="accordion mt-3 mb-3" id="accordion">
      <div class="accordion-item">
        <h2 class="accordion-header" id="headingOne">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
            Pretraga
          </button>
        </h2>
        <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordion">
          <div class="accordion-body">
            <div class="search-box">
              <div class="card-body">
                <form method="post" id='search-forma'>
                  <div class="row g-3 mb-3">
                    <div class="col">
                      <input type="text" name="naziv" class="form-control" placeholder="Pretraga po nazivu" aria-label="Pretraga po imenu oglasa" />
                    </div>
                    <div class="col">
                      <input type="text" name="opis" class="form-control" placeholder="Pretraga po opisu" aria-label="Pretraga po opisu">
                    </div>
                  </div>
                  <div class="row g-3 mb-3">
                    <div class="col">
                      <input type="text" name="min-cijena" class="form-control" placeholder="Unesite minimalnu cijenu" aria-label="Min cijena">
                    </div>
                    <div class="col">
                      <input type="text" name="max-cijena" class="form-control" placeholder="Unesite maksimalnu cijenu" aria-label="Max cijena">
                    </div>
                  </div>
                  <div class="row g-3 mb-3">
                    <div class="col">
                      <input type="text" name="min-povrsina" class="form-control" placeholder="Unesite minimalnu površinu" aria-label="Min povrsina">
                    </div>
                    <div class="col">
                      <input type="text" name="max-povrsina" class="form-control" placeholder="Unesite maksimalnu površinu" aria-label="Max povrsina">
                    </div>
                  </div>
                  <div class="row g-3 mb-3">
                    <div class="col">
                      <input type="text" name="min-godina" class="form-control" placeholder="Unesite minimalnu godinu izgradnje" aria-label="Min godina">
                    </div>
                    <div class="col">
                      <input type="text" name="max-godina" class="form-control" placeholder="Unesite maksimalnu godinu izgradnje" aria-label="Max godina">
                    </div>
                  </div>
                  <div class="row g-3 mb-3">
                    <div class="col">
                      <select name="grad" class="form-select" id="grad">
                        <option value="0" selected>-- Pretraga po gradu --</option>
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
                    <div class="col">
                      <select name="tip_oglasa" class="form-select" id="tip-oglasa">
                        <option value="0" selected>-- Pretraga po tipu oglasa --</option>
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
                  </div>
                  <div class="row g-3 mb-3">
                    <div class="col">
                      <select name="tip_nekretnine" class="form-select" id="tip-nekretnine">
                        <option value="0" selected>-- Pretraga po tipu nekretnine --</option>
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
                        ?>
                      </select>
                    </div>
                    <div class="col">
                      <select name="prodato_izdato" class="form-select" id="tip-oglasa">
                        <option value="0" selected>-- Svi oglasi --</option>
                        <option value="1">Dostupno</option>
                        <option value="2">Prodato/izdato</option>
                      </select>
                    </div>
                  </div>
                  <button type="submit" class="btn btn-primary w-100 text-uppercase mt-3">Pretraži</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php
    $query = "SELECT 
        nekretnine.id as id, 
        naziv, 
        opis,
        povrsina, 
        cijena, 
        ime_grada as grad 
      FROM nekretnine 
      JOIN gradovi 
      ON nekretnine.grad = gradovi.id
      $string_pretrage";
    $stmt = $db->prepare($query);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $naziv, $opis, $povrsina, $cijena, $grad); ?>

    <div class='d-flex mb-4 mt-4 align-items-end justify-content-between'>
      <?= "<p class='mb-0'>Rezultata: " . $stmt->num_rows . "</p>"; ?>
      <button id="clear-search-button" class="btn btn-primary">
        Poništi parametre pretrage (prikaži sve oglase)</button>
    </div>
    <table class="table table-striped table-hover">
      <thead>
        <th>ID</th>
        <th>Naziv</th>
        <th style="width: 35%;">Opis</th>
        <th>Površina (m2)</th>
        <th>Cijena (EUR)</th>
        <th>Grad</th>
        <th></th>
      </thead>
      <tbody>
        <?php
        while ($stmt->fetch()) {
          echo "<tr class='align-middle'>";
          echo "<td>$id</td>";
          echo "<td><a href='./detalji.php?id=$id'>$naziv</a></td>";
          echo "<td>$opis</a></td>";
          echo "<td>$povrsina</td>";
          echo "<td>$cijena</td>";
          echo "<td>$grad</td>";
          echo "<td style='width: 85px;'>
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

  <footer>
    <div class="d-flex justify-content-center">
      <a href="gradovi.php" class="me-3">Gradovi</a>
      <a href="tipovi_nekretnina.php">Tipovi nekretnina</a>
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
  <script src="./js/skripta.js"></script>
</body>

</html>