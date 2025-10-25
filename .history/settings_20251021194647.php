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

defined('MOODLE_INTERNAL') || die();

if ($hassiteconfig) {
    $settings = new admin_settingpage('local_autonumber', get_string('pluginname', 'local_autonumber'));

    $choices = [
        'category' => get_string('option_category', 'local_autonumber'),
        'group' => get_string('option_group', 'local_autonumber'),
        'coursegroup' => get_string('option_coursegroup', 'local_autonumber'),
        'manual' => get_string('option_manual', 'local_autonumber'),
    ];

    $settings->add(new admin_setting_configselect(
        'local_autonumber/mode',
        get_string('mode', 'local_autonumber'),
        get_string('mode_desc', 'local_autonumber'),
        'manual',
        $choices
    ));

    $settings->add(new admin_setting_configtext(
        'local_autonumber/seriesprefix',
        get_string('seriesprefix', 'local_autonumber'),
        get_string('seriesprefix_desc', 'local_autonumber'),
        'КДАСК-№'
    ));

    $ADMIN->add('localplugins', $settings);
}
