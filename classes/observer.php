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

namespace local_autonumber;

use function get_config;

/**
 * Event observer for the local_autonumber plugin.
 *
 * Handles certificate issue events and assigns serial numbers.
 *
 * @package    local_autonumber
 * @category   event
 * @copyright  2025 Павел Пасечник
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class observer
{
    /**
     * Handles the event when a course certificate is issued.
     *
     * Generates and assigns a sequential serial number for the certificate issue.
     *
     * @param \mod_coursecertificate\event\certificate_issued $event The event object containing issue data.
     * @return void
     */
    public static function certificate_issued($event) {
        global $DB;

        $issueid = $event->objectid;
        if (!$issue = $DB->get_record('tool_certificate_issues', ['id' => $issueid])) {
            return;
        }

        // We determine the mode from the settings.
        $mode = get_config('local_autonumber', 'mode') ?: 'manual';
        $prefix = '';

        switch ($mode) {
            case 'category':
                $category = $DB->get_field_sql("
                    SELECT cc.shortname
                    FROM {course} c
                    JOIN {course_categories} cc ON cc.id = c.category
                    WHERE c.id = ?", [$issue->courseid]);
                $prefix = $category . '-№';
                break;

            case 'group':
                $group = $DB->get_field_sql("
                    SELECT g.name
                    FROM {groups} g
                    JOIN {groups_members} gm ON gm.groupid = g.id
                    WHERE gm.userid = ? AND g.courseid = ?
                    LIMIT 1", [$issue->userid, $issue->courseid]);
                $prefix = ($group ?: 'GROUP') . '-№';
                break;

            case 'coursegroup':
                $course = $DB->get_field('course', 'shortname', ['id' => $issue->courseid]);
                $group = $DB->get_field_sql("
                    SELECT g.name
                    FROM {groups} g
                    JOIN {groups_members} gm ON gm.groupid = g.id
                    WHERE gm.userid = ? AND g.courseid = ?
                    LIMIT 1", [$issue->userid, $issue->courseid]);
                $prefix = $course . '-' . ($group ?: 'GROUP') . '-№';
                break;

            case 'manual':
            default:
                $prefix = get_config('local_autonumber', 'seriesprefix') ?: 'КДАСК-№';
                break;
        }

        // Pattern for searching the last number.
        $pattern = str_replace('№', '%', $prefix);

        $lastcode = $DB->get_field_sql(
            "
            SELECT code
            FROM {tool_certificate_issues}
            WHERE code LIKE ?
            ORDER BY id DESC LIMIT 1",
            [$pattern]
        );

        $nextnum = 1;
        if ($lastcode && preg_match('/(\d{6})$/', $lastcode, $m)) {
            $nextnum = intval($m[1]) + 1;
        }

        // Six-digit number format.
        $serial = str_pad($nextnum, 6, '0', STR_PAD_LEFT);

        // Final code.
        $code = str_replace('№', $serial, $prefix);

        // The certificate is verified using the standard functionality of the coursecertificate plugin.

        // We save the number in our own plugin table.
        $record = new \stdClass();
        $record->issueid = $issueid;
        $record->number = $code;
        $record->timecreated = time();
        $DB->insert_record('local_autonumber', $record);
    }
}
