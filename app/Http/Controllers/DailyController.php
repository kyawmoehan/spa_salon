<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Carbon\Carbon;
use App\Models\Service;
use App\Models\Voucher;
use App\Models\ItemVoucher;
use App\Models\VoucherStaff;
use Illuminate\Http\Request;

class DailyController extends Controller
{
    public function getServices()
    {
        $allServices =  VoucherStaff::whereDate('date', '=', Carbon::today())->get();
        $countServices = [];
        $voucherIds = [];
        foreach ($allServices as $service) {
            if (
                array_key_exists($service->voucher_id, $voucherIds) &&
                !in_array($service->service->id, $voucherIds[$service->voucher_id])
            ) {
                array_push($voucherIds[$service->voucher_id], $service->service->id);
            } else if (!array_key_exists($service->voucher_id, $voucherIds)) {
                $voucherIds[$service->voucher_id] = [$service->service->id];
            }
        }

        foreach ($voucherIds as $services) {
            foreach ($services as $service) {

                if (array_key_exists($service, $countServices)) {
                    $countServices[$service] += 1;
                } else {
                    $countServices[$service] = 1;
                }
            }
        }
        return $countServices;
    }

    public function getDatilService($serviceId)
    {
        $service = Service::find($serviceId);
        return $service;
    }

    public function getItems()
    {
        $allSaleItems =  ItemVoucher::whereDate('date', '=', Carbon::today())->get();
        $countItems = [];
        foreach ($allSaleItems as $item) {
            if (array_key_exists($item->item->id, $countItems)) {
                $countItems[$item->item->id] += $item->quantity;
            } else {
                $countItems[$item->item->id] = $item->quantity;
            }
        }

        return $countItems;
    }

    public function getDetailItem($itemId)
    {
        $item = Item::find($itemId);
        return $item;
    }

    public function dailyReport()
    {
        $report = [];

        $report['services'] = [];
        $report['items'] = [];

        $todayServices = $this->getServices();
        foreach ($todayServices as $key => $quantity) {
            $detailService = $this->getDatilService($key);
            array_push($report['services'], [
                'id' => $key,
                'quantity' => $quantity,
                'detail' => $detailService,
            ]);
        }

        $todayItems = $this->getItems();
        foreach ($todayItems as $key => $quantity) {
            $detailItem = $this->getDetailItem($key);
            array_push($report['items'], [
                'id' => $key,
                'quantity' => $quantity,
                'detail' => $detailItem,
            ]);
        }

        return view('report.dailyreport', compact('report'));
    }
}
