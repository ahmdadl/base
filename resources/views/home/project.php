<section id='projects' class="skills bg-light text-dark text-center mt-3">
    <h2>
        Projects
        <hr class='mx-auto bg-light pt-1 rounded w-25 px-5' />
    </h2>
    <div class="text-center mt-5">
        <div class="row">
            <?php foreach ($projects as $p) : ?>
                <card :has-overlay='true' cls='project' img="<?= $this->asset('assets/img/' . $p->img) ?>" title="<?= $p->title ?>">
                    <template v-slot:overlay>
                        <h5 class="card-title">Client: <?= $p->client ?></h5>
                        <p class="card-text"><?= $p->info ?></p>
                    </template>
                    <template v-slot:tags>
                        <?php foreach ($p->tags as $tag) : ?>
                            <span class="badge badge-primary p-1 mx-2">
                                <?= $tag ?>
                            </span>
                        <?php endforeach ?>
                    </template>
                </card>
            <?php endforeach ?>
        </div>
    </div>
</section>