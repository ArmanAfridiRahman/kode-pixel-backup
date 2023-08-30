<header class="header">
    <div class="container-fluid">
        <div class="header-container">
            <div class="header-logo">
                <a href="index.html">
                    <img src="{{ imageUrl(config("settings")['file_path']['user_site_logo']['path']."/".@site_logo('user_site_logo')->file->name ,@site_logo('user_site_logo')->file->disk) }}" alt="{{@site_logo('user_site_logo')->file->name}}" />
                </a>
            </div>

            <div class="nav-right d-flex jsutify-content-end align-items-center gap-5">
                <div class="main-nav">
                    <div class="mobile-logo-area d-lg-none d-flex justify-content-between align-items-center">
                        <div class="mobile-logo-wrap ">
                            <a href="index.html">
                                <img src="{{ imageUrl(config("settings")['file_path']['user_site_logo']['path']."/".@site_logo('user_site_logo')->file->name ,@site_logo('user_site_logo')->file->disk) }}" alt="{{@site_logo('user_site_logo')->file->name}}" />
                            </a>
                        </div>
                        <div class="menu-close-btn">
                            <i class="bi bi-x-lg text-dark"></i>
                        </div>
                    </div>
                    <ul class="menu-list">
                        <li class>
                            <a href="#banner" class="drop-down">Home</a>
                        </li>

                        <li class>
                            <a href="#portfolio" class="drop-down">Portfolio</a>
                        </li>

                        <li class>
                            <a href="#service" class="drop-down">Service</a>
                        </li>

                        <li class>
                            <a href="#about">About</a>
                        </li>

                        <li><a href="#contact">Contact</a></li>
                    </ul>
                    <!-- mobile-search-area -->
                    <div class="d-lg-none d-flex">
                        <a href="#" class="i-btn btn--primary-outline btn--lg capsuled">Get Support</a>
                        </a>
                    </div>
                </div>

                <div>
                    <div class="d-lg-block d-none">
                        <a href="#" class="i-btn btn--primary-outline btn--lg capsuled">
                            Get Support
                        </a>
                    </div>

                    <div class="mobile-menu-btn d-lg-none d-block">
                        <i class="bi bi-list"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
