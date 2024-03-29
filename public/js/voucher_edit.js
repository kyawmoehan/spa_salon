const LOCALSTORAGENAME = "editvoucher";

// get local storage
function getLocalstorage() {
    let getVoucherStr = localStorage.getItem(LOCALSTORAGENAME);
    let getVoucherArray = JSON.parse(getVoucherStr);
    return getVoucherArray;
}

// get corropesanding voucher
function checkBtn(id) {
    SELECTEDCHECK = id;
    let total = 0;

    let voucher = getLocalstorage();

    let voucherId = document.getElementById("voucher-id");
    voucherId.innerHTML = voucher["id"];
    let customerName = document.getElementById("customer-name");
    customerName.innerHTML = voucher["customerName"];

    // item table
    let items = voucher.items;
    $("#items-table").empty();
    $.each(items, function (i, item) {
        total += item["itemPrice"] * item["quantity"];
        var newListItem = `
        <tr>
        <td class="text-dark"><b>${i + 1}</b></td>
        <td>
            ${item["itemName"]}
        </td>
        <td>
            <button  class="btn btn-primary voucher-btn" onclick="decreaseItem(${
                item["itemId"]
            }, '${item["source"]}')">-</button>
            ${item["quantity"]}
            <button class="btn btn-primary voucher-btn" onclick="increaseItem(${
                item["itemId"]
            }, '${item["source"]}')">+</button>
        </td>
        <td>
            ${item["itemPrice"]}
        </td>
        <td>
            ${item["source"].charAt(0).toUpperCase() + item["source"].slice(1)}
        </td>
        <td>
            ${item["itemPrice"] * item["quantity"]}
        </td>
        <td>
            <a class="btn btn-sm text-danger" 
            onclick="delteItem(${item["itemId"]},'${item["source"]}')">
                <i class="fa fa-trash"></i>
            </a>
        </td>
    </tr>
        `;
        $("#items-table").append(newListItem);
    });

    // staff table
    let services = voucher.services;
    let servicesArray = [];
    $("#service-table").empty();
    $.each(services, function (i, item) {
        if (servicesArray.includes(item["serviceName"])) {
            // console.log('in');
        } else {
            servicesArray.push(item["serviceName"]);
            total += item["servicePrice"] * 1;
        }

        var newListItem = `
        <tr>
        <td class="text-dark"><b>${i + 1}</b></td>
        <td>
            ${item["serviceName"]}
        </td>
        <td>
            ${item["staffName"]}
        </td>
        <td>
            ${item["staffPct"]}
        </td>
        <td>
            <input type="number" id="${item["serviceId"]}-${
            item["staffId"]
        }"  onkeyup="editStaffAmount(${item["serviceId"]}, ${
            item["staffId"]
        })" value="${item["staffAmount"]}" > Ks
        </td>
        <td>
            ${item["servicePrice"]}
        </td>
        <td>
            <a class="btn btn-sm text-danger" 
            onclick="delteService(${item["serviceId"]}, ${item["staffId"]})">
                <i class="fa fa-trash"></i>
            </a>
        </td>
    </tr>
        `;
        $("#service-table").append(newListItem);
    });
    // total amount
    ALLTOTAL = total;
    $("#total-amount").val(total);
    // voucherPct = $("#voucher-discount").val();
    // paid = total - (voucherPct / 100) * total;
    // $("#voucher-paid").val(paid);
    voucherCrash = $("#voucher-discount-crash").val();
    voucherPct = $("#voucher-discount").val();
    paid = total - (voucherPct / 100) * total - voucherCrash;
    $("#voucher-paid").val(paid);
}
// get voucher
function getVouchers() {
    let getVoucherStr = localStorage.getItem(LOCALSTORAGENAME);
    let getVoucherArray = JSON.parse(getVoucherStr);
    if (getVoucherArray.length == 0) {
        $("#customer-check").empty();
        $("#items-table").empty();
        $("#service-table").empty();
        $("#voucher-id").empty();
        $("#customer-name").empty();
        $("#total-amount").val("");
        $("#voucher-discount").val(0);
        $("#voucher-paid").val("");
        $("#voucher-remark").val("");
        $("#half-payment").prop("checked", false);
        $("#payment").val("cash");
        document.getElementById("voucher-date").valueAsDate = new Date();

        return;
    }
    $("#item-search").val("");
    $("#show-items").removeClass("d-none");
    $("#get-show-items").addClass("d-none");

    checkBtn(getVoucherArray["id"]);
}

// delete voucher
function deleteVoucher() {
    localStorage.removeItem(LOCALSTORAGENAME);
}

// add item
function addItem(itemId, itemName, itemPrice) {
    var source = $("#item-from").val();
    var item = {
        itemId,
        itemName,
        itemPrice,
        quantity: 1,
        source,
    };
    let getVoucherArray = getLocalstorage();

    if (getVoucherArray.hasOwnProperty("items")) {
        let getItems = getVoucherArray.items;
        let getItem = getItems.find(
            (obj) => obj.itemId == itemId && obj.source == source
        );
        if (getItem) {
            const ItemIndex = getVoucherArray.items.findIndex((object) => {
                return object.itemId == itemId && object.source == source;
            });
            console.log(ItemIndex);
            getVoucherArray.items[ItemIndex].quantity += 1;
        } else {
            getVoucherArray.items.push(item);
        }
    } else {
        getVoucherArray.items = [item];
    }
    localStorage.setItem(LOCALSTORAGENAME, JSON.stringify(getVoucherArray));
    checkBtn(SELECTEDCHECK);
}

// increase item
function increaseItem(itemId, source) {
    let getVoucherArray = getLocalstorage();

    const itemIndex = getVoucherArray.items.findIndex((object) => {
        return object.itemId == itemId && object.source == source;
    });
    getVoucherArray.items[itemIndex].quantity += 1;

    localStorage.setItem(LOCALSTORAGENAME, JSON.stringify(getVoucherArray));
    checkBtn(SELECTEDCHECK);
}

// decrease item
function decreaseItem(itemId, source) {
    let getVoucherArray = getLocalstorage();
    const itemIndex = getVoucherArray.items.findIndex((object) => {
        return object.itemId == itemId && object.source == source;
    });
    getVoucherArray.items[itemIndex].quantity -= 1;
    if (getVoucherArray.items[itemIndex].quantity == 0) {
        delteItem(itemId, source);
        return;
    }
    localStorage.setItem(LOCALSTORAGENAME, JSON.stringify(getVoucherArray));
    checkBtn(SELECTEDCHECK);
}

// delete Item
function delteItem(itemId, source) {
    let getVoucherArray = getLocalstorage();
    const itemIndex = getVoucherArray.items.findIndex((object) => {
        return object.itemId == itemId && object.source == source;
    });
    getVoucherArray.items.splice(itemIndex, 1);
    localStorage.setItem(LOCALSTORAGENAME, JSON.stringify(getVoucherArray));
    checkBtn(SELECTEDCHECK);
}

// add service
function findWithAttr(array, attr, value) {
    let indexs = [];
    for (var i = 0; i < array.length; i += 1) {
        if (array[i][attr] === value) {
            indexs.push(i);
        }
    }
    return indexs;
}

function addService(serviceId, serviceName, servicePrice, normalPct, namePct) {
    var staff = $("#staff-select").val().split(",");

    let allServices = getLocalstorage().services;
    let staffCount = 1;

    let getVoucherArray = getLocalstorage();

    if (getVoucherArray.hasOwnProperty("services")) {
        var indexs = findWithAttr(allServices, "serviceName", serviceName);
        if (indexs.length != 0) {
            staffCount = indexs.length + 1;
        }
    }

    var nameCheckbox = $("#name-checkbox").is(":checked");
    var staffPct = normalPct;
    if (nameCheckbox) {
        staffPct = namePct / staffCount;
    } else {
        staffPct = normalPct / staffCount;
    }
    staffPct = staffPct.toFixed(2);
    var staffAmount = Math.floor((staffPct / 100) * servicePrice);

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
    };

    if (getVoucherArray.hasOwnProperty("services")) {
        if (indexs.length != 0) {
            indexs.forEach(function (sindex, i) {
                getVoucherArray.services[sindex]["staffPct"] = staffPct;
                getVoucherArray.services[sindex]["staffAmount"] = staffAmount;
            });
        }
    }

    if (getVoucherArray.hasOwnProperty("services")) {
        let getServices = getVoucherArray.services;
        getVoucherArray.services.push(service);
    } else {
        getVoucherArray.services = [service];
    }
    localStorage.setItem(LOCALSTORAGENAME, JSON.stringify(getVoucherArray));
    checkBtn(SELECTEDCHECK);
}

// delete service
function removeServiceidFormArr(array, value) {
    var index = array.indexOf(value);
    if (index !== -1) {
        array.splice(index, 1);
    }
    return array;
}

function increaseStaffPct(getVoucherArray, serviceIndex) {
    let serviceName = getVoucherArray.services[serviceIndex].serviceName;
    let nameCheckbox = getVoucherArray.services[serviceIndex].nameCheckbox;
    let normalPct = getVoucherArray.services[serviceIndex].normalPct;
    let namePct = getVoucherArray.services[serviceIndex].namePct;
    let servicePrice = getVoucherArray.services[serviceIndex].servicePrice;

    let allServices = getLocalstorage().services;
    let indexs = findWithAttr(allServices, "serviceName", serviceName);
    let staffCount = indexs.length - 1;
    indexs = removeServiceidFormArr(indexs, serviceIndex);

    var staffPct = normalPct;
    if (nameCheckbox) {
        staffPct = namePct / staffCount;
    } else {
        staffPct = normalPct / staffCount;
    }
    staffPct = staffPct.toFixed(2);
    var staffAmount = Math.floor((staffPct / 100) * servicePrice);

    if (indexs.length != 0) {
        indexs.forEach(function (sindex, i) {
            getVoucherArray.services[sindex]["staffPct"] = staffPct;
            getVoucherArray.services[sindex]["staffAmount"] = staffAmount;
        });
    }
}

function delteService(serviceId, staffId) {
    let getVoucherArray = getLocalstorage();

    const serviceIndex = getVoucherArray.services.findIndex((object) => {
        return object.serviceId == serviceId && object.staffId == staffId;
    });

    increaseStaffPct(getVoucherArray, serviceIndex);
    getVoucherArray.services.splice(serviceIndex, 1);
    localStorage.setItem(LOCALSTORAGENAME, JSON.stringify(getVoucherArray));
    checkBtn(SELECTEDCHECK);
}

function editStaffAmount(serviceId, staffId) {
    const changeAmount = $(`#${serviceId}-${staffId}`).val();

    console.log(changeAmount);
    let getVoucherArray = getLocalstorage();

    const serviceIndex = getVoucherArray.services.findIndex((object) => {
        return object.serviceId == serviceId && object.staffId == staffId;
    });

    getVoucherArray.services[serviceIndex]["staffAmount"] = changeAmount;

    console.log(getVoucherArray);
    localStorage.setItem(LOCALSTORAGENAME, JSON.stringify(getVoucherArray));
    checkBtn(SELECTEDCHECK);
}

// save voucher
function voucherSave() {
    let voucher = getLocalstorage();
    console.log(voucher["voucherId"]);
    let date = $("#voucher-date").val();

    let voucherData = voucher;
    voucherData.date = date;
    voucherData.total = ALLTOTAL;
    voucherData.paid = $("#voucher-paid").val();
    voucherData.paid = $("#voucher-paid").val();
    voucherData.payment = $("#payment").val();
    voucherData.halfPayment = $("#half-payment").is(":checked") ? 1 : 0;
    voucherData.discount = $("#voucher-discount").val() || 0;
    voucherData.discount_crash = $("#voucher-discount-crash").val() || 0;
    voucherData.remark = $("#voucher-remark").val();
    voucherData._token = $('meta[name="csrf-token"]').attr("content");
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    $.ajax({
        url: "/voucher/" + voucherData["voucherId"],
        type: "PATCH",
        dateType: "JSON",
        // contentType: 'application/json',
        data: voucherData,
        success: function (data) {
            console.log(data);
            deleteVoucher();
            window.location.replace("/voucher");
        },
    });
}

// voucher discount
function voucherDiscount() {
    let total = ALLTOTAL;
    let paid = 0;
    voucherPct = $("#voucher-discount").val();
    voucherCrash = $("#voucher-discount-crash").val();
    paid = total - (voucherPct / 100) * total;
    if (voucherCrash > 0) {
        paid = total - (voucherPct / 100) * total - voucherCrash;
    }
    $("#voucher-paid").val(paid);
}

// voucher discount crash
function voucherDiscountCrash() {
    let total = ALLTOTAL;
    let crash = 0;
    voucherCrash = $("#voucher-discount-crash").val();
    voucherPct = $("#voucher-discount").val();
    crash = total - voucherCrash;
    if (voucherPct > 0) {
        crash = total - (voucherPct / 100) * total - voucherCrash;
    }
    $("#voucher-paid").val(crash);
}

// item searched
function itemSearch() {
    let search = $("#item-search").val();
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    $.ajax({
        url: "/getitems",
        type: "get",
        data: { searched: search },
        success: function (data) {
            // console.log(data);
            if (search == null || search == "") {
                $("#show-items").removeClass("d-none");
                $("#get-show-items").addClass("d-none");
            } else {
                $("#show-items").addClass("d-none");
                $("#get-show-items").removeClass("d-none");
            }
            $("#get-show-items").empty();
            $.each(data, function (i, item) {
                var newListItem = `
                    <div class="col-4 item-btn-wapper mb-2">
                        <button class="item-button btn btn-secondary"
                        onclick="addItem('${item["id"]}', '${item["name"]}', '${item["price"]}')">
                            ${item["name"]}
                        </button>
                    </div>
                    `;
                $("#get-show-items").append(newListItem);
            });
        },
    });
}

// service searched
function serviceSearch() {
    let search = $("#service-search").val();
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    $.ajax({
        url: "/getservices",
        type: "get",
        data: { searched: search },
        success: function (data) {
            // console.log(data);
            if (search == null || search == "") {
                $("#show-services").removeClass("d-none");
                $("#get-show-services").addClass("d-none");
            } else {
                $("#show-services").addClass("d-none");
                $("#get-show-services").removeClass("d-none");
            }
            $("#get-show-services").empty();
            $.each(data, function (i, service) {
                var newListItem = `
                    <div class="col-4 service-btn-wapper mb-2">
                        <button class="service-button btn btn-secondary"
                        onclick="addService('${service["id"]}', '${service["name"]}',
                        '${service["price"]}', '${service["normal_pct"]}', '${service["name_pct"]}')">
                            ${service["name"]}
                        </button>
                    </div>
                    `;
                $("#get-show-services").append(newListItem);
            });
        },
    });
}

$(window).load(function () {
    // store data
    let getData = $("#all-data").val();
    localStorage.setItem(LOCALSTORAGENAME, getData);
    getVouchers();

    // exit
    window.onbeforeunload = function (e) {
        deleteVoucher();
    };
});
