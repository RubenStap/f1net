<!DOCTYPE html>
<html lang="en">

<head>
  <?php
  // Including head section
  include("../toevoeging/head.php");
  ?>
</head>

<body>
  <?php
  if (!isset($_SESSION['id'])) {
    header("Location: ../index.php");
    exit();
  }
  ?>
  <div class="container-fluid">
    <div class="row">
      <?php
      // Including navigation section
      include("../toevoeging/nav.php");
      ?>
      <div class="col-10 p-0">
        <?php
        // Including header section
        include("../toevoeging/header.php");
        ?>
        <!-- Main Heading -->
        <main>
          <section class="container-fluid my-5 ">
            <h1 class="text-center">instellingen</h1>

            <?php

            $record =  instellingenGebruikersnaam($conn);

            ?>
            <!-- formelier om gegevens te wijzigen -->
            <form method="post">
              <div class="row gy-3 gy-md-4 justify-content-md-center">

                <div class="col-8 ">
                  <label for="gebruiker" class="form-label">Nieuwe gebruikersnaam <span class="text-danger">*</span></label>
                  <div class="input-group">
                    <span class="input-group-text">
                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person" viewBox="0 0 16 16">
                        <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z" />
                      </svg>
                    </span>
                    <input type="gebruiker" class="form-control" name="gebruiker" id="gebruiker" value="<?php echo $record['gebruikersnaam'] ?>" required>
                  </div>
                </div>

                <div class="col-5">
                  <div class="d-grid">
                    <button class="btn btn-lg text-white bg-danger" type="submit">wijzig gebruikers naam</button>
                  </div>
                </div>
            </form>

            <form method="post">
              <div class="row gy-3 gy-md-4 justify-content-md-center">

                <div class="col-8">
                  <label for="password" class="form-label">Huidig Wachtwoord <span class="text-danger">*</span></label>
                  <div class="input-group">
                    <span class="input-group-text">
                      <!-- Password icon -->
                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-key" viewBox="0 0 16 16">
                        <path d="M0 8a4 4 0 0 1 7.465-2H14a.5.5 0 0 1 .354.146l1.5 1.5a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0L13 9.207l-.646.647a.5.5 0 0 1-.708 0L11 9.207l-.646.647a.5.5 0 0 1-.708 0L9 9.207l-.646.647A.5.5 0 0 1 8 10h-.535A4 4 0 0 1 0 8zm4-3a3 3 0 1 0 2.712 4.285A.5.5 0 0 1 7.163 9h.63l.853-.854a.5.5 0 0 1 .708 0l.646.647.646-.647a.5.5 0 0 1 .708 0l.646.647.646-.647a.5.5 0 0 1 .708 0l.646.647.793-.793-1-1h-6.63a.5.5 0 0 1-.451-.285A3 3 0 0 0 4 5z" />
                        <path d="M4 8a1 1 0 1 1-2 0 1 1 0 0 1 2 0z" />
                      </svg>
                    </span>
                    <input type="password" class="form-control" name="huidig-wachtwoord" id="huidig-wachtwoord" placeholder="Huidig Wachtwoord" required>
                  </div>
                </div>

                <div class="col-8">
                  <label for="wachtwoord" class="form-label">Nieuwe wachtwoord <span class="text-danger">*</span></label>
                  <div class="input-group">
                    <span class="input-group-text">
                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-key" viewBox="0 0 16 16">
                        <path d="M0 8a4 4 0 0 1 7.465-2H14a.5.5 0 0 1 .354.146l1.5 1.5a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0L13 9.207l-.646.647a.5.5 0 0 1-.708 0L11 9.207l-.646.647a.5.5 0 0 1-.708 0L9 9.207l-.646.647A.5.5 0 0 1 8 10h-.535A4 4 0 0 1 0 8zm4-3a3 3 0 1 0 2.712 4.285A.5.5 0 0 1 7.163 9h.63l.853-.854a.5.5 0 0 1 .708 0l.646.647.646-.647a.5.5 0 0 1 .708 0l.646.647.646-.647a.5.5 0 0 1 .708 0l.646.647.793-.793-1-1h-6.63a.5.5 0 0 1-.451-.285A3 3 0 0 0 4 5z" />
                        <path d="M4 8a1 1 0 1 1-2 0 1 1 0 0 1 2 0z" />
                      </svg>
                    </span>
                    <input type="password" class="form-control" name="nieuw-wachtwoord" id="nieuw-wachtwoord" placeholder="nieuw wachtwoord" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" required>
                  </div>
                </div>

                <div class="col-5">
                  <div class="d-grid">
                    <button class="btn btn-lg text-white bg-danger" type="submit" name="wachtwoord-submit" id="wachtwoord-submit">wijzig wachtwoord</button>
                  </div>
                </div>

              </div>

            </form>

            <?php

            $record =  instellingenWachtwoord($conn);

            ?>

            <form method="post">
              <div class="row gy-3 gy-md-4 justify-content-md-center">
                <div class="col-5">
                  <div class="d-grid">
                    <button class="btn btn-lg text-white bg-danger" type="submit" name="verwijder-account" id="verwijder-account">Verwijder Account</button>
                  </div>
                </div>

              </div>

            </form>

            <?php

            $record =  VerwijderAccount($conn);

            ?>
      </div>
      </section>
      </main>
      <?php
      // Including footer section
      include("../toevoeging/footer.php");
      ?>
    </div>
  </div>
  </div>
</body>

</html>