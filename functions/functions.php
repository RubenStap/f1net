<?php

// Index Functions
// (Lijn 17 t/m 34) Database Connectie
// (Lijn 40 t/m 132) Registreren en Inloggen
// (Lijn 132 t/m 246) Aanpassen Account.
// (Lijn 249 t/m 583) Favorieten Functions (Delete, Read en Toevoegen)
// (Lijn 586 t/m 886) Coureurs (Read, Toevoegen, Aanpassen, Verwijderen en Favorieten bekijken)
// (Lijn 889 t/m 1158) Banen (Read, Toevoegen, Aanpassen, Verwijderen en Favorieten bekijken)
// (Lijn 1200 t/m 1491) Teams (Read, Toevoegen, Aanpassen, Verwijderen en Favorieten bekijken)
// (Lijn 1494 t/m 1765) OverOns (Read, Toevoegen, Aanpassen en Verwijderen)
// (Lijn 1768 t/m 1836) Admin (Updaten admins) 


// *********************************************************************** //
//conectie database
function dbConnect()
{
    // Slaat variabele op met inlog gegevens
    try {
        $servername = "localhost";
        $database = "f1net";
        $dsn = "mysql:host=$servername;dbname=$database";
        $username = "root";
        $password = "";

        // Maak verbinding met de database
        $conn = new PDO($dsn, $username, $password);
        return $conn;
        // Als er error is krijg je errormessage.
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}


// *********************************************************************** //


// functie registreer
function registreer($conn)
{
    // Krijg de gebruikersnaam, email, wachtwoord, wachtwoord2 op.
    if (isset($_POST['submit'])) {
        $gebruikersnaam = $_POST['gebruiker'];
        $email = $_POST['email'];
        $ww = $_POST['ww'];
        $ww2 = $_POST['ww2'];
        $hashedWachtwoord = password_hash($ww, PASSWORD_DEFAULT);
        $admin = 0;

        // controleer of de gebruikersnaam al bestaat
        $stmtCheck = $conn->prepare("SELECT * FROM gebruikers WHERE gebruikersnaam = :gebruikersnaam");
        if ($stmtCheck->execute(['gebruikersnaam' => $gebruikersnaam])) {
            $row = $stmtCheck->fetch();
            if ($row) {
                echo "<script type=\"text/javascript\">toastr.error('Gebruikersnaam bestaat al')</script>";
                return;
            }
        }

              // Controleer of het e-mailadres geldig is
              if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                echo "<script type=\"text/javascript\">toastr.error('Ongeldig e-mailadres')</script>";
                return;
            }

        // controlleer of de email al bestaat
        $stmtCheck = $conn->prepare("SELECT * FROM gebruikers WHERE email = :email");
        if ($stmtCheck->execute(['email' => $email])) {
            $row = $stmtCheck->fetch();
            if ($row) {
                echo "<script type=\"text/javascript\">toastr.error('Email bestaat al')</script>";
                return;
            }
        }
        // controlleer of de wachtwoorden overeenkomen
        if ($ww == $ww2) { // Als ww is hetzelfde als ww2 voer dan de code uit
            try {
                $stmtUpdate = $conn->prepare("INSERT INTO gebruikers (email, gebruikersnaam, wachtwoord, admin) VALUES (:email, :gebruikersnaam, :ww, :admin)");
                $stmtUpdate->bindParam(':email', $email);
                $stmtUpdate->bindParam(':gebruikersnaam', $gebruikersnaam);
                $stmtUpdate->bindParam(':ww', $hashedWachtwoord);
                $stmtUpdate->bindParam(':admin', $admin);
                $stmtUpdate->execute();

                if ($stmtUpdate) {
                    echo "<script type=\"text/javascript\">toastr.success('Succesvol geregistreerd')</script>";
                } else {
                    echo "<script type=\"text/javascript\">toastr.error('Er is iets fout gegaan')</script>";
                }
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        } else {
            echo "<script type=\"text/javascript\">toastr.error('Wachtwoorden komen niet overeen')</script>"; // Geef een alert als de wachtwoorden niet overeenkomen
        }
    }
}


// *********************************************************************** //


// functie inloggen
function Inloggen($conn)
{
    // Kijkt of submitknop is ingedrukt.
    if (isset($_POST['submit'])) {
        $email = $_POST['email'];
        $wachtwoord = $_POST['wachtwoord'];

        // Query voor het ophalen van informatie.
        $stmt = $conn->prepare("SELECT * FROM gebruikers WHERE email = :email");
        $stmt->bindparam(':email', $email);
        $stmt->execute();
        $gebruiker = $stmt->fetch(PDO::FETCH_ASSOC);

        // Kijkt of gebruiker bestaat.
        if ($gebruiker) {
            if (password_verify($wachtwoord, $gebruiker['wachtwoord'])) {
                $_SESSION['id'] = $gebruiker['gebruikersID'];
                $_SESSION["admin"] = $gebruiker["admin"];
                echo "<script>window.location.href='../index.php';</script>";
                exit();
                // Als er fout is krijg je alert met foutmelding.
            } else {
                echo "<script type=\"text/javascript\">toastr.error('Wachtwoord en Email adres komen niet overeen')</script>";
            }
        }
    }
}


// *********************************************************************** //
// Functie Instellingen Updaten
function instellingenGebruikersnaam($conn)
{
    // haalt info op uit de data zodat dit in de input veld ztaat
    $stmt = $conn->prepare("SELECT * FROM gebruikers WHERE gebruikersID = :id");
    $stmt->bindparam(':id', $_SESSION['id']);
    $stmt->execute();

    // Hier voer je de fetchmode uit en zet het in associative array.
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $result = $stmt->fetchAll(); // Hier wordt de fetch uitgevoerd zodat het gezien kan worden.

    // foreach loop zodat het als key : value gezet wordt. Bijvoorbeeld Bram : Alkmaar.
    foreach ($result as $record) {
        foreach ($record as $key => $value) {
        }
    }

    //als knop word in gedrukt word de nieuwe info in de database gezet 

    if (isset($_POST['gebruiker'])) {
        // var_dump($result);
        $gebruikersnaam = $_POST['gebruiker'];

        $stmt = $conn->prepare("UPDATE gebruikers SET gebruikersnaam = '$gebruikersnaam' WHERE gebruikersID = :id");
        $stmt->bindparam(':id', $_SESSION['id']);
        $stmt->execute();
        echo "<script type='text/javascript'>toastr.success('Succesvol naam gewijzigd.')</script>";

        echo "<script>
                    setTimeout(function(){
                        window.location.href='../paginas/instellingen.php';
                     }, 2500);
                    </script>";
    }
    return $record;
}

// *********************************************************************** //

function instellingenWachtwoord($conn)
{
    // als knop is ingedurkt word de info van id opgehaalt en het wachtwoord in een variable gezet
    if (isset($_POST['wachtwoord-submit'])) {
        $wachtwoord = $_POST['huidig-wachtwoord'];

        $stmt = $conn->prepare("SELECT * FROM gebruikers WHERE gebruikersID = :id");
        $stmt->bindparam(':id', $_SESSION['id']);
        $stmt->execute();
        $gebruiker = $stmt->fetch(PDO::FETCH_ASSOC);

        // als de gebruiker in de database staat kijkt hij of het oude wachtwoord klopt en past hij deze aan naar de nieuwe
        if ($gebruiker) {
            if (password_verify($wachtwoord, $gebruiker['wachtwoord'])) {
                if (isset($_POST['nieuw-wachtwoord'])) {
                    $wachtwoord = $_POST['nieuw-wachtwoord'];
                    $hashedWachtwoord = password_hash($wachtwoord, PASSWORD_DEFAULT);
                    $stmt = $conn->prepare("UPDATE gebruikers SET wachtwoord = '$hashedWachtwoord' WHERE gebruikersID = :id");
                    $stmt->bindparam(':id', $_SESSION['id']);
                    $stmt->execute();
                    echo "<script type='text/javascript'>toastr.success('Succesvol wachtwoord gewijzigd.')</script>";

                    echo "<script>
                    setTimeout(function(){
                        window.location.href='../paginas/instellingen.php';
                     }, 2500);
                    </script>";
                }
            } else {
                //error mesage
                echo "<script type=\"text/javascript\">toastr.error('Wachtwoorden komen niet overeen')</script>";
            }
        }
    }
}

// *********************************************************************** //
// Functie Instellingen Updaten

function VerwijderAccount($conn)
{
    if (isset($_POST["verwijder-account"]))
    {
        $stmt = $conn->prepare("DELETE FROM favorieten WHERE gebruikersID = :gebruikersID");
        $stmt->bindParam(':gebruikersID', $_SESSION['id']);
        $stmt->execute();

        $stmt1 = $conn->prepare("DELETE FROM gebruikers WHERE gebruikersID = :gebruikersID");
        $stmt1->bindParam(':gebruikersID', $_SESSION['id']);
        $stmt1->execute();
        session_destroy();
        echo "<script type='text/javascript'>toastr.success('Succesvol account verwijderd.')</script>";

        echo "<script>
                    setTimeout(function(){
                        window.location.href='../index.php';
                     }, 2500);
                    </script>";
    }




}
// *********************************************************************** //
// Functie Wijzig Wachtwoord

function wijzigWachtwoord($conn)
{
    // Controleer of het formulier is ingediend
    if (isset($_POST['submit'])) {
        // Controleer of de ingevoerde wachtwoorden overeenkomen
        if ($_POST['nieuw-wachtwoord'] == $_POST['herhaal-nieuw-wachtwoord']) {
            try {
                // Haal email en gebruikersnaam op uit het POST-verzoek
                $email = $_POST['email'];
                $gebruikersnaam = $_POST['gebruikersnaam'];

                // Bereid en voer een SQL-query uit om de gebruiker te selecteren op basis van email en gebruikersnaam
                $stmt = $conn->prepare("SELECT gebruikersID FROM gebruikers WHERE email = :email AND gebruikersnaam = :gebruikersnaam");
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':gebruikersnaam', $gebruikersnaam);
                $stmt->execute();
                $result = $stmt->fetch(PDO::FETCH_ASSOC);

                // Controleer of de gebruiker bestaat
                if ($result) {
                    $id = $result['gebruikersID'];
                    $wachtwoord = $_POST['nieuw-wachtwoord'];

                    // Hash het nieuwe wachtwoord voordat het wordt opgeslagen in de database
                    $hashedWachtwoord = password_hash($wachtwoord, PASSWORD_DEFAULT);

                    // Bereid en voer een SQL-query uit om het wachtwoord van de gebruiker bij te werken
                    $stmt = $conn->prepare("UPDATE gebruikers SET wachtwoord = :hashedWachtwoord WHERE gebruikersID = :id");
                    $stmt->bindParam(':hashedWachtwoord', $hashedWachtwoord);
                    $stmt->bindParam(':id', $id);
                    $stmt->execute();
                    echo "<script type='text/javascript'>toastr.success('Succesvol wachtwoord gewijzigd.')</script>";
                    // Redirect naar de homepage na succesvolle wachtwoordwijziging
                    echo "<script>
                    setTimeout(function(){
                        window.location.href='../paginas/login.php';
                     }, 2500);
                    </script>";
                } else {
                    // Toon een foutmelding als de gebruikersnaam en email niet overeenkomen
                    echo "<script type='text/javascript'>toastr.error('Gebruikersnaam en email komen niet over een')</script>";
                }
            } catch (PDOException $e) {
                // Toon een foutmelding bij een databasefout
                echo "<script type='text/javascript'>toastr.error('Database error')</script>";
            }
        }
    }
}

// *********************************************************************** //
// functie favorieten verwijderen
function deleteFavorieten($conn, $id)
{
    // zet een variable op de $favCoureur
    $favCoureur = "favoriet_coureur$id";
    if (isset($_POST[$favCoureur])) {
        // delete query om de coureurs uit de favorieten te verwijderen
        $stmt = $conn->prepare("DELETE FROM favorieten WHERE gebruikersID = :gebruikersID AND coureurID = :coureurID");
        $stmt->bindParam(':gebruikersID', $_SESSION['id']);
        $stmt->bindParam(':coureurID', $_POST['coureurID']);
        $stmt->execute();
        echo "<script type='text/javascript'>toastr.success('Succesvol verwijderd uit favorieten coureur.')</script>";
        echo "<script>
        setTimeout(function(){
        window.location.href='../paginas/favorieten.php';
        }, 2500);
        </script>";
    }

    // zet een variable op de $favTeam
    $favteam = "favoriet_team$id";
    if (isset($_POST[$favteam])) {
        // delete query om de teams uit de favorieten te verwijderen
        $stmt = $conn->prepare("DELETE FROM favorieten WHERE gebruikersID = :gebruikersID AND teamID = :teamID");
        $stmt->bindParam(':gebruikersID', $_SESSION['id']);
        $stmt->bindParam(':teamID', $_POST['teamID']);
        $stmt->execute();
        echo "<script type='text/javascript'>toastr.success('Succesvol verwijderd uit favorieten team.')</script>";
        echo "<script>
        setTimeout(function(){
        window.location.href='../paginas/favorieten.php';
        }, 2500);
        </script>";
    } 

    // zet een variable op de $favBaan
    $favBaan = "favoriet_baan$id";
    if (isset($_POST[$favBaan])) {
        // delete query om de banen uit de favorieten te verwijderen
        $stmt = $conn->prepare("DELETE FROM favorieten WHERE gebruikersID = :gebruikersID AND banenID = :banenID");
        $stmt->bindParam(':gebruikersID', $_SESSION['id']);
        $stmt->bindParam(':banenID', $_POST['banenID']);
        $stmt->execute();
        echo "<script type='text/javascript'>toastr.success('Succesvol verwijderd uit favorieten baan.')</script>";
        echo "<script>
        setTimeout(function(){
        window.location.href='../paginas/favorieten.php';
        }, 2500);
        </script>";
    }
} 


// *********************************************************************** //
// functie favorieten toevoegen

function favorieten($conn)
{

    // Als er geen session id is ( dus de gebruiker is niet ingelogt ) geef dan een error en voer de functie verder niet uit
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if ($_SESSION['id'] == null) {
            echo "<script type='text/javascript'>toastr.error('Creer een account om een favoriet toe te voegen')</script>";
            exit;
        }
    }

    try {
        // vraagt de url van de pagina waar je bent
        $url = $_SERVER['REQUEST_URI'];

        // Als de url van de pagina /paginas/teams.php is doe dan de code
        if ($url == '/paginas/teams.php') {
            if (isset($_POST['teamsID'])) {
                $stmtCheckFav = $conn->prepare("SELECT * FROM favorieten WHERE gebruikersID = :gebruikersID AND teamID = :teamID");
                $stmtCheckFav->bindParam(':gebruikersID', $_SESSION['id']);
                $stmtCheckFav->bindParam(':teamID', $_POST['teamsID']);
                $stmtCheckFav->execute();

                if ($stmtCheckFav->rowCount() > 0) {
                    $stmt = $conn->prepare("DELETE FROM favorieten WHERE gebruikersID = :gebruikersID AND teamID = :teamID");
                    $stmt->bindParam(':gebruikersID', $_SESSION['id']);
                    $stmt->bindParam(':teamID', $_POST['teamsID']);
                    $stmt->execute();
                    echo "<script>
                    setTimeout(function(){
                        window.location.href='../paginas/teams.php';
                     }, 2500);
                    </script>";
                    echo "<script type='text/javascript'>toastr.success('Succesvol verwijderd uit favorieten.')</script>";
                } else {
                    $stmt = $conn->prepare("INSERT INTO favorieten (gebruikersID, teamID) VALUES (:gebruikersID, :teamID)");
                    $stmt->bindParam(':gebruikersID', $_SESSION['id']);
                    $stmt->bindParam(':teamID', $_POST['teamsID']);
                    $stmt->execute();

                    echo "<script>
                    setTimeout(function(){
                        window.location.href='../paginas/teams.php';
                     }, 2500);
                    </script>";
                    echo "<script type='text/javascript'>toastr.success('Succesvol toegevoegd aan favorieten.')</script>";
                }
            }
            // Als de url van de pagina /paginas/banen.php is doe dan de code
        } elseif ($url == '/paginas/banen.php') {
            if (isset($_POST['banenID'])) {
                $stmtCheckFav = $conn->prepare("SELECT * FROM favorieten WHERE gebruikersID = :gebruikersID AND banenID = :banenID");
                $stmtCheckFav->bindParam(':gebruikersID', $_SESSION['id']);
                $stmtCheckFav->bindParam(':banenID', $_POST['banenID']);
                $stmtCheckFav->execute();

                if ($stmtCheckFav->rowCount() > 0) {
                    $stmt = $conn->prepare("DELETE FROM favorieten WHERE gebruikersID = :gebruikersID AND banenID = :banenID");
                    $stmt->bindParam(':gebruikersID', $_SESSION['id']);
                    $stmt->bindParam(':banenID', $_POST['banenID']);
                    $stmt->execute();
                    echo "<script>
                    setTimeout(function(){
                        window.location.href='../paginas/banen.php';
                     }, 2500);
                    </script>";
                    echo "<script type='text/javascript'>toastr.success('Succesvol verwijderd uit favorieten.')</script>";
                } else {
                    $stmt = $conn->prepare("INSERT INTO favorieten (gebruikersID, banenID) VALUES (:gebruikersID, :banenID)");
                    $stmt->bindParam(':gebruikersID', $_SESSION['id']);
                    $stmt->bindParam(':banenID', $_POST['banenID']);
                    $stmt->execute();

                    echo "<script>
                    setTimeout(function(){
                        window.location.href='../paginas/banen.php';
                     }, 2500);
                    </script>";
                    echo "<script type='text/javascript'>toastr.success('Succesvol toegevoegd aan favorieten.')</script>";
                }
            }
            // Als de url van de pagina /paginas/coureurs.php is doe dan de code
        } elseif ($url == '/paginas/coureurs.php') {
            if (isset($_POST['coureurID'])) {
                $stmtCheckFav = $conn->prepare("SELECT * FROM favorieten WHERE gebruikersID = :gebruikersID AND coureurID = :coureurID");
                $stmtCheckFav->bindParam(':gebruikersID', $_SESSION['id']);
                $stmtCheckFav->bindParam(':coureurID', $_POST['coureurID']);
                $stmtCheckFav->execute();

                if ($stmtCheckFav->rowCount() > 0) {
                    $stmt = $conn->prepare("DELETE FROM favorieten WHERE gebruikersID = :gebruikersID AND coureurID = :coureurID");
                    $stmt->bindParam(':gebruikersID', $_SESSION['id']);
                    $stmt->bindParam(':coureurID', $_POST['coureurID']);
                    $stmt->execute();
                    echo "<script>
                    setTimeout(function(){
                        window.location.href='../paginas/coureurs.php';
                     }, 2500);
                    </script>";
                    echo "<script type='text/javascript'>toastr.success('Succesvol verwijderd uit favorieten.')</script>";
                } elseif ($url == '/paginas/favorieten.php') {
                    if (isset($_POST['favoriet'])) {
                        $stmt = $conn->prepare("DELETE FROM favorieten WHERE gebruikersID = :gebruikersID AND coureurID = :coureurID");
                        $stmt->bindParam(':gebruikersID', $_SESSION['id']);
                        $stmt->bindParam(':coureurID', $_POST['coureurID']);
                        $stmt->execute();
                        echo "<script>
                    setTimeout(function(){
                        window.location.href='../paginas/coureurs.php';
                     }, 2500);
                    </script>";
                        echo "<script type='text/javascript'>toastr.success('Succesvol verwijderd uit favorieten.')</script>";
                    }
                } else {
                    $stmt = $conn->prepare("INSERT INTO favorieten (gebruikersID, coureurID) VALUES (:gebruikersID, :coureurID)");
                    $stmt->bindParam(':gebruikersID', $_SESSION['id']);
                    $stmt->bindParam(':coureurID', $_POST['coureurID']);
                    $stmt->execute();

                    echo "<script>
                    setTimeout(function(){
                        window.location.href='../paginas/coureurs.php';
                     }, 2500);
                    </script>";
                    echo "<script type='text/javascript'>toastr.success('Succesvol toegevoegd aan favorieten.')</script>";
                }
            }
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

// *********************************************************************** //
// functie favorieten ophalen

function readFavorieten($conn)
{

    // het voorbereiden van de tabel//
    $stmt = $conn->prepare("SELECT * FROM favorieten WHERE gebruikersID = :gebruikersID");
    $stmt->bindParam(':gebruikersID', $_SESSION["id"]);
    $stmt->execute();


    // het ophalen van de data //
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $favorieten = $stmt->fetchAll();

    // zet de verschillen id van de tabbelen in friable
    $coureurID = array();
    $teamID = array();
    $banenID = array();
    $geliked = false;
    foreach ($favorieten as $key => $variable) {
        foreach ($variable as $key => $value) {
            if ($key == "coureurID" && !is_null($value)) {
                $coureurID[] = $value;
                $geliked = true;
            } elseif ($key == "teamID" && !is_null($value)) {
                $teamID[] = $value;
                $geliked = true;
            } elseif ($key == "banenID" && !is_null($value)) {
                $banenID[] = $value;
                $geliked = true;
            }
        }
    }

    //kijkt of er iets geliked is
    if ($geliked == false) {
        echo "<h1 class='text-center h1 p-5 m-5'>Je heb nog niks geliked</h1>";
    }

    //kijkt of er 1 of meerde likes zijn
    if (count($coureurID) >= 1) {
        echo "<h1 class='text-center h1'>Gelikete courers</h1>";
        //haald de info van coureurs een voor een op
        foreach ($coureurID as $key) {
            $stmt = $conn->prepare("SELECT * FROM coureurs WHERE coureurID = :coureurID");
            $stmt->bindParam(':coureurID', $key);
            $stmt->execute();

            // het ophalen van de data //
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $coureurs = $stmt->fetchAll();

            //zet de coureurs in html code zodat dit op de website komt
            foreach ($coureurs as $record) {
                echo '<section class="row justify-content-center p-2  w-50 m-auto mt-2 mb-2 bg-dark text-light">
                 <img src="../afbeeldingen/coureurs/' . $record['afbeelding'] . '" alt="logo" class="col-3 rounded" style="width: 130px; height: 100px;">
                 <div class="p-3 col-9">
                 <h2>' . $record['title'] . '</h2>
                <p>' . $record['omschrijving'] . '</p>
                <form action="" method="POST">';
                $check = checkFavCoureur($conn, $record['coureurID']);
                if ($check == true) {
                    echo '<input type="hidden" name="coureurID" value="' . $record['coureurID'] .
                        '">
                <button type="submit" name="favoriet_coureur' . $record['coureurID'] . '" id="favoriet" class="btn border-none text-light bg-danger"><i class="fa-solid fa-heart"></i></button>';
                } 
                echo '</form>
             </div>';
                deleteFavorieten($conn , $record['coureurID']);
            }
            echo '</section>';
        }
    }

    //kijkt of er 1 of meerdere teams geliked is
    if (count($teamID) >= 1) {
        echo "<h1 class='text-center h1'>Gelikete teams</h1>";
        //haald 1 voor 1 de info uit de database
        foreach ($teamID as $key) {
            $stmt = $conn->prepare("SELECT * FROM teams WHERE teamID = :teamID");
            $stmt->bindParam(':teamID', $key);
            $stmt->execute();

            // het ophalen van de data //
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $teams = $stmt->fetchAll();

            //zet de data op de website
            foreach ($teams as $record) {
                echo '<section class="row justify-content-center p-2  w-50 m-auto mt-2 mb-2 bg-dark text-light">
                 <img src="../afbeeldingen/teams/' . $record['afbeelding'] . '" alt="logo" class="col-3 rounded" style="width: 130px; height: 100px;">
                 <div class="p-3 col-9">
                 <h2>' . $record['title'] . '</h2>
                <p>' . $record['omschrijving'] . '</p>
                <form action="" method="POST">';
                $check = checkFavTeams($conn, $record['teamID']);
                if ($check == true) {
                    echo '<input type="hidden" name="teamID" value="' . $record['teamID'] .
                        '">
                <button type="submit" name="favoriet_team' . $record['teamID'] . '" id="favoriet" class="btn border-none text-light bg-danger"><i class="fa-solid fa-heart"></i></button>';
                }
                echo '</form>
             </div>';
                deleteFavorieten($conn, $record['teamID']);
            }
            echo '</section>';
        }
    }

    // kijkt of er 1 of meerder likes zijn op banen
    if (count($banenID) >= 1) {
        echo "<h1 class='text-center h1'>Gelikete Banen</h1>";
        foreach ($banenID as $key) {
            $stmt = $conn->prepare("SELECT * FROM banen WHERE banenID = :banenID");
            $stmt->bindParam(':banenID', $key);
            $stmt->execute();

            // het ophalen van de data //
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $banen = $stmt->fetchAll();

            // zet de data op de website
            foreach ($banen as $record) {
                echo '<section class="row justify-content-center p-2  w-50 m-auto mt-2 mb-2 bg-dark text-light">
                 <img src="../afbeeldingen/banen/' . $record['afbeelding'] . '" alt="logo" class="col-3 rounded" style="width: 130px; height: 100px;">
                 <div class="p-3 col-9">
                 <h2>' . $record['title'] . '</h2>
                <p>' . $record['omschrijving'] . '</p>
                <form action="" method="POST">';
                $check = checkFavBanen($conn, $record['banenID']);
                if ($check == true) {
                    echo '<input type="hidden" name="banenID" value="' . $record['banenID'] .
                        '">
                <button type="submit" name="favoriet_baan' . $record['banenID'] . '" id="favoriet" class="btn border-none text-light bg-danger"><i class="fa-solid fa-heart"></i></button>';
                }
                echo '</form>
             </div>';
                deleteFavorieten($conn , $record['banenID']);
            }
            echo '</section>';
        }
    }
}

// *********************************************************************** //
// Functie Voor readCoureurs

function readCoureurs($conn)
{
    // het voorbereiden van de tabel//
    $stmt = $conn->prepare("SELECT * FROM coureurs");
    $stmt->execute();

    // het ophalen van de data //
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $coureurs = $stmt->fetchAll();

    // de opbouw van de placeholder//
    foreach ($coureurs as $record) {
        echo '<section class="row justify-content-center p-2  w-50 m-auto mt-2 mb-2 bg-dark text-light">
        <img src="../afbeeldingen/coureurs/' . $record['afbeelding'] . '" alt="logo" class="col-3 rounded" style="width: 130px; height: 100px;">
        <div class="p-3 col-9">
            <h2>' . $record['title'] . '</h2>
            <p>' . $record['omschrijving'] . '</p>
            <form action="" method="POST">';
        $check = checkFavCoureur($conn, $record['coureurID']);
        if ($check == true) {
            echo '<input type="hidden" name="coureurID" value="' . $record['coureurID'] . '">
                <button type="submit" name="favoriet" id="favoriet" class="btn border-none text-light bg-danger"><i class="fa-solid fa-heart"></i></button>';
        } else {
            echo '<input type="hidden" name="coureurID" value="' . $record['coureurID'] . '">
                <button type="submit" name="favoriet" id="favoriet" class="btn border-none bg-danger"><i class="fa-solid fa-heart"></i></button>';
        }
        echo '</form>
        </div>';

        $coureurID = $record['coureurID'];
        updateCoureurs($conn, $coureurID);

        echo '</section>';
    }

    favorieten($conn);

    return $coureurs;
}


// *********************************************************************** //
// voegd niewe coureurs toe via function

function toevoegenCoureurs($conn)
{
    //als je de knop indrukt kijkt hij of de afbeelding is toegevoegd
    if (isset($_POST['voeg_coureur_toe'])) {
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["fileNaam"])) {
            //zet variable
            $path_naar_mappenstructuur = "../afbeeldingen/coureurs/";

            $bestand_naam = str_replace(' ', '_', strtolower($_POST["title"]));

            $afbeelding_type = strtolower(pathinfo($_FILES["fileNaam"]["name"], PATHINFO_EXTENSION));

            $doel_bestand = $path_naar_mappenstructuur . $bestand_naam . '.' . $afbeelding_type;

            $bestand_veilig = 1;

            // kijkt of het bestand al in de database staat
            if (file_exists($doel_bestand)) {
                echo "<script type='text/javascript'>toastr.error('het bestand bestaat al')</script>";
                $bestand_veilig = 0;
            }

            // kijkt of het bestand niet onnodig groot is 
            if ($_FILES["fileNaam"]["size"] > 500000) {
                echo "<script type='text/javascript'>toastr.error('het bestand is te groot.')</script>";
                $bestand_veilig = 0;
            }

            //kijkt of de afbeelding een png bestand is
            if ($afbeelding_type != "png") {
                echo "<script type='text/javascript'>toastr.error('alleen PNG bestanden zijn toegestaan.')</script>";
                $bestand_veilig = 0;
            }

            //kijkt of de afbeelding aan alle kritiria voldoet en zet dan het bestand op de goede plek 
            if ($bestand_veilig == 0) {
                echo " <script type='text/javascript'>toastr.error(' het bestand is niet geupload.')</script>";
            } else {
                if (move_uploaded_file($_FILES["fileNaam"]["tmp_name"], $doel_bestand)) {
                    echo "<script type=\"text/javascript\">toastr.success('Succesvol geupload')</script>";
                } else {
                    echo "<script type='text/javascript'>toastr.error('er ging iets fout met het uploaden.')</script>";
                }
            }
        }
        // zet de goede variable en zet deze in de database
        $title = $_POST['title'];
        $omschrijving = $_POST['omschrijving'];
        $afbeelding = $title . ".png";

        $stmtUpdate = $conn->prepare("INSERT INTO coureurs (title, afbeelding, omschrijving) 
            VALUES (:title, :afbeelding, :omschrijving)");
        $stmtUpdate->bindParam(':title', $title);
        $stmtUpdate->bindParam(':afbeelding', $afbeelding);
        $stmtUpdate->bindParam(':omschrijving', $omschrijving);
        $stmtUpdate->execute();
    }
}

// *********************************************************************** //
// functie coureurs update

function updateCoureurs($conn, $coureurID)
{
    // Kijkt of user [admin] is.
    if (isset($_SESSION["admin"]) && $_SESSION["admin"] == true) {
        echo '<div class="text-center">
        <form method="post">
        <button class="btn btn-lg text-white bg-danger" type="submit" name="wijzig' . $coureurID . '">Wijzig Coureur </button>
        <button class="btn btn-lg text-white bg-danger" type="submit" name="verwijder' . $coureurID . '">Verwijder Coureur</button>
    </form>
    </div>';
        $wijzig = 'wijzig' . $coureurID;
        $verwijder = 'verwijder' . $coureurID;
        // Kijkt of verwijderknop is ingedrukt.
        if (isset($_POST[$verwijder])) {
            verwijdercoureurs($conn, $coureurID);
            echo 'Verwijderd uit DataBase';
        }
        // Kijkt of wijzigknop is ingedrukt.
        if (isset($_POST[$wijzig])) {
            $stmt = $conn->prepare("SELECT * FROM coureurs WHERE coureurID = :coureurID");
            $stmt->bindParam(':coureurID', $coureurID);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            // HTML form voor informatie. Gelikt aan de gegevens uit de database.
            echo '<div class="row justify-content-center bg-dark text-light">
        <form enctype="multipart/form-data" method="post" class="d-flex flex-column justify-content-center w-50">

        <label for="title" class="text-center">Title</label>
        <input type="text" name="title" id="title" name="title" value="' . $result['title'] . '">

        <label for="fileNaam" class="text-center">Afbeelding link</label>
        <input type="file" id="fileNaam" name="fileNaam">
        

        <label for="omschrijving" class="text-center">Omschrijving</label>
        <input type="text" name="omschrijving" id="omschrijving" value="' . $result['omschrijving'] . '">

        <input type="submit" name="wijzig_coureur' . $coureurID . '" value="Wijzig Coureur" class="btn btn-lg text-white bg-danger my-3">
    </form> 
    </div>';
        }
    }
    $Wijzig = 'wijzig_coureur' . $coureurID;
    // Kijkt of Wijzigknop is ingedrukt.
    if (isset($_POST[$Wijzig])) {
        $title = $_POST['title'];
        $omschrijving = $_POST['omschrijving'];

        // Kijkt of het bestand is set.
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["fileNaam"])) {
            $title = $_POST['title'];
            $afbeelding = str_replace(' ', '_', strtolower($title)) . ".png";
            $omschrijving = $_POST['omschrijving'];

            // Query voor het ophalen van informatie.
            $stmt = $conn->prepare("SELECT * FROM coureurs WHERE coureurID = :coureurID");
            $stmt->bindParam(':coureurID', $coureurID);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            $path_naar_mappenstructuur = "../afbeeldingen/coureurs/";

            $bestand_naam = str_replace(' ', '_', strtolower($_POST["title"]));

            $afbeelding_type = strtolower(pathinfo($_FILES["fileNaam"]["name"], PATHINFO_EXTENSION));

            $doel_bestand = $path_naar_mappenstructuur . $bestand_naam . '.' . $afbeelding_type;

            $bestand_veilig = 1;

            $afbeelding_bestemming = $result['afbeelding'];

            // Kijkt of het bestand te groot is.
            if ($_FILES["fileNaam"]["size"] > 500000) {
                echo "<script type='text/javascript'>toastr.error('het bestand is te groot.')</script>";
                $bestand_veilig = 0;
            }

            // Kijkt of het bestand een PNG bestand is.
            if ($afbeelding_type != "png") {
                echo "<script type='text/javascript'>toastr.error('alleen PNG bestanden zijn toegestaan.')</script>";
                $bestand_veilig = 0;
            }

            // Kijkt of het bestand geupload is.
            if ($bestand_veilig == 0) {
                echo " <script type='text/javascript'>toastr.error(' het bestand is niet geupload.')</script>";
            } else {
                if (move_uploaded_file($_FILES["fileNaam"]["tmp_name"], $doel_bestand)) {
                    unlink("../afbeeldingen/coureurs/$afbeelding_bestemming");
                    echo "<script type=\"text/javascript\">toastr.success('Succesvol geupload')</script>";
                    // Query voor het updaten van de database met afbeelding.
                    $stmt = $conn->prepare("UPDATE coureurs SET title = :title, afbeelding = :afbeelding, omschrijving = :omschrijving WHERE coureurID = :coureurID");
                    $stmt->bindParam(':title', $title);
                    $stmt->bindParam(':afbeelding', $afbeelding);
                    $stmt->bindParam(':omschrijving', $omschrijving);
                    $stmt->bindparam(':coureurID', $coureurID);
                    $stmt->execute();
                } else {
                    echo "<script type='text/javascript'>toastr.error('er ging iets fout met het uploaden.')</script>";
                }
            }
        }

        // Query voor het updaten van de database.
        $stmt = $conn->prepare("UPDATE coureurs SET title = :title, omschrijving = :omschrijving WHERE coureurID = :coureurID");
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':omschrijving', $omschrijving);
        $stmt->bindparam(':coureurID', $coureurID);
        $stmt->execute();

        // Terug naar de banen.php pagina (HEADER werkt niet.)
        echo
        "<script>
        setTimeout(function(){
            window.location.href='../paginas/coureurs.php';
         }, 2500);
        </script>";
    }
}
// *********************************************************************** //
// kijkt of er een courer is geliked

function checkFavCoureur($conn, $coureurID)
{
    // Query voor het ophalen van de gegevens waar de gebruikersID en coureurID gelijk zijn.
    $stmt = $conn->prepare("SELECT * FROM favorieten WHERE gebruikersID = :id AND coureurID = :coureurID");
    $stmt->bindParam(':id', $_SESSION['id']);
    $stmt->bindParam(':coureurID', $coureurID);
    $stmt->execute();
    $banen = $stmt->fetchAll();
    return $banen;

    // Kijkt of er een banen is geef dan true en anders false
    if ($banen->rowCount() > 0) {
        return true;
    } else {
        return false;
    }
}

// *********************************************************************** //
// functie coureurs verwijderen
function verwijdercoureurs($conn, $coureurID)
{
    try {
        // Query voor het ophalen van de gegevens.
        $stmt1 = $conn->prepare("SELECT afbeelding FROM coureurs WHERE coureurID = :coureurID");
        $stmt1->bindParam(':coureurID', $coureurID);
        $stmt1->execute();

        // Fetch de result naar een associative array.
        $result = $stmt1->fetch(PDO::FETCH_ASSOC);

        // Verwijder de afbeelding uit de map van coureurs
        $afbeelding = $result["afbeelding"];
        var_dump($afbeelding);
        unlink("../afbeeldingen/coureurs/$afbeelding");

        // Verwijder de coureur uit de database.
        $stmt = $conn->prepare("DELETE FROM favorieten WHERE coureurID = :coureurID");
        $stmt->bindParam(':coureurID', $coureurID);
        $stmt->execute();

        // Query voor het verwijderen van de gegevens.
        $stmt = $conn->prepare("DELETE FROM coureurs WHERE coureurID = :coureurID");
        $stmt->bindParam(':coureurID', $coureurID);
        $stmt->execute();

        // Als de coureur is verwijderd geef dan een succes message.
        if ($stmt->rowCount() > 0) {
            echo "<script type=\"text/javascript\">toastr.success('Succesvol verwijderd')</script>";
        } else {
            echo "<script type='text/javascript'>toastr.error('Coureur niet gevonden error')</script>";
        }
    } catch (PDOException $e) {
        echo "<script type='text/javascript'>toastr.error('Database error')</script>";
    }
    echo
        "<script>
        setTimeout(function(){
            window.location.href='../paginas/coureurs.php';
         }, 2500);
        </script>";
}

// *********************************************************************** //
// Functie Voor readBanen

function readBanen($conn)
{
    // het voorbereiden van de tabel//
    $stmt = $conn->prepare("SELECT * FROM banen");
    $stmt->execute();


    // het ophalen van de data //
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $banen = $stmt->fetchAll();

    // de opbouw van de placeholder//
    foreach ($banen as $record) {
        echo '<article class="row justify-content-center p-2  w-50 m-auto mt-2 mb-2 bg-dark text-light">
        <img src="../afbeeldingen/banen/' . $record['afbeelding'] . '" alt="logo" class="col-4" style="width: 130px; height: 100px;">
        <div class="p-3 col-8">
            <h2 class="fw-bolder">' . $record['title'] . '</h2>
            <h5 class="text-danger">' . $record['naam'] . '</h5>
            <p class="fw-bold">' . $record['omschrijving'] . '</p>
            <form action="" method="POST">';
        $check = checkFavBanen($conn, $record['banenID']);
        if ($check == true) {
            echo '<input type="hidden" name="banenID" value="' . $record['banenID'] . '">
                <button type="submit" name="favoriet" id="favoriet" class="btn border-none text-light bg-danger"><i class="fa-solid fa-heart"></i></button>';
        } else {
            echo '<input type="hidden" name="banenID" value="' . $record['banenID'] . '">
                <button type="submit" name="favoriet" id="favoriet" class="btn border-none bg-danger"><i class="fa-solid fa-heart"></i></button>';
        }
        echo '</form>
            </div>';

        $banenID = $record['banenID'];
        updateBanen($conn, $banenID);

        echo '</article>';
    }

    favorieten($conn);

    // het terug geven van de data//
    return $banen;
}

// *********************************************************************** //
// toevoegen banen function

function toevoegenBanen($conn)
{
    //als je de knop indrukt kijkt hij of de afbeelding is toegevoegd
    if (isset($_POST['baan_toevoegen'])) {
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["fileNaam"])) {
            //zet variable
            $path_naar_mappenstructuur = "../afbeeldingen/banen/";

            $bestand_naam = str_replace(' ', '_', strtolower($_POST["title"]));

            $afbeelding_type = strtolower(pathinfo($_FILES["fileNaam"]["name"], PATHINFO_EXTENSION));

            $doel_bestand = $path_naar_mappenstructuur . $bestand_naam . '.' . $afbeelding_type;

            $bestand_veilig = 1;

            // kijkt of het bestand al in de database staat
            if (file_exists($doel_bestand)) {
                echo "<script type='text/javascript'>toastr.error('het bestand bestaat al.')</script>";
                $bestand_veilig = 0;
            }

            // kijkt of het bestand niet onnodig groot is
            if ($_FILES["fileNaam"]["size"] > 500000) {
                echo "<script type='text/javascript'>toastr.error('het bestand is te groot.')</script>";
                $bestand_veilig = 0;
            }

            //kijkt of de afbeelding een png bestand is
            if ($afbeelding_type != "png") {
                echo "<script type='text/javascript'>toastr.error('alleen PNG bestanden zijn toegestaan.')</script>";
                $bestand_veilig = 0;
            }

            //kijkt of de afbeelding aan alle kritiria voldoet en zet dan het bestand op de goede plek 
            if ($bestand_veilig == 0) {
                echo "<script type='text/javascript'>toastr.error('het bestand is niet geupload.')</script>";
            } else {
                if (move_uploaded_file($_FILES["fileNaam"]["tmp_name"], $doel_bestand)) {
                    echo "<script type=\"text/javascript\">toastr.success('Succesvol geupload')</script>";
                } else {
                    echo "<script type='text/javascript'>toastr.error('er ging iets fout met het uploaden.')</script>";
                }
            }
        }
        // zet de goede variable en zet deze in de database
        $title = $_POST['title'];
        $naam = $_POST['naamBaan'];
        $omschrijving = $_POST['omschrijving'];
        $afbeelding = $title . ".png";

        $stmtUpdate = $conn->prepare("INSERT INTO banen (title, naam, afbeelding, omschrijving) 
        VALUES (:title, :naam, :afbeelding, :omschrijving)");
        $stmtUpdate->bindParam(':title', $title);
        $stmtUpdate->bindparam(':naam', $naam);
        $stmtUpdate->bindParam(':afbeelding', $afbeelding);
        $stmtUpdate->bindParam(':omschrijving', $omschrijving);
        $stmtUpdate->execute();
    }
}

// *********************************************************************** //
// aanpassen banen functie

function updateBanen($conn, $banenID)
{
    // Kijkt of user [admin] is.
    if (isset($_SESSION["admin"]) && $_SESSION["admin"] == true) {
        echo '<div class="text-center">
        <form method="post">
        <button class="btn btn-lg text-white bg-danger" type="submit" name="wijzig' . $banenID . '">Wijzig baan </button>
        <button class="btn btn-lg text-white bg-danger" type="submit" name="verwijder' . $banenID . '">Verwijder baan</button>
    </form>
    </div>';
        $wijzig = 'wijzig' . $banenID;
        $verwijder = 'verwijder' . $banenID;
        // Kijkt of Verwijderknop is ingedrukt.
        if (isset($_POST[$verwijder])) {
            verwijderbanen($conn, $banenID);
            echo 'Verwijderd uit DataBase';
        }
        // Kijkt of wijzigknop is ingedrukt.
        if (isset($_POST[$wijzig])) {
            $stmt = $conn->prepare("SELECT * FROM banen WHERE banenID = :banenID");
            $stmt->bindParam(':banenID', $banenID);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            // HTML form voor informatie. Gelinkt aan de gegevens uit de database.
            echo '<div class="row justify-content-center bg-dark text-light">
        <form enctype="multipart/form-data" method="post" class="d-flex flex-column justify-content-center w-50">

        <label for="title" class="text-center">Title</label>
        <input type="text" name="title" id="title" name="title" value="' . $result['title'] . '">

        <label for="naam" class="text-center">Omschrijving</label>
        <input type="text" name="naam" id="naam" value="' . $result['naam'] . '">

        <label for="fileNaam" class="text-center">Afbeelding link</label>
        <input type="file" id="fileNaam" name="fileNaam">
        
        <label for="omschrijving" class="text-center">Omschrijving</label>
        <input type="text" name="omschrijving" id="omschrijving" value="' . $result['omschrijving'] . '">

        <input type="submit" name="wijzig_banen' . $banenID . '" value="Wijzig Baan" class="btn btn-lg text-white bg-danger my-3">
    </form> 
    </div>';
        }
    }
    $Wijzig = 'wijzig_banen' . $banenID;
    // Kijkt of wijzigknop is ingedrukt.
    if (isset($_POST[$Wijzig])) {
        $title = $_POST['title'];
        $naam = $_POST['naam'];
        $omschrijving = $_POST['omschrijving'];

        // Kijkt of het bestand is set.
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["fileNaam"])) {
            $title = $_POST['title'];
            $naam = $_POST['naam'];
            $afbeelding = str_replace(' ', '_', strtolower($title)) . ".png";
            $omschrijving = $_POST['omschrijving'];

            // Query voor het ophalen van de gegevens.
            $stmt = $conn->prepare("SELECT * FROM banen WHERE banenID = :banenID");
            $stmt->bindParam(':banenID', $banenID);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            $path_naar_mappenstructuur = "../afbeeldingen/banen/";

            $bestand_naam = str_replace(' ', '_', strtolower($_POST["title"]));

            $afbeelding_type = strtolower(pathinfo($_FILES["fileNaam"]["name"], PATHINFO_EXTENSION));

            $doel_bestand = $path_naar_mappenstructuur . $bestand_naam . '.' . $afbeelding_type;

            $bestand_veilig = 1;

            $afbeelding_bestemming = $result['afbeelding'];

            // Kijkt of de file te groot is.
            if ($_FILES["fileNaam"]["size"] > 500000) {
                echo "<script type='text/javascript'>toastr.error('het bestand is te groot.')</script>";
                $bestand_veilig = 0;
            }

            // Kijkt of file geen PNG bestand is.
            if ($afbeelding_type != "png") {
                echo "<script type='text/javascript'>toastr.error('alleen PNG bestanden zijn toegestaan.')</script>";
                $bestand_veilig = 0;
            }

            // Kijkt of er een bestand geupload is.
            if ($bestand_veilig == 0) {
                echo " <script type='text/javascript'>toastr.error(' het bestand is niet geupload.')</script>";
            } else {
                if (move_uploaded_file($_FILES["fileNaam"]["tmp_name"], $doel_bestand)) {
                    unlink("../afbeeldingen/banen/$afbeelding_bestemming");
                    echo "<script type=\"text/javascript\">toastr.success('Succesvol geupload')</script>";
                    // Query voor het updaten van de gegevens.
                    $stmt = $conn->prepare("UPDATE banen SET title = :title, naam = :naam , afbeelding = :afbeelding, omschrijving = :omschrijving WHERE banenID = :banenID");
                    $stmt->bindParam(':title', $title);
                    $stmt->bindParam(':naam', $naam);
                    $stmt->bindParam(':afbeelding', $afbeelding);
                    $stmt->bindParam(':omschrijving', $omschrijving);
                    $stmt->bindparam(':banenID', $banenID);
                    $stmt->execute();
                } else {
                    echo "<script type='text/javascript'>toastr.error('er ging iets fout met het uploaden.')</script>";
                }
            }
        }

        // Query voor het updaten van de gegevens.
        $stmt = $conn->prepare("UPDATE banen SET title = :title, naam = :naam, omschrijving = :omschrijving WHERE banenID = :banenID");
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':naam', $naam);
        $stmt->bindParam(':omschrijving', $omschrijving);
        $stmt->bindparam(':banenID', $banenID);
        $stmt->execute();

        // Terug naar de banen.php pagina (HEADER werkt niet.)
        echo "<script>
        setTimeout(function(){
            window.location.href='../paginas/banen.php';
         }, 2500);
        </script>";
    }
}

// *********************************************************************** //
// funtie om te kijken of banen al geliked

function checkFavBanen($conn, $banenID)
{
    // Query voor het ophalen van de gegevens waar de gebruikersID en banenID gelijk zijn.
    $stmt = $conn->prepare("SELECT * FROM favorieten WHERE gebruikersID = :id AND banenID = :banenID");
    $stmt->bindParam(':id', $_SESSION['id']);
    $stmt->bindParam(':banenID', $banenID);
    $stmt->execute();
    $banen = $stmt->fetchAll();
    return $banen;

    // Kijkt of er een banen is geef dan true en anders false
    if ($banen->rowCount() > 0) {
        return true;
    } else {
        return false;
    }
}

// *********************************************************************** //
// functie banen verwijderen

function verwijderbanen($conn, $banenID)
{
    try {
        // Query voor het ophalen van de gegevens waar de gebruikersID en banenID gelijk zijn.
        $stmt1 = $conn->prepare("SELECT afbeelding FROM banen WHERE banenID = :banenID");
        $stmt1->bindParam(':banenID', $banenID);
        $stmt1->execute();

        // Fetch de result naar een associative array.
        $result = $stmt1->fetch(PDO::FETCH_ASSOC);

        // Verwijder de afbeelding uit de map van banen
        $afbeelding = $result["afbeelding"];
        unlink("../afbeeldingen/banen/$afbeelding");

        // Verwijder de banen uit de database.
        $stmt = $conn->prepare("DELETE FROM favorieten WHERE banenID = :banenID");
        $stmt->bindParam(':banenID', $banenID);
        $stmt->execute();

        $stmt = $conn->prepare("DELETE FROM banen WHERE banenID = :banenID");
        $stmt->bindParam(':banenID', $banenID);
        $stmt->execute();

        // Als de baan is verwijderd geef dan een succes message.
        if ($stmt->rowCount() > 0) {
            echo "<script type=\"text/javascript\">toastr.success('Succesvol verwijderd')</script>";
        } else {
            echo "<script type='text/javascript'>toastr.error('baan niet gevonden error')</script>";
        }
    } catch (PDOException $e) {
        echo "<script type='text/javascript'>toastr.error('Database error')</script>";
    }
    echo
    "<script>
    setTimeout(function(){
        window.location.href='../paginas/banen.php';
     }, 2500);
    </script>";
}

// *********************************************************************** //
// Functie Voor readTeams

function readTeams($conn)
{
    // het voorbereiden van de tabel//
    $stmt = $conn->prepare("SELECT * FROM teams");
    $stmt->execute();

    // het ophalen van de data //
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $teams = $stmt->fetchAll();

    // de opbouw van de placeholder//
    foreach ($teams as $record) {
        echo '<section class="row justify-content-center p-2  w-50 m-auto mt-2 mb-2 bg-dark text-light">
        <img src="../afbeeldingen/teams/' . $record['afbeelding'] . '" alt="logo" class="col-3 rounded" style="width: 130px; height: 100px;">
        <div class="p-3 col-9">
            <h2>' . $record['title'] . '</h2>
            <p>' . $record['omschrijving'] . '</p>
            <form action="" method="POST">';
        $check = checkFavTeams($conn, $record['teamID']);
        if ($check == true) {
            echo '<input type="hidden" name="teamsID" value="' . $record['teamID'] . '">
                <button type="submit" name="favoriet" id="favoriet" class="btn border-none text-light bg-danger"><i class="fa-solid fa-heart"></i></button>';
        } else {
            echo '<input type="hidden" name="teamsID" value="' . $record['teamID'] . '">
                <button type="submit" name="favoriet" id="favoriet" class="btn border-none bg-danger"><i class="fa-solid fa-heart"></i></button>';
        }
        echo '</form>
        </div>';

        $teamsID = $record['teamID'];
        updateTeams($conn, $teamsID);

        echo '</section>';
    }
    favorieten($conn);

    return $teams;
}

// *********************************************************************** //
// teams toevoegen function

function toevoegenTeams($conn)
{
    //als je de knop indrukt kijkt hij of de afbeelding is toegevoegd
    if (isset($_POST['voeg_teams_toe'])) {
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["fileNaam"])) {
            //zet variable
            $path_naar_mappenstructuur = "../afbeeldingen/teams/";

            $bestand_naam = str_replace(' ', '_', strtolower($_POST["title"]));

            $afbeelding_type = strtolower(pathinfo($_FILES["fileNaam"]["name"], PATHINFO_EXTENSION));

            $doel_bestand = $path_naar_mappenstructuur . $bestand_naam . '.' . $afbeelding_type;

            $bestand_veilig = 1;

            // kijkt of het bestand al in de database staat
            if (file_exists($doel_bestand)) {
                echo "<script type='text/javascript'>toastr.error('het bestand bestaat al.')</script>";
                $bestand_veilig = 0;
            }

            // kijkt of het bestand niet onnodig groot is
            if ($_FILES["fileNaam"]["size"] > 500000) {
                echo "<script type='text/javascript'>toastr.error('het bestand is te groot.')</script>";
                $bestand_veilig = 0;
            }

            //kijkt of de afbeelding een png bestand is
            if ($afbeelding_type != "png") {
                echo "<script type='text/javascript'>toastr.error('alleen PNG bestanden zijn toegestaan.')</script>";
                $bestand_veilig = 0;
            }

            //kijkt of de afbeelding aan alle kritiria voldoet en zet dan het bestand op de goede plek 
            if ($bestand_veilig == 0) {
                echo "<script type='text/javascript'>toastr.error(' het bestand is niet geupload.')</script>";
            } else {
                if (move_uploaded_file($_FILES["fileNaam"]["tmp_name"], $doel_bestand)) {
                    echo "<script type=\"text/javascript\">toastr.success('Succesvol geupload')</script>";
                } else {
                    echo "<script type='text/javascript'>toastr.error('er ging iets fout met het uploaden.')</script>";
                }
            }
        }
        // zet de goede variable en zet deze in de database
        $title = $_POST['title'];
        $omschrijving = $_POST['omschrijving'];
        $afbeelding = $title . ".png";

        $stmtUpdate = $conn->prepare("INSERT INTO teams (title, afbeelding, omschrijving) 
            VALUES (:title, :afbeelding, :omschrijving)");
        $stmtUpdate->bindParam(':title', $title);
        $stmtUpdate->bindParam(':afbeelding', $afbeelding);
        $stmtUpdate->bindParam(':omschrijving', $omschrijving);
        $stmtUpdate->execute();
    }
}

// *********************************************************************** //
// functie teams updaten

function updateTeams($conn, $teamsID)
{
    // Kijkt of user [admin] is.
    if (isset($_SESSION["admin"]) && $_SESSION["admin"] == true) {
        echo '<div class="text-center">
        <form method="post">
        <button class="btn btn-lg text-white bg-danger" type="submit" name="wijzig' . $teamsID . '">Wijzig Team </button>
        <button class="btn btn-lg text-white bg-danger" type="submit" name="verwijder' . $teamsID . '">Verwijder Team</button>
    </form>
    </div>';
        $wijzig = 'wijzig' . $teamsID;
        $verwijder = 'verwijder' . $teamsID;
        // Kijkt of Verwijderknop is ingedrukt.
        if (isset($_POST[$verwijder])) {
            verwijderteams($conn, $teamsID);
            echo 'Verwijderd uit DataBase';
        }
        // Kijkt of wijzigknop is ingedrukt.
        if (isset($_POST[$wijzig])) {
            $stmt = $conn->prepare("SELECT * FROM teams WHERE teamID = :teamID");
            $stmt->bindParam(':teamID', $teamsID);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            // HTML form voor informatie. Gelikt aan de gegevens uit de database.
            echo '<div class="row justify-content-center bg-dark text-light">
        <form enctype="multipart/form-data" method="post" class="d-flex flex-column justify-content-center w-50">

        <label for="title" class="text-center">Title</label>
        <input type="text" name="title" id="title" name="title" value="' . $result['title'] . '">

        <label for="fileNaam" class="text-center">Afbeelding link</label>
        <input type="file" id="fileNaam" name="fileNaam">
        
        <label for="omschrijving" class="text-center">Omschrijving</label>
        <input type="text" name="omschrijving" id="omschrijving" value="' . $result['omschrijving'] . '">

        <input type="submit" name="wijzig_team' . $teamsID . '" value="Wijzig Team" class="btn btn-lg text-white bg-danger my-3">
    </form> 
    </div>';
        }
    }
    $Wijzig = 'wijzig_team' . $teamsID;
    // Kijkt of wijzigknop is ingedrukt.
    if (isset($_POST[$Wijzig])) {
        $title = $_POST['title'];
        $omschrijving = $_POST['omschrijving'];

        // Kijkt of het bestand is set.
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["fileNaam"])) {
            $title = $_POST['title'];
            $afbeelding = str_replace(' ', '_', strtolower($title)) . ".png";
            $omschrijving = $_POST['omschrijving'];

            // Query voor het ophalen van de gegevens.
            $stmt = $conn->prepare("SELECT * FROM teams WHERE teamID = :teamID");
            $stmt->bindParam(':teamID', $teamsID);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            $path_naar_mappenstructuur = "../afbeeldingen/teams/";

            $bestand_naam = str_replace(' ', '_', strtolower($_POST["title"]));

            $afbeelding_type = strtolower(pathinfo($_FILES["fileNaam"]["name"], PATHINFO_EXTENSION));

            $doel_bestand = $path_naar_mappenstructuur . $bestand_naam . '.' . $afbeelding_type;

            $bestand_veilig = 1;

            $afbeelding_bestemming = $result['afbeelding'];

            // Kijkt of het bestand te groot is.
            if ($_FILES["fileNaam"]["size"] > 500000) {
                echo "<script type='text/javascript'>toastr.error('het bestand is te groot.')</script>";
                $bestand_veilig = 0;
            }

            // Kijkt of het een PNG bestand is.
            if ($afbeelding_type != "png") {
                echo "<script type='text/javascript'>toastr.error('alleen PNG bestanden zijn toegestaan.')</script>";
                $bestand_veilig = 0;
            }

            // Kijkt of er een bestand geupload is.
            if ($bestand_veilig == 0) {
                echo " <script type='text/javascript'>toastr.error(' het bestand is niet geupload.')</script>";
            } else {
                if (move_uploaded_file($_FILES["fileNaam"]["tmp_name"], $doel_bestand)) {
                    unlink("../afbeeldingen/teams/$afbeelding_bestemming");
                    echo "<script type=\"text/javascript\">toastr.success('Succesvol geupload')</script>";
                    // Query voor het updaten van de gegevens voor afbeelding.
                    $stmt = $conn->prepare("UPDATE teams SET title = :title, afbeelding = :afbeelding, omschrijving = :omschrijving WHERE teamID = :teamID");
                    $stmt->bindParam(':title', $title);
                    $stmt->bindParam(':afbeelding', $afbeelding);
                    $stmt->bindParam(':omschrijving', $omschrijving);
                    $stmt->bindparam(':teamID', $teamsID);
                    $stmt->execute();
                } else {
                    echo "<script type='text/javascript'>toastr.error('er ging iets fout met het uploaden.')</script>";
                }
            }
        }

        // Query voor het updaten van de gegevens
        $stmt = $conn->prepare("UPDATE teams SET title = :title, omschrijving = :omschrijving WHERE teamID = :teamID");
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':omschrijving', $omschrijving);
        $stmt->bindparam(':teamID', $teamsID);
        $stmt->execute();

        // Terug naar de banen.php pagina (HEADER werkt niet.)
        echo "<script>
        setTimeout(function(){
            window.location.href='../paginas/teams.php';
         }, 2500);
        </script>";
    }
}

// *********************************************************************** //
// kijkt of er een team geliked
function checkFavTeams($conn, $teamID)
{
    // Query voor het ophalen van de gegevens.
    $stmt = $conn->prepare("SELECT * FROM favorieten WHERE gebruikersID = :id AND teamID = :teamID");
    $stmt->bindParam(':id', $_SESSION['id']);
    $stmt->bindParam(':teamID', $teamID);
    $stmt->execute();
    $banen = $stmt->fetchAll();
    return $banen;

    // Kijkt of er een banen is geef dan true en anders false
    if ($banen->rowCount() > 0) {
        return true;
    } else {
        return false;
    }
}

// *********************************************************************** //
// functie teams verwijderen

function verwijderteams($conn, $teamID)
{
    try {
        // Query voor het verwijderen van de gegevens.
        $stmt1 = $conn->prepare("SELECT afbeelding FROM teams WHERE teamID = :teamID");
        $stmt1->bindParam(':teamID', $teamID);
        $stmt1->execute();

        $result = $stmt1->fetch(PDO::FETCH_ASSOC);

        $afbeelding = $result["afbeelding"];
        unlink("../afbeeldingen/teams/$afbeelding");

        $stmt = $conn->prepare("DELETE FROM favorieten WHERE teamID = :teamID");
        $stmt->bindParam(':teamID', $teamID);
        $stmt->execute();

        $stmt = $conn->prepare("DELETE FROM teams WHERE teamID = :teamID");
        $stmt->bindParam(':teamID', $teamID);
        $stmt->execute();

        // Als de team is verwijderd geef dan een succes message.
        if ($stmt->rowCount() > 0) {
            echo "<script type=\"text/javascript\">toastr.success('Succesvol verwijderd')</script>";
        } else {
            echo "<script type='text/javascript'>toastr.error('team niet gevonden error')</script>";
        }
    } catch (PDOException $e) {
        echo "<script type='text/javascript'>toastr.error('Database error')</script>";
    }
    echo
    "<script>
    setTimeout(function(){
        window.location.href='../paginas/teams.php';
     }, 2500);
    </script>";
}

// *********************************************************************** //
// Functie Voor readOverOns

function readOverOns($conn)
{
    // het voorbereiden van de tabel //
    $stmt = $conn->prepare("SELECT * FROM overons");
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $overons = $stmt->fetchAll();

    // de opbouw van de placeholder //
    foreach ($overons as $record) {
        echo '<section class="row justify-content-center p-2 w-50 m-auto mt-2 mb-2 bg-dark text-light">
        <img src="../afbeeldingen/over_ons/' . $record['afbeelding'] . '" alt="logo" class="col-3 rounded" style="width: 130px; height: 100px;">
        <div class="p-3 col-9">
            <h2>' . $record['naam'] . '</h2>
            <p>' . $record['omschrijving'] . '</p>
            <div>
                <button class="bg-danger rounded p-0 text-light" onclick= >Mijn favorieten coureur is: ' . $record['favCoureur'] . '</button>
            </div>

        </div>';

        $overOnsID = $record['overOnsID'];
        updateOverOns($conn, $overOnsID);

        echo '</section>';
    }

    // return $overons; //
    return $overons;
}


// *********************************************************************** //
// voegd een extra lid aan bij over ons functie

function toevoegenOverOns($conn)
{
    //als je de knop indrukt kijkt hij of de afbeelding is toegevoegd
    if (isset($_POST['voeg_developer_toe'])) {
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["fileNaam"])) {
            //zet variable
            $path_naar_mappenstructuur = "../afbeeldingen/over_ons/";

            $bestand_naam = str_replace(' ', '_', strtolower($_POST["naam"]));

            $afbeelding_type = strtolower(pathinfo($_FILES["fileNaam"]["name"], PATHINFO_EXTENSION));

            $doel_bestand = $path_naar_mappenstructuur . $bestand_naam . '.' . $afbeelding_type;

            $bestand_veilig = 1;

            // kijkt of het bestand al in de database staat
            if (file_exists($doel_bestand)) {
                echo "<script type='text/javascript'>toastr.error('het bestand bestaat al')</script>";
                $bestand_veilig = 0;
            }

            // kijkt of het bestand niet onnodig groot is 
            if ($_FILES["fileNaam"]["size"] > 500000) {
                echo "<script type='text/javascript'>toastr.error('het bestand is te groot.')</script>";
                $bestand_veilig = 0;
            }

            //kijkt of de afbeelding een png bestand is
            if ($afbeelding_type != "png") {
                echo "<script type='text/javascript'>toastr.error('alleen PNG bestanden zijn toegestaan.')</script>";
                $bestand_veilig = 0;
            }

            //kijkt of de afbeelding aan alle kritiria voldoet en zet dan het bestand op de goede plek 
            if ($bestand_veilig == 0) {
                echo " <script type='text/javascript'>toastr.error(' het bestand is niet geupload.')</script>";
            } else {
                if (move_uploaded_file($_FILES["fileNaam"]["tmp_name"], $doel_bestand)) {
                    echo "<script type=\"text/javascript\">toastr.success('Succesvol geupload')</script>";
                } else {
                    echo "<script type='text/javascript'>toastr.error('er ging iets fout met het uploaden.')</script>";
                }
            }
        }
        // zet de goede variable en zet deze in de database
        $naam = $_POST['naam'];
        $omschrijving = $_POST['omschrijving'];
        $favCoureur = $_POST['favCoureur'];
        $afbeelding = $naam . ".png";

        $stmtUpdate = $conn->prepare("INSERT INTO overons (naam, afbeelding, omschrijving, favCoureur) 
            VALUES (:naam, :afbeelding, :omschrijving, :favCoureur)");
        $stmtUpdate->bindParam(':naam', $naam);
        $stmtUpdate->bindParam(':afbeelding', $afbeelding);
        $stmtUpdate->bindParam(':omschrijving', $omschrijving);
        $stmtUpdate->bindParam(':favCoureur', $favCoureur);
        $stmtUpdate->execute();
    }
}


// *********************************************************************** //
// Functie Voor updateOverOns

function updateOverOns($conn, $overOnsID)
{
    // Kijkt of user [admin] is.
    if (isset($_SESSION["admin"]) && $_SESSION["admin"] == true) {
        echo '<div class="text-center">
        <form method="post">
        <button class="btn btn-lg text-white bg-danger" type="submit" name="wijzig' . $overOnsID . '">Wijzig Developer </button>
        <button class="btn btn-lg text-white bg-danger" type="submit" name="verwijder' . $overOnsID . '">Verwijder Developer</button>
    </form>
    </div>';
        $wijzig = 'wijzig' . $overOnsID;
        $verwijder = 'verwijder' . $overOnsID;
        // Kijkt of verwijderknop is ingedrukt.
        if (isset($_POST[$verwijder])) {
            verwijderenOverOns($conn, $overOnsID);
            echo 'Verwijderd uit DataBase';
        }
        // Kijkt of wijzigknop is ingedrukt.
        if (isset($_POST[$wijzig])) {
            $stmt = $conn->prepare("SELECT * FROM overons WHERE overOnsID = :overOnsID");
            $stmt->bindParam(':overOnsID', $overOnsID);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            // HTML form voor informatie. Gelikt aan de gegevens uit de database.
            echo '<div class="row justify-content-center bg-dark text-light">
        <form enctype="multipart/form-data" method="post" class="d-flex flex-column justify-content-center w-50">

        <label for="naam" class="text-center">Naam</label>
        <input type="text" name="naam" id="naam" name="naam" value="' . $result['naam'] . '">

        <label for="fileNaam" class="text-center">Afbeelding link</label>
        <input type="file" id="fileNaam" name="fileNaam">
        

        <label for="omschrijving" class="text-center">Omschrijving</label>
        <input type="text" name="omschrijving" id="omschrijving" value="' . $result['omschrijving'] . '">

        <label for="favCoureur" class="text-center">Favoriet Coureur</label>
        <input type="text" name="favCoureur" id="favCoureur" value="' . $result['favCoureur'] . '">

        <input type="submit" name="wijzig_overons' . $overOnsID . '" value="Wijzig overOns" class="btn btn-lg text-white bg-danger my-3">
    </form> 
    </div>';
        }
    }
    $Wijzig = 'wijzig_overons' . $overOnsID;
    // Kijkt of Wijzigknop is ingedrukt.
    if (isset($_POST[$Wijzig])) {
        $naam = $_POST['naam'];
        $omschrijving = $_POST['omschrijving'];
        $favCoureur = $_POST['favCoureur'];

        // Kijkt of het bestand is set.
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["fileNaam"])) {
            $naam = $_POST['naam'];
            $afbeelding = str_replace(' ', '_', strtolower($naam)) . ".png";
            $omschrijving = $_POST['omschrijving'];
            $favCoureur = $_POST['favCoureur'];

            // Query voor het ophalen van informatie.
            $stmt = $conn->prepare("SELECT * FROM overons WHERE overOnsID = :overOnsID");
            $stmt->bindParam(':overOnsID', $overOnsID);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            $path_naar_mappenstructuur = "../afbeeldingen/over_ons/";

            $bestand_naam = str_replace(' ', '_', strtolower($_POST["naam"]));

            $afbeelding_type = strtolower(pathinfo($_FILES["fileNaam"]["name"], PATHINFO_EXTENSION));

            $doel_bestand = $path_naar_mappenstructuur . $bestand_naam . '.' . $afbeelding_type;

            $bestand_veilig = 1;

            $afbeelding_bestemming = $result['afbeelding'];


            // Kijkt of het bestand al bestaat.
            if (file_exists($doel_bestand)) {
                echo "<script type='text/javascript'>toastr.error('het bestand bestaat al')</script>";
                $bestand_veilig = 0;
            }

            // Kijkt of het bestand te groot is.
            if ($_FILES["fileNaam"]["size"] > 500000) {
                echo "<script type='text/javascript'>toastr.error('het bestand is te groot.')</script>";
                $bestand_veilig = 0;
            }

            // Kijkt of het bestand een PNG bestand is.
            if ($afbeelding_type != "png") {
                echo "<script type='text/javascript'>toastr.error('alleen PNG bestanden zijn toegestaan.')</script>";
                $bestand_veilig = 0;
            }

            // Kijkt of het bestand geupload is.
            if ($bestand_veilig == 0) {
                echo " <script type='text/javascript'>toastr.error(' het bestand is niet geupload.')</script>";
            } else {
                if (move_uploaded_file($_FILES["fileNaam"]["tmp_name"], $doel_bestand)) {
                    unlink("../afbeeldingen/over_ons/$afbeelding_bestemming");
                    echo "<script type=\"text/javascript\">toastr.success('Succesvol geupload')</script>";
                    // Query voor het updaten van de database met afbeelding.
                    $stmt = $conn->prepare("UPDATE overons SET naam = :naam, afbeelding = :afbeelding, omschrijving = :omschrijving, favCoureur = :favCoureur WHERE overOnsID = :overOnsID");
                    $stmt->bindParam(':naam', $naam);
                    $stmt->bindParam(':afbeelding', $afbeelding);
                    $stmt->bindParam(':omschrijving', $omschrijving);
                    $stmt->bindParam(':favCoureur', $favCoureur);
                    $stmt->bindparam(':overOnsID', $overOnsID);
                    $stmt->execute();
                } else {
                    echo "<script type='text/javascript'>toastr.error('er ging iets fout met het uploaden.')</script>";
                }
            }
        }

        // Query voor het updaten van de database.
        $stmt = $conn->prepare("UPDATE overons SET naam = :naam, omschrijving = :omschrijving, favCoureur = :favCoureur WHERE overOnsID = :overOnsID");
        $stmt->bindParam(':naam', $naam);
        $stmt->bindParam(':omschrijving', $omschrijving);
        $stmt->bindparam(':overOnsID', $overOnsID);
        $stmt->bindParam(':favCoureur', $favCoureur);
        $stmt->execute();

        // Terug naar de banen.php pagina (HEADER werkt niet.)
        echo
        "<script>
        setTimeout(function(){
            window.location.href='../paginas/overons.php';
         }, 2500);
        </script>";
    }
}

// *********************************************************************** //
// functie verwijder over ons

function verwijderenOverOns($conn, $overOnsID)
{
    try {
        // Query voor het ophalen van de gegevens.
        $stmt1 = $conn->prepare("SELECT afbeelding FROM overons WHERE overOnsID = :overOnsID");
        $stmt1->bindParam(':overOnsID', $overOnsID);
        $stmt1->execute();

        // Kijkt of er een banen is geef dan true en anders false
        $result = $stmt1->fetch(PDO::FETCH_ASSOC);

        // Verwijder de afbeelding uit de map van banen
        $afbeelding = $result["afbeelding"];
        unlink("../afbeeldingen/over_ons/$afbeelding");

        // Query voor het verwijderen van de gegevens.
        $stmt = $conn->prepare("DELETE FROM overons WHERE overOnsID = :overOnsID");
        $stmt->bindParam(':overOnsID', $overOnsID);
        $stmt->execute();

        // Als de overons is verwijderd geef dan een succes message.
        if ($stmt->rowCount() > 0) {
            echo "<script type=\"text/javascript\">toastr.success('Succesvol verwijderd')</script>";
        } else {
            echo "<script type='text/javascript'>toastr.error('Over ons niet gevonden error')</script>";
        }
    } catch (PDOException $e) {
        echo "<script type='text/javascript'>toastr.error('Database error')</script>";
    }
    echo "<script>window.location.href='../paginas/overons.php';</script>";
}

// *********************************************************************** //
// functie read/update users voor admin panel

function readGebruikersAdmin($conn)
{
    try {
        // Query voor het ophalen van de gegevens.
        $stmt = $conn->prepare("SELECT gebruikersnaam, admin FROM gebruikers");
        $stmt->execute();

        // Fetch de result naar een associative array.
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $users = $stmt->fetchAll();
        
        // html form
        echo "<div class='justify-content-center'>";
        echo "<form method='post'>";

        foreach ($users as $user) {
            $gebruikersnaam = $user['gebruikersnaam'];
            $admin = $user['admin'];

            echo "<input class ='' type='hidden' name='gebruikersnaam' value='$gebruikersnaam'>";
            echo "<input type='hidden' name='orig_admin' value='$admin'>";
            echo "@$gebruikersnaam | Admin: ";
            echo "<select name='admin'>";
            echo "<option value='0' " . ($admin == 0 ? 'selected' : '') . ">Nee</option>";
            echo "<option value='1' " . ($admin == 1 ? 'selected' : '') . ">Ja</option>";
            echo "</select>";
            echo "<button type='submit' name='verander'>Verander</button><br>";
        }

        
        echo "</form>";
        echo "</div>";


        // Kijkt of de verander knop is ingedrukt
        if (isset($_POST['verander'])) {
            $gebruikersnaam = $_POST['gebruikersnaam'];
            $admin = $_POST['admin'];
            $orig_admin = $_POST['orig_admin'];

            // Als de admin is veranderd voer dan de volgende query uit
            if ($admin != $orig_admin) {
                try {
                    // Query voor het updaten van de gegevens.
                    $stmt = $conn->prepare("UPDATE gebruikers SET admin = :admin WHERE gebruikersnaam = :gebruikersnaam");
                    $stmt->bindParam(':admin', $admin);
                    $stmt->bindParam(':gebruikersnaam', $gebruikersnaam);
                    $stmt->execute();
                    echo "<script type=\"text/javascript\">toastr.success('Succesvol geupdated')</script>";
                } catch (PDOException $e) {
                    echo $e->getMessage();
                }

                echo
                "<script>
                setTimeout(function(){
                    window.location.href='../paginas/admin.php';
                }, 2500);
                </script>";
            } else {
                echo "<script type=\"text/javascript\">toastr.info('Geen wijzigingen om op te slaan')</script>";
            }
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}