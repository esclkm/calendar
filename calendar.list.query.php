<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=page.list.query
 * [END_COT_EXT]
 */

/**
 * Calendar for Cotonti CMF
 *
 * @version 2.00
 * @author esclkm, http://www.littledev.ru
 * @copyright (с) 2011 esclkm, http://www.littledev.ru
 */
defined('COT_CODE') or die('Wrong URL');

$listdate = (int)cot_import('listdate', 'R', 'INT');
$listbegin = (int)cot_import('listbegin', 'R', 'INT');
$listexpire = (int)cot_import('listexpire', 'R', 'INT');

if($listdate > 0)
{
	$listbegin = $listdate;
	$listexpire = $listdate + 86400;
}

if ($listbegin > 0)
{
	$where['calendarexpire'] = $cfg['plugin']['calendar']['dateexpire'].">'$listbegin'";
}
if($listexpire > 0)
{
	$where['calendarbegin'] = $cfg['plugin']['calendar']['datebegin'].">'$listexpire'";
}


?>