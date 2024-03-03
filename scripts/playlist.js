function fetchPlaylists() {
    $.ajax({
        type: "GET",
        url: "/playlist/fetch_playlists.php",
        success: function(playlists) {
            console.log("Fetched Playlists:", playlists);
            populatePlaylistDropdown(playlists);
        },
        error: function(xhr, status, error) {
            console.error("Error fetching playlists:", status, error);
        }
    });
}

function populatePlaylistDropdown(playlists) {
    var select = $("#playlistSelect");
    select.empty();

    // Add default option
    select.append($("<option>").val("").text("Select a Playlist"));

    // Add each playlist to the dropdown
    playlists.forEach(function(playlist) {
        select.append($("<option>").val(playlist.id).text(playlist.name));
    });
}

function addToPlaylist() {
    var videoId = $("#videoId").val();
    var videoTitle = $("#videoTitle").val();
    var videoAuthor = $("#videoAuthor").val();
    var playlistId = $("#playlistSelect").val();

    if (playlistId === "") {
        alert("Please select a playlist.");
        return;
    }

    // Validate and sanitize user inputs as needed

    $.ajax({
        type: "POST",
        url: "/playlist/add_to_playlist.php",
        data: {
            videoId: videoId,
            videoTitle: videoTitle,
            videoAuthor: videoAuthor,
            playlistId: playlistId
        },
        success: function(response) {
            console.log("Add to Playlist Response:", response);
            $("#result").html(response);
        },
        error: function(xhr, status, error) {
            console.error("Error adding video to playlist:", status, error);
            $("#result").html("Error adding video to playlist.");
        }
    });
}

// Fetch and populate the dropdown when the page loads
$(document).ready(function() {
    fetchPlaylists();
});
