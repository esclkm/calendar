<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=standalone,global,ajax
 * [END_COT_EXT]
 */
// standalone,page.list.tags,page.tags,index.tags,ajax
/**
 * Calendar for Cotonti CMF
 *
 * @version 2.5
 * @author esclkm, http://www.littledev.ru
 * @copyright (с) 2011 esclkm, http://www.littledev.ru
 */
defined('COT_CODE') or die('Wrong URL');

$calendar_mode = 'none';
if (($cfg['plugin']['calendar']['minienabled'] == 'anywhere' ||
	($cfg['plugin']['calendar']['minienabled'] == 'index' && $env['location'] == 'home') ||
	($cfg['plugin']['calendar']['minienabled'] == 'page' && in_array($env['location'], array('home', 'page', 'list'))))
	&& cot_get_caller() == "common" && !COT_AJAX)
{
	$calendar_mode = 'common';
}
elseif ($env['type'] == 'plug' && $e == 'calendar' && cot_get_caller() == "plugin")
{
	$calendar_mode = 'main';
}
elseif($env['ext'] == 'admin')
{
	$calendar_mode = 'none';
}
if ($calendar_mode == 'main' || ($calendar_mode == 'common' && empty($MINICALENDAR)))
{
	require_once(cot_langfile('calendar'));
	require_once cot_incfile('page', 'module');

	$year = cot_import('year', 'G', 'INT');
	$year = (empty($year)) ? date('Y', $sys['now_offset'] + $usr['timezone'] * 3600) : $year;
	$month = cot_import('month', 'G', 'INT');
	$month = (empty($month)) ? date('n', $sys['now_offset'] + $usr['timezone'] * 3600) : $month;
	$events = cot_import('events', 'G', 'TXT');

	$out['subtitle'] = $L['plu_title'];

	$m_next = $month + 1;
	$m_prev = $month - 1;
	$y_next = $year;
	$y_prev = $year;

	if ($m_prev < 1)
	{
		$m_prev = 12;
		$y_prev--;
	}
	elseif ($m_next > 12)
	{
		$m_next = 1;
		$y_next++;
	}
	$today = getdate($sys['now_offset'] + $usr['timezone'] * 3600);

	for ($i = 1; $i <= 31; $i++)
	{
		$event_count[$i] = 0;
		$event_desc[$i] = array();
	}

	$l1 = cot_mktime(0, 0, 0, $month, 1, $year);
	$l2 = cot_mktime(0, 0, 0, $month + 1, 1, $year);

	$catsub = cot_structure_children('page', $cfg['plugin']['calendar']['cat']);

	$event_month = array();
	$event_count = array();
	$event_desc = array();

	$sql = $db->query("SELECT * FROM $db_pages WHERE page_state='0' AND page_cat IN ('" . implode("','", $catsub) . "') AND (" . $cfg['plugin']['calendar']['datebegin'] . "<'$l2' AND " . $cfg['plugin']['calendar']['dateexpire'] . ">'$l1') $wherecalendar ORDER BY " . $cfg['plugin']['calendar']['datebegin']);

	while ($row = $sql->fetch())
	{

		$row[$cfg['plugin']['calendar']['dateexpire']] = ($row[$cfg['plugin']['calendar']['dateexpire']] > $row[$cfg['plugin']['calendar']['datebegin']]) ? $row[$cfg['plugin']['calendar']['dateexpire']] : $row[$cfg['plugin']['calendar']['datebegin']];
		$page_calendarbegin_day = date('j', $row[$cfg['plugin']['calendar']['datebegin']]);
		$page_calendarexpire_day = date('j', $row[$cfg['plugin']['calendar']['dateexpire']]);
		$page_calendarbegin_month = date('n', $row[$cfg['plugin']['calendar']['datebegin']]);
		$page_calendarexpire_month = date('n', $row[$cfg['plugin']['calendar']['dateexpire']]);
		$page_calendarbegin_year = date('Y', $row[$cfg['plugin']['calendar']['datebegin']]);
		$page_calendarexpire_year = date('Y', $row[$cfg['plugin']['calendar']['dateexpire']]);

		$page_calendarexpire_day = ($page_calendarexpire_month - $month > 0 || $page_calendarexpire_year - $year > 0) ? '31' : $page_calendarexpire_day;
		$page_calendarbegin_day = ($page_calendarbegin_month - $month < 0 && $page_calendarbegin_year - $year) ? '1' : $page_calendarbegin_day;

		$event_month[] = $row;

		while ($page_calendarbegin_day <= $page_calendarexpire_day)
		{
			$event_count[$page_calendarbegin_day] = $event_count[$page_calendarbegin_day] + 1;
			$event_desc[$page_calendarbegin_day][] = $row;
			$page_calendarbegin_day++;
		}
	}

	/* === Hook === */
	foreach (cot_getextplugins('calendar.calevents') as $pl)
	{
		include $pl;
	}
	/* ===== */

	if ($e == 'calendar' && empty($_GET['r']) && cot_get_caller() == "plugin")
	{
		$t1 = &$t;
	}
	elseif ($e == 'calendar' && $_GET['r'] == 'calendar' && cot_get_caller() == "plugin")
	{
		$mskin = cot_tplfile(($_GET['tail'] != 'mini') ? array('calendar') : array('calendar', 'index'), 'plug');
		$caltail = ($_GET['tail'] == 'mini') ? '&tail=mini' : '';
		$t1 = new XTemplate($mskin);
	}
	else
	{
		$mskin = cot_tplfile(array('calendar', 'index'), 'plug');
		$caltail = '&tail=mini';
		$t1 = new XTemplate($mskin);
	}

	$t1->assign(array(
		'CAL_NEXTMONTH_URL' => cot_url('plug', 'e=calendar&year=' . $y_next . '&month=' . $m_next),
		'CAL_NEXTMONTH_URLAJAX' => 'index.php;' . 'r=calendar&year=' . $y_next . '&month=' . $m_next . $caltail,
		'CAL_NEXTMONTH_NUM' => $m_next,
		'CAL_NEXTMONTH_SHORT' => $L['month_short'][$m_next],
		'CAL_NEXTMONTH_FULL' => $L['month_full'][$m_next],
		'CAL_PREVMONTH_URL' => cot_url('plug', 'e=calendar&year=' . $y_prev . '&month=' . $m_prev),
		'CAL_PREVMONTH_URLAJAX' => 'index.php;' . 'r=calendar&year=' . $y_prev . '&month=' . $m_prev . $caltail,
		'CAL_PREVMONTH_NUM' => $m_prev,
		'CAL_PREVMONTH_SHORT' => $L['month_short'][$m_prev],
		'CAL_PREVMONTH_FULL' => $L['month_full'][$m_prev],
		'CAL_CURRMONTH_URL' => cot_url('plug', 'e=calendar&year=' . $year . '&month=' . $month),
		'CAL_CURRMONTH_URLAJAX' => 'index.php;' . 'r=calendar&year=' . $year . '&month=' . $month . $caltail,
		'CAL_CURRMONTH_NUM' => $month,
		'CAL_CURRMONTH_SHORT' => $L['month_short'][$month],
		'CAL_CURRMONTH_FULL' => $L['month_full'][$month],
		'CAL_MONEVENTS_URLAJAX' => 'index.php;' . 'r=calendar&year=' . $year . '&month=' . $month . '&events=month' . $caltail,
		'CAL_NOWDATE_URL' => cot_url('plug', 'e=calendar'),
		'CAL_NEXTYEAR_URL' => cot_url('plug', 'e=calendar&year=' . ($year + 1) . '&month=' . month),
		'CAL_NEXTYEAR_URLAJAX' => 'index.php;' . 'r=calendar&year=' . ($year + 1) . '&month=' . month . $caltail,
		'CAL_NEXTYEAR_NUM' => $year + 1,
		'CAL_PREVYEAR_URL' => cot_url('plug', 'e=calendar&year=' . ($year - 1) . '&month=' . $month),
		'CAL_PREVYEAR_URLAJAX' => 'index.php;' . 'r=calendar&year=' . ($year - 1) . '&month=' . $month . $caltail,
		'CAL_PREVYEAR_NUM' => $year - 1,
		'CAL_CURRYEAR_URL' => cot_url('plug', 'e=calendar&year=' . $year . '&month=' . $month),
		'CAL_CURRYEAR_URLAJAX' => 'index.php;' . 'r=calendar&year=' . $year . '&month=' . $month . $caltail,
		'CAL_CURRYEAR_NUM' => $year
	));

	for ($i = 1; $i <= 7; $i++)
	{
		$j = ($cfg['plugin']['calendar']['weekstarts']) ? $i + 6 : $i;
		$j = ($j > 7) ? $j - 7 : $j;
		$t1->assign(array(
			'CAL_DAYWEEK_NUM' => $m_prev,
			'CAL_DAYWEEK_SHORT' => $L['weekday_short'][$j],
			'CAL_DAYWEEK_FULL' => $L['weekday_full'][$j],
			'CAL_DAYWEEK_COL' => $j,
		));
		$t1->parse('MAIN.CALENDAR.COL.HEADER');
	}
	$t1->parse('MAIN.CALENDAR.COL');

	$firstday = date('w', mktime(0, 0, 0, $month, 1, $year));
	$firstday = ($cfg['plugin']['calendar']['weekstarts']) ? $firstday + 1 : $firstday;
	$firstday = ($firstday == '0') ? '7' : $firstday;

	$col = 0;
	for ($col = 1; $col < $firstday; $col++)
	{
		$t1->parse('MAIN.CALENDAR.COL.NODAY');
	}
	/* === Hook Part 1=== */
	$extp = cot_getextplugins('calendar.loop');
	/* === Hook Part1=== */
	for ($i = 1; $i <= 31; $i++)
	{
		if (checkdate($month, $i, $year))
		{
			$jj = 0;
			if (is_array($event_desc[$i]))
			{
				foreach ($event_desc[$i] as $row)
				{
					$jj++;
					$t1->assign(cot_generate_pagetags($row, 'CALENDAR_ROW_'));
					$t1->assign(array(
						'CALENDAR_ROW_TITLESHORT' => cot_cutstring(stripslashes($row['page_title']), 32),
						'CALENDAR_ROW_ODDEVEN' => cot_build_oddeven($jj),
						'CALENDAR_ROW_NUM' => $jj
					));
					$t1->parse('MAIN.CALENDAR.COL.DAY.EVENTS.ROW');
				}
			}
			if ($jj > 0)
			{
				$t1->assign('CALENDAR_DAYEVENTS_URLAJAX', cot_url('plug', 'r=calendar&year=' . $year . '&month=' . $month . '&events=' . $i . $caltail, '', true));
				$t1->parse('MAIN.CALENDAR.COL.DAY.EVENTS');
			}
			$listdate = cot_mktime(0, 0, 0, $month, $i, $year);
			$t1->assign(array(
				'CALENDAR_ROW_DAY' => $i,
				'CALENDAR_ROW_ISTODAY' => ($today['mday'] == $i && $today['mon'] == $month && $today['year'] == $year) ? 1 : 0,
				'CALENDAR_ROW_STAMP' => $listdate,
				'CALENDAR_ROW_LISTDATE' => cot_url('page', 'c=' . $cfg['plugin']['calendar']['cat'] . '&listdate=' . $listdate),
				'CALENDAR_ROW_LISTBEGIN' => cot_url('page', 'c=' . $cfg['plugin']['calendar']['cat'] . '&listbegin=' . $listdate),
				'CALENDAR_ROW_LISTEXPIRE' => cot_url('page', 'c=' . $cfg['plugin']['calendar']['cat'] . '&listexpire=' . $listdate),
				'CALENDAR_ROW_EVENTSCOUNT' => $event_count[$i],
				'CALENDAR_ROW_COL' => $col,
			));

			/* === Hook Part 2=== */
			foreach ($extp as $k => $pl)
			{
				include $pl;
			}
			/* ===== Part 2 */

			$t1->parse('MAIN.CALENDAR.COL.DAY');

			$col++;

			if ($col > 7)
			{
				$col = 1;
				$t1->parse('MAIN.CALENDAR.COL');
			}
		}
	}
	if ($col != 1)
	{
		for ($col; $col <= 7; $col++)
		{
			$t1->parse('MAIN.CALENDAR.COL.NODAY_AFTER');
		}
		$t1->parse('MAIN.CALENDAR.COL');
	}

	$t1->parse('MAIN.CALENDAR');

//Upcoming events month
	if (($r != 'calendar' && $cfg['plugin']['calendar']['automonev']) || $events == 'month')
	{
		if (is_array($event_month) && count($event_month) > 0)
		{
			$jj = 0;
			foreach ($event_month as $row)
			{
				$jj++;
				$t1->assign(cot_generate_pagetags($row, 'CALENDAR_ROW_'));
				$t1->assign(array(
					'CALENDAR_ROW_TITLESHORT' => cot_cutstring(stripslashes($row['page_title']), 32),
					'CALENDAR_ROW_ODDEVEN' => cot_build_oddeven($jj),
					'CALENDAR_ROW_NUM' => $jj
				));
				$t1->parse('MAIN.EVENTS_MONTH.ROW');
			}
		}
		else
		{
			$t1->parse('MAIN.EVENTS_MONTH.NOROW');
		}

		/* === Hook === */
		foreach (cot_getextplugins('calendar.events') as $pl)
		{
			include $pl;
		}
		/* ===== */

		$t1->assign('CALENDAR_EVENTS_MONTH_DATE', $L['month_full'][$month] . ' ' . $year);
		$t1->parse('MAIN.EVENTS_MONTH');
	}

	if (($r != 'calendar' && $cfg['plugin']['calendar']['autodayev']) || (int) $events > 0)
	{
		if ((int) $events == 0)
		{
			$events = date('j');
		}
		if (is_array($event_desc[$events]) && count($event_desc[$events]) > 0)
		{
			$jj = 0;
			foreach ($event_desc[$events] as $row)
			{
				$jj++;
				$t1->assign(cot_generate_pagetags($row, 'CALENDAR_ROW_'));
				$t1->assign(array(
					'CALENDAR_ROW_TITLESHORT' => cot_cutstring(stripslashes($row['page_title']), 32),
					'CALENDAR_ROW_ODDEVEN' => cot_build_oddeven($jj),
					'CALENDAR_ROW_NUM' => $jj
				));
				$t1->parse('MAIN.EVENTS_DAY.ROW');
			}
		}
		else
		{
			$t1->parse('MAIN.EVENTS_DAY.NOROW');
		}

		/* === Hook === */
		$extp = cot_getextplugins('calendar.events');
		if (is_array($extp))
		{
			foreach ($extp as $k => $pl)
			{
				include_once($cfg['plugins_dir'] . '/' . $pl['pl_code'] . '/' . $pl['pl_file'] . '.php');
			}
		}
		/* ===== */
		$t1->assign('CALENDAR_EVENTS_DAY_DATE', date('j.m.Y', cot_mktime(0, 0, 0, $month, $events, $year)));
		$t1->parse('MAIN.EVENTS_DAY');
	}

//Upcoming events
	if ($cfg['plugin']['calendar']['upcomingevent'] > 0 && $r != 'calendar')
	{
		$l1 = $sys['now_offset'];
		$l2 = $sys['now_offset'] + 86400 * $cfg['plugin']['calendar']['upcomingevent'];
		$sql = $db->query("SELECT * FROM $db_pages WHERE page_state='0' AND page_cat IN ('" . implode("','", $catsub) . "') AND (" . $cfg['plugin']['calendar']['datebegin'] . "<'$l2' AND " . $cfg['plugin']['calendar']['dateexpire'] . ">'$l1') $wherecalendar ORDER BY " . $cfg['plugin']['calendar']['datebegin']);
		$jj = 0;
		while ($row = $sql->fetch())
		{
			$jj++;
			$t1->assign(cot_generate_pagetags($row, 'CALENDAR_ROW_'));
			$t1->assign(array(
				'CALENDAR_ROW_TITLESHORT' => cot_cutstring(stripslashes($row['page_title']), 32),
				'CALENDAR_ROW_ODDEVEN' => cot_build_oddeven($jj),
				'CALENDAR_ROW_NUM' => $jj
			));
			$t1->parse('MAIN.EVENTS.ROW');
		}
		if ($jj > 0)
		{
			$t1->parse('MAIN.EVENTS');
		}

		/* === Hook === */
		foreach (cot_getextplugins('calendar.events') as $pl)
		{
			include $pl;
		}
		/* ===== */
	}

	if (cot_get_caller() == 'plugin' && $r == 'calendar')
	{
		cot_sendheaders();
		if ($events == 'month')
		{
			echo $t1->text('MAIN.EVENTS_MONTH');
		}
		elseif ((int) $events > 0)
		{
			echo $t1->text('MAIN.EVENTS_DAY');
		}
		else
		{
			echo $t1->text('MAIN.CALENDAR');
		}
		ob_end_flush();
	}
	elseif (cot_get_caller() != 'plug')
	{
		$t1->parse('MAIN');
		$MINICALENDAR = $t1->text('MAIN');
		if ($year == date('Y', $sys['now_offset'] + $usr['timezone'] * 3600) && $month = date('n', $sys['now_offset'] + $usr['timezone'] * 3600)
			&& $cache && (int) $cfg['plugin']['calendar']['cachetime'] > 0)
		{
			$cache->db->store('MINICALENDAR', $MINICALENDAR, 'system', $cfg['plugin']['calendar']['cachetime']);
		}
	}
}
?>