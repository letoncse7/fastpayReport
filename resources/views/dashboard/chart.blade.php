@extends('layouts.master')
@section('main-content')
           <div class="main-content pt-4">
                <div class="breadcrumb">
                    
                    <div class="col-md-3 my-3" id="change-year">
                                            
                                            <select class="form-control" name="year" id="year" onchange="chartData()">
                                                <option value="2018">Select Year (Default 2018 Selected)</option>
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
                            <p class="highcharts-description text-center">
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




@endsection

