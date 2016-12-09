<!doctype html>
<html>
<head>
	<title>iCalendar Test</title>
	<style type="text/css">

	</style>
</head>
<body>
	<div class="container">
		<form action="<?=$_SERVER['PHP_SELF']; ?>" method="POST" />
		<p>
			<label>To</label>
			<input type="text" name="to" placeholder="recipient@domain.com" />
		</p>
		<p>
			<label>From</label>
			<input type="text" name="from" placeholder="you@yourdomain.com" />
		</p>
		<p>
			<label>Title</label>
			<input type="text" name="title" placeholder="Your basic event" />
		</p>
		<p>
			<label>Location</label>
			<input type="text" name="location" placeholder="123 S apple st Frankfurt, VA, USA" />
		</p>
		<p>
			<label>Description</label>
			<textarea name="description"></textarea>
		</p>
		<p>
			<label>&nbsp;</label>
			<input type="submit" name="submit" value="Send Invite" />
		</p>
		</form>
	</div>
</body>
</html>

<?php
require "iCalendar.php";

if(isset($_POST['submit'])) {
	$title = $_POST['title'];
	$location = $_POST['location'];
	$description = $_POST['description'];
	$to = $_POST['to'];
	$from = $_POST['from'];

	$cal = new iCalendar();
	$event = new iCalendarEvent();

	$event->Title = $title;
	$event->Location = $location;
	$event->Description = $description;
	$event->setOrganizer($from);
	$event->addAttendee($to);
	$event->setStartTime(time());
	$event->setEndTime(time() + 1440);
	$event->addAlarm(3600);
	$event->addAlarm(44800);
	$cal->addEvent($event);

	$cal->toFile("invite.ics");

	if(file_exists("invite.ics"))
		echo "Succesfully created invite<br />";
	else
		echo "Failed to create invite<br />";
}
?>
