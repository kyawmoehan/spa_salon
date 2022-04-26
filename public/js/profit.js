$(window).load(function(){

    // select month option
    const d = new Date();
    let year = d.getFullYear();
    $('#profit-year').val(year);

    function topIems(profitYear){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "/getprofit",
            type: "get",
            data: {profitYear: profitYear},
            success:function(data){
                if(profitYear != null ){
                    $("#jshow-profit").removeClass( "d-none" );
                    $("#show-profit").addClass( "d-none" );
                }else{
                    $("#jshow-profit").addClass( "d-none" );
                    $("#show-profit").removeClass( "d-none" );
                }
                $( "#jshow-profit" ).empty();
                $.each( data.yearProfits, function( i, item ) {
                    var newListItem = `
                    <tr>
                        <td>${++i}</td>
                        <td>${data.months[--i]}</td>
                        <td>${item['voucherCost']}</td>
                        <td>${item['generalCost']}</td>
                        <td>${item['usageCost']}</td>
                        <td>${item['salaryCost']}</td>
                        <td>${item['profit']}</td>
                    </tr>
                    `; 
                    $( "#jshow-profit" ).append( newListItem );
                });
            },
        });
    }

    $('#profit-year').change(function(){
        let profitYear = $(this).val();
        topIems(profitYear);
    });
});