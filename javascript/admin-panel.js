// Variables
let proSwcCol = document.querySelectorAll(".pro-swc-column");

// Function for each item
proSwcCol.forEach(function (item) {
    // Plus
    item.querySelector(".pro-swc-c-plus").addEventListener("click", function () {
        if (item.querySelector(".pro-swc-number").value >= 10) {
            item.querySelector(".pro-swc-number").value = parseInt(item.querySelector(".pro-swc-number").value);
            item.querySelector(".pro-swc-bar-inner").style.width = "100%";
        } else {
            item.querySelector(".pro-swc-number").value = parseInt(item.querySelector(".pro-swc-number").value) + 1;
            item.querySelector(".pro-swc-bar-inner").style.width = parseInt(item.querySelector(".pro-swc-bar-inner").style.width) + 20 + "%";
            console.log(item.querySelector(".pro-swc-bar-inner").style.width);
            item.querySelector(".pro-swc-bar-number").innerHTML = parseInt(item.querySelector(".pro-swc-bar-number").innerHTML) + 1;
        }
    });
    // Minus
    item.querySelector(".pro-swc-c-minus").addEventListener("click", function () {
        if (item.querySelector(".pro-swc-number").value <= 5) {
            item.querySelector(".pro-swc-number").value = parseInt(item.querySelector(".pro-swc-number").value);
            item.querySelector(".pro-swc-bar-inner").style.width = "0%";
        } else {
            item.querySelector(".pro-swc-number").value = parseInt(item.querySelector(".pro-swc-number").value) - 1;
            item.querySelector(".pro-swc-bar-inner").style.width = parseInt(item.querySelector(".pro-swc-bar-inner").style.width) - 20 + "%";
            item.querySelector(".pro-swc-bar-number").innerHTML = parseInt(item.querySelector(".pro-swc-bar-number").innerHTML) - 1;
        }
    });
});