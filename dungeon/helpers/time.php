<?php if (!defined('DUNGEON_CMS')) exit;
/**************************************************************************
Copyright © 2019 Evil

This file is part of Dungeon.

Dungeon is free software: you can redistribute it and/or modify
it under the terms of the GNU Lesser General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

Dungeon is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU Lesser General Public License for more details.

You should have received a copy of the GNU Lesser General Public License
along with Dungeon. If not, see <http://www.gnu.org/licenses/>.
**************************************************************************/

function now($timestamp = NULL)
{
	return timetostr('%Y-%m-%d %H:%M:%S', $timestamp);
}

function strtoseconds($string)
{
	return strtotime($string, 0);
}

function timetostr($format, $timestamp = NULL)
{
	if ($timestamp === NULL)
	{
		$timestamp = time();
	}

	if (!is_numeric($timestamp))
	{
		$timestamp = strtotime($timestamp);
	}

	if (strtoupper(substr(PHP_OS, 0, 3)) == 'WIN')
	{
		$format = preg_replace('#(?<!%)((?:%%)*)%e#', '\1%#d', $format);
	}

	return utf8_string(ucfirst(strtolower(strftime($format, $timestamp))));
}

function time_span($timestamp)
{
	if (!is_numeric($timestamp))
	{
		$timestamp = strtotime($timestamp);
	}

	$diff = time() - $timestamp;

	if (!$diff)
	{
		return Dungeon()->lang('now');
	}
	else if ($diff == strtoseconds('1 seconds'))
	{
		return Dungeon()->lang('seconds_ago', 1);
	}
	else if ($diff <= strtoseconds('30 seconds'))
	{
		return Dungeon()->lang('seconds_ago', $diff, $diff);
	}
	else if ($diff < strtoseconds('45 seconds'))
	{
		return Dungeon()->lang('seconds_ago', 30, 30);
	}
	else if ($diff < strtoseconds('50 seconds'))
	{
		return Dungeon()->lang('seconds_ago', 45, 45);
	}
	else if ($diff < strtoseconds('55 seconds'))
	{
		return Dungeon()->lang('seconds_ago', 50, 50);
	}
	else if ($diff < strtoseconds('2 minutes'))
	{
		return Dungeon()->lang('minutes_ago', 1);
	}
	else if ($diff <= strtoseconds('59 minutes'))
	{
		return Dungeon()->lang('minutes_ago', $diff = floor($diff / 60), $diff);
	}
	else if ($diff < strtoseconds('2 hours'))
	{
		return Dungeon()->lang('hours_ago', 1);
	}
	else if ($diff <= strtoseconds('23 hours'))
	{
		return Dungeon()->lang('hours_ago', $diff = floor($diff / 3660), $diff);
	}
	else if ($timestamp >= strtotime('yesterday'))
	{
		return Dungeon()->lang('yesterday_at', timetostr(Dungeon()->lang('time_short'), $timestamp));
	}
	else if ($timestamp >= strtotime('6 days ago midnight'))
	{
		return Dungeon()->lang('day_at', ucfirst(timetostr('%A', $timestamp)), timetostr(Dungeon()->lang('time_short'), $timestamp));
	}
	else
	{
		return timetostr(Dungeon()->lang('date_time_short'), $timestamp);
	}
}

/*
Dungeon Alpha 0.1.7
./dungeon/helpers/time.php
*/