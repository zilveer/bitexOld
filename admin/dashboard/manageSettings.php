<?php
session_start();
require_once 'database.php';
require_once 'pagination.php';

// Comprobar si usuario esta logeado
if( !isset($_SESSION['sAdmin'])) {
    //header('Location: ../login.php');
}

$dbs = new DatabaseAdministration('settings');

// Se filtran todos los valores de $_POST y se actualiza la db
if( isset($_POST['save_settings']) ) {

}


// Cargar config ...
$settings = $dbs->getSettings();

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>BitEx | Global settings</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
    <link rel="stylesheet" href="/bitex/resources/css/account.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
    <script type="text/javascript">
    $( document ).ready(function() {
        $('#menu-item-settings').addClass('active');
    });
    </script>
</head>
<body>
    <?php include 'include/menuh.php'; ?>
    <p>&nbsp;</p>
    <div class="container">
        <div class="row">
            <div class="col-sm-3">
                <?php include_once 'include/menuv.php'; ?>
            </div>
            <div class="col-sm-9">
                <div class="jumbotron">

                    <form method="POST">
                        <fieldset class="form-group">
                            <legend>Fees</legend>

                            <div class="form-group row">


                                <label for="staticEmail" class="col-sm-2 col-form-label">Buy fee</label>
                                <div class="col-sm-4">
                                    <input type="number" name="buyfee" min="0.00" max="0.1" step="0.01" class="form-control-plaintext" value="<?php echo $settings['buyfee']; ?>">
                                </div>


                                <label for="staticEmail" class="col-sm-2 col-form-label">Sell fee</label>
                                <div class="col-sm-4">
                                    <input type="number" name="sellfee" min="0.00" max="0.1" step="0.01" class="form-control-plaintext" value="<?php echo $settings['sellfee']; ?>">
                                </div>
                            </div>

                            <legend>Withdraw</legend>
                            <div class="form-group row">


                                <label for="staticEmail" class="col-sm-2 col-form-label">Procress withdrawls every minutes</label>
                                <div class="col-sm-4">
                                    <input type="number" name="buyfee" min="0.00" max="0.1" step="0.01" class="form-control-plaintext" value="<?php echo $settings['buyfee']; ?>">
                                </div>


                                <label for="staticEmail" class="col-sm-2 col-form-label">Sell fee</label>
                                <div class="col-sm-4">
                                    <input type="number" name="sellfee" min="0.00" max="0.1" step="0.01" class="form-control-plaintext" value="<?php echo $settings['sellfee']; ?>">
                                </div>
                            </div>

                        </fieldset>



                        <fieldset class="form-group">
                            <legend>Checkboxes</legend>
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input class="form-check-input" value="" checked="" type="checkbox">
                                    Option one is this and that—be sure to include why it's great
                                </label>
                            </div>
                            <div class="form-check disabled">
                                <label class="form-check-label">
                                    <input class="form-check-input" value="" disabled="" type="checkbox">
                                    Option two is disabled
                                </label>
                            </div>
                        </fieldset>
                        <button type="submit" class="btn btn-primary" name="save_settings">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
