<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Helpers;
use Carbon\Carbon;


class Shipment extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
       
        return [
            'id' => $this->id,
            'date'=> $this->date,
            'created_at'=> Carbon::parse($this->created_at)->format('Y-m-d H:m:s'),
            'delivery_address'=> $this->delivery_address,
            'sender_name' => $this->sender->name,
            'sender_address' => $this->sender->address,
            'current_status' => $this->status,
            'docket_no' => $this->docket_no,
            'sender_id' => $this->sender->id,
            // 'balance_amount' => $this->balance_amount,
            'charge_total' => $this->charge_total,
            "balance" => Helpers::getShipmentBalanceAmount($this),
            
           
          ];
    }
}
