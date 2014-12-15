  <div class="goBack">
    <a href="index.php?page=index">Ga terug naar projecten</a>
  </div>

  <article class="project-view">
    <h1><?php echo $project["title"]; ?></h1>
    <h3><?php echo $project["description"]; ?></h3>
   </article>

  <div class="projectWindow">

  <?php if (!empty($items)) {

	} else {
		echo "<span><p>No stickies placed yet</p></span>";
    } ?>

  <section class="postitform">
      <header>
        <h1>Nieuwe sticky note</h1>
      </header>

  <section class="postitform-desc">
    <form action="index.php?page=addItem&amp;id=<?php echo $project['id']; ?>" method="post" class="form-horizontal" enctype="multipart/form-data">
        
        <div class="form-group<?php if(!empty($errors['title'])) echo ' has-error'; ?>">
            <label for="addTitle">Titel:</label>
            <div>
                <input type="text" name="title" accesskey="t" id="addTitle" value="<?php if(!empty($_POST['title'])) echo $_POST['title'];?>" />
                <span class="error-message"<?php if(empty($errors['title'])) echo 'style="display: none;"';?>><?php
                if(empty($errors['title'])) echo 'Please fill in a title';
                else echo $errors['title'];
                ?></span>
            </div>
        </div>

        <div class="form-group<?php if(!empty($errors['description'])) echo ' has-error'; ?>">
            <label for="addTitle">Tekst:</label>
            <div>
               <textarea type="text" name="description" accesskey="d" id="addDescription" value="<?php if(!empty($_POST['description'])) echo $_POST['description'];?>" ></textarea>
                <span class="error-message"<?php if(empty($errors['description'])) echo 'style="display: none;"';?>><?php
                if(empty($errors['description'])) echo 'Please fill in a description';
                else echo $errors['description'];
                ?></span>
            </div>
        </div>

        <div class="form-group<?php if(!empty($errors['color'])) echo ' has-error'; ?>">
            <label for="addTitle">Sticky note kleur:</label>
            <div>
                <input type="color" name="color" accesskey="c" id="addColor" value="<?php if(!empty($_POST['color'])) echo $_POST['color'];?>" />
                <span class="error-message"<?php if(empty($errors['color'])) echo 'style="display: none;"';?>><?php
                if(empty($errors['color'])) echo 'Please fill in a color';
                else echo $errors['color'];
                ?></span>
            </div>
        </div>

        <div class="form-group<?php if(!empty($errors['description'])) echo ' has-error'; ?>">
            <label for="addImage">Afbeelding/Video:</label>
            <div>
                <input type="file" name="content" id="addImage" value="<?php if(!empty($_POST['content'])) echo $_POST['content'];?>" />
                <span class="error-message"<?php if(empty($errors['content'])) echo 'style="display: none;"';?>><?php
                if(empty($errors['content'])) echo 'Please select an content';
                else echo $errors['content'];
                ?></span>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm"><input type="submit" value="Add sticky note" class="btn btn-default"></div>
        </div>
    </form>
    </section>
    
    <form action="index.php?page=invitePerson&amp;id=<?php echo $project['id']; ?>" method="post" class="form-horizontal" enctype="multipart/form-data">
        <header>
          <h1>Iemand uitnodigen</h1>
        </header>

        <div class="form-group<?php if(!empty($errors['email'])) echo ' has-error'; ?>">
            <label for="addEmail">Email address:</label>
            <div>
                <input type="email" name="email" accesskey="t" id="addEmail" value="<?php if(!empty($_POST['email'])) echo $_POST['email'];?>" />
                <span class="error-message"<?php if(empty($errors['email'])) echo 'style="display: none;"';?>><?php
                if(empty($errors['email'])) echo 'Please fill in a email';
                else echo $errors['email'];
                ?></span>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm"><input type="submit" value="Uitnodigen" class="btn btn-default"></div>
        </div>

        <br />
        <p>Project aangemaakt door:</p>
        <p><?php echo $creatorEmail; ?></p>
        <br />
        <p>Uitgenodigden:</p>
        <ul>
        <?php 
          if (!empty($inviteds)) {

          foreach ($inviteds as $invite ) {
            echo "<li>{$invite['email']}<a class=\"userDeleteButton\" href=\"index.php?page=deleteUser&amp;user_id={$invite["user_id"]}&amp;project_id={$project["id"]}\">x</a></li>";
          }
        }else{
            echo "<li>Je hebt nog niemand uitgenodigd voor dit project</li>"; 
        }
        ?>
        </ul>
        <br />

    </form>
     <?php 
    echo "<div class=\"deleteProject\">";
    echo "<a class=\"deleteProjectButton\" href=\"index.php?page=delete&amp;id={$project["id"]}\" >Verwijder dit project</a>";
    echo "</div>";
  ?>
    </section>



<script type="text/javascript">
//MAAKT EEN JSON BESTAND VAN ALLE $ITEMS
          var items = <?php echo json_encode($items) ?>;
          var itemCreators = <?php echo json_encode($itemCreators) ?>;
</script>
<script src="js/view.js"></script>
<script src="js/ajaxDeleteItem.js"></script>
