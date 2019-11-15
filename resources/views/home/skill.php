<section id='skills' class="skills bg-light text-dark text-center mt-3">
    <h2>
        Skills
        <hr class='mx-auto bg-dark pt-1 rounded w-25 px-5' />
    </h2>
    <div class="row text-center">
        <div class="col-12 col-md-6">
            <img src="<?= $this->asset('/assets/img/user.png') ?>" class="img w-75 p-1 border border-secondary rounded" />
            <p class="text-secondary mt-2 text-capitalize">
                I'm a full-stack developer specialised in frontend and backend development for complex scalable web apps. I write about web development on my blog and regularly speak at various web conferences and meetups. Want to know how I may help your project? Check out my project case studies and resume.
            </p>
            <a href='#contact' v-scroll-to="{el:'#contact', duration:2500}" class="btn btn-primary">Hire Me</a>
        </div>
        <div class="col-12 col-md-6">
            <div class="mt-5">
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