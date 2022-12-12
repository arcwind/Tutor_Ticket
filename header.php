<?php
 session_start();
if (isset($_SESSION['authorized']) && $_SESSION['authorized'] === TRUE) {
} else {
    // User is not authorized!
    header('Location: index.php');
    exit();
}?>

<p><a class="homebtn" href="/">TTHQ</a></p>
<article>
	<p>You are logged in as</p>
	
	<?php 
		echo "<h4>" . ucfirst($_SESSION['username']) . "</h4>";
	?>
	
	<!-- <p><button title="My Profile" class="hlink" data-url="/user/" type="button">my profile</button></p> -->
	<form method="post" action="logout.php">
			<input type="hidden" name="todo" value="logout" />
			<p><button type="submit" title="Log Me Out" >log me out</button></p>
	</form>
</article>
