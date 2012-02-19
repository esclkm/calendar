<?php

/**
 * [BEGIN_COT_EXT]
 * Code=calendar
 * Name=Calendar
 * Description=Will display the events in a calendar
 * Version=2.5.1
 * Date=201-Oct-20
 * Author=esclkm, http://www.littledev.ru
 * Copyright=(с) 2010 esclkm, http://www.littledev.ru
 * Notes=
 * SQL=
 * Auth_guests=R
 * Lock_guests=W12345A
 * Auth_members=R
 * Lock_members=12345
 * [END_COT_EXT]

 * [BEGIN_COT_EXT_CONFIG]
 * cat=01:string::events:Pagecat
 * weekstarts=02:radio::0:Week starts with Sunday
 * upcomingevent=03:select:0,1,2,3,4,5,6,7:3:Upcoming events days
 * automonev=04:radio::0:Autoload month events
 * autodayev=05:radio::0:Autoload day events
 * datebegin=06:select:page_date,page_begin,page_calendarbegin:page_calendarbegin:Date begin field
 * dateexpire=07:select:page_date,page_expire,page_calendarexpire:page_calendarexpire:Dateexpire expire field
 * minienabled=09:select:none,index,page,anywhere:index:Mini calendar enabled
 * cachetime=10:string:::Cache time in ours for minicalendar, 0 - disabled
 * [END_COT_EXT_CONFIG]
 */

/**
 * Calendar for Cotonti CMF
 *
 * @version 2.10
 * @author esclkm, http://www.littledev.ru
 * @copyright (с) 2011 esclkm, http://www.littledev.ru
 */

defined('COT_CODE') or die('Wrong URL');

?>