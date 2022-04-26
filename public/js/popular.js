$(window).load(function(){

    // select month option
    const d = new Date();
    let month = d.getMonth()+1;
    let year = d.getFullYear();
    $('#item-month').val(month);
    $('#item-year').val(year);
    $('#service-month').val(month);
    $('#service-year').val(year);

    function topIems(itemMonth , itemYear){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "/topitems",
            type: "get",
            data: {itemMonth: itemMonth, itemYear: itemYear},
            success:function(data){
                console.log(data);
                if(itemMonth != null ){
                    $("#jshow-item").removeClass( "d-none" );
                    $("#show-item").addClass( "d-none" );
                }else{
                    $("#jshow-item").addClass( "d-none" );
                    $("#show-item").removeClass( "d-none" );
                }
                $( "#jshow-item" ).empty();
                let number = 1;
                $.each( data, function( i, item ) { 
                    var newListItem = `
                    <tr>
                        <th scope="row">${number++}</th>
                        <td>${i}</td>
                        <td>${item}</td>
                    </tr>
                    `; 
                    $( "#jshow-item" ).append( newListItem );
                });
            },
        });
    }

    $('#item-month').change(function(){
        let itemMonth = $(this).val();
        let itemYear = $('#item-year').val();
        topIems(itemMonth, itemYear);
    });

    $('#item-year').change(function(){
        let itemYear = $(this).val();
        let itemMonth = $('#item-month').val();
        topIems(itemMonth, itemYear);
    });

    function topServices(serviceMonth, serviceYear){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "/topservices",
            type: "get",
            data: {serviceMonth: serviceMonth, serviceYear: serviceYear},
            success:function(data){
                console.log(data);
                if(serviceMonth != null ){
                    $("#jshow-service").removeClass( "d-none" );
                    $("#show-service").addClass( "d-none" );
                }else{
                    $("#jshow-service").addClass( "d-none" );
                    $("#show-service").removeClass( "d-none" );
                }
                $( "#jshow-service" ).empty();
                let number = 1;
                $.each( data, function( i, item ) { 
                    var newListItem = `
                    <tr>
                        <th scope="row">${number++}</th>
                        <td>${i}</td>
                        <td>${item}</td>
                    </tr>
                    `; 
                    $( "#jshow-service" ).append( newListItem );
                });
            },
       });
    }

    $('#service-month').change(function(){
        let serviceMonth = $(this).val();
        let serviceYear = $('#service-year').val();

        topServices(serviceMonth, serviceYear);
    });

    $('#service-year').change(function(){
        let serviceYear = $(this).val();
        let serviceMonth = $('#service-month').val();

        topServices(serviceMonth, serviceYear);
    });

});