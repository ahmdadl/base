<section id='contact' class="skills bg-light text-dark text-center mt-3">
    <h2>
        Contact
        <hr class='mx-auto bg-dark pt-1 rounded w-25 px-5' />
    </h2>
    <h4 class="text-muted">I Will Respond Withen 24 Hours</h4>
    <div class="text-left mt-5">
        <alert type='danger' v-if='mailErr'>
            <strong>an error occured</strong>
        </alert>
        <alert type='success' v-if='false === mailErr'>
            <strong>Email Sent Succefully</strong>
        </alert>
        <form class="form needs-validation" ref='mailForm' method="post" novalidate>
            <div class="form-group row">
                <label for="userName" class="d-none d-sm-inline col-sm-2 col-form-label">Name</label>
                <div class="col-sm-10">
                    <input type="text" v-model='name' class="form-control" :class="{'is-invalid': nameErr, 'is-valid': nameErr === false}" id="userName" placeholder="Name" minlength="3" maxlength="120" required />
                    <div class="invalid-feedback">
                        The Name must be less than 120 characters.
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="userEmail" class="d-none d-sm-inline col-sm-2 col-form-label">Email</label>
                <div class="col-sm-10">
                    <input type="email" v-model='email' class="form-control" :class="{'is-invalid': emailErr, 'is-valid': emailErr === false}" id="userEmail" placeholder="Email" minlength="5" required />
                    <div class="invalid-feedback">
                        Please enter a valid email
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="userMessage" class="d-none d-sm-inline col-sm-2 col-form-label">Message</label>
                <div class="col-sm-10">
                    <textarea v-model='message' class="form-control" :class="{'is-invalid': messErr, 'is-valid': messErr === false}" id="userMessage" placeholder="Enter your message" rows="6" minlength="5" required></textarea>
                    <div class="invalid-feedback">
                        Please enter your message
                    </div>
                </div>
            </div>
            <div class='form-group row'>
                <div class="col-sm-10 offset-sm-2">
                    <button type="submit" class="btn btn-outline-primary btn-block" @click.stop.prevent="sendMail">
                        <span ref='sendMailLoader' class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                        Send
                    </button>
                </div>
            </div>
        </form>
    </div>
</section>