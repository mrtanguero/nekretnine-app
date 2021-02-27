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
</head>

<body>
  <div class="container">
    <h1>Ovo je stranica nekretnine koja ima ID <?= $id ?></h1>
    <?php
    $query = "SELECT
    nekretnine.id as id,
    naziv,
    povrsina,
    cijena,
    ime_grada as grad,
    foto_url
    FROM nekretnine
    JOIN gradovi
    ON nekretnine.grad = gradovi.id 
    JOIN fotografije
    ON nekretnine.id = fotografije.nekretnina_id
    WHERE nekretnine.id = ?";

    $stmt = $db->prepare($query);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $naziv, $povrsina, $cijena, $grad, $foto_url);
    $number_of_images = $stmt->num_rows;
    $stmt->fetch();

    echo "<p><strong>ID:</strong> $id";
    echo "<br /><strong>Naziv nekretnine:</strong> $naziv";
    echo "<br /><strong>Površina (m2):</strong> $povrsina";
    echo "<br /><strong>Cijena (EUR):</strong> $cijena";
    echo "<br /><strong>Grad:</strong> $grad</p>";

    ?>

    <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
      <div class="carousel-indicators">
        <?php
        for ($i = 0; $i < $number_of_images; $i++) {
          $active = $i == 0 ? "class='active' aria-current='true'" : '';
          $slide = $i + 1;
          echo "<button 
            type='button' 
            data-bs-target='#carouselExampleIndicators' data-bs-slide-to='$i'
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
      <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
      </button>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
</body>

</html>