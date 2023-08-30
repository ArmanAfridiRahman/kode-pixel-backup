@php
    $primaryRgba =  hexa_to_rgba(site_settings('primary_color'));
    $secondaryRgba =  hexa_to_rgba(site_settings('secondary_color'));
    $primary_light = "rgba(".$primaryRgba.",0.1)";
    $primary_light2 = "rgba(".$primaryRgba.",0.702)";
    $primary_light3 = "rgba(".$primaryRgba.",0.03)";
    $secondary_light = "rgba(".$secondaryRgba.",0.1)";
@endphp
<style>
:root{
    --color-primary:  {{ site_settings('primary_color') }} !important;
    --color-primary-light: {{$primary_light}} !important;
    --color-primary-light-2: {{$primary_light2}} !important;
    --color-primary-light-3: {{$primary_light3}} !important;
    --color-secondary: {{site_settings('secondary_color') }} !important;
    --color-secondary-light:{{$secondary_light}} !important;
    --text-primary:{{site_settings('text_primary') }} !important;
    --text-secondary:{{site_settings('text_secondary') }} !important;
}

</style>