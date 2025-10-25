<?php
defined('MOODLE_INTERNAL') || die();

/**
 * Расширение навигации для вывода таблицы сертификатов с номерами.
 */
function local_autonumber_extend_navigation($nav)
{
	global $PAGE, $DB, $OUTPUT;

	// Проверяем, открыта ли страница "Мои сертификаты"
	if (strpos($PAGE->url->out(), '/admin/tool/certificate/my.php') !== false) {
		$userid = \core_user::get_userid();

		// Получаем список сертификатов текущего пользователя
		$certificates = $DB->get_records_sql("
            SELECT ci.id AS issueid, ci.code, ci.timecreated, c.fullname AS coursename, tc.name
              FROM {customcert_issues} ci
              JOIN {tool_certificate_templates} tc ON tc.id = ci.templateid
              JOIN {course} c ON c.id = ci.courseid
             WHERE ci.userid = ?
             ORDER BY ci.timecreated DESC
        ", [$userid]);

		// Рендерим таблицу с нашими номерами
		$renderer = $PAGE->get_renderer('local_autonumber');
		echo $OUTPUT->header();
		echo $renderer->render_my_certificates_table($certificates);
		echo $OUTPUT->footer();
		die; // предотвращаем двойной вывод
	}
}
