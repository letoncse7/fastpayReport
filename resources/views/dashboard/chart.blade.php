@extends('layouts.master')
@section('main-content')
           <div class="main-content pt-4">
                <div class="breadcrumb">
                    
                    <div class="col-md-3 my-3" id="change-year">
                                            
                                            <select class="form-control" name="year" id="year" >
                                                <option value="2018">Select Year</option>
                                                <option value="2017">2017</option>
                                                <option value="2018">2018</option>
                                                <option value="2019">2019</option>
                                                <option value="2020">2020</option>
                                            </select >
                    </div>
                   
                    
                    
                </div>

                
            
                <section class="ul-product-detail__tab">
                    <div class="row">
                        <div class="col-md-12">
                            <div id="container"></div>
                            <p class="highcharts-description">
                                Chart showing month wise transaction amount. Clicking on individual columns
                                brings up more detailed data. That are daily transaction amount. 
                            </p>
                            
                        </div>
                        

                    
                    </div>
                </section><!-- end of main-content -->
                

            </div>
            


@endsection

@section('page-js')
     <script src="https://code.highcharts.com/highcharts.js"></script>
     <script src="https://code.highcharts.com/modules/data.js"></script>
     <script src="https://code.highcharts.com/modules/drilldown.js"></script>
     <script src="https://code.highcharts.com/modules/exporting.js"></script>
     <script src="https://code.highcharts.com/modules/export-data.js"></script>
     <script src="https://code.highcharts.com/modules/accessibility.js"></script>

     <script type="text/javascript">

    $(document).ready(function(){
     var csrf_token  = document.head.querySelector('meta[name="csrf-token"]').content;
     $("#year").on("change", function(e){

       $.ajax({
                url: window.location.origin + '/' + 'monthly-daily-transaction-data',
                type: 'POST',
                data: {
                    '_token': csrf_token,
                    '_year': $("#year").val()
                },
                success: function( data, textStatus, jQxhr ){

                        // Create the chart
                        var title = 'FastPay Month Wise Transaction For The Year Of-<span>2018</span>';
                        var monthly_data = data.monthly;
                        var daily_data = data.daily;

                      

                        Highcharts.chart('container', {
                            chart: {
                                type: 'column',
                                "width": 1240,
                                "height": 457
                            },
                            title: {
                                text: title
                            },
                            subtitle: {
                                text: 'Click the columns to view day wise transaction amount.'
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
                                    text: 'Total Transaction Amount'
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
                                        format: '{point.y:.2f}'
                                    }
                                }
                            },

                            tooltip: {
                                headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                                pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b> IQD {point.y:.2f}</b><br/>'
                            },

                            series: [
                                {
                                    name: "FastPay Transaction Amount",
                                    colorByPoint: true,
                                    data: monthly_data
                                }
                            ],
                            drilldown: {
                                series: daily_data
                            }
                        });
                          $(".highcharts-credits").hide();

                },
                error: function( jqXhr, textStatus, errorThrown ){
                    console.log( errorThrown );
                }
           });

                    


          });

    });
</script>


@endsection

