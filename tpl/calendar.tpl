<!-- BEGIN: MAIN -->

<div class="block">
	<h2 class="calend"><span>{PHP.L.calendar_title}</span></h2>
	<div id="calendar">
		<!-- BEGIN: CALENDAR -->

		<table class="flat marginbottom10">
			<tr>
				<td colspan="2">
					<a href="{CAL_PREVMONTH_URL}" title="{PHP.L.calendar_prevmonth}"><img src="./{PHP.cfg.plugins_dir}/calendar/img/arrow-small-left.png" style="vertical-align:-5px;" alt="{PHP.L.calendar_prevmonth}" />{CAL_PREVMONTH_FULL}</a>
				</td>
				<td colspan="3" class="strong textcenter">{CAL_CURRMONTH_FULL} {CAL_CURRYEAR_NUM}</td>
				<td colspan="2" class="textright"><a href="{CAL_NEXTMONTH_URL}" title="{PHP.L.calendar_nextmonth}">{CAL_NEXTMONTH_FULL}<img src="./{PHP.cfg.plugins_dir}/calendar/img/arrow-small-right.png" style="vertical-align:-5px;" alt="{PHP.L.calendar_nextmonth}" /></a></td>
			</tr>
			<tr>
				<td><a href="{CAL_PREVYEAR_URL}" title="{PHP.L.calendar_prevyear}"><img src="./{PHP.cfg.plugins_dir}/calendar/img/arrow-small-left.png" style="vertical-align:-5px;" alt="{PHP.L.calendar_prevyear}" />{CAL_PREVYEAR_NUM}</a></td>
				<td colspan="5" class="textcenter">
					<a href="plug.php?e=calendar&year={CAL_CURRYEAR_NUM}&month=1">{PHP.L.month_full.1}</a> &nbsp;
					<a href="plug.php?e=calendar&year={CAL_CURRYEAR_NUM}&month=2">{PHP.L.month_full.2}</a> &nbsp;
					<a href="plug.php?e=calendar&year={CAL_CURRYEAR_NUM}&month=3">{PHP.L.month_full.3}</a> &nbsp;
					<a href="plug.php?e=calendar&year={CAL_CURRYEAR_NUM}&month=4">{PHP.L.month_full.4}</a> &nbsp;
					<a href="plug.php?e=calendar&year={CAL_CURRYEAR_NUM}&month=5">{PHP.L.month_full.5}</a> &nbsp;
					<a href="plug.php?e=calendar&year={CAL_CURRYEAR_NUM}&month=6">{PHP.L.month_full.6}</a> &nbsp;
					<a href="plug.php?e=calendar&year={CAL_CURRYEAR_NUM}&month=7">{PHP.L.month_full.7}</a> &nbsp;
					<a href="plug.php?e=calendar&year={CAL_CURRYEAR_NUM}&month=8">{PHP.L.month_full.8}</a> &nbsp;
					<a href="plug.php?e=calendar&year={CAL_CURRYEAR_NUM}&month=9">{PHP.L.month_full.9}</a> &nbsp;
					<a href="plug.php?e=calendar&year={CAL_CURRYEAR_NUM}&month=10">{PHP.L.month_full.10}</a> &nbsp;
					<a href="plug.php?e=calendar&year={CAL_CURRYEAR_NUM}&month=11">{PHP.L.month_full.11}</a> &nbsp;
					<a href="plug.php?e=calendar&year={CAL_CURRYEAR_NUM}&month=12">{PHP.L.month_full.12}</a>
				</td>
				<td class="textright"><a href="{CAL_NEXTYEAR_URL}" title="{PHP.L.calendar_nextyear}">{CAL_NEXTYEAR_NUM}<img src="./{PHP.cfg.plugins_dir}/calendar/img/arrow-small-right.png" style="vertical-align:-5px;" alt="{PHP.L.calendar_nextyear}" /></a></td>
			</tr>
		</table>

		<table class="cells marginbottom10">
			<!-- BEGIN: COL -->
			<tr>
				<!-- BEGIN: HEADER -->
				<td style="width:14%" class="calendar_header">{CAL_DAYWEEK_SHORT}</td>
				<!-- END: HEADER -->
				<!-- BEGIN: NODAY -->
				<td class="calendar_back"><p>&nbsp;<br />&nbsp;<br />&nbsp;</p></td>
				<!-- END: NODAY -->
				<!-- BEGIN: DAY -->
				<td class="calendar_istoday{CALENDAR_ROW_ISTODAY}">
					{CALENDAR_ROW_DAY}
					<!-- IF {CALENDAR_ROW_EVENTSCOUNT} == 0 --><p>&nbsp;<br />&nbsp;<br />&nbsp;</p><!-- ENDIF -->
					<!-- BEGIN: EVENTS -->
					<!-- BEGIN: ROW -->
					<p><a href="{CALENDAR_ROW_URL}" title="{CALENDAR_ROW_DESC}">{CALENDAR_ROW_TITLESHORT}</a></p>
					<!-- END: ROW -->
					<!-- END: EVENTS -->
				</td>
				<!-- END: DAY -->
				<!-- BEGIN: NODAY_AFTER -->
				<td class="calendar_back"><p>&nbsp;<br />&nbsp;<br />&nbsp;</p></td>
				<!-- END: NODAY_AFTER -->
			</tr>
			<!-- END: COL -->
		</table>

		<!-- END: CALENDAR -->
	</div>

	<!-- BEGIN: EVENTS -->

	<p>{PHP.L.calendar_upcoming}:</p>
	<ul class="bullets">
		<!-- BEGIN: ROW -->
		<li><!-- IF {CALENDAR_ROW_BEGIN} == {CALENDAR_ROW_EXPIRE} -->{CALENDAR_ROW_BEGIN}<!-- ELSE -->{CALENDAR_ROW_BEGIN} &ndash; {CALENDAR_ROW_EXPIRE}<!-- ENDIF -->: <a href="{CALENDAR_ROW_URL}" title="{CALENDAR_ROW_DESC}">{CALENDAR_ROW_TITLESHORT}</a></li>
		<!-- END: ROW -->
	</ul>

	<!-- END: EVENTS -->

</div>

<!-- END: MAIN -->