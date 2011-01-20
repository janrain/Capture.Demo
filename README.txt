
Contact Information 
====================

Installation and Setup 
=======================
Place the contents of this directory in a location accessible by your web server
(e.g. /var/www).

Edit config.ini and set the variables client_id and client_secret.  Change any
other variables as you see fit.

Documentation 
==============

Top-level Files 
----------------
Most top-level files behave something like this:
- include apid.php.
- render html header and page title.
- include common.php.
- retrieve the user entity and display the navigation bar by calling
  make_navigation_bar.
- display the body.

* index.php 
  Renders the main page by including 'home.php'.
  
* editprofile.php 
  Renders the profiler editor page if the user is logged in.  Otherwise, displays
  a message that the user must login.
  
* rawprofile.php 
  Pretty-prints the raw entity of the currently logged in user.
  
* logout.php 
  Logs out the user by clearing the PHP capture_session variable.
  

Included Files 
---------------
The following files should never be accessed directly by the user in a URL.
They are included by the above top-level files.
* common.php 
  Sources some javascript and includes navigation.php.  Should be included by each
  of the top-level files before rendering the body of the page.
  
* api.php 
  Provides Capture API functions.  Includes config.php.  Should be included at the
  top of every top-level file, before the html header.
  
* config.php 
  Parses config.ini for options, provides a couple of debug functions.
  
* config.ini 
  The configuration file.
  
* navigation.php 
  Provides a function for rendering the navigation bar, make_navigation_bar.  It
  takes in the user entity, which is NULL if the user is not logged in, and
  displays links based on whether the user is logged in.
  
* home.php 
  Demo main page.
  
* prettyprint.js 
  
* style.css 
  
* oauth_redirect.php 
  File that handles OAuth redirect.  Must be loaded inside a frame.  Accepts an
  authentication code and exchanges it with the server for an access token.
  
* xdcomm.html 
  Required file.  See the Janrain Capture Integration Document.
  
