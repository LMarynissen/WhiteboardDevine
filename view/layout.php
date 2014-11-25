<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Whiteboard</title>
        <link href="css/screen.css" rel="stylesheet">
    </head>
    <body>

        <nav role="navigation">
            <div class="container">
                <ul>
                    <li><a href="index.php">Overview</a></li>

                    <?php if (empty($_SESSION["user"])) { ?>
                    <li><a href="index.php?page=login">login</a></li>
                    <li><a href="index.php?page=register">Register</a></li>
                    <?php } else { ?>

                    <p>Signed in as <?php echo $_SESSION['user']['email'];?> - <a href="index.php?page=logout">Logout</a></p>
                    <?php } ?>
                    </ul>
            </div>
        </nav>

        <div>
            <?php if(!empty($_SESSION['info'])): ?><div class="alert alert-success"><?php echo $_SESSION['info'];?></div><?php endif; ?>
            <?php if(!empty($_SESSION['error'])): ?><div class="alert alert-danger"><?php echo $_SESSION['error'];?></div><?php endif; ?>
            <?php echo $content; ?>
        </div>

        <script src="js/vendor/jquery.1.11.0.min.js"></script>
        <script src="js/app.js"></script>
    </body>
</html>