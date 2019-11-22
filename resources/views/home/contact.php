<section id='contact' class="skills bg-light text-dark text-center mt-3">
    <h2>
        <?=$this->__('home.title.contact')?>
        <hr class='mx-auto bg-dark pt-1 rounded w-25 px-5' />
    </h2>
    <h5 class="text-muted"><?=$this->__('home.sec.con.res')?></h5>
    <div class="text-left mt-5">
        <alert type='danger' v-if='mailErr'>
            <strong><?=$this->__('home.sec.con.err')?></strong>
        </alert>
        <alert type='success' v-if='false === mailErr'>
            <strong><?=$this->__('home.sec.con.success')?></strong>
        </alert>
        <form class="form needs-validation" ref='mailForm' method="post" novalidate>
            <div class="form-group row">
                <label for="userName" class="d-none d-sm-inline col-sm-2 col-form-label"><?=$this->__('home.sec.con.inp.name')?></label>
                <div class="col-sm-10">
                    <input type="text" v-model='name' class="form-control" :class="{'is-invalid': nameErr, 'is-valid': nameErr === false}" id="userName" placeholder="<?=$this->__('cpost.ph.enter') . $this->__('home.sec.con.inp.name')?>" minlength="3" maxlength="120" required />
                    <div class="invalid-feedback">
                        <?=$this->__('home.sec.con.vaild.name')?>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="userEmail" class="d-none d-sm-inline col-sm-2 col-form-label"><?=$this->__('home.sec.con.inp.email')?></label>
                <div class="col-sm-10">
                    <input type="email" v-model='email' class="form-control" :class="{'is-invalid': emailErr, 'is-valid': emailErr === false}" id="userEmail" placeholder="<?=$this->__('cpost.ph.enter') . $this->__('home.sec.con.inp.email')?>" minlength="5" required />
                    <div class="invalid-feedback">
                    <?=$this->__('home.sec.con.vaild.email')?>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="userMessage" class="d-none d-sm-inline col-sm-2 col-form-label"><?=$this->__('home.sec.con.inp.mess')?></label>
                <div class="col-sm-10">
                    <textarea v-model='message' class="form-control" :class="{'is-invalid': messErr, 'is-valid': messErr === false}" id="userMessage" placeholder="<?=$this->__('cpost.ph.enter') . $this->__('home.sec.con.inp.mess')?>" rows="6" minlength="5" required></textarea>
                    <div class="invalid-feedback">
                    <?=$this->__('home.sec.con.vaild.mess')?>
                    </div>
                </div>
            </div>
            <div class='form-group row'>
                <div class="col-sm-10 offset-sm-2">
                    <button type="submit" class="btn btn-outline-primary btn-block" @click.stop.prevent="sendMail">
                        <span ref='sendMailLoader' class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                        <?=$this->__('home.sec.con.btn')?>
                    </button>
                </div>
            </div>
        </form>
    </div>
</section>