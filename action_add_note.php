<!--Adds notes or updates the status. Uses direct db access.-->
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta charset="utf-8" />
    <title>Create Tutor Ticket</title>
    <link rel="stylesheet" href="css/styles.css">
<link rel="icon" href="/img/favicon-16x16.png" type="image/png">
</head>

<body>
<header>
	<?php include 'header.php';?>
</header>

	 <main>
		<nav class="crum c2">
			<a class="navsprite cs" title="Tutor Ticket Login" href="http://172.16.1.219/index.php"></a> > <span>Tutor Tickets</span>
		</nav>

		<div>
		<section class="parentinfo">
                <?php
					require_once "config.php";

					
					$ticket_id = htmlspecialchars($_REQUEST['button'], ENT_QUOTES);				
					$details = htmlspecialchars($_REQUEST['details'], ENT_QUOTES);
					$username = htmlspecialchars($_SESSION['id'], ENT_QUOTES);
					
					//note_id, ticket_id, note, submitted_by, created_at
					
					$insertNote = "INSERT INTO notes VALUES (DEFAULT, '$ticket_id', '$details', '$username', DEFAULT) ";
					
					if ($details != null OR $details != ""){
						if(mysqli_query($db, $insertNote)){
							echo "<h2>Note Successfully Submitted</h2>";
							echo nl2br("Ticket ID: $ticket_id\nNotes: $details");
							echo "<form action='manage_tickets.php'>";
							echo "<br><button class='biggr minibtn' type='submit' name='button' value=''>Back to Manage Tickets</button>";
							echo "</form>";
						}else{
							echo "<div class=\"red bold\">Invalid response, please try again.</div>";
						}
					}else{
						 echo "<div class=\"red bold\">Empty response, please try again.</div>";
					}
					
					// Close connection
					mysqli_close($db);
                ?>
			</section>
		</div>
	</main>
</body>
</html>

