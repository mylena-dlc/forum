<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="title" content="<?= $title ?>">
    <meta class="name" content="Forum Ski Pass sur les sports d'hiver">
    <meta name="keywords" content="sport d'hiver, ski, snowbord, sport extrême, station, montagne">
    <meta name="robot" content="index, follow">
    <script src="https://cdn.tiny.cloud/1/zg3mwraazn1b2ezih16je1tc6z7gwp5yd4pod06ae5uai8pa/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="./public/css/style.css">
    
</head>

<body>
    <?php

    $title = $result["data"]['title'];
    $description = $result["data"]['description'];

    ?>

    <section class="home">
        
        <div class="logo-titre">
            <figure class="figure-home">
                <img class="img-home" src="public/img/logo2.png" alt="Logo Ski Pass">
            </figure>
            <h1 class="h1-home">Bienvenue sur <span class="span-home">SKI PASS</span></h1>
        </div>

        <p class="p-home">Votre forum de <em>sport d'hiver</em></p>

        <h2 class="h2-home">
            <a href="index.php?ctrl=forum&action=listCategories">Toutes les catégories</a>
        </h2>

        <video src="public/img/ski.mp4" autoplay muted loop></video>

    </section>
</body>

</html>