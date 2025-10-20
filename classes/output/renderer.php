<?php

namespace local_autonumber\output;

defined('MOODLE_INTERNAL') || die();

class renderer extends \plugin_renderer_base
{
	public function render_my_certificates_table($certificates)
	{
		global $DB;

		$table = new \html_table();
		$table->head = [
			get_string('name'),
			get_string('course'),
			get_string('date'),
			get_string('certnumber', 'local_autonumber'),
			'Код Moodle'
		];

		foreach ($certificates as $c) {
			$number = $DB->get_field('local_autonumber', 'number', ['issueid' => $c->issueid]);
			$table->data[] = [
				format_string($c->name ?? '-'),
				format_string($c->coursename ?? '-'),
				userdate($c->timecreated ?? time()),
				$number ?: '—',
				$c->code ?? ''
			];
		}

		return html_writer::table($table);
	}
}
