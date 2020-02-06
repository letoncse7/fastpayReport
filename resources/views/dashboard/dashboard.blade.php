@extends('layouts.master')
@section('main-content')
           <div class="main-content pt-4">
                <div class="breadcrumb">
                    <div class="col-md-7">
                      <button class="btn btn-raised btn-raised-primary chart-call" data="-1" type="button">Yesterday</button>
                      <button class="btn btn-outline-primary m-1 chart-call" data="7" type="button">This Week</button>
                      <button class="btn btn-outline-primary m-1 chart-call" data="-7" type="button">Last Week</button>
                      <button class="btn btn-outline-primary m-1 chart-call" data="30" type="button">This Month</button>
                      <button class="btn btn-outline-primary m-1 chart-call" data="-30" type="button">Last Month</button>                   
                      <button class="btn btn-outline-primary m-1 chart-call" data="32" type="button" >LMTD</button>
                      <button class="btn btn-outline-primary m-1 chart-call" data="365" type="button">This Year</button>
                      
                       

                    </div>
                    <div class="col-md-2" >
                        <input type="text" name="daterange" date-from="2020-01-07" date-to="2020-01-07" class="text form-control" value="2020-01-2-2020-01-23" id="daterange" />
                        

                    </div>
                    <div class="col-md-2">
                                            
                                            <select class="form-control" name="type" id="type" >
                                                <option value="all">All Type</option>
                                                <option value="6">Airtime</option>
                                                <option value="15">Data Bundle</option>
                                                <option value="19">Online Card</option>
                                                <option value="1">Online Shopping</option>
                                            </select >
                    </div>
                    <div class="col-md-1">
                        <input type="button" class="btn btn-primary" name="search" id="search-by-date" value="Search">
                    </div>
                    
                    
                </div>
                <div class="separator-breadcrumb border-top"></div>
                
               
                <!-- <div class="row">
                   
                    <div class="col-lg-4 col-md-4 col-sm-4">
                        <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                            <div class="card-body text-center"><i class="i-Add-User"></i>
                                <div class="content" style="max-width:100%;margin: 5px;">
                                    <p class="text-muted mt-2 mb-0">Total Deposit (IQD)</p>
                                    <p class="text-primary text-24 line-height-1 mb-2"> 8703603.33 M</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-4">
                        <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                            <div class="card-body text-center"><i class="i-Financial"></i>
                                <div class="content" style="max-width:100%;margin: 5px;">
                                    <p class="text-muted mt-2 mb-0">Total Withdrawal (IQD)</p>
                                    <p class="text-primary text-24 line-height-1 mb-2">4021.33 M</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-4">
                        <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                            <div class="card-body text-center"><i class="i-Money-2"></i>
                                <div class="content" style="max-width:100%;margin: 5px;">
                                    <p class="text-muted mt-2 mb-0">Current Balance (IQD)</p>
                                    <p class="text-primary text-24 line-height-1 mb-2">34021.33 M </p>
                                </div>
                            </div>
                        </div>
                    </div>
                   
                    
                </div> -->

                <div class="row">
                    <div class="col-md-3">
                        <div class="card mb-4">
                            <div class="card-body">
                                <h6 class="mb-3">Cash In (Amount)</h6>
                                
                                    @if($cashIn_amount > $previous_day_summary['amount'])
                                    <p class="text-20 text-success line-height-1 mb-3" id="cash_in_amount">
                                        <i class="i-Arrow-Up-in-Circle"></i> 
                                         {{ number_format($cashIn_amount, 2) }} M

                                          
                                    </p>
                                    <small class="text-muted" id="amount_txt">{{number_format($cashIn_amount_percent, 2)}}% up than last day</small>
                                     @else
                                     <p class="text-20 text-danger line-height-1 mb-3" id="cash_in_amount">
                                      <i class="i-Arrow-Down-in-Circle"></i> 
                                       {{ number_format($cashIn_amount, 2) }} M

                                        
                                     </p>
                                     <small class="text-muted" id="amount_txt">{{number_format($cashIn_amount_percent, 2)}}% down than last day</small>
                                     @endif
                                   
                               
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card mb-4">
                            <div class="card-body">
                                <h6 class="mb-3">Cash In (Quantity)</h6>
                                
                                    @if($cashIn_quantity > $previous_day_summary['quantity'])
                                    <p class="text-20 text-success line-height-1 mb-3" id="cash_in_quantity">
                                        <i class="i-Arrow-Up-in-Circle"></i> 
                                        {{$cashIn_quantity}} 

                                    </p>
                                     <small class="text-muted" id="quantity_txt">
                            {{number_format($cashIn_quantity_percent, 2)}}% up than last day</small>
                                     @else
                                     <p class="text-20 text-danger line-height-1 mb-3" id="cash_in_quantity">
                                      <i class="i-Arrow-Down-in-Circle"></i> 
                                      {{$cashIn_quantity}} 
                                       
                                  </p>
                                  <small class="text-muted" id="quantity_txt">
                            {{number_format($cashIn_quantity_percent, 2)}}% down than last day</small>
                                     @endif
                                

                            </div>
                        </div>
                    </div>
                  
                    <div class="col-md-3">
                        <div class="card o-hidden">

                            <div class="card-body">
                                <div class="d-flex justify-content-between border-bottom">
                                    <div class="flex-grow-1">
                                        <p class="text-small text-center m-0">Top in Quantity</p>
                                    </div>
                                    
                                </div>
                                <div class="d-flex justify-content-between">
                                    <div class="flex-grow-1 border-right">
                                        <p class="text-12 text-muted m-0 p-2">
                                            <strong id="max_quantity_name">{{$max_quantity['name']}}</strong></p>
                                    </div>
                                    <div class="flex-grow-1">
                                        <p class="text-12 text-muted m-0 p-2">
                                            <strong id="max_quantity_value">{{$max_quantity['quantity']}}</strong></p>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 ">
                        <div class="card o-hidden">

                            <div class="card-body">
                                <div class="d-flex justify-content-between border-bottom">
                                    
                                    <div class="flex-grow-1">
                                        <p class="text-small text-center m-0">Top in Amount</p>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <div class="flex-grow-1 border-right">
                                        <p class="text-12 text-muted m-0 p-2">
                                            <strong id="max_amount_name">{{$max_amount['name']}}</strong></p>
                                    </div>
                                    <div class="flex-grow-1">
                                        <p class="text-12 text-muted m-0 p-2">
                                            <strong id="max_amount_value">{{ number_format($max_amount['amount'] / 1000000, 2) }} M</strong></p>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

            </div>
                
                <section class="ul-product-detail__tab">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 mt-4">
                            <div class="card mt-2 mb-4">
                                <div class="card-header bg-transparent"><h3>Transaction Report For <span id="transaction_type_txt">All Type</span></h3></div>
                                <div class="card-body">
                                            <div class="tab-pane fade show active all" id="nav-chart-all" >
                                              <div class="ul-product-detail__nested-card mt-2">
                                                    <div class="row text-center">
                                                        <div class="col-lg-4 col-sm-12">
                                                            <div class="card mb-4">
                                                                <div class="card-body">
                                                                    <div class="card-title">Sales by Quantity</div>
                                                                    <div id="chartTypeWiseQuantity" style="height: 300px;"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4 col-sm-12">
                                                            <div class="card mb-4">
                                                                <div class="card-body">
                                                                    <div class="card-title">Sales by Amount</div>
                                                                    <div id="chartTypeWiseAmount" style="height: 300px;"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4 col-sm-12">
                                                            <div class="card mb-4">
                                                                <div class="card-body">
                                                                    <div class="card-title">ARPU</div>
                                                                    <div id="chartTypeWiseARPU" style="height: 300px;"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- END OF CHART -->
                                                
                                            </div>
                                           
                                        
                                    </div>
                                </div>
                                 <!-- end::basic tab-->
                                
                    
                    
                        </div>
                    </div>
                </section><!-- end of main-content -->
                
                
                
                
                
                
                
                
                    
            </div>
            


@endsection

@section('page-js')
     <script src="{{asset('assets/js/vendor/echarts.min.js')}}"></script>
     <script src="{{asset('assets/js/es5/echart.options.min.js')}}"></script>
     <script src="{{asset('assets/js/es5/dashboard.v1.script.js')}}"></script>


@endsection

