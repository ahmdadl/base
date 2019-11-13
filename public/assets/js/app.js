/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 0);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/sass/app.scss":
/*!*********************************!*\
  !*** ./resources/sass/app.scss ***!
  \*********************************/
/*! no static exports found */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),

/***/ "./resources/typescript/app.ts":
/*!*************************************!*\
  !*** ./resources/typescript/app.ts ***!
  \*************************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _partials_textTyping__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./partials/textTyping */ "./resources/typescript/partials/textTyping.ts");


Object(_partials_textTyping__WEBPACK_IMPORTED_MODULE_0__["textTyping"])();


/***/ }),

/***/ "./resources/typescript/partials/textTyping.ts":
/*!*****************************************************!*\
  !*** ./resources/typescript/partials/textTyping.ts ***!
  \*****************************************************/
/*! exports provided: textTyping */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "textTyping", function() { return textTyping; });
var canvas = document.getElementById("canvas"), ctx = canvas.getContext("2d"), header = document.getElementById('canvasHeader');
// Set Canvas to be window size
canvas.width = window.innerWidth;
canvas.height = window.innerHeight;
header.style.height = window.innerHeight + 'px';
// Configuration, Play with these
var config = {
    particleNumber: 50,
    maxParticleSize: 5,
    maxSpeed: 5,
    colorVariation: 150
};
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
var particles = [], centerX = canvas.width / 2, centerY = canvas.height / 2;
// Draws the background for the canvas, because space
var drawBg = function (ctx, color) {
    ctx.fillStyle = "rgb(" + color.r + "," + color.g + "," + color.b + ")";
    ctx.fillRect(0, 0, canvas.width, canvas.height);
};
var Particle = /** @class */ (function () {
    function Particle(x, y) {
        this.x = x || Math.round(Math.random() * canvas.width);
        // Y Coordinate
        this.y = y || Math.round(Math.random() * canvas.height);
        // Radius of the space dust
        this.r = Math.ceil(Math.random() * config.maxParticleSize);
        // Color of the rock, given some randomness
        this.c = colorVariation(colorPalette.matter[Math.floor(Math.random() * colorPalette.matter.length)], true);
        // Speed of which the rock travels
        this.s = Math.pow(Math.ceil(Math.random() * config.maxSpeed), 0.7);
        // Direction the Rock flies
        this.d = Math.round(Math.random() * 360);
    }
    return Particle;
}());
// Provides some nice color variation
// Accepts an rgba object
// returns a modified rgba object or a rgba string if true is passed in for argument 2
function colorVariation(color, returnString) {
    var r, g, b, a, variation;
    r = Math.round(Math.random() * config.colorVariation -
        config.colorVariation / 2 +
        color.r);
    g = Math.round(Math.random() * config.colorVariation -
        config.colorVariation / 2 +
        color.g);
    b = Math.round(Math.random() * config.colorVariation -
        config.colorVariation / 2 +
        color.b);
    a = Math.random() + 0.5;
    if (returnString) {
        return "rgba(" + r + "," + g + "," + b + "," + a + ")";
    }
    else {
        return { r: r, g: g, b: b, a: a };
    }
}
;
// Used to find the rocks next point in space, accounting for speed and direction
var updateParticleModel = function (p) {
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
var drawParticle = function (x, y, r, c) {
    ctx.beginPath();
    ctx.fillStyle = c;
    ctx.arc(x, y, r, 0, 2 * Math.PI, false);
    ctx.fill();
    ctx.closePath();
};
// Remove particles that aren't on the canvas
var cleanUpArray = function () {
    particles = particles.filter(function (p) {
        return p.x > -100 && p.y > -100;
    });
};
var initParticles = function (numParticles, x, y) {
    if (x === void 0) { x = 0; }
    if (y === void 0) { y = 0; }
    for (var i = 0; i < numParticles; i++) {
        particles.push(new Particle(x, y));
    }
    particles.forEach(function (p) {
        drawParticle(p.x, p.y, p.r, p.c);
    });
};
// That thing
var requestAnimFrame = (function () {
    return (window.requestAnimationFrame ||
        window.webkitRequestAnimationFrame ||
        // @ts-ignore
        window.mozRequestAnimationFrame ||
        function (callback) {
            window.setTimeout(callback, 1000 / 60);
        });
})();
// Our Frame function
var frame = function () {
    // Draw background first
    drawBg(ctx, colorPalette.bg);
    // Update Particle models to new position
    particles.map(function (p) {
        return updateParticleModel(p);
    });
    // Draw em'
    particles.forEach(function (p) {
        drawParticle(p.x, p.y, p.r, p.c);
    });
    // Play the same song? Ok!
    requestAnimFrame(frame);
};
// First Frame
frame();
// First particle explosion
initParticles(config.particleNumber);
setInterval(function (x) {
    cleanUpArray();
    initParticles(config.particleNumber);
}, 3000);
// animate string
var jobTitle = document.getElementById('job-title');
function textTyping() {
    var arr = [
        'A will not rendered',
        'A Back End Web Developer',
        'A Laravel Developer',
        'A Full Stack Web Developer'
    ], i = 0, j = 0;
    setInterval(function (_) {
        if (i > 2)
            i = 0;
        var speed = 90;
        if (j >= arr[i].length)
            j = 0;
        jobTitle.textContent = '';
        function typeWriter() {
            if (arr[i] && j >= arr[i].length)
                return;
            jobTitle.textContent += arr[i].charAt(j);
            j++;
            setTimeout(typeWriter, speed);
        }
        typeWriter();
        i++;
    }, 4000);
}
// changeTitle();



/***/ }),

/***/ 0:
/*!*********************************************************************!*\
  !*** multi ./resources/typescript/app.ts ./resources/sass/app.scss ***!
  \*********************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(/*! C:\xampp\htdocs\ninjaCoder\resources\typescript\app.ts */"./resources/typescript/app.ts");
module.exports = __webpack_require__(/*! C:\xampp\htdocs\ninjaCoder\resources\sass\app.scss */"./resources/sass/app.scss");


/***/ })

/******/ });