<?php
require_once(__DIR__ . '/../../config.php');

$number = required_param('num', PARAM_TEXT);

global $DB;

// Ищем запись по номеру диплома в таблице local_autonumber
if ($record = $DB->get_record('local_autonumber', ['number' => trim($number)])) {

	// Получаем связанный issue из customcert_issues
	if ($issue = $DB->get_record('customcert_issues', ['id' => $record->issueid])) {

		// Перенаправляем на стандартную страницу Moodle
		$url = new moodle_url('/admin/tool/certificate/view.php', ['code' => $issue->code]);
		redirect($url);
	}
}

// Если не найдено — выводим сообщение
$PAGE->set_context(context_system::instance());
$PAGE->set_title('Перевірка дійсності диплома');
$PAGE->set_heading('Перевірка дійсності диплома');

echo $OUTPUT->header();
echo html_writer::div('❌ Диплом не знайдено. Перевірте правильність номера.', 'alert alert-danger');
echo $OUTPUT->footer();
