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
 * Upgrade script for the tool_certificateelement_autonumber plugin.
 *
 * @package    tool_certificateelement_autonumber
 * @copyright  2025 Pavel Pasechnik
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Executes upgrade steps between plugin versions.
 *
 * @param int $oldversion The version we are upgrading from
 * @return bool
 */
function xmldb_tool_certificateelement_autonumber_upgrade(int $oldversion): bool {
    global $DB;

    $dbman = $DB->get_manager();

    if ($oldversion < 2025102301) {
        // Example: Add a new field, table, etc.

        upgrade_plugin_savepoint(true, 2025102301, 'tool', 'certificateelement_autonumber');
    }

    return true;
}
