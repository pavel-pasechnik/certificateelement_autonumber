<?php

namespace local_autonumber\output;

defined('MOODLE_INTERNAL') || die();

class renderer extends \plugin_renderer_base
{
	public function render_my_certificates_table($certificates)
	{
		global $DB, $OUTPUT;

		$table = new \html_table();
		$table->head = ['Назва сертифіката', 'Курс', 'Дата', 'Номер', 'Код Moodle'];

		foreach ($certificates as $c) {
			// Находим наш внутренний номер.
			$number = $DB->get_field('local_autonumber', 'number', ['issueid' => $c->issueid]);
			$table->data[] = [
				format_string($c->name),
				format_string($c->coursename),
				userdate($c->timecreated),
				$number ?: '—',
				$c->code
			];
		}

		return html_writer::table($table);
	}
}
