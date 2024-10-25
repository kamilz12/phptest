<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formularz kontaktowy</title>

</head>
<body>

<h1>zaladowano zdjecie!</h1>
<?php

//$_FILES['file']['name'] - The original name of the file to be uploaded.
//
//$_FILES['file']['type'] - The mime type of the file.
//
//$_FILES['file']['size'] - The size, in bytes, of the uploaded file.
//
//$_FILES['file']['tmp_name'] - The temporary filename of the file in which the uploaded file was stored on the server.
//
//$_FILES['file']['error'] - The error code associated with this file upload.\


if (isset($_POST['zapisz']) && ($_POST['zapisz'] == 'zapisz') && (!isset($_GET['pic']))) {
    if (is_uploaded_file($_FILES['zdjecie']['tmp_name'])) {

        $typ = $_FILES['zdjecie']['type']; //typ pliku
        //jesli typ pliku to jpeg
        if ($typ === 'image/jpeg') {
            //przeniesienie do katalogu docelowego
            move_uploaded_file($_FILES['zdjecie']['tmp_name'], './' .
                $_FILES['zdjecie']['name']);

            //tworzenie sciezki do zdjecia
            $link = $_FILES['zdjecie']['name'];
            echo "$link";
            $random = uniqid('img_'); //wygenerowanie losowej wartości
            $zdj = $random . '.jpeg'; //nazwa randomowego zdjecia ?
            copy($link, './' . $zdj); //utworzenie kopii zdjęcia
            list($width, $height) = getimagesize($zdj); //pobranie rozmiarów obrazu
            $wys = $_POST['wys']; //wysokość preferowana przez użytkownika
            $szer = $_POST['szer']; //szerokość preferowana przez użytkownika
            $skalaWys = 1;
            $skalaSzer = 1;
            $skala = 1;
            if ($width > $szer) $skalaSzer = $szer / $width;
            if ($height > $wys) $skalaWys = $wys / $height;
            if ($skalaWys <= $skalaSzer) $skala = $skalaWys;
            else $skala = $skalaSzer;
//ustalenie rozmiarów miniaturki tworzonego zdjęcia:
            $newH = $height * $skala;
            $newW = $width * $skala;
            header('Content-Type: image/jpeg');
            $nowe = imagecreatetruecolor($newW, $newH); //czarny obraz
            $obraz = imagecreatefromjpeg($zdj);
            imagecopyresampled($nowe, $obraz, 0, 0, 0, 0,
                $newW, $newH, $width, $height);
            imagejpeg($nowe, './mini-' . $link, 100);
            echo "nowe=/mini-$link <br>";
            imagedestroy($nowe);
            imagedestroy($obraz);
            unlink($zdj);

            $dlugosc = strlen($link);
            $dlugosc -= 4;
            $link = substr($link, 0, $dlugosc);
            //echo "link=$link <br/>";
            header('location:zdjecia.php?pic=' . $link);
        } else {
            header('location:zdjecia.html');
        }

    }

}
if (!empty($_GET['pic'])) {
    echo '<a href="' . $_GET['pic'] . '">Zdjęcie</a><br/>';
    echo '<a href="mini-' . $_GET['pic'] . '"> Miniatura</a><br/><br/>';
    echo '<a href="zdjecia.html">Powrót</a>';
}

?>

</body>
</html>
