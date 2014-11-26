<section id="content">
    <header><h1 class= "sans" >Registreren</h1></header>
    <form action="index.php?page=register" method="post" >
        <div class="<?php if(!empty($errors['email'])) echo ' has-error'; ?>">
            <label for="registerEmail">Email:</label>
            <div>
                <input type="email" name="email" id="registerEmail" value="<?php if(!empty($_POST['email'])) echo $_POST['email'];?>" />
                <?php if(!empty($errors['email'])) echo '<span class="error-message">' . $errors['email'] . '</span>'; ?>
            </div>
        </div>
        <div class="<?php if(!empty($errors['password'])) echo ' has-error'; ?>">
            <label for="registerPassword">Password:</label>
            <div>
                <input type="password" name="password" id="registerPassword" />
                <?php if(!empty($errors['password'])) echo '<span class="error-message">' . $errors['password'] . '</span>'; ?>
            </div>
        </div>
        <div class="<?php if(!empty($errors['confirm_password'])) echo ' has-error'; ?>">
            <label for="registerConfirmPassword">Confirm Password:</label>
            <div>
                <input type="password" name="confirm_password" id="registerConfirmPassword" />
                <?php if(!empty($errors['confirm_password'])) echo '<span class="error-message">' . $errors['confirm_password'] . '</span>'; ?>
            </div>
        </div>
        <div>
            <div><input type="submit" value="register"></div>
        </div>
    </form>
</section>