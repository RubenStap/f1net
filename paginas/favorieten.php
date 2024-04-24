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
                    <!-- per coureur een sectie met de gegevens -->

                    <?php

                    readFavorieten($conn);

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