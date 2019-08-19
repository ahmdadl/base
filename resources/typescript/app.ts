declare var Toast: any;
// declare var fetch: any;

let y = new Toast('#toast1', {
    autohide: false,
    animation: true
});
y.show();
let x = new Toast('#toast2', {
    autohide: false,
    animation: true
});
x.show();
setTimeout(_ => {x.hide()}, 2500);

console.log('no working yet');

class App
{
    constructor() {}

    public run() : void
    {
        $('button').on('click', (ev) => {
            console.log(ev, ev.target.id);
        });
        
    }
}
(new App()).run();



