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
					$newStatus = htmlspecialchars($_REQUEST['newStatus'], ENT_QUOTES);
					$username = htmlspecialchars($_SESSION['id'], ENT_QUOTES);
					
					//note_id, ticket_id, note, submitted_by, created_at
					
					$updateStatus = "UPDATE tickets SET status = '$newStatus' WHERE ticket_id = $ticket_id";
					if(mysqli_query($db, $updateStatus)){
						//echo "<h2>Status Successfully Updated</h2>";
						//echo nl2br("Ticket ID: $ticket_id\nStatus: $newStatus\n");
						header("location:manage_tickets.php");
					}else{
						echo "<div class=\"red bold\">Invalid response, please try again.</div>";
					}

					
					if($newStatus == "Closed"){
						echo $append = 'Ticket Closed.';
					} else if($newStatus == "Canceled"){
						echo $append = 'Ticket Canceled.';
					}
					
					$noteRowNote = '';
					$noteRow = array();
					$getRecentNoteQuery = "SELECT * FROM notes INNER JOIN users ON notes.submitted_by=users.user_id WHERE ticket_id = " . $ticket_id . " ORDER BY created_at DESC LIMIT 1";
					
					
					$noteString = "";
					if($notes = mysqli_query($db, $getRecentNoteQuery)){
						if(mysqli_num_rows($notes) > 0){
							
							$note = mysqli_fetch_array($notes);
							$date = date_create_from_format('Y-m-d H:i:s', $note['created_at']);
							
							$noteString = $noteString . $note['note'] . " | Note submitted by:" . ucfirst($_SESSION['username']) . " on " . $date->format('M d Y ') . "at" . $date->format(' g:i a');
							
							echo $noteString;
							
						}
					}else{
						echo "<div class=\"red bold\">Invalid response, please try again.</div>";
					}
					
					// "Ticket Closed. by $username AT date at time.\n';
					$append = $noteString . "\n" . $append;
					
					$updateStatusNote = "INSERT INTO notes VALUES (DEFAULT, '$ticket_id', '$append', '$username', DEFAULT) ";
					
					if(mysqli_query($db, $updateStatusNote)){
						header("location:manage_tickets.php");
					}else{
						echo "<div class=\"red bold\">Invalid response, please try again.</div>";
					}
					
					mysqli_close($db);
                ?>
				
		</section>
		</div>
	</main>
</body>
</html>

