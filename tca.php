<?php
  
  if (!defined ('TYPO3_MODE'))
  {
    die ('Access denied.');
  }
  
  
  
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //
    // INDEX
    // -----
    // Configuration by the extension manager
    //    Localization support
    //    Store record configuration
    // General Configuration
    // Wizard fe_users
    // Other wizards and config drafts
    // TCA
    //   tx_org_npzch
    //   tx_org_npzch_capacity
    //   tx_org_npzch_cat (master for category tables)
    //   tx_org_npzch_place
  
  
  
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //
    // Configuration by the extension manager
  
  $bool_LL = false;
  $confArr = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['org_npzch']);
  
    // Localization support
  if (strtolower(substr($confArr['LLsupport'], 0, strlen('yes'))) == 'yes')
  {
    $bool_LL = true;
  }
    // Localization support
  
    // Simplify the Organiser
  $bool_exclude_none    = true;
  $bool_exclude_default = true;
  switch ($confArr['TCA_simplify_organiser'])
  {
    case('None excluded: Editor has access to all'):
      $bool_exclude_none    = false;
      $bool_exclude_default = false;
      break;
    case('All excluded: Administrator configures it'):
        // All will be left true.
      break;
    case('Default (recommended)'):
      $bool_exclude_default = false;
    default:
  }
    // Simplify the Organiser
  
  
    // Simplify backend forms
  $bool_fegroup_control = true;
  if (strtolower(substr($confArr['TCA_simplify_fegroup_control'], 0, strlen('no'))) == 'no')
  {
    $bool_fegroup_control = false;
  }
  $bool_time_control = true;
  if (strtolower(substr($confArr['TCA_simplify_time_control'], 0, strlen('no'))) == 'no')
  {
    $bool_time_control = false;
  }
    // Simplify backend forms
  
    // Full wizard support
  $bool_full_wizardSupport_catTables = true;
  if (strtolower(substr($confArr['full_wizardSupport'], 0, strlen('no'))) == 'no')
  {
    $bool_full_wizardSupport_catTables = false;
  }
    // Full wizard support
  
    // Store record configuration
  $bool_wizards_wo_add_and_list = false;
  $str_marker_pid               = '###CURRENT_PID###';
  switch($confArr['store_records'])
  {
    case('Multi grouped: record groups in different directories'):
      $str_store_record_conf        = 'pid IN (###PAGE_TSCONFIG_IDLIST###)';
      $bool_wizards_wo_add_and_list = true;
      break;
    case('Clear presented: each record group in one directory at most'):
      $str_store_record_conf        = 'pid = ###PAGE_TSCONFIG_ID###';
      $bool_wizards_wo_add_and_list = true;
      break;
    case('Easy 2: same as easy 1 but with storage pid'):
      $str_marker_pid               = '###STORAGE_PID###';
      $str_store_record_conf        = 'pid=###STORAGE_PID###';
      break;
    case('Easy 1: all in the same directory'):
    default:
      $str_store_record_conf        = 'pid=###CURRENT_PID###';
  }
    // Store record configuration
  
  switch($confArr['full_wizardSupport'])
  {
    case('No'):
      $bool_wizards_wo_add_and_list_for_catTables = true;
      break;
    case('Yes (recommended)'):
    default:
      $bool_wizards_wo_add_and_list_for_catTables = false;
  }
    // Configuration by the extension manager
  
  
  
      /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
      //
      // General Configuration
  
      // JSopenParams for all wizards
    $JSopenParams     = 'height=680,width=800,status=0,menubar=0,scrollbars=1';
      // Rows of fe_group select box
    $size_fegroup     = 10;
      // General Configuration
  
  
  
      /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
      //
      // Wizard fe_users
  
      // Wizard for fe_users
    $arr_config_feuser = array(
      'type'                => 'select',
      'size'                => 30,
      'minitems'            => 0,
      'maxitems'            => 999,
      'foreign_table'       => 'fe_users',
      'foreign_table_where' => 'AND fe_users.' . $str_store_record_conf . ' ORDER BY fe_users.last_name',
      'wizards' => array(
        '_PADDING'  => 2,
        '_VERTICAL' => 0,
        'add' => array(
          'type'   => 'script',
          'title'  => 'LLL:EXT:org_npzch/locallang_db.xml:wizard.fe_user.add',
          'icon'   => 'add.gif',
          'params' => array(
            'table'    => 'fe_users',
            'pid'      => $str_marker_pid,
            'setValue' => 'prepend'
          ),
          'script' => 'wizard_add.php',
        ),
        'list' => array(
          'type'   => 'script',
          'title'  => 'LLL:EXT:org_npzch/locallang_db.xml:wizard.fe_user.list',
          'icon'   => 'list.gif',
          'params' => array(
            'table' => 'fe_users',
            'pid'   => $str_marker_pid,
          ),
          'script' => 'wizard_list.php',
        ),
        'edit' => array(
          'type'                      => 'popup',
          'title'                     => 'LLL:EXT:org_npzch/locallang_db.xml:wizard.fe_user.edit',
          'script'                    => 'wizard_edit.php',
          'popup_onlyOpenIfSelected'  => 1,
          'icon'                      => 'edit2.gif',
          'JSopenParams'              => $JSopenParams,
        ),
      ),
    );
    if($bool_wizards_wo_add_and_list)
    {
      unset($arr_config_feuser['wizards']['add']);
      unset($arr_config_feuser['wizards']['list']);
    }
      // Wizard for fe_users
  
      // Wizard for tx_org_npzch_cat ...
    $arr_tx_org_npzch_cat = array (
      'exclude'   => $bool_exclude_default,
      'label'     => 'LLL:EXT:org_npzch/locallang_db.xml:tx_org_npzch.tx_org_npzch_cat',
      'config'    => array (
        'type'      => 'select',
        'size'      => 10,
        'minitems'  => 0,
        'maxitems'  => 99,
        'MM'                  => 'tx_org_npzch_mm_tx_org_npzch_cat',
        'foreign_table'       => 'tx_org_npzch_cat',
        'foreign_table_where' => 'AND tx_org_npzch_cat.' . $str_store_record_conf . ' AND tx_org_npzch_cat.hidden=0 ORDER BY tx_org_npzch_cat.title',
//        'wizards' => array(
//          '_PADDING'  => 2,
//          '_VERTICAL' => 0,
//          'add' => array(
//            'type'   => 'script',
//            'title'  => 'LLL:EXT:org_npzch/locallang_db.xml:wizard.tx_org_npzch_cat.add',
//            'icon'   => 'add.gif',
//            'params' => array(
//              'table'    => 'tx_org_npzch_cat',
//              'pid'      => $str_marker_pid,
//              'setValue' => 'prepend'
//            ),
//            'script' => 'wizard_add.php',
//          ),
//          'list' => array(
//            'type'   => 'script',
//            'title'  => 'LLL:EXT:org_npzch/locallang_db.xml:wizard.tx_org_npzch_cat.list',
//            'icon'   => 'list.gif',
//            'params' => array(
//              'table' => 'tx_org_npzch_cat',
//              'pid'   => $str_marker_pid,
//            ),
//            'script' => 'wizard_list.php',
//          ),
//          'edit' => array(
//            'type'                      => 'popup',
//            'title'                     => 'LLL:EXT:org_npzch/locallang_db.xml:wizard.tx_org_npzch_cat.edit',
//            'script'                    => 'wizard_edit.php',
//            'popup_onlyOpenIfSelected'  => 1,
//            'icon'                      => 'edit2.gif',
//            'JSopenParams'              => $JSopenParams,
//          ),
//        ),
      ),
    );
    $arr_tx_org_npzch_cat_max_1 = $arr_tx_org_npzch_cat;
    $arr_tx_org_npzch_cat_max_1['config']['items']    = array (array ('', null) );
    $arr_tx_org_npzch_cat_max_1['config']['maxitems'] = 1;
    $arr_tx_org_npzch_cat_max_1['config']['size']     = 7;
      // Wizard for tx_org_npzch_cat ...
  
      // Wizard fe_users
  
  
  
      /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
      //
      // Other wizards and config drafts
  
    $arr_wizard_url = array (
      'type'      => 'input',
      'size'      => '80',
      'max'       => '256',
      'checkbox'  => '',
      'eval'      => 'trim',
      'wizards'   => array (
        '_PADDING'  => '2',
        'link'      => array (
          'type'         => 'popup',
          'title'        => 'Link',
          'icon'         => 'link_popup.gif',
          'script'       => 'browse_links.php?mode=wizard',
          'JSopenParams' => $JSopenParams,
        ),
      ),
      'softref' => 'typolink',
    );
  
    $conf_datetime = array (
      'type'    => 'input',
      'size'    => '10',
      'max'     => '20',
      'eval'    => 'required,datetime',
      'default' => mktime(date('H'),date('i'),0,date('m'),date('d'),date('Y'))
    );
    
    $conf_file_document = array (
      'type'          => 'group',
      'internal_type' => 'file',
      'allowed'       => '',
      'disallowed'    => 'php,php3',
      'max_size'      => $GLOBALS['TYPO3_CONF_VARS']['BE']['maxFileSize'],
      'uploadfolder'  => 'uploads/tx_org',
      'size'          => 10,
      'minitems'      => 0,
      'maxitems'      => 99,
    );
  
    $conf_file_image = array (
      'type'          => 'group',
      'internal_type' => 'file',
      'allowed'       => $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext'],
      'max_size'      => $GLOBALS['TYPO3_CONF_VARS']['BE']['maxFileSize'],
      'uploadfolder'  => 'uploads/tx_org',
      'show_thumbs'   => 1,
      'size'          => 3,
      'minitems'      => 0,
      'maxitems'      => 20,
    );
  
    $conf_input_01_trimUpperRequired = array (
      'type' => 'input',
      'size' => '1',
      'eval' => 'trim,upper,required'
    );
  
    $conf_input_30_trim = array (
      'type' => 'input',
      'size' => '30',
      'eval' => 'trim'
    );
  
    $conf_input_30_trimRequired = array (
      'type' => 'input',
      'size' => '30',
      'eval' => 'trim,required'
    );
  
    $conf_input_80_trim = array (
      'type' => 'input',
      'size' => '80',
      'eval' => 'trim'
    );
    $conf_text_30_05 = array (
      'type' => 'text',
      'cols' => '30',
      'rows' => '5',
    );
  
    $conf_text_50_10 = array (
      'type' => 'text',
      'cols' => '50',
      'rows' => '10',
    );
  
    $conf_text_rte = array (
      'type' => 'text',
      'cols' => '30',
      'rows' => '5',
      'wizards' => array(
        '_PADDING' => 2,
        'RTE' => array(
          'notNewRecords' => 1,
          'RTEonly'       => 1,
          'type'          => 'script',
          'title'         => 'Full screen Rich Text Editing|Formatteret redigering i hele vinduet',
          'icon'          => 'wizard_rte2.gif',
          'script'        => 'wizard_rte.php',
        ),
      ),
    );
  
    $conf_hidden = array (
      'exclude' => $bool_exclude_default,
      'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
      'config'  => array (
        'type'    => 'check',
        'default' => '0'
      )
    );
    $conf_starttime = array (
      'exclude' => $bool_time_control,
      'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.starttime',
      'config'  => array (
        'type'     => 'input',
        'size'     => '8',
        'max'      => '20',
        'eval'     => 'date',
        'default'  => '0',
        'checkbox' => '0'
      )
    );
    $conf_endtime = array (
      'exclude' => $bool_time_control,
      'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.endtime',
      'config'  => array (
        'type'     => 'input',
        'size'     => '8',
        'max'      => '20',
        'eval'     => 'date',
        'checkbox' => '0',
        'default'  => '0',
        'range'    => array (
          'upper' => mktime(0, 0, 0, date('m'), date('d'), date('Y')+30),
          'lower' => mktime(0, 0, 0, date('m')-1, date('d'), date('Y'))
        )
      )
    );
    $conf_fegroup = array (
      'exclude'     => $bool_fegroup_control,
      'l10n_mode'   => 'mergeIfNotBlank',
      'label'       => 'LLL:EXT:lang/locallang_general.php:LGL.fe_group',
      'config'      => array (
        'type'      => 'select',
        'size'      => $size_fegroup,
        'maxitems'  => 20,
        'items' => array (
          array('LLL:EXT:lang/locallang_general.php:LGL.hide_at_login', -1),
          array('LLL:EXT:lang/locallang_general.php:LGL.any_login', -2),
          array('LLL:EXT:lang/locallang_general.php:LGL.usergroups', '--div--')
        ),
        'exclusiveKeys' => '-1,-2',
        'foreign_table' => 'fe_groups'
      )
    );
    // Other wizards and config drafts
  
  
  
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //
    // tx_org_npzch - without any localisation support
  
  
  
  $TCA['tx_org_npzch'] = array (
    'ctrl' => $TCA['tx_org_npzch']['ctrl'],
    'interface' => array (
      'showRecordFieldList' =>  'type, title, short, occasion,datetime_start,datetime_end,'.
                                'tx_org_npzch_capacity, tx_org_npzch_cat, tx_org_npzch_place,'.
                                'fe_user,'.
                                'tx_org_cal,'.
                                'hidden, starttime, endtime, fe_group,'.
                                'keywords, description',
    ),
    'feInterface' => $TCA['tx_org_npzch']['feInterface'],
    'columns' => array (
      'type' => array (
        'exclude'   => $bool_exclude_default,
        'label'     => 'LLL:EXT:org_npzch/locallang_db.xml:tx_org_npzch.type',
        'config'    => array (
          'type'    => 'select', 
          'items'   => array (
            '0' => array (
              '0' => 'LLL:EXT:org_npzch/locallang_db.xml:tx_org_npzch.type.booked',
              '1' => '0',
              '2' => 'EXT:org_npzch/ext_icon/npzch_booked.gif',
            ),
            'reserved' => array (
              '0' => 'LLL:EXT:org_npzch/locallang_db.xml:tx_org_npzch.type.reserved',
              '1' => 'reserved',
              '2' => 'EXT:org_npzch/ext_icon/npzch_reserved.gif',
            ),
            'canceled' => array (
              '0' => 'LLL:EXT:org_npzch/locallang_db.xml:tx_org_npzch.type.canceled',
              '1' => 'canceled',
              '2' => 'EXT:org_npzch/ext_icon/npzch_canceled.gif',
            ),
          ),
          'default' => '0',
        ),
      ),
      'title' => array (
        'exclude'   => 0,
        'label'     => 'LLL:EXT:org_npzch/locallang_db.xml:tx_org_npzch.title',
        'config'    => $conf_input_30_trimRequired,
      ),
      'short' => array (
        'exclude' => $bool_exclude_default,
        'label'   => 'LLL:EXT:org_npzch/locallang_db.xml:tx_org_npzch.short',
        'config'  => $conf_text_50_10,
      ),
      'occasion' => array (
        'exclude'   => $bool_exclude_default,
        'label'     => 'LLL:EXT:org_npzch/locallang_db.xml:tx_org_npzch.occasion',
        'config'    => $conf_text_rte,
      ),
      'datetime_start' => array (
        'exclude'   => $bool_exclude_default,
        'label'     => 'LLL:EXT:org_npzch/locallang_db.xml:tx_org_npzch.datetime_start',
        'config'    => $conf_datetime,
      ),
      'datetime_end' => array (
        'exclude'   => $bool_exclude_default,
        'label'     => 'LLL:EXT:org_npzch/locallang_db.xml:tx_org_npzch.datetime_end',
        'config'    => $conf_datetime,
      ),
      'tx_org_npzch_capacity' => $arr_tx_org_npzch_cat_max_1,
      'tx_org_npzch_cat'      => $arr_tx_org_npzch_cat_max_1,
      'tx_org_npzch_place'    => $arr_tx_org_npzch_cat_max_1,
      'fe_user' => array (
        'exclude' => $bool_exclude_default,
        'label'   => 'LLL:EXT:org_npzch/locallang_db.xml:tx_org_npzch.fe_user',
        'config'  => $arr_config_feuser,
      ),
      'tx_org_cal'            => $arr_tx_org_npzch_cat,
      'hidden'    => $conf_hidden,
      'starttime' => $conf_starttime,
      'endtime'   => $conf_endtime,
      'fe_group'  => $conf_fegroup,
      'keywords' => array (
        'label'   => 'LLL:EXT:org_npzch/locallang_db.xml:tca_phrase.keywords',
        'exclude' => $bool_exclude_default,
        'config'  => $conf_input_80_trim,
      ),
      'description' => array (
        'label'   => 'LLL:EXT:org_npzch/locallang_db.xml:tca_phrase.description',
        'exclude' => $bool_exclude_default,
        'config'  => $conf_text_50_10,
      ),
    ),
    'types' => array (
      '0' =>  array
                    ('showitem' =>  
                      '--div--;LLL:EXT:org_npzch/locallang_db.xml:tx_org_npzch.div_booking,' .
                        'type, title, short, occasion,' . 
                        '--palette--;LLL:EXT:org_npzch/locallang_db.xml:tx_org_npzch.palette_appointment;appointment,' .
                      '--div--;LLL:EXT:org_npzch/locallang_db.xml:tx_org_npzch.div_fe_user,' . 
                        'fe_user,'.
                      '--div--;LLL:EXT:org_npzch/locallang_db.xml:tx_org_npzch.div_categories,' .
                        'tx_org_npzch_capacity, tx_org_npzch_cat, tx_org_npzch_place,'.
                      '--div--;LLL:EXT:org_npzch/locallang_db.xml:tx_org_npzch.div_access,' . 
                        'hidden;;1;;,fe_group'.
                      '--div--;LLL:EXT:org_npzch/locallang_db.xml:tx_org_npzch.div_seo,' . 
                        'keywords, description,'.
                    ''),
      'canceled' =>  array
                    ('showitem' =>  
                      '--div--;LLL:EXT:org_npzch/locallang_db.xml:tx_org_npzch.div_booking,' .
                        'type, title, short, occasion,' . 
                        '--palette--;LLL:EXT:org_npzch/locallang_db.xml:tx_org_npzch.palette_appointment;appointment,' .
                      '--div--;LLL:EXT:org_npzch/locallang_db.xml:tx_org_npzch.div_fe_user,' . 
                        'fe_user,'.
                      '--div--;LLL:EXT:org_npzch/locallang_db.xml:tx_org_npzch.div_categories,' .
                        'tx_org_npzch_capacity, tx_org_npzch_cat, tx_org_npzch_place,'.
                      '--div--;LLL:EXT:org_npzch/locallang_db.xml:tx_org_npzch.div_access,' . 
                        'hidden;;1;;,fe_group'.
                      '--div--;LLL:EXT:org_npzch/locallang_db.xml:tx_org_npzch.div_seo,' . 
                        'keywords, description,'.
                    ''),
      'reserved' =>  array
                    ('showitem' =>  
                      '--div--;LLL:EXT:org_npzch/locallang_db.xml:tx_org_npzch.div_booking,' .
                        'type, title, short, occasion,' . 
                        '--palette--;LLL:EXT:org_npzch/locallang_db.xml:tx_org_npzch.palette_appointment;appointment,' .
                      '--div--;LLL:EXT:org_npzch/locallang_db.xml:tx_org_npzch.div_fe_user,' . 
                        'fe_user,'.
                      '--div--;LLL:EXT:org_npzch/locallang_db.xml:tx_org_npzch.div_categories,' .
                        'tx_org_npzch_capacity, tx_org_npzch_cat, tx_org_npzch_place,'.
                      '--div--;LLL:EXT:org_npzch/locallang_db.xml:tx_org_npzch.div_access,' . 
                        'hidden;;1;;,fe_group'.
                      '--div--;LLL:EXT:org_npzch/locallang_db.xml:tx_org_npzch.div_seo,' . 
                        'keywords, description,'.
                    ''),
    ),
  //      '--div--;LLL:EXT:org_npzch/locallang_db.xml:tx_org_npzch.div_cal,' .
  //        'tx_org_cal,'.
    'palettes' => array (
      '1' =>  array
              (
                'showitem' => 'starttime,endtime,'
              ),
      'appointment' =>  array
                        (
                          'showitem' => 'datetime_start,LLL:EXT:org_npzch/locallang_db.xml:tx_org_npzch.datetime_start,' . 
                                        'datetime_end,LLL:EXT:org_npzch/locallang_db.xml:tx_org_npzch.datetime_end,',
                          'canNotCollapse' => 1,
                        ),
    )
  );

    // Relation fe_user
  $TCA['tx_org_npzch']['columns']['fe_user']['config']['MM'] =
    'tx_org_npzch_mm_fe_users';
    // Relation fe_user
  
    // Relation tx_org_npzch_capacity
  $TCA['tx_org_npzch']['columns']['tx_org_npzch_capacity']['label'] =
    'LLL:EXT:org_npzch/locallang_db.xml:tx_org_npzch.tx_org_npzch_capacity';
  unset($TCA['tx_org_npzch']['columns']['tx_org_npzch_capacity']['config']['items']);
  $TCA['tx_org_npzch']['columns']['tx_org_npzch_capacity']['config']['minitems'] = 1;
  $TCA['tx_org_npzch']['columns']['tx_org_npzch_capacity']['config']['size'] = 6;
//:TODO:
  $TCA['tx_org_npzch']['columns']['tx_org_npzch_capacity']['config']['MM'] =
    'tx_org_npzch_mm_tx_org_npzch_capacity';
  $TCA['tx_org_npzch']['columns']['tx_org_npzch_capacity']['config']['foreign_table'] =
    'tx_org_npzch_capacity';
  $TCA['tx_org_npzch']['columns']['tx_org_npzch_capacity']['config']['foreign_table_where'] =
    'AND tx_org_npzch_capacity.' . $str_store_record_conf . ' AND tx_org_npzch_capacity.hidden=0 ORDER BY tx_org_npzch_capacity.sorting';
  $TCA['tx_org_npzch']['columns']['tx_org_npzch_capacity']['config']['wizards']['add']['title'] =
    'LLL:EXT:org_npzch/locallang_db.xml:wizard.tx_org_npzch_capacity.add';
  $TCA['tx_org_npzch']['columns']['tx_org_npzch_capacity']['config']['wizards']['add']['params']['table'] =
    'tx_org_npzch_capacity';
  $TCA['tx_org_npzch']['columns']['tx_org_npzch_capacity']['config']['wizards']['list']['title'] =
    'LLL:EXT:org_npzch/locallang_db.xml:wizard.tx_org_npzch_capacity.list';
  $TCA['tx_org_npzch']['columns']['tx_org_npzch_capacity']['config']['wizards']['edit']['title'] =
    'LLL:EXT:org_npzch/locallang_db.xml:wizard.tx_org_npzch_capacity.edit';
  $TCA['tx_org_npzch']['columns']['tx_org_npzch_capacity']['config']['wizards']['list']['params']['table'] =
    'tx_org_npzch_capacity';
  if($bool_wizards_wo_add_and_list_for_catTables)
  {
    unset($TCA['tx_org_npzch']['columns']['tx_org_npzch_capacity']['config']['wizards']['add']);
    unset($TCA['tx_org_npzch']['columns']['tx_org_npzch_capacity']['config']['wizards']['list']);
  }
    // Relation tx_org_npzch_capacity
  
    // Relation tx_org_npzch_place
  $TCA['tx_org_npzch']['columns']['tx_org_npzch_place']['label'] =
    'LLL:EXT:org_npzch/locallang_db.xml:tx_org_npzch.tx_org_npzch_place';
  $TCA['tx_org_npzch']['columns']['tx_org_npzch_place']['config']['MM'] =
    'tx_org_npzch_mm_tx_org_npzch_place';
  $TCA['tx_org_npzch']['columns']['tx_org_npzch_place']['config']['foreign_table'] =
    'tx_org_npzch_place';
  $TCA['tx_org_npzch']['columns']['tx_org_npzch_place']['config']['foreign_table_where'] =
    'AND tx_org_npzch_place.' . $str_store_record_conf . ' AND tx_org_npzch_place.hidden=0 ORDER BY tx_org_npzch_place.sorting';
  $TCA['tx_org_npzch']['columns']['tx_org_npzch_place']['config']['wizards']['add']['title'] =
    'LLL:EXT:org_npzch/locallang_db.xml:wizard.tx_org_npzch_place.add';
  $TCA['tx_org_npzch']['columns']['tx_org_npzch_place']['config']['wizards']['add']['params']['table'] =
    'tx_org_npzch_place';
  $TCA['tx_org_npzch']['columns']['tx_org_npzch_place']['config']['wizards']['list']['title'] =
    'LLL:EXT:org_npzch/locallang_db.xml:wizard.tx_org_npzch_place.list';
  $TCA['tx_org_npzch']['columns']['tx_org_npzch_place']['config']['wizards']['edit']['title'] =
    'LLL:EXT:org_npzch/locallang_db.xml:wizard.tx_org_npzch_place.edit';
  $TCA['tx_org_npzch']['columns']['tx_org_npzch_place']['config']['wizards']['list']['params']['table'] =
    'tx_org_npzch_place';
  if($bool_wizards_wo_add_and_list_for_catTables)
  {
    unset($TCA['tx_org_npzch']['columns']['tx_org_npzch_place']['config']['wizards']['add']);
    unset($TCA['tx_org_npzch']['columns']['tx_org_npzch_place']['config']['wizards']['list']);
  }
    // Relation tx_org_npzch_place
  
    // Relation tx_org_cal
  $TCA['tx_org_npzch']['columns']['tx_org_cal']['label'] =
    'LLL:EXT:org_npzch/locallang_db.xml:tx_org_npzch.tx_org_cal';
  $TCA['tx_org_npzch']['columns']['tx_org_cal']['config']['MM'] =
    'tx_org_npzch_mm_tx_org_cal';
  $TCA['tx_org_npzch']['columns']['tx_org_cal']['config']['foreign_table'] =
    'tx_org_cal';
  $TCA['tx_org_npzch']['columns']['tx_org_cal']['config']['foreign_table_where'] =
    'AND tx_org_cal.' . $str_store_record_conf . ' AND tx_org_cal.hidden=0 AND tx_org_cal.sys_language_uid=###REC_FIELD_sys_language_uid### AND tx_org_cal.hidden=0 AND tx_org_cal.deleted=0 ORDER BY tx_org_cal.datetime DESC, tx_org_cal.title';
  $TCA['tx_org_npzch']['columns']['tx_org_cal']['config']['wizards']['add']['title'] =
    'LLL:EXT:org_npzch/locallang_db.xml:wizard.tx_org_cal.add';
  $TCA['tx_org_npzch']['columns']['tx_org_cal']['config']['wizards']['add']['params']['table'] =
    'tx_org_cal';
  $TCA['tx_org_npzch']['columns']['tx_org_cal']['config']['wizards']['list']['title'] =
    'LLL:EXT:org_npzch/locallang_db.xml:wizard.tx_org_cal.list';
  $TCA['tx_org_npzch']['columns']['tx_org_cal']['config']['wizards']['edit']['title'] =
    'LLL:EXT:org_npzch/locallang_db.xml:wizard.tx_org_cal.edit';
  $TCA['tx_org_npzch']['columns']['tx_org_cal']['config']['wizards']['list']['params']['table'] =
    'tx_org_cal';
  if($bool_wizards_wo_add_and_list)
  {
    unset($TCA['tx_org_npzch']['columns']['tx_org_cal']['config']['wizards']['add']);
    unset($TCA['tx_org_npzch']['columns']['tx_org_cal']['config']['wizards']['list']);
  }
    // Relation tx_org_cal
  
    // be_tablefilter
  $TCA['tx_org_npzch']['columns']['datetime_start']['config_filter'] =
    $TCA['tx_org_npzch']['columns']['datetime_start']['config'];
  $TCA['tx_org_npzch']['columns']['datetime_start']['config_filter']['fromto'] = true;
  $TCA['tx_org_npzch']['columns']['datetime_start']['config_filter']['fromto_labels']['from'] =
    'LLL:EXT:org_npzch/locallang_db.xml:tx_org_npzch.datetime_start.from';
  $TCA['tx_org_npzch']['columns']['datetime_start']['config_filter']['fromto_labels']['to'] =
    'LLL:EXT:org_npzch/locallang_db.xml:tx_org_npzch.datetime_start.to';

  $TCA['tx_org_npzch']['columns']['fe_user']['config_filter'] =
    $TCA['tx_org_npzch']['columns']['fe_user']['config'];
  $TCA['tx_org_npzch']['columns']['fe_user']['config_filter']['maxitems'] = 1;
  $TCA['tx_org_npzch']['columns']['fe_user']['config_filter']['size']     = 1;
  $items = array ('-99' => array ( '0' => '', '1' => '' ));
  foreach($TCA['tx_org_npzch']['columns']['fe_user']['config']['items'] as $key => $arrValue)
  {
    $items[$key] = $arrValue;
  }
  $TCA['tx_org_npzch']['columns']['fe_user']['config_filter']['items'] = $items;
  unset($TCA['tx_org_npzch']['columns']['fe_user']['config_filter']['wizards']);

  $TCA['tx_org_npzch']['columns']['tx_org_npzch_place']['config_filter'] =
    $TCA['tx_org_npzch']['columns']['tx_org_npzch_place']['config'];
  $TCA['tx_org_npzch']['columns']['tx_org_npzch_place']['config_filter']['size'] = 1;

  $TCA['tx_org_npzch']['columns']['type']['config_filter'] =
    $TCA['tx_org_npzch']['columns']['type']['config'];
  $items = array ('-99' => array ( '0' => '', '1' => '' ));
  foreach($TCA['tx_org_npzch']['columns']['type']['config']['items'] as $key => $arrValue)
  {
    $items[$key] = $arrValue;
  }
  $TCA['tx_org_npzch']['columns']['type']['config_filter']['items'] = $items;
    // be_tablefilter
  
    // tx_org_npzch - without any localisation support
  
  
  
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //
    // tx_org_npzch_cat (master for category tables)
  
  $TCA['tx_org_npzch_cat'] = array (
    'ctrl' => $TCA['tx_org_npzch_cat']['ctrl'],
    'interface' => array (
      'showRecordFieldList' =>  'title,short,tx_org_npzch,'.
                                'hidden'
    ),
    'feInterface' => $TCA['tx_org_npzch_cat']['feInterface'],
    'columns' => array (
      'title' => array (
        'exclude' => 0,
        'label' => 'LLL:EXT:org_npzch/locallang_db.xml:tx_org_npzch_cat.title',
        'config'  => $conf_input_30_trimRequired,
      ),
      'short' => array (
        'exclude'   => 0,
        'label'     => 'LLL:EXT:org_npzch/locallang_db.xml:tx_org_npzch_cat.short',
        'config'    => $conf_input_01_trimUpperRequired,
      ),
      'tx_org_npzch'  => $arr_tx_org_npzch_cat,
      'hidden'        => $conf_hidden,
    ),
    'types' => array (
      '0' => array('showitem' =>  '--div--;LLL:EXT:org_npzch/locallang_db.xml:tx_org_npzch_cat.div_cat,     title,short,tx_org_npzch,'.
                                  '--div--;LLL:EXT:org_npzch/locallang_db.xml:tx_org_npzch_cat.div_access,  hidden'.
                                  ''),
    ),
  );
  
    // Relation tx_org_npzch
  $TCA['tx_org_npzch_cat']['columns']['tx_org_npzch']['label'] =
    'LLL:EXT:org_npzch/locallang_db.xml:tx_org_npzch_cat.tx_org_npzch';
  $TCA['tx_org_npzch_cat']['columns']['tx_org_npzch']['config']['maxitems'] = 999;
  unset($TCA['tx_org_npzch_cat']['columns']['tx_org_npzch']['config']['items']);
  $TCA['tx_org_npzch_cat']['columns']['tx_org_npzch']['config']['MM'] =
    'tx_org_npzch_mm_tx_org_npzch_cat';
  $TCA['tx_org_npzch_cat']['columns']['tx_org_npzch']['config']['MM_opposite_field'] =
    'tx_org_npzch_cat';
  $TCA['tx_org_npzch_cat']['columns']['tx_org_npzch']['config']['foreign_table'] =
    'tx_org_npzch';
  $TCA['tx_org_npzch_cat']['columns']['tx_org_npzch']['config']['foreign_table_where'] =
    'AND tx_org_npzch.' . $str_store_record_conf . ' AND tx_org_npzch.hidden=0 ORDER BY tx_org_npzch.title';
  $TCA['tx_org_npzch_cat']['columns']['tx_org_npzch']['config']['wizards']['add']['title'] =
    'LLL:EXT:org_npzch/locallang_db.xml:wizard.tx_org_npzch.add';
  $TCA['tx_org_npzch_cat']['columns']['tx_org_npzch']['config']['wizards']['add']['params']['table'] =
    'tx_org_npzch';
  $TCA['tx_org_npzch_cat']['columns']['tx_org_npzch']['config']['wizards']['list']['title'] =
    'LLL:EXT:org_npzch/locallang_db.xml:wizard.tx_org_npzch.list';
  $TCA['tx_org_npzch_cat']['columns']['tx_org_npzch']['config']['wizards']['edit']['title'] =
    'LLL:EXT:org_npzch/locallang_db.xml:wizard.tx_org_npzch.edit';
  $TCA['tx_org_npzch_cat']['columns']['tx_org_npzch']['config']['wizards']['list']['params']['table'] =
    'tx_org_npzch';
    // Relation tx_org_npzch
    // tx_org_npzch_cat (master for category tables)
  
  
  
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //
    // tx_org_npzch_capacity
  
  $TCA['tx_org_npzch_capacity'] = array (
    'ctrl' => $TCA['tx_org_npzch_capacity']['ctrl'],
    'interface' => array (
      'showRecordFieldList' =>  'title,value,tx_org_npzch,'.
                                'hidden'
    ),
    'feInterface' => $TCA['tx_org_npzch_capacity']['feInterface'],
    'columns' => array (
      'title' => array (
        'exclude' => 0,
        'label' => 'LLL:EXT:org_npzch/locallang_db.xml:tx_org_npzch_capacity.title',
        'config'  => $conf_input_30_trimRequired,
      ),
      'value' => array (
        'exclude' => 0,
        'label'   => 'LLL:EXT:org_npzch/locallang_db.xml:tx_org_npzch_capacity.value',
        'config' => array (
          'type' => 'input',  
          'size' => '6',
          'max'  => '6',
          'eval' => 'required,double2',
        ),
      ),
      'tx_org_npzch' => $TCA['tx_org_npzch_cat']['columns']['tx_org_npzch'],
      'hidden'          => $conf_hidden,
    ),
    'types' => array (
      '0' => array('showitem' =>  '--div--;LLL:EXT:org_npzch/locallang_db.xml:tx_org_npzch_capacity.div_capacity, title,value,tx_org_npzch,'.
                                  '--div--;LLL:EXT:org_npzch/locallang_db.xml:tx_org_npzch_capacity.div_access,   hidden'.
                                  ''),
    ),
  );
  
    // Relation tx_org_npzch
  $TCA['tx_org_npzch_capacity']['columns']['tx_org_npzch']['config']['maxitems'] = 999;
  unset($TCA['tx_org_npzch_degeree']['columns']['tx_org_npzch']['config']['items']);
  $TCA['tx_org_npzch_capacity']['columns']['tx_org_npzch']['config']['MM'] =
    'tx_org_npzch_mm_tx_org_npzch_capacity';
  $TCA['tx_org_npzch_capacity']['columns']['tx_org_npzch']['config']['MM_opposite_field'] =
    'tx_org_npzch_capacity';
    // Relation tx_org_npzch
    // tx_org_npzch_capacity
  
  
  
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //
    // tx_org_npzch_place
  
  $TCA['tx_org_npzch_place'] = array (
    'ctrl' => $TCA['tx_org_npzch_place']['ctrl'],
    'interface' => array (
      'showRecordFieldList' =>  'title,short,tx_org_npzch,'.
                                'hidden'
    ),
    'feInterface' => $TCA['tx_org_npzch_place']['feInterface'],
    'columns' => array (
      'title' => array (
        'exclude' => 0,
        'label' => 'LLL:EXT:org_npzch/locallang_db.xml:tx_org_npzch_place.title',
        'config'  => $conf_input_30_trimRequired,
      ),
      'short' => array (
        'exclude'   => 0,
        'label'     => 'LLL:EXT:org_npzch/locallang_db.xml:tx_org_npzch_place.short',
        'config'    => $conf_input_01_trimUpperRequired,
      ),
      'tx_org_npzch' => $TCA['tx_org_npzch_cat']['columns']['tx_org_npzch'],
      'hidden'          => $conf_hidden,
    ),
    'types' => array (
      '0' => array('showitem' =>  '--div--;LLL:EXT:org_npzch/locallang_db.xml:tx_org_npzch_place.div_place,   title,short,tx_org_npzch,'.
                                  '--div--;LLL:EXT:org_npzch/locallang_db.xml:tx_org_npzch_place.div_access,   hidden'.
                                  ''),
    ),
  );
  
    // Relation tx_org_npzch
  $TCA['tx_org_npzch_place']['columns']['tx_org_npzch']['config']['maxitems'] = 999;
  unset($TCA['tx_org_npzch_degeree']['columns']['tx_org_npzch']['config']['items']);
  $TCA['tx_org_npzch_place']['columns']['tx_org_npzch']['config']['MM'] =
    'tx_org_npzch_mm_tx_org_npzch_place';
  $TCA['tx_org_npzch_place']['columns']['tx_org_npzch']['config']['MM_opposite_field'] =
    'tx_org_npzch_place';
    // Relation tx_org_npzch
    // tx_org_npzch_place
  
  
  
  ?>