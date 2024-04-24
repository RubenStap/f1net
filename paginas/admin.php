
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
if (!isset($_SESSION['admin']) || !$_SESSION['admin']) {
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
                <main class="container-fluid">
                    <!-- Main Heading -->
                    <h1 class="text-center mt-5 mb-5">Admin panel</h1>

                    <section>
                        <?php
                        readGebruikersAdmin($conn)
                        ?>
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
