<footer class="text-center text-lg-start text-white bg-dark border-start border-danger border-3">

    <section class="d-flex justify-content-between p-2 bg-danger    ">
    </section>

    <section class="container-fluid text-center  mt-5">

        <div class="row mt-3">

            <div class="col-lg-3 mx-auto mb-4">

                <h6 class="text-uppercase fw-bold">over ons</h6>
                <hr class="mb-4 mt-0 d-inline-block" style="width: 60px; background-color: #ff4d4d; height: 2px" />
                <p>
                    Hallo wij zijn 5 developers die een passie hebben voor racen en dat graag willen delen.
                    Daarom hebben we deze site gemaakt voor de echte formule 1 fans. Op deze site kan je alles vinden wat ook maar te maken heeft met de formule 1. Van de teams tot aan de banen. Je kan ook een acount aanmaken voor het opslaan van je favorieten zodat je makkelijk bij ze kan. opelijk kunnen jullie er
                    van genieten veel dank developer team.
                </p>
            </div>
                <!-- footer links -->
            <div class="col-lg-3 mx-auto mb-4">

                <h6 class="text-uppercase fw-bold">Handige links</h6>
                <hr class="mb-4 mt-0 d-inline-block mx-auto" style="width: 60px; background-color: #ff4d4d; height: 2px" />
                <p>
                    <a href="../paginas/coureurs.php" class="text-white" style="text-decoration:none ">Coureurs</a>
                </p>
                <p>
                    <a href="../paginas/banen.php" class="text-white" style="text-decoration:none ">Banen</a>
                </p>
                <p>
                    <a href="../paginas/teams.php" class="text-white" style="text-decoration:none ">Teams</a>
                </p>

                 <!-- als de gebruiker ingelogd is kunnen ze de instellingen zien -->
                <?php
               if (isset($_SESSION['id']))
                    {
                        echo '<a class="text-white" style="text-decoration:none" href="../paginas/instellingen.php"> Instellingen </a>';
                    }
                else
                    {
                        echo '<a class="text-white" style="text-decoration:none" href="../paginas/login.php"> Inloggen </a>';
                    }
                ?>
            </div>
            <div class="col-lg-3 mx-auto mb-md-0 mb-4">

                <h6 class="text-uppercase fw-bold">Contact</h6>
                <hr class="mb-4 mt-0 d-inline-block mx-auto" style="width: 60px; background-color: #ff4d4d; height: 2px" />
                <p><i class="fas fa-home mr-3"></i> Alkmaar, Alk 10012, NL</p>
                <p><i class="fas fa-envelope mr-3"></i> f1-net@example.com</p>

            </div>
        </div>
    </section>
    <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2)">
        © 2024 Copyright:
        <a class="text-white" href="../index.php">F1-net.com</a>
    </div>

</footer>