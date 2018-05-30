<?php
session_start();

// Comprobar si usuario esta logeado
if( !isset($_SESSION['sAdmin'])) {
    header('Location: ../login.php');
}


?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>BitEx | My account</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
    <link rel="stylesheet" href="/bitex/resources/css/account.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
    <script type="text/javascript">
    $( document ).ready(function() {
        $('#account').addClass('active');
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


                    <form>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Email address</label>
                            <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
                            <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Password</label>
                            <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="exampleCheck1">
                            <label class="form-check-label" for="exampleCheck1">Check me out</label>
                        </div>
                        <hr/>
                        <input type="text" name="x" value="xxx">
                        <button type="submit" class="btn btn-primary">Update</button>
                        <?php echo $_SESSION['session']['mail']; ?>
                        <span class="badge badge-success">Verified</span>
                        <span class="badge badge-secondary">Unverified</span>
                        Daily withdrawal limit 1BTC
                        Use BTX for fees
                        change password
                        Last login Time: 2018-05-25 09:42:30    IP: 37.11.147.112
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
