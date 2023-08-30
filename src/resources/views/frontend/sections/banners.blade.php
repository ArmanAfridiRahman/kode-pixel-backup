<section class="banner" id="banner">
    <div class="container">
        <div class="banner-container">
            <div class="row g-5 align-items-center">
                <div class="col-lg-7">
                    <div class="banner-content">
                        <h1 class="text-black">{{@frontend_section_data($banner->value,'primary_heading') }}</h1>
                        <p class="text-black">{{@frontend_section_data($banner->value,'primary_short_description')}}
                        </p>

                        <div class="authors-wrapper">
                            <h5>{{@frontend_section_data($banner->value,'secondary_heading')}}</h5>
                            <p>{{@frontend_section_data($banner->value,'secondary_short_description')}}</p>

                            <div class="authors">
                                <div class="swiper author-slider">
                                    <div class="swiper-wrapper">
                                        <div class="swiper-slide">
                                            <div>
                                                <img src="./assets/images/author/envato.png" alt="">
                                            </div>
                                        </div>

                                        <div class="swiper-slide">
                                            <div>
                                                <img src="./assets/images/author/codecanyon.png" alt="">
                                            </div>
                                        </div>

                                        <div class="swiper-slide">
                                            <div>
                                                <img src="./assets/images/author/envato.png" alt="">
                                            </div>
                                        </div>

                                        <div class="swiper-slide">
                                            <div>
                                                <img src="./assets/images/author/codecanyon.png" alt="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-5">
                    <div class="banner-right">
                        <div class="banner-img">
                            <img src="{{@frontend_section_data($banner->value,'banner_image')}}" alt="">
                        </div>

                        <div class="circle-container">
                            <div class="circleButton">
                                <svg class="textcircle" viewBox="0 0 500 500">
                                    <defs>
                                        <path id="textcircle"
                                              d="M250,400 a150,150 0 0,1 0,-300a150,150 0 0,1 0,300Z">
                                        </path>
                                    </defs>
                                    <text>
                                        <textPath xlink:href="#textcircle" textLength="900">Explore More
                                            -
                                            Explore More -</textPath>
                                    </text>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="social-media d-md-flex d-none">
        <span>Follow Us - </span>
        <ul>
            <li><a href="#">Fb.</a></li>
            <li><a href="#">Be.</a></li>
            <li><a href="#">Lk.</a></li>
        </ul>
    </div>
</section>
