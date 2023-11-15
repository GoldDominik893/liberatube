document.getElementById("form").addEventListener("submit", function(event) {
  event.preventDefault();
  var form = event.target;
  var formData = new FormData(form);
  var xhr = new XMLHttpRequest();
  xhr.open("POST", "/settings.php");
  xhr.onload = function() {
    if (xhr.status === 200) {
      location.reload();
    } else {
      console.error("Request failed with status:", xhr.status);
    }
  };
  xhr.onerror = function() {
    console.error("Request failed");
  };
  xhr.send(formData);
});