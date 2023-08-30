@extends('layouts.master')
@section('content')


    @php
        $banner_section = frontend_section()->where("slug",'banner_section')->first();
        $about_section = frontend_section()->where("slug",'about_section')->first();
        $service_section = frontend_section()->where("slug",'service_section')->first();
        $portfolio_section = frontend_section()->where("slug",'portfolio_section')->first();
        $process_section = frontend_section()->where("slug",'process_section')->first();
        $product_section = frontend_section()->where("slug",'product_section')->first();
        $support_section = frontend_section()->where("slug",'support_section')->first();
        $team_section = frontend_section()->where("slug",'team_section')->first();
        $contactUs_section = frontend_section()->where("slug",'contactUs_section')->first();

    @endphp

    @includeWhen($banner_section->status == App\Enums\StatusEnum::true->status(),'frontend.sections.banners',['banner' => $banner_section])

    @includeWhen($about_section->status == App\Enums\StatusEnum::true->status(),'frontend.sections.about',['about' => $about_section])

    @includeWhen($service_section->status == App\Enums\StatusEnum::true->status(), 'frontend.sections.service',['service' => $service_section])

    @includeWhen($portfolio_section->status == App\Enums\StatusEnum::true->status(),'frontend.sections.portfolio',['portfolio' => $portfolio_section])

    @includeWhen($process_section->status == App\Enums\StatusEnum::true->status(),'frontend.sections.process',['process' => $process_section])

    @includeWhen($product_section->status == App\Enums\StatusEnum::true->status(),'frontend.sections.product_section',['product_section' => $product_section])

    @includeWhen($support_section->status == App\Enums\StatusEnum::true->status(),'frontend.sections.support_section',['support_section' => $support_section])

    @includeWhen($team_section->status == App\Enums\StatusEnum::true->status(),'frontend.sections.team_section',['team_section' => $team_section])

    @includeWhen($contactUs_section->status == App\Enums\StatusEnum::true->status(),'frontend.sections.contactUs_section',['contactUs_section' => $contactUs_section])



@endsection
