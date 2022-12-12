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
			<a class="navsprite cs" title="Tutor Ticket Login" href="index.php"></a><span> Submit Tutor Ticket</span>
		</nav>

		
		<section class="parentinfo">
		<form name"create_tutor_ticket" action="action_submit_ticket.php" method="POST">
				<h2>Student Information:</h2>
					<input type="text" name="student_name" placeholder="Student's Name" action="" required ><br>
					<input type="email" name="email" placeholder="Email"  action=""><br>
					<input type="tel" name="phone_number" placeholder="Phone Number"  action=">"><br>
		</section>
		<section class="parentinfo">
				<h2>Course Details:</h2>
					<select name="course">
						<option disabled selected value>Select Course</option>
						<option value="Math 3">Math 3</option>
						<option value="Math 4 ">Math 4</option>
						<option value="Math 5">Math 5</option>
						<option value="Math 6">Math 6</option>
						<option value="Math 7">Math 7</option>
						<option value="Pre-Algebra">Pre-Algebra</option>
						<option value="Algebra 1">Algebra 1</option>
						<option value="Algebra 2">Algebra 2</option>
						<option value="Geometry">Geometry</option>
						<option value="Pre-Calculus">Pre-Calculus</option>
					</select><br>
					<input type="text" name="lesson" placeholder="Lesson"  action="" ><br>
					<input type="text" name="problem" placeholder="Problem"  action=""><br>
		</section>
		<section class="parentinfo">
					<h3>Extra Details</h3>
					<p>If you are not able to fill out the lesson and/or problem field, you must fill in a description of help required by the student.</p>
					<textarea name="details" rows="10" cols="50" action=""></textarea><br>
					
		<br><button type="submit" name="submit">Submit Ticket</button>
		</section>
		</form>
	</main>
</body>
</html>


