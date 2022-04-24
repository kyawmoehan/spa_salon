$(window).load(function(){

    // select month option
    const d = new Date();
    let month = d.getMonth()+1;
    $('#item-month').val(month);
    $('#service-month').val(month);

    $('#item-month').change(function(){
       let itemMonth = $(this).val();
       $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "/topitems",
            type: "get",
            data: {itemMonth: itemMonth},
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
    });

    $('#service-month').change(function(){
        let serviceMonth = $(this).val();
        $.ajaxSetup({
         headers: {
             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
             }
         });
         $.ajax({
             url: "/topservices",
             type: "get",
             data: {serviceMonth: serviceMonth},
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
     });
});