# INDEX
# -----
# tx_org_npzch
# tx_org_npzch_capacity
# tx_org_npzch_cat
# tx_org_npzch_place
# tx_org_npzch_mm_fe_users
# tx_org_npzch_mm_tx_org_npzch_capacity
# tx_org_npzch_mm_tx_org_npzch_cat
# tx_org_npzch_mm_tx_org_npzch_place
# tx_org_npzch_mm_tx_org_cal

# fe_users
# tx_org_cal
# tx_org_headquarters



#
# Table structure for table 'tx_org_npzch'
#
CREATE TABLE tx_org_npzch (
  uid int(11) unsigned DEFAULT '0' NOT NULL auto_increment,
  pid int(11) unsigned DEFAULT '0' NOT NULL,
  tstamp int(11) unsigned DEFAULT '0' NOT NULL,
  crdate int(11) unsigned DEFAULT '0' NOT NULL,
  cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
  deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
  type tinytext,
  title tinytext,
  short mediumtext,
  occasion mediumtext,
  datetime_start int(11) unsigned DEFAULT '0' NOT NULL,
  datetime_end int(11) unsigned DEFAULT '0' NOT NULL,
  tx_org_npzch_capacity tinytext,
  tx_org_npzch_cat tinytext,
  tx_org_npzch_place tinytext,
  fe_user tinytext,
  tx_org_cal tinytext,
  tx_org_news tinytext,
  hidden tinyint(4) DEFAULT '0' NOT NULL,
  starttime int(11) DEFAULT '0' NOT NULL,
  endtime int(11) DEFAULT '0' NOT NULL,
  fe_group varchar(100) DEFAULT '0' NOT NULL,
  keywords text,
  description text,
  
  PRIMARY KEY (uid),
  KEY parent (pid)

);



#
# Table structure for table 'tx_org_npzch_capacity'
#
CREATE TABLE tx_org_npzch_capacity (
  uid int(11) unsigned DEFAULT '0' NOT NULL auto_increment,
  pid int(11) unsigned DEFAULT '0' NOT NULL,
  tstamp int(11) unsigned DEFAULT '0' NOT NULL,
  crdate int(11) unsigned DEFAULT '0' NOT NULL,
  cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
  deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
  sorting int(10) DEFAULT '0' NOT NULL,
  title tinytext,
  value tinytext,
  tx_org_npzch tinytext,
  hidden tinyint(4) DEFAULT '0' NOT NULL,
  
  PRIMARY KEY (uid),
  KEY parent (pid)
);



#
# Table structure for table 'tx_org_npzch_cat'
#
CREATE TABLE tx_org_npzch_cat (
  uid int(11) unsigned DEFAULT '0' NOT NULL auto_increment,
  pid int(11) unsigned DEFAULT '0' NOT NULL,
  tstamp int(11) unsigned DEFAULT '0' NOT NULL,
  crdate int(11) unsigned DEFAULT '0' NOT NULL,
  cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
  deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
  title tinytext,
  short tinytext,
  tx_org_npzch tinytext,
  hidden tinyint(4) DEFAULT '0' NOT NULL,
  
  PRIMARY KEY (uid),
  KEY parent (pid)
);



#
# Table structure for table 'tx_org_npzch_place'
#
CREATE TABLE tx_org_npzch_place (
  uid int(11) unsigned DEFAULT '0' NOT NULL auto_increment,
  pid int(11) unsigned DEFAULT '0' NOT NULL,
  tstamp int(11) unsigned DEFAULT '0' NOT NULL,
  crdate int(11) unsigned DEFAULT '0' NOT NULL,
  cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
  deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
  sorting int(10) DEFAULT '0' NOT NULL,
  title tinytext,
  short tinytext,
  tx_org_npzch tinytext,
  hidden tinyint(4) DEFAULT '0' NOT NULL,
  
  PRIMARY KEY (uid),
  KEY parent (pid)
);



#
# Table structure for table 'tx_org_npzch_mm_fe_users'
#
CREATE TABLE tx_org_npzch_mm_fe_users (
  uid_local int(11) unsigned DEFAULT '0' NOT NULL,
  uid_foreign int(11) unsigned DEFAULT '0' NOT NULL,
  tablenames varchar(30) DEFAULT '' NOT NULL,
  sorting int(11) unsigned DEFAULT '0' NOT NULL,
  sorting_foreign int(11) unsigned DEFAULT '0' NOT NULL,
  KEY uid_local (uid_local),
  KEY uid_foreign (uid_foreign)
);



#
# Table structure for table 'tx_org_npzch_mm_tx_org_npzch_capacity'
#
CREATE TABLE tx_org_npzch_mm_tx_org_npzch_capacity (
  uid_local int(11) unsigned DEFAULT '0' NOT NULL,
  uid_foreign int(11) unsigned DEFAULT '0' NOT NULL,
  tablenames varchar(30) DEFAULT '' NOT NULL,
  sorting         int(11) unsigned DEFAULT '0' NOT NULL,
  sorting_foreign int(11) unsigned DEFAULT '0' NOT NULL,
  KEY uid_local (uid_local),
  KEY uid_foreign (uid_foreign)
);



#
# Table structure for table 'tx_org_npzch_mm_tx_org_npzch_cat'
#
CREATE TABLE tx_org_npzch_mm_tx_org_npzch_cat (
  uid_local int(11) unsigned DEFAULT '0' NOT NULL,
  uid_foreign int(11) unsigned DEFAULT '0' NOT NULL,
  tablenames varchar(30) DEFAULT '' NOT NULL,
  sorting         int(11) unsigned DEFAULT '0' NOT NULL,
  sorting_foreign int(11) unsigned DEFAULT '0' NOT NULL,
  KEY uid_local (uid_local),
  KEY uid_foreign (uid_foreign)
);



#
# Table structure for table 'tx_org_npzch_mm_tx_org_npzch_place'
#
CREATE TABLE tx_org_npzch_mm_tx_org_npzch_place (
  uid_local int(11) unsigned DEFAULT '0' NOT NULL,
  uid_foreign int(11) unsigned DEFAULT '0' NOT NULL,
  tablenames varchar(30) DEFAULT '' NOT NULL,
  sorting         int(11) unsigned DEFAULT '0' NOT NULL,
  sorting_foreign int(11) unsigned DEFAULT '0' NOT NULL,
  KEY uid_local (uid_local),
  KEY uid_foreign (uid_foreign)
);



#
# Table structure for table 'tx_org_npzch_mm_tx_org_cal'
#
CREATE TABLE tx_org_npzch_mm_tx_org_cal (
  uid_local int(11) unsigned DEFAULT '0' NOT NULL,
  uid_foreign int(11) unsigned DEFAULT '0' NOT NULL,
  tablenames varchar(30) DEFAULT '' NOT NULL,
  sorting         int(11) unsigned DEFAULT '0' NOT NULL,
  sorting_foreign int(11) unsigned DEFAULT '0' NOT NULL,
  KEY uid_local (uid_local),
  KEY uid_foreign (uid_foreign)
);



#
# Table structure for table 'fe_users'
#
CREATE TABLE fe_users (
  tx_org_npzch tinytext
);



#
# Table structure for table 'tx_org_cal'
#
CREATE TABLE tx_org_cal (
  tx_org_npzch tinytext
);