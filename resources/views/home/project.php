<section id='projects' class="skills bg-light text-dark text-center mt-3">
    <h2>
        Projects
        <hr class='mx-auto bg-light pt-1 rounded w-25 px-5' />
    </h2>
    <div class="text-center mt-5">
        <div class="row">
            <?php foreach ($projects as $p) : ?>
                <div class='col-12 col-md-6 col-lg-4 mb-3 px-sm-5 px-md-2'>
                    <div class="project card bg-light text-white shadow border border-dark">
                        <div class='card-body position-relative p-0'>
                            <img src="<?= $this->asset('assets/img/' . $p->img) ?>" class="card-img" alt="title">
                            <div ref='cardOverlay' class="card-img-overlay">
                                <h5 class="card-title">Client: <?= $p->client ?></h5>
                                <p class="card-text"><?= $p->info ?></p>
                            </div>
                        </div>
                        <div class="card-footer text-dark">
                            <h5 class="card-title"><?= $p->title ?></h5>
                            <div class="tags d-block text-capitalize">
                                <?php foreach ($p->tags as $tag) : ?>
                                    <span class="badge badge-primary p-1 mx-2">
                                        <?= $tag ?>
                                    </span>
                                <?php endforeach ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach ?>
        </div>
    </div>
</section>