<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use simple_html_dom;

class PostedJobController extends Controller
{

  public function extract(){
    // HTMLデータを取得する
    $html = file_get_html('http://ca.indeed.com/jobs?q=php&sort=date&start=0');

    // HTMLをオブジェクトとして扱う
    //$phpQueryObj = phpQuery::newDocument($html);

    //echo var_dump($html);

    foreach ($html->find('div[class=row  result]') as $elem) {
      // company name
      echo $elem->find('span[itemprop=name]', 0);

      // company address
      $regionName = $elem->find('span[itemprop=addressLocality]', 0);
      $regionArr = explode(',', str_replace(" ", "", $regionName));
      echo "----------------------------------------------";
      echo $regionName;
      echo "----------------------------------------------";

      // Find all links
      echo $elem->find('a[rel=nofollow]', 0)->href;

      // http://ca.indeed.com/ . [a href]

      foreach($elem->find('span[class=iaLabel]') as $easilyApply){
        echo $easilyApply->plaintext;
      }

      foreach($elem->find('span[class=sdn]') as $sponsered){
        echo $sponsered->plaintext;
      }
    }
  }
}
