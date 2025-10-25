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

namespace local_autonumber\output;

defined('MOODLE_INTERNAL') || die();

class renderer extends \plugin_renderer_base
{
    public function render_my_certificates_table($certificates) {
        global $DB;

        $table = new \html_table();
        $table->head = [
            get_string('name'),
            get_string('course'),
            get_string('date'),
            get_string('certnumber', 'local_autonumber'),
        ];

        foreach ($certificates as $c) {
            $number = $DB->get_field('local_autonumber', 'number', ['issueid' => $c->issueid]);
            $table->data[] = [
                format_string($c->name ?? '-'),
                format_string($c->coursename ?? '-'),
                userdate($c->timecreated ?? time()),
                $number ?: '—',
            ];
        }

        return html_writer::table($table);
    }
}
