<div align="center">
<img src="/screenshots/lt.png" width="300px">
    <h1> Liberatube </h1>


  <a href="https://www.gnu.org/licenses/agpl-3.0.en.html">
    <img alt="License: AGPLv3" src="https://shields.io/badge/License-AGPL%20v3-blue.svg">
  </a>
  <a href="https://github.com/golddominik893/liberatube/commits/master">
    <img alt="GitHub commits" src="https://img.shields.io/github/commit-activity/y/golddominik893/liberatube?color=red&label=commits">
  </a>
  <a href="https://github.com/golddominik893/liberatube/issues">
    <img alt="GitHub issues" src="https://img.shields.io/github/issues/golddominik893/liberatube?color=important">
  </a>
  <a href="https://github.com/golddominik893/liberatube/pulls">
    <img alt="GitHub pull requests" src="https://img.shields.io/github/issues-pr/golddominik893/liberatube?color=blueviolet">
  </a>
  
  <h3> A Privacy, Feature Rich alternative front end to YouTube. </h3>
</div>

## Screenshots

| Home                      | Video              |
|-------------------------------------|-------------------------------------|
| ![](screenshots/home.png)    | ![](screenshots/video.png) |

| Channel                        | Comments             | Settings      |
|-------------------------------------|-------------------------------------|---------------------------------------|
| ![](screenshots/channel.png)   | ![](screenshots/comments.png) | ![](screenshots/settings.png) |

## Features

- Lightweight
- No ads
- No tracking
- Light/Dark/Blue/Ultra-dark themes
- Audio-only mode 
- Return YouTube Dislike
- Download videos
- Does not use official YouTube API's
- API *(soon)*
  
## To-do List

- Performance improvements
- DASH video through VideoJS.
- Autoplay for playlists.
- Sort videos on a users channel by date and popularity.
- Clickable timestamps from description or comments.
- Native language support.
- Playlist creation.
- Subscribing to channels.
- Caching the trending page to reduce loading times significantly.
- Annotations (clickable links on the video basically).
- Docker compose

## Instances of Liberatube
[badyt.lol](https://badyt.lol) - Stable, Hosted by GoldDominik893<br>
[ltbeta.epicsite.xyz](https://ltbeta.epicsite.xyz) - Beta, Hosted by GoldDominik893<br>


If you want to add your instance of Liberatube to this list please create an [issue](https://github.com/GoldDominik893/bad-youtube/issues)

## Installation
Clone the git repository,
```bash
git clone https://github.com/GoldDominik893/liberatube.git
```
Then paste the contents into the htdocs of any website hosting software that supports PHP and MySQL then import the `database.sql` in the MySQL dashboard. After that edit config.php and put your credentials for your database and your desired admin account.

### Updating Liberatube
Replace the contents of your htdocs folder with the new one and just keep the `config.php` file.

## Documentation
If you need help regarding this software please check the [Documentation](http://liberatube-docs.epicsite.xyz/) first before opening an issue or a discussion.

## Liability

We take no responsibility for the use of our tool, or external instances
provided by third parties. We strongly recommend you abide by the valid
official regulations in your country. Furthermore, we refuse liability
for any inappropriate use of Liberatube, such as illegal downloading.
This tool is provided to you in the spirit of free, open software.

You may view the LICENSE in which this software is provided to you [here](./LICENSE).

>   16. Limitation of Liability.
>
> IN NO EVENT UNLESS REQUIRED BY APPLICABLE LAW OR AGREED TO IN WRITING
WILL ANY COPYRIGHT HOLDER, OR ANY OTHER PARTY WHO MODIFIES AND/OR CONVEYS
THE PROGRAM AS PERMITTED ABOVE, BE LIABLE TO YOU FOR DAMAGES, INCLUDING ANY
GENERAL, SPECIAL, INCIDENTAL OR CONSEQUENTIAL DAMAGES ARISING OUT OF THE
USE OR INABILITY TO USE THE PROGRAM (INCLUDING BUT NOT LIMITED TO LOSS OF
DATA OR DATA BEING RENDERED INACCURATE OR LOSSES SUSTAINED BY YOU OR THIRD
PARTIES OR A FAILURE OF THE PROGRAM TO OPERATE WITH ANY OTHER PROGRAMS),
EVEN IF SUCH HOLDER OR OTHER PARTY HAS BEEN ADVISED OF THE POSSIBILITY OF
SUCH DAMAGES.
