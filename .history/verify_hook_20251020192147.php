<?php
require_once(__DIR__ . '/../../config.php');

// Automatic redirection from the standard Moodle certificate verification page
if (
	strpos($_SERVER['REQUEST_URI'], '/admin/tool/certificate/verify.php') !== false
	&& strpos($_SERVER['REQUEST_URI'], '/local/autonumber/verify_hook.php') === false
) {
	redirect(new moodle_url('/local/autonumber/verify_hook.php'));
}

$code = optional_param('code', '', PARAM_ALPHANUMEXT);
$num  = optional_param('num', '', PARAM_TEXT);

global $DB;

$found = false;

if ($num) {
	$record = $DB->get_record('local_autonumber', ['number' => trim($num)]);
	if ($record && ($issue = $DB->get_record('customcert_issues', ['id' => $record->issueid]))) {
		$url = new moodle_url('/admin/tool/certificate/view.php', ['code' => $issue->code]);
		redirect($url);
	}
} elseif ($code) {
	redirect(new moodle_url('/admin/tool/certificate/view.php', ['code' => $code]));
}

$PAGE->set_context(context_system::instance());
$PAGE->set_title(get_string('verifytitle', 'local_autonumber', 'Перевірка дійсності диплома'));
$PAGE->set_heading(get_string('verifyheading', 'local_autonumber', 'Перевірка дійсності диплома'));
echo $OUTPUT->header();

if (($num || $code) && !$found) {
	echo $OUTPUT->notification('❌ Диплом не знайдено. Перевірте правильність номера.', 'notifyproblem');
}

echo html_writer::start_tag('form', [
	'method' => 'get',
	'action' => new moodle_url('/local/autonumber/verify_hook.php'),
	'class'  => 'mform'
]);

echo html_writer::div('Введіть номер диплома або код сертифіката:', 'fitemtitle');
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
