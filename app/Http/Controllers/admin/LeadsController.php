<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LeadsController extends Controller
{
    public function index(){
        // Generated by curl-to-PHP: http://incarnate.github.io/curl-to-php/
       
        $str ='9012:1234@http://172.16.0.10/vicidial/lead_report_export.php?DB=&run_export=1&VLC_enabled=&query_date=2019-05-06&end_date=2019-05-18&date_field=call_date&header_row=YES&rec_fields=NONE&custom_fields=YES&call_notes=NO&did_filter=NO&export_fields=EXTENDED&search_archived_data=&campaign[]=WYCSZ&list_id[]=---ALL---&status[]=---ALL---&user_group[]=---ALL---&SUBMIT=SUBMIT';
        $str = str_replace('.', '%2E', $str);
        $str = str_replace('-', '%2D', $str);
  
        $str = str_replace("[","/[",$str);
        $str = str_replace("]","/]",$str);
        echo $str;
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $str );
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Errors:' . curl_error($ch);
        }
        
        curl_close ($ch);
        var_dump($result);

    }
}
