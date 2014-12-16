<section id="content">

    <?php if (!empty($_SESSION["user"])) {
	echo"<header><h1>Whiteboards</h1></header>";
     ?>

     <article class="addProjectDiv">
    <?php if (!empty($_SESSION["user"])) {
    	echo"<a class=\"addProject\" href=\"index.php?page=add\">Nieuw whiteboard</a>";
    } ?>
	</article>

	<article>
	<h2>Eigen whiteboards</h2>

	<?php if (!empty($projects) || !empty($invitedProjects)) {
		foreach ($projects as $project ) {
	    	echo "<li class=\"invited\"><a href=\"index.php?page=detail&amp;id={$project['id']}\"> {$project['title']} </a></li>";
		}
		echo "<h2>Samenwerkingen</h2>";
		foreach ($invitedProjects as $invitedProject ) {
	    	echo "<li class=\"invited\"><a href=\"index.php?page=detail&amp;id={$invitedProject['project_id']}\"> {$invitedProject['title']} </a></li>";
		}
	} else {
		echo "<p>Geen projecten</p>";
    }

    }else{
    	echo "<header><h2>";
    	echo "<p><a href=\"index.php?page=login\">Log in</a> om whiteboards aan te maken</p>";
        echo "</h2></header>";
    } 
    ?>
    </article>
    
</section>