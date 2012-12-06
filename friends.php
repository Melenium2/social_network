<?php
	session_start();
	
	// Check to see if the user is logged in. If they are not, then redirect them to the index/login page.
	if(!(isset($_SESSION['user']))){
		header("Location: index.php");
	}
	// Include the common PHP file
	include_once("common.php");
	// Call the common header function.
	common_header();
?>
	<title>Your Friends</title>
	</head>
	<body>
		<?php addMenu(); ?>
		<h1>Welcome to the Friends Page</h1>

		<?php
			// Connect to DB
			$db = new mysqli('localhost', 'team09', 'maroon', 'team09');
			if (mysqli_connect_errno()) {
				die('Failed to connect to database. Try again later.');
			}

			$query = 'select id from users where email = ?';
			$prep_query = $db->prepare($query);
			$prep_query->bind_param('s', $_SESSION['user']);
			if ($prep_query->execute()) {
				$prep_query->bind_result($id);
				$prep_query->fetch();
				$prep_query->close();
			}
			else {
				die('Failed to execute query');
			}
			
			$query = "select user2 from friends where user1 = $id";
			$results = $db->query($query);

			if (!$results) {
				die('Invalid query');
			}

			$query = 'select fname, lname from users where id = ?';
			$prep_query = $db->prepare($query);
			while ($row = $results->fetch_assoc()) {
				$id2 = $row['user2'];
				$prep_query->bind_param('i', $id2);
				if ($prep_query->execute()) {
					$prep_query->bind_result($fname, $lname);
					$prep_query->fetch();
		?>
					<form action="unfriend.php" method="post">
						<p>
							<?php echo "$fname $lname "?>
							<input type='text' name='user2' value='<?php echo $id2?>' style='display:none'/>
							<input type='submit' value='Unfriend' style='display:inline'/>
						</p>
					</form>
		<?php
				}
				else {
					die('Error obtaining friends list');
				}
			}

			$prep_query->close();
			$results->close();
			$db->close();
		?>
	</body>
</html>
