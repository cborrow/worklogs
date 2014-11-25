<?php
if(!function_exists('generate_status_chart')) {
	function generate_status_chart($open, $closed) {
		echo "<canvas id=\"statusChart\" width=\"250\" height=\"250\"></canvas>";
		echo "<script type=\"text/javascript\">";
		echo "var data = [
			{
				value: 30,
				color: '#F7464A',
				highlight: '#FF5A5E',
				label: 'Open Jobs'
			},
			{
				value: 70,
				color: '#46BFBD',
				highlight: '#5AD3D1',
				label: 'Closed Jobs'
			}
		]";
		echo "var ctx = document.getElementbyId('statusChart').getContext('2d');";
		echo "var chart = new Chart(ctx).Doughnut(data);";
		echo "</script>";
	}
}
?>