<section id="content">

  <h1><?php echo $project["title"]; ?></h1>
  <h3><?php echo $project["description"]; ?></h3>

  <?php 
  echo "<a href=\"index.php?page=delete&amp;id={$project["id"]}\" >Delete this project</a>";
  ?>

  <div class="projectWindow">

  <?php if (!empty($items)) {


		foreach ($items as $item ) {
	    	//echo "<a href=\"index.php?page=detail&amp;id={$project['id']}\"> {$project['title']} </a>";
	    /*	echo "  	
	    		<div class=\"stickyNote\" posX=\"{$item['posX']}\" posY=\"{$item['posY']}\" style=\"left:{$item['posX']}px; top:{$item['posY']}px; \">
  					<h3 class=\"stickyTitle\">{$item['title']}</h3>
  					<h4 class=\"stickyTitle\">{$item['description']}</h4>
  					<div class=\"stickyContent\" style=\"background-image: url('images/{$item['contentlink']}_th.{$item['extension']}');\"></div>
					<button class=\"stickyDeleteButton\">Delete</button>
  				</div>	
  				";
  		*/
		}
	} else {
		echo "<p>No stickies placed yet</p>";
    } ?>

  <section class="postitform">
	<form action="index.php?page=addItem&amp;id=<?php echo $project['id']; ?>" method="post" class="form-horizontal" enctype="multipart/form-data">
        <header>
          <h1>New sticky note</h1>
        </header>

        <div class="form-group<?php if(!empty($errors['title'])) echo ' has-error'; ?>">
            <label for="addTitle">Title:</label>
            <div>
                <input type="text" name="title" accesskey="t" id="addTitle" value="<?php if(!empty($_POST['title'])) echo $_POST['title'];?>" />
                <span class="error-message"<?php if(empty($errors['title'])) echo 'style="display: none;"';?>><?php
                if(empty($errors['title'])) echo 'Please fill in a title';
                else echo $errors['title'];
                ?></span>
            </div>
        </div>

        <div class="form-group<?php if(!empty($errors['description'])) echo ' has-error'; ?>">
            <label for="addTitle">Description:</label>
            <div>
                <input type="text" name="description" accesskey="d" id="addDescription" value="<?php if(!empty($_POST['description'])) echo $_POST['description'];?>" />
                <span class="error-message"<?php if(empty($errors['description'])) echo 'style="display: none;"';?>><?php
                if(empty($errors['description'])) echo 'Please fill in a description';
                else echo $errors['description'];
                ?></span>
            </div>
        </div>

        <div class="form-group<?php if(!empty($errors['color'])) echo ' has-error'; ?>">
            <label for="addTitle">Background Color:</label>
            <div>
                <input type="color" name="color" accesskey="c" id="addColor" value="<?php if(!empty($_POST['color'])) echo $_POST['color'];?>" />
                <span class="error-message"<?php if(empty($errors['color'])) echo 'style="display: none;"';?>><?php
                if(empty($errors['color'])) echo 'Please fill in a color';
                else echo $errors['color'];
                ?></span>
            </div>
        </div>

        <div class="form-group<?php if(!empty($errors['description'])) echo ' has-error'; ?>">
            <label for="addImage">Image:</label>
            <div>
                <input type="file" name="image" id="addImage" value="<?php if(!empty($_POST['image'])) echo $_POST['image'];?>" />
                <span class="error-message"<?php if(empty($errors['image'])) echo 'style="display: none;"';?>><?php
                if(empty($errors['image'])) echo 'Please select an image';
                else echo $errors['image'];
                ?></span>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10"><input type="submit" value="Add sticky note" class="btn btn-default"></div>
        </div>
    </form>
    </section>


</section>
<script type="text/javascript">
//MAAKT EEN JSON BESTAND VAN ALLE $ITEMS
          var items = <?php echo json_encode($items) ?>;
</script>
<script src="js/view.js"></script>
<script src="js/ajaxDeleteItem.js"></script>