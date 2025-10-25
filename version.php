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
 * @copyright  2025 Павел
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

// Plugin metadata.
$plugin->component = 'certificateelement_autonumber';
$plugin->subpluginof   = 'tool_certificate';
$plugin->version   = 2025102307;              // YYYYMMDDXX.
$plugin->requires  = 2024042200;              // Requires Moodle 4.4 or later.
$plugin->release   = '1.0.0';
$plugin->maturity  = MATURITY_STABLE;

$plugin->dependencies = [
    // Declare dependencies for correct installation order.
    'tool_certificate' => 2024042200, // Core Workplace certificate tool.
    'mod_coursecertificate' => 2024042200, // Course certificate module.
];
