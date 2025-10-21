<?php
defined('MOODLE_INTERNAL') || die();

if ($hassiteconfig) {
	$settings = new admin_settingpage('local_autonumber', get_string('pluginname', 'local_autonumber'));

	$choices = [
		'category' => get_string('option_category', 'local_autonumber'),
		'group' => get_string('option_group', 'local_autonumber'),
		'coursegroup' => get_string('option_coursegroup', 'local_autonumber'),
		'manual' => get_string('option_manual', 'local_autonumber'),
	];

	$settings->add(new admin_setting_configselect(
		'local_autonumber/mode',
		get_string('mode', 'local_autonumber'),
		get_string('mode_desc', 'local_autonumber'),
		'manual',
		$choices
	));

	$settings->add(new admin_setting_configtext(
		'local_autonumber/seriesprefix',
		get_string('seriesprefix', 'local_autonumber'),
		get_string('seriesprefix_desc', 'local_autonumber'),
		'КДАСК-№'
	));

	$ADMIN->add('localplugins', $settings);
}
