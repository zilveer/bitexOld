<?php
session_start();
define('USER', 'admin7');
define('PASS', 'admin7');

// Comprobar si el usuario ya esta logeado
if( isset($_SESSION['sAdmin']) ) {
    header('Location: dashboard/');
}

try {
    // Si introdujo email y password ...
    if( !empty($_POST['email']) && !empty($_POST['password'])) {
        $mail = filter_var($_POST['email'], FILTER_SANITIZE_STRING);
        $pass = filter_var($_POST['password'], FILTER_SANITIZE_STRING);

        if ( $mail === false || $pass === false) {
            throw new Exception('Sorry we couldn\'t verify your credentials');
        }

        if ( strcmp($mail, USER) !== 0 && strcmp($pass, PASS) !== 0 ) {
            throw new Exception('Invalid credentials');
        }

        $sessData['userLoggedIn'] = true;
        $sessData['userID'] = $userData['id'];
        $sessData['mail'] = $userData['mail'];
        $sessData['banned'] = false;
        $_SESSION['sAdmin'] = $sessData;

        header('Location: dashboard/');
    }
} catch (Exception $e) {
    $ERROR_MESSAGE = $e->getMessage();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>BitEx | Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
    <link rel="stylesheet" href="/bitex/resources/css/login.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
</head>
<body>
    <p>&nbsp;</p>
    <div class="container">
        <div class="row">
            <div class="col-sm">
                <?php if( isset($ERROR_MESSAGE) ): ?>
                    <div class="alert alert-danger">
                        <strong><?php echo $ERROR_MESSAGE; ?></strong>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="account-wall">
            <form class="form-signin" method="POST">
                <input type="text" name="email" class="form-control" placeholder="email" required autofocus>
                <input type="password" name="password" class="form-control" placeholder="password" required>
                <button class="btn btn-primary btn-block" name="login" type="submit">Sign in</button>
            </form>
        </div>
    </div>

</body>
</html>
