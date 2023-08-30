<section class="about pt-100 pb-100" id="about">
    <div class="container">
        <div class="row g-4 g-xl-5 align-items-center">
            <div class="col-lg-5 order-lg-0 order-1">
                <div class="about-img">
                    <img src="{{@frontend_section_data($about->value,'banner_image')}}" alt="">
                </div>
            </div>

            <div class="col-lg-7 order-lg-1 order-0">
                <div class="section-title">
                    <span>Learn About Us</span>
                    <h2>{{@frontend_section_data($about->value,'primary_heading') }}</h2>
                </div>

                <div>
                    <div class="about-content">
                        <p>{{@frontend_section_data($about->value,'primary_short_description') }}
                        </p>
                    </div>
                    <a href="#" class="i-btn btn--primary btn--lg capsuled">Discover More</a>
                </div>
            </div>
        </div>

        <div class="row g-0 counter">
            <div class="col-lg-3 col-sm-6">
                <div class="counter-item">
                    <div class="counter-icon">
                        <i class="bi bi-kanban"></i>
                    </div>

                    <h4>40</h4>
                    <p>Project Completed</p>
                </div>
            </div>

            <div class="col-lg-3 col-sm-6">
                <div class="counter-item">
                    <div class="counter-icon">
                        <i class="bi bi-kanban"></i>
                    </div>

                    <h4>40</h4>
                    <p>Project Completed</p>
                </div>
            </div>

            <div class="col-lg-3 col-sm-6">
                <div class="counter-item">
                    <div class="counter-icon">
                        <i class="bi bi-kanban"></i>
                    </div>

                    <h4>40</h4>
                    <p>Project Completed</p>
                </div>
            </div>

            <div class="col-lg-3 col-sm-6">
                <div class="counter-item">
                    <div class="counter-icon">
                        <i class="bi bi-kanban"></i>
                    </div>

                    <h4>40</h4>
                    <p>Project Completed</p>
                </div>
            </div>
        </div>
    </div>
</section>
