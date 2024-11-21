<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <style>
        .hero-image {
            color: blue;
            background-color: blue;
            position: absolute;
            right: 10%;
            top: 50%;
            transform: translateY(-50%);
            width: 60%;
            height: 80%;
           
            border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%;
            animation: morph 8s ease-in-out infinite;
        }
        .a{
            left: 0;
            width: 30%;
            height: 40%;
        }

        /*distorção da imagem*/
        @keyframes morph {
            0% { border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%; }
            50% { border-radius: 70% 30% 30% 70% / 70% 70% 30% 30%; }
            100% { border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%; }
        }

    </style>
    <div class="hero-image"></div>
    <div class="hero-image a"></div>
</body>
</html>