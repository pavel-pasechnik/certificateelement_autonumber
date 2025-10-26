# Certificate Element: AutoNumber

[![Moodle](https://img.shields.io/badge/Moodle-4.0--4.5-orange?logo=moodle&style=flat-square)](https://moodle.org/plugins/tool_certificate)
[![License: GPL v3](https://img.shields.io/badge/License-GPLv3-blue.svg?style=flat-square)](https://www.gnu.org/licenses/gpl-3.0)
[![Latest Release](https://img.shields.io/github/v/release/pavel-pasechnik/certificateelement_autonumber?label=Release&style=flat-square)](https://github.com/pavel-pasechnik/certificateelement_autonumber/releases/latest)
[![Coding Style](https://img.shields.io/badge/Coding%20Style-Moodle-blueviolet?style=flat-square)](https://moodledev.io/general/development/policies/codingstyle)

**Component:** `certificateelement_autonumber`  
**Type:** Certificate element for Moodle Workplace certificates  
**Maintainer:** Pavel Pasechnik (Kyiv, Ukraine)  
**License:** GNU GPL v3

---

## What It Does
- Adds the element **“Certificate number”** to the Workplace certificate designer.
- Generates a unique sequential number for every issued certificate.
- Keeps numbering global for the whole site and resets automatically on 1 January each year.
- Shows a zero-padded ten-digit value (for example `0000000042`) in the rendered certificate and in previews.

---

## Numbering Logic
1. When a certificate is issued, the plugin counts all `tool_certificate_issues` created in the same calendar year.  
2. The current issue receives the next available position; the result is saved in the table `certificate_autonumber`.  
3. Preview mode uses the current count + 1, so designers see how the value will look without reserving a number.  
4. If an issue is revoked, the corresponding record is deleted. Numbers are not reused and remain unique within the year.

---

## Installation
1. Copy this directory to `admin/tool/certificate/element/autonumber` in your Moodle codebase.  
2. Run the Moodle upgrade (`php admin/cli/upgrade.php`).  
3. Ensure the official Workplace components `tool_certificate` and `mod_coursecertificate` are installed, as they provide the certificate infrastructure.

---

## Using the Element
- Open any Workplace certificate template and add the element **“Certificate number”**.  
- Place and style it using the standard positioning controls.  
- No additional settings are required—the numbering runs automatically.  
- During preview the element displays what the next number will look like; the real value appears on issued certificates.

---

## Stored Data & Privacy
- The plugin creates the table `certificate_autonumber` with the fields `issueid`, `number`, and `year`.  
- Only technical identifiers are stored; no personal data is collected.  
- Records are removed if the matching certificate issue is revoked.

---

## Compatibility
- Tested with Moodle 4.0 – 4.5 (Workplace).  
- Requires the Workplace certificate stack (`tool_certificate`, `mod_coursecertificate`).  
- Release: 1.0.0 (`$plugin->version = 2022042000`).

---

## Development Notes
- The numbering is produced by `classes/generator.php` and rendered by the certificate element in `classes/element.php`.  
- Event observers in `classes/observer.php` listen to certificate issue and revoke events to keep the data table in sync.  
- Coding style follows the Moodle PHP guidelines; lint with `phpcs` if you make changes.
