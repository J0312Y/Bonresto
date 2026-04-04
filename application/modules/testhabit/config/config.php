<?php
// module directory name
$HmvcConfig['testhabit']["_title"]     = "Taste Habit Program";
$HmvcConfig['testhabit']["_description"] = "Manage Taste Habit";
$HmvcConfig['testhabit']["_version"]     = 1.1;


// register your module tables
// only register tables are imported while installing the module
$HmvcConfig['testhabit']['_database'] = true;
$HmvcConfig['testhabit']['_extra_query'] = true;
$HmvcConfig['testhabit']["_tables"] = array(
'tbl_habittrack');
