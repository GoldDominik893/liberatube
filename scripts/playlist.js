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
            toast("error", "Failed to load playlists.", 4000);
        }
    });
}

function populatePlaylistDropdown(playlists) {
    const select = $("#playlistSelect");
    select.empty();
    select.append($("<option>").val("").text("Select a Playlist"));
    playlists.forEach(function (playlist) {
        select.append($("<option>").val(playlist.id).text(playlist.name));
    });
}

function addToPlaylist() {
    const videoId = $("#videoId").val();
    const videoTitle = $("#videoTitle").val();
    const videoAuthor = $("#videoAuthor").val();
    const playlistId = $("#playlistSelect").val();

    if (playlistId === "") {
        toast("info", "Please select a playlist first.", 3000);
        return;
    }

    $.ajax({
        type: "POST",
        url: "/playlist/add_to_playlist.php",
        data: {
            videoId,
            videoTitle,
            videoAuthor,
            playlistId
        },
        success: function (response) {
            console.log("Add to Playlist Response:", response);
            // Check if the response contains a success indicator
            if (response.toLowerCase().includes("added")) {
                toast("success", response, 4000);
            } else {
                toast("error", response, 4000);
            }
        },
        error: function (xhr, status, error) {
            console.error("Error adding video to playlist:", status, error);
            toast("error", "Failed to add video to playlist.", 4000);
        }
    });
}

$(document).ready(function () {
    fetchPlaylists();
});
