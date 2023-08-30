@extends('admin.layouts.master')
@section('content')

<div class="page-title-box">
    <h4 class="page-title">
       {{translate($title)}}
    </h4>
    <div class="page-title-right">
      <ol class="breadcrumb m-0">
        <li class="breadcrumb-item">
             <div class="cron">
              {{translate("Last Cron Run")}} : {{session()->has("last_corn_run") ?  diff_for_humans(session()->get("last_corn_run")) : translate("N/A")  }}
             </div>
        </li>
      </ol>
    </div>
  </div>

  <!-- card -->

  <div class="row g-3 mb-4">







    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
        <div class="i-card-sm style-2 info">
            <div class="icon">
              <i class="las la-users"></i>
            </div>
            <div class="card-info">
              <h5 class="title">
                {{translate("Total Visitors")}}
              </h5>
              <h3>{{$data['total_visitor']}}
                {{Arr::get($data,"total_visitor",0)}}
              </h3>
            </div>
        </div>
    </div>


  </div>

  <!-- charts -->

  <div class="row g-3 mb-4">


    <div class="col-lg-6">
      <div class="i-card-md">
        <div class="card--header">
          <h4 class="card-title">
            {{translate("Visitors By Month In")}}  {{ \Carbon\Carbon::now()->year }}
          </h4>
        </div>
        <div class="card-body">
          <div id="visitor" class="apex-chart"></div>
        </div>
      </div>
    </div>


  </div>




  @php
    $primaryRgba =  hexa_to_rgba(site_settings('primary_color'));
    $secondaryRgba =  hexa_to_rgba(site_settings('secondary_color'));
    $primary_light = "rgba(".$primaryRgba.",0.1)";
    $primary_light2 = "rgba(".$primaryRgba.",0.702)";
    $primary_light3 = "rgba(".$primaryRgba.",0.03)";
    $secondary_light = "rgba(".$secondaryRgba.",0.1)";
  @endphp

@endsection

@push('script-include')
  <script  src="{{asset('assets/global/js/apexcharts.js')}}"></script>
  <script  src="{{asset('assets/global/js/chart-init.js')}}"></script>
@endpush


@push('script-push')
<script>
  "use strict";


    var vistiorLabel =  @json(array_keys($data['visitor_by_months']));
    var visitorValues =  @json(array_values($data['visitor_by_months']));



   /** visitors by months */
    var options = {
          series: [{
          name: "{{translate('Visitors')}}",
          data: visitorValues
        }],
          chart: {
          height: 350,
          type: 'line',
        },
        forecastDataPoints: {
          count: 7
        },
        colors:['{{ site_settings('primary_color') }}'],
        stroke: {
          width: 5,
          curve: 'smooth'
        },
        xaxis: {

          categories: vistiorLabel,


        },
        title: {

          align: 'left',
          style: {
            fontSize: "16px",
            color: '#666'
          }
        },
        fill: {
          type: 'gradient',
          gradient: {
            shade: 'dark',
            gradientToColors: [ '#FDD835'],
            shadeIntensity: 1,
            type: 'horizontal',
            opacityFrom: 1,
            opacityTo: 1,
            stops: [0, 100, 100, 100]
          },
        },
        yaxis: {
          min: 0,
          max: 50
        }
    };

    var chart = new ApexCharts(document.querySelector("#visitor"), options);
    chart.render();


    /** earning by months */
    var earning = {
        series: [{
        data: earningValues
        }],
        chart: {
        type: 'bar',
        height: 350
      },
      annotations: {
        xaxis: [{
          x: 500,
          borderColor: '#00E396',
          label: {
            borderColor: '#00E396',
            style: {
              color: '#fff',
              background: '#00E396',
            },

          }
        }],

      },
      colors:['{{ site_settings('primary_color') }}'],

      plotOptions: {
        bar: {
          horizontal: true,
        }
      },
      dataLabels: {
        enabled: true
      },
      xaxis: {
        categories: earningLabel,
      },
      grid: {
        xaxis: {
          lines: {
            show: true
          }
        }
      },
      yaxis: {
        reversed: true,
        axisTicks: {
          show: true
        }
      }
    };

    var chart = new ApexCharts(document.querySelector("#earning"), earning);
    chart.render();


    /** gateway used by months */
    var options = {
          series: gatewayValues,
          chart: {
          type: 'polarArea',
          height: 365
        },
        labels: gatewayLabel ,
        stroke: {
          colors: ['#fff']
        },
        fill: {
          opacity: 0.8
        },

        colors:['{{ site_settings('primary_color') }}',"{{site_settings('secondary_color')}}" , "{{ $primary_light}}" , "{{ $primary_light2}}" ,"{{$primary_light3}}","{{$secondary_light}}"],

        responsive: [{
          breakpoint: 480,
          options: {
            chart: {
              width: 200
            },
            legend: {
              position: 'bottom'
            }
          }
        }]
    };

    var chart = new ApexCharts(document.querySelector("#paymentGateway"), options);
    chart.render();





</script>
@endpush




