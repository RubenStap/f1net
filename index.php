<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>f1-net</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/b801578fa3.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" type="image/png" href="../afbeeldingen/logo/logo.png" />
    <script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>
    <?php

    session_start();
    include("functions/functions.php");
    $conn = dbConnect();
    ?>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <?php
            // Include navigation section
            include("toevoeging/nav.php");
            ?>
            <div class="col-10 p-0">
                <?php
                // Include header section
                include("toevoeging/header.php");
                ?>
                <main class="container">
                    <div class="container px-4 py-5" id="hanging-icons">
                        <div class="row g-4 py-5 row-cols-1 row-cols-lg-2">

                            <div class="col d-flex align-items-start">
                                <div class=" text-body-emphasis rounded d-inline-flex align-items-center justify-content-center fs-4 flex-shrink-0 me-3">
                                    <svg class="bi" width="1em" height="1em">
                                        <use xlink:href="#toggles2" />
                                    </svg>
                                </div>
                                <div>
                                    <article>
                                        <a class="text-decoration-none" target="_blank" href="https://www.formula1.com/en/latest/article.hulkenberg-calls-his-one-lap-pace-unexpected-as-haas-jump-up-the-order-in.3CAX1PoxdIlR4vYmzADXGI.html">
                                            <img class="img-thumbnail" src="afbeeldingen/index_afbeelding/f1_auto_atricle_1.avif" alt="auto">
                                            <h3 class="p-3 text-dark">Hülkenberg noemt zijn tempo in één ronde 'onverwacht' terwijl Haas in Bahrein een stapje hogerop komt</h3>
                                        </a>
                                    </article>
                                </div>
                            </div>

                            <div class="col d-flex align-items-start">
                                <div class=" text-body-emphasis  rounded d-inline-flex align-items-center justify-content-center fs-4 flex-shrink-0 me-3">
                                    <svg class="bi" width="1em" height="1em">
                                        <use xlink:href="#cpu-fill" />
                                    </svg>
                                </div>
                                <div>
                                    <article>
                                        <a class="text-decoration-none" target="_blank" href="https://www.formula1.com/en/latest/article.its-a-shock-hamilton-left-surprised-by-mercedes-early-pace-in-bahrain.yOMVTwqAkYM9ZOp3ptu5E.html">
                                            <img class="img-thumbnail" src="afbeeldingen/index_afbeelding/f1_hamilton_article_2.avif" alt="auto">
                                            <h3 class="p-3 text-dark">'Het is een schok' - Hamilton vertrok verrast door het vroege tempo van Mercedes in Bahrein</h3>
                                        </a>
                                    </article>
                                </div>
                            </div>
                            <div class="col d-flex align-items-start">
                                <div class=" text-body-emphasis  rounded d-inline-flex align-items-center justify-content-center fs-4 flex-shrink-0 me-3">
                                    <svg class="bi" width="1em" height="1em">
                                        <use xlink:href="#tools" />
                                    </svg>
                                </div>
                                <div>
                                    <article>
                                        <a class="text-decoration-none" target="_blank" href="https://www.formula1.com/en/latest/article.what-the-teams-said-thursday-practice-in-bahrain-2024.3GIrX9z83k4Xs6LtaxyFA8.html">
                                            <img class="img-thumbnail" src="afbeeldingen/index_afbeelding/f1_autos_article_3.avif" alt="auto">
                                            <h3 class="p-3 text-dark">Wat de teams zeiden - Donderdagtraining in Bahrein</h3>
                                        </a>
                                    </article>
                                </div>
                            </div>
                            <div class="col d-flex align-items-start">
                                <div class=" text-body-emphasis  rounded d-inline-flex align-items-center justify-content-center fs-4 flex-shrink-0 me-3">
                                    <svg class="bi" width="1em" height="1em">
                                        <use xlink:href="#tools" />
                                    </svg>
                                </div>
                                <div>
                                    <article>
                                        <a class="text-decoration-none" target="_blank" href="https://www.formula1.com/en/latest/article.verstappen-not-too-worried-after-practice-in-bahrain-as-he-predicts-very.75ppsgOSQQtXenCZ9v0W9G.html">
                                            <img class="img-thumbnail" src="afbeeldingen/index_afbeelding/f1_max_article_3.avif" alt="auto">
                                            <h3 class="p-3 text-dark">Verstappen 'niet al te bezorgd' na de training in Bahrein, aangezien hij de kwalificatie 'heel dichtbij' voorspelt</h3>
                                        </a>
                                    </article>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
                <?php
                // Include footer section
                include("toevoeging/footer.php");
                ?>
            </div>

        </div>
    </div>
</body>

</html>