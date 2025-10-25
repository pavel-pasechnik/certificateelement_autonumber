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

defined('MOODLE_INTERNAL') || die();

/**
 * Manager class for autonumber operations.
 *
 * @package   certificateelement_autonumber
 */
class manager {
    /**
     * Пересчитать все номера для существующих сертификатов.
     *
     * @return int Количество пересчитанных записей.
     */
    public static function recalculate_all(): int {
        global $DB;

        $issues = $DB->get_records('tool_certificate_issues');
        $DB->delete_records('certificateelement_autonumber');
        $count = 0;

        foreach ($issues as $issue) {
            [$series, $number, $year] = generator::generate($issue->courseid ?? 0, $issue->userid, $issue->timecreated);
            $record = (object)[
                'issueid' => $issue->id,
                'series' => $series,
                'number' => $number,
                'year' => $year,
            ];
            $DB->insert_record('certificateelement_autonumber', $record);
            $count++;
        }

        return $count;
    }
}
