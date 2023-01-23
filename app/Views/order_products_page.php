<?php
    $db = \Config\Database::connect();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Order products</title>
    <meta name="description" content="The small framework with powerful features">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/png" href="/favicon.ico">
    <link rel="stylesheet" href="/css/main.css">

    <script type="text/javascript" src="\js\jquery-3.6.0.min.js" ></script>
    <script type="text/javascript" src="\js\cookie-util.js"></script>
    <script type="text/javascript" src="\js\main.js"></script>
    <style>
        
    </style>
</head>
<body>
<header>

<div id="body">
    <div id='inner'>
        <div id='skladove'>
            <span>Складове</spab>
        </div>

        <!------------------------------------------------------------------------------------------------------ -->
        <div id='zelenchuci'>
            <span>Зеленчуци</spab>
        </div>
        <?php
            $query  = $db->query('select * from zelenchuci');
            $result = $query->getResult();
        ?>
        <div id='sklad-zelenchuci' class='sklad'>
            <form action='' id='artikuli-zelenchuci-form' data-name='zelenchuci'>
                <select name="artikul" id="artikuli-zelenchuci">
                    <?php
                        foreach($result as $item) {
                            echo "<option value='".$item->ime."' data-count='".$item->broika."'>".$item->opisanie."</option>";
                        }
                    ?>
                </select>
                <input type='text' name='broika' placeholder='Бройка'>
                <input type='submit' name='poruchka' value='Добави'>
            </form>
            <div id='zelenchuci-error'>
                <span></span>
            </div>
        </div>

        <!------------------------------------------------------------------------------------------------------ -->
        <div id='elektronika'>
            <span>Електроника</spab>
        </div>
        <?php
            $query  = $db->query('select * from elektronika');
            $result = $query->getResult();
        ?>
        <div id='sklad-elektronika' class='sklad'>
            <form action='' id='artikuli-elektronika-form' data-name='elektronika'>
                <select name="artikul" id="artikuli-elektronika">
                    <?php
                        foreach($result as $item) {
                            echo "<option value='".$item->ime."' data-count='".$item->broika."'>".$item->opisanie."</option>";
                        }
                    ?>
                </select>
                <input type='text' name='broika' placeholder='Бройка'>
                <input type='submit' name='poruchka' value='Добави'>
            </form>
            <div id='elektronika-error'>
                <span></span>
            </div>
        </div>

        <button id='order-button'>Завърши поръчката</button>
        <div id='final-price'>
            <span>Крайна цена: <span>200.50</span></span>
        </div>
    </div>
</div>

<script>
    
</script>

<!-- -->

</body>
</html>
