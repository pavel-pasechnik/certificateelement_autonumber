<?php

namespace local_autonumber;

defined('MOODLE_INTERNAL') || die();

class observer
{
	public static function certificate_issued($event)
	{
		global $DB;

		$issueid = $event->objectid;
		if (!$issue = $DB->get_record('customcert_issues', ['id' => $issueid])) {
			return;
		}

		$year = date('Y');
		$prefix = get_config('local_autonumber', 'seriesprefix') ?: 'КДА';
		$prefix .= '-' . $year;

		$lastcode = $DB->get_field_sql(
			"
            SELECT code
            FROM {customcert_issues}
            WHERE code LIKE ?
            ORDER BY id DESC LIMIT 1",
			[$prefix . '%']
		);

		$nextnum = 1;
		if ($lastcode && preg_match('/(\d{6})$/', $lastcode, $m)) {
			$nextnum = intval($m[1]) + 1;
		}

		$serial = str_pad($nextnum, 6, '0', STR_PAD_LEFT);
		$code = "{$prefix}-{$serial}";

		$DB->set_field('customcert_issues', 'code', $code, ['id' => $issueid]);
	}
}
