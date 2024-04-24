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
                        <div class="justify-content-md-center">
                            <div class="row">
                                <div class="col-12 my-3">
                                    <div class="text-center mb-5">
                                        <a href="#!">
                                            <img src="../afbeeldingen/logo/F1NET logo.png" alt="BootstrapBrain Logo" width="300" height="200">
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <!-- Reset Password Form -->
                            <form method="post">
                                <div class="row gy-3 gy-md-4 justify-content-md-center">
                                    <div class="col-7">
                                        <!-- Email Input -->
                                        <label for="gebruikersnaam" class="form-label">Gebruikersnaam <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-envelope" viewBox="0 0 16 16">
                                                    <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4Zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1H2Zm13 2.383-4.708 2.825L15 11.105V5.383Zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741ZM1 11.105l4.708-2.897L1 5.383v5.722Z" />
                                                </svg>
                                            </span>
                                            <input type="text" class="form-control" name="gebruikersnaam" id="gebruikersnaam" required>
                                        </div>
                                    </div>
                                    <div class="col-7">
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
                                    <div class="col-7">
                                        <!-- New Password Input -->
                                        <label for="password" class="form-label">Nieuw wachtwoord (1 Hoofdletter, 1 Cijfer, 1 Speciaal teken, min. 8 tekens) <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-key" viewBox="0 0 16 16">
                                                    <path d="M0 8a4 4 0 0 1 7.465-2H14a.5.5 0 0 1 .354.146l1.5 1.5a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0L13 9.207l-.646.647a.5.5 0 0 1-.708 0L11 9.207l-.646.647a.5.5 0 0 1-.708 0L9 9.207l-.646.647A.5.5 0 0 1 8 10h-.535A4 4 0 0 1 0 8zm4-3a3 3 0 1 0 2.712 4.285A.5.5 0 0 1 7.163 9h.63l.853-.854a.5.5 0 0 1 .708 0l.646.647.646-.647a.5.5 0 0 1 .708 0l.646.647.646-.647a.5.5 0 0 1 .708 0l.646.647.793-.793-1-1h-6.63a.5.5 0 0 1-.451-.285A3 3 0 0 0 4 5z" />
                                                    <path d="M4 8a1 1 0 1 1-2 0 1 1 0 0 1 2 0z" />
                                                </svg>
                                            </span>
                                            <input type="password" class="form-control" name="nieuw-wachtwoord" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" id="nieuw-wachtwoord" value="" required>
                                        </div>
                                    </div>
                                    <div class="col-7">
                                        <!-- Confirm New Password Input -->
                                        <label for="password2" class="form-label">Herhaal nieuw wachtwoord <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-key" viewBox="0 0 16 16">
                                                    <path d="M0 8a4 4 0 0 1 7.465-2H14a.5.5 0 0 1 .354.146l1.5 1.5a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0L13 9.207l-.646.647a.5.5 0 0 1-.708 0L11 9.207l-.646.647a.5.5 0 0 1-.708 0L9 9.207l-.646.647A.5.5 0 0 1 8 10h-.535A4 4 0 0 1 0 8zm4-3a3 3 0 1 0 2.712 4.285A.5.5 0 0 1 7.163 9h.63l.853-.854a.5.5 0 0 1 .708 0l.646.647.646-.647a.5.5 0 0 1 .708 0l.646.647.646-.647a.5.5 0 0 1 .708 0l.646.647.793-.793-1-1h-6.63a.5.5 0 0 1-.451-.285A3 3 0 0 0 4 5z" />
                                                    <path d="M4 8a1 1 0 1 1-2 0 1 1 0 0 1 2 0z" />
                                                </svg>
                                            </span>
                                            <input type="password" class="form-control" name="herhaal-nieuw-wachtwoord" id="herhaal-nieuw-wachtwoord" value="" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" required>
                                        </div>
                                    </div>
                                    <div class="col-7 pb-3">
                                        <!-- Submit Button -->
                                        <div class="d-grid">
                                            <button class="btn btn-lg text-white bg-danger" type="submit" name="submit">Wachtwoord opnieuw instellen</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <?php

                            wijzigWachtwoord($conn);
                            
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