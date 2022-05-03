var SELECTEDCHECK = "";
var ALLTOTAL = 0;


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
    
    document.getElementById('voucher-date').valueAsDate = new Date();
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
            <button  class="btn btn-primary voucher-btn"  onclick="decreaseItem(${item['itemId']}, '${item['source']}')">-</button>
            ${item['quantity']}
            <button class="btn btn-primary voucher-btn" onclick="increaseItem(${item['itemId']}, '${item['source']}')">+</button>
        </td>
        <td>
            ${item['itemPrice']} Ks
        </td>
        <td>
            ${item['source'].charAt(0).toUpperCase() + item['source'].slice(1)}
        </td>
        <td>
            ${item['itemPrice']* item['quantity']} Ks
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
            // console.log('in');
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
            ${item['staffPct'] === null ? '0': item['staffPct']} %
        </td>
        <td>
            ${item['staffAmount']} Ks
        </td>
        <td>
            ${item['servicePrice']} Ks
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
    ALLTOTAL = total;
    $('#total-amount').val(total);
    voucherPct = $('#voucher-discount').val();
    paid = total -((voucherPct/100)*total);
    $('#voucher-paid').val(paid);
    
}

// get voucher
function getVouchers(){
    let getVoucherStr = localStorage.getItem("vouchers");
    let getVoucherArray = JSON.parse(getVoucherStr);
    if(getVoucherArray.length == 0){
        $( "#customer-check" ).empty();
        $( "#items-table" ).empty();
        $( "#service-table" ).empty();
        $( "#voucher-id" ).empty();
        $( "#customer-name" ).empty();
        $( "#total-amount" ).val('');
        $( "#voucher-discount" ).val(0);
        $( "#voucher-paid" ).val('');
        $('#voucher-remark').val('');
        $('#half-payment').prop('checked', false); 
        $("#payment").val('cash');
        document.getElementById('voucher-date').valueAsDate = new Date();

        return;
    }
    $('#item-search').val('');
    $("#show-items").removeClass("d-none");
    $("#get-show-items").addClass("d-none");


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

// increase item 
function increaseItem(itemId, source){
    let getVoucherArray = getLocalstorage();
    const index = getVoucherArray.findIndex(object => {
        return object.id === SELECTEDCHECK;
      });
      const itemIndex = getVoucherArray[index].items.findIndex(object => {
        return object.itemId == itemId && object.source == source;
    });
    getVoucherArray[index].items[itemIndex].quantity += 1;
    
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
        delteItem(itemId, source);
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
function findWithAttr(array, attr, value) {
    let indexs = [];
    for(var i = 0; i < array.length; i += 1) {
        if(array[i][attr] === value) {
            indexs.push(i);
        }
    }
    return indexs;
}

function addService(serviceId, serviceName, servicePrice, normalPct, namePct){

    var staff = $('#staff-select').val().split(',');

    let allServices = getVoucherById(SELECTEDCHECK).services;
    let staffCount = 1;

    let getVoucherArray = getLocalstorage();
    const index = getVoucherArray.findIndex(object => {
        return object.id === SELECTEDCHECK;
    });

    if(getVoucherArray[index].hasOwnProperty('services')){
        var indexs = findWithAttr(allServices, 'serviceName', serviceName);
        if(indexs.length != 0){
            staffCount = indexs.length + 1;
        }
    }

    var nameCheckbox = $('#name-checkbox').is(':checked');
    var staffPct = normalPct;
    if(nameCheckbox){
        staffPct = namePct/ staffCount;
    }else{
        staffPct = normalPct / staffCount;
    }
    staffPct = staffPct.toFixed(2);
    var staffAmount = Math.floor((staffPct/100)*servicePrice);
    
    var service = {
        serviceId,
        serviceName,
        servicePrice,
        staffName: staff[0],
        staffId: staff[1],
        staffPct,
        staffAmount,
        normalPct,
        namePct,
        nameCheckbox,
    }
    
    if(getVoucherArray[index].hasOwnProperty('services')){
        if(indexs.length != 0){
            indexs.forEach(function(sindex, i) {
                getVoucherArray[index].services[sindex]['staffPct']= staffPct;
                getVoucherArray[index].services[sindex]['staffAmount']= staffAmount;
            });
        }
    }

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
function removeServiceidFormArr(array, value){
    var index = array.indexOf(value);
    if (index !== -1) {
        array.splice(index, 1);
    }
    return array;
}

function increaseStaffPct(getVoucherArray, index, serviceIndex){
    let serviceName = getVoucherArray[index].services[serviceIndex].serviceName;
    let nameCheckbox = getVoucherArray[index].services[serviceIndex].nameCheckbox;
    let normalPct = getVoucherArray[index].services[serviceIndex].normalPct;
    let namePct = getVoucherArray[index].services[serviceIndex].namePct;
    let servicePrice = getVoucherArray[index].services[serviceIndex].servicePrice;

    let allServices = getVoucherById(SELECTEDCHECK).services;
    let indexs = findWithAttr(allServices, 'serviceName', serviceName);
    let staffCount = indexs.length -1;
    indexs = removeServiceidFormArr(indexs, serviceIndex);

    var staffPct = normalPct;
    if(nameCheckbox){
        staffPct = namePct/ staffCount;
    }else{
        staffPct = normalPct / staffCount;
    }
    staffPct = staffPct.toFixed(2);
    var staffAmount = Math.floor((staffPct/100)*servicePrice);

    if(indexs.length != 0){
        indexs.forEach(function(sindex, i) {
            getVoucherArray[index].services[sindex]['staffPct']= staffPct;
            getVoucherArray[index].services[sindex]['staffAmount']= staffAmount;
        });
    }
}

function delteService(serviceId, staffId){
    let getVoucherArray = getLocalstorage();
    const index = getVoucherArray.findIndex(object => {
        return object.id === SELECTEDCHECK;
    });
    const serviceIndex = getVoucherArray[index].services.findIndex(object => {
        return object.serviceId == serviceId && object.staffId == staffId;
    });

 
    increaseStaffPct(getVoucherArray, index, serviceIndex);
    getVoucherArray[index].services.splice(serviceIndex, 1);
    localStorage.setItem("vouchers", JSON.stringify(getVoucherArray));
    checkBtn(SELECTEDCHECK);
}

// save voucher
function voucherSave(){
    let voucher = getVoucherById(SELECTEDCHECK);
    let date = $( "#voucher-date" ).val();

    let voucherData = voucher;
    voucherData.date = date; 
    voucherData.total = ALLTOTAL;   
    voucherData.paid =  $('#voucher-paid').val();
    voucherData.payment = $('#payment').val();
    voucherData.halfPayment = $('#half-payment').is(':checked') ? 1: 0;
    voucherData.discount=  $('#voucher-discount').val();
    voucherData.remark = $('#voucher-remark').val();
    voucherData._token = $('meta[name="csrf-token"]').attr('content');

    if(voucherData.paid == 0){
        return;
    }
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: "/voucher",
        type: "post",
        dateType: "JSON",
        // contentType: 'application/json',
        data: voucherData,
        success:function(data){
            localStorage.setItem("printvoucher", JSON.stringify(voucherData));
            deleteVoucher();
            window.location.replace("/printvoucher");
        },
    });
}

// voucher discount
function voucherDiscount(){
    let total = $('#total-amount').val();
    voucherPct = $('#voucher-discount').val();
    paid = total -((voucherPct/100)*total);
    $('#voucher-paid').val(paid); 
}

// item searched
function itemSearch(){
    let search = $('#item-search').val();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "/getitems",
            type: "get",
            data: {searched: search},
            success:function(data){
                // console.log(data);
                if(search == null || search == ""){
                    $("#show-items").removeClass( "d-none" );
                    $("#get-show-items").addClass( "d-none" );
                }else{
                    $("#show-items").addClass( "d-none" );
                    $("#get-show-items").removeClass( "d-none" );
                }
                $( "#get-show-items" ).empty();
                $.each( data, function( i, item ) { 
                    var newListItem = `
                    <div class="col-4 item-btn-wapper mb-2">
                        <button class="item-button btn btn-secondary"
                        onclick="addItem('${item['id']}', '${item['name']}', '${item['price']}')">
                            ${item['name']}
                        </button>
                    </div>
                    `; 
                    $( "#get-show-items" ).append( newListItem );
                });
            },
        });
}

// service searched
function serviceSearch(){
    let search = $('#service-search').val();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "/getservices",
            type: "get",
            data: {searched: search},
            success:function(data){
                // console.log(data);
                if(search == null || search == ""){
                    $("#show-services").removeClass( "d-none" );
                    $("#get-show-services").addClass( "d-none" );
                }else{
                    $("#show-services").addClass( "d-none" );
                    $("#get-show-services").removeClass( "d-none" );
                }
                $( "#get-show-services" ).empty();
                $.each( data, function( i, service ) { 
                    var newListItem = `
                    <div class="col-4 service-btn-wapper mb-2">
                        <button class="service-button btn btn-secondary"
                        onclick="addService('${service['id']}', '${service['name']}',
                        '${service['price']}', '${service['normal_pct']}', '${service['name_pct']}')">
                            ${service['name']}
                        </button>
                    </div>
                    `; 
                    $( "#get-show-services" ).append( newListItem );
                });
            },
        });
}

$(document).ready(function() {
    $('#voucher-select-cust').select2();
});

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
            let customerId = $('#voucher-select-cust').val();
            uuid = generate();
            let voucher = {
                id: uuid,
                customerName: customerName,
                customerId: customerId,
            };
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