<section id="content">

    <?php if (!empty($_SESSION["user"])) {
	echo"<header><h1>Your Projects</h1></header>";
     ?>


	<?php if (!empty($projects) || !empty($invitedProjects)) {
		foreach ($projects as $project ) {
	    	echo "<a href=\"index.php?page=detail&amp;id={$project['id']}\"> {$project['title']} </a>";
		}
		foreach ($invitedProjects as $invitedProject ) {
	    	echo "<a href=\"index.php?page=detail&amp;id={$invitedProject['project_id']}\"> {$invitedProject['title']} </a>";
		}
	} else {
		echo "<p>Geen projecten</p>";
    }

    }else{
    	echo "<p>Log in om projecten te maken</p>";
    } 
    ?>

    
    <?php if (!empty($_SESSION["user"])) {
    	echo"<li><a href=\"index.php?page=add\">Add a project</a></li>";
    } ?>


</section>