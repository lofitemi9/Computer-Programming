<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <?php
    $phrase = "Giraffe Academy";
    echo str_replace("Giraffe", "Panda", $phrase);
    echo "<br>";
    echo substr($phrase, 8);
    ?>
</body>

</html>