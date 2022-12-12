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
		
					$student_name = htmlspecialchars($_REQUEST['student_name'], ENT_QUOTES);
					$email = htmlspecialchars($_REQUEST['email'], ENT_QUOTES);
					$phone_number = htmlspecialchars($_REQUEST['phone_number'], ENT_QUOTES);
					
					if(!isset($_REQUEST['course'])) { $_REQUEST['course'] = "";}

					$course = htmlspecialchars($_REQUEST['course'], ENT_QUOTES); //might be unncessesary? Unsure if hackers can send whatever even if it's a dropdown box choice. 
					$lesson = htmlspecialchars($_REQUEST['lesson'], ENT_QUOTES);
					$problem = htmlspecialchars($_REQUEST['problem'], ENT_QUOTES);
					$details = htmlspecialchars($_REQUEST['details'], ENT_QUOTES);
					
					$username = htmlspecialchars($_SESSION['id'], ENT_QUOTES);//ditto, see line 33
					
				
					$sql = "INSERT INTO tickets VALUES (DEFAULT, '$student_name', '$email', '$phone_number','$course', '$lesson', '$problem', '$details', DEFAULT, '$username', DEFAULT)";		

					if(mysqli_query($db, $sql)){
							echo "<h2>Ticket Successfully Submitted</h2>";

							echo nl2br("Student Name: $student_name\nCourse: $course\n "
									. "Lesson Number: $lesson\n Problem Number: $problem\n Email (optional):$email");
									
							echo "<form action='submit_ticket.php'>";
							echo "<br><button class='biggr minibtn' type='submit' name='button' value=''>Back to Submit Tickets</button>";
							echo "</form>";
					} else{
							echo "<div class=\"red bold\">Invalid response, please try again.</div>";
					}
					 

					// Close connection
					mysqli_close($db);
                ?>
				
			</section>
		</div>
	</main>
</body>
</html>

