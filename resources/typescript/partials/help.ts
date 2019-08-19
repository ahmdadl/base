class El
{
    public el: HTMLElement | any;
    public elArr: NodeListOf<HTMLElement>;

    private cssSelector: string;

    constructor(cssSelector : any)
    {
        if (cssSelector instanceof El) {
            this.el = cssSelector;
        } else {
            this.cssSelector = cssSelector;
            this.el = document.querySelector(this.cssSelector);
        }
    }

    public getAll() : NodeListOf<HTMLElement>
    {
        return document.querySelectorAll(this.cssSelector);
    }

    public handleAll(callback: CallableFunction) : void
    {
        // get the list of html elemnts with that selector
        let elArr: NodeListOf<Element> = this.getAll();

        // loop through elements
        for (let i in elArr) {
            // run the callback function with the current element
            if (elArr.hasOwnProperty(i)) {
                callback(elArr[i]);
            }
        }
    }

    public getId() : string
    {
        return <string>this.el.id;
    }
    
    public addClass(cls: string) : void
    {
        if (this.el.className.indexOf(cls) === -1) {
            this.el.className += ' ' + cls;
        }
    }

    public removeClass(cls: string) : void
    {
        this.el.className = this.el.className.replace(cls, '');
    }

    public css(prop: string, value: string) : void
    {
        this.el.style[prop] = value;
    }

    public attr(prop: string, value: any = null) : any
    {
        // check if no value added then return current attribute value
        if (null === value) return this.el.getAttribute(prop);
        // set attribute value
        this.el.setAttribute(prop, value);
    }

    public focus(callback: CallableFunction) : void
    {
        this.addEvent('focus', callback);
    }
    
    public blur(callback: CallableFunction) : void
    {
        this.addEvent('blur', callback);
    }

    public keyPress(callback: CallableFunction) : void
    {
        this.addEvent('keypress', callback);
    }

    public on(ev: string, callback: CallableFunction) : void
    {
        let evs = ev.split(' ');
        if (evs.length > 1) {
            for (const e of evs) {
                this.addEvent(e, callback);
            }
        } else {
            this.addEvent(ev, callback);
        }
    }

    public val(value: any = null) : any
    {
        if (null === value) {
            return (<HTMLInputElement>this.el).value;
        }
        (<HTMLInputElement>this.el).value = value;
    }

    public parent() : El
    {
        return new El(this.el.parentElement);
    }

    public isActive() : boolean
    {
        return (document.activeElement === this.el);
    }

    private addEvent(event: string, callback: CallableFunction) : void
    {
        this.el.addEventListener(event, function (ev) {
            callback(ev);
        }, true)
    }
}

/**
 * factory to create El instance
 *
 * @param {*} cssSelector
 * @returns
 */
function $(cssSelector: any) {
    return (new El(cssSelector));
}