@extends('layouts.dashboard_layout')

@section('css')
    <!--begin::Page Vendor Stylesheets(used by this page)-->
    <link href="{{ asset('dist/assets/plugins/custom/fullcalendar/fullcalendar.bundle.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('dist/assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('dist/assets/plugins/custom/vis-timeline/vis-timeline.bundle.css') }}" rel="stylesheet"
        type="text/css" />

    <!--end::Page Vendor Stylesheets-->
@stop

@section('heading_title')
    <!--begin::Heading-->
    <h1 class="d-flex flex-column text-dark fw-bolder my-0 fs-1">{{ trans('home.title') }}
        {{-- <small class="text-muted fs-6 fw-bold ms-1 pt-1">You’ve got 24 New Sales</small> --}}
    </h1>
    <!--end::Heading-->
@stop

@section('content')

    <div class="row g-5 g-lg-10" style="margin-bottom: 20px">
        <div class="col-xl-3" style="height: 200px">
            <div class="card bg-dark  card-xl-stretch mb-xl-8">
                <div class="card-body">
                    <span class="svg-icon svg-icon-white svg-icon-3x ms-n1">
                        <i class="fas fa-chart-pie" style="color: #fff ; font-size: 30px"></i>
                    </span>
                    <div class="text-white fw-bold fs-2 mb-2 mt-5">{{ trans('general.categories') }}</div>
                    <div class="fw-semibold text-white" style="font-size: 18px;">
                        {{ $categories_count }}</div>
                </div>
            </div>
        </div>
        <div class="col-xl-3" style="height: 200px; width:26%">
            <div class="card bg-dark  card-xl-stretch mb-xl-8">
                <div class="card-body">
                    <span class="svg-icon svg-icon-white svg-icon-3x ms-n1">
                        <i class="fas fa-chart-pie" style="color: #fff ; font-size: 30px"></i>
                    </span>
                    <div class="text-white fw-bold fs-2 mb-2 mt-5">{{ trans('general.sub_categories') }}</div>
                    <div class="fw-semibold text-white" style="font-size: 18px;">
                        {{ $sub_categories_count }}</div>
                </div>
            </div>
        </div>
        <div class="col-xl-3" style="height: 200px">
            <div class="card bg-dark  card-xl-stretch mb-xl-8">
                <div class="card-body">
                    <span class="svg-icon svg-icon-white svg-icon-3x ms-n1">
                        <i class="fas fa-book" style="color: #fff ; font-size: 30px"></i>
                    </span>
                    <div class="text-white fw-bold fs-2 mb-2 mt-5">{{ trans('general.books') }}</div>
                    <div class="fw-semibold text-white" style="font-size: 18px;">
                        {{ $books_count }}</div>
                </div>
            </div>
        </div>
    </div>

    <!--begin::Row-->
    <div class="row">
        <!--begin::Col-->
        <div class="col-xl-12">
            <!--begin::Chart widget 17-->
            <div class="card card-flush h-xl-100">
                <!--begin::Header-->
                <div class="card-header pt-7">
                    <!--begin::Title-->
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bolder text-dark">{{ trans('home.sub_category_statistics') }}</span>
                        {{-- <span class="text-gray-400 pt-2 fw-bold fs-6">Top Selling Countries</span> --}}
                    </h3>
                    <!--end::Title-->
                </div>
                <!--end::Header-->
                <!--begin::Body-->
                <div class="card-body pt-5">
                    <!--begin::Chart container-->
                    <div id="chartdiv" class="w-100 h-350px"></div>
                    <!--end::Chart container-->
                </div>
                <!--end::Body-->
            </div>
            <!--end::Chart widget 17-->
        </div>
        <!--end::Col-->
    </div>
    <!--end::Row-->




@stop

@section('js')
    <script src="https://cdn.amcharts.com/lib/5/index.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>

    <script>
        am5.ready(function() {

            // Create root element
            // https://www.amcharts.com/docs/v5/getting-started/#Root_element
            var root = am5.Root.new("chartdiv");


            // Set themes
            // https://www.amcharts.com/docs/v5/concepts/themes/
            root.setThemes([
                am5themes_Animated.new(root)
            ]);


            // Create chart
            // https://www.amcharts.com/docs/v5/charts/xy-chart/
            var chart = root.container.children.push(am5xy.XYChart.new(root, {
                panX: true,
                panY: true,
                wheelX: "panX",
                wheelY: "zoomX",
                pinchZoomX: true
            }));

            // Add cursor
            // https://www.amcharts.com/docs/v5/charts/xy-chart/cursor/
            var cursor = chart.set("cursor", am5xy.XYCursor.new(root, {}));
            cursor.lineY.set("visible", false);


            // Create axes
            // https://www.amcharts.com/docs/v5/charts/xy-chart/axes/
            var xRenderer = am5xy.AxisRendererX.new(root, {
                minGridDistance: 30
            });
            xRenderer.labels.template.setAll({
                rotation: -90,
                centerY: am5.p50,
                centerX: am5.p100,
                paddingRight: 15
            });

            xRenderer.grid.template.setAll({
                location: 1
            })

            var xAxis = chart.xAxes.push(am5xy.CategoryAxis.new(root, {
                maxDeviation: 0.3,
                categoryField: "category",
                renderer: xRenderer,
                tooltip: am5.Tooltip.new(root, {})
            }));

            var yAxis = chart.yAxes.push(am5xy.ValueAxis.new(root, {
                maxDeviation: 0.3,
                renderer: am5xy.AxisRendererY.new(root, {
                    strokeOpacity: 0.1
                })
            }));


            // Create series
            // https://www.amcharts.com/docs/v5/charts/xy-chart/series/
            var series = chart.series.push(am5xy.ColumnSeries.new(root, {
                name: "Series 1",
                xAxis: xAxis,
                yAxis: yAxis,
                valueYField: "value",
                sequencedInterpolation: true,
                categoryXField: "category",
                tooltip: am5.Tooltip.new(root, {
                    labelText: "{valueY}"
                })
            }));

            series.columns.template.setAll({
                cornerRadiusTL: 5,
                cornerRadiusTR: 5,
                strokeOpacity: 0
            });
            series.columns.template.adapters.add("fill", function(fill, target) {
                return chart.get("colors").getIndex(series.columns.indexOf(target));
            });

            series.columns.template.adapters.add("stroke", function(stroke, target) {
                return chart.get("colors").getIndex(series.columns.indexOf(target));
            });

            // Set data
            var categories = {{ Js::from($categories) }};

            var data = [];

            categories.forEach(myFunction);

            function myFunction(item) {
                data.push({
                    category: item.name,
                    value: item.sub_categories_count
                });
            }

            xAxis.data.setAll(data);
            series.data.setAll(data);

            // Make stuff animate on load
            // https://www.amcharts.com/docs/v5/concepts/animations/
            series.appear(1000);
            chart.appear(1000, 100);

        }); // end am5.ready()
    </script>
@stop
