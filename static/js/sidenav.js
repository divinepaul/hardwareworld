// display sidebar on click
document.querySelector("#side-menu").addEventListener("change",(event)=> {
    if(event.target.checked){
        document.querySelector(".sidebar").style.display = "block";
    } else {
        document.querySelector(".sidebar").style.display = "none";
    }
});

let seconds = 7000;
document.querySelectorAll(".message-container").forEach(messageElement => {
    messageElement.addEventListener("click",()=>{
        messageElement.remove();
    });
    setTimeout(() => {
        messageElement.remove();
    },seconds);
    seconds+=1000;
});
