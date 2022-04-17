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
    let total = 0;
    
    let voucher = getVoucherById(id);
    
    let voucherId = document.getElementById('voucher-id');
    voucherId.innerHTML = voucher['id'];
    let customerName = document.getElementById('customer-name');
    customerName.innerHTML = voucher['customerName'];
    
    // item table
    let items = voucher.items;
    $( "#items-table" ).empty();
    $.each( items, function( i, item ) { 
        total += item['itemPrice']* item['quantity'];
        var newListItem = `
        <tr>
        <td class="text-dark"><b>${i+1}</b></td>
        <td>
            ${item['itemName']}
        </td>
        <td>
            <button onclick="decreaseItem(${item['itemId']}, '${item['source']}')">-</button>
            ${item['quantity']}
        </td>
        <td>
            ${item['itemPrice']}
        </td>
        <td>
            ${item['source']}
        </td>
        <td>
            ${item['itemPrice']* item['quantity']}
        </td>
        <td>
            <a class="btn btn-sm text-danger" 
            onclick="delteItem(${item['itemId']},'${item['source']}')">
                <i class="fa fa-trash"></i>
            </a>
        </td>
    </tr>
        `; 
        $( "#items-table" ).append( newListItem );
     
    });

    // staff table
    let services = voucher.services;
    let servicesArray = [];
    $( "#service-table" ).empty();
    $.each( services, function( i, item ) {
        if(servicesArray.includes(item['serviceName'])){
            console.log('in');
        }else{
            servicesArray.push(item['serviceName']);
            total += item['servicePrice'] * 1;
        }
        
        var newListItem = `
        <tr>
        <td class="text-dark"><b>${i+1}</b></td>
        <td>
            ${item['serviceName']}
        </td>
        <td>
            ${item['staffName']}
        </td>
        <td>
            ${item['staffPct']}
        </td>
        <td>
            ${item['staffAmount']}
        </td>
        <td>
            ${item['servicePrice']}
        </td>
        <td>
            <a class="btn btn-sm text-danger" 
            onclick="delteService(${item['serviceId']}, ${item['staffId']})">
                <i class="fa fa-trash"></i>
            </a>
        </td>
    </tr>
        `; 
        $( "#service-table" ).append( newListItem );
     
    });
    // total amount
    $('#total-amount').val(total);
    
}

// get voucher
function getVouchers(){
    let getVoucherStr = localStorage.getItem("vouchers");
    let getVoucherArray = JSON.parse(getVoucherStr);
    if(getVoucherArray.length == 0){
        $( "#customer-check" ).empty();
        return;
    }
    $( "#customer-check" ).empty();
    $.each( getVoucherArray, function( i, item ) {       
        var newListItem = `<li class="check_customer_name list-group-item d-flex justify-content-between align-items-center pe-0 py-0">` + item['customerName'] + 
        ` <button id="check-voucher" class="btn btn-sm text-info cus_check_btn" 
        onclick="checkBtn('${item['id']}')" >Check</button></li>`; 
        $( "#customer-check" ).append( newListItem );
    });
    checkBtn(getVoucherArray[0]['id']);
}
// delete voucher
function deleteVoucher(){
    let getVoucherArray = getLocalstorage();
    const index = getVoucherArray.findIndex(object => {
        return object.id === SELECTEDCHECK;
    });
    getVoucherArray.splice(index, 1);
    localStorage.setItem("vouchers", JSON.stringify(getVoucherArray));
    if(getVoucherArray.length !== 0){
        checkBtn(getVoucherArray[0]['id']);
    }
    getVouchers();
}

// add item
function addItem(itemId, itemName, itemPrice){
    var source = $('#item-from').val();
    var item = {
        itemId,
        itemName,
        itemPrice,
        quantity: 1,
        source,
    }
    let getVoucherArray = getLocalstorage();
    const index = getVoucherArray.findIndex(object => {
        return object.id === SELECTEDCHECK;
    });

    if(getVoucherArray[index].hasOwnProperty('items')){
        let getItems =  getVoucherArray[index].items 
        let getItem = getItems.find(obj => obj.itemId == itemId && obj.source == source);
        if(getItem){
            const ItemIndex = getVoucherArray[index].items.findIndex(object => {
                return object.itemId == itemId  && object.source == source;
              });
              console.log(ItemIndex);
            getVoucherArray[index].items[ItemIndex].quantity += 1;
        }else {
            getVoucherArray[index].items.push(item);
        }
    }else {
        getVoucherArray[index].items = [item];
    }
    localStorage.setItem("vouchers", JSON.stringify(getVoucherArray));
    checkBtn(SELECTEDCHECK);
}

// decrease item
function decreaseItem(itemId, source){
    let getVoucherArray = getLocalstorage();
    const index = getVoucherArray.findIndex(object => {
        return object.id === SELECTEDCHECK;
      });
      const itemIndex = getVoucherArray[index].items.findIndex(object => {
        return object.itemId == itemId && object.source == source;
    });
    getVoucherArray[index].items[itemIndex].quantity -= 1;
    if(getVoucherArray[index].items[itemIndex].quantity == 0){
        delteItem(itemId);
        return;
    }
    localStorage.setItem("vouchers", JSON.stringify(getVoucherArray));
    checkBtn(SELECTEDCHECK);
}

// delete Item
function delteItem(itemId, source){
    let getVoucherArray = getLocalstorage();
    const index = getVoucherArray.findIndex(object => {
        return object.id === SELECTEDCHECK;
    });
    const itemIndex = getVoucherArray[index].items.findIndex(object => {
        return object.itemId == itemId && object.source == source;
    });
    getVoucherArray[index].items.splice(itemIndex, 1);
    localStorage.setItem("vouchers", JSON.stringify(getVoucherArray));
    checkBtn(SELECTEDCHECK);
}


// add service
function addService(serviceId, serviceName, servicePrice){
    var staff = $('#staff-select').val().split(',');
    var staffPct = $('#staff-pct').val();
    var staffAmount = (staffPct/100)*servicePrice;
    var service = {
        serviceId,
        serviceName,
        servicePrice,
        staffName: staff[0],
        staffId: staff[1],
        staffPct,
        staffAmount,
    }
    let getVoucherArray = getLocalstorage();
    const index = getVoucherArray.findIndex(object => {
        return object.id === SELECTEDCHECK;
      });

    if(getVoucherArray[index].hasOwnProperty('services')){
        let getServices =  getVoucherArray[index].services;
        getVoucherArray[index].services.push(service);
    }else {
        getVoucherArray[index].services = [service];
    }
    localStorage.setItem("vouchers", JSON.stringify(getVoucherArray));
    checkBtn(SELECTEDCHECK);
}

// delete service
function delteService(serviceId, staffId){
    let getVoucherArray = getLocalstorage();
    const index = getVoucherArray.findIndex(object => {
        return object.id === SELECTEDCHECK;
    });
    const serviceIndex = getVoucherArray[index].services.findIndex(object => {
        return object.serviceId == serviceId && object.staffId == staffId;
    });
    getVoucherArray[index].services.splice(serviceIndex, 1);
    localStorage.setItem("vouchers", JSON.stringify(getVoucherArray));
    checkBtn(SELECTEDCHECK);
}

$(window).load(function(){
        // uuid
        function generate() {
              return Math.floor((1 + Math.random()) * 0x10000)
                  .toString(16)
                  .substring(1);
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
          console.log(localStorage.getItem('vouchers'))
            if (localStorage.getItem("vouchers").length === 0) {
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
            checkBtn(uuid);
          });   
});