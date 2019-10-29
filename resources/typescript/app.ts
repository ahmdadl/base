declare var Toast: any;

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

$('#showPass').on('click', (ev) => {
    let self = $(ev.target);
    if (ev.target.className.indexOf('active') > -1) {
        self.removeClass('btn-danger');
        self.removeClass('active');
        $('.password').handleAll((el) => {
            $(el).attr('type', 'password');
        });
    } else {
        self.addClass('btn-danger');
        self.addClass('active');
        $('.password').handleAll((el) => {
            $(el).attr('type', 'text');
        });
    }
});

$('form.needs-validation').handleAll((el) => {
    $(el).on('submit', (ev) => {
        let self = ev.target;

        let isNotValid = (self.checkValidity() === false),
            passMatch = ($('#password').val() !== $('#confPassword').val());

        if (isNotValid || passMatch) {
            ev.preventDefault();
            ev.stopPropagation();
            if (passMatch) {
                $('#password').addClass('is-invalid');
                $('#confPassword').addClass('is-invalid');
            }
        }

        $('.submit').addClass('loading');
    
        $(self).addClass('was-validated');
    });
});

let toggleCurrent = (el: El, current: string) => {
    if (current === 'light') {
        el.attr('data-current', 'dark');
    } else {
        el.attr('data-current', 'light');
    }
};

$('#dark-mode').on('click', (ev) => {
    let self = $(ev.target);

    let current = self.attr('data-current');

    toggleCurrent(self, current);

    if (current === 'light') {
        $('.bg-light').handleAll(el => {
            let self = $(el);

            self.removeClass('bg-light');
            self.removeClass('text-dark');
            self.addClass('bg-dark');
            self.addClass('text-white');
        });
    } else {
        $('.bg-dark').handleAll(el => {
            let self = $(el);

            self.removeClass('bg-dark');
            self.removeClass('text-white');
            self.addClass('bg-light');
            self.addClass('text-dark');
        });
    }
});


