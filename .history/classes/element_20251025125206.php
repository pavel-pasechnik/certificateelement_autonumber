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

< ? php
namespace certificateelement_autonumber;

use tool_certificate\element;
use core\notification;

defined('MOODLE_INTERNAL') || die();

/**
 * Element: Autonumber series + number.
 *
 * @package   certificateelement_autonumber
 * @copyright 2025 Павел
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class element extends element {
    /** @var string Серия сертификата */
    protected $series;

    /** @var int Номер сертификата */
    protected $number;

    /**
     * Вывод значения на сертификате.
     *
     * @param \stdClass $issue
     * @param \context $context
     * @return string
     */
    public function render($issue, $context) {
        global $DB;

        $record = $DB->get_record('certificateelement_autonumber', ['issueid' => $issue->id]);
        if ($record) {
            return format_string("{$record->series}-{$record->number}");
        }

        return get_string('autonumber_missing', 'certificateelement_autonumber');
    }

    /**
     * Вызывается при выпуске сертификата.
     *
     * @param \stdClass $issue
     */
    public static function issue_generated($issue) {
        global $DB;

        $year = date('Y', $issue->timecreated);
        $courseid = $issue->courseid ?? 0;
        $series = self::define_series($courseid, $issue->userid);

        $max = $DB->get_record_sql("
            SELECT MAX(number) AS maxnum
              FROM {certificateelement_autonumber}
             WHERE year = ? AND series = ?", [$year, $series]);

        $newnumber = ($max->maxnum ?? 0) + 1;

        $record = (object)[
            'issueid' => $issue->id,
            'series' => $series,
            'number' => $newnumber,
            'year' => $year,
        ];
        $DB->insert_record('certificateelement_autonumber', $record);
    }

    /**
     * Логика определения серии по настройке шаблона.
     *
     * @param int $courseid
     * @param int $userid
     * @return string
     */
    protected static function define_series($courseid, $userid): string {
        global $DB;

        $mode = get_config('certificateelement_autonumber', 'seriesmode') ?: 'course';
        switch ($mode) {
            case 'group':
                $group = groups_get_user_groups($courseid, $userid);
                return $group ? 'G' . reset($group[0]) : 'G0';
            case 'coursegroup':
                $group = groups_get_user_groups($courseid, $userid);
                return "C{$courseid}-G" . (reset($group[0]) ?: '0');
            case 'manual':
                return get_config('certificateelement_autonumber', 'manualseries') ?: 'SER';
            default:
                return "C{$courseid}";
        }
    }

    /**
     * Удаление номера при отзыве сертификата.
     *
     * @param \stdClass $issue
     */
    public static function issue_revoked($issue) {
        global $DB;
        $DB->delete_records('certificateelement_autonumber', ['issueid' => $issue->id]);
    }
}
