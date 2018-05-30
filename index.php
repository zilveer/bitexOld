<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>BitEx | Welcome</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
    <link rel="stylesheet" href="./resources/css/welcome.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
</head>
<body>
    <nav class="navbar navbar-expand-lg nav-dark bg-dark">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
            <span class="navbar-toggler-icon"></span>
        </button>
        <a class="navbar-brand" href="#">BitEx</a>

        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="navbar-nav ml-md-auto">
                <li class="nav-item">
                    <a class="nav-link" href="./exchange">Markets</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./user/register.php">Sign Up</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./user/login.php">Log In</a>
                </li>
            </ul>
        </div>

    </nav>
    <div class="scroll-wrapper" style="">
        <section class="section1">
        </section>
        <section class="section2"></section>
        <section class="section3"></section>
        <section class="section4"></section>
    </div>

    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-sm">
                    <h2>Exchange</h2>
                    <p><a class="" href="#">Privacy policy</a> | <a class="" href="#">FAQ</a> | <a class="" href="#">ToS</a></p>
                </div>
                <div class="col-sm">
                    <h2>Info</h2>
                    <p><a class="" href="#">About</a> | <a class="" href="#">Cookies</a> | <a class="" href="#">API Docs</a></p>
                    <p><a class="" href="#">Fees</a> | <a class="" href="#">Support</a> | <a class="" href="#">Contact</a></p>
                </div>
                <div class="col-sm">
                    <h2>Social</h2>
                    <p><a class="" href="#">Twitter</a> | <a class="" href="#">Facebook</a> | <a class="" href="#">Youtube</a></p>
                </div>
            </div>
        </div>
        <p><?php echo date('Y'); ?>BitEx, Inc ©</p>
    </footer>
</body>
</html>
