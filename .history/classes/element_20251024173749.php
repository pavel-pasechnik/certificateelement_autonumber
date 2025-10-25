namespace certificateelement_autonumber;

use tool_certificate\element;
use certificateelement_autonumber\generator;

class element extends element {
    public function render($pdf, $preview, $user) {
        if ($preview) {
            $text = 'SAMPLE-2025-000001';
        } else {
            $courseid = $this->get_context()->instanceid ?? 0;
            $groupid = null; // при желании можно извлечь из enrolments
            $pattern = $this->get_configdata_property('seriespattern');
            $text = generator::generate_number($user->id, $courseid, $groupid, $pattern);
        }
        $this->render_text($pdf, $text);
    }
}