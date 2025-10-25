<?php
defined('MOODLE_INTERNAL') || die();

function local_autonumber_before_footer()
{
	global $PAGE;

	// Подключаем наш вывод для страницы "Мои сертификаты"
	if (strpos($PAGE->url->out(), '/admin/tool/certificate/my.php') !== false) {
		$PAGE->requires->js_call_amd('local_autonumber/enhance_certlist', 'init');
	}
}
