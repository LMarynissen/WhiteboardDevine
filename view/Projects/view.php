<section id="content">

  <h1><?php echo $project["title"]; ?></h1>
  <h3><?php echo $project["description"]; ?></h3>

  <?php 
  echo "<a href=\"index.php?page=delete&amp;id={$project["id"]}\" >Delete this project</a>";
  ?>

  <div class="projectWindow">
  	<div class="stickyNote">
  		<h3 class="stickyTitle"></h3>
  		<div class="stickyContent"></div>

		<button class="stickyDeleteButton"></button>
  	</div>	
  </div>

</section>