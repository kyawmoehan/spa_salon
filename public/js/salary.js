$(window).load(function(){

    $('#staff-name').change(function(){
       let staff_id = $(this).val();
       $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "/staffrecord",
            type: "get",
            data: {id: staff_id},
            success:function(data){
                console.log(data);
                let serviceAmount = data.reduce((n, {staff_amount})=> n+ staff_amount,0);
                $('#service-amount').val(serviceAmount);
                let amount = +$('#amount').val();
                let totalAmount = amount + serviceAmount;
                $('#total-amount').val(totalAmount);
            },
        });
    });

    $('#amount').keyup(function(){
        let amount = +$(this).val();
        let serviceAmount = +$('#service-amount').val();
        let totalAmount = amount + serviceAmount;
        $('#total-amount').val(totalAmount);
    });
});