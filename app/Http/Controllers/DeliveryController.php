<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use App\Models\City;
use App\Models\Province;
use App\Models\Wards;
use App\Models\Feeship;

class DeliveryController extends Controller
{
    public function delivery(Request $request)
    {
        $city = City::orderBy('matp', 'ASC')->get();

        return view('admin.delivery.add_delivery')->with(compact('city'));
    }

    public function select_delivery(Request $request)
    {
        $data = $request->all();
        if ($request->action == 'city') {
            $select_province = Province::where('matp', $data['ma_id'])
            ->orderBy('maqh', 'ASC')->get();
            $output = '<option value="">--- Chọn quận huyện ---</option>';
            foreach ($select_province as $key => $province) {
                $output .= '<option value="' . $province->maqh . '">' . $province->name_quanhuyen . '</option>';
            }
            echo $output;
        } elseif ($request->action == 'province') {
            $select_wards = Wards::where('maqh', $data['ma_id'])->orderBy('xaid', 'ASC')->get();
            $output = '<option value="">--- Chọn xã phường ---</option>';
            foreach ($select_wards as $ward) {
                $output .= '<option value="' . $ward->xaid . '">' . $ward->name_xaphuong . '</option>';
            }
            echo $output;
        }
    }

    public function insert_delivery(Request $request)
    {
        $data = $request->all();
        $feeship = new Feeship();
        $feeship->fee_matp = $data['city'];
        $feeship->fee_maqh = $data['province'];
        $feeship->fee_xaid = $data['wards'];
        $feeship->fee_feeship = $data['fee_ship'];
        $feeship->save();
        // return Redirect::to('all-delivery');
    }

    public function select_feeship(){
		$feeship = Feeship::with(['city', 'province', 'wards'])->orderby('fee_id', 'DESC')->get();

		$output = '';
		$output .= '<div class="table-responsive">  
			<table class="table table-bordered">
				<thead> 
					<tr>
						<th>Tên thành phố</th>
						<th>Tên quận huyện</th> 
						<th>Tên xã phường</th>
						<th>Phí ship</th>
					</tr>  
				</thead>
				<tbody>
				';

				foreach($feeship as $key => $fee){
                    // $city_name = $fee->city ? $fee->city->name_city : 'N/A';
                    // $province_name = $fee->province ? $fee->province->name_quanhuyen : 'N/A';
                    // $wards_name = $fee->wards ? $fee->wards->name_xaphuong : 'N/A';
				$output.='
					<tr>
						<td>'.($fee->city?->name_city ?? 'N/A').'</td>
                        <td>'.($fee->province?->name_quanhuyen ?? 'N/A').'</td>
                        <td>'.($fee->wards?->name_xaphuong ?? 'N/A').'</td>
						<td contenteditable data-feeship_id="'.$fee->fee_id.'" class="fee_feeship_edit">'.number_format($fee->fee_feeship,0,',','.').'</td>
					</tr>
					';
				}

				$output.='		
				</tbody>
				</table></div>
				';
                return $output;	
	}

    public function update_feeship(Request $request){
        $data = $request->all();
        $fee_ship = Feeship::find($data['feeship_id']);
        $fee_value = rtrim($data['fee_value'], '.');
        $fee_ship->fee_feeship = $fee_value;
        $fee_ship->save();
    }
}
