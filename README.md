# README #

Application to use with a broadcast software (e.g. XSplit / OBS) to interact in real time, displaying images and audio files using another remote controller (smartphone, tablet, pc) connected to local network.

### Requirements ###

* Require socketIo / NodeJs
* Broadcast Software
* Version 1.0

### Installation ###

* Clone repository in your server folder (e.g. www if WAMP is used)
* In "js/socket_config.js", at line 1, set your local ip and the port used by your server
* If your port is not 80, put your port in file "app.js" at line 13 too
* Run Wamp
* With prompt command, set your directory and run command "npm install socket io" to install library
* Run app.js using command "node app.js"
* Using WAMP (or another local server), click on "Put Online"
* Run index.php in your browser, and one more time using your remote controller (connect to local ip)
* Capture your browser window with broadwast software.
* Enjoy !

### Contribution ###

This program is widely extendable. Thanks in advance for your contribution.