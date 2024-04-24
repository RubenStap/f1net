<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    // Including head section
    include("../toevoeging/head.php");
    ?>
</head>

<body>
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

                <?php

                if (isset($_SESSION["admin"]) && $_SESSION["admin"] == true) {
                    echo
                    '<section class="row justify-content-center p-2 w-50 m-auto mt-2 mb-2 bg-dark text-light">
                    <h1 class="text-center mt-5 mb-5">Voeg Nieuwe Developer Toe</h1>
                    <form enctype="multipart/form-data" method="post" class="d-flex flex-column justify-content-center w-50">
                        <label for="naam" class="text-center">Naam</label>
                        <input type="text" name="naam" id="naam">
                        <label for="fileNaam" class="text-center">Afbeelding link</label>
                        <input type="file" id="fileNaam" name="fileNaam">
                        <label for="omschrijving" class="text-center">omschrijving</label>
                        <input type="text" name="omschrijving" id="omschrijving">
                        <label for="favCoureur" class="text-center">Favoriete Coureur</label>
                        <input type="text" name="favCoureur" id="favCoureur">
                        <input type="submit" name="voeg_developer_toe" value="Voeg Nieuwe Developer Toe" class="btn my-3 btn-lg text-white bg-danger">';
                    toevoegenOverOns($conn);
                    echo '
                    </form>
                    </section>';
                }

                ?>

                    <h1 class="text-center mt-5 mb-5">Meet The Team</h1>
                    <!-- per medewerker een sectie met de gegevens -->  

                    <?php

                    readOverOns($conn);

                    ?>
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
