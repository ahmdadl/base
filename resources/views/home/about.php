<section id='about' class='about bg-light text-dark text-center mt-5 pt-2'>
    <h2>
        About
        <hr class='mx-auto bg-dark pt-1 rounded w-25 px-5' />
    </h2>
    <div class="row">
        <?php foreach ($pros as $p) : ?>
            <div class="pros col-6 col-md-4 shadow mt-4">
                <div class="content p-1">
                    <div class="fa-3x d-inline-block bg-primary p-2 text-light w-25 h-25 mx-auto hexagon hexagon1">
                        <i class="fas fa-<?= $p->icon ?>"></i>
                    </div>
                    <h3 class="d-block mt-3"><?= $p->title ?></h3>
                    <span class="text-muted"><?= $p->txt ?></span>
                </div>
            </div>
        <?php endforeach ?>
    </div>
</section>