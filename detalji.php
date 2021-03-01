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
  <title>Detalji - <?= $id ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.0/font/bootstrap-icons.css">
</head>

<body>
  <div class="container mt-3 mb-3" style="max-width: 960px;">
    <?php
    $query = "SELECT
    nekretnine.id as id,
    naziv,
    opis,
    povrsina,
    cijena,
    ime_grada as grad,
    foto_url,
    status,
    datum_prodaje,
    tipovi_nekretnina.tip_nekretnine as tip_nekretnine,
    tipovi_oglasa.tip_oglasa as tip_oglasa
    FROM nekretnine
    JOIN gradovi
    ON nekretnine.grad = gradovi.id 
    JOIN tipovi_nekretnina
    ON nekretnine.tip_nekretnine = tipovi_nekretnina.id
    JOIN tipovi_oglasa
    ON nekretnine.tip_oglasa = tipovi_oglasa.id
    JOIN fotografije
    ON nekretnine.id = fotografije.nekretnina_id
    WHERE nekretnine.id = ?";

    $stmt = $db->prepare($query);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result(
      $id,
      $naziv,
      $opis,
      $povrsina,
      $cijena,
      $grad,
      $foto_url,
      $status,
      $datum_prodaje,
      $tip_nekretnine,
      $tip_oglasa
    );
    $number_of_images = $stmt->num_rows;
    $stmt->fetch();
    $status_verbalno = $status == 0 ? 'DOSTUPNO' : 'PRODATO/IZDATO';
    ?>
    <h1 class="text-center mb-5"><?= $naziv ?> - <?= $grad ?></h1>
    <div class="row">
      <div class="col-5">
        <p><strong>ID:</strong> <?= $id ?><br />
          <strong>Naziv nekretnine:</strong> <?= $naziv ?><br />
          <strong>Opis:</strong> <?= $opis ?><br />
          <strong>Površina (m2):</strong> <?= $povrsina ?><br />
          <strong>Cijena (EUR):</strong> <?= $cijena ?><br />
          <strong>Grad:</strong> <?= $grad ?><br />
          <strong>Status:</strong> <?= $status_verbalno ?><br />
          <strong>Datum prodaje:</strong> <?= $datum_prodaje ? $datum_prodaje : "N/A" ?><br />
          <strong>Tip nekretnine:</strong> <?= $tip_nekretnine ?><br />
          <strong>Tip oglasa:</strong> <?= $tip_oglasa ?>
        </p>
        <div class="d-flex mb-3">
          <a class="btn btn-primary me-2" href="izmijeni.php?id=<?= $id ?>">
            <i class='bi bi-pencil-square me-2'></i>Izmijeni
          </a>
          <button class='btn btn-sm btn-danger' data-bs-toggle='modal' data-bs-target='#deleteModal'>
            <i class='bi bi-trash me-2'></i>Obriši
          </button>
        </div>
        <div class="d-flex">
          <a href="index.php" class="me-3">Home</a>
          <a href="gradovi.php" class="me-3">Gradovi</a>
          <a href="tipovi_nekretnina.php">Tipovi nekretnina</a>
        </div>
      </div>

      <div class="carousel-container col-7">
        <div id="carouseIndicators" class="carousel slide" data-bs-ride="carousel">
          <div class="carousel-indicators">
            <?php
            for ($i = 0; $i < $number_of_images; $i++) {
              $active = $i == 0 ? "class='active' aria-current='true'" : '';
              $slide = $i + 1;
              echo "<button 
            type='button' 
              data-bs-target='#carouseIndicators' data-bs-slide-to='$i'
              aria-label='Slide $slide'
              $active</button>";
            }
            ?>
          </div>
          <div class="carousel-inner">
            <?php
            $stmt->execute();
            for ($i = 0; $i < $number_of_images; $i++) {
              $stmt->fetch();
              $slide = $i + 1;
              $active = $i == 0 ? 'active' : '';
              echo "<div class='carousel-item $active'>";
              echo "<img class='d-block w-100' src='$foto_url' alt='Slide number $slide'>";
              echo "</div>";
            }

            $stmt->free_result();
            $db->close();
            ?>
          </div>
          <button class="carousel-control-prev" type="button" data-bs-target="#carouseIndicators" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
          </button>
          <button class="carousel-control-next" type="button" data-bs-target="#carouseIndicators" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
          </button>
        </div>
      </div>
    </div>
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
          <a href="obrisi.php?id=<?= $id ?>" type="button" class="btn btn-danger">Obriši</a>
        </div>
      </div>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
</body>

</html>