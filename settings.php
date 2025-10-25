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
 * Admin settings for the certificateelement_autonumber plugin.
 *
 * @package    certificateelement_autonumber
 * @copyright  2025 Павел
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

if ($hassiteconfig) {
    $settings = new admin_settingpage(
        'certificateelement_autonumber',
        get_string('pluginname', 'certificateelement_autonumber')
    );

    // Setting the series mode selection.
    $options = [
        'course' => get_string('series_course', 'certificateelement_autonumber'),
        'group' => get_string('series_group', 'certificateelement_autonumber'),
        'coursegroup' => get_string('series_coursegroup', 'certificateelement_autonumber'),
        'manual' => get_string('series_manual', 'certificateelement_autonumber'),
    ];

    $settings->add(new admin_setting_configselect(
        'certificateelement_autonumber/seriesmode',
        get_string('seriesmode', 'certificateelement_autonumber'),
        get_string('seriesmode_desc', 'certificateelement_autonumber'),
        'course',
        $options
    ));

    // Manual series setup.
    $settings->add(new admin_setting_configtext(
        'certificateelement_autonumber/manualseries',
        get_string('manualseries', 'certificateelement_autonumber'),
        get_string('manualseries_desc', 'certificateelement_autonumber'),
        'SER'
    ));

    // Check for the presence of the certificateelement/autonumber:manage right before adding the recalculation button.
    $context = context_system::instance();
    if (has_capability('certificateelement/autonumber:manage', $context)) {
        $url = new moodle_url('/admin/tool/certificate/element/autonumber/recalculate.php');
        $button = new single_button($url, get_string('recalculate_numbers', 'certificateelement_autonumber'), 'get');
        $settings->add(new admin_setting_heading(
            'certificateelement_autonumber_recalculate',
            get_string('recalculate_numbers_heading', 'certificateelement_autonumber'),
            $OUTPUT->render($button)
        ));
    }

    // Add a choice of action when uninstalling the plugin.
    if (has_capability('certificateelement/autonumber:manage', $context)) {
        $options = [
            'keep' => get_string('keep_plugin_data', 'certificateelement_autonumber'),
            'delete' => get_string('delete_plugin_data', 'certificateelement_autonumber'),
        ];

        $settings->add(new admin_setting_configselect(
            'certificateelement_autonumber/uninstallmode',
            get_string('uninstallmode', 'certificateelement_autonumber'),
            get_string('uninstallmode_desc', 'certificateelement_autonumber'),
            'keep',
            $options
        ));

        $deleteurl = new moodle_url('/admin/tool/certificate/element/autonumber/uninstall.php');
        $deletebutton = new single_button(
            $deleteurl,
            get_string('execute_uninstall_action', 'certificateelement_autonumber'),
            'get'
        );
        $settings->add(new admin_setting_heading(
            'certificateelement_autonumber_delete',
            get_string('delete_plugin_data_heading', 'certificateelement_autonumber'),
            $OUTPUT->render($deletebutton)
        ));
    }

    $ADMIN->add('tools', $settings);
}
