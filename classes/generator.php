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

/**
 * Generator for automatic certificate numbering.
 *
 * @package   certificateelement_autonumber
 * @copyright 2025 Pavel Pasechnik
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class generator {
    /**
     * Returns the series/number triplet for the next certificate.
     *
     * Numbering is global for the calendar year and counts every previously issued
     * certificate, even if the element was added after some issues already existed.
     *
     * @param int $timecreated Issue timestamp
     * @param int|null $issueid Issue ID for deterministic positioning; null when previewing
     * @return array [series, number, year]
     */
    public static function generate(int $timecreated, ?int $issueid = null): array {
        global $DB;

        $year = (int)date('Y', $timecreated);
        [$start, $end] = self::get_year_bounds($year);

        if ($issueid === null) {
            $count = $DB->count_records_select(
                'tool_certificate_issues',
                'timecreated >= ? AND timecreated < ?',
                [$start, $end]
            );
            return ['', $count + 1, $year];
        }

        $count = $DB->get_field_sql(
            "
            SELECT COUNT(1)
              FROM {tool_certificate_issues}
             WHERE timecreated >= ?
               AND timecreated < ?
               AND (
                   timecreated < ?
                   OR (timecreated = ? AND id <= ?)
               )",
            [$start, $end, $timecreated, $timecreated, $issueid]
        );

        return ['', (int)$count, $year];
    }

    /**
     * Returns the timestamps that bound the provided year.
     *
     * @param int $year
     * @return array [starttimestamp, endtimestamp)
     */
    protected static function get_year_bounds(int $year): array {
        $start = mktime(0, 0, 0, 1, 1, $year);
        $end = mktime(0, 0, 0, 1, 1, $year + 1);
        return [$start, $end];
    }
}
