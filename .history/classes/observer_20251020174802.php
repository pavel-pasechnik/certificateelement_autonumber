$mode = get_config('local_autonumber', 'mode') ?: 'manual';
$year = date('Y', $issue->timecreated);

// Определяем базовый префикс
switch ($mode) {
case 'category':
$category = $DB->get_field_sql("
SELECT cc.shortname
FROM {course} c
JOIN {course_categories} cc ON cc.id = c.category
WHERE c.id = ?", [$issue->courseid]);
$prefix = $category . '-' . $year . '-№';
break;

case 'group':
$group = $DB->get_field_sql("
SELECT g.name
FROM {groups} g
JOIN {groups_members} gm ON gm.groupid = g.id
WHERE gm.userid = ? AND g.courseid = ?
LIMIT 1", [$issue->userid, $issue->courseid]);
$prefix = $group . '-' . $year . '-№';
break;

case 'coursegroup':
$course = $DB->get_field('course', 'shortname', ['id' => $issue->courseid]);
$group = $DB->get_field_sql("
SELECT g.name
FROM {groups} g
JOIN {groups_members} gm ON gm.groupid = g.id
WHERE gm.userid = ? AND g.courseid = ?
LIMIT 1", [$issue->userid, $issue->courseid]);
$prefix = $course . '-' . $group . '-' . $year . '-№';
break;

case 'manual':
default:
$prefix = get_config('local_autonumber', 'seriesprefix') ?: 'KDA-year-№';
$prefix = str_replace('year', $year, $prefix);
break;
}