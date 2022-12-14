<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Helpers;

class Package extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $packages_description = [];
        foreach ($this->package as $key => $value) {
            array_push($packages_description,$value->description);
        }

        $packages_description = implode (", ",   $packages_description);
        // $bill_to_name = $this->bill_to_id == $this->sender->id ? $this->sender->name : $this->receiver->name;
        return [
            'id' => $this->id,
            'shipment_date'=> $this->date,
            'packages'=> $this->package,
            'shipment_sender_address' => $this->sender->address,
            'shipment_delivery_address' => $this->delivery_address,
            'shipment_docket_no' => $this->docket_no,
            'shipment_freight_invoice_number' => $this->freight_invoice_number,
            'shipment_charge_total' => $this->charge_total,
            'shipment_sender_name' => $this->sender->name,
            'shipment_receiver_name' => $this->receiver->name,
            'shipment_sender_gst' => $this->sender->gst,
            'shipment_receiver_gst' => $this->receiver->gst,
            'packages_description' =>    $packages_description,
            'shipment_payment_type' => $this->payment_type,
            'shipment_tds_amount' => $this->tds_amount,
            'shipment_charge_Insurance' => $this->charge_Insurance,
            'shipment_bill_to' => $this->bill_to,
            // 'shipment_bill_name' =>  $bill_to_name,
            'shipment_transport_driver_vehicle' => $this->transport_driver_vehicle,
          ];
    }

}
