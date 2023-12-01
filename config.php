<?php 
    // ALL FIELDS ARE REQUIRED (except SQL, only if $useSQL is false)

    // SQL
    $useSQL = true;                                  // If you want to use a SQL database to store user data (true / false)
    $servername = "localhost";                       // The IP / domain used to connect to your database
    $username = "root";                              // The database username
    $password = "";                                  // The database password
    $dbname = "users";                               // The database name, by default, if you imported database.sql it is "users"

    // Invidious
    $InvVDServer1 = "https://invidious.lunar.icu";   // The Invidious instance that will be set as first priority to fetch video data
    $InvVDServer2 = "https://invidious.nerdvpn.de";  // The Invidious instance that will be set as second priority to fetch video data
    $InvVDCAServer1 = "https://invidious.lunar.icu"; // The Invidious instance that will be set as first priority to fetch video captions
    $InvVDCAServer2 = "https://invidious.lunar.icu"; // The Invidious instance that will be set as second priority to fetch video captions
    $InvCServer = "https://invidious.lunar.icu";     // The Invidious instance that will be used to fetch comments
    $InvVIServer = "https://invidious.lunar.icu";    // The Invidious instance that will be used to fetch video information
    $InvTServer = "https://invidious.lunar.icu";     // The Invidious instance that will be used to fetch trending videos for the home page
    $InvSServer = "https://invidious.lunar.icu";     // The Invidious instance that will be used to search for content

    // Admin and Defaults
    $defaultRegion = "GB";                           // If the user is logged out or doesn't have a region set this will be the default, (put any 2 digit country code)
    $defaultTheme = "ultra-dark";                    // If the user is logged out or doesn't have a theme set this will be the default, (dark / light / blue / ultra-dark)
    $defaultLang = "en";                             // If the user is logged out or doesn't have a language set this will be the default
    $defaultLoadCommentsSetting = "nothing";         // If the user is logged out or doesn't have a comments loading preference set this will be the default (nothing, noreplies)
    $adminuser = "GoldDominik893";                   // The user on liberatube you want to have access to the admin dashboard
    $testinstance = true;                            // Whether this is a test instance. A disclaimer will be shown, (true / false)
    $allowProxy = "downloads";                       // Choose if the users can proxy video data through the server, (true / false / downloads)
    $useReturnYTDislike = true;                      // Choose whether the server contacts the return youtube dislike api for an estimate of the dislikes, (true / false)
?>
