This is a replacement for the file

/moodle/local/ltiprovider/tool.php

It does several things differently from the original tool.php

- The Moodle username now includes the consumer key in its hash 

- Old usernames based solely on the userid are silently updated

- User data like name, etc are updated when it changes

- The sourcedid and service url are udated if they change

