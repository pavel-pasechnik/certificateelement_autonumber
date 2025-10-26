# Moodle Plugin: Certificate Element AutoNumber

[![Moodle](https://img.shields.io/badge/Moodle-4.0--4.5-orange?logo=moodle&style=flat-square)](https://moodle.org/plugins/tool_certificate)
[![License: GPL v3](https://img.shields.io/badge/License-GPLv3-blue.svg?style=flat-square)](https://www.gnu.org/licenses/gpl-3.0)
[![Latest Release](https://img.shields.io/github/v/release/pavel-pasechnik/tool_certificateelement_autonumber?label=Download&style=flat-square)](https://github.com/pavel-pasechnik/tool_certificateelement_autonumber/releases/latest)
[![Build Status](https://github.com/pavel-pasechnik/tool_certificateelement_autonumber/actions/workflows/release.yml/badge.svg)](https://github.com/pavel-pasechnik/tool_certificateelement_autonumber/actions/workflows/release.yml)
[![Maintainer](https://img.shields.io/badge/Maintainer-Pavel%20Pasechnik-blue?style=flat-square)](https://github.com/pavel-pasechnik)

**Component:** `tool_certificateelement_autonumber`  
**Maintainer:** Pavel Pasechnik (Kyiv, Ukraine)  
**Compatible with:** Moodle 4.0 — 4.5+  
**License:** GNU GPL v3

---

## 📖 Description

The **Certificate Element AutoNumber** plugin extends the official Moodle Workplace Certificate System  
(`tool_certificate` and `mod_coursecertificate`) by adding **automatic series and sequential numbering**  
to issued certificates.

> ⚙️ **Dependencies:**  
> Requires the official Workplace plugins:
> - [`tool_certificate`](https://github.com/moodleworkplace/moodle-tool_certificate/tree/MOODLE_400_STABLE) — version **v4.0.0**  
> - [`mod_coursecertificate`](https://github.com/moodleworkplace/moodle-mod_coursecertificate/tree/MOODLE_400_STABLE) — version **v4.0.0**

---

## 🧩 Key Features

- Adds a new **dynamic field “Certificate number”** to the certificate template editor.
- Automatically generates numbers in the format:
  ```
  {SERIES}-{SEQUENCE}
  ```
  Example: `КДАСК-000123`
- Supports different numbering modes:
  | Mode | Description | Example |
  |-------|-------------|----------|
  | Course | Uses course shortname | `ШБ-000101` |
  | Group | Uses group ID | `БВ25-4-000021` |
  | Course + Group | Combined format | `TTC-TTC1-000015` |
  | Manual | Custom prefix defined per template | `КДАСК-000001` |
- Year is automatically derived from the issue date.
- Supports number reset each year and per series.
- Integrates with Moodle’s verification page (`view.php?code=XYZ123`).
- Automatically removes number when a certificate is revoked.

---

## ⚙️ Configuration

Navigate to  
**Site administration → Plugins → Certificate elements → AutoNumber**

Available options:
- **Series mode**: Defines how the series prefix is generated.  
- **Manual series**: Custom text prefix (used in Manual mode).
- **Recalculate numbers**: Admin button to rebuild all numbers based on current settings.

---

## 🔁 Recalculation

Admins can recalculate all existing certificate numbers using:
- The **“Recalculate numbers”** button in plugin settings  
  (runs `/admin/tool_certificateelement_autonumber/recalculate.php`)

Each issued certificate gets a new number consistent with the current numbering rules.

---

## 🌐 Localization

| Language  | File Path                                      | Status |
| --------- | ---------------------------------------------- | ------ |
| English   | `lang/en/tool_certificateelement_autonumber.php` | ✅     |
| Ukrainian | `lang/uk/tool_certificateelement_autonumber.php` | ✅     |
| Russian   | `lang/ru/tool_certificateelement_autonumber.php` | ✅     |

---

## 🧰 Developer Info

- Integrated via `certificateelement` API from `tool_certificate`.
- Dynamic field registered under `classes/local/dynamicfield/certnumber.php`.
- Observer listens to certificate issue/revoke events.
- Admin capability: `certificateelement/autonumber:manage`
- Full PHPCS compliance (Moodle coding standard).

---

## 📜 License

This plugin is distributed under the [GNU General Public License v3](https://www.gnu.org/licenses/gpl-3.0.html).
