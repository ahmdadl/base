var canvas = document.getElementById("canvas") as HTMLCanvasElement,
    ctx = canvas.getContext("2d") as CanvasRenderingContext2D;
    
// Set Canvas to be window size
canvas.width = window.innerWidth;
canvas.height = window.innerHeight;
// Configuration, Play with these
var config = {
    particleNumber: 50,
    maxParticleSize: 5,
    maxSpeed: 5,
    colorVariation: 150
};
interface Color {
    r: number;
    g: number;
    b: number;
    a: number;
}
// Colors
var colorPalette = {
    bg: { r: 12, g: 9, b: 29 },
    matter: [
        { r: 36, g: 18, b: 42 },
        { r: 78, g: 36, b: 42 },
        { r: 252, g: 178, b: 96 },
        { r: 253, g: 238, b: 152 } // totesASun
    ]
};
// Some Variables hanging out
var particles: Array<Particle> = [],
    centerX = canvas.width / 2,
    centerY = canvas.height / 2;
// Draws the background for the canvas, because space
let drawBg = function(ctx: CanvasRenderingContext2D, color: Color | any) {
        ctx.fillStyle = "rgb(" + color.r + "," + color.g + "," + color.b + ")";
        ctx.fillRect(0, 0, canvas.width, canvas.height);
    };
    
class Particle {
    public x: number;
    public y: number;
    public r: number;
    public c: any;
    public d: number;
    public s: number;

    public constructor (x: number, y: number) {
        this.x = x || Math.round(Math.random() * canvas.width);
        // Y Coordinate
        this.y = y || Math.round(Math.random() * canvas.height);
        // Radius of the space dust
        this.r = Math.ceil(Math.random() * config.maxParticleSize);
        // Color of the rock, given some randomness
        this.c = colorVariation(
            colorPalette.matter[
                Math.floor(Math.random() * colorPalette.matter.length)
            ],
            true
        );
        // Speed of which the rock travels
        this.s = Math.pow(Math.ceil(Math.random() * config.maxSpeed), 0.7);
        // Direction the Rock flies
        this.d = Math.round(Math.random() * 360);
    }
}
// Provides some nice color variation
// Accepts an rgba object
// returns a modified rgba object or a rgba string if true is passed in for argument 2
function colorVariation (color:any, returnString: boolean) : any
{
    var r, g, b, a, variation;
    r = Math.round(
        Math.random() * config.colorVariation -
            config.colorVariation / 2 +
            color.r
    );
    g = Math.round(
        Math.random() * config.colorVariation -
            config.colorVariation / 2 +
            color.g
    );
    b = Math.round(
        Math.random() * config.colorVariation -
            config.colorVariation / 2 +
            color.b
    );
    a = Math.random() + 0.5;
    if (returnString) {
        return "rgba(" + r + "," + g + "," + b + "," + a + ")";
    } else {
        return { r: r, g: g, b: b, a: a };
    }
};
// Used to find the rocks next point in space, accounting for speed and direction
var updateParticleModel = function(p: Particle) {
    var a = 180 - (p.d + 90); // find the 3rd angle
    p.d > 0 && p.d < 180
        ? (p.x += (p.s * Math.sin(p.d)) / Math.sin(p.s))
        : (p.x -= (p.s * Math.sin(p.d)) / Math.sin(p.s));
    p.d > 90 && p.d < 270
        ? (p.y += (p.s * Math.sin(a)) / Math.sin(p.s))
        : (p.y -= (p.s * Math.sin(a)) / Math.sin(p.s));
    return p;
};
// Just the function that physically draws the particles
// Physically? sure why not, physically.
var drawParticle = function(x: number, y: number, r: number, c: string) {
    ctx.beginPath();
    ctx.fillStyle = c;
    ctx.arc(x, y, r, 0, 2 * Math.PI, false);
    ctx.fill();
    ctx.closePath();
};
// Remove particles that aren't on the canvas
var cleanUpArray = function() {
    particles = particles.filter(function(p) {
        return p.x > -100 && p.y > -100;
    });
};
var initParticles = function(numParticles: number, x: number = 0, y: number = 0) {
    for (var i = 0; i < numParticles; i++) {
        particles.push(new Particle(x, y));
    }
    particles.forEach(function(p) {
        drawParticle(p.x, p.y, p.r, p.c);
    });
};
// That thing
let requestAnimFrame = (function() {
    return (
        window.requestAnimationFrame ||
        window.webkitRequestAnimationFrame ||
        // @ts-ignore
        window.mozRequestAnimationFrame ||
        function(callback) {
            window.setTimeout(callback, 1000 / 60);
        }
    );
})();
// Our Frame function
var frame = function() {
    // Draw background first
    drawBg(ctx, colorPalette.bg);
    // Update Particle models to new position
    particles.map(function(p) {
        return updateParticleModel(p);
    });
    // Draw em'
    particles.forEach(function(p) {
        drawParticle(p.x, p.y, p.r, p.c);
    });
    // Play the same song? Ok!
    requestAnimFrame(frame);
};
// First Frame
frame();
// First particle explosion
initParticles(config.particleNumber);
setInterval((x: any) => {
    cleanUpArray();
    initParticles(config.particleNumber);
}, 3000);

// animate string
let jobTitle = document.getElementById('job-title') as HTMLElement;

function textTyping () {
    let arr = [
        'A will not rendered',
        'A Back End Web Developer',
        'A Laravel Developer',
        'A Full Stack Web Developer'
    ],
    i = 0,
    j = 0;

    setInterval(_ => {
        if (i > 2) i = 0;
        let speed = 90;
        if (j >= arr[i].length) j = 0;
        jobTitle.textContent = ''
        function typeWriter() {
            if (arr[i] && j >= arr[i].length) return;
            jobTitle.textContent += arr[i].charAt(j)
            j++;
            setTimeout(typeWriter, speed);
        }
        typeWriter();
        i++;
    }, 4000)

    
}

// changeTitle();
export {textTyping}