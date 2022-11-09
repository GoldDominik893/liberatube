function w3_open() {
    document.getElementById("mySidebar").style.display = "block";
    }
  
function w3_close() {
    document.getElementById("mySidebar").style.display = "none";
    }

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