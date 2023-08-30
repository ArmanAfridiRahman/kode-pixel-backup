<section class="processing dark-bg pt-100 pb-100 mt-50 mt-0">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="section-title text-center">
                                <span>
                                    Our Working Process
                                </span>
                    <h2>{{@frontend_section_data($process->value,'primary_heading') }}</h2>
                </div>
            </div>
        </div>
        
        <div class="row g-4">
            @foreach($processes as $process)
            <div class="col-lg-4 col-md-6">
                <div class="processing-card">
                    <div class="processing-icon">
                        <i class="{{$process->icon}}"></i>
                    </div>
                    <div class="processing-content">
                        <h4>{{$process->title}}</h4>
                        <p>
                            {{$process->short_description}}
                        </p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
