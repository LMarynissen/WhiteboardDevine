<section id="content">
	<header><h1>Your Projects</h1></header>


	<?php if (!empty($projects)) {
		foreach ($projects as $project ) {
	    	echo "<a href=\"index.php?page=detail&amp;id={$project['id']}\"> {$project['title']} </a>";
		}
	} else {
		echo "<p>No projects</p>";
    } ?>
    
    <?php if (!empty($_SESSION["user"])) {
    	echo"<li><a href=\"index.php?page=add\">Add a project</a></li>";
    } ?>

</section>