<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$plugin_info = array (
	'pi_name' => 'Timespan',
	'pi_version' => '1.0',
	'pi_author' => 'Michael Leigeber',
	'pi_author_url' => 'http://www.caddis.co',
	'pi_description' => 'Returns the relative time between a provided time and the current time.',
	'pi_usage' => Timespan::usage()
);

class Timespan
{
	public $return_data = '';

	function __construct()
	{
		$this->EE =& get_instance();

		$origin_date = $this->EE->TMPL->fetch_param('date');
		$show_labels = $this->EE->TMPL->fetch_param('show_labels');
		$show_empty = $this->EE->TMPL->fetch_param('show_empty', true);
		
		if ($origin_date)
		{
			// Get tag pair content
			$result = $this->EE->TMPL->tagdata;
			
			$current_date = time();
			$rem = $current_date - $origin_date;
			
			// Determine if the date is in the past of the future
			$past_future = ($rem <= 0) ? 'past' : 'future';
			str_replace('{timespan:past_future}', $past_future, $result);
			
			$rem = abs($rem);
			
			if (strpos($result, '{timespan:years}') !== false)
			{
				$years = floor($rem / 31556926) % 31556926;
				$rem -= $years * 31556926;
				$result = str_replace('{timespan:years}', ($years || !$show_empty) ? $years . ($show_labels ? ($years == 1 ? ' Year' : ' Years') : '') : '', $result);
			}
			
			if (strpos($result, '{timespan:months}') !== false)
			{
				$months = floor($rem / 2629743.83) % 2629743.83;
				$rem -= $months * 2629743.83;
				$result = str_replace('{timespan:months}', ($months || !$show_empty) ? $months . ($show_labels ? ($months == 1 ? ' Month' : ' Months') : '') : '', $result);
			}
			
			if (strpos($result, '{timespan:days}') !== false)
			{
				$days = floor($rem / 86400) % 86400;
				$rem -= $days * 86400;
				$result = str_replace('{timespan:days}', ($days || !$show_empty) ? $days . ($show_labels ? ($days == 1 ? ' Day' : ' Days') : '') : '', $result);
			}
			
			if (strpos($result, '{timespan:hours}') !== false)
			{
				$hours = floor($rem / 3600) % 3600;
				$rem -= $hours * 3600;
				$result = str_replace('{timespan:hours}', ($hours || !$show_empty) ? $hours . ($show_labels ? ($hours == 1 ? ' Hour' : ' Hours') : '') : '', $result);
			}
			
			if (strpos($result, '{timespan:minutes}') !== false)
			{
				$minutes = floor($rem / 60) % 60;
				$result = str_replace('{timespan:minutes}', ($minutes || !$show_empty) ? $minutes . ($show_labels ? ($minutes == 1 ? ' Minute' : ' Minutes') : '') : '', $result);
			}
			
			$this->return_data = $result;
		}
	}

	function usage()
	{
		ob_start(); 
?>
Parameters:

date = '{entry_date}'		// Unix timestamp (default EE date format)
show_labels = 'false'			// Show the date labels (years, minutes, etc)
show_empty = 'true'			// Hide values that equal 0

Usage:

{exp:ellapsed date="{entry_date}"}
{if {ellapsed:days} < 7}
This entry is less than a week old!
{/if}
{/exp:ellapsed}

{exp:timespan date="{entry_date}" show_labels="true" show_empty="false"}
The time difference is {timespan:years} {timespan:months} {timespan:days} {timespan:hours}{if {timespan:minutes} != ''} and {timespan:minutes}{/if}.
{/exp:timespan}

{exp:timespan date="{entry_date}"}
{if {timespan:past_future} == 'past'}
The entry was created in the past.
{if:else}
The entry is from the future.
{/if}
{/exp:timespan}
<?php
		$buffer = ob_get_contents();
	
		ob_end_clean(); 

		return $buffer;
	}
}
?>