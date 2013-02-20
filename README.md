ExpressionEngine Relative Time Plugin
========

Returns the relative time between a provided time and the current time in ExpressionEngine.

Parameters:

date = '{entry_date}' // Unix timestamp (default EE date format)
show_labels = 'false' // Show the date labels (years, minutes, etc)
show_empty = 'true' // Hide values that equal 0

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
