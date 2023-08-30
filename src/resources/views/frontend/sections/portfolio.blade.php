<section class="portfolio pt-100 pb-100" id="portfolio">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-7 col-sm-9">
                <div class="section-title">
                    <span>Recent work</span>
                    <h2>{{@frontend_section_data($portfolio->value,'primary_heading') }}</h2>
                </div>
            </div>
            <div class="col-lg-5 col-sm-3">
                <div class="section-title-right">
                    <div class="preview-next">
                        <button class="port-button-prev"><i class="bi bi-arrow-left"></i></button>
                        <button class="port-button-next"><i class="bi bi-arrow-right"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid wrapper-fluid">
        <div class="swiper portfolio-slider">
            <div class="swiper-wrapper">
                @foreach($portfolios as $portfolio)
                <div class="swiper-slide">
                    <div class="portfolio-card">
                        <div class="portfolio-img">
                            <img src="./assets/images/portfolio/home.png" alt="">
                        </div>
                        <div class="portfolio-content">
                            <a href="{{$portfolio->url}}" class="view-link-btn">
                                <svg xmlns="http://www.w3.org/2000/svg" version="1.1"
                                     xmlns:xlink="http://www.w3.org/1999/xlink"
                                     xmlns:svgjs="http://svgjs.com/svgjs" x="0" y="0" viewBox="0 0 512 512"
                                     style="enable-background:new 0 0 512 512" xml:space="preserve" class="">
                                                <g>
                                                    <path
                                                        d="M512 21.805v331.202c0 12.042-9.763 21.805-21.805 21.805s-21.805-9.763-21.805-21.805V74.451L37.225 505.615c-4.259 4.257-9.838 6.386-15.419 6.386s-11.16-2.129-15.419-6.386c-8.516-8.516-8.516-22.323 0-30.839L437.553 43.61h-278.56c-12.042 0-21.805-9.763-21.805-21.805S146.951 0 158.993 0h331.202C502.237-.001 512 9.763 512 21.805z"
                                                        data-original="#000000" class=""></path>
                                                </g>
                                            </svg>
                            </a>
                            <h4>
                                {{$portfolio->title}}
                            </h4>
                            <p>
                                {{$portfolio->short_description}}
                            </p>
                            <a href="{{$portfolio->url}}" class="i-btn btn--primary-outline btn--md capsuled">Purchase Now</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

</section>
