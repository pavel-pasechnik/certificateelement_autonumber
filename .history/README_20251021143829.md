# Moodle Plugin: Local AutoNumber

[![Moodle](https://img.shields.io/badge/Moodle-4.0--4.5-orange?logo=moodle&style=flat-square)](https://moodle.org/plugins/local_autonumber)
[![License: GPL v3](https://img.shields.io/badge/License-GPLv3-blue.svg?style=flat-square)](https://www.gnu.org/licenses/gpl-3.0)
[![Latest Release](https://img.shields.io/github/v/release/pavel-pasechnik/autonumber?label=Download&style=flat-square)](https://github.com/pavel-pasechnik/autonumber/releases/latest)
[![Build Status](https://github.com/pavel-pasechnik/autonumber/actions/workflows/release.yml/badge.svg)](https://github.com/pavel-pasechnik/autonumber/actions/workflows/release.yml)
[![Maintainer](https://img.shields.io/badge/Maintainer-Pavel%20Pasechnik-blue?style=flat-square)](https://github.com/pavel-pasechnik)

**Component:** `local_autonumber`  
**Maintainer:** Pavel Pasechnik (Kyiv, Ukraine)  
**Compatible with:** Moodle 4.0 — 4.5+  
**License:** GNU GPL v3

---

## 📖 Description

The **Local AutoNumber** plugin automatically assigns **series and sequential registration numbers** to certificates issued through Moodle’s official **Certificate management system** (`tool_certificate` or `mod_customcert`).

> ⚠️ **Dependency:** Requires the official Moodle Certificate Management Plugin (`tool_certificate` or `mod_coursecertificate`).

It provides flexible numbering schemes and full integration with the verification system.

| Mode           | Description                        | Example              |
| -------------- | ---------------------------------- | -------------------- |
| Category       | Based on course category shortname | `ШБ25-000123`        |
| Group          | Based on user group shortname      | `БВ25-4-000123`      |
| Course + Group | Combined pattern                   | `TTC1-БВ25-4-000123` |
| Manual         | Fully custom template              | `КДАСК-№000001`      |

---

## 🧩 Key Features

- Automatic assignment of series and sequential numbers
- Integration with Moodle core verification (`view.php?code=...`)
- Integration with _My certificates_ page (custom renderer)
- CLI utility for generating numbers for imported certificates
- Multilingual interface (English, Ukrainian, Russian)
- 100% compatible with Moodle 4.0–4.5+ and `tool_certificate`

---

## ⚙️ Installation

1. Copy the `autonumber` folder into `local/`.
2. Visit _Site administration → Notifications_ to complete installation.
3. Configure numbering mode in  
   _Site administration → Plugins → Local plugins → Auto Numbering_.

---

## 🧰 Migration & CLI Tools

If you already have existing certificates, you can generate numbering records using:

```bash
php local/autonumber/cli/generate_for_existing.php
```

The script automatically generates numbers based on the issue date and ID  
(e.g., `КДАСК-№000101`) and saves them in the plugin table `mdl_local_autonumber`.

---

## 🔍 Verification

Issued certificates can be verified by:

1. Standard Moodle page  
   `/admin/tool/certificate/view.php?code=XYZ123`

This page shows verified data such as course, user, and issue date.

---

## 🌐 Localization

| Language  | File Path                      | Status |
| --------- | ------------------------------ | ------ |
| English   | `lang/en/local_autonumber.php` | ✅     |
| Ukrainian | `lang/uk/local_autonumber.php` | ✅     |
| Russian   | `lang/ru/local_autonumber.php` | ✅     |

---

## 🧩 Developer Info

- Renderer integration with `tool_certificate/my.php` adds custom column “Number”
- Observer assigns numbers on issue event
- CLI tools automate migration of existing data
- Localization handled through `get_string()` API

---

## 📜 License

This plugin is distributed under the [GNU General Public License v3](https://www.gnu.org/licenses/gpl-3.0.html).
