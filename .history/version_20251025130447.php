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

$plugin->component = 'certificateelement_autonumber';
$plugin->version   = 2025102300;              // YYYYMMDDXX
$plugin->requires  = 2024042200;              // Requires Moodle 4.4 or later.
$plugin->release   = '1.0.0';
$plugin->maturity  = MATURITY_ALPHA;

// Dependencies.
$plugin->dependencies = [
    'tool_certificate' => 2024042200, // Core Workplace certificate tool.
    'mod_coursecertificate' => 2024042200, // Course certificate module.
];
