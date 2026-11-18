<?php

$samochody = [
    [
        "marka" => "BMW",
        "model" => "320d",
        "rok_produkcji" => 2018,
        "cena" => 85000,
        "przebieg" => 120000,
        "paliwo" => "diesel",
        "moc" => 190
    ],
    [
        "marka" => "Audi",
        "model" => "A4",
        "rok_produkcji" => 2020,
        "cena" => 110000,
        "przebieg" => 80000,
        "paliwo" => "benzyna",
        "moc" => 150
    ],
    [
        "marka" => "Opel",
        "model" => "Astra H",
        "rok_produkcji" => 2008,
        "cena" => 14500,
        "przebieg" => 240000,
        "paliwo" => "benzyna",
        "moc" => 115
    ],
    [
        "marka" => "Volkswagen",
        "model" => "Passat B8",
        "rok_produkcji" => 2019,
        "cena" => 78000,
        "przebieg" => 145000,
        "paliwo" => "diesel",
        "moc" => 150
    ],
    [
        "marka" => "Toyota",
        "model" => "Corolla",
        "rok_produkcji" => 2024,
        "cena" => 115000,
        "przebieg" => 25000,
        "paliwo" => "hybryda",
        "moc" => 140
    ],
    [
        "marka" => "Skoda",
        "model" => "Octavia",
        "rok_produkcji" => 2016,
        "cena" => 48000,
        "przebieg" => 185000,
        "paliwo" => "diesel",
        "moc" => 150
    ],
    [
        "marka" => "Ford",
        "model" => "Focus",
        "rok_produkcji" => 2014,
        "cena" => 32000,
        "przebieg" => 160000,
        "paliwo" => "benzyna",
        "moc" => 125
    ],
    [
        "marka" => "Hyundai",
        "model" => "i30",
        "rok_produkcji" => 2023,
        "cena" => 89000,
        "przebieg" => 42000,
        "paliwo" => "benzyna",
        "moc" => 120
    ],
    [
        "marka" => "Mercedes-Benz",
        "model" => "C200",
        "rok_produkcji" => 2017,
        "cena" => 95000,
        "przebieg" => 110000,
        "paliwo" => "benzyna",
        "moc" => 184
    ],
    [
        "marka" => "Renault",
        "model" => "Megane",
        "rok_produkcji" => 2010,
        "cena" => 18000,
        "przebieg" => 210000,
        "paliwo" => "diesel",
        "moc" => 110
    ],
    [
        "marka" => "Kia",
        "model" => "Ceed",
        "rok_produkcji" => 2022,
        "cena" => 79000,
        "przebieg" => 65000,
        "paliwo" => "benzyna",
        "moc" => 160
    ]
];

usort($samochody, function($a, $b) {
    return $a['cena'] <=> $b['cena'];
});

function obliczWiek($rokProdukcji) {
    $aktualnyRok = date("Y");
    return $aktualnyRok - $rokProdukcji;
}

function okreslKategorie($wiek) {
    if ($wiek <= 3) {
        return "samochód prawie nowy";
    } elseif ($wiek >= 4 && $wiek <= 7) {
        return "samochód kilkuletni";
    } elseif ($wiek >= 8 && $wiek <= 15) {
        return "samochód używany";
    } else {
        return "samochód zabytkowy lub starszy";
    }
}


function wyszukajSamochody($samochody, $maksymalnaCena) {
    $znaleziono = false;

    foreach ($samochody as $auto) {
        if ($auto['cena'] <= $maksymalnaCena) {
            echo "<p><b>" . $auto['marka'] . " " . $auto['model'] . "</b> - " . $auto['cena'] . " zł (" . $auto['rok_produkcji'] . " r.)</p>";
            $znaleziono = true;
        }
    }

    if (!$znaleziono) {
        echo "<p>Nie znaleziono żadnego samochodu w podanym budżecie.</p>";
    }
}

// Funkcje analizy cen
function najdrozszySamochod($samochody) {
    $najdrozszy = $samochody[0];
    foreach ($samochody as $auto) {
        if ($auto['cena'] > $najdrozszy['cena']) {
            $najdrozszy = $auto;
        }
    }
    return $najdrozszy;
}

function najtanszySamochod($samochody) {
    $najtanszy = $samochody[0];
    foreach ($samochody as $auto) {
        if ($auto['cena'] < $najtanszy['cena']) {
            $najtanszy = $auto;
        }
    }
    return $najtanszy;
}

function obliczSredniaCene($samochody) {
    $suma = 0;
    $ilosc = count($samochody);

    foreach ($samochody as $auto) {
        $suma += $auto['cena'];
    }

    return round($suma / $ilosc);
}

// Obliczanie statystyk
$liczbaWszystkich = count($samochody);
$sredniaCena = obliczSredniaCene($samochody);
$najdrozszy = najdrozszySamochod($samochody);
$najtanszy = najtanszySamochod($samochody);

$licznikDiesel = 0;
$licznikPo2020 = 0;
$licznikMalyPrzebieg = 0;

foreach ($samochody as $auto) {
    if ($auto['paliwo'] == "diesel") {
        $licznikDiesel++;
    }
    if ($auto['rok_produkcji'] > 2020) {
        $licznikPo2020++;
    }
    if ($auto['przebieg'] < 100000) {
        $licznikMalyPrzebieg++;
    }
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Komis samochodowy</title>
</head>
<body>

    <h1>================================<br>
        KOMIS SAMOCHODOWY<br>
        ================================</h1>

    <?php foreach ($samochody as $auto): ?>
        <?php 
            $wiek = obliczWiek($auto['rok_produkcji']);
            $kategoria = okreslKategorie($wiek);
        ?>
        <div>
            <h3><?php echo $auto['marka'] . " " . $auto['model']; ?></h3>
            Rok produkcji: <?php echo $auto['rok_produkcji']; ?><br>
            Cena: <?php echo $auto['cena']; ?> zł<br>
            Przebieg: <?php echo $auto['przebieg']; ?> km<br>
            Paliwo: <?php echo $auto['paliwo']; ?><br>
            Moc: <?php echo $auto['moc']; ?> KM<br>
            Wiek: <?php echo $wiek; ?> lat<br>
            Kategoria: <?php echo $kategoria; ?><br>
            <p>--------------------------------</p>
        </div>
    <?php endforeach; ?>


    <h2>================================<br>
        WYSZUKIWARKA PO CENIE<br>
        ================================</h2>

    <form method="POST" action="">
        <label>Maksymalna cena (zł): </label>
        <input type="number" name="max_cena" required>
        <button type="submit">Szukaj</button>
    </form>

    <?php
    if (isset($_POST['max_cena']) && $_POST['max_cena'] !== "") {
        $maxCena = (int)$_POST['max_cena'];
        echo "<h3>Wyniki wyszukiwania do " . $maxCena . " zł:</h3>";
        wyszukajSamochody($samochody, $maxCena);
    } else {
        
        echo "<h3>Przykładowe wyszukiwanie (do 50000 zł):</h3>";
        wyszukajSamochody($samochody, 50000);
    }
    ?>


    <h2>================================<br>
        STATYSTYKI<br>
        ================================</h2>

    <p>
        Liczba samochodów: <?php echo $liczbaWszystkich; ?><br>
        Średnia cena: <?php echo $sredniaCena; ?> zł<br>
        Najdroższy: <?php echo $najdrozszy['marka'] . " " . $najdrozszy['model']; ?><br>
        Najtańszy: <?php echo $najtanszy['marka'] . " " . $najtanszy['model']; ?><br>
        Samochody diesel: <?php echo $licznikDiesel; ?><br>
        Samochody po 2020 roku: <?php echo $licznikPo2020; ?><br>
        Przebieg poniżej 100000 km: <?php echo $licznikMalyPrzebieg; ?>
    </p>
    <p>================================</p>

</body>
</html>