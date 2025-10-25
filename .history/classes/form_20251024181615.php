<?php
// This file is part of Moodle - http://moodle.org/
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
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Form for autonumber certificate element settings.
 *
 * @package    certificateelement_autonumber
 * @copyright  2025 Your Name
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

namespace certificateelement_autonumber;

use tool_certificate\element_form;

class form extends element_form {
    /**
     * Define inner form elements.
     *
     * @param MoodleQuickForm $mform The mform object
     */
    protected function definition_inner($mform) {
        $mform->addElement('select', 'seriespattern', get_string('seriespattern', 'tool_certificateelement_autonumber'), [
            'course' => get_string('bycourse', 'tool_certificateelement_autonumber'),
            'group' => get_string('bygroup', 'tool_certificateelement_autonumber'),
            'custom' => get_string('custom', 'tool_certificateelement_autonumber'),
            'combined' => get_string('combined', 'tool_certificateelement_autonumber'),
        ]);
        $mform->setDefault('seriespattern', 'course');

        $mform->addElement('text', 'customprefix', get_string('customprefix', 'tool_certificateelement_autonumber'));
        $mform->setType('customprefix', PARAM_ALPHANUMEXT);
    }
}
