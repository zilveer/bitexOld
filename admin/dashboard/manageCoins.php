<?php
session_start();
// Comprobar si usuario esta logeado
if( !isset($_SESSION['sAdmin'])) {
    //header('Location: ../login.php');
}

require_once 'database.php';
require_once 'pagination.php';

// Instanciar
$dbc = new DatabaseAdministration('coins');
$pagination = new Pagination($dbc->countRows());


// Nueva moneda
if( isset($_POST['add_coin']) ) {
    $ret = $dbc->addCoin($_POST);
}

// Borrar moneda
if( isset($_POST['remove_coin']) ) {
    $ret = $dbc->removeCoin($_POST);
}

// Actualizar datos de moneda
if( isset($_POST['update_coin']) ) {
    $dbc->updateCoin($_POST);
}

echo '<pre>';
//print_r($coins);
echo '</pre>';

$coins = $dbc->getCoins($pagination->getOffsets());
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>BitEx | Coin Management</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
    <link rel="stylesheet" href="/bitex/resources/css/account.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
    <script type="text/javascript">
    $( document ).ready(function() {
        $('#menu-item-coins').addClass('active');

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
                            <legend>Add coin</legend>
                            <div class="form-group row">
                                <label for="staticEmail" class="col-sm-2 col-form-label">Symbol</label>
                                <div class="col-sm-4">
                                    <input type="text" name="symbol" class="form-control" value="">
                                </div>
                                <label for="staticEmail" class="col-sm-2 col-form-label">Name</label>
                                <div class="col-sm-4">
                                    <input type="text" name="name" class="form-control" value="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="staticEmail" class="col-sm-2 col-form-label">Min deposit</label>
                                <div class="col-sm-4">

                                    <input type="number" name="min_deposit" min="0.00000001" step="0.00000001" class="form-control" value="0.00000001">
                                </div>
                                <label for="staticEmail" class="col-sm-2 col-form-label">Min withdrawl</label>
                                <div class="col-sm-4">
                                    <input type="number" name="min_withdrawal" min="0.00000001" step="0.00000001" class="form-control" value="0.00000001">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="staticEmail" class="col-sm-2 col-form-label">Withdrawl fee</label>
                                <div class="col-sm-4">
                                    <input type="number" name="fee_withdrawal" min="0.00000001" step="0.00000001" class="form-control" value="0.00000001">
                                </div>
                            </div>
                            <hr/>
                            <button type="submit" class="btn btn-primary float-right" name="add_coin">Add new coin</button>
                        </fieldset>
                    </form>

                    <fieldset class="form-group">
                        <legend>Edit coins</legend>
                        <table id="pair-table" class="table table-borderless" >
                            <thead>
                                <tr>
                                    <th scope="col" onClick="alert('orderPair')">Symbol</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">M.Deposit</th>
                                    <th scope="col">M.Withdrawal</th>
                                    <th scope="col">Withdrawal fee</th>
                                    <th scope="col">Coin actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($coins as $v): ?>
                                    <tr class="">
                                        <form class="" action="" method="post">
                                            <input type="hidden" name="id" value="<?php echo $v['id']; ?>" />
                                            <td name="coin"><input type="text" name="symbol" class="form-control" value="<?php echo $v['symbol']; ?>"></td>
                                            <td name="price"><input type="text" name="name" class="form-control" value="<?php echo $v['name']; ?>"></td>
                                            <td name="change">
                                                <input type="number" name="min_deposit" min="0.00000001" step="0.00000001" class="form-control" value="<?php echo $v['min_deposit']; ?>">
                                            </td>
                                            <td name="volume">
                                                <input type="number" name="min_withdrawal" min="0.00000001" step="0.00000001" class="form-control" value="<?php echo $v['min_withdrawal']; ?>">
                                            </td>
                                            <td name="volume">
                                                <input type="number" name="fee_withdrawal" min="0.00000001" step="0.00000001" class="form-control" value="<?php echo $v['fee_withdrawal']; ?>">
                                            </td>
                                            <td name="volume" class="">
                                                <button type="submit" class="btn btn-primary btn-sm" name="update_coin">Update</button>
                                                <button type="submit" class="btn btn-danger btn-sm confirm" name="remove_coin">X</button>
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
