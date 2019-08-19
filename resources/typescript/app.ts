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


