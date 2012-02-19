<?php

/**
 * Calendar for Cotonti CMF
 *
 * @version 2.5
 * @author esclkm, http://www.littledev.ru
 * @copyright (с) 2011 esclkm, http://www.littledev.ru
 */

defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('page', 'module');
global $db_pages, $cfg, $R;
cot_extrafield_add($db_pages, 'calendarbegin', 'datetime', '', '', '', false, 'HTML', 'Event Begin');
cot_extrafield_add($db_pages, 'calendarexpire', 'datetime', '', '', '', false, 'HTML', 'Event Expire');

?>
