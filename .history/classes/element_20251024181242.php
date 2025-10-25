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

use tool_certificate\element as base_element;

/**
 * Certificate element that renders an auto-generated serial number.
 *
 * @package    certificateelement_autonumber
 * @copyright  2025 Павел Пасечник
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class element extends base_element {
    /**
     * Renders the element content into the certificate PDF.
     *
     * @param object $pdf     TCPDF instance provided by the certificate renderer.
     * @param bool   $preview Whether this is a preview render.
     * @param object $user    User record for whom the certificate is issued.
     * @return void
     */
    public function render($pdf, $preview, $user) {
        if ($preview) {
            $text = 'SAMPLE-2025-000001';
        } else {
            $courseid = $this->get_context()->instanceid ?? 0;
            $groupid = null; // Optionally, can be extracted from enrolments.
            $pattern = $this->get_configdata_property('seriespattern');
            $text = generator::generate_number($user->id, $courseid, $groupid, $pattern);
        }
        $this->render_text($pdf, $text);
    }
}
