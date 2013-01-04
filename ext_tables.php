<?php
if (!defined ('TYPO3_MODE')) 
{
  die ('Access denied.');
}



  ////////////////////////////////////////////////////////////////////////////
  // 
  // INDEX
  
  // Configuration by the extension manager
  //    Localization support
  //    Store record configuration
  // Enables the Include Static Templates
  // Add pagetree icons
  // Configure third party tables
  // draft field tx_org_npzch
  //    fe_users
  //    tx_org_cal
  // TCA tables
  //    org_npzch
  //    org_npzch_capacity
  //    org_npzch_cat
  //    org_npzch_place



  /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 
  // Configuration by the extension manager
  
$confArr  = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$_EXTKEY]);

  // Language for labels of static templates and page tsConfig
$llStatic = $confArr['LLstatic'];
switch($llStatic) {
  case($llStatic == 'German'):
    $llStatic = 'de';
    break;
  default:
    $llStatic = 'default';
}
  // Language for labels of static templates and page tsConfig

  // Simplify the Organiser
$bool_exclude_none    = 1;
$bool_exclude_default = 1;
switch ($confArr['TCA_simplify_organiser'])
{
  case('None excluded: Editor has access to all'):
    $bool_exclude_none    = 0;
    $bool_exclude_default = 0;
    break;
  case('All excluded: Administrator configures it'):
      // All will be left true.
    break;
  case('Default (recommended)'):
    $bool_exclude_default = 0;
  default:
}
  // Simplify the Organiser

  // Simplify backend forms
$bool_time_control = true;
if (strtolower(substr($confArr['TCA_simplify_time_control'], 0, strlen('no'))) == 'no')
{
  $bool_time_control = false;
}
  // Simplify backend forms

  // Store record configuration
$bool_wizards_wo_add_and_list       = false;
$bool_full_wizardSupport_allTables  = true;
$str_marker_pid                     = '###CURRENT_PID###';
switch($confArr['store_records']) 
{
  case('Multi grouped: record groups in different directories'):
    //var_dump('MULTI');
    $str_store_record_conf        = 'pid IN (###PAGE_TSCONFIG_IDLIST###)';
    $bool_wizards_wo_add_and_list = true;
    break;
  case('Clear presented: each record group in one directory at most'):
    //var_dump('CLEAR');
    $str_store_record_conf        = 'pid IN (###PAGE_TSCONFIG_ID###)';
    $bool_wizards_wo_add_and_list = true;
    break;
  case('Easy 2: same as easy 1 but with storage pid'):
    $str_marker_pid         = '###STORAGE_PID###';
    $str_store_record_conf  = 'pid=###STORAGE_PID###';
    break;
  case('Easy 1: all in the same directory'):
  default:
    //var_dump('EASY');
    $str_store_record_conf        = 'pid=###CURRENT_PID###';
}
  // Store record configuration
  // Configuration of the extension manager



  ////////////////////////////////////////////////////////////////////////////
  // 
  // Enables the Include Static Templates

  // Case $llStatic
switch(true) {
  case($llStatic == 'de'):
      // German
    t3lib_extMgm::addStaticFile($_EXTKEY,'static/base/',            '+Org npz.ch: Basis (immer einbinden!)');
    t3lib_extMgm::addStaticFile($_EXTKEY,'static/npzch/11081301/',  '+Org npz.ch: Buchungen');
    break;
  default:
      // English
    t3lib_extMgm::addStaticFile($_EXTKEY,'static/base/',            '+Org npz.ch: Basis (obligate!)');
    t3lib_extMgm::addStaticFile($_EXTKEY,'static/npzch/11081301/',  '+Org npz.ch: Bookings');
}
  // Case $llStatic
  // Enables the Include Static Templates



  ////////////////////////////////////////////////////////////////////////////
  // 
  // Add pagetree icons

  // Case $llStatic
switch(true) {
  case($llStatic == 'de'):
      // German
    $TCA['pages']['columns']['module']['config']['items'][] = 
       array('Org: Workshop', 'org_wrkshp', t3lib_extMgm::extRelPath($_EXTKEY).'ext_icon/npzch.gif');
    break;
  default:
      // English
    $TCA['pages']['columns']['module']['config']['items'][] = 
       array('Org: Workshop', 'org_wrkshp', t3lib_extMgm::extRelPath($_EXTKEY).'ext_icon/npzch.gif');
}
  // Case $llStatic

$ICON_TYPES['org_wrkshp']   = array('icon' => t3lib_extMgm::extRelPath($_EXTKEY).'ext_icon/npzch.gif');

  // Add pagetree icons



  /////////////////////////////////////////////////
  //
  // Add default page and user TSconfig

t3lib_extMgm::addPageTSConfig('<INCLUDE_TYPOSCRIPT: source="FILE:EXT:' . $_EXTKEY . '/tsConfig/' . $llStatic . '/page.txt">');
  // Add default page and user TSconfig



  ////////////////////////////////////////////////////////////////////////////
  // 
  // Configure third party tables
  
  // draft field tx_org_npzch
  // fe_users
  // tx_org_cal
  // tx_org_headquarters

  // draft field tx_org_npzch
$arr_tx_org_npzch = array (
  'exclude' => 0,
  'label'   => 'LLL:EXT:org_npzch/locallang_db.xml:tca_phrase.npzch',
  'config'  => array (
    'type'     => 'select', 
    'size'     =>   30,
    'minitems' =>    0,
    'maxitems' =>    1,
    'MM'                  => '%MM%',
    'MM_opposite_field'   => 'fe_user',
    'foreign_table'       => 'tx_org_npzch',
    'foreign_table_where' => 'AND tx_org_npzch.' . $str_store_record_conf . ' ORDER BY tx_org_npzch.title',
    'wizards' => array(
      '_PADDING'  => 2,
      '_VERTICAL' => 0,
      'add' => array(
        'type'   => 'script',
        'title'  => 'LLL:EXT:org_npzch/locallang_db.xml:wizard.npzch.add',
        'icon'   => 'add.gif',
        'params' => array(
          'table'    => 'tx_org_npzch',
          'pid'      => $str_marker_pid,
          'setValue' => 'prepend'
        ),
        'script' => 'wizard_add.php',
      ),
      'list' => array(
        'type'   => 'script',
        'title'  => 'LLL:EXT:org_npzch/locallang_db.xml:wizard.npzch.list',
        'icon'   => 'list.gif',
        'params' => array(
          'table'   => 'tx_org_npzch',
          'pid'     => $str_marker_pid,
        ),
        'script' => 'wizard_list.php',
      ),
      'edit' => array(
        'type'                      => 'popup',
        'title'                     => 'LLL:EXT:org_npzch/locallang_db.xml:wizard.npzch.edit',
        'script'                    => 'wizard_edit.php',
        'popup_onlyOpenIfSelected'  => 1,
        'icon'                      => 'edit2.gif',
        'JSopenParams'              => 'height=350,width=580,status=0,menubar=0,scrollbars=1',
      ),
    ),
  ),
);
  // draft field tx_org_npzch

  // fe_users
t3lib_div::loadTCA('fe_users');

  // Add field tx_org_npzch
$showRecordFieldList = $TCA['fe_users']['interface']['showRecordFieldList'];
$showRecordFieldList = $showRecordFieldList.',tx_org_npzch';
$TCA['fe_users']['interface']['showRecordFieldList'] = $showRecordFieldList;
  // Add field tx_org_npzch

  // Add field tx_org_npzch
$TCA['fe_users']['columns']['tx_org_npzch']                  = $arr_tx_org_npzch;
$TCA['fe_users']['columns']['tx_org_npzch']['label']         =
  'LLL:EXT:org_npzch/locallang_db.xml:fe_users.tx_org_npzch';
$TCA['fe_users']['columns']['tx_org_npzch']['config']['MM']  = 'tx_org_npzch_mm_fe_users';
  // Add field tx_org_npzch

  // Insert div [npzch] at position $int_div_position
$str_showitem     = $TCA['fe_users']['types']['0']['showitem'];
$arr_showitem     = explode('--div--;', $str_showitem);
$int_div_position = 3;
foreach($arr_showitem as $key => $value)
{
  switch(true)
  {
    case($key < $int_div_position):
        // Don't move divs, which are placed before the new tab
      $arr_new_showitem[$key] = $value;
      break;
    case($key == $int_div_position):
        // Insert the new tab
      $arr_new_showitem[$key]     = 'LLL:EXT:org_npzch/locallang_db.xml:fe_users.div_tx_org_npzch, tx_org_npzch,';
        // Move former tab one position behind
      $arr_new_showitem[$key + 1] = $value;
      break;
    case($key > $int_div_position):
        // Move divs, which are placed after the new tab one position behind
      $arr_new_showitem[$key + 1] = $value;
      break;
  }
}
$str_showitem                 = implode('--div--;', $arr_new_showitem);
$TCA['fe_users']['types']['0']['showitem']   = $str_showitem;
  // Insert div [npzch] at position $int_div_position

$TCA['fe_users']['ctrl']['filter'] = 'filter_for_all_fields';
$TCA['fe_users']['columns']['tx_org_npzch']['config_filter'] =
  $TCA['fe_users']['columns']['tx_org_npzch']['config'];
$TCA['fe_users']['columns']['tx_org_npzch']['config_filter']['maxitems'] = 1;
$TCA['fe_users']['columns']['tx_org_npzch']['config_filter']['size']     = 1;
$items = array ('-99' => array ( '0' => '', '1' => '' ));
foreach( ( array) $TCA['fe_users']['columns']['tx_org_npzch']['config']['items'] as $key => $arrValue)
{
  $items[$key] = $arrValue;
}
$TCA['fe_users']['columns']['tx_org_npzch']['config_filter']['items'] = $items;


  
if($bool_wizards_wo_add_and_list)
{
  unset($TCA['fe_users']['columns']['tx_org_npzch']['config']['wizards']['add']);
  unset($TCA['fe_users']['columns']['tx_org_npzch']['config']['wizards']['list']);
}
  // fe_users

  // tx_org_cal
t3lib_div::loadTCA('tx_org_cal');

  // typeicons: Add type_icon
$TCA['tx_org_cal']['ctrl']['typeicons']['tx_org_npzch'] =
  t3lib_extmgm::extRelPath($_EXTKEY) . 'ext_icon/npzch.gif';
  // typeicons: Add type_icon

  // showRecordFieldList: Add field tx_org_npzch
$showRecordFieldList = $TCA['tx_org_cal']['interface']['showRecordFieldList'];
$showRecordFieldList = $showRecordFieldList.',tx_org_npzch';
$TCA['tx_org_cal']['interface']['showRecordFieldList'] = $showRecordFieldList;
  // showRecordFieldList: Add field tx_org_npzch

  // columns: Add field tx_org_npzch
$TCA['tx_org_cal']['columns']['tx_org_npzch']                  = $arr_tx_org_npzch;
$TCA['tx_org_cal']['columns']['tx_org_npzch']['label']         =
  'LLL:EXT:org_npzch/locallang_db.xml:tx_org_cal.tx_org_npzch';
$TCA['tx_org_cal']['columns']['tx_org_npzch']['config']['MM']  = 'tx_org_npzch_mm_tx_org_cal';
  // columns: Add field tx_org_npzch

  // columns: extend type
$TCA['tx_org_cal']['columns']['type']['config']['items']['tx_org_npzch'] = array
(
  '0' => 'LLL:EXT:org_npzch/locallang_db.xml:tx_org_cal.type.tx_org_npzch',
  '1' => 'tx_org_npzch',
  '2' => 'EXT:org_npzch/ext_icon/npzch.gif',
);
  // columns: extend type

//  // Insert type [tx_org_npzch] with fields to TCAtypes
//$TCA['tx_org_cal']['types']['tx_org_npzch']['showitem'] =
//  '--div--;LLL:EXT:org/locallang_db.xml:tx_org_cal.div_calendar,    type,title,datetime,tx_org_caltype,tx_org_npzch,'.
//  '--div--;LLL:EXT:org/locallang_db.xml:tx_org_cal.div_event,       tx_org_location,'.
//  '--div--;LLL:EXT:org/locallang_db.xml:tx_org_cal.div_department,  tx_org_department,'.
//  '--div--;LLL:EXT:org/locallang_db.xml:tx_org_cal.div_control,     hidden;;1;;,fe_group'.
//  ''
//;
  // Insert type [tx_org_npzch] with fields to TCAtypes
$TCA['tx_org_cal']['types']['tx_org_npzch']['showitem'] =
  '--div--;LLL:EXT:org/locallang_db.xml:tx_org_cal.div_calendar,    type,title,datetime,tx_org_npzch,'.
  '--div--;LLL:EXT:org/locallang_db.xml:tx_org_cal.div_control,     hidden;;1;;,fe_group'.
  ''
;
  // tx_org_cal
  // Configure third party tables



  ////////////////////////////////////////////////////////////////////////////
  // 
  // TCA tables

  // org_npzch
  // org_npzch_capacity
  // org_npzch_cat
  // org_npzch_place

  // org_npzch ////////////////////////////////////////////////////////////
$TCA['tx_org_npzch'] = array (
  'ctrl' => array (
    'title'             => 'LLL:EXT:org_npzch/locallang_db.xml:tx_org_npzch',
    'label'             => 'datetime_start',
    'label_alt'         => 'fe_user',
    'label_alt_force'   => 'true',
    'tstamp'            => 'tstamp',
    'crdate'            => 'crdate',
    'cruser_id'         => 'cruser_id',
    'default_sortby'    => 'ORDER BY datetime_start DESC',
    'delete'            => 'deleted',
    'enablecolumns'     => array (
      'disabled'  => 'hidden',
      'starttime' => 'starttime',
      'endtime'   => 'endtime',
      'fe_group'  => 'fe_group',
    ),
    'dividers2tabs'     => true,
    'hideAtCopy'        => true,
    'requestUpdate'     => 'static_countries',
    'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY).'tca.php',
    'thumbnail'         => 'image',
    'iconfile'          => t3lib_extMgm::extRelPath($_EXTKEY).'ext_icon/npzch.gif',
    'type'              => 'type',
    'typeicon_column'   => 'type',
    'typeicons'         => array(
      '0'         => '../typo3conf/ext/org_npzch/ext_icon/npzch_booked.gif',
      'canceled'  => '../typo3conf/ext/org_npzch/ext_icon/npzch_canceled.gif',
      'reserved'  => '../typo3conf/ext/org_npzch/ext_icon/npzch_reserved.gif',
    ),
      // be_tablefilter
//    'filter' => true,
    'filter' => 'filter_for_all_fields',
//    'filter' => 'filter_for_displayed_fields_only',
  ),
);
  // org_npzch /////////////////////////////////////////////////////////////////////

  // org_npzch_capacity ///////////////////////////////////////////////////////////////////
$TCA['tx_org_npzch_capacity'] = array (
  'ctrl' => array (
    'title'             => 'LLL:EXT:org_npzch/locallang_db.xml:tx_org_npzch_capacity',
    'label'             => 'title',
//    'label_alt'         => 'value',
//    'label_alt_force'   => 'true',
    'tstamp'            => 'tstamp',
    'crdate'            => 'crdate',
    'cruser_id'         => 'cruser_id',
    'sortby'            => 'sorting',
    'delete'            => 'deleted',
    'enablecolumns'     => array (
      'disabled'  => 'hidden',
    ),
    'dividers2tabs'     => true,
    'hideAtCopy'        => false,
    'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY).'tca.php',
    'thumbnail'         => 'image',
    'iconfile'          => t3lib_extMgm::extRelPath($_EXTKEY).'ext_icon/capacity.gif',
  ),
);
  // org_npzch_capacity ///////////////////////////////////////////////////////////////////

  // org_npzch_cat ///////////////////////////////////////////////////////////////////
$TCA['tx_org_npzch_cat'] = array (
  'ctrl' => array (
    'title'             => 'LLL:EXT:org_npzch/locallang_db.xml:tx_org_npzch_cat',
    'label'             => 'title',
//    'label_alt'         => 'short',
//    'label_alt_force'   => 'true',
    'tstamp'            => 'tstamp',
    'crdate'            => 'crdate',
    'cruser_id'         => 'cruser_id',
    'default_sortby'    => 'ORDER BY title',
    'delete'            => 'deleted',
    'enablecolumns'     => array (
      'disabled'  => 'hidden',
    ),
    'dividers2tabs'     => true,
    'hideAtCopy'        => false,
    'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY).'tca.php',
    'thumbnail'         => 'image',
    'iconfile'          => t3lib_extMgm::extRelPath($_EXTKEY).'ext_icon/cat.gif',
  ),
);
  // org_npzch_cat ///////////////////////////////////////////////////////////////////

  // org_npzch_place ///////////////////////////////////////////////////////////////////
$TCA['tx_org_npzch_place'] = array (
  'ctrl' => array (
    'title'             => 'LLL:EXT:org_npzch/locallang_db.xml:tx_org_npzch_place',
    'label'             => 'title',
//    'label_alt'         => 'short',
//    'label_alt_force'   => 'true',
    'tstamp'            => 'tstamp',
    'crdate'            => 'crdate',
    'cruser_id'         => 'cruser_id',
    'sortby'            => 'sorting',
    'delete'            => 'deleted',
    'enablecolumns'     => array (
      'disabled'  => 'hidden',
    ),
    'dividers2tabs'     => true,
    'hideAtCopy'        => false,
    'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY).'tca.php',
    'thumbnail'         => 'image',
    'iconfile'          => t3lib_extMgm::extRelPath($_EXTKEY).'ext_icon/place.gif',
  ),
);
  // org_npzch_place ///////////////////////////////////////////////////////////////////

  // TCA tables //////////////////////////////////////////////////////////////

?>