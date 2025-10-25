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
    $settings = new admin_settingpage('certificateelement_autonumber', get_string('pluginname', 'tool_certificateelement_autonumber'));

    // Настройка выбора режима серии.
    $options = [
        'course' => get_string('series_course', 'tool_certificateelement_autonumber'),
        'group' => get_string('series_group', 'tool_certificateelement_autonumber'),
        'coursegroup' => get_string('series_coursegroup', 'tool_certificateelement_autonumber'),
        'manual' => get_string('series_manual', 'tool_certificateelement_autonumber'),
    ];
    $settings->add(new admin_setting_configselect(
        'certificateelement_autonumber/seriesmode',
        get_string('seriesmode', 'tool_certificateelement_autonumber'),
        get_string('seriesmode_desc', 'tool_certificateelement_autonumber'),
        'course',
        $options
    ));

    // Настройка ручной серии.
    $settings->add(new admin_setting_configtext(
        'certificateelement_autonumber/manualseries',
        get_string('manualseries', 'tool_certificateelement_autonumber'),
        get_string('manualseries_desc', 'tool_certificateelement_autonumber'),
        'SER'
    ));

    // Кнопка пересчёта номеров.
    $url = new moodle_url('/admin/tool/certificateelement_autonumber/recalculate.php');
    $button = new single_button($url, get_string('recalculate_numbers', 'tool_certificateelement_autonumber'), 'get');
    $settings->add(new admin_setting_heading(
        'certificateelement_autonumber_recalculate',
        get_string('recalculate_numbers_heading', 'tool_certificateelement_autonumber'),
        $OUTPUT->render($button)
    ));

    $ADMIN->add('tools', $settings);
}
