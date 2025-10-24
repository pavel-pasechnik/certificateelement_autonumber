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

namespace local_autonumber\local\dynamicfield;

use mod_coursecertificate\local\dynamicfield\base_dynamic_field;

/**
 * Dynamic field: Certificate number.
 *
 * @package   local_autonumber
 * @copyright 2025 Павел Пасечник
 * @license   https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class certnumber extends base_dynamic_field {
    /**
     * Returns the field name shown in the certificate editor.
     *
     * @return string
     */
    public static function get_field_name(): string {
        return get_string('certnumber', 'local_autonumber');
    }

    /**
     * Returns the field description.
     *
     * @return string
     */
    public static function get_field_description(): string {
        return get_string('certnumber_desc', 'local_autonumber');
    }

    /**
     * Fetches the stored certificate number for the given issue.
     *
     * @param object $issue Issue record provided by course certificate module.
     * @param object $user User record (unused, required by interface).
     * @return string
     */
    public function get_value($issue, $user): string {
        global $DB;
        return $DB->get_field('local_autonumber', 'number', ['issueid' => $issue->id]) ?? '';
    }
}
