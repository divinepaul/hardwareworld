// display sidebar on click
document.querySelector("#side-menu").addEventListener("change",(event)=> {
    if(event.target.checked){
        document.querySelector(".sidebar").style.display = "block";
    } else {
        document.querySelector(".sidebar").style.display = "none";
    }
});
