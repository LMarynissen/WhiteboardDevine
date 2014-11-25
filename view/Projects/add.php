<?php if (empty($_SESSION["user"])) {
    header('Location: index.php?page=register');
    $_SESSION['error'] = "You need to be logged in to add a project";
    exit();
} ?>

<section id="content">
    <header><h1>Add a whiteboard</h1></header>
</section>