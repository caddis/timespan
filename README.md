# Timespan 1.2.0

Returns the relative time between a provided time and the current time.

## Parameters

	date = '{entry_date}' // Unix timestamp (default EE date format)
	show_labels = 'false' // Show the date labels (years, minutes, etc)
	show_empty = 'true' // Hide values that equal 0

## Usage

```html
{exp:timespan date="{entry_date}"}
{if {timespan:days} < 7}
This entry is less than a week old!
{/if}
{/exp:timespan}

{exp:timespan date="{entry_date}" show_labels="true" show_empty="false"}
The time difference is {timespan:years} {timespan:months} {timespan:days} {timespan:hours}{if {timespan:minutes} != ''} and {timespan:minutes}{/if}.
{/exp:timespan}

{exp:timespan date="{entry_date}"}
{if '{timespan:past_future}' == 'past'}
The entry was created in the past.
{if:else}
The entry is from the future.
{/if}
{/exp:timespan}
```

## License

Copyright 2014 Caddis Interactive, LLC

   Licensed under the Apache License, Version 2.0 (the "License");
   you may not use this file except in compliance with the License.
   You may obtain a copy of the License at

       http://www.apache.org/licenses/LICENSE-2.0

   Unless required by applicable law or agreed to in writing, software
   distributed under the License is distributed on an "AS IS" BASIS,
   WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
   See the License for the specific language governing permissions and
   limitations under the License.