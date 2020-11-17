@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Dashboard</div>
                    <div class="card-body">

                    <div class="row" style="margin-bottom: 20px;">

                        <div class="col-md-3">
                            <select onchange="getPages(this);" name="book_id" id="book_id" class="form-control m-input select2">
                                <option value="">Select Book</option>
                                @foreach($books as $book)
                                <option value="{{ $book->book_id }}">{{ $book->book_title }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <select name="page_no" id="page_no" class="form-control m-input select2">
                                <option value="">Select Page</option>
                            </select>
                        </div>

                        <div class="col-md-2">
                            <input type="text" class="form-control m-input " readonly placeholder="Start Date" id="date_timepicker_start">
                        </div>

                        <div class="col-md-2">
                            <input type="text" class="form-control m-input " readonly placeholder="End Date" id="date_timepicker_end">
                        </div>

                        <div class="col-md-2">
                            <button type="button" onclick="filterGraphData()" class="btn btn-secondary">Go</button>

                        </div>

                    </div>

                    <div class="row">
                        <div class="col-md-6">
                        <div style="width: 100%;" id="bar_graph"></div>
                        </div>
                        <div class="col-md-6">
                        <div style="width: 100%;" id="pie_graph"></div>
                        </div>

                    </div>

                        <div class="row" style="margin-top: 30px; display: none;">
                            <div class="col-md-12">
                                <div style="width: 100%;" id="bar_expression_graph"></div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('post-styles')
    <style>
        .select2-container .select2-selection--single{
            height: 40px;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered{
            line-height: 36px;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow{
            top: 7px;
        }
    </style>

@endpush

@push('post-scripts')
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/highcharts-3d.js"></script>
    <script src="https://code.highcharts.com/modules/data.js"></script>
    <script src="https://code.highcharts.com/modules/drilldown.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>

    <script>
        // Create the chart
        var bar_graph = Highcharts.chart('bar_graph', {
            chart: {
                type: 'column'
            },
            title: {
                text: 'Facial Expressions BarGraph'
            },
            subtitle: {
                text: ''
            },
            accessibility: {
                announceNewData: {
                    enabled: true
                }
            },
            xAxis: {
                type: 'category'
            },
            yAxis: {
                title: {
                    text: 'Total Numbers'
                }

            },
            legend: {
                enabled: false
            },
            plotOptions: {
                series: {
                    borderWidth: 0,
                    dataLabels: {
                        enabled: true,
                        format: '{point.y:.0f}'
                    }
                }
            },

            tooltip: {
                headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.0f}</b> of total<br/>'
            },

            series: [
                {
                    name: "Expression",
                    colorByPoint: true,
                    data: []
                }
            ]
        });

        var pie_graph =   Highcharts.chart('pie_graph', {
            chart: {
                type: 'pie',
                options3d: {
                    enabled: true,
                    alpha: 45,
                    beta: 0
                }
            },
            title: {
                text: 'Facial Expressions PieGraph'
            },
            accessibility: {
                point: {
                    valueSuffix: '%'
                }
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    depth: 35,
                    dataLabels: {
                        enabled: true,
                        format: '{point.name}'
                    }
                }
            },
            series: [{
                type: 'pie',
                name: 'Expression',
                data: []
            }]
        });

        function filterGraphData() {
            var book_id=$('#book_id').children("option:selected").val();
            var page_no=$('#page_no').children("option:selected").val();
            var start_date=$('#date_timepicker_start').val();
            var end_date=$('#date_timepicker_end').val();

            $.post('{{ route('admin.filter-graph-data-ajax') }}',{book_id:book_id,page_no:page_no,start_date:start_date,end_date:end_date},function(response){
                if (response.status) {
                    bar_graph.update({
                        series:
                            {
                            name: "Expression",
                            colorByPoint: true,
                            data: response.data_bg
                             }
                        }, true, true);

                    pie_graph.update({
                        series:
                            {
                            name: "Expression",
                            type: 'pie',
                            data: response.data_bg
                             }
                        }, true, true);
                }else{
                    bar_graph.update({series: []}, true, true);
                    pie_graph.update({series: []}, true, true);
                }

            },"json");
        }

        function getPages(obj) {
            var book_id = $(obj).val();
            if(book_id.length) {
                $.post('{{ route('admin.get-book-pages-ajax') }}', {'book_id': book_id}, function (response) {
                    if (response.status) {
                        $('#page_no').empty().trigger("change");
                        var newOption = new Option("Select Page", "", false, false);
                        $('#page_no').append(newOption).trigger('change');

                        response.data.forEach(function(row){
                            var newOption = new Option(row.page_no, row.page_no, false, false);
                            $('#page_no').append(newOption).trigger('change');
                        });

                    }else{
                        $('#page_no').empty().trigger("change");
                        var newOption = new Option("Select Page", "", false, false);
                        $('#page_no').append(newOption).trigger('change');
                    }

                },"json");


            }else{
                $('#page_no').empty().trigger("change");
                var newOption = new Option("Select Page", "", false, false);
                $('#page_no').append(newOption).trigger('change');
            }
        }


        var bar_expression_graph = Highcharts.chart('bar_expression_graph', {
            chart: {
                type: 'column'
            },
            title: {
                text: 'Facial Expressions'
            },
            subtitle: {
                text: ''
            },
            accessibility: {
                announceNewData: {
                    enabled: true
                }
            },
            xAxis: {
                type: 'category'
            },
            yAxis: {
                title: {
                    text: 'Total Numbers'
                }

            },
            legend: {
                enabled: false
            },
            plotOptions: {
                series: {
                    borderWidth: 0,
                    dataLabels: {
                        enabled: true,
                        format: '{point.y:.0f}'
                    }
                }
            },

            tooltip: {
                headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.0f}</b> of total<br/>'
            },

            series: [
                {
                    name: "Expression",
                    colorByPoint: true,
                    data: [{"name":"Angry","y":4},{"name":"Happy","y":29}]
                }
            ]
        });

    </script>

@endpush