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

namespace tool_certificateelement_autonumber;

/**
 * Generator for automatic certificate numbering.
 *
 * @package   tool_certificateelement_autonumber
 * @copyright 2025 Pavel Pasechnik
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class generator {
    /**
     * Возвращает следующую комбинацию серии и номера.
     *
     * @param int $courseid
     * @param int $userid
     * @param int $timecreated
     * @return array [series, number, year]
     */
    public static function generate(int $courseid, int $userid, int $timecreated): array {
        global $DB;

        $year = date('Y', $timecreated);
        $series = self::resolve_series($courseid, $userid);

        $numberingmode = get_config('tool_certificateelement_autonumber', 'numberingmode') ?: 'yearly';

        if ($numberingmode === 'continuous') {
            $max = $DB->get_field_sql('
                SELECT MAX(number)
                  FROM {tool_certificateelement_autonumber}
                 WHERE series = ?', [$series]);
        } else {
            $max = $DB->get_field_sql('
                SELECT MAX(number)
                  FROM {tool_certificateelement_autonumber}
                 WHERE year = ? AND series = ?', [$year, $series]);
        }

        $newnumber = ((int)$max) + 1;

        return [$series, $newnumber, $year];
    }

    /**
     * Определяет серию на основе режима.
     *
     * @param int $courseid
     * @param int $userid
     * @return string
     */
    public static function resolve_series(int $courseid, int $userid): string {
        global $DB;

        $mode = get_config('tool_certificateelement_autonumber', 'seriesmode') ?: 'course';

        switch ($mode) {
            case 'group':
                $groups = groups_get_user_groups($courseid, $userid);
                return $groups && !empty($groups[0]) ? 'G' . reset($groups[0]) : 'G0';

            case 'coursegroup':
                $groups = groups_get_user_groups($courseid, $userid);
                $gid = $groups && !empty($groups[0]) ? reset($groups[0]) : '0';
                return "C{$courseid}-G{$gid}";

            case 'manual':
                return get_config('tool_certificateelement_autonumber', 'manualseries') ?: 'SER';

            default:
                $shortname = $DB->get_field('course', 'shortname', ['id' => $courseid]);
                return $shortname ?: "C{$courseid}";
        }
    }
}
