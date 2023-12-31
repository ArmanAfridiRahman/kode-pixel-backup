<section class="contact dark-bg pt-100 pb-100" id="contact">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-6">
                <div class="section-title">
                                <span>
                                    Get in touch
                                </span>
                    <h2>{{@frontend_section_data($contactUs_section->value,'primary_heading')}}</h2>
                </div>

                <div class="contact-content">
                    <p>{{@frontend_section_data($contactUs_section->value,'primary_short_description') }}</p>

                    <div class="contact-info-item">
                        <div class="contact-info">
                            <div class="contact-info-icon">
                                            <span class="phone-icon">
                                                <svg viewBox="0 0 29 48" xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M4.8 48H24C25.2726 47.9987 26.4928 47.4926 27.3927 46.5927C28.2926 45.6928 28.7987 44.4726 28.8 43.2C28.8 42.9878 28.7157 42.7843 28.5657 42.6343C28.4157 42.4843 28.2122 42.4 28 42.4C27.7878 42.4 27.5843 42.4843 27.4343 42.6343C27.2843 42.7843 27.2 42.9878 27.2 43.2C27.2 44.0487 26.8629 44.8626 26.2627 45.4627C25.6626 46.0629 24.8487 46.4 24 46.4H4.8C3.95131 46.4 3.13737 46.0629 2.53726 45.4627C1.93714 44.8626 1.6 44.0487 1.6 43.2V4.8C1.6 3.95131 1.93714 3.13737 2.53726 2.53726C3.13737 1.93714 3.95131 1.6 4.8 1.6H5.1056L6.8424 5.0736C7.04049 5.47317 7.34659 5.80923 7.72597 6.04367C8.10534 6.27811 8.54283 6.40156 8.9888 6.4H19.8112C20.2572 6.40156 20.6947 6.27811 21.074 6.04367C21.4534 5.80923 21.7595 5.47317 21.9576 5.0736L23.6944 1.6H24C24.8487 1.6 25.6626 1.93714 26.2627 2.53726C26.8629 3.13737 27.2 3.95131 27.2 4.8V6.4C27.2 6.61217 27.2843 6.81566 27.4343 6.96569C27.5843 7.11571 27.7878 7.2 28 7.2C28.2122 7.2 28.4157 7.11571 28.5657 6.96569C28.7157 6.81566 28.8 6.61217 28.8 6.4V4.8C28.7987 3.52735 28.2926 2.30719 27.3927 1.40729C26.4928 0.507392 25.2726 0.00127074 24 0L4.8 0C3.52735 0.00127074 2.30719 0.507392 1.40729 1.40729C0.507392 2.30719 0.00127074 3.52735 0 4.8L0 43.2C0.00127074 44.4726 0.507392 45.6928 1.40729 46.5927C2.30719 47.4926 3.52735 47.9987 4.8 48ZM20.5264 4.3576C20.4605 4.49082 20.3585 4.60288 20.2321 4.68108C20.1057 4.75928 19.9598 4.80048 19.8112 4.8H8.9888C8.84015 4.80048 8.69435 4.75928 8.56793 4.68108C8.44152 4.60288 8.33955 4.49082 8.2736 4.3576L6.8944 1.6H21.9056L20.5264 4.3576Z">
                                                    </path>
                                                </svg>
                                            </span>
                                <span class="icon-middle">
                                                <svg width="20" height="20" viewBox="0 0 20 20"
                                                     xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M17.1173 11.6269C16.5725 11.1057 15.8481 10.8148 15.0947 10.8148C14.3413 10.8148 13.6168 11.1057 13.072 11.6269L11.6565 13.0449C11.6277 13.0762 11.5889 13.0965 11.5469 13.1024C11.5048 13.1082 11.462 13.0993 11.4258 13.0771C9.68378 11.8305 8.15956 10.304 6.91482 8.55921C6.89403 8.52382 6.88582 8.48241 6.89152 8.44175C6.89723 8.40109 6.91652 8.36356 6.94625 8.33528L8.36538 6.91373C8.90079 6.37583 9.20144 5.64723 9.20144 4.88765C9.20144 4.12806 8.90079 3.39947 8.36538 2.86156L6.31988 0.811157C5.77519 0.290495 5.05121 0 4.29831 0C3.5454 0 2.82143 0.290495 2.27673 0.811157C0.319789 2.77142 -0.437274 5.8363 0.24694 9.01279C0.708321 11.139 1.86606 13.0843 3.90085 15.1454C4.54364 15.7657 4.41937 15.6534 4.86146 16.1077C6.90768 18.1352 8.85034 19.2949 10.9758 19.7563C13.9041 20.3852 17.0609 19.8279 19.1607 17.7224C19.4267 17.4565 19.6378 17.1407 19.7818 16.7931C19.9259 16.4454 20 16.0727 20 15.6963C20 15.3199 19.9259 14.9472 19.7818 14.5995C19.6378 14.2518 19.4267 13.936 19.1607 13.6702L17.1173 11.6269ZM18.1522 16.715C17.5019 17.342 16.7312 17.8301 15.8869 18.1499C15.0426 18.4696 14.1423 18.6143 13.2406 18.5752C10.2409 18.5752 7.99257 17.1994 5.87564 15.1025C5.14715 14.3491 5.18 14.3999 4.90574 14.1317C3.31622 12.6806 2.18303 10.7972 1.64465 8.71159C1.06186 6.01373 1.67608 3.43963 3.28734 1.82491C3.42007 1.69134 3.57783 1.58535 3.75157 1.51303C3.9253 1.4407 4.11159 1.40347 4.29974 1.40347C4.48788 1.40347 4.67417 1.4407 4.8479 1.51303C5.02164 1.58535 5.1794 1.69134 5.31213 1.82491L7.35835 3.87174C7.4918 4.00471 7.5977 4.16278 7.66997 4.33688C7.74223 4.51098 7.77943 4.69767 7.77943 4.88622C7.77943 5.07476 7.74223 5.26145 7.66997 5.43555C7.5977 5.60965 7.4918 5.76772 7.35835 5.90069L5.92992 7.32581C5.65895 7.5942 5.49257 7.9507 5.46075 8.33108C5.42894 8.71147 5.53377 9.09073 5.75637 9.40055C7.08979 11.2676 8.72096 12.902 10.5844 14.2382C10.8944 14.4623 11.2741 14.5677 11.6549 14.5356C12.0358 14.5034 12.3925 14.3358 12.6607 14.063L14.0819 12.6371C14.3507 12.3684 14.7149 12.2174 15.0947 12.2174C15.4744 12.2174 15.8387 12.3684 16.1074 12.6371L18.1508 14.684C18.2847 14.8169 18.391 14.975 18.4635 15.1492C18.5361 15.3235 18.5735 15.5104 18.5737 15.6992C18.5738 15.888 18.5366 16.075 18.4643 16.2493C18.392 16.4237 18.2859 16.582 18.1522 16.715Z">
                                                    </path>
                                                </svg>
                                            </span>
                            </div>
                            <div class="contact-info-content">
                                <span>Call Us</span>
                                <h6><a href="tel:{{@frontend_section_data($contactUs_section->value,'phone_number')}}">{{@frontend_section_data($contactUs_section->value,'phone_number')}}</a></h6>
                            </div>
                        </div>

                        <div class="contact-info">
                            <div class="contact-info-icon">
                                            <span class="phone-icon">
                                                <svg viewBox="0 0 29 48" xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M4.8 48H24C25.2726 47.9987 26.4928 47.4926 27.3927 46.5927C28.2926 45.6928 28.7987 44.4726 28.8 43.2C28.8 42.9878 28.7157 42.7843 28.5657 42.6343C28.4157 42.4843 28.2122 42.4 28 42.4C27.7878 42.4 27.5843 42.4843 27.4343 42.6343C27.2843 42.7843 27.2 42.9878 27.2 43.2C27.2 44.0487 26.8629 44.8626 26.2627 45.4627C25.6626 46.0629 24.8487 46.4 24 46.4H4.8C3.95131 46.4 3.13737 46.0629 2.53726 45.4627C1.93714 44.8626 1.6 44.0487 1.6 43.2V4.8C1.6 3.95131 1.93714 3.13737 2.53726 2.53726C3.13737 1.93714 3.95131 1.6 4.8 1.6H5.1056L6.8424 5.0736C7.04049 5.47317 7.34659 5.80923 7.72597 6.04367C8.10534 6.27811 8.54283 6.40156 8.9888 6.4H19.8112C20.2572 6.40156 20.6947 6.27811 21.074 6.04367C21.4534 5.80923 21.7595 5.47317 21.9576 5.0736L23.6944 1.6H24C24.8487 1.6 25.6626 1.93714 26.2627 2.53726C26.8629 3.13737 27.2 3.95131 27.2 4.8V6.4C27.2 6.61217 27.2843 6.81566 27.4343 6.96569C27.5843 7.11571 27.7878 7.2 28 7.2C28.2122 7.2 28.4157 7.11571 28.5657 6.96569C28.7157 6.81566 28.8 6.61217 28.8 6.4V4.8C28.7987 3.52735 28.2926 2.30719 27.3927 1.40729C26.4928 0.507392 25.2726 0.00127074 24 0L4.8 0C3.52735 0.00127074 2.30719 0.507392 1.40729 1.40729C0.507392 2.30719 0.00127074 3.52735 0 4.8L0 43.2C0.00127074 44.4726 0.507392 45.6928 1.40729 46.5927C2.30719 47.4926 3.52735 47.9987 4.8 48ZM20.5264 4.3576C20.4605 4.49082 20.3585 4.60288 20.2321 4.68108C20.1057 4.75928 19.9598 4.80048 19.8112 4.8H8.9888C8.84015 4.80048 8.69435 4.75928 8.56793 4.68108C8.44152 4.60288 8.33955 4.49082 8.2736 4.3576L6.8944 1.6H21.9056L20.5264 4.3576Z">
                                                    </path>
                                                </svg>
                                            </span>
                                <span class="icon-middle">
                                                <svg viewBox="0 0 18 14" xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M17.9106 0.827294C17.7154 0.32616 17.2273 -0.00317646 16.6847 2.31069e-05H1.31529C0.772686 -0.00317646 0.284644 0.32616 0.0893571 0.827294C0.0368849 0.965948 0.00925575 1.1126 0.00771373 1.26066C0.00771373 1.27402 0 1.28548 0 1.29884V12.7273C0 13.4302 0.575634 14 1.28571 14H16.7143C17.4244 14 18 13.4302 18 12.7273V1.2982C18 1.28484 17.9929 1.27338 17.9923 1.26002C17.9907 1.11218 17.963 0.965747 17.9106 0.827294ZM16.7143 1.29248C16.7143 1.29248 16.7143 1.29566 16.7059 1.30138L8.9775 8.26446L1.31529 1.27275L16.7143 1.29248ZM1.28571 12.7273V3.02084L8.10964 9.2031C8.6152 9.65563 9.3848 9.65563 9.89036 9.2031L16.7143 3.02084V12.7273H1.28571Z">
                                                    </path>
                                                </svg>
                                            </span>
                            </div>
                            <div class="contact-info-content">
                                <span>Mail Us</span>
                                <h6><a href="mailto:{{@frontend_section_data($contactUs_section->value,'email')}}">{{@frontend_section_data($contactUs_section->value,'email')}}</a></h6>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="col-lg-6">
                <form action="#">
                    <div class="row g-4 mb-5">
                        <div class="col-md-6">
                            <input type="text" class="form-control" placeholder="Name">
                        </div>
                        <div class="col-md-6">
                            <input type="email" class="form-control" placeholder="Email">
                        </div>
                        <div class="col-12">
                            <input type="text" class="form-control" placeholder="subject">
                        </div>
                        <div class="col-12">
                                        <textarea class="form-control" placeholder="Your Message" name="" id=""
                                                  cols="30" rows="10"></textarea>
                        </div>
                    </div>
                    <button type="submit" class="i-btn btn--primary btn--lg capsuled">Let's
                        Talk</button>
                </form>
            </div>
        </div>
    </div>
</section>
