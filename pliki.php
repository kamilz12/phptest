<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formularz kontaktowy</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 20px;
        }
        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        input, label {
            display: block;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

<h1>Formularz kontaktowy</h1>
<form action="pliki.php" method="post">
    <label for="imie">Imię:</label>
    <input type="text" id="imie" name="imie" >

    <label for="nazwisko">Nazwisko:</label>
    <input type="text" id="nazwisko" name="nazwisko" >

    <label for="email">Adres e-mail:</label>
    <input type="email" id="email" name="email" >

    <label for="telefon">Numer telefonu:</label>
    <input type="tel" id="telefon" name="telefon" >

    <label for="panstwo">Państwo:</label>
    <select id="panstwo" name="panstwo" >
        <option value="">Wybierz państwo</option>
        <option value="polska">Polska</option>
        <option value="niemcy">Niemcy</option>
        <option value="francja">Francja</option>
        <option value="wielka_brytania">Wielka Brytania</option>
        <option value="usa">USA</option>
        <option value="kanada">Kanada</option>
        <option value="australia">Australia</option>
    </select>

    <fieldset>
        <legend>Technologie:</legend>
        <label>
            <input type="checkbox" name="technologie[]" value="php"> PHP
        </label>
        <label>
            <input type="checkbox" name="technologie[]" value="java"> Java
        </label>
        <label>
            <input type="checkbox" name="technologie[]" value="js"> JavaScript
        </label>
    </fieldset>

    <fieldset>
        <legend>Sposób płatności:</legend>
        <label>
            <input type="radio" name="sposob_platnosci" value="karta_kredytowa" > Karta kredytowa
        </label>
        <label>
            <input type="radio" name="sposob_platnosci" value="paypal"> PayPal
        </label>
        <label>
            <input type="radio" name="sposob_platnosci" value="przelew_bankowy"> Przelew bankowy
        </label>
    </fieldset>

    <button type="submit" name="submit" value="wyczysc">Wyczysc</button>
    <button type="submit" name="submit" value="zapisz">Zapisz</button>
    <button type="submit" name="submit" value="pokaz">Pokaz</button>
    <button type="submit" name="submit" value="php">PHP</button>
    <button type="submit" name="submit" value="cpp">CPP</button>
    <button type="submit" name="submit" value="java">JaVA</button>
</form>

<form action="zdjecia.php" method="post" enctype="multipart/form-data">
    <p>max wysokosc: </p> <input type="number" name="wys"><br>
    <p>max szerokosc: </p> <input type="number" name="szer"><br>
    <p>Plik jpg</p> <input type="file" name="zdjecie"><br>
    <input type="submit" value="zapisz" name="zapisz">
</form>
<?php
//Funkcje pomocnicze:
function dodaj() {
    if (isset($_REQUEST['nazwisko'])&&($_REQUEST['nazwisko']!="")) {
        $nazwisko = htmlspecialchars(trim($_REQUEST['nazwisko']));
        echo "Nazwisko: $nazwisko <br />";
    }
    else echo "Nie wpisano nazwiska <br />";

    if (isset($_REQUEST['imie'])&&($_REQUEST['imie']!="")) {
        $imie = htmlspecialchars(trim($_REQUEST['imie']));
        echo "imie: $imie <br />";
    }
    else echo "Nie wpisano imie <br />";

    if (isset($_REQUEST['email'])&&($_REQUEST['email']!="")) {
        $email = htmlspecialchars(trim($_REQUEST['email']));
        echo "email: $email <br />";
    }
    else echo "Nie wpisano email <br />";

    if (isset($_REQUEST['telefon'])&&($_REQUEST['telefon']!="")) {
        $telefon = htmlspecialchars(trim($_REQUEST['telefon']));
        echo "telefon: $telefon <br />";
    }
    else echo "Nie wpisano telefon <br />";

    if (isset($_REQUEST['technologie']) && is_array($_REQUEST['technologie']) && count($_REQUEST['technologie']) > 0) {
        $tech = '<p>Wybrane technologie: ' . implode(', ', $_REQUEST['technologie']) . '</p>';
        echo $tech;
    } else {
        echo '<p class="error">Musisz wybrać przynajmniej jedną technologię!</p>';
    }

    if (isset($_REQUEST['panstwo']) && ($_REQUEST['panstwo']!='')) {
        $panstwo = htmlspecialchars((trim($_REQUEST['panstwo'])));
        echo "wybrane panstwo $panstwo";
    } else {
        echo '<p class="error">Musisz wybrać panstwo!</p>';
    }

    if (isset($_REQUEST['sposob_platnosci']) && $_REQUEST['sposob_platnosci']!=''){
        $platnosc = htmlspecialchars((trim($_REQUEST['sposob_platnosci'])));
        echo "platnosc: $platnosc";
    }
    else{
        echo "nie wybrano platnosci";
    }
    $dane = "$nazwisko $imie $email $telefon $panstwo $platnosc  $tech  \n";
    $d_root = $_SERVER['DOCUMENT_ROOT'];
    $path = "$d_root/../file.txt";
    if (file_put_contents($path, $dane, FILE_APPEND) === false) {
        echo "<p class='error'>Błąd: Nie udało się zapisać danych do pliku.</p>";
    } else {
        echo "<p>Dane zapisane pomyślnie!</p>";
    }

//zbierz pozostałe dane z formularza – dodając je do łańcucha $dane
//zapisz łańcuch z danymi do pliku dane.txt w postaci wiersza np.:
//Agatowska 21 Polska agatka@gmail.com PHP,CPP,Java Visa
}
function pokaz() {
    echo file_get_contents("data.txt");
}
function pokaz_zamowienie($tut) {
    if (file_exists('data.txt')) {
        $dane = file('data.txt');
        foreach ($dane as $wiersz) {
            if (strpos($wiersz, $tut) !== false) {
                echo nl2br(htmlspecialchars($wiersz));
            }
        }
    }
}
//Skrypt właściwy do obsługi akcji (żądań):
if (isset($_POST["submit"])) {
    $akcja = $_POST["submit"];
    switch ($akcja) {
        case "zapisz":
            dodaj();
            break;
        case "pokaz":
            pokaz();
            break;
        case "java":
            pokaz_zamowienie("Java");
            break;
        case "php":
            pokaz_zamowienie("PHP");
            break;
        case "cpp":
            pokaz_zamowienie("CPP");
            break;
    }
}


// -------------------
// Informacje o serwerze i żądaniu
// -------------------

echo "<h3>Informacje o serwerze i żądaniu</h3>";

// Adres IP klienta
$client_ip = $_SERVER['REMOTE_ADDR'];
echo "<strong>Adres IP klienta:</strong> $client_ip<br />";

// Nazwa hosta serwera
$server_name = $_SERVER['SERVER_NAME'];
echo "<strong>Nazwa hosta serwera:</strong> $server_name<br />";

// Metoda żądania (GET/POST)
$request_method = $_SERVER['REQUEST_METHOD'];
echo "<strong>Metoda żądania:</strong> $request_method<br />";

// Adres URL
$request_uri = $_SERVER['REQUEST_URI'];
echo "<strong>Adres URL żądania:</strong> $request_uri<br />";

// Wersja protokołu HTTP
$http_version = $_SERVER['SERVER_PROTOCOL'];
echo "<strong>Wersja protokołu HTTP:</strong> $http_version<br />";

?>

</body>
</html>
