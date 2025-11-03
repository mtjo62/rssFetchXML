# rssFetchXML
App:       rssFetchXML
Version:   1.1
Author:    MT Jordan <mtjo62@gmail.com>
Copyright: 2025
License:   MIT License

*********************************************************************************

rssFetchXML: RSS feed aggregator

rssFetchXML fetchs RSS feeds using a simple PHP class

*********************************************************************************

rssFetchXML Features:

    * Extremely compact code that simplifies hooking into projects utilizing
      PHP's simplexml and cURL
    * Does not require allow_url_fopen enabled
    * Using simplexml with cURL sends "friendly" RSS requests that networks such
      as Cloudflare may treat as bots with other methods
    * Display unlimited RSS feeds with a single class instance
    * Auto creates cached XML files 
    * Cache dir and cache expiration time set in script but can be overridden
      on the client side
    * See rssFetchXML_demo.php for examples
   
rssFetchXML Requirements:

    * PHP 5.6+
    * Enabled libxml extension
    * Enabled cURL extension

*********************************************************************************
