<?php
if(isset($_GET['error']))
    $error = $_GET['error'];

$error = null;
?>
<!doctype html>
<html>
<head>
    <title>iCal Invintation Demo</title>
    <style type="text/css">
    * {
        font-family: "Segoe UI", Sans-Serif;
        font-size: 12pt;
    }
    label {
        float: left;
        width: 150px;
    }
    input[type=text], input[type=date], input[type=time] {
        width: 400px;
    }
    textarea {
        width: 400px;
        height: 300px;
    }
    </style>
</head>
<body>
    <div class="container">
        <form action="<?=$_SERVER['PHP_SELF']; ?>" method="post">
        <?php if(isset($error) && strlen($error) > 2): ?>
            <h3><?=$error; ?></h3>
        <?php endif; ?>
        <p>
            <label>Sender</label>
            <input type="text" name="sender" readonly="true" value="eventmailer@nationalpcpro.com" />
        </p>
        <p>
            <label>Recipient</label>
            <input type="text" name="recipient" placeholder="user@domain.com" />
        </p>
        <p>
            <label>Event Start Date</label>
            <input type="date" name="start_date" placeholder="01/01/2015" />
        </p>
        <p>
            <label>Event End Date</label>
            <input type="date" name="end_date" placeholder="01/02/2015" />
        </p>
        <p>
            <label>Event Alert Time (in minutes)</label>
            <input type="text" name="alert_time" placeholder="15" />
        </p>
        <p>
            <label>Event Name</label>
            <input type="text" name="title" placeholder="My Test Event" />
        </p>
        <p>
            <label>Event Text</label>
            <textarea name="msg"></textarea>
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
if(isset($_POST['submit'])) {
    $to = $_POST['recipient'];
    $from = $_POST['sender'];
    $title = $_POST['title'];
    $msg = $_POST['msg'];
    $alert = $_POST['alert_time'];
    $start = strtotime($_POST['start_date']);
    $end = strtotime($_POST['end_date']);

    define('ORGANISATIONREPLYMAIL', $from);
    define('ORGANISATIONNAME', 'National PC Professionals, Inc');

    if(sendCalEntry($start, $end, "Here", $msg, $title, "", $to, $from))
        $_GET['error'] = 'E-Mail sent successfully.';
    else
        $_GET['error'] = 'Your message failed to send. Please check PHP and mail logs to find out why.';
}

function sendCalEntry( $tsStart, $tsEnd, $location, $summary, $title, $resources, $to, $subject ){

    require "php-mailer/PHPMailerAutoload.php";
    require "iCalendar\iCalendar.php";

	$from = ORGANISATIONREPLYMAIL;
	$dtstart = date('Ymd',$tsStart).'T'.date('His',$tsStart);
	$dtend = date('Ymd',$tsEnd).'T'.date('His',$tsEnd);
	$loc = $location;

    $cal = new iCalendar();
    $event = new iCalendarEvent();
    $event->setOrganizer($from, 'Event Mailer');
    $event->setStartTime($tsStart);
    $event->setEndTime($tsEnd);
    $event->Location = $location;
    $event->Summary = $title;
    $event->Description = $summary . "\r\n" . $summary . "\r\n" . $summary;
    $event->addAttendee($to);
    $event->addAlarm(1800);
    $event->addAlarm(3600);
    $cal->addEvent($event);

	/*$vcal = "BEGIN:VCALENDAR\r\n";
	$vcal .= "VERSION:2.0\r\n";
	$vcal .= "PRODID:-//nonstatics.com//OrgCalendarWebTool//EN\r\n";
	$vcal .= "METHOD:REQUEST\r\n";
	$vcal .= "BEGIN:VEVENT\r\n";
	$vcal .= "ORGANIZER;CN=\"".ORGANISATIONNAME." (".$_SERVER['REMOTE_USER'].")"."\":mailto:".ORGANISATIONREPLYMAIL."\r\n";
	$vcal .= "UID:".date('Ymd').'T'.date('His')."-".rand()."-nonstatics.com\r\n";
	$vcal .= "DTSTAMP:".date('Ymd').'T'.date('His')."\r\n";
	$vcal .= "DTSTART:$dtstart\r\n";
	$vcal .= "DTEND:$dtend\r\n";
	$vcal .= "LOCATION:$location\r\n";
	$vcal .= "SUMMARY:$summary\r\n";
	$vcal .= "DESCRIPTION:Note: $summary - The following resources were booked: $resources \r\n";
	$vcal .= "BEGIN:VALARM\r\n";
	$vcal .= "TRIGGER:-PT15M\r\n";
	$vcal .= "ACTION:DISPLAY\r\n";
	$vcal .= "DESCRIPTION:Reminder\r\n";
	$vcal .= "END:VALARM\r\n";
	$vcal .= "END:VEVENT\r\n";
	$vcal .= "END:VCALENDAR\r\n";*/

	$headers = "From: $from\r\nReply-To: $from";
	$headers .= "\r\nMIME-version: 1.0\r\nContent-Type: text/calendar; name=calendar.ics; method=REQUEST; charset=\"iso-8859-1\"";
	$headers .= "\r\nContent-Transfer-Encoding: 7bit\r\nX-Mailer: Microsoft Office Outlook 12.0";

    /*if(strpos($to, ';')) {
        $parts = explode(';', $to);
    }*/

    $mail = new PHPMailer();

    $mail->SMTPDebug = 3;
    $mail->Debugoutput = 'html';
    $mail->isSMTP();
    $mail->Host = '192.168.21.2';
    $mail->SMTPAuth = true;
    //$mail->SMTPSecure = 'tls';
    $mail->Username ='eventmailer';
    $mail->Password = 'Password123!';
    $mail->SMTPSecure = false;
    $mail->Port = 25;

    $mail->setFrom($from, 'Event Mailer');
    $mail->AddReplyTo($from, 'Event Mailer');

    if(!(strpos($to, ';') === false)) {
        $parts = explode(';', $to);

        foreach($parts as $p) {
            $mail->addAddress($p);
        }
    }
    else
        $mail->addAddress($to);

    $mail->ContentType = 'text/calendar; name=calendar.ics; method=REQUEST; charset="iso-8859-1"';
    $mail->XMailer = 'Microsoft Office Outlook 12.0';

    $mail->addCustomHeader('Content-Transfer-Encoding', '7bit');

    $mail->Subject = $subject . " " . $summary . " / " . $resources;
    //$mail->Body = $vcal;
    $mail->Body = $cal->toString();

    if($mail->send())
        echo "Message sent successfully";
    else {
        echo "Message failed to send<br /><br />";
        echo $mail->ErrorInfo;
    }
}
?>
