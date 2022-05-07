<table class="table table-hover progress-table text-center" id="myTable1">
    <thead class="text-uppercase">
        <tr>
            <th scope="col">No</th>
            <th scope="col">Month</th>
            <th scope="col">Voucher Total</th>
            <th scope="col">General Cost</th>
            <th scope="col">Usage Item Cost</th>
            <th scope="col">Salary Cost</th>
            <th scope="col">Profit</th>
        </tr>
    </thead>
    <tbody class="" id="jshow-profit">

    </tbody>
    <tbody class="" id="show-profit">
       @foreach($yearProfits as $key=>$profit)
        <tr>
            <td>{{$key+1}}</td>
            <td>{{$months[$key]}}</td>
            <td>{{$profit['voucherCost']}} Ks</td>
            <td>{{$profit['generalCost']}} Ks</td>
            <td>{{$profit['usageCost']}} Ks</td>
            <td>{{$profit['salaryCost']}} Ks</td>
            <td>{{$profit['profit']}} Ks</td>
        </tr>
       @endforeach
    </tbody>
</table>