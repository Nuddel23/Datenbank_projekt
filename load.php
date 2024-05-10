<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loading Spinner</title>
    <style>
        body {
            background-color: rgba(0, 0, 0, 0.7);
            ;
        }


        #loading-spinner {
            position: fixed;
            top: 50%;
            left: 50%;
            width: 20vw;
            height: 20vw;
        }

        @keyframes rotate {
            from {
                transform: translate(-50%, -50%) rotate(0deg);
            }

            to {
                transform: translate(-50%, -50%) rotate(360deg);
            }
        }

        #loading-spinner img {
            width: 100%;
            height: 100%;
            animation: rotate 2s linear infinite;
        }
    </style>
    <script>

        setTimeout(function () {
            window.location.href = "homepage.php";
        }, 1900); 
    </script>
</head>

<body>
    <div id="loading-spinner">
        <img src="img/logo.png">
    </div>
</body>

</html>