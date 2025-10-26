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

/**
 * Form fragment for certificate element settings.
 *
 * @package    certificateelement_autonumber
 * @copyright  2025 Pavel Pasechnik
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$mform->addElement('select', 'seriesmode', get_string('seriesmode', 'certificateelement_autonumber'), [
    'course' => get_string('series_course', 'certificateelement_autonumber'),
    'group' => get_string('series_group', 'certificateelement_autonumber'),
    'coursegroup' => get_string('series_coursegroup', 'certificateelement_autonumber'),
    'manual' => get_string('series_manual', 'certificateelement_autonumber'),
]);
$mform->setDefault('seriesmode', 'course');
$mform->addElement('text', 'manualseries', get_string('manualseries', 'certificateelement_autonumber'));
