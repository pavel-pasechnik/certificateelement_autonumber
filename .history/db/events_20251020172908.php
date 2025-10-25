<?php
defined('MOODLE_INTERNAL') || die();

$observers = [
	[
		'eventname'   => '\mod_customcert\event\certificate_issued',
		'callback'    => '\local_autonumber\observer::certificate_issued',
		'includefile' => '/local/autonumber/classes/observer.php',
		'priority'    => 1000,
	],
];
