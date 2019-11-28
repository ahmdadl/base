<div class='m-4'>
    <fieldset>
        <legend>Comments</legend>
        <alert type='danger' v-if='h.d.commErr'>
            <strong><?= $this->__('home.sec.con.err') ?></strong>
        </alert>
        <alert type='success' v-if='false === h.d.commErr'>
            <strong><?= $this->__('home.sec.con.success') ?></strong>
        </alert>
        <form method="post" class="form needs-validation" novalidate @submit.prevent.stop="h.d.commentSend">
            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="name">Name</label>
                <input type="text" class="form-control col-sm-10" id="name" placeholder="Enter Your Name" v-model.trim='h.d.name' :class="{'is-invalid': h.d.nameErr, 'is-valid': h.d.nameErr === false}" @keypress="h.d.validateName" minlength="5" maxlength="255" required>
                <div class="invalid-feedback">
                    Please provide a valid name.
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="email">Email</label>
                <input type="email" class="form-control col-sm-10" id="email" placeholder="Enter Your Email" v-model.trim='h.d.email' :class="{'is-invalid': h.d.emailErr, 'is-valid': h.d.emailErr === false}"  @keypress='h.d.validateEmailInput' id="userEmail" minlength="5" required>
                <div class="invalid-feedback">
                    Please provide a valid email.
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="cmessage">Message</label>
                <textarea class="form-control col-sm-10" id="cmessage" rows="6" placeholder="enter your comment" v-model.trim='h.d.message' :class="{'is-invalid': h.d.messErr, 'is-valid': h.d.messErr === false}" minlength="10" required></textarea>
                <div class="invalid-feedback">
                    Please provide a valid message.
                </div>
            </div>
            <button type="submit" class="btn btn-primary btn-block">
                Comment
                <span v-if='h.d.commenting' class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            </button>
        </form>
    </fieldset>
</div>