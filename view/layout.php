<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Whiteboard</title>
        <link href="css/screen.css" rel="stylesheet">
    </head>
    <body>
        <script src="js/vendor/jquery.1.11.0.min.js"></script>
        <nav role="navigation">
            <div class="container">
                <ul>
                    <li class= "schreef"><a href="index.php">Whiteboard</a></li>
                    <div class = "line"></div>
                    <?php if (empty($_SESSION["user"])) { ?>
                    <ul class= "right-regi">
                    <li class ="sans" ><a href="index.php?page=login">login</a></li>
                    <li class = "sans" ><a href="index.php?page=register">Register</a></li>
                    </ul>
                    <?php } else { ?>
                </ul>
                <ul class = "right">
                    <li class="sans"><p>Signed in as <?php echo $_SESSION['user']['email'];?></p> 
                    - <a href="index.php?page=logout">Logout</a></li>
                    <?php } ?>
                </ul> 
            </div>
        </nav>

        <div>
            <?php if(!empty($_SESSION['info'])): ?><div class="alert alert-success"><?php echo $_SESSION['info'];?></div><?php endif; ?>
            <?php if(!empty($_SESSION['error'])): ?><div class="alert alert-danger"><?php echo $_SESSION['error'];?></div><?php endif; ?>
            <?php echo $content; ?>
        </div>

        <script src="js/app.js"></script>
    </body>
</html>