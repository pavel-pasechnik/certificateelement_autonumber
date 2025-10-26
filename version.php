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
 * Version metadata for the certificateelement_autonumber plugin.
 *
 * @package    certificateelement_autonumber
 * @copyright  2025 Pavel Pasechnik
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

// Plugin metadata.
$plugin->component   = 'certificateelement_autonumber';
$plugin->subpluginof = 'tool_certificate';
$plugin->version      = 2025102601; // Incremented internal version.
$plugin->requires     = 2022041900.00; // Matches dependencies.
$plugin->release      = '1.0.0';
$plugin->maturity     = MATURITY_STABLE;
$plugin->supported    = [400, 405]; // Moodle 4.0–4.5 support range.

$plugin->dependencies = [
    'tool_certificate' => 2025031804, // Workplace certificate tool 4.5.7.
    'mod_coursecertificate' => 2025031804, // Course certificate module 4.5.7.
];
