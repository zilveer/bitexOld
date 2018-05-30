<?php
session_start();

// Comprobar si el usuario ya esta logeado
if( isset($_SESSION['session']) ) {
    if( $_SESSION['session']['userLoggedIn'] ) {
        header('Location: /bitex/exchange');
    }
}

try {
    // Si introdujo email y password ...
    if( !empty($_POST['mail']) && !empty($_POST['password']) && !empty($_POST['password2']) ) {
        $mail = filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL);
        $pass = filter_var($_POST['password'], FILTER_SANITIZE_STRING);
        $pass2 = filter_var($_POST['password2'], FILTER_SANITIZE_STRING);

        if ( $mail === false || $pass === false || $pass2 === false) {
            throw new Exception('Sorry we couldn\'t verify your credentials');
        }

        if (strcmp($pass, $pass2) !== 0) {
            throw new Exception('The password are not the same');
        }

        require_once 'user.php';
        $user = new User(); // 123456
        $hash = $user->getHash($pass);
        $user->insert( array('mail' =>  $mail, 'password' => $hash) );

        // hubo un error
        if ( !empty($user->db->error) ) {
            if (strpos($user->db->error, 'Duplicate') !== false) {
                throw new Exception('The email is already in use.');
            }
        }

        // Si la cuenta fue creada
        if ( $user->db->affected_rows == 1 ) {
            $SUCCESS_MESSAGE = 'Account successfully created.';
        }

        //echo '<pre>';
        //print_r($user);
        //echo '</pre>';
    } else {
        throw new Exception('All fields are required.');
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
    <title>BitEx | Sign Up</title>
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
                <?php if( !empty($ERROR_MESSAGE) ): ?>
                    <div class="alert alert-danger">
                        <strong><?php echo $ERROR_MESSAGE; ?></strong>
                    </div>
                <?php elseif( !empty($SUCCESS_MESSAGE) ): ?>
                    <div class="alert alert-success">
                        <strong><?php echo $SUCCESS_MESSAGE; ?></strong>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="account-wall">
            <form class="form-signin" method="POST">
                <input type="text" name="mail" class="form-control" placeholder="Your email" required autofocus>
                <input type="password" name="password" class="form-control" placeholder="Your password" required>
                <input type="password" name="password2" class="form-control" placeholder="Repeat your password" required>
                <button class="btn btn-primary btn-block" name="login" type="submit">Sign up</button>
            </form>
        </div>
    </div>
</body>
</html>
