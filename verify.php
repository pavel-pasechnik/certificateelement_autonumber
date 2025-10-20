<?php
require_once(__DIR__ . '/../../config.php');

$number = required_param('num', PARAM_TEXT);
$number = trim(preg_replace('/\s+/', '', $number));

global $DB;

if ($record = $DB->get_record('local_autonumber', ['number' => $number])) {
	if ($issue = $DB->get_record('customcert_issues', ['id' => $record->issueid])) {
		$url = new moodle_url('/admin/tool/certificate/view.php', ['code' => $issue->code]);
		redirect($url);
	}
}

http_response_code(404);
$PAGE->set_context(context_system::instance());
$PAGE->set_title('Перевірка дійсності диплома');
$PAGE->set_heading('Перевірка дійсності диплома');

echo $OUTPUT->header();
echo html_writer::div('❌ Диплом не знайдено. Перевірте правильність номера.', 'alert alert-danger');
echo $OUTPUT->footer();
