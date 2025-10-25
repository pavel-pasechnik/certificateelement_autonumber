# Moodle Plugin: Local AutoNumber

[![Moodle](https://img.shields.io/badge/Moodle-4.0--4.5-orange?logo=moodle&style=flat-square)](https://moodle.org/plugins/local_autonumber)
[![License: GPL v3](https://img.shields.io/badge/License-GPLv3-blue.svg?style=flat-square)](https://www.gnu.org/licenses/gpl-3.0)
[![Latest Release](https://img.shields.io/github/v/release/pavel-pasechnik/autonumber?label=Download&style=flat-square)](https://github.com/pavel-pasechnik/autonumber/releases/latest)
[![Maintainer](https://img.shields.io/badge/Maintainer-Pavel%20Pasechnik-blue?style=flat-square)](https://github.com/pavel-pasechnik)

**Component:** `local_autonumber`  
**Maintainer:** Pavel Pasechnik (Kyiv, Ukraine)  
**Compatible with:** Moodle 4.0 — 4.5  
**License:** GNU GPL v3

---

## 📖 Description

This plugin automatically assigns **sequential registration numbers** to certificates issued via the **Custom Certificate** module (`mod_customcert`).

It supports flexible numbering schemes:

| Mode           | Description                            | Example                   |
| -------------- | -------------------------------------- | ------------------------- |
| Category       | Based on the course category shortname | `ШБ25-2025-000123`        |
| Group          | Based on user group                    | `БВ25-4-2025-000123`      |
| Course + Group | Combination                            | `TTC1-БВ25-4-2025-000123` |
| Manual         | Fully custom pattern                   | `KDASK-year-№`            |

---

## 🧩 Features

- Uses certificate issue date for year reference
- Sequential numbering within the same year
- Localizable (English, Ukrainian, Russian)
- 100% compatible with Moodle core updates

---

## ⚙️ Installation

1. Copy folder `autonumber` to `local/`.
2. Go to _Site administration → Notifications_ to complete installation.
3. Configure under  
   _Site administration → Plugins → Local plugins → Auto Numbering_.

---

## 📜 License

This plugin is distributed under the [GNU General Public License v3](https://www.gnu.org/licenses/gpl-3.0.html).
