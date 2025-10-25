<?php
require_once(__DIR__ . '/../../config.php');

$code = optional_param('code', '', PARAM_TEXT); // стандартный параметр
$num  = optional_param('num', '', PARAM_TEXT);  // твой параметр

global $DB;

if ($num) {
	// Если ввели твой номер — ищем в таблице local_autonumber
	if ($record = $DB->get_record('local_autonumber', ['number' => trim($num)])) {
		if ($issue = $DB->get_record('customcert_issues', ['id' => $record->issueid])) {
			$url = new moodle_url('/admin/tool/certificate/view.php', ['code' => $issue->code]);
			redirect($url);
		}
	}
} elseif ($code) {
	// Если ввели стандартный код — просто редиректим на стандартную страницу
	redirect(new moodle_url('/admin/tool/certificate/view.php', ['code' => $code]));
}

// Если ничего не найдено — форма
$PAGE->set_context(context_system::instance());
$PAGE->set_title('Перевірка дійсності диплома');
$PAGE->set_heading('Перевірка дійсності диплома');
echo $OUTPUT->header();

echo html_writer::start_tag('form', [
	'method' => 'get',
	'action' => new moodle_url('/local/autonumber/verify_hook.php'),
	'class'  => 'mform'
]);

echo html_writer::div(
	'Введіть номер диплома або код сертифіката:',
	'fitemtitle'
);
echo html_writer::empty_tag('input', [
	'type' => 'text',
	'name' => 'num',
	'placeholder' => 'КДА-2025-№000123 або G3VTX7MZQW',
	'class' => 'form-control',
	'required' => 'required'
]);
echo html_writer::empty_tag('br');
echo html_writer::empty_tag('input', [
	'type' => 'submit',
	'value' => 'Перевірити',
	'class' => 'btn btn-primary'
]);
echo html_writer::end_tag('form');

echo $OUTPUT->footer();
