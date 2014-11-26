<?php if (empty($_SESSION["user"])) {
    header('Location: index.php?page=register');
    $_SESSION['error'] = "You need to be logged in to add a project";
    exit();
} ?>

<section id="content">
    <header><h1>Add a whiteboard</h1></header>

    <form action="index.php?page=add" method="post" enctype="multipart/form-data">
        <div class="<?php if(!empty($errors['project'])) echo ' has-error'; ?>">
            <div>
                <label for="titleInput">Title:</label>
                <input type="text" name="title" id="titleInput" placeholder="<?php if(!empty($_POST['title'])) echo $_POST['title'];?>" />
                <span class="error-message"<?php if(empty($errors['title'])) echo 'style="display: none;"';?>><?php
                if(empty($errors['title'])) echo 'Please fill in a title';
                else echo $errors['title'];
                ?></span>

                <label for="DescriptionInput">Description:</label>
                <input type="text" name="description" id="descriptionInput" placeholder="<?php if(!empty($_POST['description'])) echo $_POST['description'];?>" />
                <span class="error-message"<?php if(empty($errors['description'])) echo 'style="display: none;"';?>><?php
                if(empty($errors['description'])) echo 'Please fill in a description';
                else echo $errors['description'];
                ?></span>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10"><input type="submit" value="Create Project" class="btn btn-default"></div>
        </div>
    </form>

</section>
