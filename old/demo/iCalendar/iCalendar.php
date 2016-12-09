<?php
require_once "iCalendarEvent.php";

/**
 * iCalendar class
 *
 * Creates and stores information for an iCalendar and iCalendar event.
 *
 * @package iCalendar
 * @author Cory Borrow
 * @copyright 2015 Cory Borrow
 * @version 1.0
 */
class iCalendar {
	/**
	 * Stores an array of iCalendarEvent objects.
	 * @access protected
	 * @var array
	 */
	protected $events;

	/**
	 * Stores the product id of the iCalendar. Automatically generated.
	 * @access protected
	 * @var string
	 */
	protected $prodId;

	/**
	 * Stores the calendar type. Automatically generated.
	 * @access protected
	 * @var string
	 */
	protected $calScale;

	/**
	 * Sets the method of the iCalendar event. Automatically generated.
	 * @access protected
	 * @var string
	 */
	protected $method;

	/**
	 * Sets the version of the iCalendar.
	 * @access protected
	 * @var string
	 */
	protected $version;

	/**
	 * Constructor.
	 */
	public function __construct() {
		$this->events = array();
		$this->prodId = "-//Cory Borrow//iCalendar PHP//EN";
		$this->version = "2.0";
		$this->calScale = "GREGORIAN";
		$this->method = "REQUEST";
	}

	/**
	 * Adds a new event in form of an iCalendarEvent.
	 *
	 * @access public
	 * @param iCalendarEvent $event Event object.
	 */
	public function addEvent(iCalendarEvent $event) {
		$this->events[] = $event;
	}

	/**
	 * Returns the formatted iCalendar in the form of a iCalendar/vCalendar event.
	 *
	 * @access public
	 * @return string
	 */
	public function toString() {
		if(count($this->events) == 0)
			throw new Exception("At least one event is required.");

		$output = "BEGIN:VCALENDAR\r\n";
		$output .= "PRODID:{$this->prodId}\r\n";
		$output .= "VERSION:{$this->version}\r\n";
		$output .= "CALSCALE:{$this->calScale}\r\n";
		$output .= "METHOD:{$this->method}\r\n";

		foreach($this->events as $e) {
			$output .= $e->toString();
		}

		$output .= "END:VCALENDAR\r\n";
		return $output;
	}

	/**
	 * Writes the iCalendar event to a file. iCalendar standard uses an .ics extension.
	 *
	 * @param  string $fileName The name of the file to save event as. (Defaults to invite.ics)
	 * @return boolean Returns true or fals if file was written.
	 */
	public function toFile($fileName = 'invite.ics') {
		if(file_put_contents($fileName, $this->toString() > 0))
			return true;
		return false;
	}
}
?>
