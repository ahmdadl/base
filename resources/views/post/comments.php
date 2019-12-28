<div class='m-4'>
    <fieldset class="card bg-light text-dark my-4">
        <h5 class="card-header bg-primary text-light"><?= $this->__('shpost.c.title') ?>:</h5>
        <div class="card-body">
            <alert type='danger' v-if='h.d.commErr'>
                <strong><?= $this->__('home.sec.con.err') ?></strong>
            </alert>
            <alert type='success' v-if='false === h.d.commErr'>
                <strong><?= $this->__('shpost.c.success') ?></strong>
            </alert>
            <form method="post" class="form needs-validation" novalidate @submit.prevent.stop="h.d.commentSend">
                <?= $this->csrf() ?>
                <?= $this->_method('post') ?>
                <input type='hidden' ref='postID' value="<?= $pid ?>" />
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" for="name"><?= $this->__('home.sec.con.inp.name') ?></label>
                    <input type="text" class="form-control bg-light text-dark col-sm-10" id="name" placeholder="<?= $this->__('cpost.ph.enter') . $this->__('home.sec.con.inp.name') ?>" v-model.trim='h.d.name' :class="{'is-invalid': h.d.nameErr, 'is-valid': h.d.nameErr === false}" @keypress="h.d.validateName" minlength="5" maxlength="255" required>
                    <div class="col-sm-10 offset-sm-2 invalid-feedback">
                        <?= $this->__('home.sec.con.vaild.name') ?>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" for="email"><?= $this->__('home.sec.con.inp.email') ?></label>
                    <input type="email" class="form-control bg-light text-dark col-sm-10" id="email" placeholder="<?= $this->__('cpost.ph.enter') . $this->__('home.sec.con.inp.email') ?>" v-model.trim='h.d.email' :class="{'is-invalid': h.d.emailErr, 'is-valid': h.d.emailErr === false}" @keypress='h.d.validateEmailInput' id="userEmail" minlength="5" required>
                    <div class="col-sm-10 offset-sm-2 invalid-feedback">
                        <?= $this->__('home.sec.con.vaild.email') ?>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" for="cmessage"><?= $this->__('home.sec.con.inp.mess') ?></label>
                    <textarea class="form-control bg-light text-dark col-sm-10" id="cmessage" rows="7" placeholder="<?= $this->__('cpost.ph.enter') . $this->__('home.sec.con.inp.mess') ?>" v-model.trim='h.d.message' :class="{'is-invalid': h.d.messErr, 'is-valid': h.d.messErr === false}" minlength="10" required></textarea>
                    <div class="col-sm-10 offset-sm-2 invalid-feedback">
                        <?= $this->__('home.sec.con.vaild.mess') ?>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary btn-block">
                    <span v-if='h.d.commenting' class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    <?= $this->__('shpost.c.btn') ?>
                </button>
            </form>
        </div>
    </fieldset>
</div>

<div class="m-3">
    <div class="text-center" v-if='h.d.loading'>
        <div class="spinner-border text-primary" style="width: 4rem; height: 4rem;" role="status">
            <div class="spinner-grow text-primary" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
    </div>

    <ul class="list-unstyled">
        <li class="media mt-4 transition" v-for='(c, inx) in h.d.allComments' :key="c.id" :id="'d' + c.id" :class="{'animated': undefined !== c.fresh}">
            <img :src="c.email" class="mr-3" :alt="c.name">
            <div class="media-body">
                <p class="mt-0 mb-1">
                    <?php if ($session->has('admin')) : ?>
                        <button class="btn btn-danger btn-sm py-1 float-right" @click.stop.prevent="h.d.deleteComment(c.id, inx)">
                            <span :ref="'commentDanger' + c.id" class="spinner-border spinner-border-sm mr-2 d-none" role="status" aria-hidden="true"></span>
                            X
                        </button>
                    <?php endif ?>
                    <h5 class="mb-0">{{c.name}}</h5>
                    <span class="text-muted" dir='ltr'>
                        <i class="fas fa-clock"></i>
                        {{c.created_at}}
                    </span>
                </p>
                {{c.body}}
            </div>
        </li>
    </ul>

</div>