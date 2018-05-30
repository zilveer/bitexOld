<?php
session_start();
// Comprobar si usuario esta logeado
if( !isset($_SESSION['sAdmin'])) {
    //header('Location: ../login.php');
}

require_once 'include/database.php';
require_once 'include/pagination.php';

// Database
$dbm = new DatabaseAdministration('markets');
$dbc = new DatabaseAdministration('coins');

// Cargamos las coins ...
$coins = $dbc->getCoins();

// Add Market
if( isset($_POST['add_market']) ) {
    $ret = $dbm->addMarket($_POST);
}

// Remove Market
if( isset($_POST['remove_market']) ) {
    $ret = $dbm->removeMarket($_POST['id']);
}

// Open Market
if( isset($_POST['resume_market']) ) {
    $ret = $dbm->updateMarket($_POST['id'], 0);
}

// Close Market
if( isset($_POST['suspend_market']) ) {
    $ret = $dbm->updateMarket($_POST['id'], 1);
}

// Cargamos los markets y el paginador
$pagination = new Pagination($dbm->countRows());
$markets = $dbm->getMarkets($pagination->getOffsets());


?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>BitEx | Market Management</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
    <link rel="stylesheet" href="/bitex/resources/css/account.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>

    <script type="text/javascript">
    $( document ).ready(function() {
        $('#menu-item-markets').addClass('active');

        $('.confirm').click(function(e) {
            if (!confirm('Are you sure?')) {
                e.preventDefault();
            }
        });
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
                    <?php if(isset($ret['ERROR'])): ?>
                        <div class="alert alert-danger">
                            <?php echo $ret['ERROR']; ?>
                        </div>
                    <?php elseif(isset($ret['INFO'])): ?>
                        <div class="alert alert-success">
                            <?php echo $ret['INFO']; ?>
                        </div>
                    <?php endif; ?>
                    <form method="POST">
                        <fieldset class="form-group">
                            <legend>Add Market</legend>
                            <div class="form-group row">
                                <label for="symbol" class="col-sm-2 col-form-label">Symbol</label>
                                <div class="col-sm-4">
                                    <select name="symbol" class="custom-select">
                                        <?php foreach ($coins as $coin): ?>
                                            <option value="<?php echo $coin['symbol']; ?>"><?php echo $coin['symbol']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <hr/>
                            <button type="submit" class="btn btn-primary float-right" name="add_market">Add Market</button>
                        </fieldset>
                    </form>

                    <fieldset class="form-group">
                        <legend>Manage Market</legend>
                        <table id="pair-table" class="table table-borderless" >
                            <thead>
                                <tr>
                                    <th scope="col" onClick="alert('orderPair')">Symbol</th>
                                    <th scope="col">Market status</th>
                                    <th scope="col">Market actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($markets as $market): ?>
                                    <tr>
                                        <form method="POST">
                                            <input type="hidden" name="id" value="<?php echo $market['id']; ?>" />
                                            <td name="coin"><?php echo $market['symbol']; ?></td>
                                            <td name="market_status">
                                                <?php if($market['market_suspended']): ?>
                                                    <span class="badge badge-danger">Suspended</span>
                                                <?php else: ?>
                                                    <span class="badge badge-success">Open</span>
                                                <?php endif; ?>
                                            </td>
                                            <td name="volume" class="float-right">
                                                <?php if($market['market_suspended']): ?>
                                                    <button type="submit" class="btn btn-success confirm" name="resume_market">Resume</button>
                                                <?php else: ?>
                                                    <button type="submit" class="btn btn-danger confirm" name="suspend_market">Suspend</button>
                                                <?php endif; ?>
                                                <button type="submit" class="btn btn-primary confirm" name="remove_market">Remove</button>
                                            </td>
                                        </form>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        <?php $pagination->print(); ?>
                    </fieldset>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
