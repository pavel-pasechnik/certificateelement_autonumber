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
 * Admin page to recalculate certificate numbers/series.
 *
 * @package    certificateelement_autonumber
 * @copyright  2025 Pavel Pasechnik
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(__DIR__ . '/../../../../config.php');

require_login();
require_capability('moodle/site:config', context_system::instance());

$PAGE->set_context(context_system::instance());
$PAGE->set_url(new moodle_url('/admin/tool/certificate/element/autonumber/recalculate.php'));
$PAGE->set_title(get_string('recalculate_numbers', 'certificateelement_autonumber'));
$PAGE->set_heading(get_string('pluginname', 'certificateelement_autonumber'));

echo $OUTPUT->header();

$count = \certificateelement_autonumber\manager::recalculate_all();

echo $OUTPUT->notification(
    get_string('recalculate_done', 'certificateelement_autonumber', $count),
    'notifysuccess'
);

echo $OUTPUT->continue_button(
    new moodle_url('/admin/settings.php', ['section' => 'certificateelement_autonumber'])
);

echo $OUTPUT->footer();
