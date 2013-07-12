GrabLite
========

Grab the urls from the feed url.

You can run the grab application simply by the command below:

php index.php [URL] [turns]

url: The feed URL you want to start with;

turns: The loops which the application runs. For example, We fetched URL B, C and D from feed URL A.
       If you set the 'turns' parameter to '2', the application will start to grab more URLs from B, C and D in the second loop.

The grabbed results will be wroten into the table named 'url_queue'

The database configuration is located in config.ini.php.

PLEASE!! Create the database named 'spider' manually by the SQL below:

CREATE DATABASE spider;
