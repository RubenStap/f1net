-- Creeren database genaamd f1net
CREATE DATABASE IF NOT EXISTS f1net;

-- Gebruik de database genaamd f1net 
USE f1net;

-- Creeer tabel genaamd gebruikers als die nog niet bestaat met de volgende eigenschappen
CREATE TABLE IF NOT EXISTS gebruikers (
    gebruikersID int(11) NOT NULL AUTO_INCREMENT,
    email varchar(255) NOT NULL,
    gebruikersnaam varchar(30) NOT NULL,
    wachtwoord varchar(255) NOT NULL,
    admin BOOLEAN DEFAULT false,
    PRIMARY KEY (gebruikersID)
);


-- Inlog gegevens admin account
-- gebruikersnaam = admin
-- email = admin@admin
-- wachtwoord = admin

-- mysql boolean values
-- 0 = false 
-- 1 = true

-- Zet in de tabel gebruikers de volgende gegevens maar overschrijft deze gegevens met een id van 1 als
-- de query opnieuw word uitgevoerd.
REPLACE INTO gebruikers (gebruikersID, email, gebruikersnaam, wachtwoord, admin)
VALUES (1, 'admin@admin', 'admin', '$2y$10$qonovuxVdgXBVnjnqXV7j.WeN1g9iEJs8wOoxPh7AOkdkE4WnO5fW', true);

-- *** 
CREATE TABLE IF NOT EXISTS coureurs (
   coureurID int(11) NOT NULL AUTO_INCREMENT, 
   title varchar(255) NOT NULL,
   afbeelding varchar(255) NOT NULL,
   omschrijving MEDIUMTEXT NOT NULL,
   PRIMARY KEY (coureurID)
);

-- ***
CREATE TABLE IF NOT EXISTS banen (
   banenID int(11) NOT NULL AUTO_INCREMENT, 
   title varchar(255) NOT NULL,
   naam varchar(255) NOT NULL, 
   afbeelding varchar(255) NOT NULL,
   omschrijving MEDIUMTEXT NOT NULL,
   PRIMARY KEY (banenID)
);

CREATE TABLE IF NOT EXISTS teams (
   teamID int(11) NOT NULL AUTO_INCREMENT, 
   title varchar(255) NOT NULL,
   afbeelding varchar(255) NOT NULL,
   omschrijving MEDIUMTEXT NOT NULL,
   PRIMARY KEY (teamID)
);

CREATE TABLE IF NOT EXISTS favorieten (
   favorietenID int(11) NOT NULL AUTO_INCREMENT,
   gebruikersID int(11) NOT NULL,
   coureurID int(11),
   teamID int(11),
   banenID int(11),
   PRIMARY KEY (favorietenID),
   FOREIGN KEY (gebruikersID) REFERENCES gebruikers(gebruikersID),
   FOREIGN KEY (coureurID) REFERENCES coureurs(coureurID),
   FOREIGN KEY (teamID) REFERENCES teams(teamID),
   FOREIGN KEY (banenID) REFERENCES banen(banenID)
);

CREATE TABLE IF NOT EXISTS overOns (
   overOnsID int(11) NOT NULL AUTO_INCREMENT, 
   naam varchar(255) NOT NULL,
   afbeelding varchar(255) NOT NULL,
   omschrijving varchar(255) NOT NULL,
   favCoureur varchar(25) NOT NULL,
   PRIMARY KEY (overOnsID)
);

 INSERT INTO coureurs ( title, afbeelding, omschrijving ) 
values 
('Max Verstappen', 'max.png', 'Nederlandse F1-kampioen, bekend om zijn gedurfde races en kwaliteit in de race.'),
('Sergio Perez', 'sergio.png', 'Mexicaanse F1-coureur, gewaardeerd om zijn consistente prestaties.'),
('George Russell', 'rus.png', 'Britse F1-coureur, een van de beste coureurs van mercedes talent met veel potentieel'),
('Lewis Hamilton', 'ham.png', 'Britse F1-legende, recordhouder en zevenvoudig wereldkampioen.'),
('Carlos Sainz', 'sai.png', 'Spaanse F1-coureur, bekend om zijn vastberadenheid en veelzijdigheid.'),
('Charles Leclerc', 'lec.png', 'Monegaskische F1-coureur, opkomend talent met indrukwekkende snelheid'),
('Lando Norris', 'nor.png', 'Britse F1-coureur, bekend om zijn jeugdige enthousiasme en snelle progressie.'),
('Oscar Piastri', 'pia.png', 'Australische opkomende coureur, bekend om zijn indrukwekkende prestaties in de junior formuleklassen.'),
('Fernado Alonso', 'alo.png', 'Spaanse F1-legende, tweevoudig wereldkampioen en ervaren racer.'),
('Lance Stroll', 'str.png', 'Canadese F1-coureur, bekend om zijn snelheid, zijn vader en jonge leeftijd.'),
('Pierre Gasly', 'gas.png', 'Franse F1-coureur, bekend om zijn vastberadenheid en overwinning in Monza.'),
('Esteban Ocon', 'oco.png', 'Franse F1-coureur, bekend om zijn constante prestaties en sterke racevaardigheden.'),
('Valteri Bottas', 'bot.png', 'Finse F1-coureur, bekend om zijn snelheid en betrouwbaarheid als teamspeler.'),
('Guanyu Zhou', 'zho.png', 'Chinese F1-coureur, opkomend talent met veelbelovende prestaties in de opstapklasses.'),
('Alex Albon','alb.png', 'Thai-Britse F1-coureur, bekend om zijn vastberadenheid en racevaardigheden.'),
('Logan Sargeant','sar.png', 'Amerikaanse opkomende coureur, bekend om zijn veelbelovende prestaties in de junior formuleklassen.'),
('Nico Hulkenberg','hul.png', 'Duitse F1-coureur, bekend om zijn ervaring en flexibiliteit als reserve- en vervangingsrijder.'),
('Kevin Magnussen', 'mag.png', 'Deense F1-coureur, bekend om zijn agressieve rijstijl en vastberadenheid op het circuit.'),
('Daniel Ricciardo','ric.png', 'Australische F1-coureur, bekend om zijn vrolijke persoonlijkheid en gewaagde inhaalacties.'),
('Yuki tsunoda','tsu.png', 'Japanse F1-coureur, opkomend talent met snelheid en vastberadenheid.');

INSERT INTO banen (title, naam, afbeelding, omschrijving)
VALUES ('BAHRAIN GP', 'BAHRAIN GP', 'Bahrain.png', 'Op het 5.412 kilometer lange circuit werden 57 rondes afgelegd. De snelste race ronde, een indrukwekkende 1:30.252, werd vastgesteld in 2004. De spanning en snelheid op de baan waren adembenemend terwijl de coureurs streden om de leiding.'),
       ('SAUDI ARABIAN GP', 'SAUDI ARABIAN GP', 'jeddah.png', 'Op het 6.174 kilometer lange circuit werden 50 rondes afgelegd. Het ronderecord van 1:30.734, vastgesteld in 2021, zorgde voor intense competitie onder de coureurs terwijl ze streden om de beste positie op de baan.'),
       ('AUSTRALIAN GP', 'ALBERT PARK', 'australie.png', 'Met 58 rondes op het 5.278 kilometer lange circuit was de competitie intens. Het ronderecord van 1:20.260, neergezet in 2022, motiveerde coureurs om hun grenzen te verleggen en de snelste rondetijden te behalen tijdens deze uitdagende race.'),
       ('JAPANESE GP', 'SUZUKA CIRCUIT', 'japan.png', 'Op het 5.807 kilometer lange circuit werden 53 rondes afgelegd. Het ronderecord van 1:30.983, gevestigd in 2019, hing als een uitdaging boven de coureurs, die streden om elke bocht en rechte lijn om de beste tijden te behalen tijdens deze spannende race.'),
       ('CHINESE GP', 'SHANGHAI INTERNATIONAL CIRCUIT', 'china.png', 'Op het 5.451 kilometer lange circuit werden 56 rondes afgelegd. Het ronderecord van 1:32.238, vastgesteld in 2004, diende als een constante uitdaging voor de coureurs terwijl ze streefden naar perfectie in elke bocht en rechte lijn gedurende de race.'),
       ('MIAMI GP', 'MIAMI INTERNATIONAL AUTODROME', 'miami.png', 'Op het 5.412 kilometer lange circuit werden 57 rondes afgelegd. Het ronderecord van 1:31.361, vastgesteld in 2022, zette een hoge standaard voor de coureurs, die vastberaden waren om de limieten van snelheid en precisie te doorbreken tijdens deze intense race.'),
       ('IMOLA GP', 'AUTODROMO ENZO E DINO FERRARI', 'imola.png', 'Op het 4.909 kilometer lange circuit werden 63 rondes afgelegd. Het ronderecord van 1:15.484, vastgesteld in 2020, bleef een ultieme uitdaging voor de coureurs, die elke bocht aangrepen met vastberadenheid en precisie tijdens deze adrenaline-pompende race.'),
       ('CANADIAN GP', 'CIRCUIT GILLES VILLENEUVE', 'canada.png', 'Op het 4.361 kilometer lange circuit werden 70 rondes afgelegd. Het ronderecord van 1:13.078, vastgesteld in 2019, diende als een constante uitdaging voor de coureurs, die elk moment op de baan benutten om hun snelheid en precisie te maximaliseren tijdens deze intense race.'),
       ('SPANISH GP', 'CIRCUIT DE CATALUNYA', 'spain.png', 'Op het 4.675 kilometer lange circuit werden 66 rondes afgelegd. Het ronderecord van 1:18.149, vastgesteld in 2021, stelde een uitdagende maatstaf voor de coureurs, die vastberaden waren om elke bocht te perfectioneren en de snelste tijden te behalen tijdens deze spannende race.'),
       ('AUSTRIAN GP', 'RED BULL RING', 'oostenrijk.png', 'Op het 4.318 kilometer lange circuit werden 71 rondes afgelegd. Het ronderecord van 1:05.619, vastgesteld in 2020, zorgde voor een ongekende uitdaging voor de coureurs, die hun vaardigheden tot het uiterste dreven om elke bocht met precisie te nemen tijdens deze adembenemende race.'),
       ('BRITISH GP', 'CIRCUIT SILVERSTONE', 'silverstone.png', 'Op het 5.891 kilometer lange circuit werden 52 rondes afgelegd. Het ronderecord van 1:27.097, gevestigd in 2020, vormde een constante uitdaging voor de coureurs, die gestaag werkten aan het perfectioneren van elke bocht tijdens deze uitdagende race.'),
       ('HUNGARIAN GP', 'HUNGARORING', 'hongarije.png', 'Op het 4.381 kilometer lange circuit werden 70 rondes afgelegd. Het ronderecord van 1:16.627, vastgesteld in 2020, dreef de coureurs tot het uiterste, terwijl ze elke bocht met precisie aanvielen tijdens deze intense race.'),
       ('BELGIAN GP', 'SPA-FRANCORCHAMPS', 'belgie.png', 'Op het 7.004 kilometer lange circuit werden 44 rondes afgelegd. Het ronderecord van 1:46.286, vastgesteld in 2018, daagde de coureurs uit om hun uithoudingsvermogen en precisie te tonen terwijl ze deze lange en uitdagende baan aanpakten.'),
       ('DUTCH GP', 'CIRCUIT ZANDVOORT', 'nederland.png', 'Op het 4.259 kilometer lange circuit werden 72 rondes afgelegd. Het ronderecord van 1:11.097, gevestigd in 2021, vormde een constante uitdaging voor de coureurs, die vastberaden waren om elke bocht met precisie aan te vallen tijdens deze intense race.'),
       ('ITALIAN GP', 'AUTODROMO NAZIONALE MONZA', 'monza.png', 'Op het 5.793 kilometer lange circuit werden 53 rondes afgelegd. Het ronderecord van 1:21.046, gevestigd in 2004, stond als een uitdaging voor de coureurs, die elk moment op de baan benutten om hun snelheid en precisie te maximaliseren tijdens deze spannende race.'),
       ('AZERBAIJAN GP', 'BAKU CITY CIRCUIT', 'baku.png', 'Op het 6.003 kilometer lange circuit werden 51 rondes afgelegd. Het ronderecord van 1:43.009, vastgesteld in 2019, vormde een uitdagende norm voor de coureurs, die elke bocht met precisie en vastberadenheid aanvielen tijdens deze veeleisende race.'),
       ('SINGAPORE GP', 'MARINA BAY STREET CIRCUIT', 'singapore.png', 'Op het 5.063 kilometer lange circuit werden 61 rondes afgelegd. Het ronderecord van 1:41.905, vastgesteld in 2018, diende als een uitdagende maatstaf voor de coureurs, die vastbesloten waren om elke bocht met precisie aan te vallen tijdens deze intense race.'),
       ('UNITED STATES GP', 'CIRCUIT OF THE AMERICAS', 'usa.png', 'Op het 5.513 kilometer lange circuit werden 56 rondes afgelegd. Het ronderecord van 1:36.169, gevestigd in 2019, stond als een uitdaging voor de coureurs, die elk moment op de baan benutten om hun snelheid en precisie te maximaliseren tijdens deze spannende race.'),
       ('MEXICAN GP', 'AUTODROMO HERMANOS RODRIGUEZ', 'mexico.png', 'Op het 4.304 kilometer lange circuit werden 71 rondes afgelegd. Het ronderecord van 1:17.774, vastgesteld in 2021, zorgde voor een uitdagende norm voor de coureurs, die vastberaden waren om elke bocht met precisie aan te vallen tijdens deze intense race.'),
       ('BRAZILIAN GP', 'AUTODROMO JOSE CARLOS PACE INTERLAGOS', 'brazil.png', 'Op het 4.309 kilometer lange circuit werden 71 rondes afgelegd. Het ronderecord van 1:10.540, vastgesteld in 2018, vormde een uitdagende norm voor de coureurs, die elk moment op de baan benutten om hun snelheid en precisie te maximaliseren tijdens deze intense race.'),
       ('LAS VEGAS GP', 'LAS VEGAS STREET CIRCUIT', 'lasvegas.png', 'Op het 6.120 kilometer lange circuit werden 50 rondes afgelegd. Met een ronderecord van 1:35.490, was elke ronde een uitdaging voor de coureurs, die streefden naar perfectie in elke bocht tijdens deze spannende race.'),
       ('QATAR GP', 'LOSAIL INTERNATIONAL CIRCUIT', 'qatar.png', 'Op het 5.380 kilometer lange circuit werden 57 rondes afgelegd. Met een ronderecord van 1:23.196, vastgesteld in 2021, was elke ronde een intense strijd voor de coureurs, die vastbesloten waren om elke bocht met precisie aan te vallen tijdens deze adembenemende race.'),
       ('GP ABU DHABI', 'YAS MARINA CIRCUIT', 'abudhabi.png', 'Op het 5,281 kilometer lange circuit werden 58 rondes afgelegd. Met een snelste raceronde van 1.26,103 in 2021, was elke ronde een spannende uitdaging voor de coureurs, die vastberaden waren om de limieten van snelheid en precisie te verleggen tijdens deze opwindende race.');

-- ***
INSERT INTO teams (title, afbeelding, omschrijving)
VALUES ('RED BULL RACING', 'redbull.png', 'Red Bull Racing, een Formule 1-team, staat bekend om zijn innovatie en agressieve aanpak, met coureurs zoals Max Verstappen en Sergio Perez.'),
       ('SCUDERIA FERRARI', 'ferrari.png', 'Ferrari, legendarisch Italiaans Formule 1-team, bekend om zijn rijke geschiedenis, passie en iconische rode kleur, met coureurs zoals Charles Leclerc.'),
       ('MERCEDES AMG F1', 'mercedes.png', 'Mercedes, toonaangevend Formule 1-team, bekend om zijn dominantie en technische excellentie, met coureurs zoals Lewis Hamilton en George Russell.'),
       ('MCLAREN RACING', 'mclaren.png', 'McLaren Racing, een iconisch Brits Formule 1-team, bekend om zijn rijke erfenis, innovatie en succes op het circuit.'),
       ('ASTON MARTIN F1 TEAM', 'aston.png', 'Aston Martin F1 Team, een Brits Formule 1-team, bekend om zijn samenwerking met de prestigieuze automaker en opkomend talent zoals Sebastian Vettel.'),
       ('HAAS F1 TEAM', 'haas.png', 'Haas F1 Team, een Amerikaans Formule 1-team, opgericht in 2016, bekend om zijn pragmatische aanpak en samenwerking met Ferrari voor motoren.'),
       ('WILLIAMS RACING', 'wiliams.png', 'Williams Racing is een historisch Formule 1-team met een rijke erfenis, opgericht in 1977, bekend om zijn passie, innovatie en talentontwikkeling.'),
       ('STAKE F1 TEAM', 'stake.png', 'Red Bull Racing, een Formule 1-team, staat bekend om zijn innovatie en agressieve aanpak, met coureurs zoals Max Verstappen en Sergio Perez.'),
       ('VISA CASH APP RB', 'rb.png', 'Red Bull Racing, een Formule 1-team, staat bekend om zijn innovatie en agressieve aanpak, met coureurs zoals Max Verstappen en Sergio Perez.'),
       ('ALPINE F1', 'alpine.png', 'Red Bull Racing, een Formule 1-team, staat bekend om zijn innovatie en agressieve aanpak, met coureurs zoals Max Verstappen en Sergio Perez.');


INSERT INTO overOns (naam, afbeelding, omschrijving, favCoureur)
VALUES ('Bram', 'bram.png', 'Hoi ik ben Bram ik ben een van de programmeurs van F1 Net.', 'Nikolas Latifi'),
       ('Ruben', 'ruben.png', 'Hoi ik ben Ruben ik ben een van de programmeurs van F1 Net.', 'Carlos Sainz'),
       ('Thijn', 'thijn.png', 'Hoi ik ben Thijn ik ben een van de programmeurs van F1 Net.', 'Oscar Piastri'),
       ('Daan', 'daan.png', 'Hoi ik ben Daan ik ben een van de programmeurs van F1 Net.', 'Charles Leclerc'),
       ('Damien', 'damien.png', 'Hoi ik ben Damien ik ben een van de programmeurs van F1 Net.', 'Charles Leclerc'),
       ('Onno', 'onno.png', 'Hoi ik ben Onno ik ben de productowner van F1 Net.', 'Aryton Senna');