<?php

$installer = $this;

$installer->startSetup();
$installer->run("
DROP TABLE IF EXISTS {$this->getTable('uni_sprt_tkt')};
DROP TABLE IF EXISTS {$this->getTable('uni_sprt_tkt_reply')};
DROP TABLE IF EXISTS {$this->getTable('uni_sprt_tkt_status')};
DROP TABLE IF EXISTS {$this->getTable('uni_sprt_tkt_pri')};
DROP TABLE IF EXISTS {$this->getTable('uni_sprt_tkt_dep')};
CREATE TABLE {$this->getTable('uni_sprt_tkt')} (
  `entity_id` int(11) NOT NULL primary key auto_increment,
  `ticket_id` varchar(30) NOT NULL,
  `user_name` varchar(100) default NULL,
  `user_id` int(11) default NULL,
  `user_email` varchar(100) default NULL,
  `department` varchar(100) NOT NULL default '1',
  `ticket_priority` int(3) NOT NULL default '1',
  `ticket_subject` varchar(100) default NULL,
  `ticket_message` text NOT NULL,
  `ticket_attachment` varchar(50) default NULL,
  `create_time` datetime default NULL,
  `update_time` datetime default NULL,
  `reply_count` int(20) NOT NULL default '0',
  `ticket_status` int(3) NOT NULL default '1'
 
 ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


CREATE TABLE {$this->getTable('uni_sprt_tkt_reply')} (
  `entity_id` int(11) NOT NULL primary key auto_increment,
  `ticket_id` varchar(30) NOT NULL,
  `user_name` varchar(100) default NULL,
  `user_id` int(11) default NULL,
  `reply_time` datetime default NULL,
  `ticket_attachment` varchar(50) default NULL,
  `ticket_replies` varchar(150) default NULL,
  `is_admin` int(11) default NULL
   
 ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE {$this->getTable('uni_sprt_tkt_status')} (
  `entity_id` int(11) NOT NULL primary key auto_increment,
  `title` varchar(100) default NULL,
  `font_color` varchar(50) default NULL,
  `background_color` varchar(50) default NULL,
  `is_system` int(10) NOT NULL default '0',
  `ticket_status` int(3) NOT NULL default '0'
   
 ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


CREATE TABLE {$this->getTable('uni_sprt_tkt_pri')} (
  `entity_id` int(11) NOT NULL primary key auto_increment,
  `title` varchar(100) default NULL,
  `font_color` varchar(50) default NULL,
  `background_color` varchar(50) default NULL,
  `is_system` int(10) NOT NULL default '0',
  `ticket_priority` int(3) NOT NULL default '0'
   
 ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


CREATE TABLE {$this->getTable('uni_sprt_tkt_dep')} (
  `entity_id` int(11) NOT NULL primary key auto_increment,
  `title` varchar(100) default NULL,
  `is_system` int(10) NOT NULL default '0',
  `dep_status` int(3) NOT NULL default '0'
   
 ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

INSERT INTO {$this->getTable('uni_sprt_tkt_dep')} (`entity_id`, `title`, `is_system`, `dep_status`) VALUES
(1, 'Sales', 1, 0),
(2, 'Marketing', 1, 0),
(3, 'Complain', 1, 0);

INSERT INTO {$this->getTable('uni_sprt_tkt_pri')} (`entity_id`, `title`, `font_color`, `background_color`, `is_system`, `ticket_priority`) VALUES
(1, 'High', 'FF0000', NULL, 1, 1),
(2, 'Medium', '059E05', NULL, 1, 1),
(3, 'Low', '000000', NULL, 1, 1);

INSERT INTO {$this->getTable('uni_sprt_tkt_status')} (`entity_id`, `title`, `font_color`, `background_color`, `is_system`, `ticket_status`) VALUES
(1, 'New', 'FF0000', NULL, 1, 1),
(2, 'Pending', '059E05', NULL, 1, 1),
(3, 'Close', '000000', NULL, 1, 1);

");
$installer->endSetup();

