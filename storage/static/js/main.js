function GetRoll () {
    if (document.documentElement.scrollTop >= 500) {
        document.getElementById("topbar").style.position="fixed";
        document.getElementById("topbar").style.zIndex="9999";
    } else {
        document.getElementById("topbar").style.position="unset";
        document.getElementById("topbar").style.zIndex="unset";
    }
}
window.addEventListener('scroll', GetRoll);