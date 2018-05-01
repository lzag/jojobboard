document.getElementById('remove-user-btn').addEventListener('click',askForSure);

function askForSure() {
    confirm("Please confirm if you'd like to remove your account");
}

document.getElementById('changeBgColor').addEventListener('click',changeColor);

function changeColor () {
    var color = document.getElementById('BgSelect').value;
    console.log(color);
    h6 = document.getElementById('userdata');
    console.log(h6);
    h6.innerHTML = color;


}
