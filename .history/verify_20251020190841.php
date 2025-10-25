<?php
require_once(__DIR__ . '/../../config.php');

$number = required_param('num', PARAM_TEXT);

global $DB;

// Search for a record by diploma number in the local_autonumber table
if ($record = $DB->get_record('local_autonumber', ['number' => trim($number)])) {

	// Get the related issue from customcert_issues
	if ($issue = $DB->get_record('customcert_issues', ['id' => $record->issueid])) {

		// Redirecting to the standard Moodle page
		$url = new moodle_url('/admin/tool/certificate/view.php', ['code' => $issue->code]);
		redirect($url);
	}
}

// If not found, display a message
$PAGE->set_context(context_system::instance());
$PAGE->set_title('Перевірка дійсності диплома');
$PAGE->set_heading('Перевірка дійсності диплома');

echo $OUTPUT->header();
echo html_writer::div('❌ Диплом не знайдено. Перевірте правильність номера.', 'alert alert-danger');
echo $OUTPUT->footer();
