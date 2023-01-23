<?php
    $db = \Config\Database::connect();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin</title>
    <meta name="description" content="The small framework with powerful features">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/png" href="/favicon.ico">
    <link rel="stylesheet" href="/css/main.css">
    <script type="text/javascript" src="\js\jquery-3.6.0.min.js" ></script>
    <style>
        
    </style>
    <script type='text/javascript'>
        $(document).ready(function() {
            $('#nov-sklad-form,#nov-artikul-form').on('submit', function(e) {
                e.preventDefault();
                var form = $(e.currentTarget);
                $.ajax({
                    url: form.attr('data-url'),
                    method: 'post',
                    data: form.serialize()
                })
                .done(function(jqXHR, status, req) {
                    //var response = $.parseJSON(jqXHR);
                    console.log(jqXHR);
                });
            });
        });
    </script>
</head>
<body>
<header>

<div id="body">
    <div id='inner-add'>
        <div id='admin-panel-top'>
            <span>Административен панел</spab>
        </div>
        <div id='nov-sklad'>
            <form action='' id='nov-sklad-form' data-url='/nov-sklad'>
                <input type='text' name='nov-sklad' placeholder='Нов склад'>
                <input type='submit' name='sklad-submit' value='Създай' id='sklad-submit'>
            </form>
            <div id='nov-sklad-error'>
                <span></span>
            </div>
        </div>

        <div id='nov-artikul-top'>
            <span>Нов артикул</span>
        </div>
        <div id='nov-artikul'>
            <form action='' id='nov-artikul-form' data-url='/add-product'>
                <?php
                    $tables = $db->listTables();
                ?>
                <select name="sklad-select" id="sklad-select">
                    <?php
                        foreach($tables as $table) {
                            if($table != 'pending_orders') {
                                echo "<option value='".$table."'>".$table."</option>";
                            }
                        }
                    ?>
                </select>
                <input type='text' name='nov-artikul' placeholder='Нов артикул'>
                <input type='text' name='nov-artikul-cena' placeholder='Цена на артикул'>
                <input type='text' name='nov-artikul-broika' placeholder='Бройка'>
                <input type='text' name='nov-artikul-opisanie' placeholder='Описaние'>
                <input type='submit' name='artikul-submit' value='Създай' id='artikul-submit'>
            </form>
            <div id='nov-artikul-error'>
                <span></span>
            </div>
        </div>
    </div>
</div>

<!-- -->

</body>
</html>
