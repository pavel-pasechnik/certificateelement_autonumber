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

/**
 * Event observer for certificate autonumber.
 *
 * @package   certificateelement_autonumber
 * @copyright 2025 Pavel Pasechnik
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class observer {
    /**
     * Event: certificate issuance.
     *
     * @param certificate_issued $event
     */
    public static function certificate_issued(certificate_issued $event) {
        global $DB;

        $issue = $event->get_record_snapshot('tool_certificate_issues', $event->objectid);
        [, $number, $year] = generator::generate((int)$issue->timecreated, (int)$issue->id);

        // We check to see if there are any entries.
        if (!$DB->record_exists('certificate_autonumber', ['issueid' => $issue->id])) {
            $record = (object)[
                'issueid' => $issue->id,
                'number' => $number,
                'year' => $year,
            ];
            $DB->insert_record('certificate_autonumber', $record);
        }
    }

    /**
     * Event: certificate revocation.
     *
     * @param certificate_revoked $event
     */
    public static function certificate_revoked(certificate_revoked $event) {
        global $DB;
        $DB->delete_records('certificate_autonumber', ['issueid' => $event->objectid]);
    }
}
