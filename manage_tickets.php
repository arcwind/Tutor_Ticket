<!--Experiments by Aaron starting from Lea Ann, Attempt 2-->
<!DOCTYPE html>

<html lang="en" xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta charset="utf-8" >
    <title>Manage Tutor Tickets</title>
    <link rel="stylesheet" href="css/styles.css">	
	<link rel="icon" href="/img/favicon-16x16.png" type="image/png">
</head>

<body>
<header>
<?php include 'header.php';?>
 </header>

<main>
	<nav class="crum c2"><a class="navsprite cs" title="Tutor Ticket Login" href="index.php"></a> > <span>Manage Tutor Ticket</span></nav>
	
<section class="tutor">
<?php 

	require_once "config.php";

	$numOfRowsQuery = "SELECT COUNT(ticket_id) FROM tickets";
	
	$count = 0;
	$total_pages = "5";
	
	if($numOfRowsResult = mysqli_query($db, $numOfRowsQuery)){
		$count =  mysqli_fetch_array($numOfRowsResult)[0];
	}
	
	if(isset($_GET['page'])) {
		$page = $_GET['page'];
	} else {
		// set proper default value if it was not set
		$page = 1;
	}

    if (!$page) {
		$pc = 1;
    } else {
		$pc = $page;
    }
	
	$begin = $pc - 1;	
	$begin = $begin * $total_pages;
	
	$sql = 'SELECT ticket_id, student_name, email, phone_number, course, lesson, problem, details, status, created_at, username FROM tickets INNER JOIN users ON tickets.created_by=users.user_id ORDER BY created_at DESC';
	
	$pagesNeeded = $count / $total_pages;	
	
	if($result = mysqli_query($db, $sql . ' LIMIT ' . $begin .','. $total_pages)){
		$i = 0;
		if(mysqli_num_rows($result) > 0){ //safety check
			while($row = mysqli_fetch_array($result)){
				//tab info
				echo "<div class='container'>";
					echo "<label for='chk-" . $i . "'><input id='chk-" . $i . "' type='checkbox' >";
						echo "<div class='title'>";
							echo "<span class='tab125'>Ticket ID: " . $row['ticket_id'] . "</span>";
							echo "<span class='tab150'>" . $row['student_name'] . "</span>";
							echo "<span class='tab125'>" . $row['phone_number'] . "</span>";
							$date = date_create_from_format('Y-m-d H:i:s', $row['created_at']);
							echo "<span class='tab225'>" . $date->format('M d Y ') . "at" . $date->format(' g:i a') . "</span>";
							echo "<span class='tab100'>" . $row['status'] . "</span>";
							echo "<span class='tab200'>Submitted By: " . ucfirst($row['username']) . "</span>";
						echo "</div>";
						
						echo "<div class='content'>";
							echo "<div class='wrapper'>";
								echo "<div class='heading'>Ticket Information</div>";
									echo "<div class='main'>";
										echo "<span class='item'>Math Level:" . $row['course'] . "</span>";
										echo "<span class='item'>Lesson:" . $row['lesson'] . "</span>";
										echo "<span class='item'>Problem:" . $row['problem'] . "</span>";
										echo "<span class='item'>Notes:" . $row['details'] . "</span>";
									echo "</div>";
									echo "<aside class='aside aside-1'>";
										echo "<span class='item'>Ticket ID:" . $row['ticket_id'] . "</span>";
										echo "<span class='item'>Name:" . $row['student_name'] ."</span>";
										echo "<span class='item'>Email:" . $row['email'] . "</span>";
										echo "<span class='item'>Phone:" . $row['phone_number'] . "</span>";
									echo "</aside>";
									echo "<aside class='aside aside-2'>";
										echo "<form name=\"add_note\" action=\"action_update_status.php\" method=\"POST\">";
										echo "<h4>Ticket Status</h4>";
											echo "<select name=\"newStatus\" class=\"newstatus\">";
											echo "<option value=\"New\" "; 
												if($row['status'] == 'New') {echo "selected=\"selected\" ";}
											echo ">New</option>";
									
											echo "<option value=\"Closed\" "; 
												if($row['status'] == 'Closed') {echo "selected=\"selected\" ";}
											echo ">Closed</option>";
									
											echo "<option value=\"Active\" "; 
												if($row['status'] == 'Active') {echo "selected=\"selected\" ";}
											echo ">Active</option>";

											echo "<option value=\"Hold\" "; 
												if($row['status'] == 'Hold') {echo "selected=\"selected\" ";}
											echo ">Hold</option>";

											echo "<option value=\"Canceled\" "; 
												if($row['status'] == 'Canceled') {echo "selected=\"selected\" ";}
											echo ">Canceled</option>";
									
											echo "</select><br>";

											echo "<button class='biggr minibtn' type=\"submit\" name = \"button\" value=\"" . $row['ticket_id'] . "\">Update Ticket</button>";

										echo "</form>";
									echo "</aside>";
									
									echo "</div>";	
									echo "<div class='footer'>";
										
										//Second db call to get only the most recent note
										$getNotes = "SELECT * FROM notes INNER JOIN users ON notes.submitted_by=users.user_id WHERE ticket_id = " . $row['ticket_id'] . " ORDER BY created_at DESC LIMIT 1";
										
										$noteString = "";
										if($noteResults = mysqli_query($db, $getNotes)){
											if(mysqli_num_rows($noteResults) > 0){
												while($noteRow = mysqli_fetch_array($noteResults)){
													
														$date = date_create_from_format('Y-m-d H:i:s', $noteRow['created_at']);
													echo "<span class='tab225'>" . $date->format('M d Y ') . "at" . $date->format(' g:i a') . "</span>";
													$noteString = $noteString . $noteRow['note'] . " | Submitted by:" . ucfirst($_SESSION['username']) . " on " . $date->format('M d Y ') . "at" . $date->format(' g:i a'). "\n";
												}
											}
										}
										
										//puts most recent note in the textbox. You can append/modify and send again.
										echo "<form name='update_tutor_ticket' action='action_add_note.php' method='POST'>";
											echo "<span class='item'>Private Notes:</span>";
											echo "<textarea name='details' class='private_note' value='details' required>". $noteString . "</textarea><br>";
											echo "<button class='biggr minibtn' type='submit' name='button' value='" . $row['ticket_id'] . "'>Submit Notes</button>";
										echo "</form>";										
							echo "</div>";
						echo "</div>";
					echo "</label>";
				echo "</div>";
				$i++;
			}
			mysqli_free_result($result);
		}
	}
	
	$previous = $pc -1;
	$next = $pc +1;
	
	if ($pc>1) {
		echo " <a href='?page=$previous'><button class='biggr minibtn prev' type='submit'>Previous</button></a> ";
	}else{
		echo " <button class='' type='submit'></button></a> ";//adding spacing when no previous button
	}
	if ($pc<$pagesNeeded) {
		echo " <a href='?page=$next'><button class='biggr minibtn next' type='submit'>Next</button></a>";//could not ge this to work with form action

	}	
	
?>
</section>
</main>
</body>
</html>
