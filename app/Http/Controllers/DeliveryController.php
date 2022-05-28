<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\City;
use App\Models\Ward;
use App\Models\District;
use App\Models\Shipfee;

class DeliveryController extends Controller
{
    public function delivery(Request $request){
        $city = City::orderby('matp','ASC')->get();
        return view('admin.delivery.add_delivery')->with(compact('city'));
    }

    public function select_delivery(Request $request){
        $data = $request->all();
        if($data['action']){
            $output = '';
            if($data['action']=="city"){
                $select_district = District::where('matp',$data['ma_id'])->orderby('maqh','ASC')->get();
                $output.='<option>---Choose district---</option>';
                foreach($select_district as $key => $district){
                    $output.='<option value="'.$district->maqh.'">'.$district->district_name.'</option>';
                }
            }
            else{
                $select_ward = Ward::where('maqh',$data['ma_id'])->orderby('xaid','ASC')->get();
                $output.='<option>---Choose ward---</option>';
                foreach($select_ward as $key => $ward){
                    $output.='<option value="'.$ward->xaid.'">'.$ward->ward_name.'</option>';
                }
            }
            echo $output;
        }
    }

    public function insert_delivery(Request $request){
        $data = $request->all();
        $ship_fee = new Shipfee();
        $ship_fee->fee_matp = $data['city'];
        $ship_fee->fee_maqh = $data['district'];
        $ship_fee->fee_xaid = $data['ward'];
        $ship_fee->fee_shipfee = $data['ship_fee'];
        $ship_fee->save();
    }

    public function select_shipfee(){
        $shipfee = Shipfee::orderby('fee_id','DESC')->get();
        $output = '';
        $output .= '<div class="table-responsive">  
            <table class="table table-bordered">
                <thread> 
                    <tr>
                        <th>City name</th>
                        <th>District name</th> 
                        <th>Ward name</th>
                        <th>Shipping fee</th>
                    </tr>  
                </thread>
                <tbody>
                ';

                foreach($shipfee as $key => $fee){

                $output.='
                    <tr>
                        <td>'.$fee->city->city_name.'</td>
                        <td>'.$fee->district->district_name.'</td>
                        <td>'.$fee->ward->ward_name.'</td>
                        <td contenteditable data-shipfee_id="'.$fee->fee_id.'" class="fee_shipfee_edit">'.number_format($fee->fee_shipfee,0,',','.').' USD</td>
                    </tr>
                    ';
                }

                $output.='      
                </tbody>
                </table></div>
                ';

                echo $output;
 
    }
    public function update_delivery(Request $request){
        $data = $request->all();
        $ship_fee = Shipfee::find($data['shipfee_id']);
        $fee_value = rtrim($data['fee_value'],'.');
        $ship_fee->fee_shipfee = $fee_value;
        $ship_fee->save();
    }
}
