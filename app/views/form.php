<?php
// Tony Silvestri
// 11/4/21
/** @var ?string $results results from shipping rate request */
?>

<!doctype html>
<html lang="">
<head>
    <meta charset="utf-8">
    <title>Homework task v2.2</title>
    <meta name="description" content="Homework task v2.2">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body {
            display: flex;
            justify-content: center;
            font-family: Arial, Helvetica, sans-serif;
        }

        .container {
            width: 1080px;
        }

        label {
            min-width: 150px;
            display: inline-block;
            font-size: 15px;
            padding-bottom: 10px;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Shipment rates</h1>
    <form method="POST">
        <fieldset>
            <legend>Shipment address</legend>
            <div>
                <label>Address</label>
                <input name="recipient[address1]" value="<?= $_POST['recipient']['address1'] ?? null ?>">
            </div>
            <div>
                <label>City</label>
                <input name="recipient[city]" value="<?= $_POST['recipient']['city'] ?? null ?>">
            </div>
            <div>
                <label>State code</label>
                <input name="recipient[state_code]" value="<?= $_POST['recipient']['state_code'] ?? null ?>">
            </div>
            <div>
                <label>ZIP code</label>
                <input name="recipient[zip]" value="<?= $_POST['recipient']['zip'] ?? null ?>">
            </div>
            <div>
                <label>Country code</label>
                <input name="recipient[country_code]" value="<?= $_POST['recipient']['country_code'] ?? null ?>">
            </div>
        </fieldset>
        <br>
        <fieldset>
            <legend>Shipment items</legend>
            <fieldset>
                <legend>1. item</legend>
                <div>
                    <label>Variant ID</label>
                    <input name="items[0][variant_id]" value="<?= $_POST['items'][0]['variant_id'] ?? null ?>">
                </div>
                <div>
                    <label>Quantity</label>
                    <input name="items[0][quantity]" value="<?= $_POST['items'][0]['quantity'] ?? null ?>">
                </div>
            </fieldset>
            <fieldset>
                <legend>2. item</legend>
                <div>
                    <label>Variant ID</label>
                    <input name="items[1][variant_id]" value="<?= $_POST['items'][1]['variant_id'] ?? null ?>">
                </div>
                <div>
                    <label>Quantity</label>
                    <input name="items[1][quantity]" value="<?= $_POST['items'][1]['quantity'] ?? null ?>">
                </div>
            </fieldset>
        </fieldset>
        <br>
        <div>
            <button type="submit">Get shipping rates</button>
        </div>
    </form>
    <p>
        <?php
        if ($results) {
            echo $results;
        }
        ?>
    </p>
</div>
</body>
</html>
