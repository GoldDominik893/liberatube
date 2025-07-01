<?php
// ALL FIELDS ARE REQUIRED (except SQL, only if $useSQL is false)

// SQL
$useSQL = true;                                   // If you want to use a SQL database to store user data (true / false)
$servername = "localhost";                        // The IP / domain used to connect to your database
$username = "root";                               // The database username
$password = "";                                   // The database password
$dbname = "users";                                // The database name, by default, if you imported database.sql it is "users"

// COMMENT OUT THE PREVIOUS LINES AND UNCOMMENT THESE IF USING DOCKER
// $servername = "db";
// $username = "root";
// $password = "password";
// $dbname = "users";

// Invidious
$InvVIServer = "https://invidious.tail5b365.ts.net";  // Only used temporarily by media fetch, replaced soon.
$InvVIServerArray = [                                 // Include multiple instances for failover.
                    "https://nyc1.iv.ggtyler.dev",
                    "https://lekker.gay",
                    "https://invidious.tail5b365.ts.net",
                    "https://invidious.schenkel.eti.br",
                    "https://id.420129.xyz",
                    "https://inv.nadeko.net",
                    "https://iv.duti.dev",
                    "https://invidious.adminforge.de",
                    "https://invidious.kavin.rocks",
                    "https://invidious.snopyta.org",
                    "https://invidious.f5.si",
                    "https://invidious.osi.kr",
                ];
$InvSServer = "https://oci-invidious.epicsite.xyz";  // Instance used for: Search, Channels, Playlists, Captions.
$InvCServer = "https://oci-invidious.epicsite.xyz";  // Instance used for: Video Comments.
$InvTServer = "https://oci-invidious.epicsite.xyz";  // Instance used for: Trending page (homepage).


// Admin and Defaults
$cacheTime = 20000;                                // Time in seconds that the cache will be valid for (integer)
$defaultRegion = "GB";                             // If the user is logged out or doesn't have a region set this will be the default, (put any 2 digit country code)
$defaultTheme = "ultra-dark";                      // If the user is logged out or doesn't have a theme set this will be the default, (blue / ultra-dark)
$defaultLang = "en";                               // If the user is logged out or doesn't have a language set this will be the default
$defaultLoadCommentsSetting = "noreplies";         // If the user is logged out or doesn't have a comments loading preference set this will be the default (nothing / noreplies / showall)
$adminuser = "GoldDominik893";                     // The user on liberatube you want to have access to the admin dashboard
$testinstance = true;                              // Whether this is a test instance. A disclaimer will be shown, (true / false)
$allowProxy = "false";                             // Choose if the users can proxy video data through the server, (true / false / downloads)
$useReturnYTDislike = true;                        // Choose whether the server contacts the return youtube dislike api for an estimate of the dislikes, (true / false)
