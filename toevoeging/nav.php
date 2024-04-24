<div class="bg-dark col-2 justify-content-between">
  <nav class="bg-dark sticky-top justify-content-left"> <!-- TODO: Navbar #user# staat niet gelijkt met de rest van de list -->
    <ul class="nav nav-pills flex-column mt-4">
      <div class="nav-item py-2 py-sm-0 mask">
        <div class="dropdown open ">

          <button class="btn nav-link border-none dropdown-toggle text-white " type="button" id="triggerId" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-user"></i><span class="fs-4 d-none ms-2 d-lg-inline">
              <!-- checkt of de gebruiker is ingelogd -->
              <?php
              if (isset($_SESSION['id'])) {
                  $stmt = $conn->prepare("SELECT * FROM gebruikers WHERE gebruikersID = :id");
                  $stmt->bindparam(':id', $_SESSION['id']);
                  $stmt->execute();
                  $gebruiker = $stmt->fetch(PDO::FETCH_ASSOC);
                  echo $gebruiker['gebruikersnaam'];
              } else {
                  echo "Gebruiker";
              }
                ?>
            </span>
          </button>
          <div class="dropdown-menu bg-secondary" aria-labelledby="triggerId">
            <?php
            // als je admin bent, dan krijg je een admin knop//
            if (isset($_SESSION['id'])) {
                if ($gebruiker['admin'] == 1) {
                    echo '<a class="dropdown-item fs-5 text-white" href="../paginas/admin.php"><i class="fa-solid fa-user-shield"></i><span class="ms-2 ">Admin</span></a>';
                } else {
                }
                echo '
            <a class="dropdown-item fs-5 text-white" href="../paginas/instellingen.php"><i class="fa-solid fa-gear"></i><span class="ms-2 ">Instellingen</span></a>
            <a class="dropdown-item fs-5 text-white" href="../paginas/favorieten.php"><i class="fa-solid fa-heart"></i><span class="ms-2 ">Favorieten</span></a>
            <form method="post">
            <button type="submit" class="dropdown-item fs-5 text-white" name="logout"><i class="fa-solid fa-right-from-bracket"></i><span class="ms-2 ">Uitloggen</span></button>
            </form>
            ';
            } else {
                echo '
            <a class="dropdown-item fs-5 text-white" href="../paginas/registreer.php"><i class="fa-solid fa-right-to-bracket"></i><span class="ms-2 ">Registreer</span></a>
            <a class="dropdown-item fs-5 text-white" href="../paginas/login.php"><i class="fa-solid fa-user"></i><span class="ms-2 ">login</span></a>
            ';
            }
            if (isset($_SESSION['id']) && isset($_POST['logout'])) {
                session_destroy();
                header("Refresh:0" . "; url=../index.php");
            }

            ?>
          </div>
        </div>
        <!-- de links in de navbar -->
      </div>
      <li class="nav-item py-2 py-sm-0 mask">
        <a href="../index.php" class="nav-link text-white">
          <i class="fa-solid fa-home"></i><span class="fs-4 d-none ms-2 d-lg-inline">Home</span>
        </a>
      </li>
      <li class="nav-item py-2 py-sm-0 mask">
        <a href="../paginas/coureurs.php" class="nav-link text-white">
          <i class="fa-solid fa-person"></i><span class="fs-4 d-none ms-2 d-lg-inline">Coureurs</span>
        </a>
      </li>
      <li class="nav-item py-2 py-sm-0 mask">
        <a href="../paginas/banen.php" class="nav-link text-white">
          <i class="fs-6 fa-solid fa-road"></i><span class="fs-4 d-none ms-2 d-lg-inline">Banen</span>
        </a>
      </li>
      <li class="nav-item py-2 py-sm-0 mask">
        <a href="../paginas/teams.php" class="nav-link text-white">
          <i class="fa-solid fa-people-group"></i><span class="fs-4 d-none ms-2 d-lg-inline">Teams</span>
        </a>
      </li>
      <li class="nav-item py-2 py-sm-0 mask">
        <a href="../paginas/overons.php" class="nav-link text-white">
          <i class="fa-solid fa-address-card"></i><span class="fs-4 d-none ms-2 d-lg-inline">Over ons</span>
        </a>
      </li>
    </ul>
    </ul>
</div>
