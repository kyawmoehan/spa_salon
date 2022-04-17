var SELECTEDCHECK = "";


// get local storage
function getLocalstorage(){
    let getVoucherStr = localStorage.getItem("vouchers");
    let getVoucherArray = JSON.parse(getVoucherStr);
    return getVoucherArray;
}

function getVoucherById(id){
    let getVoucherArray = getLocalstorage();
    let voucher = getVoucherArray.find(obj => obj.id == id);
    return voucher;
}

// get corropesanding voucher
function checkBtn(id){
    SELECTEDCHECK = id;
    
    let voucher = getVoucherById(id);
    
    let voucherId = document.getElementById('voucher-id');
    voucherId.innerHTML = voucher['id'];
    let customerName = document.getElementById('customer-name');
    customerName.innerHTML = voucher['customerName'];
    
    // item table
    let items = voucher.items;
    $( "#items-table" ).empty();
    $.each( items, function( i, item ) {  
        console.log(item);     
        var newListItem = `
        <tr>
        <td class="text-dark"><b>${i+1}</b></td>
        <td>
            ${item['itemName']}
        </td>
        <td>
            ${item['quantity']}
        </td>
        <td>
            ${item['itemPrice']}
        </td>
        <td>
            ${item['itemPrice']* item['quantity']}
        </td>
        <td>
            <a class="btn btn-sm text-danger">
                <i class="fa fa-trash"></i>
            </a>
        </td>
    </tr>
        `; 
        $( "#items-table" ).append( newListItem );
     
    });
    
}

// add item
function addItem(itemId, itemName, itemPrice){
    var item = {
        itemId,
        itemName,
        itemPrice,
        quantity: 1,
    }
    let getVoucherArray = getLocalstorage();
    const index = getVoucherArray.findIndex(object => {
        return object.id === SELECTEDCHECK;
      });

    if(getVoucherArray[index].hasOwnProperty('items')){
        let getItems =  getVoucherArray[index].items 
        let getItem = getItems.find(obj => obj.itemId == itemId);
        if(getItem){
            const ItemIndex = getVoucherArray[index].items.findIndex(object => {
                return object.itemId === itemId;
              });
            getVoucherArray[index].items[ItemIndex].quantity += 1;
        }else {
            getVoucherArray[index].items.push(item);
        }
    }else {
        getVoucherArray[index].items = [item];
        console.log(getVoucherArray);
    }
    localStorage.setItem("vouchers", JSON.stringify(getVoucherArray));
    checkBtn(SELECTEDCHECK);
}

// delete Item
function delteItem(){

}

$(window).load(function(){
        // uuid
        function generate() {
              return Math.floor((1 + Math.random()) * 0x10000)
                  .toString(16)
                  .substring(1);
        }
    
        function getVouchers(){
            let getVoucherStr = localStorage.getItem("vouchers");
            let getVoucherArray = JSON.parse(getVoucherStr);
            $( "#customer-check" ).empty();
            $.each( getVoucherArray, function( i, item ) {       
                var newListItem = `<li class="check_customer_name list-group-item d-flex justify-content-between align-items-center pe-0 py-0">` + item['customerName'] + 
                ` <button id="check-voucher" class="btn btn-sm text-info cus_check_btn" 
                onclick="checkBtn('${item['id']}')" >Check</button></li>`; 
                $( "#customer-check" ).append( newListItem );
             
            });
            if(getVoucherArray){
                checkBtn(getVoucherArray[0]['id']);
            }
        }
    
        
    
        getVouchers();
        
        // add button
        $( "#voucher-add" ).on( "click", function() {
            let customerName = $('#voucher-select-cust').find(":selected").text();
            uuid = generate();
            let voucher = {
                id: uuid,
                customerName: customerName,
            };
          
            if (localStorage.getItem("vouchers") === null) {
                let voucherArray = [];
                voucherArray.push(voucher);
                let voucherStr = JSON.stringify(voucherArray);
    
                localStorage.setItem("vouchers", voucherStr);
            }else{
                let getVoucherStr = localStorage.getItem("vouchers");
                let getVoucherArray = JSON.parse(getVoucherStr);
                getVoucherArray.push(voucher);
                let voucherStr = JSON.stringify(getVoucherArray);
                localStorage.setItem("vouchers", voucherStr);
            }
            getVouchers();
          });   
});