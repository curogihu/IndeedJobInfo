<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Company;
use simple_html_dom;

class PostedJobController extends Controller
{

  public function extract(){
    // HTMLデータを取得する

    // min = 0, max = 990

    $html = file_get_html('http://ca.indeed.com/jobs?q=php&sort=date&start=0');

    foreach ($html->find('div[class=row  result]') as $elem) {
      $ret = $elem->find('span[itemprop=name]', 0);

      // company name
      if(isset($ret)){
        $regionName = $elem->find('span[itemprop=addressLocality]', 0)->plaintext;
        $regionArr = explode(',', str_replace(" ", "", $regionName));

        $company = new Company;

        $company->CompanyName = trim($elem->find('span[itemprop=name]', 0)->plaintext);
        $company->City = $this->getCityName($regionArr);
        $company->Province = $this->getProvinceName($regionArr);
        $company->Link = $elem->find('a[rel=nofollow]', 0)->href;

        $company->AddedTime = date("Ymd");

        $company->save();
      }

/*
      // company address
      $regionName = $elem->find('span[itemprop=addressLocality]', 0);
      $regionArr = explode(',', str_replace(" ", "", $regionName));

      echo "----------------------------------------------<br>";
      echo "region name = " . $this->getCityName($regionArr) . " " . $this->getProvinceName($regionArr) . "<br>";

      echo $this->getCityName($regionArr) . "<br>";
      echo $this->getProvinceName($regionArr) . "<br>";

      // Find all links
      echo $elem->find('a[rel=nofollow]', 0)->href . "<br>";

      // http://ca.indeed.com/ . [a href]

      $easilyApply = false;
      $sponsered = false;

      foreach($elem->find('span[class=iaLabel]') as $easilyApply){
        echo $easilyApply->plaintext . "<br>";
      }

      foreach($elem->find('span[class=sdn]') as $sponsered){
        echo $sponsered->plaintext . "<br>";
      }

      echo "-----------------------<br>";
      */
    }
  }

  public function getCityName($pArr){
    if(count($pArr) > 0){
      return $pArr[0];
    }

    return "";
  }

  public function getProvinceName($pArr){
    if(count($pArr) === 2){
      return $pArr[1];
    }

    return "";
  }
}
