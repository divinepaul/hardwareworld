console.log("yes");
var canvas = document.getElementById("canvas");
var canvasContainer = document.querySelector(".canvas-logo");
canvas.width = canvas.parentElement.clientWidth;
canvas.height = canvas.parentElement.clientHeight;
let height = canvas.clientHeight;
let width = canvas.clientWidth;

console.log(height);
console.log(width);

let diagonalWidth = Math.sqrt(Math.pow((width/2),2)+Math.pow((height/2),2));
let centerX = width/2;
let centerY = height/2;

var c = canvas.getContext("2d");
class Point {
    constructor(color) {
        this.angle = Math.random() * 2 * Math.PI;
        this.speed = Math.random() / 30;
        this.distance = Math.floor(Math.random()*diagonalWidth/2);
        this.x = centerX + (this.distance * Math.cos(this.angle));
        this.y = centerY + (this.distance * Math.sin(this.angle));
        this.color = color;
    }
    draw(){
        c.fillStyle = this.color;
        c.beginPath();
        c.arc(this.x,this.y, 5, 0, 2 * Math.PI, false);
        c.fill();
    }
    update(){
        this.angle += this.speed;
        this.x = centerX + (this.distance * Math.cos(this.angle));
        this.y = centerY + (this.distance * Math.sin(this.angle));
    }

}
let points = [];
let colors = ["#3a0ca3"];
for(let i =0;i<=300;i++){
    let point = new Point(colors[Math.floor(Math.random()*colors.length)]);
    if(point.distance > 170){
        points.push(point);
    }
}
function animate(){
    points.forEach(point=>{
        point.update();
        point.draw();
    });
    c.fillStyle = 'rgba(255,255,255,0.11)';
    c.fillRect(0,0,document.body.clientWidth,document.body.clientHeight);
    requestAnimationFrame(animate)
}

animate();

canvasContainer.addEventListener("mouseover", ()=> {
    for (let i = 0; i < points.length; i++) {
        points[i].speed = Math.random() / 40;
        let colors = ["#f72585","#7209b7","#3a0ca3","#4361ee","#4cc9f0"];
        points[i].color = colors[Math.floor(Math.random()*colors.length)];
    }
})

canvasContainer.addEventListener("mouseout", ()=> {
    for (let i = 0; i < points.length; i++) {
        points[i].speed = Math.random() / 30;
        points[i].color = "#3a0ca3";
    }
})
