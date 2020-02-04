'use strict';

var _extends = Object.assign || function (target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i]; for (var key in source) { if (Object.prototype.hasOwnProperty.call(source, key)) { target[key] = source[key]; } } } return target; };

$(document).ready(function () {

         var init_data=[];
         var csrf_token  = document.head.querySelector('meta[name="csrf-token"]').content;

         $("#type").change(function (e){
             
         var interval = $(".btn-raised-primary").attr("data");
         var formDate = $("#daterange").attr("date-from");
         var toDate = $("#daterange").attr("date-to");
          e.preventDefault();
         $.ajax({
                url: window.location.origin + '/' + 'get-dashboard-report',
                type: 'POST',
                data: {
                    '_token': csrf_token,
                    '_interval': interval,
                    '_fromDate': formDate,
                    '_toDate': toDate,
                    '_type': $("#type").val()
                },
                success: function( data, textStatus, jQxhr ){
                        var Q = [];
                        var A = [];
                        var R = [];

                      if($("#type").val()=='all'){
                          
                          $(".all").show();
                      }
                      else{

                          $(".all").hide();

                          $("#nav-chart-"+ $("#type").val()).show();
                      }

                    $.each(data.typewise, function(key, value){
                        
                         Q[key] = {"name": value.name, "value":value.quantity};
                         A[key] = {"name": value.name, "value":value.amount};
                         R[key] = {"name": value.name, "value":value.arpu};
                         

                    });


                    var ElementIdQ = document.getElementById('chartTypeWiseQuantity');
                    var ElementIdA = document.getElementById('chartTypeWiseAmount');
                    var ElementIdR = document.getElementById('chartTypeWiseARPU');
                   
                    dashboard_chart_typewise(Q, "Sales by Quantity", ElementIdQ);
                    dashboard_chart_typewise(A, "Sales by Amount", ElementIdA);
                    dashboard_chart_typewise(R, "Sales by ARPU", ElementIdR);
                    
                    var A_Q = [];
                    var A_A = [];
                    var A_R = [];

                    var B_Q = [];
                    var B_A = [];
                    var B_R = [];

                    var C_Q = [];
                    var C_A = [];
                    var C_R = [];

                    var S_Q = [];
                    var S_A = [];
                    var S_R = [];
                    
                   $.each(data.single_chart, function(key, value){

                         if(value.type=='6'){

                             A_Q[key] = {"name": value.name, "value":value.quantity};
                             A_A[key] = {"name": value.name, "value":value.amount};
                             A_R[key] = {"name": value.name, "value":value.arpu};

                         }

                         if(value.type=='15'){

                             B_Q[key] = {"name": value.name, "value":value.quantity};
                             B_A[key] = {"name": value.name, "value":value.amount};
                             B_R[key] = {"name": value.name, "value":value.arpu};

                         }

                         if(value.type=='19'){

                             C_Q[key] = {"name": value.name, "value":value.quantity};
                             C_A[key] = {"name": value.name, "value":value.amount};
                             C_R[key] = {"name": value.name, "value":value.arpu};

                         }

                         if(value.type=='1'){

                             S_Q[key] = {"name": value.name, "value":value.quantity};
                             S_A[key] = {"name": value.name, "value":value.amount};
                             S_R[key] = {"name": value.name, "value":value.arpu};

                         }

                    });

                    var ElementIdAirtimeQ = document.getElementById('chartAirtimeQ');
                    var ElementIdAirtimeA = document.getElementById('chartAirtimeA');
                    var ElementIdAirtimeR = document.getElementById('chartAirtimeR');
                   
                    dashboard_chart_single(A_Q, "Sales by Quantity", ElementIdAirtimeQ);
                    dashboard_chart_single(A_A, "Sales by Amount", ElementIdAirtimeA);
                    dashboard_chart_single(A_R, "Sales by ARPU", ElementIdAirtimeR);


                    var ElementIdDataBundleQ = document.getElementById('chartDataBundleQ');
                    var ElementIdDataBundleA = document.getElementById('chartDataBundleA');
                    var ElementIdDataBundleR = document.getElementById('chartDataBundleR');
                   
                    dashboard_chart_single(B_Q, "Sales by Quantity", ElementIdDataBundleQ);
                    dashboard_chart_single(B_A, "Sales by Amount", ElementIdDataBundleA);
                    dashboard_chart_single(B_R, "Sales by ARPU", ElementIdDataBundleR);

                    var ElementIdOnlineCardQ = document.getElementById('chartOnlineCardQ');
                    var ElementIdOnlineCardA = document.getElementById('chartOnlineCardA');
                    var ElementIdOnlineCardR = document.getElementById('chartOnlineCardR');
                   
                    dashboard_chart_single(C_Q, "Sales by Quantity", ElementIdOnlineCardQ);
                    dashboard_chart_single(C_A, "Sales by Amount", ElementIdOnlineCardA);
                    dashboard_chart_single(C_R, "Sales by ARPU", ElementIdOnlineCardR);


                    var ElementIdOnlineShopQ = document.getElementById('chartOnlineShopQ');
                    var ElementIdOnlineShopA = document.getElementById('chartOnlineShopA');
                    var ElementIdOnlineShopR = document.getElementById('chartOnlineShopR');
                   
                    dashboard_chart_single(S_Q, "Sales by Quantity", ElementIdOnlineShopQ);
                    dashboard_chart_single(S_A, "Sales by Amount", ElementIdOnlineShopA);
                    dashboard_chart_single(S_R, "Sales by ARPU", ElementIdOnlineShopR);

                },
                error: function( jqXhr, textStatus, errorThrown ){
                    console.log( errorThrown );
                }
           });

         });

         $("#search-by-date").click(function (){
             
         var interval = $(".btn-raised-primary").attr("data");
         var formDate = $("#daterange").attr("date-from");
         var toDate = $("#daterange").attr("date-to");
         if(formDate=='' || toDate==''){
            
            $("#daterange").focus();
                 return false;
         }


         $.ajax({
                url: window.location.origin + '/' + 'get-dashboard-report',
                type: 'POST',
                data: {
                    '_token': csrf_token,
                    '_fromDate': formDate,
                    '_toDate': toDate,
                    '_type': $("#type").val()
                },
                success: function( data, textStatus, jQxhr ){
                        var Q = [];
                        var A = [];
                        var R = [];


                    $.each(data.typewise, function(key, value){
                        
                         Q[key] = {"name": value.name, "value":value.quantity};
                         A[key] = {"name": value.name, "value":value.amount};
                         R[key] = {"name": value.name, "value":value.arpu};
                         

                    });


                    var ElementIdQ = document.getElementById('chartTypeWiseQuantity');
                    var ElementIdA = document.getElementById('chartTypeWiseAmount');
                    var ElementIdR = document.getElementById('chartTypeWiseARPU');
                   
                    dashboard_chart_typewise(Q, "Sales by Quantity", ElementIdQ);
                    dashboard_chart_typewise(A, "Sales by Amount", ElementIdA);
                    dashboard_chart_typewise(R, "Sales by ARPU", ElementIdR);
                    
                    var A_Q = [];
                    var A_A = [];
                    var A_R = [];

                    var B_Q = [];
                    var B_A = [];
                    var B_R = [];

                    var C_Q = [];
                    var C_A = [];
                    var C_R = [];

                    var S_Q = [];
                    var S_A = [];
                    var S_R = [];
                    
                   $.each(data.single_chart, function(key, value){

                         if(value.type=='6'){

                             A_Q[key] = {"name": value.name, "value":value.quantity};
                             A_A[key] = {"name": value.name, "value":value.amount};
                             A_R[key] = {"name": value.name, "value":value.arpu};

                         }

                         if(value.type=='15'){

                             B_Q[key] = {"name": value.name, "value":value.quantity};
                             B_A[key] = {"name": value.name, "value":value.amount};
                             B_R[key] = {"name": value.name, "value":value.arpu};

                         }

                         if(value.type=='19'){

                             C_Q[key] = {"name": value.name, "value":value.quantity};
                             C_A[key] = {"name": value.name, "value":value.amount};
                             C_R[key] = {"name": value.name, "value":value.arpu};

                         }

                         if(value.type=='1'){

                             S_Q[key] = {"name": value.name, "value":value.quantity};
                             S_A[key] = {"name": value.name, "value":value.amount};
                             S_R[key] = {"name": value.name, "value":value.arpu};

                         }

                    });

                    var ElementIdAirtimeQ = document.getElementById('chartAirtimeQ');
                    var ElementIdAirtimeA = document.getElementById('chartAirtimeA');
                    var ElementIdAirtimeR = document.getElementById('chartAirtimeR');
                   
                    dashboard_chart_single(A_Q, "Sales by Quantity", ElementIdAirtimeQ);
                    dashboard_chart_single(A_A, "Sales by Amount", ElementIdAirtimeA);
                    dashboard_chart_single(A_R, "Sales by ARPU", ElementIdAirtimeR);


                    var ElementIdDataBundleQ = document.getElementById('chartDataBundleQ');
                    var ElementIdDataBundleA = document.getElementById('chartDataBundleA');
                    var ElementIdDataBundleR = document.getElementById('chartDataBundleR');
                   
                    dashboard_chart_single(B_Q, "Sales by Quantity", ElementIdDataBundleQ);
                    dashboard_chart_single(B_A, "Sales by Amount", ElementIdDataBundleA);
                    dashboard_chart_single(B_R, "Sales by ARPU", ElementIdDataBundleR);

                    var ElementIdOnlineCardQ = document.getElementById('chartOnlineCardQ');
                    var ElementIdOnlineCardA = document.getElementById('chartOnlineCardA');
                    var ElementIdOnlineCardR = document.getElementById('chartOnlineCardR');
                   
                    dashboard_chart_single(C_Q, "Sales by Quantity", ElementIdOnlineCardQ);
                    dashboard_chart_single(C_A, "Sales by Amount", ElementIdOnlineCardA);
                    dashboard_chart_single(C_R, "Sales by ARPU", ElementIdOnlineCardR);


                    var ElementIdOnlineShopQ = document.getElementById('chartOnlineShopQ');
                    var ElementIdOnlineShopA = document.getElementById('chartOnlineShopA');
                    var ElementIdOnlineShopR = document.getElementById('chartOnlineShopR');
                   
                    dashboard_chart_single(S_Q, "Sales by Quantity", ElementIdOnlineShopQ);
                    dashboard_chart_single(S_A, "Sales by Amount", ElementIdOnlineShopA);
                    dashboard_chart_single(S_R, "Sales by ARPU", ElementIdOnlineShopR);

                    var summary = data.summary;

                    console.log(summary);

                    if(summary.a > 0){
                        var txt_a = "<i class='i-Arrow-Up-in-Circle'></i>" + summary.a.toFixed(2) + "M";
                        var amount_txt = summary.ap.toFixed(2) +'% up than last day';
                        $("#cash_in_amount").addClass("text-success").removeClass("text-danger");
                    }
                    else{

                        var txt_a = "<i class='i-Arrow-Down-in-Circle'></i>" + summary.a.toFixed(2) + "M";
                        var amount_txt =  summary.ap.toFixed(2) +'% down than last day';
                        $("#cash_in_amount").addClass("text-danger").removeClass("text-success");
                    }

                     if(summary.q > 0){
                        var txt_q = "<i class='i-Arrow-Up-in-Circle'></i>" + summary.q;
                        var quantity_txt = summary.qp.toFixed(2) +'% up than last day';
                        $("#cash_in_quantity").addClass("text-success").removeClass("text-danger");
                    }
                    else{

                        var txt_q = "<i class='i-Arrow-Down-in-Circle'></i>" + summary.q;
                        var quantity_txt = summary.qp.toFixed(2) +'% down than last day';;
                        $("#cash_in_quantity").addClass("text-danger").removeClass("text-success");
                    }


                    
                    $("#cash_in_amount").html(txt_a);
                    $("#amount_txt").html(amount_txt);

                    $("#cash_in_quantity").html(txt_q);
                    $("#quantity_txt").html(quantity_txt);

                    $("#max_quantity_name").html(summary.mq.name);
                    $("#max_quantity_value").html(summary.mq.quantity);

                    $("#max_amount_name").html(summary.ma.name);
                    $("#max_amount_value").html(summary.ma.amount / 1000000 + " M");



                },
                error: function( jqXhr, textStatus, errorThrown ){
                    console.log( errorThrown );
                }
           });

         

         });
 
     /****** Begin Chart For Type Wise Quantity in Dashboard ********/
      
       $(".chart-call").click(function (){

       $( ".chart-call" ).removeClass( "btn-raised btn-raised-primary" ).addClass( "btn-outline-primary" );

       $(this).addClass( "btn-raised btn-raised-primary" ).removeClass( "btn-outline-primary" );
       
       var data = $(this).attr("data");

         if(data=='-1'){

             var start_date = Date.today().addDays(-1);
             var end_date = Date.today();

         }
         else if(data=="7"){

           var start_date = new Date().last().week();
           var end_date = Date.today();
         }
         else if(data=="-7"){

           var start_date = Date.today().addWeeks(-2);
           var end_date = new Date().last().week();


         }
         else if(data=="30"){

           var start_date = Date.today().moveToFirstDayOfMonth();
           var end_date = Date.today().moveToLastDayOfMonth();

         }
         else if(data=="-30"){
         var start_date = Date.today().moveToFirstDayOfMonth().addMonths(-1);
         var end_date = Date.today().moveToLastDayOfMonth().addMonths(-1);
         }
         else if(data=="32"){
          
          var start_date = Date.today().moveToFirstDayOfMonth().addMonths(-1);
          var end_date = Date.today();

         }
         else if(data=="365"){
    
           var start_date = new Date(new Date().getFullYear(), 0, 1,0,0,0);
           var end_date = new Date(new Date().getFullYear(), 11, 31,0,0,0);
         }
       
       var date_from = start_date.toString("yyyy-MM-dd");
       var date_to = end_date.toString("yyyy-MM-dd");
       var start_date = start_date.toString("MM/dd/yyyy");
       var end_date = end_date.toString("MM/dd/yyyy");

       $("#daterange").val(start_date + "-" + end_date);
       $("#daterange").attr("date-from", date_from);
       $("#daterange").attr("date-to", date_to);

       });
       



             function dashboard_chart_typewise(data, title, ElementId){
                
                if (ElementId) {
                    var chartTypeWise = echarts.init(ElementId);
                    chartTypeWise.setOption({
                        color: ['#7FFFD4', '#0000FF', '#A52A2A', '#7FFF00', '#FF7F50', '#D2691E', '#5F9EA0', '#DC143C', '#00008B', '#008B8B', '#B8860B', '#006400', '#6957af'],
                        tooltip: {
                            show: true,
                            backgroundColor: 'rgba(0, 0, 0, .8)'
                        },

                        series: [{
                            name: title,
                            type: 'pie',
                            radius: '60%',
                            center: ['50%', '50%'],
                            data: data,
                            itemStyle: {
                                emphasis: {
                                    shadowBlur: 10,
                                    shadowOffsetX: 0,
                                    shadowColor: 'rgba(0, 0, 0, 0.5)'
                                }
                            }
                        }]
                    });
                    $(window).on('resize', function () {
                        setTimeout(function () {
                            chartTypeWise.resize();
                        }, 500);
                    });
                }
               }
               


   /****** END Chart For Type Wise ARPU in Dashboard ********/

  
   /****** Begin Chart For Airtime Quantity in Dashboard ********/

   function dashboard_chart_single(data, title, ElementId){

    if (ElementId) {
        var chartSingleType = echarts.init(ElementId);
        chartSingleType.setOption({
            color: ['#7FFFD4', '#0000FF', '#A52A2A', '#7FFF00', '#FF7F50', '#D2691E', '#5F9EA0', '#DC143C', '#00008B', '#008B8B',
                    '#B8860B', '#006400', '#6957af', '#DDA0DD', '#B0E0E6', '#663399', '#FF0000', '#BC8F8F', '#4169E1', '#B8860B', 
                    '#8B4513', '#FA8072', '#F4A460', '#2E8B57', '#A0522D', '#FFF5EE', '#C0C0C0', '#87CEEB', '#6A5ACD', '#708090',
                    '#708090', '#00FF7F', '#4682B4', '#D2B48C', '#FF6347', '#40E0D0', '#EE82EE', '#F5DEB3'],
            tooltip: {
                show: true,
                backgroundColor: 'rgba(0, 0, 0, .8)'
            },

            series: [{
                name: title,
                type: 'pie',
                radius: '60%',
                center: ['50%', '50%'],
                data: data,
                itemStyle: {
                    emphasis: {
                        shadowBlur: 10,
                        shadowOffsetX: 0,
                        shadowColor: 'rgba(0, 0, 0, 0.5)'
                    }
                }
            }]
        });
        $(window).on('resize', function () {
            setTimeout(function () {
                chartSingleType.resize();
            }, 500);
        });
    }
   }
   
   /****** END Chart For Type Wise ARPU in Dashboard ********/
     
        
   

});