<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Log;
use App\Http\Requests;
use App\Company;
use simple_html_dom;

class PostedJobController extends Controller
{

  public function extract(){
    //America/Vancouver
    date_default_timezone_set('America/Vancouver');
    $cnt = 0;
    $keyWords = array("php", "wordpress", "scala", "back end", "front end", "full stack");

    // min = 0, max = 990
    foreach($keyWords as $keyWord){
      for($i = 0; $i < 1000; $i += 10){
        $html = file_get_html('http://ca.indeed.com/jobs?q=' .
                              $this->modifySearchKeyWord($keyWord) .
                              '&sort=date&start=' . $i);
        $this->extractCompanyInfo($html);

        sleep(3);
      }
    }

    //echo "Add cnt = " . $cnt;
    Log::info(date("Ymd") . " addCnt = " . $cnt);
  }

  public function extractCompanyInfo($pHtml){
    foreach ($pHtml->find('div[class=row  result]') as $elem) {
      $ret = $elem->find('span[itemprop=name]', 0);

      if(!isset($ret)){
        //Log::info(date("Ymd") . " addCnt = " . $cnt);
        //exit(0);

      }else{
        $link = "http://ca.indeed.com" . $elem->find('a[rel=nofollow]', 0)->href;
        $company = Company::where('Link', $link)->get();

        // prevent from inputting duplicate record
        if($company->isEmpty()){
          $regionName = $elem->find('span[itemprop=addressLocality]', 0)->plaintext;
          $regionArr = explode(',', str_replace(" ", "", $regionName));

          $company = new Company;

          $company->CompanyName = trim($elem->find('span[itemprop=name]', 0)->plaintext);
          $company->City = $this->getCityName($regionArr);
          $company->Province = $this->getProvinceName($regionArr);
          $company->JobTitle = $elem->find('a[rel=nofollow]', 0)->title;
          $company->Link = "http://ca.indeed.com" . $elem->find('a[rel=nofollow]', 0)->href;

          $company->AddedTime = date("Ymd");

          $company->save();
          $cnt++;
        }
      }
    }
  }

  public function modifySearchKeyWord($pKeyWord){
    return str_replace(" ", "+", $pKeyWord);
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
