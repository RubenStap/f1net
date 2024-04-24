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
                <main class="container-fluid">
                    <section class="row">
                        <div class="row justify-content-md-center">
                            <div class="bg-white p-4 rounded shadow-sm">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="text-center mb-5">
                                            <!-- Logo -->
                                            <a href="#!">
                                                <img src="../afbeeldingen/logo/F1NET logo.png" alt="BootstrapBrain Logo" style=" width: 300px; height: 200px">
                                            </a>
                                            <h1 class="my-3">Registreer</h1>
                                        </div>
                                    </div>
                                </div>
                                <!-- Registration Form -->
                                <form action="registreer.php" method="post">
                                    <div class="row gy-3 gy-md-4 overflow-hidden justify-content-md-center">
                                        <div class="col-8">
                                            <!-- Username Input -->
                                            <label for="gebruiker" class="form-label">Gebruikersnaam <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <span class="input-group-text">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person" viewBox="0 0 16 16">
                                                        <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z" />
                                                    </svg>
                                                </span>
                                                <input type="gebruiker" class="form-control" name="gebruiker" id="gebruiker" required>
                                            </div>
                                        </div>
                                        <div class="col-8">
                                            <!-- Email Input -->
                                            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <span class="input-group-text">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-envelope" viewBox="0 0 16 16">
                                                        <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4Zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1H2Zm13 2.383-4.708 2.825L15 11.105V5.383Zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741ZM1 11.105l4.708-2.897L1 5.383v5.722Z" />
                                                    </svg>
                                                </span>
                                                <input type="email" class="form-control" name="email" id="email" required>
                                            </div>
                                        </div>
                                        <div class="col-8">
                                            <!-- Password Input -->
                                            <label for="wachtwoord" class="form-label">Wachtwoord (1 Hoofdletter, 1 Cijfer, 1 Speciaal teken, min. 8 tekens) <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <span class="input-group-text">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-key" viewBox="0 0 16 16">
                                                        <path d="M0 8a4 4 0 0 1 7.465-2H14a.5.5 0 0 1 .354.146l1.5 1.5a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0L13 9.207l-.646.647a.5.5 0 0 1-.708 0L11 9.207l-.646.647a.5.5 0 0 1-.708 0L9 9.207l-.646.647A.5.5 0 0 1 8 10h-.535A4 4 0 0 1 0 8zm4-3a3 3 0 1 0 2.712 4.285A.5.5 0 0 1 7.163 9h.63l.853-.854a.5.5 0 0 1 .708 0l.646.647.646-.647a.5.5 0 0 1 .708 0l.646.647.646-.647a.5.5 0 0 1 .708 0l.646.647.793-.793-1-1h-6.63a.5.5 0 0 1-.451-.285A3 3 0 0 0 4 5z" />
                                                        <path d="M4 8a1 1 0 1 1-2 0 1 1 0 0 1 2 0z" />
                                                    </svg>
                                                </span>
                                                <input type="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" class="form-control" name="ww" id="ww" value="" required>
                                            </div>
                                        </div>
                                        
                                        <div class="col-8">
                                            <!-- Password 2 Input -->
                                            <label for="wachtwoord" class="form-label">Herhaal Wachtwoord <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <span class="input-group-text">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-key" viewBox="0 0 16 16">
                                                        <path d="M0 8a4 4 0 0 1 7.465-2H14a.5.5 0 0 1 .354.146l1.5 1.5a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0L13 9.207l-.646.647a.5.5 0 0 1-.708 0L11 9.207l-.646.647a.5.5 0 0 1-.708 0L9 9.207l-.646.647A.5.5 0 0 1 8 10h-.535A4 4 0 0 1 0 8zm4-3a3 3 0 1 0 2.712 4.285A.5.5 0 0 1 7.163 9h.63l.853-.854a.5.5 0 0 1 .708 0l.646.647.646-.647a.5.5 0 0 1 .708 0l.646.647.646-.647a.5.5 0 0 1 .708 0l.646.647.793-.793-1-1h-6.63a.5.5 0 0 1-.451-.285A3 3 0 0 0 4 5z" />
                                                        <path d="M4 8a1 1 0 1 1-2 0 1 1 0 0 1 2 0z" />
                                                    </svg>
                                                </span>
                                                <input type="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" class="form-control" name="ww2" id="ww2" value="" required>
                                            </div>
                                        </div>
                                        <div class="col-5">
                                            <!-- Submit Button -->
                                            <div class="d-grid">
                                            <button class="btn btn-lg text-white bg-danger" type="submit" name="submit">Maak account</button>
                                                <?php

                                                registreer($conn);

                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
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
