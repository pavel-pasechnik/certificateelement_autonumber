<?php
// This file is part of Moodle - https://moodle.org/.
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
 * Admin settings for the tool_certificateelement_autonumber plugin.
 *
 * @package    tool_certificateelement_autonumber
 * @copyright  2025 Pavel Pasechnik
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

if ($hassiteconfig) {
    // Check if the 'certificateelementplugins' category exists to avoid "parent does not exist" error.
    if ($ADMIN->locate('certificateelementplugins')) {
        $settings = new admin_settingpage(
            'tool_certificateelement_autonumber',
            get_string('autonumber_settings', 'tool_certificateelement_autonumber')
        );

        // Series mode selection.
        $options = [
            'course' => get_string('series_course', 'tool_certificateelement_autonumber'),
            'group' => get_string('series_group', 'tool_certificateelement_autonumber'),
            'coursegroup' => get_string('series_coursegroup', 'tool_certificateelement_autonumber'),
            'manual' => get_string('series_manual', 'tool_certificateelement_autonumber'),
        ];
        $settings->add(new admin_setting_configselect(
            'tool_certificateelement_autonumber/seriesmode',
            get_string('seriesmode', 'tool_certificateelement_autonumber'),
            get_string('seriesmode_desc', 'tool_certificateelement_autonumber'),
            'course',
            $options
        ));

        // Manual series input.
        $settings->add(new admin_setting_configtext(
            'tool_certificateelement_autonumber/manualseries',
            get_string('manualseries', 'tool_certificateelement_autonumber'),
            get_string('manualseries_desc', 'tool_certificateelement_autonumber'),
            'SER'
        ));

        // Recalculation info.
        $settings->add(new admin_setting_heading(
            'tool_certificateelement_autonumber_recalculate',
            get_string('recalculate_numbers_heading', 'tool_certificateelement_autonumber'),
            get_string('recalculate_numbers_desc', 'tool_certificateelement_autonumber')
        ));

        // Uninstall behavior.
        $options = [
            'keep' => get_string('keep_plugin_data', 'tool_certificateelement_autonumber'),
            'delete' => get_string('delete_plugin_data', 'tool_certificateelement_autonumber'),
        ];
        $settings->add(new admin_setting_configselect(
            'tool_certificateelement_autonumber/uninstallmode',
            get_string('uninstallmode', 'tool_certificateelement_autonumber'),
            get_string('uninstallmode_desc', 'tool_certificateelement_autonumber'),
            'keep',
            $options
        ));

        $ADMIN->add('certificateelementplugins', $settings);
    }
}
