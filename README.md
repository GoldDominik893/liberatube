<div align="center">
<img src="/screenshots/lt.png" width="300px">
    <h1> Liberatube </h1>

<a href="https://www.gnu.org/licenses/agpl-3.0.en.html">
    <img alt="License: AGPLv3" src="https://shields.io/badge/License-MIT%20-blue.svg">
  </a>
  <a href="https://github.com/iv-org/invidious/commits/master">
    <img alt="GitHub commits" src="https://img.shields.io/github/commit-activity/y/golddominik893/liberatube?color=red&label=commits">
  </a>
  <a href="https://github.com/iv-org/invidious/issues">
    <img alt="GitHub issues" src="https://img.shields.io/github/issues/golddominik893/liberatube?color=important">
  </a>
  <a href="https://github.com/iv-org/invidious/pulls">
    <img alt="GitHub pull requests" src="https://img.shields.io/github/issues-pr/golddominik893/liberatube?color=blueviolet">
  </a>
  
  <h3> A Privacy, Feature Rich alternative front end to YouTube. </h3>
</div>

## Screenshots

| Search page                         | Ultra dark theme               |
|-------------------------------------|-------------------------------------|
| ![](screenshots/search-page.png)    | ![](screenshots/ultra-dark-theme.png) |

| Audio player                         | Trending content page               | Video player with blue theme      |
|-------------------------------------|-------------------------------------|---------------------------------------|
| ![](screenshots/audio-player.png)    | ![](screenshots/trending-content-page.png) | ![](screenshots/different-themes.png) |

## Features

- Lightweight
- No ads
- No tracking
- Light/Dark/Blue/Ultra-dark themes
- Audio-only mode 
- Uses the Return YouTube Dislike API to get an estimate of the number of dislikes
- Download videos
- Does not use official YouTube API's *(soon)*
- API *(soon)*


## Instances of Liberatube
[two.epicfaucet.gq](https://two.epicfaucet.gq) (old ver, gonna expire, official)<br>
[badyt.cf](https://badyt.cf) (old ver, gonna expire, official)<br>
[badyt.lol](https://badyt.lol) (new ver, official)<br>
[badyt.epicsite.xyz](https://badyt.epicsite.xyz) (will use in the future, official)<br>
[badytbeta.epicsite.xyz](https://badytbeta.epicsite.xyz) (beta, official)<br>

If you want to add your instance of Bad YouTube to this list please create an [issue](https://github.com/GoldDominik893/bad-youtube/issues)

## Installation
Clone the git repository,
```bash
git clone https://github.com/GoldDominik893/liberatube.git
```
Then paste the contents into the htdocs of any website hosting software that supports PHP and MySQL then import the `database.sql` in the MySQL dashboard. After that edit config.php and put your credentials for your database and your desired admin account. You also need to have a YouTube API v3 you can get an API key from [here](https://console.cloud.google.com).

### Updating Liberatube
Replace the contents of your htdocs folder with the new one and just keep the `config.php` file.
