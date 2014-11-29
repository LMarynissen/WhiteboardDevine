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

</section>
<script type="text/javascript">
//MAAKT EEN JSON BESTAND VAN ALLE $ITEMS
          var items = <?php echo json_encode($items) ?>;
</script>
<script src="js/view.js"></script>