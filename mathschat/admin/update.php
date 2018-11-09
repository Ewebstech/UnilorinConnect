<?php

// 7.0 begin

if(!isset($settings['style_template'])){

$install=array();

$install[]='INSERT INTO '.$dbss['prfx']."_settings VALUES('style_template','
td,p,div,input,select,textarea{font-size:[15];font-family:[3];text-align:left}
input,select,textarea{color:#[13];background-color:#[14];padding:2px;border-width:0px;box-sizing:border-box}
.bgcolor_overal{color:#[1];background-color:#[2]}
.bgcolor_panel_bars{color:#[9];background-color:#[10]}
.bgcolor_panel_content{color:#[11];background-color:#[12]}
.bgcolor_top_bar{color:#[5];background-color:#[6]}
.bgcolor_bottom_bar{color:#[7];background-color:#[8]}
.title1{font-size:[17];font-weight:bold;text-transform:uppercase}
.title2{font-size:[18];font-weight:bold;text-transform:uppercase}
.text_small{font-size:[16]}
.panels_extra{[19]}
.boxes_extra{[20]}
.topbar_extra{[21]}
.bottombar_extra{[22]}
.textbox_extra{[23]}
.body_extra{[24]}
.link_color{color:#[4];cursor:pointer}
.oo{font-weight:bold;line-height:13px;white-space:nowrap;color:#[4];margin-left:8px}
',1)";

$install[]='INSERT INTO '.$dbss['prfx']."_settings VALUES('style_delivery','
td,p,div,input,select,textarea{font-size:9pt;font-family:verdana,helvetica,sans-serif;text-align:left}
input,select,textarea{color:#fff;background-color:#444;padding:2px;border-width:0px;box-sizing:border-box}
.bgcolor_overal{color:#fff;background-color:#333}
.bgcolor_panel_bars{color:#fff;background-color:#111}
.bgcolor_panel_content{color:#fff;background-color:#222}
.bgcolor_top_bar{color:#fff;background-color:#222}
.bgcolor_bottom_bar{color:#fff;background-color:#222}
.title1{font-size:12pt;font-weight:bold;text-transform:uppercase}
.title2{font-size:8pt;font-weight:bold;text-transform:uppercase}
.text_small{font-size:8pt}
.panels_extra{border-radius:10px;box-shadow:2px 2px 2px #111}
.boxes_extra{border:0px solid #fff;border-radius:5px;box-shadow:2px 2px 2px #111}
.topbar_extra{border-bottom:1px solid #111;box-shadow:0px 2px 2px #111}
.bottombar_extra{border-top:1px solid #111;box-shadow:0px -2px 2px #111}
.textbox_extra{border:1px solid #fff;box-shadow:2px 2px 2px #111}
.body_extra{background-image:none}
.link_color{color:#FEC400;cursor:pointer}
.oo{font-weight:bold;line-height:13px;white-space:nowrap;color:#FEC400;margin-left:8px}
',0)";

$install[]='CREATE TABLE '.$dbss['prfx'].'_style(
sid smallint NOT NULL,    
value text NOT NULL,
desktop smallint NOT NULL)';

$install[]='DELETE FROM '.$dbss['prfx'].'_style';

$install[]='INSERT INTO '.$dbss['prfx']."_style VALUES(1,'fff',1)";
$install[]='INSERT INTO '.$dbss['prfx']."_style VALUES(2,'333',1)";
$install[]='INSERT INTO '.$dbss['prfx']."_style VALUES(3,'verdana, sans-serif',1)";
$install[]='INSERT INTO '.$dbss['prfx']."_style VALUES(4,'FEC400',1)";
$install[]='INSERT INTO '.$dbss['prfx']."_style VALUES(5,'fff',1)";
$install[]='INSERT INTO '.$dbss['prfx']."_style VALUES(6,'222',1)";
$install[]='INSERT INTO '.$dbss['prfx']."_style VALUES(7,'fff',1)";
$install[]='INSERT INTO '.$dbss['prfx']."_style VALUES(8,'222',1)";
$install[]='INSERT INTO '.$dbss['prfx']."_style VALUES(9,'fff',1)";
$install[]='INSERT INTO '.$dbss['prfx']."_style VALUES(10,'111',1)";
$install[]='INSERT INTO '.$dbss['prfx']."_style VALUES(11,'fff',1)";
$install[]='INSERT INTO '.$dbss['prfx']."_style VALUES(12,'222',1)";
$install[]='INSERT INTO '.$dbss['prfx']."_style VALUES(13,'fff',1)";
$install[]='INSERT INTO '.$dbss['prfx']."_style VALUES(14,'444',1)";
$install[]='INSERT INTO '.$dbss['prfx']."_style VALUES(15,'9pt',1)";
$install[]='INSERT INTO '.$dbss['prfx']."_style VALUES(16,'8pt',1)";
$install[]='INSERT INTO '.$dbss['prfx']."_style VALUES(17,'12pt',1)";
$install[]='INSERT INTO '.$dbss['prfx']."_style VALUES(18,'9pt',1)";
$install[]='INSERT INTO '.$dbss['prfx']."_style VALUES(19,'border-radius:10px;box-shadow:2px 2px 2px #111',1)";
$install[]='INSERT INTO '.$dbss['prfx']."_style VALUES(20,'border:0px solid #fff;border-radius:5px;box-shadow:2px 2px 2px #111',1)";
$install[]='INSERT INTO '.$dbss['prfx']."_style VALUES(21,'border-bottom:1px solid #111;box-shadow:0px 2px 2px #111',1)";
$install[]='INSERT INTO '.$dbss['prfx']."_style VALUES(22,'border-top:1px solid #111;box-shadow:0px -2px 2px #111',1)";
$install[]='INSERT INTO '.$dbss['prfx']."_style VALUES(23,'border:1px solid #fff;box-shadow:2px 2px 2px #111',1)";
$install[]='INSERT INTO '.$dbss['prfx']."_style VALUES(24,'background-image:none',1)";

for($i=0;$i<count($install);$i++){neutral_query($install[$i]);}
}

// 7.0 end

// 7.1 begin

if(!isset($settings['iplog_on'])){

$install=array();

$install[]='INSERT INTO '.$dbss['prfx']."_settings VALUES('iplog_on','1',0)";

$install[]='CREATE TABLE '.$dbss['prfx'].'_iplog(
usr_id integer NOT NULL,
usr_name varchar(255) NOT NULL,
ipaddr varchar(15) NOT NULL,
timestamp integer NOT NULL)';

$install[]='CREATE TABLE '.$dbss['prfx'].'_ban(
ban_id integer NOT NULL,
ban_name varchar(64) NOT NULL,
ban_ip varchar(15) NOT NULL,
timestamp integer NOT NULL,
ban_reason varchar(255) NOT NULL)';

for($i=0;$i<count($install);$i++){neutral_query($install[$i]);}
}

// 7 .1 end

// 7 .2 begin

if(!isset($settings['slot_1d'])){

$install=array();

$fp='./incl/styles.dat';
if(is_file($fp)){$style=file($fp); 
if(isset($style[12])){
for($i=0;$i<13;$i++){$style[$i]=trim($style[$i]);}
$install[]='INSERT INTO '.$dbss['prfx']."_settings VALUES('slot_1d','$style[0]',1)";
$install[]='INSERT INTO '.$dbss['prfx']."_settings VALUES('slot_2d','$style[1]',1)";
$install[]='INSERT INTO '.$dbss['prfx']."_settings VALUES('slot_3d','$style[2]',1)";
$install[]='INSERT INTO '.$dbss['prfx']."_settings VALUES('slot_4d','$style[3]',1)";
$install[]='INSERT INTO '.$dbss['prfx']."_settings VALUES('slot_5d','$style[4]',1)";
$install[]='INSERT INTO '.$dbss['prfx']."_settings VALUES('slot_6d','$style[5]',1)";
$install[]='INSERT INTO '.$dbss['prfx']."_settings VALUES('slot_7d','$style[6]',1)";
$install[]='INSERT INTO '.$dbss['prfx']."_settings VALUES('slot_8d','$style[7]',1)";
$install[]='INSERT INTO '.$dbss['prfx']."_settings VALUES('slot_9d','$style[8]',1)";
for($i=0;$i<count($install);$i++){neutral_query($install[$i]);}
}}}

// 7 .2 end

?>