<?php 
    /** ALL FIELDS ARE REQUIRED */
    $servername = "localhost"; /** The IP / domain used to connect to your database */
    $username = "root"; /** The database username */
    $password = ""; /** The database password */
    $dbname = "users"; /** The database name, by default, if you imported database.sql it is "users" */
    $adminuser = "GoldDominik893"; /** The user on badyt you want to have access to the admin dashboard */
    $ytapikey = "AIzaSyCw9PUr1rYYX4Z5QD5cyb2iimkN755Warc"; /** Your YouTube API v3 Key */

    $InvVDServer1 = "https://yewtu.be"; /** The Invidious instance that will be set as first priority to fetch video data */
    $InvVDServer2 = "https://invidio.xamh.de"; /** The Invidious instance that will be set as second priority to fetch video data */
    $InvVDCAServer1 = "https://invidious.nerdvpn.de"; /** The Invidious instance that will be set as first priority to fetch video captions */
    $InvVDCAServer2 = "https://invidious.esmailelbob.xyz"; /** The Invidious instance that will be set as second priority to fetch video captions */
    $InvCServer = "https://invidious.dhusch.de"; /** The Invidious instance that will be used to fetch comments */
    $InvVIServer = "https://invidious.dhusch.de"; /** The Invidious instance that will be used to fetch video information */
    $InvTServer = "https://invidious.dhusch.de"; /** The Invidious instance that will be used to fetch trending videos for the home page. */

    $defaultRegion = "GB"; /** If the user is logged out or doesn't have a region set this will be the default, put any 2 digit country code. */
    $defaultTheme = "ultra-dark"; /** If the user is logged out or doesn't have a theme set this will be the default, (dark, light, blue, ultra-dark) */
    $defaultLang = "en"; /** If the user is logged out or doesn't have a language set this will be the default */
?>