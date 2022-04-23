$(window).load(function(){

    // select month option
    const d = new Date();
    let month = d.getMonth()+1;
    $('#item-month').val(month);

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
                    console.log('hi');
                    $("#jshow-item").removeClass( "d-none" );
                    $("#show-item").addClass( "d-none" );
                }else{
                    console.log('hello')
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
});