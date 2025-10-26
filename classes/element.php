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

namespace certificateelement_autonumber;

use tool_certificate\element_helper;

/**
 * Certificate element that renders the generated number.
 *
 * @package   certificateelement_autonumber
 * @copyright 2025 Pavel Pasechnik
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

class element extends \tool_certificate\element {

    /**
     * Inject the common typography and positioning controls.
     *
     * @param \MoodleQuickForm $mform
     */
    public function render_form_elements($mform) {
        parent::render_form_elements($mform);
    }

    /**
     * Persist configuration.
     *
     * @param \stdClass $data
     */
    public function save_form_data(\stdClass $data) {
        // Element-specific configuration is not required yet, store an empty object.
        $data->data = json_encode(new \stdClass());
        parent::save_form_data($data);
    }

    /**
     * Draw the element content onto the generated PDF.
     *
     * @param \pdf $pdf
     * @param bool $preview
     * @param \stdClass $user
     * @param \stdClass|null $issue
     */
    public function render($pdf, $preview, $user, $issue) {
        [, $number] = $this->resolve_number($preview, $user, $issue);
        $content = $this->format_number($number);

        element_helper::render_content($pdf, $this, $content);
    }

    /**
     * Render HTML preview in the drag-and-drop designer.
     *
     * @return string
     */
    public function render_html() {
        $content = $this->format_number(1);

        return element_helper::render_html_content($this, $content);
    }

    /**
     * Helper to prepare data for the form.
     *
     * @return \stdClass|array
     */
    public function prepare_data_for_form() {
        return parent::prepare_data_for_form();
    }

    /**
     * Compose a display string for the generated number.
     *
     * @param int $number
     * @return string
     */
    protected function format_number(int $number): string {
        $padded = str_pad((string)$number, 10, '0', STR_PAD_LEFT);
        return format_string($padded);
    }

    /**
     * Resolve the numeric triplet to show, reusing the generator where possible.
     *
     * @param bool $preview
     * @param \stdClass $user
     * @param \stdClass|null $issue
     * @return array
     */
    protected function resolve_number(bool $preview, \stdClass $user, ?\stdClass $issue): array {
        global $DB;

        if ($preview || empty($issue) || empty($issue->id)) {
            // In preview mode we only count how many issues exist in the current year.
            $timecreated = ($issue && isset($issue->timecreated)) ? (int)$issue->timecreated : time();

            [, $number, $year] = generator::generate($timecreated);
            return ['', $number, (int)$year];
        }

        $record = $DB->get_record('certificate_autonumber', ['issueid' => $issue->id]);

        if (!$record) {
            // Fallback in case the observer has not persisted a number yet.
            $timecreated = isset($issue->timecreated) ? (int)$issue->timecreated : time();

            [, $number, $year] = generator::generate($timecreated, (int)$issue->id);
            $record = (object)[
                'issueid' => $issue->id,
                'number' => $number,
                'year' => $year,
            ];
            $DB->insert_record('certificate_autonumber', $record);
        }

        return ['', (int)$record->number, (int)$record->year];
    }
}
