<?php
// *************** 1. Typy danych ***************

// Typy proste
$liczba = 10; // INTEGER
$przecinek = 3.14; // DOUBLE
$tekst = "Hello, World"; // STRING
$czy_prawda = true; // BOOLEAN

// *************** 2. Tablice ***************

// Tablica numeryczna
$towary = array("Zeszyt", "Blok", "Kredki");
$towary = ["Zeszyt", "Blok", "Kredki"]; // Alternatywny zapis

// Tablica asocjacyjna
$ceny = ["Zeszyt" => 2, "Blok" => 8, "Kredki" => 4];

// Dostęp do elementów tablicy asocjacyjnej
$ceny["Blok"] = 6; // Zmiana wartości dla klucza "Blok"

// Wyświetlenie tablicy asocjacyjnej za pomocą pętli foreach
foreach ($ceny as $klucz => $wartosc) {
    echo "$klucz kosztuje $wartosc zł <br>";
}

// *************** 3. Sortowanie tablic ***************

// Sortowanie tablic numerycznych
$liczby = [20, 10, 18];
sort($liczby); // Rosnąco
rsort($liczby); // Malejąco

// Sortowanie tablic asocjacyjnych
asort($ceny); // Rosnąco według wartości
ksort($ceny); // Rosnąco według klucza
arsort($ceny); // Malejąco według wartości
krsort($ceny); // Malejąco według klucza

// *************** 4. Operacje na plikach ***************

// Otwarcie pliku w trybie do zapisu; tworzy plik, jeśli nie istnieje
$plik = fopen("dane.txt", "w");
if ($plik) {
    fwrite($plik, "Pierwsza linia tekstu\n"); // Zapis do pliku
    fclose($plik); // Zamknięcie pliku
}

// Odczyt z pliku
$plik = fopen("dane.txt", "r");
if ($plik) {
    while (!feof($plik)) { // Pętla odczytująca do końca pliku
        echo fgets($plik) . "<br>"; // Odczyt jednej linii
    }
    fclose($plik);
}

// *************** 5. Wyrażenia regularne ***************

// Przykład zamiany tekstu przy pomocy wyrażeń regularnych
$ciag = "Szybki, rudy lis.";
$wzor = "/rudy/";
$zamiana = "czarny";
echo preg_replace($wzor, $zamiana, $ciag); // Zmiana tekstu "rudy" na "czarny"

// Przykład wyszukiwania tekstu w ciągu
$czyZnaleziono = preg_match("/lis/", $ciag, $wyniki);
if ($czyZnaleziono) {
    echo "Znaleziono: " . $wyniki[0]; // Wynik wyszukiwania
}

// *************** 6. Funkcje przydatne przy wyrażeniach regularnych ***************

// Funkcja preg_split - dzieli ciąg względem wzorca wyrażenia regularnego
$ciag_do_podzialu = "ala@ma@kota";
$podzielone = preg_split("/@/", $ciag_do_podzialu);
print_r($podzielone); // Wyświetla tablicę ["ala", "ma", "kota"]

?>
