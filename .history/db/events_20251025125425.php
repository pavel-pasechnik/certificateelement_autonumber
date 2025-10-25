$observers = [
    [
        'eventname'   => '\tool_certificate\event\certificate_issued',
        'callback'    => '\certificateelement_autonumber\element::issue_generated',
    ],
    [
        'eventname'   => '\tool_certificate\event\certificate_revoked',
        'callback'    => '\certificateelement_autonumber\element::issue_revoked',
    ],
];