<?php

if ($calendars->num_rows() > 0)
{
	foreach ($calendars->result() as $calendar)
	{
		echo "<option value=\"$calendar->cal_cod\">". utf8_decode($calendar->public_name)."</option>";
	}
}
else
{
	echo '<option value=" Ninguno">Ningún calendario disponible</option>';
}

?>
