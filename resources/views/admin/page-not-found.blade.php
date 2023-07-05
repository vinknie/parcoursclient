<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <style>
        html {
            height: 100vh;
            overflow: hidden
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .image-container {
            position: relative;
        }

        .image-container img {
            display: block;
            width: 100%;
        }

        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: #0000007a;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            text-align: center;
            color: #cacaca;
            font-size: 30px;
            font-family: sans-serif;
        }

        .overlay a {
            color: #69a28f;
            text-decoration-color: #cacaca;
            text-underline-offset: 4px;
            font-size: 22px;
        }
    </style>
</head>

<body>
    <div class="image-container">
        <img src="{{ asset('images/lost.jpg') }}" alt="not found"
            style="width: 100%; height: 100%; max-height: 100vh; object-fit: cover">
        <div class="overlay">
            <p>"Perdre le chemin est le début de l'aventure."</p>
            <p>- Patrick Modiano</p>
            <a href="http://localhost:8000">Aller à la page d'accueil &gt;</a>
        </div>
    </div>
</body>

</html>