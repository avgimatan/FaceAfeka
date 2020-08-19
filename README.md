# FaceAfeka #

FaceAfeka is a project of social network based on Facebook and a game that members from the social network can play together.

## Technologies in the project ##
Server: NodeJS, Apache and PHP.
Client: HTML, CSS, JS, React framework. 
The social network is built on Apache, written in PHP and JS, CSS, HTML.
The memory game is built On NodeJS in JS React framework and HTML.
Our database is SQL in MariaDB.

## Installation ##

1. In order to use PHP, Apache, SQL technologies: Install Wampserver64 software that includes all the installations required for these   technologies.
2. Install NodeJS on your computer to run the game's server (node ​​website).
3. After those installations, make sure that the PHP and NodeJS servers run in the background by placing them in the environment variables of the computer. Type in the search for Windows "environment variables" -> go to "Edit environment variables for ..." -> In user variables click on path -> click on new -> enter the source address of the php.exe file (found In the wamp folder) and the source address of the node.exe file (located in program files).
4. Installing NodeJS in the game's folder: Go to cmd -> run cd command to the game's folder (MemoryGame) -> run npm install command.
5. Activating MariaDB: Log in to phpMyAdmin -> enter "root" as username, empty password, server choise MariaDB -> create a new database named "facefeka" -> click on import tab -> import the facefeka.sql file.

## run the project ##
1. Activating the game server: Go to cmd -> execute a cd command to the folder where the game is located -> run "npm start" command.
2. Activating the social network server: Go to cmd-> execute a cd command to the main folder of the project (FaceAfeka) -> run "php -S localhost:8080" command
3. Go to http://localhost:8080.