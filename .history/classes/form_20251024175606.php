namespace certificateelement_autonumber;

use tool_certificate\element_form;

class form extends element_form {
    protected function definition_inner($mform) {
        $mform->addElement('select', 'seriespattern', get_string('seriespattern', 'tool_certificateelement_autonumber'), [
            'course' => get_string('bycourse', 'tool_certificateelement_autonumber'),
            'group' => get_string('bygroup', 'tool_certificateelement_autonumber'),
            'custom' => get_string('custom', 'tool_certificateelement_autonumber'),
            'combined' => get_string('combined', 'tool_certificateelement_autonumber'),
        ]);
        $mform->setDefault('seriespattern', 'course');

        $mform->addElement('text', 'customprefix', get_string('customprefix', 'tool_certificateelement_autonumber'));
        $mform->setType('customprefix', PARAM_ALPHANUMEXT);
    }
}
