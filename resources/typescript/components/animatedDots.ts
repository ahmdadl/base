import Vue from "vue";
import Component from "vue-class-component";

interface Color {
    r: number;
    g: number;
    b: number;
    a: number;
}

interface Particle {
    x: number;
    y: number;
    r: number;
    c: any;
    d: number;
    s: number;
}

@Component({
    template: '<canvas id="canvas" :width="width" :height="height"></canvas>'
})
export default class animatedDots extends Vue {
    public el: HTMLCanvasElement;
    public ctx: CanvasRenderingContext2D;
    public width = window.innerWidth;
    public height = window.innerHeight;
    public config = {
        particleNumber: 50,
        maxParticleSize: 5,
        maxSpeed: 5,
        colorVariation: 150
    };
    public colorPalette = {
        bg: { r: 12, g: 9, b: 29 },
        matter: [
            { r: 36, g: 18, b: 42 },
            { r: 78, g: 36, b: 42 },
            { r: 252, g: 178, b: 96 },
            { r: 253, g: 238, b: 152 } // totesASun
        ]
    };
    public particles: Array<Particle> = [];
    public centerX = this.width / 2;
    public centerY = this.height / 2;

    public drawBg(ctx: CanvasRenderingContext2D, color: Color | any): void {
        this.ctx.fillStyle =
            "rgb(" + color.r + "," + color.g + "," + color.b + ")";
        this.ctx.fillRect(0, 0, this.width, this.height);
    }

    public createParticle(x: number, y: number): Particle {
        x = x || Math.round(Math.random() * this.width);
        // Y Coordinate
        y = y || Math.round(Math.random() * this.height);
        // Radius of the space dust
        let r = Math.ceil(Math.random() * this.config.maxParticleSize);
        // Color of the rock, given some randomness
        let c = this.colorVariation(
            this.colorPalette.matter[
                Math.floor(Math.random() * this.colorPalette.matter.length)
            ],
            true
        );
        // Speed of which the rock travels
        let s = Math.pow(Math.ceil(Math.random() * this.config.maxSpeed), 0.7);
        // Direction the Rock flies
        let d = Math.round(Math.random() * 360);

        return { x, y, r, c, s, d };
    }

    /**
     * Provides some nice color variation
     * Accepts an rgba object
     * returns a modified rgba object or a rgba string if
     * true is passed in for argument 2
     *
     * @param color
     * @param returnString
     */
    public colorVariation(color: any, returnString: boolean): string | Color {
        let r: number, g: number, b: number, a: number;

        r = Math.round(
            Math.random() * this.config.colorVariation -
                this.config.colorVariation / 2 +
                color.r
        );
        g = Math.round(
            Math.random() * this.config.colorVariation -
                this.config.colorVariation / 2 +
                color.g
        );
        b = Math.round(
            Math.random() * this.config.colorVariation -
                this.config.colorVariation / 2 +
                color.b
        );
        a = Math.random() + 0.5;

        if (returnString) {
            return "rgba(" + r + "," + g + "," + b + "," + a + ")";
        } else {
            return { r: r, g: g, b: b, a: a };
        }
    }

    /**
     * Used to find the rocks next point in space,
     * accounting for speed and direction
     *
     * @param p
     * @returns Particle
     */
    public updateParticleModel(p: Particle): Particle {
        var a = 180 - (p.d + 90); // find the 3rd angle
        p.d > 0 && p.d < 180
            ? (p.x += (p.s * Math.sin(p.d)) / Math.sin(p.s))
            : (p.x -= (p.s * Math.sin(p.d)) / Math.sin(p.s));
        p.d > 90 && p.d < 270
            ? (p.y += (p.s * Math.sin(a)) / Math.sin(p.s))
            : (p.y -= (p.s * Math.sin(a)) / Math.sin(p.s));
        return p;
    }

    /**
     *  Just the function that physically draws the particles
     * Physically? sure why not, physically.
     *
     * @param x
     * @param y
     * @param r
     * @param c
     */
    public drawParticle(x: number, y: number, r: number, c: string): void {
        this.ctx.beginPath();
        this.ctx.fillStyle = c;
        this.ctx.arc(x, y, r, 0, 2 * Math.PI, false);
        this.ctx.fill();
        this.ctx.closePath();
    }

    public cleanUpArray(): void {
        this.particles = this.particles.filter(p => {
            return p.x > -100 && p.y > -100;
        });
    }

    public initParticles(
        numParticles: number,
        x: number = 0,
        y: number = 0
    ): void {
        for (var i = 0; i < numParticles; i++) {
            this.particles.push(this.createParticle(x, y));
        }
        let _a = this
        this.particles.forEach(function(p) {
            _a.drawParticle(p.x, p.y, p.r, p.c);
        });
    }

    public support = {
        animationFrame: window.requestAnimationFrame ||
            window.webkitRequestAnimationFrame ||
            // @ts-ignore
            window.mozRequestAnimationFrame ||
            // @ts-ignore
            window.msRequestAnimationFrame ||
            // @ts-ignore
            window.oRequestAnimationFrame
    }

    public requestAnimFrame (fun) {
        return this.support.animationFrame.call(window, fun)
    }

    public frame() {
        let _a = this;
        this.drawBg(this.ctx, this.colorPalette.bg);
        // Update Particle models to new position
        this.particles.map(function(p) {
            return _a.updateParticleModel(p);
        });
        // Draw em'
        
        this.particles.forEach(function(p) {
            // console.log(_a)
            _a.drawParticle(p.x, p.y, p.r, p.c);
        });
        // Play the same song? Ok!
        this.requestAnimFrame(this.frame);
    }

    mounted() {
        this.el = <HTMLCanvasElement>this.$el;
        this.ctx = <CanvasRenderingContext2D>this.el.getContext("2d");

        // First Frame
        this.frame();
        // First particle explosion
        this.initParticles(this.config.particleNumber);
        setInterval((x: any) => {
            this.cleanUpArray();
            this.initParticles(this.config.particleNumber);
        }, 3000);

        // set header height to the same as canvas
        let x = this.$root.$refs.canvasHeader as HTMLDivElement
        x.style.height = window.innerHeight + 'px'
    }
}
