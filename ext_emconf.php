<?php

########################################################################
# Extension Manager/Repository config file for ext "org_npzch".
#
# Auto generated 14-09-2011 12:43
#
# Manual updates:
# Only the data in the array - everything else is removed by next
# writing. "version" and "dependencies" must not be touched!
########################################################################

$EM_CONF[$_EXTKEY] = array(
	'title' => 'Org +npz.ch - booking',
	'description' => 'Extends the Organiser with a booking system for npz.ch.',
	'category' => 'plugin',
	'shy' => 0,
	'version' => '1.1.0',
	'dependencies' => 'org',
	'conflicts' => '',
	'priority' => '',
	'loadOrder' => '',
	'module' => '',
	'state' => 'beta',
	'uploadfolder' => 1,
	'createDirs' => '',
	'modify_tables' => '',
	'clearcacheonload' => 1,
	'lockType' => '',
	'author' => 'Dirk Wildt (Die Netzmacher)',
	'author_email' => 'http://wildt.at.die-netzmacher.de',
	'author_company' => '',
	'CGLcompliance' => '',
	'CGLcompliance_note' => '',
	'constraints' => array(
		'depends' => array(
			'org' => '2.0.0-',
		),
		'conflicts' => array(
		),
		'suggests' => array(
		),
	),
  'suggests' => array(
  ),
	'_md5_values_when_last_written' => 'a:29:{s:9:"ChangeLog";s:4:"428e";s:21:"ext_conf_template.txt";s:4:"865b";s:12:"ext_icon.gif";s:4:"ec42";s:17:"ext_localconf.php";s:4:"2e68";s:14:"ext_tables.php";s:4:"0a9d";s:14:"ext_tables.sql";s:4:"b29e";s:16:"locallang_db.xml";s:4:"bfe7";s:7:"tca.php";s:4:"9783";s:21:"ext_icon/capacity.gif";s:4:"bee9";s:16:"ext_icon/cat.gif";s:4:"bee9";s:18:"ext_icon/npzch.gif";s:4:"bee9";s:25:"ext_icon/npzch_booked.gif";s:4:"39e3";s:27:"ext_icon/npzch_canceled.gif";s:4:"9efb";s:27:"ext_icon/npzch_reserved.gif";s:4:"e54a";s:18:"ext_icon/place.gif";s:4:"bee9";s:19:"ext_icon/status.gif";s:4:"bee9";s:37:"lib/class.tx_org_npzch_extmanager.php";s:4:"7112";s:17:"lib/locallang.xml";s:4:"cf20";s:20:"res/realurl_conf.php";s:4:"d41d";s:35:"res/html/npzch/11081301/default.css";s:4:"fc72";s:36:"res/html/npzch/11081301/default.tmpl";s:4:"d063";s:36:"res/html/npzch/11083001/default.tmpl";s:4:"c291";s:21:"res/js/slide-0.0.2.js";s:4:"4f65";s:25:"static/base/constants.txt";s:4:"636e";s:21:"static/base/setup.txt";s:4:"a121";s:35:"static/npzch/11081301/constants.txt";s:4:"2126";s:31:"static/npzch/11081301/setup.txt";s:4:"b392";s:20:"tsConfig/de/page.txt";s:4:"8402";s:25:"tsConfig/default/page.txt";s:4:"8402";}',
);

?>
