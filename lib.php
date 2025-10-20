<?php
defined('MOODLE_INTERNAL') || die();

/**
 * Navigation extension for displaying a table of certificates with numbers.
 */
function local_autonumber_extend_navigation($nav)
{
	global $PAGE, $DB, $OUTPUT;

	// Check if the "My Certificates" page is open.
	if (strpos($PAGE->url->out(), '/admin/tool/certificate/my.php') !== false) {
		$userid = \core_user::get_userid();

		// Get a list of certificates for the current user
		$certificates = $DB->get_records_sql("
            SELECT ci.id AS issueid, ci.code, ci.timecreated, c.fullname AS coursename, tc.name
              FROM {customcert_issues} ci
              JOIN {tool_certificate_templates} tc ON tc.id = ci.templateid
              JOIN {course} c ON c.id = ci.courseid
             WHERE ci.userid = ?
             ORDER BY ci.timecreated DESC
        ", [$userid]);

		// Let's render a table with our numbers
		$renderer = $PAGE->get_renderer('local_autonumber');
		echo $OUTPUT->header();
		echo $renderer->render_my_certificates_table($certificates);
		echo $OUTPUT->footer();
		die; // prevent double output
	}
}
