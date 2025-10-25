namespace certificateelement_autonumber;

defined('MOODLE_INTERNAL') || die();

class generator {
    /**
     * Генерирует новый номер сертификата на основе текущего года и контекста.
     */
    public static function generate_number($userid, $courseid, $groupid = null, $seriespattern = 'course') {
        global $DB;

        $year = date('Y');
        $prefix = self::generate_prefix($courseid, $groupid, $seriespattern);

        // Проверяем текущий максимум по этой серии и году.
        $sql = "SELECT MAX(seqnum) AS maxseq
                  FROM {certificateelement_autonumber}
                 WHERE year = :year AND series = :series";
        $params = ['year' => $year, 'series' => $prefix];
        $max = $DB->get_field_sql($sql, $params) ?? 0;
        $next = $max + 1;

        // Сохраняем запись.
        $record = (object)[
            'userid' => $userid,
            'courseid' => $courseid,
            'groupid' => $groupid,
            'year' => $year,
            'series' => $prefix,
            'seqnum' => $next,
            'created' => time()
        ];
        $DB->insert_record('certificateelement_autonumber', $record);

        // Формируем итоговый номер.
        return sprintf('%s-%04d-%06d', $prefix, $year, $next);
    }

    private static function generate_prefix($courseid, $groupid, $pattern) {
        switch ($pattern) {
            case 'course':
                return 'COURSE-' . $courseid;
            case 'group':
                return 'GROUP-' . $groupid;
            case 'custom':
                return get_config('certificateelement_autonumber', 'customprefix') ?: 'KDA';
            case 'combined':
                return 'KDA-' . $courseid . '-' . $groupid;
            default:
                return 'KDA';
        }
    }
}