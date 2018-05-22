<?php
session_start();
// Comprobar si usuario esta logeado
if( !isset($_SESSION['sAdmin'])) {
    //header('Location: ../login.php');
}

require_once 'database.php';
require_once 'pagination.php';

// Database
$dbm = new DatabaseAdministration('markets');
$dbc = new DatabaseAdministration('coins');
$dbp = new DatabaseAdministration('pairs');
$coins = $dbc->getCoins();
$markets = $dbm->getMarkets();

// Add pair
if( isset($_POST['add_pair']) ) {
    $ret = $dbp->addPair($_POST);
}

// Remove pair
if( isset($_POST['remove_pair']) ) {
    $ret = $dbp->removePair($_POST['id']);
}

// Resume pair
if( isset($_POST['resume_pair']) ) {
    $ret = $dbp->updatePair($_POST['id'], 0);
}

// Suspend
if( isset($_POST['suspend_pair']) ) {
    $ret = $dbp->updatePair($_POST['id'], 1);
}

// Paginacion
$pagination = new Pagination($dbp->countRows());
$pairs = $dbp->getPairs($pagination->getOffsets());
//echo '<pre>';
//print_r($_POST);
//echo '</pre>';

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>BitEx | Pair Management</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
    <link rel="stylesheet" href="/bitex/resources/css/account.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
    <script type="text/javascript">
    $( document ).ready(function() {
        $('#menu-item-pairs').addClass('active');

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
                    <fieldset class="form-group">
                        <form method="POST">
                            <legend>Add pair</legend>
                            <div class="form-group row">
                                <div class="col-sm-6">
                                    <label for="symbol" class="col-sm-2 col-form-label">Coin</label>
                                    <select name="coin" class="custom-select">
                                        <?php foreach ($coins as $coin): ?>
                                            <option value="<?php echo $coin['symbol']; ?>"><?php echo $coin['symbol']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="col-sm-6">
                                    <label for="symbol" class="col-sm-2 col-form-label">Market</label>
                                    <select name="market" class="custom-select">
                                        <?php foreach ($markets as $market): ?>
                                            <option value="<?php echo $market['symbol']; ?>"><?php echo $market['symbol']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <hr/>
                            <button type="submit" class="btn btn-primary float-right" name="add_pair">Add pair</button>
                        </form>
                    </fieldset>

                    <fieldset class="form-group">
                        <legend>Manage Pairs</legend>
                        <table id="pair-table" class="table table-borderless" >
                            <thead>
                                <tr>
                                    <th scope="col" onClick="alert('orderPair')">Pair</th>
                                    <th scope="col">Pair status</th>
                                    <th scope="col">24h Volume</th>
                                    <th scope="col">Pair actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($pairs as $pair): ?>
                                    <tr>
                                        <form method="POST">
                                            <input type="hidden" name="id" value="<?php echo $pair['id']; ?>" />
                                            <td name="pair"><?php echo $pair['coin'] . "/" . $pair['market']; ?></td>
                                            <td name="pair_status">
                                                <?php if($pair['pair_suspended']): ?>
                                                    <span class="badge badge-danger">Suspended</span>
                                                <?php else: ?>
                                                    <span class="badge badge-success">Open</span>
                                                <?php endif; ?>
                                            </td>
                                            <td name="">
                                                volume
                                            </td>
                                            <td name="" class="float-right">
                                                <?php if($pair['pair_suspended']): ?>
                                                    <button type="submit" class="btn btn-success confirm" name="resume_pair">Resume</button>
                                                <?php else: ?>
                                                    <button type="submit" class="btn btn-danger confirm" name="suspend_pair">Suspend</button>
                                                <?php endif; ?>
                                                <button type="submit" class="btn btn-primary confirm" name="remove_pair">Remove</button>
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
