<section id='skills' class="skills bg-light text-dark text-center mt-5 pt-3">
    <h2>
        <?= $this->__('home.title.skill') ?>
        <hr class='mx-auto bg-dark pt-1 rounded w-25 px-5' />
    </h2>
    <div class="row text-center">
        <div class="col-12 col-md-6 mt-3 mb-5">
            <img src="<?= $this->asset('/assets/img/meLarge.jpg') ?>" class="img w-75 p-1 border border-secondary rounded" />
            <p class="text-secondary mt-2 text-capitalize">
                <?= $this->__('home.sec.skill.info') ?>
                <a href='#projects' v-scroll-to="'#projects'" class='btn btn-outline-primary btn-sm'><?= $this->__('home.sec.skill.my') ?> <?= $this->__('home.title.project') ?></a>.
            </p>
            <a href='#contact' v-scroll-to="{el:'#contact', duration:2500}" class="btn btn-primary"><?=$this->__('home.sec.skill.hire')?></a>
        </div>
        <div class="col-12 col-md-6 mt-3">
            <div class=>
                <dync-progress :txt='"html"' :val='90'></dync-progress>
                <dync-progress :txt='"css"' :val='75'></dync-progress>
                <dync-progress :txt='"bootstrap"' :val='85'></dync-progress>
                <dync-progress :txt='"javascipt"' :val='80'></dync-progress>
                <dync-progress :txt='"jquery"' :val='85'></dync-progress>
                <dync-progress :txt='"vue"' :val='75'></dync-progress>
                <dync-progress :txt='"angular 2"' :val='70'></dync-progress>
                <dync-progress :txt='"php"' :val='90'></dync-progress>
                <dync-progress :txt='"php oop"' :val='85'></dync-progress>
                <dync-progress :txt='"python"' :val='60'></dync-progress>
                <dync-progress :txt='"mysql"' :val='85'></dync-progress>
                <dync-progress :txt='"laravel"' :val='85'></dync-progress>
                <dync-progress :txt='"lumen"' :val='80'></dync-progress>
                <dync-progress :txt='"unit_Testing"' :val='85'></dync-progress>
            </div>
        </div>
    </div>
</section>