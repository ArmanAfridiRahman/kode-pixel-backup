<section class="team dark-bg pt-100 pb-100 mt-50 mt-0">
    <div>
        <div class="container-fluid wrapper-fluid">
            <div class="row gy-5">
                <div class="col-lg-4">
                    <div class="section-title">
                                    <span>
                                        Our Teams
                                    </span>
                        <h2>{{@frontend_section_data($team_section->value,'primary_heading') }}</h2>
                    </div>

                    <p>{{@frontend_section_data($team_section->value,'primary_short_description') }}</p>
                </div>

                <div class="col-lg-8">
                    <div class="teams-slider-container">
                        <div class="teams-preview-next">
                            <div class="preview-next">
                                <button class="team-button-prev"><i class="bi bi-arrow-left"></i></button>
                                <button class="team-button-next"><i class="bi bi-arrow-right"></i></button>
                            </div>
                        </div>


                        <div class="swiper teams-slider">
                            <div class="swiper-wrapper">
                                @foreach($teams as $team)
                                <div class="swiper-slide">
                                    <div class="team-card">
                                        <div class="team-img">
                                            <img src="https://img.freepik.com/free-photo/business-concept-portrait-confident-young-businesswoman-keeping-arms-crossed-looking-camera-w_1258-104422.jpg?w=1380&t=st=1693046425~exp=1693047025~hmac=d85e7e52e226272afa5e8d7bcf97399667f7883bbbbf8386be7565c8c0e8b9a6"
                                                 alt="">
                                        </div>
                                        <div class="team-card-content">
                                            <h4>{{$team->name}}</h4>
                                            <p>{{$team->designation}}</p>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
