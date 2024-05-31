function copyText() {
    var Text = document.getElementById("textbox");
    Text.select();
    navigator.clipboard.writeText(Text.value);
    document.getElementById("clipboard")
        .innerHTML = Text.value;
    }
function myFunction() {
    var popup = document.getElementById("myPopup");
    popup.classList.toggle("show");
    }
var Alert = new CustomAlert();
var Alert_pl = new CustomAlert_pl();

function CustomAlert(){
    this.render = function(){
        let popUpBox = document.getElementById('popUpBox');
        popUpBox.style.display = "block";
        document.getElementById('closeModal').innerHTML = '<a class="button" onclick="Alert.ok()">Close</a>';
    }
    this.ok = function(){
    document.getElementById('popUpBox').style.display = "none";
    document.getElementById('popUpOverlay').style.display = "none";
    }
}	

function CustomAlert_pl(){
    this.render = function(){
        let popUpBox = document.getElementById('popUpBox_pl');
        popUpBox.style.display = "block";
        document.getElementById('closeModal_pl').innerHTML = '<a class="button" onclick="Alert_pl.ok()">Close</a>';
    }
    this.ok = function(){
    document.getElementById('popUpBox_pl').style.display = "none";
    document.getElementById('popUpOverlay').style.display = "none";
    }
}	

const urlParams = new URLSearchParams(window.location.search);
const t = urlParams.get('t');
if (t !== null && !isNaN(t)) {
  const videoVideo = document.getElementById('video');
  videoVideo.currentTime = parseInt(t);
}

function seekToTime(timestamp) {
    var video = document.getElementById("video");

    var timeComponents = timestamp.split(":").map(component => parseInt(component, 10));

    var totalSeconds = 0;
    for (var i = 0; i < timeComponents.length; i++) {
      totalSeconds = totalSeconds * 60 + timeComponents[i];
    }

    video.currentTime = totalSeconds;
  }






  document.addEventListener('DOMContentLoaded', function () {
    const video = document.getElementById('video');
    const audio = document.getElementById('audio');
    const qualitySelector = document.getElementById('qualitySelector');

    let shouldUpdateTime = true;
    let disableSync = false;

    function syncPlayPause(event) {
        if (disableSync) return;
        if (event.target === audio && video.paused !== audio.paused) {
            if (audio.paused) video.pause();
            else video.play();
        } else if (event.target === video && video.paused !== audio.paused) {
            if (video.paused) audio.pause();
            else audio.play();
        }
    }

    video.addEventListener('play', syncPlayPause);
    video.addEventListener('pause', syncPlayPause);
    audio.addEventListener('play', syncPlayPause);
    audio.addEventListener('pause', syncPlayPause);

    function checkSync() {
        if (disableSync) return;
        if (shouldUpdateTime && Math.abs(video.currentTime - audio.currentTime) > 0.3) {
            audio.currentTime = video.currentTime;
        }
    }

    setInterval(checkSync, 100);

    document.addEventListener('visibilitychange', function () {
        if (disableSync) return;
        if (document.visibilityState === 'hidden') {
            shouldUpdateTime = false;
        } else if (document.visibilityState === 'visible') {
            video.currentTime = audio.currentTime;
            shouldUpdateTime = true;
        }
    });

    function keepPlaying() {
        if (disableSync) return;
        if (document.visibilityState === 'hidden') {
            if (!audio.paused) {
                audio.play().catch(error => console.log('Audio play error:', error));
            }
        } else {
            if (!video.paused) {
                video.play().catch(error => console.log('Video play error:', error));
            }
            if (!audio.paused) {
                audio.play().catch(error => console.log('Audio play error:', error));
            }
        }
        requestAnimationFrame(keepPlaying);
    }

    requestAnimationFrame(keepPlaying);

    video.addEventListener('seeked', () => {
        if (disableSync) return;
        if (shouldUpdateTime) {
            audio.currentTime = video.currentTime;
        }
    });

    // Populate quality selector
    const videoSources = video.getElementsByTagName('source');
    Array.from(videoSources).forEach(source => {
        const option = document.createElement('option');
        option.value = source.src;
        option.textContent = source.getAttribute('label');
        qualitySelector.appendChild(option);
    });

    // Add event listener for quality change
    qualitySelector.addEventListener('change', function () {
        const selectedQuality = this.options[this.selectedIndex].textContent;
        video.src = this.value;
        video.play();
        if (selectedQuality === '360/720p') {
            disableSync = true;
            audio.pause(); // Stop the audio
        } else {
            disableSync = false;
        }
    });
});
