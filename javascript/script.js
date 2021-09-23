let npw = document.getElementsByClassName("navbar-profilepicture-wrapper")[0];
let npwm = document.getElementsByClassName("navbar-dropdown")[0];

npw.addEventListener("click", function(event) {
    event.preventDefault();

    if (npw.classList.contains('menu-open')) {
        npw.classList.toggle('menu-open');
        npwm.style.pointerEvents = "none";
        npwm.style.opacity = "0";
        npwm.style.top = "3.5em";
    } else {
        npw.classList.toggle('menu-open');
        npwm.style.pointerEvents = "auto";
        npwm.style.opacity = "1";
        npwm.style.top = "4em";
    }
});