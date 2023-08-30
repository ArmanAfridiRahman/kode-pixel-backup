<section class="services pt-100 pb-100" id="service">
    <div class="container">
        <div class="row">
            <div class="col-xl-8 mx-auto">
                <div class="section-title text-center">
                    <span>Services</span>
                    <h2>{{@frontend_section_data($service->value,'                                                                                                                                                                                                                                                                                                                                            ') }}
                    </h2>
                </div>
            </div>
        </div>

        <div class="row g-5 align-items-center">
            <div class="col-xl-5 col-lg-6">
                @foreach($services as $service)
                <div class="service-item">
                    <div class="service-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="512" height="512" x="0"
                             y="0" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512"
                             xml:space="preserve" class="">
                                        <g>
                                            <g data-name="OUTLINE">
                                                <path
                                                    d="M472 16H40a24.027 24.027 0 0 0-24 24v352a24.027 24.027 0 0 0 24 24h165.248l-19.2 64H160v16h192v-16h-26.048l-19.2-64H472a24.027 24.027 0 0 0 24-24V40a24.027 24.027 0 0 0-24-24zM309.248 480H202.752l19.2-64h68.096zM480 392a8.01 8.01 0 0 1-8 8H40a8.01 8.01 0 0 1-8-8v-24h448zm0-40H32V40a8.01 8.01 0 0 1 8-8h432a8.01 8.01 0 0 1 8 8z"
                                                    data-original="#000000" class=""></path>
                                                <path
                                                    d="M440 152H334.627a7.947 7.947 0 0 1-5.657-2.344l-22.627-22.627a23.843 23.843 0 0 0-16.97-7.029H200a24.027 24.027 0 0 0-24 24v168a24.027 24.027 0 0 0 24 24h240a24.027 24.027 0 0 0 24-24V176a24.027 24.027 0 0 0-24-24zm8 160a8.01 8.01 0 0 1-8 8H200a8.01 8.01 0 0 1-8-8V144a8.01 8.01 0 0 1 8-8h89.373a7.947 7.947 0 0 1 5.657 2.344l22.627 22.627a23.843 23.843 0 0 0 16.97 7.029H440a8.01 8.01 0 0 1 8 8z"
                                                    data-original="#000000" class=""></path>
                                                <path
                                                    d="M266.343 194.343 220.687 240l45.656 45.657 11.314-11.314L243.313 240l34.344-34.343zM297.076 276.257l40.03-71.987 13.983 7.775-40.03 71.987zM362.343 205.657 396.687 240l-34.344 34.343 11.314 11.314L419.313 240l-45.656-45.657zM202.794 64l12.955 30.219 28.57 11.838 30.579-12.219 15.819 15.819 11.313-11.314-23.275-23.277-34.326 13.717-16.54-6.853L213.343 48h-42.686l-14.545 33.93-16.541 6.853-34.325-13.717-30.179 30.18 13.716 34.325-6.853 16.54L48 170.657v42.686l33.929 14.546 6.854 16.54-13.717 34.325 30.179 30.18 34.326-13.717 17.366 7.196 6.126-14.781-23.382-9.689-30.579 12.219-15.264-15.264 12.219-30.579-11.839-28.571L64 202.794v-21.588l30.219-12.954 11.838-28.571-12.219-30.579 15.265-15.264 30.578 12.219 28.57-11.838L181.206 64z"
                                                    data-original="#000000" class=""></path>
                                                <path
                                                    d="m163.56 134.648-7.12-14.328a80.028 80.028 0 0 0 0 143.36l7.12-14.328a64.029 64.029 0 0 1 0-114.704z"
                                                    data-original="#000000" class=""></path>
                                            </g>
                                        </g>
                                    </svg>
                    </div>
                    <div class="service-right">
                        <div class="service-content">                                               
                            <h4>
                               {{$service->title}}
                            </h4>
                            <p>{{$service->short_description}}</p>

                        </div>

                        <div>
                            <span class="arrow">
                                <svg xmlns="http://www.w3.org/2000/svg" version="1.1" x="0" y="0"
                                        viewBox="0 0 512 512" style="enable-background:new 0 0 512 512"
                                        xml:space="preserve" class="">
                                    <g>
                                        <path
                                            d="M512 21.805v331.202c0 12.042-9.763 21.805-21.805 21.805s-21.805-9.763-21.805-21.805V74.451L37.225 505.615c-4.259 4.257-9.838 6.386-15.419 6.386s-11.16-2.129-15.419-6.386c-8.516-8.516-8.516-22.323 0-30.839L437.553 43.61h-278.56c-12.042 0-21.805-9.763-21.805-21.805S146.951 0 158.993 0h331.202C502.237-.001 512 9.763 512 21.805z"
                                            data-original="#000000" class=""></path>
                                    </g>
                                </svg>
                            </span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="col-xl-7 col-lg-6">
                <div class="service-details ms-0 ms-lg-5">
                    <div class="service-img">
                        <img src="https://img.freepik.com/free-photo/top-view-unrecognizable-hacker-performing-cyberattack-night_1098-18706.jpg?w=740&t=st=1693200458~exp=1693201058~hmac=0c065d7e85c53486867f81719a9c18c8f376da9eadae7611b51aec66019a7203"
                             alt="">
                    </div>
                    <div class="service-detail-content">
                        <h4>Web application Development</h4>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Fugiat porro ipsum
                            pariatur reprehenderit ducimus, omnis eveniet neque accusamus sint sapiente.</p>

                        <ul>
                            <li>
                                <p><i class="bi bi-check2"></i>
                                    Enterprise Solution
                                </p>
                            </li>
                            <li>
                                <p><i class="bi bi-check2"></i>
                                    E-commerce Solution
                                </p>
                            </li>

                            <li>
                                <p><i class="bi bi-check2"></i>
                                    API & Backend
                                </p>
                            </li>
                            <li>
                                <p><i class="bi bi-check2"></i>
                                    Custom Development
                                </p>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
