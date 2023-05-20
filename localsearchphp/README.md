Local Search PHP
----------------

A simple PHP search engine that crawls a site it is embedded in and supports simple searches of the site.

This only looks at the web pages on your site through a crawl process like any other web search engine.
The crawl process is embedded into the pages of the site with AJAX.   The crawl process and the search
process return JSON so you can use it any way you like and format it in a way that fits with the design
of your site.


This does not require a separate crawl process and used SQLite on the local disk for its page index database.


Using ChatGPT
-------------

The initial version of this code was built with ChatGPT.  I asked the following questions:

* I want to write a simple PHP search engine that crawls a site it is embedded in and supports simple searches of the site.
* Chuck: Started a file - crawl.php
* Could I use DOMDocument and loadHTML instead?
* How would I remove multiple spaces and blank lines from the body and title text
* How do I exclude the contents of the nav tag from the body content
* How do I made sure not to add the same body content twice?
* How about if I just store the hash of the body content in the body array?
* What are good places to add error checking
* How do I get the error code like 404 from `file_get_contents`
* How to check if `$http_response_header` is a 2xx or 3xx
* Can I store the pages in an SQLITE database so this crawler is restartable?
* Chuck: Started a second file - crawl2.php
* Can you also store the queue of unretrieved urls in the database
* Can you store the queue in the pages table and add a retrieved date so we can do the crawl over and over and re-crawl older pages?
* Add some code to the end to read and dump all the pages in the table
* How do I insert the initial url with on on duplicate key ignore
* Is "INSERT IGNORE" valid SQLITE syntax?
* If I insert the initial page with $now it never is retrieved - how would you make it so the first url is retrieved and the actual loop is properly primed?
* Your answer was wrong.
* ChatGPT:  Could you please clarify which part of my answer was wrong so I can provide a more accurate response?
* You still are selecting retrieved as null in the first select
* Your answer is still wrong.
* Chuck: I decided to work on the code and ask smaller questions
* Can SQLite do on duplicate key update?
