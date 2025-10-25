<?php
// This file is part of Moodle - https://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <https://www.gnu.org/licenses/>.

namespace certificateelement_autonumber;

use tool_certificate\event\certificate_issued;
use tool_certificate\event\certificate_revoked;

defined('MOODLE_INTERNAL') || die();

/**
 * Event observer for certificate autonumber.
 *
 * @package   certificateelement_autonumber
 */
class observer {
    /**
     * Событие: выпуск сертификата.
     *
     * @param certificate_issued $event
     */
    public static function certificate_issued(certificate_issued $event) {
        global $DB;

        $issue = $event->get_record_snapshot('tool_certificate_issues', $event->objectid);
        [$series, $number, $year] = generator::generate($issue->courseid ?? 0, $issue->userid, $issue->timecreated);

        // Проверяем, нет ли записи.
        if (!$DB->record_exists('certificateelement_autonumber', ['issueid' => $issue->id])) {
            $record = (object)[
                'issueid' => $issue->id,
                'series' => $series,
                'number' => $number,
                'year' => $year,
            ];
            $DB->insert_record('certificateelement_autonumber', $record);
        }
    }

    /**
     * Событие: отзыв сертификата.
     *
     * @param certificate_revoked $event
     */
    public static function certificate_revoked(certificate_revoked $event) {
        global $DB;
        $DB->delete_records('certificateelement_autonumber', ['issueid' => $event->objectid]);
    }
}
