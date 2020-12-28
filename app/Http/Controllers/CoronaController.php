<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Charts\CoronaChart;
use App\Charts\StatChart;
use App\Contact;
use App\Forecast;
use Illuminate\Support\Facades\Http;
use Datatables;
use Illuminate\Support\Facades\DB;

class CoronaController extends Controller
{

    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }
    


    public function provinceChart()
    {
        $per_province=array();
        $name_province=array();
        $y_province=array();
        $sembuh_province=array();
        $mati_province=array();
        $province=collect(Http::get('https://data.covid19.go.id/public/api/prov.json')->json());
        // dd($province['list_data']);
        for($i=0;$i<5;$i++){
            $per_province[]=$province['list_data'][$i];
            $name_province[]=$per_province[$i]['key'];
            $y_province[]=$per_province[$i]['jumlah_kasus'];
            $mati_province[]=$per_province[$i]['jumlah_meninggal'];
            $sembuh_province[]=$per_province[$i]['jumlah_sembuh'];
        }
        $chart_province = array(
            "nama_provinsi" => $name_province,
            "jumlah_kasus" => $y_province,
            "jumlah_mati" => $mati_province,
            "jumlah_sembuh" => $sembuh_province,
        );
        // dd(json_encode($chart_province));
        return response()->json([
            'data'=>$chart_province
        ]);
    }

    public function provinceLowestChart()
    {
        $per_province=array();
        $name_province=array();
        $y_province=array();
        $sembuh_province=array();
        $mati_province=array();
        $province=collect(Http::get('https://data.covid19.go.id/public/api/prov.json')->json());
        $n=0;
        for($i=count($province['list_data'])-5;$i<count($province['list_data']);$i++){
            $per_province[]=$province['list_data'][$i];
            $name_province[]=$per_province[$n]['key'];
            $y_province[]=$per_province[$n]['jumlah_kasus'];
            $mati_province[]=$per_province[$n]['jumlah_meninggal'];
            $sembuh_province[]=$per_province[$n]['jumlah_sembuh'];

            $n++;
        }
        $chart_province = array(
            "nama_provinsi" => $name_province,
            "jumlah_kasus" => $y_province,
            "jumlah_mati" => $mati_province,
            "jumlah_sembuh" => $sembuh_province,
        );
        return response()->json([
            'data'=>$chart_province
        ]);
    }

    public function movingAvg()
    {
        $harian = collect(Http::get('https://apicovid19indonesia-v2.vercel.app/api/indonesia/harian')->json());
        
        $sevenDays=count($harian)-7;
        $n=0;
        for ($i=$sevenDays; $i < count($harian); $i++) { 
            $sembuh[]=$harian[$i]['sembuh'];
            $meninggal[]=$harian[$i]['meninggal'];
            $positif[]=$harian[$i]['positif'];
            $dataSembuh[$n]['sembuh']=$harian[$i]['sembuh'];
            $dataSembuh[$n]['meninggal']=$harian[$i]['meninggal'];
            $dataSembuh[$n]['positif']=$harian[$i]['positif'];
            $dataSembuh[$n]['tanggal']=date('Y-m-d',strtotime($harian[$i]['tanggal']));
            $n++;
        }
        $dataSembuh[7]['sembuh']=floor(array_sum($sembuh)/7);
        $dataSembuh[7]['meninggal']=floor(array_sum($meninggal)/7);
        $dataSembuh[7]['positif']=floor(array_sum($positif)/7);
        $dataSembuh[7]['tanggal']=date('Y-m-d', strtotime("+1 day"));
 

        foreach($dataSembuh as $data){
            $datasembuh[]=$data['sembuh'];
            $datameninggal[]=$data['meninggal'];
            $datapositif[]=$data['positif'];
            $datatanggal[]=$data['tanggal'];
        }
 
        $data = array(
            "sembuh" => ($datasembuh),
            "positif" => ($datapositif),
            "meninggal" => ($datameninggal),
            "tanggal" => ($datatanggal),
        );
        return response()->json($data);
    }

    public function movingAvgSembuh()
    {
        $harian = collect(Http::get('https://apicovid19indonesia-v2.vercel.app/api/indonesia/harian')->json());
        
        $sevenDays=count($harian)-7;
        $n=0;
        for ($i=$sevenDays; $i < count($harian); $i++) { 
            $sembuh[]=$harian[$i]['sembuh'];
            $meninggal[]=$harian[$i]['meninggal'];
            $positif[]=$harian[$i]['positif'];
            $dataSembuh[$n]['sembuh']=$harian[$i]['sembuh'];
            $dataSembuh[$n]['meninggal']=$harian[$i]['meninggal'];
            $dataSembuh[$n]['positif']=$harian[$i]['positif'];
            $dataSembuh[$n]['tanggal']=date('Y-m-d',strtotime($harian[$i]['tanggal']));
            $n++;
        }
        $dataSembuh[7]['sembuh']=floor(array_sum($sembuh)/7);
        $dataSembuh[7]['meninggal']=floor(array_sum($meninggal)/7);
        $dataSembuh[7]['positif']=floor(array_sum($positif)/7);
        $dataSembuh[7]['tanggal']=date('Y-m-d', strtotime("+1 day"));
 

        foreach($dataSembuh as $data){
            $datasembuh[]=[
                'date'=>$data['tanggal'],
                'sembuh'=>$data['sembuh'],
            ];
            // $datameninggal[]=$data['meninggal'];
            // $datapositif[]=$data['positif'];
            // $datatanggal[]=$data['tanggal'];
        }
 
        $data = array(
            "sembuh" => ($datasembuh),
            // "positif" => ($datapositif),
            // "meninggal" => ($datameninggal),
            // "tanggal" => ($datatanggal),
        );
        return response()->json($datasembuh);
        
    }
}
