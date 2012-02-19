<!-- BEGIN: MAIN -->

<div id="calendar">
<!-- BEGIN: CALENDAR -->
<table class="cells marginbottom10">
<!-- BEGIN: COL -->
	<tr>
<!-- BEGIN: HEADER -->
		<td style="width:14%;" class="calendar_header">{CAL_DAYWEEK_SHORT}</td>
<!-- END: HEADER -->
<!-- BEGIN: NODAY -->
		<td class="calendar_back">&nbsp;</td>
<!-- END: NODAY -->
<!-- BEGIN: DAY -->
		<td class="calendar_istoday{CALENDAR_ROW_ISTODAY} textcenter">
			<!-- IF {CALENDAR_ROW_EVENTSCOUNT} > 0 --><a href="#" title="{PHP.L.calendar_viewday}" class="ajax" rel="calmini;{CALENDAR_DAYEVENTS_URLAJAX}">{CALENDAR_ROW_DAY}</a><!-- ELSE -->{CALENDAR_ROW_DAY}<!-- ENDIF -->
<!-- BEGIN: EVENTS -->
<!-- BEGIN: ROW -->		
<!-- END: ROW -->
<!-- END: EVENTS -->
		</td>
<!-- END: DAY -->
<!-- BEGIN: NODAY_AFTER -->
		<td class="calendar_back">&nbsp;</td>
<!-- END: NODAY_AFTER -->
	</tr>
<!-- END: COL -->
	<tr class="centerall">
		<td><a href="#" title="{CAL_PREVMONTH_FULL}" class="ajax" rel="get-calendar;{CAL_PREVMONTH_URLAJAX}"><img src="{PHP.cfg.plugins_dir}/calendar/img/arrow-small-left.png" alt="" /></a></td>
		<td colspan="5"><a href="plug.php?e=calendar&amp;year={CAL_CURRYEAR_NUM}&amp;month={CAL_CURRMONTH_NUM}" class="ajax" rel="calmini;{CAL_MONEVENTS_URLAJAX}">{CAL_CURRMONTH_FULL} {CAL_CURRYEAR_NUM}</a></td>
		<td><a href="#" title="{CAL_NEXTMONTH_FULL}" class="ajax" rel="get-calendar;{CAL_NEXTMONTH_URLAJAX}"><img src="{PHP.cfg.plugins_dir}/calendar/img/arrow-small-right.png" alt="" /></a></td>
	</tr>
</table>
<!-- END: CALENDAR -->
</div>

<!-- BEGIN: EVENTS -->
<p class="strong">{PHP.L.calendar_upcoming}:</p>
<ul class="bullets">
	<!-- BEGIN: ROW -->
	<li><!-- IF {CALENDAR_ROW_BEGIN} == {CALENDAR_ROW_EXPIRE} -->{CALENDAR_ROW_BEGIN}<!-- ELSE -->{CALENDAR_ROW_BEGIN} &ndash; {CALENDAR_ROW_EXPIRE}<!-- ENDIF -->: <a href="{CALENDAR_ROW_URL}" title="{CALENDAR_ROW_DESC}">{CALENDAR_ROW_TITLESHORT}</a></li>
	<!-- END: ROW -->
</ul>
<!-- END: EVENTS -->

<div id="calmini">
<!-- BEGIN: EVENTS_DAY -->
<p class="strong" style="margin:2px 0 0;">События дня ({CALENDAR_EVENTS_DAY_DATE}):</p>
<ul class="bullets">
	<!-- BEGIN: ROW -->
	<li>{CALENDAR_ROW_BEGIN} <a href="{CALENDAR_ROW_URL}" title="{CALENDAR_ROW_TITLE}">{CALENDAR_ROW_TITLE}</a></li>
	<!-- END: ROW -->
	<!-- BEGIN: NOROW -->
	<li>На данный день событий нет</li>
	<!-- END: NOROW -->	
</ul>
<!-- END: EVENTS_DAY -->

<!-- BEGIN: EVENTS_MONTH -->
<p class="strong" style="margin:2px 0 0;">События месяца ({CALENDAR_EVENTS_MONTH_DATE}):</p>
<ul class="bullets">
	<!-- BEGIN: ROW -->
	<li>{CALENDAR_ROW_BEGIN} <a href="{CALENDAR_ROW_URL}" title="{CALENDAR_ROW_TITLE}">{CALENDAR_ROW_TITLE}</a></li>
	<!-- END: ROW -->
	<!-- BEGIN: NOROW -->
	<li>В данном месяце событий нет</li>
	<!-- END: NOROW -->	
</ul>
<!-- END: EVENTS_MONTH -->
</div>

<!-- END: MAIN -->