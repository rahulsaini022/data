<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
use App\State;
use App\Attorney;
use App\Download;
use App\Setting;
use App\DrChildren;
use Auth;
use DateTime;
use Illuminate\Support\Facades\Storage;
Use URL;
use Carbon\Carbon;

class ComputedComputationController extends Controller
{
    

      /* Save/Download Computed Sole Shared Computation Sheet */
      public function soleSharedSheet(Request $request)
      {
            $case_data['case_id']=$request->case_id;
            $attorney_data = User::find(Auth::user()->id)->attorney;

            if((isset($request->save_form) && $request->save_form=='Save') || (isset($request->download_form) && $request->download_form=='Download'))
            {
              die('in process');
                  $postData = $request;
                  // calculate code before save/download for sole/shared sheet
                  $ohMinimumWageData=DB::select(DB::raw("select getOHMinimumWage2018(0) AS tmpResult"));
                  $OH_Minimum_Wage = $ohMinimumWageData[0]->tmpResult;
                  $postData['OH_Minimum_Wage']=$OH_Minimum_Wage;

                  /***************** calculation for 02d **************************/
                  $type='obligee';
                  $sum=0;
                  $arr=['a','b','c'];

                  /* SUM ALL 3 FIELDS */
                  for($i = 0;$i < 3;$i++)
                  {
                      $fieldName = $type."_2".$arr[$i];
                      $postData[$fieldName] = ($postData[$fieldName] != '') ? $postData[$fieldName] : 0;
                      $sum += $postData[$fieldName];
                  }

                  /* GOT AVERAGE OF ALL 3 FIELDS */
                  $rsum = ($sum/3);
                  $fieldName = $type."_2d";

                  $postData[$fieldName] = min($rsum,$postData[$type.'_2c']);
                  $type='obligor';
                  $sum=0;
                  $arr=['a','b','c'];

                  /* SUM ALL 3 FIELDS */
                  for($i = 0;$i < 3;$i++)
                  {
                      $fieldName = $type."_2".$arr[$i];
                      $postData[$fieldName] = ($postData[$fieldName] != '') ? $postData[$fieldName] : 0;
                      $sum += $postData[$fieldName];
                  }

                  /* GOT AVERAGE OF ALL 3 FIELDS */

                  $rsum = ($sum/3);
                  $fieldName = $type."_2d";

                  $postData[$fieldName] = min($rsum,$postData[$type.'_2c']);

                  /***************** calculation for 03d **************************/
                  $type='obligee';
                  $postData[$type.'_3a'] = ($postData[$type.'_3a'] != '') ? $postData[$type.'_3a'] : 0;
                  $postData[$type.'_3b'] = ($postData[$type.'_3b'] != '') ? $postData[$type.'_3b'] : 0;

                  if ((isset($postData[$type.'_3_c_radio'])) && ($postData[$type.'_3_c_radio'] == 'manual'))
                  {
                      $postData[$type.'_3c'] = ($postData[$type.'_3_c_override_input'] != '') ? round(($postData[$type.'_3_c_override_input']),2) : 0;

                  } else {

                      $postData[$type.'_3c'] = round((max((0.062 * ($postData[$type.'_3a'] - $postData[$type.'_3b'])), 0)), 2);
                  }

                  $postData[$type.'_3d'] = round(((($postData[$type.'_3a']-$postData[$type.'_3b'])-$postData[$type.'_3c'])), 2);

                  $type='obligor';
                  $postData[$type.'_3a'] = ($postData[$type.'_3a'] != '') ? $postData[$type.'_3a'] : 0;
                  $postData[$type.'_3b'] = ($postData[$type.'_3b'] != '') ? $postData[$type.'_3b'] : 0;

                  if ((isset($postData[$type.'_3_c_radio'])) && ($postData[$type.'_3_c_radio'] == 'manual'))
                  {
                      $postData[$type.'_3c'] = ($postData[$type.'_3_c_override_input'] != '') ? round(($postData[$type.'_3_c_override_input']),2) : 0;

                  } else {

                      $postData[$type.'_3c'] = round((max((0.062 * ($postData[$type.'_3a'] - $postData[$type.'_3b'])), 0)), 2);
                  }

                  $postData[$type.'_3d'] = round(((($postData[$type.'_3a']-$postData[$type.'_3b'])-$postData[$type.'_3c'])), 2);

                  /***************** calculation for 08 **************************/
                  $type='obligor';
                  $postData[$type."_4"]=($postData[$type."_4"]!='')?$postData[$type."_4"]:0;
                  $postData[$type."_5"]=($postData[$type."_5"]!='')?$postData[$type."_5"]:0;
                  $postData[$type."_6"]=($postData[$type."_6"]!='')?$postData[$type."_6"]:0;
                  $postData[$type."_7"]=($postData[$type."_7"]!='')?$postData[$type."_7"]:0;
                  $postData[$type."_8"]=($postData[$type."_8"]!='')?$postData[$type."_8"]:0;

                  $field_7=round(($postData[$type."_1"]+$postData[$type."_2d"]+$postData[$type."_3d"]+$postData[$type."_4"]+$postData[$type."_5"]+$postData[$type."_6"]),2);

                  if($field_7<0)
                  {
                      $field_7=0.00;
                  }

                  $postData[$type."_7"] = $field_7;
                  $postData[$type."_8"] = round(($field_7*.05),2);

                  $type='obligee';
                  $postData[$type."_4"]=($postData[$type."_4"]!='')?$postData[$type."_4"]:0;
                  $postData[$type."_5"]=($postData[$type."_5"]!='')?$postData[$type."_5"]:0;
                  $postData[$type."_6"]=($postData[$type."_6"]!='')?$postData[$type."_6"]:0;
                  $postData[$type."_7"]=($postData[$type."_7"]!='')?$postData[$type."_7"]:0;
                  $postData[$type."_8"]=($postData[$type."_8"]!='')?$postData[$type."_8"]:0;

                  $field_7=round(($postData[$type."_1"]+$postData[$type."_2d"]+$postData[$type."_3d"]+$postData[$type."_4"]+$postData[$type."_5"]+$postData[$type."_6"]),2);

                  if($field_7<0)
                  {
                      $field_7=0.00;
                  }

                  $postData[$type."_7"] = $field_7;
                  $postData[$type."_8"] = round(($field_7*.05),2);

                  /***************** calculation for 09c **************************/
                  $type='obligee';
                  $postData[$type."_9a"] = ($postData[$type."_9a"] != '') ? $postData[$type."_9a"] : 0;
                  $postData[$type."_9b"] = ($postData[$type."_9b"] != '') ? $postData[$type."_9b"] : 0;
                  $postData[$type."_9c"] = ($postData[$type."_9c"] != '') ? $postData[$type."_9c"] : 0;

                  $postData[$type."_9d"] = 0;
                  $postData[$type."_9e"] = 0;
                  $postData[$type."_9f"] = 0;

                  $postData[$type."_9c"] = $postData[$type."_9a"]-$postData[$type."_9b"];

                  $result=DB::select(DB::raw("SELECT getOhioChildSupport2018(".$postData[$type.'_7'].",".$postData[$type.'_9a'].") AS calculation"));


                  if ($postData[$type.'_9a'] == 0)
                  {
                      $postData[$type."_9d"] = 0;

                  } else {

                      $postData[$type."_9d"] = $result[0]->calculation;
                  }

                  if($postData[$type."_9a"]>0)
                      $postData[$type."_9e"]=round(($postData[$type."_9d"]/$postData[$type."_9a"]),2);

                  if($postData[$type."_9c"]>0)
                      $postData[$type."_9f"]=round(($postData[$type."_9e"]*$postData[$type."_9c"]),2);

                  $type='obligor';
                  $postData[$type."_9a"] = ($postData[$type."_9a"] != '') ? $postData[$type."_9a"] : 0;
                  $postData[$type."_9b"] = ($postData[$type."_9b"] != '') ? $postData[$type."_9b"] : 0;
                  $postData[$type."_9c"] = ($postData[$type."_9c"] != '') ? $postData[$type."_9c"] : 0;

                  $postData[$type."_9d"] = 0;
                  $postData[$type."_9e"] = 0;
                  $postData[$type."_9f"] = 0;

                  $postData[$type."_9c"] = $postData[$type."_9a"]-$postData[$type."_9b"];

                  $result=DB::select(DB::raw("SELECT getOhioChildSupport2018(".$postData[$type.'_7'].",".$postData[$type.'_9a'].") AS calculation"));


                  if ($postData[$type.'_9a'] == 0)
                  {
                      $postData[$type."_9d"] = 0;

                  } else {

                      $postData[$type."_9d"] = $result[0]->calculation;
                  }

                  if($postData[$type."_9a"]>0)
                      $postData[$type."_9e"]=round(($postData[$type."_9d"]/$postData[$type."_9a"]),2);

                  if($postData[$type."_9c"]>0)
                      $postData[$type."_9f"]=round(($postData[$type."_9e"]*$postData[$type."_9c"]),2);

                  /***************** calculation for O15 **************************/
                  $type='obligee';
                  $postData[$type."_10b"] = ($postData[$type."_10b"] != '') ? $postData[$type."_10b"] : 0;

                  if((isset($postData[$type."_10a"])) && ($postData[$type."_10a"] == ''))
                  {
                      $postData[$type."_10b"] = 0;
                  }

                  $postData[$type."_11"] = ($postData[$type."_11"] != '') ? $postData[$type."_11"] : 0;
                  $postData[$type."_12"] = $postData[$type."_9f"] + $postData[$type."_10b"] + $postData[$type."_11"];
                  $postData[$type."_13"] = $postData[$type."_7"] - $postData[$type."_12"];
                  $postData[$type."_13"] = ($postData[$type."_13"] > 0) ? $postData[$type."_13"] : 0;
                  $postData[$type."_14"] = $postData[$type."_13"];

                  if((isset($postData[$type."_10a"])) && ($postData[$type."_10a"] == ''))
                  {
                      $postData[$type."_10b"] = 0;
                  }

                  $noChildThisOrder = $postData['number_children_order'];
                  $nthChildThreshholdData=DB::select(DB::raw("SELECT getOH_CS_Shaded_Threshold2018(".$noChildThisOrder.") As tmpResult"));
                  $postData[$type.'_15'] = 0;

                  if (isset($nthChildThreshholdData[0]->tmpResult))
                  {
                      if ((isset($postData[$type.'_14'])) && ($postData[$type.'_14'] <= $nthChildThreshholdData[0]->tmpResult))
                      {
                          $postData[$type.'_15'] = 1;

                      }
                  }

                  $type='obligor';

                  $postData[$type."_10b"] = ($postData[$type."_10b"] != '') ? $postData[$type."_10b"] : 0;

                  if((isset($postData[$type."_10a"])) && ($postData[$type."_10a"] == ''))
                  {
                      $postData[$type."_10b"] = 0;
                  }

                  $postData[$type."_11"] = ($postData[$type."_11"] != '') ? $postData[$type."_11"] : 0;
                  $postData[$type."_12"] = $postData[$type."_9f"] + $postData[$type."_10b"] + $postData[$type."_11"];
                  $postData[$type."_13"] = $postData[$type."_7"] - $postData[$type."_12"];
                  $postData[$type."_13"] = ($postData[$type."_13"] > 0) ? $postData[$type."_13"] : 0;
                  $postData[$type."_14"] = $postData[$type."_13"];

                  if((isset($postData[$type."_10a"])) && ($postData[$type."_10a"] == ''))
                  {
                      $postData[$type."_10b"] = 0;
                  }

                  $noChildThisOrder = $postData['number_children_order'];
                  $nthChildThreshholdData=DB::select(DB::raw("SELECT getOH_CS_Shaded_Threshold2018(".$noChildThisOrder.") As tmpResult"));

                  $postData[$type.'_15'] = 0;

                  if (isset($nthChildThreshholdData[0]->tmpResult))
                  {
                      if ((isset($postData[$type.'_14'])) && ($postData[$type.'_14'] <= $nthChildThreshholdData[0]->tmpResult))
                      {
                          $postData[$type.'_15'] = 1;

                      }
                  }


                  /***************** calculation for O16 **************************/
                  $postData["obligee_16"] = $postData["obligee_14"] + $postData["obligor_14"];


                  /***************** calculation for O18 **************************/
                  $postData["obligee_17"]=0;

                  $postData["obligee_18a"]=0;
                  $postData["obligor_18a"]=0;
                  $postData["obligee_18b"]=0;
                  $postData["obligee_18c"]=0;
                  $postData["obligor_18c"]=0;
                  $postData["obligee_18d"]=0;
                  $postData["obligor_18d"]=0;

                  /**
                   * @TODO :- Warning Check
                   */
                  // $postData["obligee_19a"]=($postData["obligee_19a"]!='')?$postData["obligee_19a"]:0;
                  // $postData["obligor_19a"]=($postData["obligor_19a"]!='')?$postData["obligor_19a"]:0;

                  $postData["obligee_19a"]= $postData["obligee_19a"];
                  $postData["obligor_19a"]= $postData["obligor_19a"];

                  $postData["obligee_19b"]=0;
                  $postData["obligor_19b"]=0;

                  $postData["obligee_20"]=($postData["obligee_20"]!='')?$postData["obligee_20"]:0;
                  $postData["obligor_20"]=($postData["obligor_20"]!='')?$postData["obligor_20"]:0;

                  if($postData["obligee_16"]>0)
                  {
                      $postData["obligee_17"]=round(($postData["obligee_14"]/$postData["obligee_16"])*100,2);
                      $postData["obligor_17"]=round(($postData["obligor_14"]/$postData["obligee_16"])*100,2);
                  }

                  $result=DB::select(DB::raw("SELECT getOhioChildSupport2018(".$postData['obligee_14'].",".$postData['number_children_order'].") AS calculation"));
                  if(isset($result[0]->calculation))
                  {
                      $postData["obligee_18a"]=$result[0]->calculation;
                  }

                  $result=DB::select(DB::raw("SELECT getOhioChildSupport2018(".$postData['obligor_14'].",".$postData['number_children_order'].") AS calculation"));
                  if(isset($result[0]->calculation))
                  {
                      if($result[0]->calculation<960) {

                          $postData["obligor_18a"]=960;
                      } else {

                          $postData["obligor_18a"]=$result[0]->calculation;
                      }
                  }

                  $result=DB::select(DB::raw("SELECT getOhioChildSupport2018(".$postData['obligee_16'].",".$postData['number_children_order'].") AS calculation"));

                  if(isset($result[0]->calculation))
                  {
                      if($result[0]->calculation<960) {
                          $postData["obligee_18b"]=960;
                      } else {
                          $postData["obligee_18b"]=$result[0]->calculation;
                      }
                  }

                  $postData['obligor_17'] = (isset($postData['obligor_17']) && ($postData['obligor_17'] != '')) ? $postData['obligor_17'] : 0;

                  $postData["obligee_18c"]=round(($postData["obligee_18b"]*($postData["obligee_17"]/100)),2);
                  $postData["obligor_18c"]=round(($postData["obligee_18b"]*($postData["obligor_17"]/100)),2);

                  $low18=($postData["obligee_18a"]<$postData["obligee_18c"])?$postData["obligee_18a"]:$postData["obligee_18c"];

                  $low18=($low18<960)?960:$low18;
                  $postData["obligee_18d"]=$low18;
                  $low18=($postData["obligor_18a"]<$postData["obligor_18c"])?$postData["obligor_18a"]:$postData["obligor_18c"];
                  $low18=($low18<960)?960:$low18;
                  $postData["obligor_18d"]=$low18;

                  if(isset($postData["obligee_19a"]) && $postData["obligee_19a"]>0)
                  {
                      $postData["obligee_19b"]=round((($postData["obligee_18d"]*0.10)), 2);
                  } else {
                      $postData["obligee_19b"]=0.00;
                  }

                  if(isset($postData["obligor_19a"]) && $postData["obligor_19a"]>0)
                  {
                      $postData["obligor_19b"]=round((($postData["obligor_18d"]*0.10)), 2);
                  } else {
                      $postData["obligor_19b"]=0.00;
                  }

                  /***************** some required calculations before O21 and 021f **************************/
                              


                  /***************** calculation for O21 and 021f **************************/
                  $obligeeSum = 0;

                  for ($i=1; $i <= 6; $i++)
                  {
                      $postData['obligee_21d'.$i] = ($postData['obligee_21d'.$i] != '') ? $postData['obligee_21d'.$i] : 0;
                      $obligeeSum += $postData['obligee_21d'.$i];
                  }
                  /**Replace " with ' Start ****************************************/

                  $postData['obligee_21a'] = $obligeeSum ?? 0;

                  /**
                   * @TODO :- Warning check
                   */
                  $obligorSum = 0;

                  for ($i=1; $i <= 6; $i++)
                  {
                      $postData['obligor_21d'.$i] = ($postData['obligor_21d'.$i] != '') ? $postData['obligor_21d'.$i] : 0;
                      $obligorSum += $postData['obligor_21d'.$i];
                  }

                  $postData['obligor_21a'] = $obligorSum ?? 0;

                  $postData['obligee_21f'] = 0;
                  $postData['obligor_21f'] = 0;

                  $postData['obligee_21g'] = ($postData['obligee_21g']!='')?$postData['obligee_21g']:0;
                  $postData['obligor_21g'] = ($postData['obligor_21g']!='')?$postData['obligor_21g']:0;

                  $postData['obligee_21h'] = 0;
                  $postData['obligor_21h'] = 0;

                  $postData['obligee_21i'] = 0;
                  $postData['obligor_21i'] = 0;

                  $postData['obligee_21j'] = 0;
                  $postData['obligor_21j'] = 0;

                  $e_total=0;

                  for($i=1;$i<=6;$i++)
                  {
                      $mac=0;
                      if($postData['obligee_21b'.$i]!='')
                      {
                          $res = explode("/", $postData["obligee_21b".$i]);

                          if(count($res)>2)
                          {
                              $newDob = $res[2]."-".$res[0]."-".$res[1];


                              // get month difference
                              $start=date("Y-m-d");
                              $end=$newDob;
                              $end OR $end = time();
                              $start = new DateTime("$start");
                              $end   = new DateTime("$end");
                              $diff  = $start->diff($end);
                              $months_diff=$diff->format('%y') * 12 + $diff->format('%m');


                              if($months_diff<18)
                              {
                                  $mac=11464;
                              }
                              elseif($months_diff>=18 && $months_diff<36)
                              {
                                  $mac=10025;
                              }
                              elseif($months_diff>=36 && $months_diff<72)
                              {
                                  $mac=8600;
                              }
                              elseif($months_diff>=72 && $months_diff<144)
                              {
                                  $mac=7290;
                              }
                              else
                              {
                                  $mac=0;
                              }
                          }


                          if($months_diff<36)
                          {
                              $postData["obligee_21b".$i.'a']=$months_diff." Months";
                          }
                          else
                          {
                              $start=date("Y-m-d");
                              $end=$newDob;
                              $end OR $end = time();
                              $start = new DateTime("$start");
                              $end   = new DateTime("$end");
                              $diff  = $start->diff($end);
                              $postData["obligee_21b".$i.'a']= $diff->format('%y')." Years";
                          }
                      } else {
                          $postData["obligee_21b".$i.'a']= "";
                      }

                      $postData["obligee_21c".$i]=$mac;

                      $postData["obligee_21d".$i]=($postData["obligee_21d".$i]!='')?$postData["obligee_21d".$i]:0;

                      $postData["obligee_21e".$i]=($postData["obligee_21c".$i]<$postData["obligee_21d".$i])?$postData["obligee_21c".$i]:$postData["obligee_21d".$i];

                      $postData["obligee_21e".$i]=($postData["obligee_21e".$i]!='')?$postData["obligee_21e".$i]:0;

                      $e_total=$e_total+$postData["obligee_21e".$i];

                  }
                  /**Replace " with 'End****************************************/

                  for ($i=1; $i < 6; $i++)
                  {
                      $postData['obligee_21e'.$i] = min($postData['obligee_21c'.$i], ($postData['obligee_21d'.$i] + $postData['obligor_21d'.$i]));
                  }

                  //Apportioned Obligee Sum
                  for ($i=1; $i<=6 ; $i++)
                  {
                      $dividerApporObligee = $postData['obligee_21d'.$i] + $postData['obligor_21d'.$i];
                      $dividerApporObligee = ($dividerApporObligee == 0) ? 1 : $dividerApporObligee;

                      $postData['apportioned_obligee_21_'.$i] = round((($postData['obligee_21d'.$i]*($postData['obligee_21e'.$i]/$dividerApporObligee))), 2);
                  }

                  for ($i=1; $i<=6 ; $i++)
                  {
                      $dividerApporObligor = $postData['obligee_21d'.$i] + $postData['obligor_21d'.$i];
                      $dividerApporObligor = ($dividerApporObligor == 0) ? 1 : $dividerApporObligor;

                      $postData['apportioned_obligor_21_'.$i] = round((($postData['obligor_21d'.$i]*($postData['obligee_21e'.$i]/$dividerApporObligor))), 2);
                  }


                  $type='obligee';
                  $obligeeSumAppoint = 0;

                  for ($i=1; $i <= 6; $i++)
                  {
                      $obligeeSumAppoint += $postData['apportioned_obligee_21_'.$i];
                  }

                  $postData["obligee_21f"] = $obligeeSumAppoint ?? 0;

                  /**
                   * @TODO :- Warning Check
                   */

                  if ($type == 'obligee')
                  {
                      
                      $fedChildPerceObligee=DB::select(DB::raw("SELECT getFedChildCareCreditPercentage2018(".$postData['obligee_14'].") AS calculation"));
                      $fedChildPercentageObligee = $fedChildPerceObligee[0]->calculation;

                      $postData['obligee_21fa'] = $fedChildPercentageObligee*100;

                      /***************************************/

                      $childCareCreditData=DB::select(DB::raw("SELECT getFedChildCareCap2018(6) AS calculation"));
                      $childCareCredit = $childCareCreditData[0]->calculation;

                      $postData['obligee_21fb'] = round(($fedChildPercentageObligee * (min(($postData['obligee_1'] + max($postData['obligee_3d'], 0)), $postData['obligee_21f'], $childCareCredit))), 2);

                      /***********************************/

                      $ohChildPerObligeeData=DB::select(DB::raw("SELECT getOhChildCareCreditPercentage2018(".$postData['obligee_14'].") AS calculation"));

                      $ohChildPerObligee = $ohChildPerObligeeData[0]->calculation;

                      $postData['obligee_21fc'] = $ohChildPerObligee*100;

                      /*********************************/
                      // following fromulas are changed on 27-12-2019 22:30:00
                      // $postData['obligee_21fd'] = round(($ohChildPerObligee * $postData['obligee_21f']), 2);
                      $postData['obligee_21fd'] = round(($ohChildPerObligee * $postData['obligee_21fb']), 2);

                      /****************************************/

                  }
                  $type='obligor';

                  /**
                   * @TODO :- Warning Check
                   */
                  $obligorSumAppoint = 0;

                  for ($i=1; $i <= 6; $i++)
                  {
                      $obligorSumAppoint += $postData['apportioned_obligor_21_'.$i];
                  }

                  $postData["obligor_21f"] = $obligorSumAppoint ?? 0;

                  if ($type == 'obligor')
                  {
                     
                      $fedChildPerceObligor=DB::select(DB::raw("SELECT getFedChildCareCreditPercentage2018(".$postData['obligor_14'].") AS calculation"));
                      $fedChildPercentageObligor = $fedChildPerceObligor[0]->calculation;

                      $postData['obligor_21fa'] = $fedChildPercentageObligor*100;

                      /*******************************/

                      $childCareCreditData=DB::select(DB::raw("SELECT getFedChildCareCap2018(6) AS calculation"));
                      $childCareCredit = $childCareCreditData[0]->calculation;

                      $postData['obligor_21fb'] = round(($fedChildPercentageObligor * (min(($postData['obligor_1'] + max($postData['obligor_3d'], 0)), $postData['obligor_21f'], $childCareCredit))), 2);

                      /*********************************/

                      $ohChildPerObligorData=DB::select(DB::raw("SELECT getOhChildCareCreditPercentage2018(".$postData['obligor_14'].") AS calculation"));
                      $ohChildPerObligor = $ohChildPerObligorData[0]->calculation;

                      $postData['obligor_21fc'] = $ohChildPerObligor*100;

                      /********************************/
                       // following fromulas are changed on 27-12-2019 22:30:00
                      // $postData['obligor_21fd'] = round(($ohChildPerObligor * $postData['obligor_21f']), 2);
                      $postData['obligor_21fd'] = round(($ohChildPerObligor * $postData['obligor_21fb']), 2);

                      /****************************************/

                  }

                  if (isset($postData['obligee_21_g_radio']) && ($postData['obligee_21_g_radio'] == 'calculation'))
                  {
                      $postData['obligee_21g'] = $postData['obligee_21fb'] + $postData['obligee_21fd'];

                  } else {

                      $postData['obligee_21g'] = $postData['obligee_21_g_override_text'];
                  }

                  if (isset($postData['obligor_21_g_radio']) && ($postData['obligor_21_g_radio'] == 'calculation'))
                  {
                      $postData['obligor_21g'] = $postData['obligor_21fb'] + $postData['obligor_21fd'];

                  } else {

                      $postData['obligor_21g'] = $postData['obligor_21_g_override_text'];
                  }

                  /**
                   * 21 h formula changed by client itself
                   * overide the old one i.e present below
                   * commented
                   */
                  if($postData['obligee_21f'] > 0)
                  {
                      $postData['obligee_21h'] = $postData['obligee_21f'] - $postData['obligee_21g'];
                  }

                  if($postData['obligor_21f'] > 0)
                  {
                      $postData['obligor_21h'] = $postData['obligor_21f'] - $postData['obligor_21g'];
                  }

                  /**
                   * Code need to be cleaned after client
                   * approval
                   */
                  // $postData["obligee_21f"] = $e_total;
                  // $postData["obligor_21f"] = $e_total;

                  // if($postData["obligee_21f"]>0)
                  // {
                  //  $postData["obligee_21h"] = $postData["obligee_21f"] - ($postData["obligee_21g"]+$postData["obligor_21g"]);
                  // }

                  // if($postData["obligor_21f"]>0)
                  // {
                  //  $postData["obligor_21h"] = $postData["obligor_21f"]-($postData["obligee_21g"]+$postData["obligor_21g"]);
                  // }
                  // echo "<pre>";print_r($postData['obligee_17']);die();

                  if($postData['obligee_15']==1)
                  {
                      // L21i(C1)=MIN(L17(C1),0.50)(L21h(C1)+L21h(C2));
                      // $postData["obligee_21i"]=((min($postData["obligee_17"],50)/100))*$postData["obligee_21h"];

                      $postData["obligee_21i"]= min(($postData['obligee_17']/100), 0.50) * ($postData['obligee_21h'] + $postData['obligor_21h']);

                  } else {

                      // L21i(C1)=L17(C1)(L21h(C1)+L21h(C2)
                      // $postData["obligee_21i"]=(($postData["obligee_17"]/100)*$postData["obligee_21h"]);

                      $postData["obligee_21i"]=(($postData["obligee_17"]/100) * ($postData['obligee_21h'] + $postData['obligor_21h']));
                  }
                  if($postData['obligor_15']==1)
                  {
                      // $postData["obligor_21i"]=((min($postData["obligor_17"],50)/100))*$postData["obligor_21h"];
                      $postData["obligor_21i"]= round((min(($postData['obligor_17']/100), 0.50) * ($postData['obligee_21h'] + $postData['obligor_21h'])), 2);

                  } else {

                      // $postData["obligor_21i"]=(($postData["obligor_17"]/100)*$postData["obligor_21h"]);
                      $postData["obligor_21i"]=round(((($postData["obligor_17"]/100) * ($postData['obligee_21h'] + $postData['obligor_21h']))), 2);
                  }

                  // $postData["obligee_21j"]=($postData["obligee_21f"]-$postData["obligee_21a"]);
                  // $postData["obligor_21j"]=($postData["obligor_21f"]-$postData["obligor_21a"]);

                  $postData["obligee_21j"]=($postData["obligee_21i"]-$postData["obligee_21a"]);
                  $postData["obligor_21j"]=($postData["obligor_21i"]-$postData["obligor_21a"]);

                  $postData["obligee_21j"]=($postData["obligee_21j"]>0)?$postData["obligee_21j"]:0;
                  $postData["obligor_21j"]=($postData["obligor_21j"]>0)?$postData["obligor_21j"]:0;

                  $postData["obligee_22"]=($postData["obligee_18d"]-$postData["obligee_19b"]-$postData["obligee_20"])+$postData["obligee_21j"];

                  $postData["obligor_22"]=($postData["obligor_18d"]-$postData["obligor_19b"]-$postData["obligor_20"])+$postData["obligor_21j"];

                  $postData["obligee_22"]=($postData["obligee_22"]>0)?$postData["obligee_22"]:0;
                  $postData["obligor_22"]=($postData["obligor_22"]>0)?$postData["obligor_22"]:0;

                  /**
                   * If g is having radio value manual
                   * then 21 h shoild be like below
                   */
                  if (isset($postData['obligee_21_g_radio']) && ($postData['obligee_21_g_radio'] == 'manual'))
                  {
                      $postData['obligee_21h'] = $postData['obligee_21f'] - $postData['obligee_21g'];
                  }

                  if (isset($postData['obligor_21_g_radio']) && ($postData['obligor_21_g_radio'] == 'manual'))
                  {
                      $postData['obligor_21h'] = $postData['obligor_21f'] - $postData['obligor_21g'];
                  }


                  /******************* calculations for 025 ****************************/

                  if (isset($postData['25a_child_sport_radio']) && ($postData['25a_child_sport_radio'] == 'deviation'))
                  {
                      $postData['25a_child_sport_deviation_text'] = (isset($postData['25a_child_sport_deviation_text']) && ($postData['25a_child_sport_deviation_text'] != '')) ? $postData['25a_child_sport_deviation_text'] : 0;

                      $postData['obligor_25a'] = $postData['25a_child_sport_deviation_text'];

                  } else {

                      $postData['25a_child_sport_non_deviation_text'] = (isset($postData['25a_child_sport_non_deviation_text']) && ($postData['25a_child_sport_non_deviation_text'] != '')) ? $postData['25a_child_sport_non_deviation_text'] : 0;

                      $postData['obligor_25a'] = $postData['25a_child_sport_non_deviation_text'] - $postData['obligor_24'];
                  }

                  /******************* calculations for 024 ****************************/
                  $combinedGrossIncome = $postData['obligee_1'] + $postData['obligor_1'];
                  $combinedGrossIncome = ($combinedGrossIncome == '') ? 0 : $combinedGrossIncome;

                  $ohCashMedicalData=DB::select(DB::raw("SELECT getOHCashMedical2018(".$combinedGrossIncome.",".$postData['number_children_order'].") As tmpResult"));

                  $postData["obligee_24"]=0;
                  $postData["obligor_24"]=0;

                  $postData["obligee_25a"]=((isset($postData["obligee_25a"])) && ($postData["obligee_25a"]!='')) ? $postData["obligee_25a"]:0;
                  $postData["obligor_25a"]=((isset($postData["obligor_25a"])) && ($postData["obligor_25a"]!='')) ? $postData["obligor_25a"]:0;
                  $postData["obligee_25b"]=((isset($postData["obligee_25b"])) && ($postData["obligee_25b"]!='')) ? $postData["obligee_25b"]:0;
                  $postData["obligor_25b"]=((isset($postData["obligor_25b"])) && ($postData["obligor_25b"]!='')) ? $postData["obligor_25b"]:0;

                  $postData["obligee_25c"]=0;
                  $postData["obligor_25c"]=0;
                  $postData["obligee_27"]=0;
                  $postData["obligor_27"]=0;

                  $postData["obligee_28"]= ((isset($postData["obligee_28"])) && ($postData["obligee_28"] != '')) ? $postData["obligee_28"] : 0;
                  $postData["obligor_28"]= ((isset($postData["obligor_28"])) && ($postData["obligor_28"] != '')) ? $postData["obligor_28"] : 0;

                  $postData["obligee_29"]=0;
                  $postData["obligor_29"]=0;
                  $postData["obligee_30"]=0;
                  $postData["obligor_30"]=0;

                  $postData['obligee_23a'] = @$ohCashMedicalData[0]->tmpResult;
                  // $postData['obligee_23a']=1554.80;
                  $postData['obligee_23b']=($postData['obligee_23a']*($postData['obligee_17']/100));
                  $postData['obligor_23b']=($postData['obligee_23a']*($postData['obligor_17']/100));

                  if($postData['obligee_22']>0)
                  {
                      $postData['obligee_24']=($postData['obligee_22']/12);
                  }

                  if($postData['obligor_22']>0)
                  {
                      $postData['obligor_24']=($postData['obligor_22']/12);
                  }

                  $postData['obligee_25c']=($postData['obligee_25a']+$postData['obligee_25b']);
                  $postData['obligor_25c']=($postData['obligor_25a']+$postData['obligor_25b']);

                  $postData['obligee_26']=($postData['obligee_24']+$postData['obligee_25c']);
                  $postData['obligor_26']=($postData['obligor_24']+$postData['obligor_25c']);

                  $postData['obligee_27'] = ($postData['obligee_23b']/12);
                  $postData['obligor_27'] = round(($postData['obligor_23b']/12), 2);          

                  // if($postData['obligee_23b']>0)
                  // {
                  //  $postData['obligee_27'] = ($postData['obligee_23b']/12);
                  //  }

                  // if($postData['obligee_23b'] > 0)
                  // {            
                  //      $postData['obligor_27'] = round(($postData['obligor_23b']/12), 2);          
                  //  }

                  $postData['obligee_29']=($postData['obligee_27']+$postData['obligee_28']);
                  $postData['obligor_29']=($postData['obligor_27']+$postData['obligor_28']);

                  //  echo "<pre>";print_r($postData['obligor_28']);die();
                  //  $postData['obligee_30']=($postData['obligee_24']+$postData['obligee_25c']+$postData['obligee_27']+$postData['obligee_28']);
                  //  $postData['obligor_30']=($postData['obligor_24']+$postData['obligor_25c']+$postData['obligor_27']+$postData['obligor_28']);
                  //  L30 = L26 + L29

                  $postData['obligee_30']=($postData['obligee_26']+$postData['obligee_29']);
                  $postData['obligor_30']=($postData['obligor_26']+$postData['obligor_29']);

                  /******************* calculations for 031 ****************************/
                  $postData['obligor_31'] = ($postData['obligor_30'] * 0.02);
                  $postData['obligor_32'] = ($postData['obligor_31'] + $postData['obligor_30']);
                  // end of calculate code before save/download for sole/shared sheet

                  $array=array(
                          "user_id"=>Auth::user()->id,
                          "case_id"=>$request->case_id,
                          "form_text"=>serialize($request->all()),
                          'form_state'=>$request->sheet_state,
                          "form_custody"=>$request->sheet_custody,
                          );
                              // dd($array);
                  if(isset($request->case_id)){
                              // die('yes');
                        $sheet_data=DB::table('users_attorney_submissions')->where([['user_id', Auth::user()->id], ['case_id', $request->case_id],['form_state', $request->sheet_state],['form_custody', $request->sheet_custody]])->latest('id')->first();
                        if(isset($sheet_data)){
                              DB::table('users_attorney_submissions')->where('id',$sheet_data->id)->update($array);
                        } else {
                              // die('no');
                              DB::table('users_attorney_submissions')->insert($array);
                        }
                  } else {
                        $sheet_data=DB::table('users_attorney_submissions')->where([['user_id', Auth::user()->id],['form_state', $request->sheet_state],['form_custody', $request->sheet_custody]])->whereNull('case_id')->latest('id')->first();
                        if(isset($sheet_data)){
                              // dd($sheet_data);
                              // die('yes');
                              DB::table('users_attorney_submissions')->where('id',$sheet_data->id)->update($array);
                        } else {
                              // die('no');
                              DB::table('users_attorney_submissions')->insert($array);
                        }
                  }
                  if($postData['obligee_1_datepick']==''){
                        $postData['obligee_1_datepick']=null;
                  } else {
                    $postData['obligee_1_datepick']=date("Y-m-d", strtotime($postData['obligee_1_datepick'])); 
                  }
                  if($postData['obligor_1_datepick']==''){
                        $postData['obligor_1_datepick']=null;
                  } else {
                    $postData['obligor_1_datepick']=date("Y-m-d", strtotime($postData['obligor_1_datepick'])); 
                  }
                  if($postData['obligee_21b1']==''){
                        $postData['obligee_21b1']=null;
                  } else {
                    $postData['obligee_21b1']=date("Y-m-d", strtotime($postData['obligee_21b1'])); 
                  }
                  if($postData['obligee_21b2']==''){
                        $postData['obligee_21b2']=null;
                  } else {
                    $postData['obligee_21b2']=date("Y-m-d", strtotime($postData['obligee_21b2'])); 
                  }
                  if($postData['obligee_21b3']==''){
                        $postData['obligee_21b3']=null;
                  } else {
                    $postData['obligee_21b3']=date("Y-m-d", strtotime($postData['obligee_21b3'])); 
                  }
                  if($postData['obligee_21b4']==''){
                        $postData['obligee_21b4']=null;
                  } else {
                    $postData['obligee_21b4']=date("Y-m-d", strtotime($postData['obligee_21b4'])); 
                  }
                  if($postData['obligee_21b5']==''){
                        $postData['obligee_21b5']=null;
                  } else {
                    $postData['obligee_21b5']=date("Y-m-d", strtotime($postData['obligee_21b5'])); 
                  }
                  if($postData['obligee_21b6']==''){
                        $postData['obligee_21b6']=null;
                  } else {
                    $postData['obligee_21b6']=date("Y-m-d", strtotime($postData['obligee_21b6'])); 
                  }
                  // if(isset($postData['obligee_21_g_radio']) && $postData['obligee_21_g_radio']=='calculation'){
                  //       $postData['obligee_21_g_radio']=0;
                  // }
                  // if(isset($postData['obligor_21_g_radio']) && $postData['obligor_21_g_radio']=='calculation'){
                  //       $postData['obligor_21_g_radio']=0;
                  // }
                  // $postData['obligee_21b1a'] = (int) filter_var($postData['obligee_21b1a'], FILTER_SANITIZE_NUMBER_INT);
                  // $postData['obligee_21b2a'] = (int) filter_var($postData['obligee_21b1a'], FILTER_SANITIZE_NUMBER_INT);
                  // echo "<pre>";print_r($postData->all());die;
                  $array2=array(
                              "user_id"=>Auth::user()->id,
                              "case_id"=>$postData['case_id'],
                              "obligee_name"=>$postData['obligee_name'],
                              "obligor_name"=>$postData['obligor_name'],
                              "county_name"=>$postData['county_name'],
                              "sets_case_number"=>$postData['sets_case_number'],
                              "court_administrative_order_number"=>$postData['court_administrative_order_number'],
                              "number_children_order"=>$postData['number_children_order'],
                              "obligee_1_input_year"=>$postData['obligee_1_input_year'],
                              "obligee_1_dropdown"=>$postData['obligee_1_dropdown'],
                              "obligee_1_input_ytd"=>$postData['obligee_1_input_ytd'],
                              "obligee_1_datepick"=>$postData['obligee_1_datepick'],
                              "obligor_1_input_year"=>$postData['obligor_1_input_year'],
                              "obligor_1_dropdown"=>$postData['obligor_1_dropdown'],
                              "obligor_1_input_ytd"=>$postData['obligor_1_input_ytd'],
                              "obligor_1_datepick"=>$postData['obligor_1_datepick'],
                              "obligee_1"=>$postData['obligee_1'],
                              "obligor_1"=>$postData['obligor_1'],
                              "obligee_2a"=>$postData['obligee_2a'],
                              "obligor_2a"=>$postData['obligor_2a'],
                              "obligee_2b"=>$postData['obligee_2b'],  
                              "obligor_2b"=>$postData['obligor_2b'],
                              "obligee_2c"=>$postData['obligee_2c'],
                              "obligor_2c"=>$postData['obligor_2c'],
                              "obligee_2d"=>$postData['obligee_2d'],
                              "obligor_2d"=>$postData['obligor_2d'],
                              "obligee_3a"=>$postData['obligee_3a'],
                              "obligor_3a"=>$postData['obligor_3a'],
                              "obligee_3b"=>$postData['obligee_3b'],
                              "obligor_3b"=>$postData['obligor_3b'],
                              "obligee_3_c_top_override_input"=>$postData['obligee_3_c_top_override_input'],  
                              "obligee_3_c_override_input"=>$postData['obligee_3_c_override_input'],  
                              "obligor_3_c_top_override_input"=>$postData['obligor_3_c_top_override_input'],  
                              "obligor_3_c_override_input"=>$postData['obligor_3_c_override_input'],
                              "obligee_3c"=>$postData['obligee_3c'],
                              "obligor_3c"=>$postData['obligor_3c'],
                              "obligee_3d"=>$postData['obligee_3d'],
                              "obligor_3d"=>$postData['obligor_3d'],
                              "obligee_4"=>$postData['obligee_4'],
                              "obligor_4"=>$postData['obligor_4'],
                              "obligee_5"=>$postData['obligee_5'],
                              "obligor_5"=>$postData['obligor_5'],
                              "obligee_6"=>$postData['obligee_6'],
                              "obligor_6"=>$postData['obligor_6'],
                              "obligee_7"=>$postData['obligee_7'],
                              "obligor_7"=>$postData['obligor_7'],
                              "obligee_8"=>$postData['obligee_8'],
                              "obligor_8"=>$postData['obligor_8'],
                              "obligee_9a"=>$postData['obligee_9a'],
                              "obligor_9a"=>$postData['obligor_9a'],
                              "obligee_9b"=>$postData['obligee_9b'],
                              "obligor_9b"=>$postData['obligor_9b'],
                              "obligee_9c"=>$postData['obligee_9c'],
                              "obligor_9c"=>$postData['obligor_9c'],
                              "obligee_9d"=>$postData['obligee_9d'],
                              "obligor_9d"=>$postData['obligor_9d'],
                              "obligee_9e"=>$postData['obligee_9e'],
                              "obligor_9e"=>$postData['obligor_9e'],
                              "obligee_9f"=>$postData['obligee_9f'],
                              "obligor_9f"=>$postData['obligor_9f'],
                              "obligee_10a"=>$postData['obligee_10a'],
                              "obligor_10a"=>$postData['obligor_10a'],
                              "obligee_10b"=>$postData['obligee_10b'],
                              "obligor_10b"=>$postData['obligor_10b'],
                              "obligee_11"=>$postData['obligee_11'],
                              "obligor_11"=>$postData['obligor_11'],
                              "obligee_12"=>$postData['obligee_12'],
                              "obligor_12"=>$postData['obligor_12'],
                              "obligee_13"=>$postData['obligee_13'],
                              "obligor_13"=>$postData['obligor_13'],
                              "obligee_14"=>$postData['obligee_14'],
                              "obligor_14"=>$postData['obligor_14'],
                              "obligee_15"=>$postData['obligee_15'],
                              "obligor_15"=>$postData['obligor_15'],
                              "obligee_16"=>$postData['obligee_16'],
                              "obligee_17"=>$postData['obligee_17'],
                              "obligor_17"=>$postData['obligor_17'],
                              "obligee_18a"=>$postData['obligee_18a'],
                              "obligor_18a"=>$postData['obligor_18a'],
                              "obligee_18b"=>$postData['obligee_18b'],
                              "obligee_18c"=>$postData['obligee_18c'],
                              "obligor_18c"=>$postData['obligor_18c'],
                              "obligee_18d"=>$postData['obligee_18d'],
                              "obligor_18d"=>$postData['obligor_18d'],
                              "obligee_19a"=>$postData['obligee_19a'],
                              "obligor_19a"=>$postData['obligor_19a'],
                              "obligee_19b"=>$postData['obligee_19b'],
                              "obligor_19b"=>$postData['obligor_19b'],
                              "obligee_20"=>$postData['obligee_20'],
                              "obligor_20"=>$postData['obligor_20'],  
                              "obligee_21a"=>$postData['obligee_21a'],    
                              "obligor_21a"=>$postData['obligor_21a'],
                              "obligee_21b1"=>$postData['obligee_21b1'],
                              "obligee_21b2"=>$postData['obligee_21b2'],
                              "obligee_21b3"=>$postData['obligee_21b3'],
                              "obligee_21b4"=>$postData['obligee_21b4'],
                              "obligee_21b5"=>$postData['obligee_21b5'],
                              "obligee_21b6"=>$postData['obligee_21b6'],  
                              "obligee_21b1a"=>$postData['obligee_21b1a'],    
                              "obligee_21b2a"=>$postData['obligee_21b2a'],    
                              "obligee_21b3a"=>$postData['obligee_21b3a'],    
                              "obligee_21b4a"=>$postData['obligee_21b4a'],    
                              "obligee_21b5a"=>$postData['obligee_21b5a'],    
                              "obligee_21b6a"=>$postData['obligee_21b6a'],
                              "obligee_21c1"=>$postData['obligee_21c1'],
                              "obligee_21c2"=>$postData['obligee_21c2'],
                              "obligee_21c3"=>$postData['obligee_21c3'],
                              "obligee_21c4"=>$postData['obligee_21c4'],
                              "obligee_21c5"=>$postData['obligee_21c5'],
                              "obligee_21c6"=>$postData['obligee_21c6'],
                              "obligee_21d1"=>$postData['obligee_21d1'],
                              "obligor_21d1"=>$postData['obligor_21d1'],
                              "obligee_21d2"=>$postData['obligee_21d2'],
                              "obligor_21d2"=>$postData['obligor_21d2'],
                              "obligee_21d3"=>$postData['obligee_21d3'],
                              "obligor_21d3"=>$postData['obligor_21d3'],
                              "obligee_21d4"=>$postData['obligee_21d4'],
                              "obligor_21d4"=>$postData['obligor_21d4'],
                              "obligee_21d5"=>$postData['obligee_21d5'],
                              "obligor_21d5"=>$postData['obligor_21d5'],
                              "obligee_21d6"=>$postData['obligee_21d6'],
                              "obligor_21d6"=>$postData['obligor_21d6'],
                              "obligee_21e1"=>$postData['obligee_21e1'],
                              "obligee_21e2"=>$postData['obligee_21e2'],
                              "obligee_21e3"=>$postData['obligee_21e3'],
                              "obligee_21e4"=>$postData['obligee_21e4'],
                              "obligee_21e5"=>$postData['obligee_21e5'],
                              "obligee_21e6"=>$postData['obligee_21e6'],
                              "apportioned_obligee_21_1"=>$postData['apportioned_obligee_21_1'],
                              "apportioned_obligor_21_1"=>$postData['apportioned_obligor_21_1'],
                              "apportioned_obligee_21_2"=>$postData['apportioned_obligee_21_2'],
                              "apportioned_obligor_21_2"=>$postData['apportioned_obligor_21_2'],
                              "apportioned_obligee_21_3"=>$postData['apportioned_obligee_21_3'],
                              "apportioned_obligor_21_3"=>$postData['apportioned_obligor_21_3'],
                              "apportioned_obligee_21_4"=>$postData['apportioned_obligee_21_4'],
                              "apportioned_obligor_21_4"=>$postData['apportioned_obligor_21_4'],
                              "apportioned_obligee_21_5"=>$postData['apportioned_obligee_21_5'],
                              "apportioned_obligor_21_5"=>$postData['apportioned_obligor_21_5'],
                              "apportioned_obligee_21_6"=>$postData['apportioned_obligee_21_6'],
                              "apportioned_obligor_21_6"=>$postData['apportioned_obligor_21_6'],
                              "obligee_21f"=>$postData['obligee_21f'],
                              "obligor_21f"=>$postData['obligor_21f'],
                              "obligee_21fa"=>$postData['obligee_21fa'],
                              "obligor_21fa"=>$postData['obligor_21fa'],
                              "obligee_21fb"=>$postData['obligee_21fb'],
                              "obligor_21fb"=>$postData['obligor_21fb'],
                              "obligee_21fc"=>$postData['obligee_21fc'],
                              "obligor_21fc"=>$postData['obligor_21fc'],
                              "obligee_21fd"=>$postData['obligee_21fd'],
                              "obligor_21fd"=>$postData['obligor_21fd'],
                              "obligee_21_g_radio"=>$postData['obligee_21_g_radio'],
                              "obligor_21_g_radio"=>$postData['obligor_21_g_radio'],
                              "obligee_21_g_override_text"=>$postData['obligee_21_g_override_text'],
                              "obligor_21_g_override_text"=>$postData['obligor_21_g_override_text'],
                              "obligee_21g"=>$postData['obligee_21g'],
                              "obligor_21g"=>$postData['obligor_21g'],
                              "obligee_21h"=>$postData['obligee_21h'],
                              "obligor_21h"=>$postData['obligor_21h'],
                              "obligee_21i"=>$postData['obligee_21i'],
                              "obligor_21i"=>$postData['obligor_21i'],
                              "obligee_21j"=>$postData['obligee_21j'],
                              "obligor_21j"=>$postData['obligor_21j'],
                              "obligee_22"=>$postData['obligee_22'],
                              "obligor_22"=>$postData['obligor_22'],
                              "obligor_24"=>$postData['obligor_24'],
                              "23a_annual_combined_cash_medical_support"=>$postData['obligee_23a'],
                              "obligee_23b"=>$postData['obligee_23b'],
                              "obligor_23b"=>$postData['obligor_23b'],
                              "25a_SpecialUnusual"=>$postData['25a_SpecialUnusual'],
                              "25a_Significant"=>$postData['25a_Significant'],
                              "25a_OtherCourt"=>$postData['25a_OtherCourt'],
                              "25a_Extraordinaryt"=>$postData['25a_Extraordinaryt'],
                              "25a_Extended"=>$postData['25a_Extended'],
                              "25a_ChildStandardt_living"=>$postData['25a_ChildStandardt_living'],
                              "25a_ChildFinancial"=>$postData['25a_ChildFinancial'],
                              "25a_ChildEdOps"=>$postData['25a_ChildEdOps'], 
                              "25a_RelativeParental"=>$postData['25a_RelativeParental'],
                              "25a_ParentalSupport"=>$postData['25a_ParentalSupport'],
                              "25a_ObligeesIncome"=>$postData['25a_ObligeesIncome'],
                              "25a_ChildPost_secondary"=>$postData['25a_ChildPost_secondary'],
                              "25a_ParentalRemarriage"=>$postData['25a_ParentalRemarriage'],
                              "25a_ParentReunCost"=>$postData['25a_ParentReunCost'],
                              "25a_ParentalFederal"=>$postData['25a_ParentalFederal'],
                              "25a_ExtraordinaryChild"=>$postData['25a_ExtraordinaryChild'],
                              "25a_relvant"=>$postData['25a_relvant'],
                              "25a_OtherRelevantText"=>$postData['25a_OtherRelevantText'],
                              "25a_child_sport_deviation_text"=>$postData['25a_child_sport_deviation_text'],
                              "25a_child_sport_non_deviation_text"=>$postData['25a_child_sport_non_deviation_text'], 
                              "obligor_25a"=>$postData['obligor_25a'],
                              "obligor_25b"=>$postData['obligor_25b'],
                              "obligor_25c"=>$postData['obligor_25c'], 
                              "obligor_26"=>$postData['obligor_26'],
                              "obligor_27"=>$postData['obligor_27'],
                              "obligor_28"=>$postData['obligor_28'],
                              "obligor_29"=>$postData['obligor_29'],
                              "obligor_30"=>$postData['obligor_30'],
                              "obligor_31"=>$postData['obligor_31'],
                              "obligor_32"=>$postData['obligor_32'],
                              "form_state"=>$postData['sheet_state'],
                              "form_custody"=>$postData['sheet_custody'],
                              "obligee_1_radio"=>$postData['obligee_1_radio'],
                              "obligor_1_radio"=>$postData['obligor_1_radio'],
                              "obligee_3_c_radio"=>$postData['obligee_3_c_radio'],
                              "obligor_3_c_radio"=>$postData['obligor_3_c_radio'],
                              "25a_child_sport_radio"=>$postData['25a_child_sport_radio'],
                              "counsel_dropdown"=>$postData['counsel_dropdown'],
                              "OhSSCSTrig"=>'1',
                              "updated_at"=>now(),
                          );

                  if(isset($request->case_id)){
                              // die('yes');
                        $sheet_data=DB::table('sole_shared_submissions')->where([['user_id', Auth::user()->id],['case_id', $request->case_id]])->latest('id')->first();
                        if(isset($sheet_data)){
                              DB::table('sole_shared_submissions')->where('id',$sheet_data->id)->update($array2);
                        } else {
                              // die('no');
                              DB::table('sole_shared_submissions')->insert($array2);
                        }
                  } else {      
                        $sheet_data=DB::table('sole_shared_submissions')->where([['user_id', Auth::user()->id],['form_state', $request->sheet_state],['form_custody', $request->sheet_custody]])->whereNull('case_id')->latest('id')->first();
                        if(isset($sheet_data)){
                              DB::table('sole_shared_submissions')->where('id',$sheet_data->id)->update($array2);
                        } else {
                              // die('no');
                              DB::table('sole_shared_submissions')->insert($array2);
                        }
                  }

                  if(isset($request->case_id)){
                        $prefill_data = DB::table('users_attorney_submissions')
                                    ->where([
                                      ['user_id', '=', Auth::user()->id],
                                      ['form_state', '=', $request->sheet_state],
                                      ['form_custody', '=', $request->sheet_custody],
                                      ['case_id', '=', $request->case_id]
                                    ])
                                     ->orderBy('id', 'desc')
                                     ->limit(1)
                                    ->get()->pluck('form_text');
                  } else {
                        $prefill_data = DB::table('users_attorney_submissions')
                                    ->where([
                                      ['user_id', '=', Auth::user()->id],
                                      ['form_state', '=', $request->sheet_state],
                                      ['form_custody', '=', $request->sheet_custody]
                                    ])->whereNull('case_id')
                                     ->orderBy('id', 'desc')
                                     ->limit(1)
                                    ->get()->pluck('form_text');
                  }
                  $postData=unserialize($prefill_data[0]);
                  $ohMinimumWageData=DB::select(DB::raw("select getOHMinimumWage2018(0) AS tmpResult"));
                  $OH_Minimum_Wage = $ohMinimumWageData[0]->tmpResult;
                  $postData['OH_Minimum_Wage']=$OH_Minimum_Wage;

                  $admin_email=Setting::where('setting_key', 'admin_email')->pluck('setting_value')->first();
                  if(!$admin_email){
                    $admin_email=env('APP_EMAIL');
                  }
                  if(isset($request->download_form) && $request->download_form=='Download')
                  {
                        exec('sh /home/ubuntu/.BFLODocs/MacrosScripts/QuickOhCSSS_pdf.sh', $output, $return);
                        // Return will return non-zero upon an error
                        if (!$return)
                        {
                              sleep(5);
                              $response= "PDF Created Successfully";
                              // echo json_encode($response);
                              if(isset($request->case_id)){
                                $data=DB::table('sole_shared_submissions')
                                ->join('states', 'sole_shared_submissions.form_state', '=', 'states.id')
                                ->where('sole_shared_submissions.user_id', Auth::user()->id)
                                ->where('sole_shared_submissions.form_custody', $request->sheet_custody)
                                ->where('sole_shared_submissions.case_id', $request->case_id)
                                ->select('sole_shared_submissions.id','sole_shared_submissions.form_custody', 'sole_shared_submissions.updated_at', 'sole_shared_submissions.created_at','states.state')
                                ->latest('sole_shared_submissions.id')
                                ->first();
                              } else {
                                  $data=DB::table('sole_shared_submissions')
                                ->join('states', 'sole_shared_submissions.form_state', '=', 'states.id')
                                ->where('sole_shared_submissions.user_id', Auth::user()->id)
                                ->where('sole_shared_submissions.form_custody', $request->sheet_custody)
                                ->whereNull('sole_shared_submissions.case_id')
                                ->select('sole_shared_submissions.id','sole_shared_submissions.form_custody', 'sole_shared_submissions.updated_at', 'sole_shared_submissions.created_at','states.state')
                                ->latest('sole_shared_submissions.id')
                                ->first();
                              }
                              $created_at=$data->created_at;
                              $updated_at=$data->updated_at;
                              $datetime=date("m-d-Y_His", strtotime($created_at));
                              $client_lname='NA';
                              if(isset($request->obligee_name) && $request->obligee_name !=''){
                                  $client_fullname=$request->obligee_name;
                                  $client_fullname = explode(" ", $client_fullname);
                                  $client_lname =end($client_fullname);
                                  // if(isset($client_fullname[0])){
                                  //   $client_lname=$client_fullname[0];
                                  // }
                                  // if(isset($client_fullname[1])){
                                  //   $client_lname=$client_fullname[1];
                                  // }
                                  // if(isset($client_fullname[2])){
                                  //   $client_lname=$client_fullname[2];
                                  // }
                              }
                              // dd($data);
                              $path=( public_path() . '/uiodirs/'.Auth::user()->id.'/download/'.$client_lname.'_'.$data->state.'_CS_'.$data->form_custody.'_'.$datetime.'.pdf');
                              $headers = array(
                                    'Content-Type'=> 'application/pdf'
                                  );
                              $filename=$client_lname.'_'.$data->state.'_CS_'.$data->form_custody.'_'.$datetime.'.pdf';
                              if(file_exists($path)){
                                  $download_array=array(
                                    'attorney_id' => Auth::user()->id,
                                    'obligee_name' => $request->obligee_name,
                                    'obligor_name' => $request->obligor_name,
                                    'type' => $request->sheet_custody,
                                    'file_name' => $filename,
                                    'created_at' => $updated_at,
                                    'updated_at' => $updated_at
                                  );
                                  $download=Download::create($download_array);
                                  return redirect()->route('attorney.downloads');
                                    // $response=response()->download($path, $filename, $headers);
                                    // ob_end_clean();
                                    // return $response;

                              }else{
                                  echo $errmsg="Sorry, File that you are trying to download is not available yet. Please <a href='mailto:".$admin_email."'>check this</a> with admin for more details"; die;
                              }
                        }
                        else
                        {
                              // $response= "PDF not created";
                              echo $errmsg="Sorry, File that you are trying to download is not available yet. Please <a href='mailto:".$admin_email."'>check</a> with admin for more details"; die;
                        }

                  }
                  return view('computations.computed.sole_shared',['sheet_custody' =>$request->sheet_custody, 'sheet_state' =>$request->sheet_state, 'chk_prefill'=>$request->chk_prefill, 'case_data'=>$case_data, 'postData'=>$postData, 'attorney_data'=>$attorney_data ])->with('success', 'Computation sheet saved successfully.');

            }


            if((isset($request->submit) && $request->submit=='Calculate') || (isset($request->submit_email) && $request->submit_email=='Print'))
            // if(isset($request->submit) && $request->submit=='Calculate' || )
            {
                  $postData = $request;
                  $ohMinimumWageData=DB::select(DB::raw("select getOHMinimumWage2018(0) AS tmpResult"));
                  $OH_Minimum_Wage = $ohMinimumWageData[0]->tmpResult;
                  $postData['OH_Minimum_Wage']=$OH_Minimum_Wage;

                  /***************** calculation for 02d **************************/
                  $type='obligee';
                  $sum=0;
                  $arr=['a','b','c'];

                  /* SUM ALL 3 FIELDS */
                  for($i = 0;$i < 3;$i++)
                  {
                      $fieldName = $type."_2".$arr[$i];
                      $postData[$fieldName] = ($postData[$fieldName] != '') ? $postData[$fieldName] : 0;
                      $sum += $postData[$fieldName];
                  }

                  /* GOT AVERAGE OF ALL 3 FIELDS */
                  $rsum = ($sum/3);
                  $fieldName = $type."_2d";

                  $postData[$fieldName] = min($rsum,$postData[$type.'_2c']);
                  $type='obligor';
                  $sum=0;
                  $arr=['a','b','c'];

                  /* SUM ALL 3 FIELDS */
                  for($i = 0;$i < 3;$i++)
                  {
                      $fieldName = $type."_2".$arr[$i];
                      $postData[$fieldName] = ($postData[$fieldName] != '') ? $postData[$fieldName] : 0;
                      $sum += $postData[$fieldName];
                  }

                  /* GOT AVERAGE OF ALL 3 FIELDS */

                  $rsum = ($sum/3);
                  $fieldName = $type."_2d";

                  $postData[$fieldName] = min($rsum,$postData[$type.'_2c']);

                  /***************** calculation for 03d **************************/
                  $type='obligee';
                  $postData[$type.'_3a'] = ($postData[$type.'_3a'] != '') ? $postData[$type.'_3a'] : 0;
                  $postData[$type.'_3b'] = ($postData[$type.'_3b'] != '') ? $postData[$type.'_3b'] : 0;

                  if ((isset($postData[$type.'_3_c_radio'])) && ($postData[$type.'_3_c_radio'] == 'manual'))
                  {
                      $postData[$type.'_3c'] = ($postData[$type.'_3_c_override_input'] != '') ? round(($postData[$type.'_3_c_override_input']),2) : 0;

                  } else {

                      $postData[$type.'_3c'] = round((max((0.062 * ($postData[$type.'_3a'] - $postData[$type.'_3b'])), 0)), 2);
                  }

                  $postData[$type.'_3d'] = round(((($postData[$type.'_3a']-$postData[$type.'_3b'])-$postData[$type.'_3c'])), 2);

                  $type='obligor';
                  $postData[$type.'_3a'] = ($postData[$type.'_3a'] != '') ? $postData[$type.'_3a'] : 0;
                  $postData[$type.'_3b'] = ($postData[$type.'_3b'] != '') ? $postData[$type.'_3b'] : 0;

                  if ((isset($postData[$type.'_3_c_radio'])) && ($postData[$type.'_3_c_radio'] == 'manual'))
                  {
                      $postData[$type.'_3c'] = ($postData[$type.'_3_c_override_input'] != '') ? round(($postData[$type.'_3_c_override_input']),2) : 0;

                  } else {

                      $postData[$type.'_3c'] = round((max((0.062 * ($postData[$type.'_3a'] - $postData[$type.'_3b'])), 0)), 2);
                  }

                  $postData[$type.'_3d'] = round(((($postData[$type.'_3a']-$postData[$type.'_3b'])-$postData[$type.'_3c'])), 2);

                  /***************** calculation for 08 **************************/
                  $type='obligor';
                  $postData[$type."_4"]=($postData[$type."_4"]!='')?$postData[$type."_4"]:0;
                  $postData[$type."_5"]=($postData[$type."_5"]!='')?$postData[$type."_5"]:0;
                  $postData[$type."_6"]=($postData[$type."_6"]!='')?$postData[$type."_6"]:0;
                  $postData[$type."_7"]=($postData[$type."_7"]!='')?$postData[$type."_7"]:0;
                  $postData[$type."_8"]=($postData[$type."_8"]!='')?$postData[$type."_8"]:0;

                  $field_7=round(($postData[$type."_1"]+$postData[$type."_2d"]+$postData[$type."_3d"]+$postData[$type."_4"]+$postData[$type."_5"]+$postData[$type."_6"]),2);

                  if($field_7<0)
                  {
                      $field_7=0.00;
                  }

                  $postData[$type."_7"] = $field_7;
                  $postData[$type."_8"] = round(($field_7*.05),2);

                  $type='obligee';
                  $postData[$type."_4"]=($postData[$type."_4"]!='')?$postData[$type."_4"]:0;
                  $postData[$type."_5"]=($postData[$type."_5"]!='')?$postData[$type."_5"]:0;
                  $postData[$type."_6"]=($postData[$type."_6"]!='')?$postData[$type."_6"]:0;
                  $postData[$type."_7"]=($postData[$type."_7"]!='')?$postData[$type."_7"]:0;
                  $postData[$type."_8"]=($postData[$type."_8"]!='')?$postData[$type."_8"]:0;

                  $field_7=round(($postData[$type."_1"]+$postData[$type."_2d"]+$postData[$type."_3d"]+$postData[$type."_4"]+$postData[$type."_5"]+$postData[$type."_6"]),2);

                  if($field_7<0)
                  {
                      $field_7=0.00;
                  }

                  $postData[$type."_7"] = $field_7;
                  $postData[$type."_8"] = round(($field_7*.05),2);

                  /***************** calculation for 09c **************************/
                  $type='obligee';
                  $postData[$type."_9a"] = ($postData[$type."_9a"] != '') ? $postData[$type."_9a"] : 0;
                  $postData[$type."_9b"] = ($postData[$type."_9b"] != '') ? $postData[$type."_9b"] : 0;
                  $postData[$type."_9c"] = ($postData[$type."_9c"] != '') ? $postData[$type."_9c"] : 0;

                  $postData[$type."_9d"] = 0;
                  $postData[$type."_9e"] = 0;
                  $postData[$type."_9f"] = 0;

                  $postData[$type."_9c"] = $postData[$type."_9a"]-$postData[$type."_9b"];

                  $result=DB::select(DB::raw("SELECT getOhioChildSupport2018(".$postData[$type.'_7'].",".$postData[$type.'_9a'].") AS calculation"));


                  if ($postData[$type.'_9a'] == 0)
                  {
                      $postData[$type."_9d"] = 0;

                  } else {

                      $postData[$type."_9d"] = $result[0]->calculation;
                  }

                  if($postData[$type."_9a"]>0)
                      $postData[$type."_9e"]=round(($postData[$type."_9d"]/$postData[$type."_9a"]),2);

                  if($postData[$type."_9c"]>0)
                      $postData[$type."_9f"]=round(($postData[$type."_9e"]*$postData[$type."_9c"]),2);

                  $type='obligor';
                  $postData[$type."_9a"] = ($postData[$type."_9a"] != '') ? $postData[$type."_9a"] : 0;
                  $postData[$type."_9b"] = ($postData[$type."_9b"] != '') ? $postData[$type."_9b"] : 0;
                  $postData[$type."_9c"] = ($postData[$type."_9c"] != '') ? $postData[$type."_9c"] : 0;

                  $postData[$type."_9d"] = 0;
                  $postData[$type."_9e"] = 0;
                  $postData[$type."_9f"] = 0;

                  $postData[$type."_9c"] = $postData[$type."_9a"]-$postData[$type."_9b"];

                  $result=DB::select(DB::raw("SELECT getOhioChildSupport2018(".$postData[$type.'_7'].",".$postData[$type.'_9a'].") AS calculation"));


                  if ($postData[$type.'_9a'] == 0)
                  {
                      $postData[$type."_9d"] = 0;

                  } else {

                      $postData[$type."_9d"] = $result[0]->calculation;
                  }

                  if($postData[$type."_9a"]>0)
                      $postData[$type."_9e"]=round(($postData[$type."_9d"]/$postData[$type."_9a"]),2);

                  if($postData[$type."_9c"]>0)
                      $postData[$type."_9f"]=round(($postData[$type."_9e"]*$postData[$type."_9c"]),2);

                  /***************** calculation for O15 **************************/
                  $type='obligee';
                  $postData[$type."_10b"] = ($postData[$type."_10b"] != '') ? $postData[$type."_10b"] : 0;

                  if((isset($postData[$type."_10a"])) && ($postData[$type."_10a"] == ''))
                  {
                      $postData[$type."_10b"] = 0;
                  }

                  $postData[$type."_11"] = ($postData[$type."_11"] != '') ? $postData[$type."_11"] : 0;
                  $postData[$type."_12"] = $postData[$type."_9f"] + $postData[$type."_10b"] + $postData[$type."_11"];
                  $postData[$type."_13"] = $postData[$type."_7"] - $postData[$type."_12"];
                  $postData[$type."_13"] = ($postData[$type."_13"] > 0) ? $postData[$type."_13"] : 0;
                  $postData[$type."_14"] = $postData[$type."_13"];

                  if((isset($postData[$type."_10a"])) && ($postData[$type."_10a"] == ''))
                  {
                      $postData[$type."_10b"] = 0;
                  }

                  $noChildThisOrder = $postData['number_children_order'];
                  $nthChildThreshholdData=DB::select(DB::raw("SELECT getOH_CS_Shaded_Threshold2018(".$noChildThisOrder.") As tmpResult"));
                  $postData[$type.'_15'] = 0;

                  if (isset($nthChildThreshholdData[0]->tmpResult))
                  {
                      if ((isset($postData[$type.'_14'])) && ($postData[$type.'_14'] <= $nthChildThreshholdData[0]->tmpResult))
                      {
                          $postData[$type.'_15'] = 1;

                      }
                  }

                  $type='obligor';

                  $postData[$type."_10b"] = ($postData[$type."_10b"] != '') ? $postData[$type."_10b"] : 0;

                  if((isset($postData[$type."_10a"])) && ($postData[$type."_10a"] == ''))
                  {
                      $postData[$type."_10b"] = 0;
                  }

                  $postData[$type."_11"] = ($postData[$type."_11"] != '') ? $postData[$type."_11"] : 0;
                  $postData[$type."_12"] = $postData[$type."_9f"] + $postData[$type."_10b"] + $postData[$type."_11"];
                  $postData[$type."_13"] = $postData[$type."_7"] - $postData[$type."_12"];
                  $postData[$type."_13"] = ($postData[$type."_13"] > 0) ? $postData[$type."_13"] : 0;
                  $postData[$type."_14"] = $postData[$type."_13"];

                  if((isset($postData[$type."_10a"])) && ($postData[$type."_10a"] == ''))
                  {
                      $postData[$type."_10b"] = 0;
                  }

                  $noChildThisOrder = $postData['number_children_order'];
                  $nthChildThreshholdData=DB::select(DB::raw("SELECT getOH_CS_Shaded_Threshold2018(".$noChildThisOrder.") As tmpResult"));

                  $postData[$type.'_15'] = 0;

                  if (isset($nthChildThreshholdData[0]->tmpResult))
                  {
                      if ((isset($postData[$type.'_14'])) && ($postData[$type.'_14'] <= $nthChildThreshholdData[0]->tmpResult))
                      {
                          $postData[$type.'_15'] = 1;

                      }
                  }


                  /***************** calculation for O16 **************************/
                  $postData["obligee_16"] = $postData["obligee_14"] + $postData["obligor_14"];


                  /***************** calculation for O18 **************************/
                  $postData["obligee_17"]=0;

                  $postData["obligee_18a"]=0;
                  $postData["obligor_18a"]=0;
                  $postData["obligee_18b"]=0;
                  $postData["obligee_18c"]=0;
                  $postData["obligor_18c"]=0;
                  $postData["obligee_18d"]=0;
                  $postData["obligor_18d"]=0;

                  /**
                   * @TODO :- Warning Check
                   */
                  // $postData["obligee_19a"]=($postData["obligee_19a"]!='')?$postData["obligee_19a"]:0;
                  // $postData["obligor_19a"]=($postData["obligor_19a"]!='')?$postData["obligor_19a"]:0;

                  $postData["obligee_19a"]= $postData["obligee_19a"];
                  $postData["obligor_19a"]= $postData["obligor_19a"];

                  $postData["obligee_19b"]=0;
                  $postData["obligor_19b"]=0;

                  $postData["obligee_20"]=($postData["obligee_20"]!='')?$postData["obligee_20"]:0;
                  $postData["obligor_20"]=($postData["obligor_20"]!='')?$postData["obligor_20"]:0;

                  if($postData["obligee_16"]>0)
                  {
                      $postData["obligee_17"]=round(($postData["obligee_14"]/$postData["obligee_16"])*100,2);
                      $postData["obligor_17"]=round(($postData["obligor_14"]/$postData["obligee_16"])*100,2);
                  }

                  $result=DB::select(DB::raw("SELECT getOhioChildSupport2018(".$postData['obligee_14'].",".$postData['number_children_order'].") AS calculation"));
                  if(isset($result[0]->calculation))
                  {
                      $postData["obligee_18a"]=$result[0]->calculation;
                  }

                  $result=DB::select(DB::raw("SELECT getOhioChildSupport2018(".$postData['obligor_14'].",".$postData['number_children_order'].") AS calculation"));
                  if(isset($result[0]->calculation))
                  {
                      if($result[0]->calculation<960) {

                          $postData["obligor_18a"]=960;
                      } else {

                          $postData["obligor_18a"]=$result[0]->calculation;
                      }
                  }

                  $result=DB::select(DB::raw("SELECT getOhioChildSupport2018(".$postData['obligee_16'].",".$postData['number_children_order'].") AS calculation"));

                  if(isset($result[0]->calculation))
                  {
                      if($result[0]->calculation<960) {
                          $postData["obligee_18b"]=960;
                      } else {
                          $postData["obligee_18b"]=$result[0]->calculation;
                      }
                  }

                  $postData['obligor_17'] = (isset($postData['obligor_17']) && ($postData['obligor_17'] != '')) ? $postData['obligor_17'] : 0;

                  $postData["obligee_18c"]=round(($postData["obligee_18b"]*($postData["obligee_17"]/100)),2);
                  $postData["obligor_18c"]=round(($postData["obligee_18b"]*($postData["obligor_17"]/100)),2);

                  $low18=($postData["obligee_18a"]<$postData["obligee_18c"])?$postData["obligee_18a"]:$postData["obligee_18c"];

                  $low18=($low18<960)?960:$low18;
                  $postData["obligee_18d"]=$low18;
                  $low18=($postData["obligor_18a"]<$postData["obligor_18c"])?$postData["obligor_18a"]:$postData["obligor_18c"];
                  $low18=($low18<960)?960:$low18;
                  $postData["obligor_18d"]=$low18;

                  if(isset($postData["obligee_19a"]) && $postData["obligee_19a"]>0)
                  {
                      $postData["obligee_19b"]=round((($postData["obligee_18d"]*0.10)), 2);
                  } else {
                      $postData["obligee_19b"]=0.00;
                  }

                  if(isset($postData["obligor_19a"]) && $postData["obligor_19a"]>0)
                  {
                      $postData["obligor_19b"]=round((($postData["obligor_18d"]*0.10)), 2);
                  } else {
                      $postData["obligor_19b"]=0.00;
                  }

                  /***************** some required calculations before O21 and 021f **************************/
                              


                  /***************** calculation for O21 and 021f **************************/
                  $obligeeSum = 0;

                  for ($i=1; $i <= 6; $i++)
                  {
                      $postData['obligee_21d'.$i] = ($postData['obligee_21d'.$i] != '') ? $postData['obligee_21d'.$i] : 0;
                      $obligeeSum += $postData['obligee_21d'.$i];
                  }
                  /**Replace " with ' Start ****************************************/

                  $postData['obligee_21a'] = $obligeeSum ?? 0;

                  /**
                   * @TODO :- Warning check
                   */
                  $obligorSum = 0;

                  for ($i=1; $i <= 6; $i++)
                  {
                      $postData['obligor_21d'.$i] = ($postData['obligor_21d'.$i] != '') ? $postData['obligor_21d'.$i] : 0;
                      $obligorSum += $postData['obligor_21d'.$i];
                  }

                  $postData['obligor_21a'] = $obligorSum ?? 0;

                  $postData['obligee_21f'] = 0;
                  $postData['obligor_21f'] = 0;

                  $postData['obligee_21g'] = ($postData['obligee_21g']!='')?$postData['obligee_21g']:0;
                  $postData['obligor_21g'] = ($postData['obligor_21g']!='')?$postData['obligor_21g']:0;

                  $postData['obligee_21h'] = 0;
                  $postData['obligor_21h'] = 0;

                  $postData['obligee_21i'] = 0;
                  $postData['obligor_21i'] = 0;

                  $postData['obligee_21j'] = 0;
                  $postData['obligor_21j'] = 0;

                  $e_total=0;

                  for($i=1;$i<=6;$i++)
                  {
                      $mac=0;
                      if($postData['obligee_21b'.$i]!='')
                      {
                          $res = explode("/", $postData["obligee_21b".$i]);

                          if(count($res)>2)
                          {
                              $newDob = $res[2]."-".$res[0]."-".$res[1];


                              // get month difference
                              $start=date("Y-m-d");
                              $end=$newDob;
                              $end OR $end = time();
                              $start = new DateTime("$start");
                              $end   = new DateTime("$end");
                              $diff  = $start->diff($end);
                              $months_diff=$diff->format('%y') * 12 + $diff->format('%m');


                              if($months_diff<18)
                              {
                                  $mac=11464;
                              }
                              elseif($months_diff>=18 && $months_diff<36)
                              {
                                  $mac=10025;
                              }
                              elseif($months_diff>=36 && $months_diff<72)
                              {
                                  $mac=8600;
                              }
                              elseif($months_diff>=72 && $months_diff<144)
                              {
                                  $mac=7290;
                              }
                              else
                              {
                                  $mac=0;
                              }
                          }


                          if($months_diff<36)
                          {
                              $postData["obligee_21b".$i.'a']=$months_diff." Months";
                          }
                          else
                          {
                              $start=date("Y-m-d");
                              $end=$newDob;
                              $end OR $end = time();
                              $start = new DateTime("$start");
                              $end   = new DateTime("$end");
                              $diff  = $start->diff($end);
                              $postData["obligee_21b".$i.'a']= $diff->format('%y')." Years";
                          }
                      } else {
                          $postData["obligee_21b".$i.'a']= "";
                      }

                      $postData["obligee_21c".$i]=$mac;

                      $postData["obligee_21d".$i]=($postData["obligee_21d".$i]!='')?$postData["obligee_21d".$i]:0;

                      $postData["obligee_21e".$i]=($postData["obligee_21c".$i]<$postData["obligee_21d".$i])?$postData["obligee_21c".$i]:$postData["obligee_21d".$i];

                      $postData["obligee_21e".$i]=($postData["obligee_21e".$i]!='')?$postData["obligee_21e".$i]:0;

                      $e_total=$e_total+$postData["obligee_21e".$i];

                  }
                  /**Replace " with 'End****************************************/

                  for ($i=1; $i < 6; $i++)
                  {
                      $postData['obligee_21e'.$i] = min($postData['obligee_21c'.$i], ($postData['obligee_21d'.$i] + $postData['obligor_21d'.$i]));
                  }

                  //Apportioned Obligee Sum
                  for ($i=1; $i<=6 ; $i++)
                  {
                      $dividerApporObligee = $postData['obligee_21d'.$i] + $postData['obligor_21d'.$i];
                      $dividerApporObligee = ($dividerApporObligee == 0) ? 1 : $dividerApporObligee;

                      $postData['apportioned_obligee_21_'.$i] = round((($postData['obligee_21d'.$i]*($postData['obligee_21e'.$i]/$dividerApporObligee))), 2);
                  }

                  for ($i=1; $i<=6 ; $i++)
                  {
                      $dividerApporObligor = $postData['obligee_21d'.$i] + $postData['obligor_21d'.$i];
                      $dividerApporObligor = ($dividerApporObligor == 0) ? 1 : $dividerApporObligor;

                      $postData['apportioned_obligor_21_'.$i] = round((($postData['obligor_21d'.$i]*($postData['obligee_21e'.$i]/$dividerApporObligor))), 2);
                  }


                  $type='obligee';
                  $obligeeSumAppoint = 0;

                  for ($i=1; $i <= 6; $i++)
                  {
                      $obligeeSumAppoint += $postData['apportioned_obligee_21_'.$i];
                  }

                  $postData["obligee_21f"] = $obligeeSumAppoint ?? 0;

                  /**
                   * @TODO :- Warning Check
                   */

                  if ($type == 'obligee')
                  {
                      
                      $fedChildPerceObligee=DB::select(DB::raw("SELECT getFedChildCareCreditPercentage2018(".$postData['obligee_14'].") AS calculation"));
                      $fedChildPercentageObligee = $fedChildPerceObligee[0]->calculation;

                      $postData['obligee_21fa'] = $fedChildPercentageObligee*100;

                      /***************************************/

                      $childCareCreditData=DB::select(DB::raw("SELECT getFedChildCareCap2018(6) AS calculation"));
                      $childCareCredit = $childCareCreditData[0]->calculation;

                      $postData['obligee_21fb'] = round(($fedChildPercentageObligee * (min(($postData['obligee_1'] + max($postData['obligee_3d'], 0)), $postData['obligee_21f'], $childCareCredit))), 2);

                      /***********************************/

                      $ohChildPerObligeeData=DB::select(DB::raw("SELECT getOhChildCareCreditPercentage2018(".$postData['obligee_14'].") AS calculation"));

                      $ohChildPerObligee = $ohChildPerObligeeData[0]->calculation;

                      $postData['obligee_21fc'] = $ohChildPerObligee*100;

                      /*********************************/
                      // following fromulas are changed on 27-12-2019 22:30:00
                      // $postData['obligee_21fd'] = round(($ohChildPerObligee * $postData['obligee_21f']), 2);
                      $postData['obligee_21fd'] = round(($ohChildPerObligee * $postData['obligee_21fb']), 2);

                      /****************************************/

                  }
                  $type='obligor';

                  /**
                   * @TODO :- Warning Check
                   */
                  $obligorSumAppoint = 0;

                  for ($i=1; $i <= 6; $i++)
                  {
                      $obligorSumAppoint += $postData['apportioned_obligor_21_'.$i];
                  }

                  $postData["obligor_21f"] = $obligorSumAppoint ?? 0;

                  if ($type == 'obligor')
                  {
                     
                      $fedChildPerceObligor=DB::select(DB::raw("SELECT getFedChildCareCreditPercentage2018(".$postData['obligor_14'].") AS calculation"));
                      $fedChildPercentageObligor = $fedChildPerceObligor[0]->calculation;

                      $postData['obligor_21fa'] = $fedChildPercentageObligor*100;

                      /*******************************/

                      $childCareCreditData=DB::select(DB::raw("SELECT getFedChildCareCap2018(6) AS calculation"));
                      $childCareCredit = $childCareCreditData[0]->calculation;

                      $postData['obligor_21fb'] = round(($fedChildPercentageObligor * (min(($postData['obligor_1'] + max($postData['obligor_3d'], 0)), $postData['obligor_21f'], $childCareCredit))), 2);

                      /*********************************/

                      $ohChildPerObligorData=DB::select(DB::raw("SELECT getOhChildCareCreditPercentage2018(".$postData['obligor_14'].") AS calculation"));
                      $ohChildPerObligor = $ohChildPerObligorData[0]->calculation;

                      $postData['obligor_21fc'] = $ohChildPerObligor*100;

                      /********************************/
                       // following fromulas are changed on 27-12-2019 22:30:00
                      // $postData['obligor_21fd'] = round(($ohChildPerObligor * $postData['obligor_21f']), 2);
                      $postData['obligor_21fd'] = round(($ohChildPerObligor * $postData['obligor_21fb']), 2);

                      /****************************************/

                  }

                  if (isset($postData['obligee_21_g_radio']) && ($postData['obligee_21_g_radio'] == 'calculation'))
                  {
                      $postData['obligee_21g'] = $postData['obligee_21fb'] + $postData['obligee_21fd'];

                  } else {

                      $postData['obligee_21g'] = $postData['obligee_21_g_override_text'];
                  }

                  if (isset($postData['obligor_21_g_radio']) && ($postData['obligor_21_g_radio'] == 'calculation'))
                  {
                      $postData['obligor_21g'] = $postData['obligor_21fb'] + $postData['obligor_21fd'];

                  } else {

                      $postData['obligor_21g'] = $postData['obligor_21_g_override_text'];
                  }

                  /**
                   * 21 h formula changed by client itself
                   * overide the old one i.e present below
                   * commented
                   */
                  if($postData['obligee_21f'] > 0)
                  {
                      $postData['obligee_21h'] = $postData['obligee_21f'] - $postData['obligee_21g'];
                  }

                  if($postData['obligor_21f'] > 0)
                  {
                      $postData['obligor_21h'] = $postData['obligor_21f'] - $postData['obligor_21g'];
                  }

                  /**
                   * Code need to be cleaned after client
                   * approval
                   */
                  // $postData["obligee_21f"] = $e_total;
                  // $postData["obligor_21f"] = $e_total;

                  // if($postData["obligee_21f"]>0)
                  // {
                  //  $postData["obligee_21h"] = $postData["obligee_21f"] - ($postData["obligee_21g"]+$postData["obligor_21g"]);
                  // }

                  // if($postData["obligor_21f"]>0)
                  // {
                  //  $postData["obligor_21h"] = $postData["obligor_21f"]-($postData["obligee_21g"]+$postData["obligor_21g"]);
                  // }
                  // echo "<pre>";print_r($postData['obligee_17']);die();

                  if($postData['obligee_15']==1)
                  {
                      // L21i(C1)=MIN(L17(C1),0.50)(L21h(C1)+L21h(C2));
                      // $postData["obligee_21i"]=((min($postData["obligee_17"],50)/100))*$postData["obligee_21h"];

                      $postData["obligee_21i"]= min(($postData['obligee_17']/100), 0.50) * ($postData['obligee_21h'] + $postData['obligor_21h']);

                  } else {

                      // L21i(C1)=L17(C1)(L21h(C1)+L21h(C2)
                      // $postData["obligee_21i"]=(($postData["obligee_17"]/100)*$postData["obligee_21h"]);

                      $postData["obligee_21i"]=(($postData["obligee_17"]/100) * ($postData['obligee_21h'] + $postData['obligor_21h']));
                  }
                  if($postData['obligor_15']==1)
                  {
                      // $postData["obligor_21i"]=((min($postData["obligor_17"],50)/100))*$postData["obligor_21h"];
                      $postData["obligor_21i"]= round((min(($postData['obligor_17']/100), 0.50) * ($postData['obligee_21h'] + $postData['obligor_21h'])), 2);

                  } else {

                      // $postData["obligor_21i"]=(($postData["obligor_17"]/100)*$postData["obligor_21h"]);
                      $postData["obligor_21i"]=round(((($postData["obligor_17"]/100) * ($postData['obligee_21h'] + $postData['obligor_21h']))), 2);
                  }

                  // $postData["obligee_21j"]=($postData["obligee_21f"]-$postData["obligee_21a"]);
                  // $postData["obligor_21j"]=($postData["obligor_21f"]-$postData["obligor_21a"]);

                  $postData["obligee_21j"]=($postData["obligee_21i"]-$postData["obligee_21a"]);
                  $postData["obligor_21j"]=($postData["obligor_21i"]-$postData["obligor_21a"]);

                  $postData["obligee_21j"]=($postData["obligee_21j"]>0)?$postData["obligee_21j"]:0;
                  $postData["obligor_21j"]=($postData["obligor_21j"]>0)?$postData["obligor_21j"]:0;

                  $postData["obligee_22"]=($postData["obligee_18d"]-$postData["obligee_19b"]-$postData["obligee_20"])+$postData["obligee_21j"];

                  $postData["obligor_22"]=($postData["obligor_18d"]-$postData["obligor_19b"]-$postData["obligor_20"])+$postData["obligor_21j"];

                  $postData["obligee_22"]=($postData["obligee_22"]>0)?$postData["obligee_22"]:0;
                  $postData["obligor_22"]=($postData["obligor_22"]>0)?$postData["obligor_22"]:0;

                  /**
                   * If g is having radio value manual
                   * then 21 h shoild be like below
                   */
                  if (isset($postData['obligee_21_g_radio']) && ($postData['obligee_21_g_radio'] == 'manual'))
                  {
                      $postData['obligee_21h'] = $postData['obligee_21f'] - $postData['obligee_21g'];
                  }

                  if (isset($postData['obligor_21_g_radio']) && ($postData['obligor_21_g_radio'] == 'manual'))
                  {
                      $postData['obligor_21h'] = $postData['obligor_21f'] - $postData['obligor_21g'];
                  }


                  /******************* calculations for 025 ****************************/

                  if (isset($postData['25a_child_sport_radio']) && ($postData['25a_child_sport_radio'] == 'deviation'))
                  {
                      $postData['25a_child_sport_deviation_text'] = (isset($postData['25a_child_sport_deviation_text']) && ($postData['25a_child_sport_deviation_text'] != '')) ? $postData['25a_child_sport_deviation_text'] : 0;

                      $postData['obligor_25a'] = $postData['25a_child_sport_deviation_text'];

                  } else {

                      $postData['25a_child_sport_non_deviation_text'] = (isset($postData['25a_child_sport_non_deviation_text']) && ($postData['25a_child_sport_non_deviation_text'] != '')) ? $postData['25a_child_sport_non_deviation_text'] : 0;

                      $postData['obligor_25a'] = $postData['25a_child_sport_non_deviation_text'] - $postData['obligor_24'];
                  }

                  /******************* calculations for 024 ****************************/
                  $combinedGrossIncome = $postData['obligee_1'] + $postData['obligor_1'];
                  $combinedGrossIncome = ($combinedGrossIncome == '') ? 0 : $combinedGrossIncome;

                  $ohCashMedicalData=DB::select(DB::raw("SELECT getOHCashMedical2018(".$combinedGrossIncome.",".$postData['number_children_order'].") As tmpResult"));

                  $postData["obligee_24"]=0;
                  $postData["obligor_24"]=0;

                  $postData["obligee_25a"]=((isset($postData["obligee_25a"])) && ($postData["obligee_25a"]!='')) ? $postData["obligee_25a"]:0;
                  $postData["obligor_25a"]=((isset($postData["obligor_25a"])) && ($postData["obligor_25a"]!='')) ? $postData["obligor_25a"]:0;
                  $postData["obligee_25b"]=((isset($postData["obligee_25b"])) && ($postData["obligee_25b"]!='')) ? $postData["obligee_25b"]:0;
                  $postData["obligor_25b"]=((isset($postData["obligor_25b"])) && ($postData["obligor_25b"]!='')) ? $postData["obligor_25b"]:0;

                  $postData["obligee_25c"]=0;
                  $postData["obligor_25c"]=0;
                  $postData["obligee_27"]=0;
                  $postData["obligor_27"]=0;

                  $postData["obligee_28"]= ((isset($postData["obligee_28"])) && ($postData["obligee_28"] != '')) ? $postData["obligee_28"] : 0;
                  $postData["obligor_28"]= ((isset($postData["obligor_28"])) && ($postData["obligor_28"] != '')) ? $postData["obligor_28"] : 0;

                  $postData["obligee_29"]=0;
                  $postData["obligor_29"]=0;
                  $postData["obligee_30"]=0;
                  $postData["obligor_30"]=0;

                  $postData['obligee_23a'] = @$ohCashMedicalData[0]->tmpResult;
                  // $postData['obligee_23a']=1554.80;
                  $postData['obligee_23b']=($postData['obligee_23a']*($postData['obligee_17']/100));
                  $postData['obligor_23b']=($postData['obligee_23a']*($postData['obligor_17']/100));

                  if($postData['obligee_22']>0)
                  {
                      $postData['obligee_24']=($postData['obligee_22']/12);
                  }

                  if($postData['obligor_22']>0)
                  {
                      $postData['obligor_24']=($postData['obligor_22']/12);
                  }

                  $postData['obligee_25c']=($postData['obligee_25a']+$postData['obligee_25b']);
                  $postData['obligor_25c']=($postData['obligor_25a']+$postData['obligor_25b']);

                  $postData['obligee_26']=($postData['obligee_24']+$postData['obligee_25c']);
                  $postData['obligor_26']=($postData['obligor_24']+$postData['obligor_25c']);

                  $postData['obligee_27'] = ($postData['obligee_23b']/12);
                  $postData['obligor_27'] = round(($postData['obligor_23b']/12), 2);          

                  // if($postData['obligee_23b']>0)
                  // {
                  //  $postData['obligee_27'] = ($postData['obligee_23b']/12);
                  //  }

                  // if($postData['obligee_23b'] > 0)
                  // {            
                  //      $postData['obligor_27'] = round(($postData['obligor_23b']/12), 2);          
                  //  }

                  $postData['obligee_29']=($postData['obligee_27']+$postData['obligee_28']);
                  $postData['obligor_29']=($postData['obligor_27']+$postData['obligor_28']);

                  //  echo "<pre>";print_r($postData['obligor_28']);die();
                  //  $postData['obligee_30']=($postData['obligee_24']+$postData['obligee_25c']+$postData['obligee_27']+$postData['obligee_28']);
                  //  $postData['obligor_30']=($postData['obligor_24']+$postData['obligor_25c']+$postData['obligor_27']+$postData['obligor_28']);
                  //  L30 = L26 + L29

                  $postData['obligee_30']=($postData['obligee_26']+$postData['obligee_29']);
                  $postData['obligor_30']=($postData['obligor_26']+$postData['obligor_29']);

                  /******************* calculations for 031 ****************************/
                  $postData['obligor_31'] = ($postData['obligor_30'] * 0.02);
                  $postData['obligor_32'] = ($postData['obligor_31'] + $postData['obligor_30']);

                  // to get children names
                  // $childreninfo=DrChildren::where('case_id',$request->case_id)->get()->first();
                  // if(isset($childreninfo)){
                  //     $children_length=array('First','Second','Third','Fourth','Fifth','Sixth','Seventh','Eigth');
                  //     for ($i=0; $i < $postData['number_children_order']; $i++) {
                  //         $b=$i+1;
                  //         $postData['obligee_21b'.$b.'_child_name']=NULL;

                  //         $obj_key='This_Marriage_'.$children_length[$i].'_Child_DOB';
                  //         $postData['obligee_21b'.$b.'']=date("m/d/Y", strtotime($childreninfo->{$obj_key}));

                  //         $obj_key2='This_Marriage_'.$children_length[$i].'_Child_FirstName';
                  //         $postData['obligee_21b'.$b.'_child_name']=$childreninfo->{$obj_key2};
                  //     }
                  // }

                  if(isset($request->submit_email) && $request->submit_email=='Print'){
                        return view('computations.computed.sole_shared',['sheet_custody' =>$request->sheet_custody, 'sheet_state' =>$request->sheet_state, 'chk_prefill'=>$request->chk_prefill, 'case_data'=>$case_data, 'postData'=>$postData, 'attorney_data'=>$attorney_data ])->with('print_sheet', '1');
                  }

                  return view('computations.computed.sole_shared',['sheet_custody' =>$request->sheet_custody, 'sheet_state' =>$request->sheet_state, 'chk_prefill'=>$request->chk_prefill, 'case_data'=>$case_data, 'postData'=>$postData, 'attorney_data'=>$attorney_data ])->with('bottom_scroll', '');

            }


            if($request->chk_prefill=='1'){
                  if(isset($request->case_id)){
                  $prefill_data = DB::table('users_attorney_submissions')
                                    ->where([
                                      ['user_id', '=', Auth::user()->id],
                                      ['form_state', '=', $request->sheet_state],
                                      ['form_custody', '=', $request->sheet_custody],
                                      ['case_id', '=', $request->case_id]
                                    ])
                                     ->orderBy('id', 'desc')
                                     ->limit(1)
                                    ->get()->pluck('form_text');
                  } else {
                        $prefill_data = DB::table('users_attorney_submissions')
                                    ->where([
                                      ['user_id', '=', Auth::user()->id],
                                      ['form_state', '=', $request->sheet_state],
                                      ['form_custody', '=', $request->sheet_custody]
                                    ])->whereNull('case_id')
                                     ->orderBy('id', 'desc')
                                     ->limit(1)
                                    ->get()->pluck('form_text');
                  }                  
                  if(isset($prefill_data[0])){
                        $postData=unserialize($prefill_data[0]);
                        $ohMinimumWageData=DB::select(DB::raw("select getOHMinimumWage2018(0) AS tmpResult"));
                        $OH_Minimum_Wage = $ohMinimumWageData[0]->tmpResult;
                        $postData['OH_Minimum_Wage']=$OH_Minimum_Wage;
                        return view('computations.computed.sole_shared',['sheet_custody' =>$request->sheet_custody, 'sheet_state' =>$request->sheet_state, 'chk_prefill'=>$request->chk_prefill, 'case_data'=>$case_data, 'postData'=>$postData, 'attorney_data'=>$attorney_data ]);
                  } else{
                        $ohMinimumWageData=DB::select(DB::raw("select getOHMinimumWage2018(0) AS tmpResult"));
                        $OH_Minimum_Wage = $ohMinimumWageData[0]->tmpResult;
                        return view('computations.computed.sole_shared',['sheet_custody' =>$request->sheet_custody, 'sheet_state' =>$request->sheet_state, 'chk_prefill'=>$request->chk_prefill, 'case_data'=>$case_data, 'attorney_data'=>$attorney_data, 'OH_Minimum_Wage'=>$OH_Minimum_Wage]);
                  }                                    
                  
            }
            $ohMinimumWageData=DB::select(DB::raw("select getOHMinimumWage2018(0) AS tmpResult"));
            $OH_Minimum_Wage = $ohMinimumWageData[0]->tmpResult;
            return view('computations.computed.sole_shared',['sheet_custody' =>$request->sheet_custody, 'sheet_state' =>$request->sheet_state, 'chk_prefill'=>$request->chk_prefill, 'attorney_data'=>$attorney_data, 'case_data'=>$case_data, 'OH_Minimum_Wage'=>$OH_Minimum_Wage]);


      }



      /* Save/Download Computed Split Computation Sheet */
      public function splitSheet(Request $request)
      {

            /* STEP 1 */
            $case_data['case_id'] = $request->case_id;
            $attorney_data = User::find(Auth::user()->id)->attorney;
            if(isset($request->submit_email) && $request->submit_email=='Print')
            {
                  $postData = $request;
                  // calculate code for split sheet before save/download
                  $ohMinimumWageData=DB::select(DB::raw("select getOHMinimumWage2018(0) AS tmpResult"));
                  $OH_Minimum_Wage = $ohMinimumWageData[0]->tmpResult;
                  $postData['OH_Minimum_Wage']=$OH_Minimum_Wage;
                  /******************* calculations for 02d ****************************/
                  $type='obligee';
                  $sum=0;
                  $arr=['a','b','c'];

                  /* SUM ALL 3 FIELDS */
                  for($i = 0;$i < 3;$i++)
                  {
                        $fieldName = $type."_2".$arr[$i];
                        $postData[$fieldName] = ($postData[$fieldName] != '') ? $postData[$fieldName] : 0;
                        $sum += $postData[$fieldName];
                  }

                  /* GOT AVERAGE OF ALL 3 FIELDS */
                  $rsum = ($sum/3);
                  $fieldName = $type."_2d";

                  $postData[$fieldName] = min($rsum,$postData[$type.'_2c']);

                  $type='obligor';
                  $sum=0;
                  $arr=['a','b','c'];

                  /* SUM ALL 3 FIELDS */
                  for($i = 0;$i < 3;$i++)
                  {
                        $fieldName = $type."_2".$arr[$i];
                        $postData[$fieldName] = ($postData[$fieldName] != '') ? $postData[$fieldName] : 0;
                        $sum += $postData[$fieldName];
                  }

                  /* GOT AVERAGE OF ALL 3 FIELDS */
                  $rsum = ($sum/3);
                  $fieldName = $type."_2d";

                  $postData[$fieldName] = min($rsum,$postData[$type.'_2c']);

                  /******************* calculations for 03d ****************************/
                  $type='obligee';
                  $postData[$type.'_3a'] = ($postData[$type.'_3a'] != '') ? $postData[$type.'_3a'] : 0;
                  $postData[$type.'_3b'] = ($postData[$type.'_3b'] != '') ? $postData[$type.'_3b'] : 0;

                  if ((isset($postData[$type.'_3_c_radio'])) && ($postData[$type.'_3_c_radio'] == 'manual'))
                  {
                              $postData[$type.'_3c'] = ($postData[$type.'_3_c_override_input'] != '') ? round(($postData[$type.'_3_c_override_input']),2) : 0;

                  } else {

                        $postData[$type.'_3c'] = round((max((0.062 * ($postData[$type.'_3a'] - $postData[$type.'_3b'])), 0)), 2);
                  }

                  $postData[$type.'_3d'] = round(((($postData[$type.'_3a']-$postData[$type.'_3b'])-$postData[$type.'_3c'])), 2);

                  $type='obligor';
                  $postData[$type.'_3a'] = ($postData[$type.'_3a'] != '') ? $postData[$type.'_3a'] : 0;
                  $postData[$type.'_3b'] = ($postData[$type.'_3b'] != '') ? $postData[$type.'_3b'] : 0;

                  if ((isset($postData[$type.'_3_c_radio'])) && ($postData[$type.'_3_c_radio'] == 'manual'))
                  {
                              $postData[$type.'_3c'] = ($postData[$type.'_3_c_override_input'] != '') ? round(($postData[$type.'_3_c_override_input']),2) : 0;

                  } else {

                        $postData[$type.'_3c'] = round((max((0.062 * ($postData[$type.'_3a'] - $postData[$type.'_3b'])), 0)), 2);
                  }

                  $postData[$type.'_3d'] = round(((($postData[$type.'_3a']-$postData[$type.'_3b'])-$postData[$type.'_3c'])), 2);


                  /******************* calculations for 08 ****************************/
                  $type='obligee';
                  $postData[$type."_4"]=($postData[$type."_4"]!='')?$postData[$type."_4"]:0;
                  $postData[$type."_5"]=($postData[$type."_5"]!='')?$postData[$type."_5"]:0;
                  $postData[$type."_6"]=($postData[$type."_6"]!='')?$postData[$type."_6"]:0;
                  $postData[$type."_7"]=($postData[$type."_7"]!='')?$postData[$type."_7"]:0;
                  $postData[$type."_8"]=($postData[$type."_8"]!='')?$postData[$type."_8"]:0;

                  $field_7=round(($postData[$type."_1"]+$postData[$type."_2d"]+$postData[$type."_3d"]+$postData[$type."_4"]+$postData[$type."_5"]+$postData[$type."_6"]),2);

                  if($field_7<0)
                  {
                        $field_7=0.00;
                  }

                  $postData[$type."_7"] = $field_7;
                  $postData[$type."_8"] = round(($field_7*.05),2);

                  $type='obligor';
                  $postData[$type."_4"]=($postData[$type."_4"]!='')?$postData[$type."_4"]:0;
                  $postData[$type."_5"]=($postData[$type."_5"]!='')?$postData[$type."_5"]:0;
                  $postData[$type."_6"]=($postData[$type."_6"]!='')?$postData[$type."_6"]:0;
                  $postData[$type."_7"]=($postData[$type."_7"]!='')?$postData[$type."_7"]:0;
                  $postData[$type."_8"]=($postData[$type."_8"]!='')?$postData[$type."_8"]:0;

                  $field_7=round(($postData[$type."_1"]+$postData[$type."_2d"]+$postData[$type."_3d"]+$postData[$type."_4"]+$postData[$type."_5"]+$postData[$type."_6"]),2);

                  if($field_7<0)
                  {
                        $field_7=0.00;
                  }

                  $postData[$type."_7"] = $field_7;
                  $postData[$type."_8"] = round(($field_7*.05),2);


                  /******************* calculations for 09c ****************************/
                  $type='obligee';
                  $postData[$type."_9a"] = ($postData[$type."_9a"] != '') ? $postData[$type."_9a"] : 0;
                  $postData[$type."_9b"] = ($postData[$type."_9b"] != '') ? $postData[$type."_9b"] : 0;
                  $postData[$type."_9c"] = ($postData[$type."_9c"] != '') ? $postData[$type."_9c"] : 0;

                  $postData[$type."_9d"] = 0;
                  $postData[$type."_9e"] = 0;
                  $postData[$type."_9f"] = 0;

                  $postData[$type."_9c"] = $postData[$type."_9a"]-$postData[$type."_9b"];

                  $result=DB::select(DB::raw("SELECT getOhioChildSupport2018(".$postData[$type.'_7'].",".$postData[$type.'_9a'].") AS calculation"));


                  if ($postData[$type.'_9a'] == 0)
                  {
                      $postData[$type."_9d"] = 0;

                  } else {

                      $postData[$type."_9d"] = $result[0]->calculation;
                  }

                  if($postData[$type."_9a"]>0)
                      $postData[$type."_9e"]=round(($postData[$type."_9d"]/$postData[$type."_9a"]),2);

                  if($postData[$type."_9c"]>0)
                      $postData[$type."_9f"]=round(($postData[$type."_9e"]*$postData[$type."_9c"]),2);

                  $type='obligor';
                  $postData[$type."_9a"] = ($postData[$type."_9a"] != '') ? $postData[$type."_9a"] : 0;
                  $postData[$type."_9b"] = ($postData[$type."_9b"] != '') ? $postData[$type."_9b"] : 0;
                  $postData[$type."_9c"] = ($postData[$type."_9c"] != '') ? $postData[$type."_9c"] : 0;

                  $postData[$type."_9d"] = 0;
                  $postData[$type."_9e"] = 0;
                  $postData[$type."_9f"] = 0;

                  $postData[$type."_9c"] = $postData[$type."_9a"]-$postData[$type."_9b"];

                  $result=DB::select(DB::raw("SELECT getOhioChildSupport2018(".$postData[$type.'_7'].",".$postData[$type.'_9a'].") AS calculation"));


                  if ($postData[$type.'_9a'] == 0)
                  {
                      $postData[$type."_9d"] = 0;

                  } else {

                      $postData[$type."_9d"] = $result[0]->calculation;
                  }

                  if($postData[$type."_9a"]>0)
                      $postData[$type."_9e"]=round(($postData[$type."_9d"]/$postData[$type."_9a"]),2);

                  if($postData[$type."_9c"]>0)
                      $postData[$type."_9f"]=round(($postData[$type."_9e"]*$postData[$type."_9c"]),2);

                  /***************** calculation for 015 **************************/
                  $type='obligee';
                  $postData[$type."_10b"] = ($postData[$type."_10b"] != '') ? $postData[$type."_10b"] : 0;

                  if((isset($postData[$type."_10a"])) && ($postData[$type."_10a"] == ''))
                  {
                      $postData[$type."_10b"] = 0;
                  }

                  $postData[$type."_11"] = ($postData[$type."_11"] != '') ? $postData[$type."_11"] : 0;
                  $postData[$type."_12"] = $postData[$type."_9f"] + $postData[$type."_10b"] + $postData[$type."_11"];
                  $postData[$type."_13"] = $postData[$type."_7"] - $postData[$type."_12"];
                  $postData[$type."_13"] = ($postData[$type."_13"] > 0) ? $postData[$type."_13"] : 0;
                  $postData[$type."_14"] = $postData[$type."_13"];

                  if((isset($postData[$type."_10a"])) && ($postData[$type."_10a"] == ''))
                  {
                      $postData[$type."_10b"] = 0;
                  }

                  $noChildThisOrder = $postData['number_children_order'];
                  $nthChildThreshholdData=DB::select(DB::raw("SELECT getOH_CS_Shaded_Threshold2018(".$noChildThisOrder.") As tmpResult"));
                  $postData[$type.'_15'] = 0;

                  if (isset($nthChildThreshholdData[0]->tmpResult))
                  {
                      if ((isset($postData[$type.'_14'])) && ($postData[$type.'_14'] <= $nthChildThreshholdData[0]->tmpResult))
                      {
                          $postData[$type.'_15'] = 1;

                      }
                  }

                  $type='obligor';

                  $postData[$type."_10b"] = ($postData[$type."_10b"] != '') ? $postData[$type."_10b"] : 0;

                  if((isset($postData[$type."_10a"])) && ($postData[$type."_10a"] == ''))
                  {
                      $postData[$type."_10b"] = 0;
                  }

                  $postData[$type."_11"] = ($postData[$type."_11"] != '') ? $postData[$type."_11"] : 0;
                  $postData[$type."_12"] = $postData[$type."_9f"] + $postData[$type."_10b"] + $postData[$type."_11"];
                  $postData[$type."_13"] = $postData[$type."_7"] - $postData[$type."_12"];
                  $postData[$type."_13"] = ($postData[$type."_13"] > 0) ? $postData[$type."_13"] : 0;
                  $postData[$type."_14"] = $postData[$type."_13"];

                  if((isset($postData[$type."_10a"])) && ($postData[$type."_10a"] == ''))
                  {
                      $postData[$type."_10b"] = 0;
                  }

                  $noChildThisOrder = $postData['number_children_order'];
                  $nthChildThreshholdData=DB::select(DB::raw("SELECT getOH_CS_Shaded_Threshold2018(".$noChildThisOrder.") As tmpResult"));

                  $postData[$type.'_15'] = 0;

                  if (isset($nthChildThreshholdData[0]->tmpResult))
                  {
                      if ((isset($postData[$type.'_14'])) && ($postData[$type.'_14'] <= $nthChildThreshholdData[0]->tmpResult))
                      {
                          $postData[$type.'_15'] = 1;

                      }
                  }

                  /***************** calculation for 016 **************************/
                  $postData["obligee_16"] = $postData["obligee_14"] + $postData["obligor_14"];

                  /***************** calculation for 018split **************************/
                  $postData["obligee_17"]=0;

                  $postData["obligee_18a1"]=0;
                  $postData["obligor_18a1"]=0;
                  $postData["obligee_18a2"]=0;
                  $postData["obligor_18a2"]=0;

                  $postData["obligee_18b"]=0;
                  $postData["obligee_18c"]=0;
                  $postData["obligor_18c"]=0;
                  $postData["obligee_18d"]=0;
                  $postData["obligor_18d"]=0;

                  $postData["obligee_19a"]=((isset($postData['obligee_19a'])) && ($postData["obligee_19a"]!=''))?$postData["obligee_19a"]:0;
                  $postData["obligor_19a"]=((isset($postData['obligor_19a'])) && ($postData["obligor_19a"]!=''))?$postData["obligor_19a"]:0;

                  $postData["obligee_19b"]=0;
                  $postData["obligor_19b"]=0;

                  $postData["obligee_20"]=((isset($postData['obligee_20'])) && ($postData["obligee_20"]!=''))?$postData["obligee_20"]:0;
                  $postData["obligor_20"]=((isset($postData['obligor_20'])) && ($postData["obligor_20"]!=''))?$postData["obligor_20"]:0;

                  if($postData["obligee_16"]>0)
                  {
                  $postData["obligee_17"]=round(($postData["obligee_14"]/$postData["obligee_16"])*100,2);
                  $postData["obligor_17"]=round(($postData["obligor_14"]/$postData["obligee_16"])*100,2);
                  }

                  $result=DB::select(DB::raw("SELECT getOhioChildSupport2018(".$postData['obligee_14'].",".$postData['parent_a_children'].") AS calculation"));

                  if(isset($result[0]->calculation))
                  {
                        $postData["18a1"]=max($result[0]->calculation,960);
                  }


                  $result=DB::select(DB::raw("SELECT getOhioChildSupport2018(".$postData['obligor_14'].",".$postData['parent_a_children'].") AS calculation"));

                  if(isset($result[0]->calculation))
                  {
                        $postData["18a2"]=max($result[0]->calculation,960);
                  }

                  $result=DB::select(DB::raw("SELECT getOhioChildSupport2018(".$postData['obligee_14'].",".$postData['parent_b_children'].") AS calculation"));

                  if(isset($result[0]->calculation))
                  {
                        $postData["18a3"]=max($result[0]->calculation,960);
                  }


                  
                  $result=DB::select(DB::raw("SELECT getOhioChildSupport2018(".$postData['obligor_14'].",".$postData['parent_b_children'].") AS calculation"));

                  if(isset($result[0]->calculation))
                  {
                        $postData["18a4"]=max($result[0]->calculation,960);
                  }


                  
                  $result=DB::select(DB::raw("SELECT getOhioChildSupport2018(".$postData['obligee_16'].",".$postData['parent_a_children'].") AS calculation"));

                  if(isset($result[0]->calculation))
                  {
                        $postData["obligee_18b"] = max($result[0]->calculation,960);
                  }

                  $result=DB::select(DB::raw("SELECT getOhioChildSupport2018(".$postData['obligee_16'].",".$postData['parent_b_children'].") AS calculation"));

                  $postData["obligor_18b"] = (isset($postData['obligor_18b']) && $postData['obligor_18b'] != 0) ? $postData['obligor_18b'] : 0;
                  if(isset($result[0]->calculation))
                  {
                        $postData["obligor_18b"] = max($result[0]->calculation,960);
                  }

                  $postData["18c1"]=round(($postData["obligee_18b"]*($postData["obligee_17"]/100)),2);
                  $postData["18c2"]=round(($postData["obligee_18b"]*($postData["obligor_17"]/100)),2);
                  $postData["18c3"]=round(($postData["obligor_18b"]*($postData["obligee_17"]/100)),2);
                  $postData["18c4"]=round(($postData["obligor_18b"]*($postData["obligor_17"]/100)),2);

                  $low18=min($postData["18a1"],$postData["18c1"]);
                  $low18=max($low18,960);
                  $postData["18d1"]=$low18;

                  $low18=min($postData["18a2"],$postData["18c2"]);
                  $low18=max($low18,960);
                  $postData["18d2"]=$low18;

                  $low18=min($postData["18a3"],$postData["18c3"]);
                  $low18=max($low18,960);
                  $postData["18d3"]=$low18;

                  $low18=min($postData["18a4"],$postData["18c4"]);
                  $low18=max($low18,960);
                  $postData["18d4"]=$low18;

                  // formulas to calculate "obligee_19b" and "obligor_19b" are swapped
                  if(isset($postData["obligee_19a"]) && $postData["obligee_19a"]>0)
                  {
                        // $postData["obligee_19b"]=($postData["18d3"]*0.10);
                        $postData["obligee_19b"]=($postData["18d2"]*0.10);
                  } else {
                        $postData["obligee_19b"]=0;
                  }

                  if(isset($postData["obligor_19a"]) && $postData["obligor_19a"]>0)
                  {
                        $postData["obligor_19b"]=($postData["18d3"]*0.10);
                        // $postData["obligor_19b"]=($postData["18d2"]*0.10);
                  } else {
                        $postData["obligor_19b"]=0;
                  }

                  /***************** calculation for O21csplit **************************/
                  
                  $postData["20a2"]=($postData["20a2"]!='')?$postData["20a2"]:0;
                  $postData["20a3"]=($postData["20a3"]!='')?$postData["20a3"]:0;

                  /**
                   * Create a Function to calculate the sum
                   */
                  $type='obligee';
                  $lineNo=21;
                  $lineSubrow='d';
                  $name = $type.'_'.$lineNo.''.$lineSubrow;
                  $a = 0;

                  for ($i=1; $i <= 6; $i++)
                  {
                      if($postData['obligee_21b'.$i] !=''){
                        $postData[$name.''.$i] = ($postData[$name.''.$i] != '') ? $postData[$name.''.$i] : 0;
                      } else {
                        $postData[$name.''.$i]=0;
                      }
                      $a += $postData[$name.''.$i];
                  }
                  $postData['21a1'] = $a ?? 0;

                  $type='obligor';
                  $lineNo=21;
                  $lineSubrow='d';
                  $name = $type.'_'.$lineNo.''.$lineSubrow;
                  $a = 0;

                  for ($i=1; $i <= 6; $i++)
                  {
                      if($postData['obligee_21b'.$i] !=''){
                        $postData[$name.''.$i] = ($postData[$name.''.$i] != '') ? $postData[$name.''.$i] : 0;
                      } else {
                        $postData[$name.''.$i]=0;
                      }
                        $a += $postData[$name.''.$i];
                  }
                  $postData['21a2'] = $a ?? 0;

                  $type='obligee';
                  $lineNo=21;
                  $lineSubrow='h';
                  $name = $type.'_'.$lineNo.''.$lineSubrow;
                  $a = 0;

                  for ($i=1; $i <= 6; $i++)
                  {
                      if($postData['obligor_21b'.$i] !=''){
                        $postData[$name.''.$i] = ($postData[$name.''.$i] != '') ? $postData[$name.''.$i] : 0;
                      } else {
                        $postData[$name.''.$i]= 0;
                      }
                      $a += $postData[$name.''.$i];
                  }
                  $postData['21a3'] = $a ?? 0;

                  $type='obligor';
                  $lineNo=21;
                  $lineSubrow='h';
                  $name = $type.'_'.$lineNo.''.$lineSubrow;
                  $a = 0;

                  for ($i=1; $i <= 6; $i++)
                  {
                        if($postData['obligor_21b'.$i] !=''){
                          $postData[$name.''.$i] = ($postData[$name.''.$i] != '') ? $postData[$name.''.$i] : 0;
                        } else {
                          $postData[$name.''.$i]= 0;
                        }
                        $a += $postData[$name.''.$i];
                  }

                  $postData['21a4'] = $a ?? 0;

                  $postData["21a1"] = ($postData["21a1"]!='')?$postData["21a1"]:0;
                  $postData["21a2"] = ($postData["21a2"]!='')?$postData["21a2"]:0;
                  $postData["21a3"] = ($postData["21a3"]!='')?$postData["21a3"]:0;
                  $postData["21a4"] = ($postData["21a4"]!='')?$postData["21a4"]:0;

                  $postData["21l1"] = ($postData["21l1"]!='')?$postData["21l1"]:0;
                  $postData["21l2"] = ($postData["21l2"]!='')?$postData["21l2"]:0;
                  $postData["21l3"] = ($postData["21l3"]!='')?$postData["21l3"]:0;
                  $postData["21l4"] = ($postData["21l4"]!='')?$postData["21l4"]:0;

                  $postData["21o1"]=($postData["21o1"]!='')?$postData["21o1"]:0;
                  $postData["21o2"]=($postData["21o2"]!='')?$postData["21o2"]:0;
                  $postData["21o3"]=($postData["21o3"]!='')?$postData["21o3"]:0;
                  $postData["21o4"]=($postData["21o4"]!='')?$postData["21o4"]:0;

                  $postData["21m2"]=0;
                  $postData["21n4"]=0;

                  $postData["obligee_21f"]=0;
                  $postData["obligor_21f"]=0;

                  $postData["obligee_21g"]=((isset($postData['obligee_21g'])) && ($postData["obligee_21g"]!=''))?$postData["obligee_21g"]:0;
                  $postData["obligor_21g"]=((isset($postData['obligor_21g'])) && ($postData["obligor_21g"]!=''))?$postData["obligor_21g"]:0;

                  $postData["obligee_21h"]=0;
                  $postData["obligor_21h"]=0;

                  $postData["obligee_21i"]=0;
                  $postData["obligor_21i"]=0;

                  $postData["obligee_21j"]=0;
                  $postData["obligor_21j"]=0;

                  $e_total=0;
                  $obligor21JTotal = 0;

                  for($i=1;$i<=6;$i++)
                  {
                        $mac=0;
                        if($postData["obligee_21b".$i]!='')
                        {
                              $res = explode("/", $postData["obligee_21b".$i]);

                              if(count($res)>2)
                              {
                                    $newDob = $res[2]."-".$res[0]."-".$res[1];

                                    // get month difference
                                    $start=date("Y-m-d");
                                    $end=$newDob;
                                    $end OR $end = time();
                                    $start = new DateTime("$start");
                                    $end   = new DateTime("$end");
                                    $diff  = $start->diff($end);
                                    $months_diff=$diff->format('%y') * 12 + $diff->format('%m');

                                    if($months_diff<18) {
                                          $mac=11464;
                                    } elseif($months_diff>=18 && $months_diff<36) {
                                          $mac=10025;
                                    } elseif($months_diff>=36 && $months_diff<72) {
                                          $mac=8600;
                                    } elseif($months_diff>=72 && $months_diff<144) {
                                          $mac=7290;
                                    } else {
                                          $mac=0;
                                    }
                              }

                              if($months_diff<36)
                              {
                                $postData["obligee_21b".$i.'a']=$months_diff." Months";
                              } else {
                                 $start=date("Y-m-d");
                                 $end=$newDob;
                                 $end OR $end = time();
                                 $start = new DateTime("$start");
                                 $end   = new DateTime("$end");
                                 $diff  = $start->diff($end);
                                 $postData["obligee_21b".$i.'a']= $diff->format('%y')." Years";
                              }
                        } else {
                              $postData["obligee_21b".$i.'a']='';
                        }

                        $postData["obligee_21c".$i] = $mac;
                        $postData["obligee_21d".$i] = ($postData["obligee_21d".$i] != '') ? $postData["obligee_21d".$i] : 0;

                        $sumOf21dObligeeObligor = $postData['obligee_21d'.$i] + $postData['obligor_21d'.$i];
                        $sumOf21dObligeeObligor = ($sumOf21dObligeeObligor == '') ? 1 : $sumOf21dObligeeObligor;

                        $postData['obligee_21e'.$i] = min($postData['obligee_21c'.$i], $sumOf21dObligeeObligor);
                        
                        $postData["obligee_21e".$i] = ($postData["obligee_21e".$i] != '')?$postData["obligee_21e".$i]:0;
                        
                        // $apporSumObligee = ($postData['obligor_21e'.$i]/$sumOf21dObligeeObligor);

                        $apporSumObligee = ($postData['obligee_21e'.$i]/$sumOf21dObligeeObligor);
                        $postData['21_apportioned_obligee_A'.$i] = ($apporSumObligee * $postData['obligee_21d'.$i]);
                        $postData['21_apportioned_obligee_B'.$i] = ($apporSumObligee * $postData['obligor_21d'.$i]);          

                        $e_total = $e_total + $postData['21_apportioned_obligee_A'.$i];
                        $obligor21JTotal = $obligor21JTotal + $postData['21_apportioned_obligee_B'.$i];
                  }

                  $postData["obligee_21j"] = $e_total;
                  $postData["obligor_21j"] = $obligor21JTotal;

                  $e_total = 0;
                  $obligor21KTotal = 0;

                  for($i=1;$i<=6;$i++)
                  {
                  $mac=0;
                  if($postData["obligor_21b".$i]!='')
                  {

                    $res = explode("/", $postData["obligor_21b".$i]);

                    if(count($res)>2)
                    {
                      $newDob = $res[2]."-".$res[0]."-".$res[1];

                      // get month difference
                        $start=date("Y-m-d");
                        $end=$newDob;
                        $end OR $end = time();
                        $start = new DateTime("$start");
                        $end   = new DateTime("$end");
                        $diff  = $start->diff($end);
                        $months_diff=$diff->format('%y') * 12 + $diff->format('%m');

                      if($months_diff<18)
                      {
                        $mac=11464;
                      }
                      elseif($months_diff>=18 && $months_diff<36)
                      {
                        $mac=10025;
                      }
                      elseif($months_diff>=36 && $months_diff<72)
                      {
                        $mac=8600;
                      }
                      elseif($months_diff>=72 && $months_diff<144)
                      {
                        $mac=7290;
                      }
                      else
                      {
                        $mac=0;
                      }
                    }

                    if($months_diff<36)
                    {
                        $postData["obligor_21b".$i.'a']=$months_diff." Months";
                    } else {
                        $start=date("Y-m-d");
                        $end=$newDob;
                        $end OR $end = time();
                        $start = new DateTime("$start");
                        $end   = new DateTime("$end");
                        $diff  = $start->diff($end);
                        $postData["obligor_21b".$i.'a']= $diff->format('%y')." Years";
                    }

                  } else {
                              $postData["obligor_21b".$i.'a']='';
                  }

                        $postData["obligor_21c".$i] = $mac;

                        $postData["obligor_21d".$i] = ($postData["obligor_21d".$i] != '') ? $postData["obligor_21d".$i] : 0;

                        $sumOf21hObligeeObligor = $postData['obligee_21h'.$i] + $postData['obligor_21h'.$i];                  
                        $sumOf21hObligeeObligor = ($sumOf21hObligeeObligor == '') ? 1 : $sumOf21hObligeeObligor;

                        $postData['obligor_21e'.$i] = min($postData['obligor_21c'.$i], $sumOf21hObligeeObligor);
                        $postData["obligor_21e".$i]=($postData["obligor_21e".$i]!='')?$postData["obligor_21e".$i]:0;

                        $apporSumObligor = ($postData['obligor_21e'.$i]/$sumOf21hObligeeObligor);
                        $postData['21_apportioned_obligor_A'.$i] = ($apporSumObligor * $postData['obligee_21h'.$i]);
                        $postData['21_apportioned_obligor_B'.$i] = ($apporSumObligor * $postData['obligor_21h'.$i]);

                        // $e_total = $e_total+$postData["obligor_21e".$i];

                        $e_total = $e_total + $postData['21_apportioned_obligor_A'.$i];
                        $obligor21KTotal = $obligor21KTotal + $postData['21_apportioned_obligor_B'.$i];
                  }

                  $postData["obligee_21k"] = $e_total;
                  $postData["obligor_21k"] = $obligor21KTotal;

                  // if($postData["obligee_21j"]>0)
                  // {
                  //   $postData["21m2"] = $postData["obligee_21j"]-($postData["21l1"]-$postData["21l2"]);
                  // }

                  // if($postData["obligor_21k"]>0)
                  // {
                  //  $postData["21n4"] = $postData["obligor_21k"]-($postData["21l3"]-$postData["21l4"]);
                  // }

                  /*************************************************/

                  /**
                  * Remove Above Comments when Split sheets
                  * approved
                  */

                  // // (L21jC1+L21kC3)-(L21lC1+L21lC3)
                  // $postData['21m2'] = ($postData['obligee_21j'] + $postData['obligee_21k']) - ($postData['21l1'] + $postData['21l3']);

                  // // (L21jC2+L21kC4)-(L21lC2+L21lC4)
                  // $postData['21n4'] = ($postData['obligor_21j'] + $postData['obligor_21k']) - ($postData['21l2'] + $postData['21l4']);

                  $postData['21m2'] = ($postData['obligee_21j'] + $postData['obligor_21j']) - ($postData['21l1'] + $postData['21l2']);

                  // following fromulas are changed on 27-12-2019 23:11:00
                  // (L21jC2+L21kC4)-(L21lC2+L21lC4)
                  $postData['21n4'] = ($postData['obligor_21j'] + $postData['obligor_21k']) - ($postData['21l2'] + $postData['21l4']);
                  // (21k.c3+21k.c4)-(21l.c3+21l.c4)
                  $postData['21n4'] = ($postData['obligee_21k'] + $postData['obligor_21k']) - ($postData['21l3'] + $postData['21l4']);

                  if($postData['obligee_15'] == 1)
                  {
                        // echo $a=min($postData["obligee_17"], 0.5);
                        // echo $postData["obligor_17"];die;
                        $postData["21o1"] = (min($postData["obligee_17"]/100, 0.5) * $postData["21m2"]);
                        $postData["21o2"] = (min($postData["obligor_17"]/100,0.5) * $postData["21m2"]);

                  } else {

                        $postData["21o1"] = ($postData["obligee_17"]/100 * $postData["21m2"]);
                        $postData["21o2"] = ($postData["obligor_17"]/100 * $postData["21m2"]);
                  }

                  if($postData['obligor_15'] == 1)
                  {
                        $postData["21o3"] = (min($postData["obligee_17"]/100, 0.5) * $postData["21n4"]);
                        $postData["21o4"] = (min($postData["obligor_17"]/100, 0.5) * $postData["21n4"]);

                  } else {

                        $postData["21o3"] = $postData["obligee_17"]/100 * $postData["21n4"];
                        $postData["21o4"] = $postData["obligor_17"]/100 * $postData["21n4"];
                  }

                  /*************************************************/

                  $postData["21p1"] = max(($postData["21o1"]-$postData["21a1"]),0);
                  $postData["21p2"] = max(($postData["21o2"]-$postData["21a2"]),0);
                  $postData["21p3"] = max(($postData["21o3"]-$postData["21a3"]),0);
                  $postData["21p4"] = max(($postData["21o4"]-$postData["21a4"]),0);

                  $postData["obligee_22"] = ($postData["18d2"]-$postData["obligee_19b"]-$postData["20a2"])+$postData["21p2"];
                  $postData["obligor_22"] = ($postData["18d3"]-$postData["obligor_19b"]-$postData["20a3"])+$postData["21p3"];

                  $postData["obligee_22"] = max($postData["obligee_22"],0);
                  $postData["obligor_22"] = max($postData["obligor_22"],0);




                  /***************** calculation for O21ksplit **************************/
                  $result21kaObligeeArray=DB::select(DB::raw("SELECT getFedChildCareCreditPercentage2018(".$postData['obligee_14'].") AS calculation"));

                  $result21kaObligee = $result21kaObligeeArray[0]->calculation;

                  $result21kaObligorArray=DB::select(DB::raw("SELECT getFedChildCareCreditPercentage2018(".$postData['obligor_14'].") AS calculation"));

                  $result21kaObligor = $result21kaObligorArray[0]->calculation;

                  $postData['obligee_21ka1'] = $result21kaObligee;
                  $postData['obligee_21ka2'] = $result21kaObligor;

                  $postData['obligor_21ka1'] = $result21kaObligee;
                  $postData['obligor_21ka2'] = $result21kaObligor;

                  /*************************************************/

                  $countOf21e = 0;
                  $countOf21i = 0;

                  for ($i=0; $i <= 6; $i++) 
                  { 
                  if ($postData['obligee_21e'.$i] > 0)
                  {
                        $countOf21e = $countOf21e + 1;
                  }

                  if ($postData['obligor_21e'.$i] > 0)
                  {
                        $countOf21i = $countOf21i + 1;
                  }           
                  }

                  $parentACreditCapArray=DB::select(DB::raw("SELECT getFedChildCareCap2018(".$countOf21e.") AS calculation"));
                  $parentACreditCap = $parentACreditCapArray[0]->calculation;

                  $parentBCreditCapArray=DB::select(DB::raw("SELECT getFedChildCareCap2018(".$countOf21i.") AS calculation"));
                  $parentBCreditCap = $parentBCreditCapArray[0]->calculation;

                  $postData['obligee_21kb1'] = $postData['obligee_21ka1'] * min(($postData['obligee_1'] + max($postData['obligee_3d'], 0)), $postData['obligee_21j'], $parentACreditCap);

                  $postData['obligee_21kb2'] = $postData['obligee_21ka2'] * min(($postData['obligor_1'] + max($postData['obligor_3d'], 0)), $postData['obligor_21j'], $parentACreditCap);

                  $postData['obligor_21kb1'] = $postData['obligor_21ka1'] * min(($postData['obligee_1'] + max($postData['obligee_3d'], 0)), $postData['obligee_21k'], $parentBCreditCap);

                  $postData['obligor_21kb2'] = $postData['obligor_21ka2'] * min(($postData['obligor_1'] + max($postData['obligor_3d'], 0)), $postData['obligor_21k'], $parentBCreditCap);

                  /*************************************************/

                  $result21kcObligeeArray=DB::select(DB::raw("SELECT getOhChildCareCreditPercentage2018(".$postData['obligee_14'].") AS calculation"));

                  $result21kcObligee = $result21kcObligeeArray[0]->calculation;

                  $result21kcObligorArray=DB::select(DB::raw("SELECT getOhChildCareCreditPercentage2018(".$postData['obligor_14'].") AS calculation"));

                  $result21kcObligor = $result21kcObligorArray[0]->calculation;

                  $postData['obligee_21kc1'] = $result21kcObligee;
                  $postData['obligee_21kc2'] = $result21kcObligor;

                  $postData['obligor_21kc1'] = $result21kcObligee;
                  $postData['obligor_21kc2'] = $result21kcObligor;

                  /*************************************************/

                  // following fromulas are changed on 27-12-2019 22:14:00
                  // $postData['obligee_21kd1'] = $postData['obligee_21kc1'] * $postData['obligee_21j'];
                  // $postData['obligee_21kd2'] = $postData['obligee_21kc2'] * $postData['obligor_21j'];

                  // $postData['obligor_21kd1'] = $postData['obligor_21kc1'] * $postData['obligee_21k'];
                  // $postData['obligor_21kd2'] = $postData['obligor_21kc2'] * $postData['obligor_21k'];

                  $postData['obligee_21kd1'] = $postData['obligee_21kc1'] * $postData['obligee_21kb1'];
                  $postData['obligee_21kd2'] = $postData['obligee_21kc2'] * $postData['obligee_21kb2'];

                  $postData['obligor_21kd1'] = $postData['obligor_21kc1'] * $postData['obligor_21kb1'];
                  $postData['obligor_21kd2'] = $postData['obligor_21kc2'] * $postData['obligor_21kb2'];




                  /***************** calculation for O21lsplit **************************/
                  if ((isset($postData['21l_obligee_ParentA'])) && ($postData['21l_obligee_ParentA'] == 'calculation'))
                  {
                        $postData['21l1'] = $postData['obligee_21kb1'] + $postData['obligee_21kd1'];

                  } else {

                        $postData['21l1'] = ($postData['21l_obligee_ParentA_Over_input'] != '') ? $postData['21l_obligee_ParentA_Over_input'] : 0;
                  }

                  if ((isset($postData['21l_obligee_ParentB'])) && ($postData['21l_obligee_ParentB'] == 'calculation'))
                  {
                        $postData['21l2'] = $postData['obligee_21kb2'] + $postData['obligee_21kd2'];

                  } else {

                        $postData['21l2'] = ($postData['21l_obligee_ParentB_Over_input'] != '') ? $postData['21l_obligee_ParentB_Over_input'] : 0;
                  }

                  if ((isset($postData['21l_obligor_ParentA'])) && ($postData['21l_obligor_ParentA'] == 'calculation'))
                  {
                        $postData['21l3'] = $postData['obligor_21kb1'] + $postData['obligor_21kd1'];

                  } else {

                        $postData['21l3'] = ($postData['21l_obligor_ParentA_Over_input'] != '') ? $postData['21l_obligor_ParentA_Over_input'] : 0;
                  }

                  if ((isset($postData['21l_obligor_ParentB'])) && ($postData['21l_obligor_ParentB'] == 'calculation'))
                  {
                        $postData['21l4'] = $postData['obligor_21kb2'] + $postData['obligor_21kd2'];

                  } else {

                        $postData['21l4'] = ($postData['21l_obligor_ParentB_Over_input'] != '') ? $postData['21l_obligor_ParentB_Over_input'] : 0;
                  }

                  /**********************************************/

                  // following fromulas are changed on 27-12-2019 23:11:00
                  // (L21jC1+L21kC3)-(L21lC1+L21lC3)

                  // $postData['21m2'] = ($postData['obligee_21j'] + $postData['obligee_21k']) - ($postData['21l1'] + $postData['21l3']);

                  // (21j.c1+21j.c2)-(21l.c1+21l.c2). 

                  $postData['21m2'] = ($postData['obligee_21j'] + $postData['obligor_21j']) - ($postData['21l1'] + $postData['21l2']);

                  // following fromulas are changed on 27-12-2019 23:11:00
                  // (L21jC2+L21kC4)-(L21lC2+L21lC4)
                  $postData['21n4'] = ($postData['obligor_21j'] + $postData['obligor_21k']) - ($postData['21l2'] + $postData['21l4']);
                  // (21k.c3+21k.c4)-(21l.c3+21l.c4)
                  $postData['21n4'] = ($postData['obligee_21k'] + $postData['obligor_21k']) - ($postData['21l3'] + $postData['21l4']);


                  /***************** calculation for O24split **************************/
                  $combinedGrossIncome = $postData['obligee_1'] + $postData['obligor_1'];
                  $combinedGrossIncome = ($combinedGrossIncome == '') ? 0 : $combinedGrossIncome;

                  $ohCashMedicalData=DB::select(DB::raw("SELECT getOHCashMedical2018(".$combinedGrossIncome.",".$postData['number_children_order'].") As tmpResult"));

                  $postData["obligee_24"] = 0;
                  $postData["obligor_24"] = 0;

                  $postData["obligee_25"] = 0;
                  $postData["obligor_25"] = 0;

                  $postData["obligee_26a"] = ($postData["obligee_26a"] != '')?$postData["obligee_26a"]:0;
                  $postData["obligor_26a"] = ($postData["obligor_26a"] != '')?$postData["obligor_26a"]:0;
                  $postData["obligee_26b"] = ($postData["obligee_26b"] != '')?$postData["obligee_26b"]:0;
                  $postData["obligor_26b"] = ($postData["obligor_26b"] != '')?$postData["obligor_26b"]:0;

                  $postData["obligee_26c"] = 0;
                  $postData["obligor_26c"] = 0;

                  $postData["obligee_27"] = 0;
                  $postData["obligor_27"] = 0;

                  $postData["obligee_28"] = ($postData["obligee_28"] != '')?$postData["obligee_28"]:0;
                  $postData["obligor_28"] = ($postData["obligor_28"] != '')?$postData["obligor_28"]:0;

                  $postData["obligee_29"] = 0;
                  $postData["obligor_29"] = 0;

                  $postData["obligee_30"]=($postData["obligee_30"] != '')?$postData["obligee_30"]:0;
                  $postData["obligor_30"]=($postData["obligor_30"] != '')?$postData["obligor_30"]:0;

                  /******************************************************************************/

                  $obligee23aOhCash=DB::select(DB::raw("SELECT getOHCashMedical2018(".$postData['obligee_14'].",".$postData['parent_a_children'].") As tmpResult"));

                  $obligor23aOhCash=DB::select(DB::raw("SELECT getOHCashMedical2018(".$postData['obligor_14'].",".$postData['parent_b_children'].") As tmpResult"));

                  $postData['obligee_23a'] = $obligee23aOhCash[0]->tmpResult;
                  // $postData['obligee_23a'] = 388.70;
                  $postData['obligor_23a'] = $obligor23aOhCash[0]->tmpResult;
                  // $postData['obligor_23a'] = 388.70;

                  /******************************************************************************/

                  $postData['obligee_23b'] = ($postData['obligee_23a']*($postData['obligor_17']/100));
                  $postData['obligor_23b'] = ($postData['obligor_23a']*($postData['obligee_17']/100));


                  $postData['obligee_24'] = round($postData['obligor_22'], 2);
                  $postData['obligor_24'] = round($postData['obligee_22'], 2);

                  $postData['24nso'] = round(abs($postData['obligor_24']-$postData['obligee_24']), 2);


                  if($postData['obligee_24'] > $postData['obligor_24'])
                  {
                  $postData['obligee_25'] = $postData['24nso']/12;
                  }

                  if($postData['obligor_24'] > $postData['obligee_24'])
                  {
                  $postData['obligor_25'] = $postData['24nso']/12;
                  }

                  $postData['obligee_26c'] = ($postData['obligee_26a'] + $postData['obligee_26b']);
                  $postData['obligor_26c'] = ($postData['obligor_26a'] + $postData['obligor_26b']);

                  $postData['obligee_27'] = ($postData['obligee_25'] + $postData['obligee_26c']);
                  $postData['obligor_27'] = ($postData['obligor_25'] + $postData['obligor_26c']);

                  if($postData['obligor_23b'] > 0)
                  {
                  $postData['obligee_28'] = round($postData['obligor_23b'], 2);
                  }

                  if($postData['obligee_23b'] > 0)
                  {
                  $postData['obligor_28'] = round($postData['obligee_23b'], 2);
                  }

                  $postData['28nso'] = abs($postData['obligor_28'] - $postData['obligee_28']);

                  if ($postData['obligee_28'] > $postData['obligor_28'])
                  {
                  $postData['obligee_29'] = round(($postData['28nso']/12), 2);
                  }

                  if ($postData['obligor_28'] > $postData['obligee_28'])
                  {
                  $postData['obligor_29'] = round(($postData['28nso']/12), 2);
                  }

                  $postData['obligee_31'] = ($postData['obligee_29'] + $postData['obligee_30']);
                  $postData['obligor_31'] = ($postData['obligor_29'] + $postData['obligor_30']);

                  $postData['obligee_32'] = ($postData['obligee_27'] + $postData['obligee_31']);
                  $postData['obligor_32'] = ($postData['obligor_27'] + $postData['obligor_31']);

                  $postData['nso_32'] = abs($postData['obligor_32'] - $postData['obligee_32']);






                  /***************** calculation for O26split **************************/
                  $type='obligee';
                  if ((isset($postData['26a_'.$type.'_child_sport'])) && ($postData['26a_'.$type.'_child_sport'] == 'deviation'))
                  {
                        $postData[$type.'_26a'] = $postData['26a_'.$type.'_child_sport_deviation_text'];

                  } else {

                        $postData[$type.'_26a'] = $postData[$type.'_25'] - $postData['26a_'.$type.'_child_sport_non_deviation_text'];
                  }

                  $postData[$type.'_26a'] = ($postData[$type.'_26a'] != '') ? $postData[$type.'_26a'] : 0;

                  $type='obligor';
                  if ((isset($postData['26a_'.$type.'_child_sport'])) && ($postData['26a_'.$type.'_child_sport'] == 'deviation'))
                  {
                        $postData[$type.'_26a'] = $postData['26a_'.$type.'_child_sport_deviation_text'];

                  } else {

                        $postData[$type.'_26a'] = $postData[$type.'_25'] - $postData['26a_'.$type.'_child_sport_non_deviation_text'];
                  }

                  $postData[$type.'_26a'] = ($postData[$type.'_26a'] != '') ? $postData[$type.'_26a'] : 0;



                  /***************** calculation for O31split **************************/
                  $type='obligee';
                  $typeOpposite = ($type == 'obligee') ? 'obligor' : 'obligee';

                  $postData[$type.'_33'] = 0;
                  if ($postData[$type.'_32'] > $postData[$typeOpposite.'_32'])
                  {
                        // $postData[$type.'_33'] = round(($postData['nso_32']/12), 2);
                        $postData[$type.'_33'] = round(($postData['nso_32']), 2);
                  }

                  $postData[$type.'_34'] = (isset($postData[$type.'_33']) && ($postData[$type.'_33'] == 0)) ? 0 : $postData[$type.'_33'];
                  $postData[$type.'_35'] = (isset($postData[$type.'_33']) && ($postData[$type.'_33'] == 0)) ? 0 : ($postData[$type.'_33'] * 0.02);

                  $sumFor36 = $postData[$type.'_34'] + $postData[$type.'_35'];
                  $postData[$type.'_36'] = (isset($postData[$type.'_33']) && ($postData[$type.'_33'] == 0)) ? 0 : $sumFor36;

                  $type='obligor';
                  $typeOpposite = ($type == 'obligee') ? 'obligor' : 'obligee';

                  $postData[$type.'_33'] = 0;
                  if ($postData[$type.'_32'] > $postData[$typeOpposite.'_32'])
                  {
                        // $postData[$type.'_33'] = round(($postData['nso_32']/12), 2);
                        $postData[$type.'_33'] = round(($postData['nso_32']), 2);
                  }

                  $postData[$type.'_34'] = (isset($postData[$type.'_33']) && ($postData[$type.'_33'] == 0)) ? 0 : $postData[$type.'_33'];
                  $postData[$type.'_35'] = (isset($postData[$type.'_33']) && ($postData[$type.'_33'] == 0)) ? 0 : ($postData[$type.'_33'] * 0.02);

                  $sumFor36 = $postData[$type.'_34'] + $postData[$type.'_35'];
                  $postData[$type.'_36'] = (isset($postData[$type.'_33']) && ($postData[$type.'_33'] == 0)) ? 0 : $sumFor36;

                  // if ($postData['obligee_32'] == $postData['obligor_32'])
                  // {
                  //       // $postData[$type.'_33'] = round(($postData['nso_32']/12), 2);
                  //       $postData['obligee_33'] = 0;
                  //       $postData['obligor_33'] = 0;
                  // }

                  if(isset($postData['obligee_21ka1'])){
                        $postData['obligee_21ka1']=$postData['obligee_21ka1']*100;
                  };
                  if(isset($postData['obligee_21ka2'])){
                        $postData['obligee_21ka2']=$postData['obligee_21ka2']*100;
                  };
                  if(isset($postData['obligor_21ka1'])){
                        $postData['obligor_21ka1']=$postData['obligor_21ka1']*100;
                  };
                  if(isset($postData['obligor_21ka2'])){
                        $postData['obligor_21ka2']=$postData['obligor_21ka2']*100;
                  };
                  if(isset($postData['obligee_21kc1'])){
                        $postData['obligee_21kc1']=$postData['obligee_21kc1']*100;
                  };
                  if(isset($postData['obligee_21kc2'])){
                        $postData['obligee_21kc2']=$postData['obligee_21kc2']*100;
                  };
                  if(isset($postData['obligor_21kc1'])){
                        $postData['obligor_21kc1']=$postData['obligor_21kc1']*100;
                  };
                  if(isset($postData['obligor_21kc2'])){
                        $postData['obligor_21kc2']=$postData['obligor_21kc2']*100;
                  };
                  // end of calculate code for split sheet before save/download
                  return view('computations.computed.split_print',['sheet_custody' =>$request->sheet_custody, 'sheet_state' =>$request->sheet_state, 'chk_prefill'=>$request->chk_prefill, 'postData'=>$postData, 'attorney_data'=>$attorney_data ]);
            }

            if((isset($request->save_form) && $request->save_form=='Save') || (isset($request->download_form) && $request->download_form=='Download'))
            {
              die('in process');
                  $postData = $request;
                  // calculate code for split sheet before save/download
                  $ohMinimumWageData=DB::select(DB::raw("select getOHMinimumWage2018(0) AS tmpResult"));
                  $OH_Minimum_Wage = $ohMinimumWageData[0]->tmpResult;
                  $postData['OH_Minimum_Wage']=$OH_Minimum_Wage;
                  /******************* calculations for 02d ****************************/
                  $type='obligee';
                  $sum=0;
                  $arr=['a','b','c'];

                  /* SUM ALL 3 FIELDS */
                  for($i = 0;$i < 3;$i++)
                  {
                        $fieldName = $type."_2".$arr[$i];
                        $postData[$fieldName] = ($postData[$fieldName] != '') ? $postData[$fieldName] : 0;
                        $sum += $postData[$fieldName];
                  }

                  /* GOT AVERAGE OF ALL 3 FIELDS */
                  $rsum = ($sum/3);
                  $fieldName = $type."_2d";

                  $postData[$fieldName] = min($rsum,$postData[$type.'_2c']);

                  $type='obligor';
                  $sum=0;
                  $arr=['a','b','c'];

                  /* SUM ALL 3 FIELDS */
                  for($i = 0;$i < 3;$i++)
                  {
                        $fieldName = $type."_2".$arr[$i];
                        $postData[$fieldName] = ($postData[$fieldName] != '') ? $postData[$fieldName] : 0;
                        $sum += $postData[$fieldName];
                  }

                  /* GOT AVERAGE OF ALL 3 FIELDS */
                  $rsum = ($sum/3);
                  $fieldName = $type."_2d";

                  $postData[$fieldName] = min($rsum,$postData[$type.'_2c']);

                  /******************* calculations for 03d ****************************/
                  $type='obligee';
                  $postData[$type.'_3a'] = ($postData[$type.'_3a'] != '') ? $postData[$type.'_3a'] : 0;
                  $postData[$type.'_3b'] = ($postData[$type.'_3b'] != '') ? $postData[$type.'_3b'] : 0;

                  if ((isset($postData[$type.'_3_c_radio'])) && ($postData[$type.'_3_c_radio'] == 'manual'))
                  {
                              $postData[$type.'_3c'] = ($postData[$type.'_3_c_override_input'] != '') ? round(($postData[$type.'_3_c_override_input']),2) : 0;

                  } else {

                        $postData[$type.'_3c'] = round((max((0.062 * ($postData[$type.'_3a'] - $postData[$type.'_3b'])), 0)), 2);
                  }

                  $postData[$type.'_3d'] = round(((($postData[$type.'_3a']-$postData[$type.'_3b'])-$postData[$type.'_3c'])), 2);

                  $type='obligor';
                  $postData[$type.'_3a'] = ($postData[$type.'_3a'] != '') ? $postData[$type.'_3a'] : 0;
                  $postData[$type.'_3b'] = ($postData[$type.'_3b'] != '') ? $postData[$type.'_3b'] : 0;

                  if ((isset($postData[$type.'_3_c_radio'])) && ($postData[$type.'_3_c_radio'] == 'manual'))
                  {
                              $postData[$type.'_3c'] = ($postData[$type.'_3_c_override_input'] != '') ? round(($postData[$type.'_3_c_override_input']),2) : 0;

                  } else {

                        $postData[$type.'_3c'] = round((max((0.062 * ($postData[$type.'_3a'] - $postData[$type.'_3b'])), 0)), 2);
                  }

                  $postData[$type.'_3d'] = round(((($postData[$type.'_3a']-$postData[$type.'_3b'])-$postData[$type.'_3c'])), 2);


                  /******************* calculations for 08 ****************************/
                  $type='obligee';
                  $postData[$type."_4"]=($postData[$type."_4"]!='')?$postData[$type."_4"]:0;
                  $postData[$type."_5"]=($postData[$type."_5"]!='')?$postData[$type."_5"]:0;
                  $postData[$type."_6"]=($postData[$type."_6"]!='')?$postData[$type."_6"]:0;
                  $postData[$type."_7"]=($postData[$type."_7"]!='')?$postData[$type."_7"]:0;
                  $postData[$type."_8"]=($postData[$type."_8"]!='')?$postData[$type."_8"]:0;

                  $field_7=round(($postData[$type."_1"]+$postData[$type."_2d"]+$postData[$type."_3d"]+$postData[$type."_4"]+$postData[$type."_5"]+$postData[$type."_6"]),2);

                  if($field_7<0)
                  {
                        $field_7=0.00;
                  }

                  $postData[$type."_7"] = $field_7;
                  $postData[$type."_8"] = round(($field_7*.05),2);

                  $type='obligor';
                  $postData[$type."_4"]=($postData[$type."_4"]!='')?$postData[$type."_4"]:0;
                  $postData[$type."_5"]=($postData[$type."_5"]!='')?$postData[$type."_5"]:0;
                  $postData[$type."_6"]=($postData[$type."_6"]!='')?$postData[$type."_6"]:0;
                  $postData[$type."_7"]=($postData[$type."_7"]!='')?$postData[$type."_7"]:0;
                  $postData[$type."_8"]=($postData[$type."_8"]!='')?$postData[$type."_8"]:0;

                  $field_7=round(($postData[$type."_1"]+$postData[$type."_2d"]+$postData[$type."_3d"]+$postData[$type."_4"]+$postData[$type."_5"]+$postData[$type."_6"]),2);

                  if($field_7<0)
                  {
                        $field_7=0.00;
                  }

                  $postData[$type."_7"] = $field_7;
                  $postData[$type."_8"] = round(($field_7*.05),2);


                  /******************* calculations for 09c ****************************/
                  $type='obligee';
                  $postData[$type."_9a"] = ($postData[$type."_9a"] != '') ? $postData[$type."_9a"] : 0;
                  $postData[$type."_9b"] = ($postData[$type."_9b"] != '') ? $postData[$type."_9b"] : 0;
                  $postData[$type."_9c"] = ($postData[$type."_9c"] != '') ? $postData[$type."_9c"] : 0;

                  $postData[$type."_9d"] = 0;
                  $postData[$type."_9e"] = 0;
                  $postData[$type."_9f"] = 0;

                  $postData[$type."_9c"] = $postData[$type."_9a"]-$postData[$type."_9b"];

                  $result=DB::select(DB::raw("SELECT getOhioChildSupport2018(".$postData[$type.'_7'].",".$postData[$type.'_9a'].") AS calculation"));


                  if ($postData[$type.'_9a'] == 0)
                  {
                      $postData[$type."_9d"] = 0;

                  } else {

                      $postData[$type."_9d"] = $result[0]->calculation;
                  }

                  if($postData[$type."_9a"]>0)
                      $postData[$type."_9e"]=round(($postData[$type."_9d"]/$postData[$type."_9a"]),2);

                  if($postData[$type."_9c"]>0)
                      $postData[$type."_9f"]=round(($postData[$type."_9e"]*$postData[$type."_9c"]),2);

                  $type='obligor';
                  $postData[$type."_9a"] = ($postData[$type."_9a"] != '') ? $postData[$type."_9a"] : 0;
                  $postData[$type."_9b"] = ($postData[$type."_9b"] != '') ? $postData[$type."_9b"] : 0;
                  $postData[$type."_9c"] = ($postData[$type."_9c"] != '') ? $postData[$type."_9c"] : 0;

                  $postData[$type."_9d"] = 0;
                  $postData[$type."_9e"] = 0;
                  $postData[$type."_9f"] = 0;

                  $postData[$type."_9c"] = $postData[$type."_9a"]-$postData[$type."_9b"];

                  $result=DB::select(DB::raw("SELECT getOhioChildSupport2018(".$postData[$type.'_7'].",".$postData[$type.'_9a'].") AS calculation"));


                  if ($postData[$type.'_9a'] == 0)
                  {
                      $postData[$type."_9d"] = 0;

                  } else {

                      $postData[$type."_9d"] = $result[0]->calculation;
                  }

                  if($postData[$type."_9a"]>0)
                      $postData[$type."_9e"]=round(($postData[$type."_9d"]/$postData[$type."_9a"]),2);

                  if($postData[$type."_9c"]>0)
                      $postData[$type."_9f"]=round(($postData[$type."_9e"]*$postData[$type."_9c"]),2);

                  /***************** calculation for 015 **************************/
                  $type='obligee';
                  $postData[$type."_10b"] = ($postData[$type."_10b"] != '') ? $postData[$type."_10b"] : 0;

                  if((isset($postData[$type."_10a"])) && ($postData[$type."_10a"] == ''))
                  {
                      $postData[$type."_10b"] = 0;
                  }

                  $postData[$type."_11"] = ($postData[$type."_11"] != '') ? $postData[$type."_11"] : 0;
                  $postData[$type."_12"] = $postData[$type."_9f"] + $postData[$type."_10b"] + $postData[$type."_11"];
                  $postData[$type."_13"] = $postData[$type."_7"] - $postData[$type."_12"];
                  $postData[$type."_13"] = ($postData[$type."_13"] > 0) ? $postData[$type."_13"] : 0;
                  $postData[$type."_14"] = $postData[$type."_13"];

                  if((isset($postData[$type."_10a"])) && ($postData[$type."_10a"] == ''))
                  {
                      $postData[$type."_10b"] = 0;
                  }

                  $noChildThisOrder = $postData['number_children_order'];
                  $nthChildThreshholdData=DB::select(DB::raw("SELECT getOH_CS_Shaded_Threshold2018(".$noChildThisOrder.") As tmpResult"));
                  $postData[$type.'_15'] = 0;

                  if (isset($nthChildThreshholdData[0]->tmpResult))
                  {
                      if ((isset($postData[$type.'_14'])) && ($postData[$type.'_14'] <= $nthChildThreshholdData[0]->tmpResult))
                      {
                          $postData[$type.'_15'] = 1;

                      }
                  }

                  $type='obligor';

                  $postData[$type."_10b"] = ($postData[$type."_10b"] != '') ? $postData[$type."_10b"] : 0;

                  if((isset($postData[$type."_10a"])) && ($postData[$type."_10a"] == ''))
                  {
                      $postData[$type."_10b"] = 0;
                  }

                  $postData[$type."_11"] = ($postData[$type."_11"] != '') ? $postData[$type."_11"] : 0;
                  $postData[$type."_12"] = $postData[$type."_9f"] + $postData[$type."_10b"] + $postData[$type."_11"];
                  $postData[$type."_13"] = $postData[$type."_7"] - $postData[$type."_12"];
                  $postData[$type."_13"] = ($postData[$type."_13"] > 0) ? $postData[$type."_13"] : 0;
                  $postData[$type."_14"] = $postData[$type."_13"];

                  if((isset($postData[$type."_10a"])) && ($postData[$type."_10a"] == ''))
                  {
                      $postData[$type."_10b"] = 0;
                  }

                  $noChildThisOrder = $postData['number_children_order'];
                  $nthChildThreshholdData=DB::select(DB::raw("SELECT getOH_CS_Shaded_Threshold2018(".$noChildThisOrder.") As tmpResult"));

                  $postData[$type.'_15'] = 0;

                  if (isset($nthChildThreshholdData[0]->tmpResult))
                  {
                      if ((isset($postData[$type.'_14'])) && ($postData[$type.'_14'] <= $nthChildThreshholdData[0]->tmpResult))
                      {
                          $postData[$type.'_15'] = 1;

                      }
                  }

                  /***************** calculation for 016 **************************/
                  $postData["obligee_16"] = $postData["obligee_14"] + $postData["obligor_14"];

                  /***************** calculation for 018split **************************/
                  $postData["obligee_17"]=0;

                  $postData["obligee_18a1"]=0;
                  $postData["obligor_18a1"]=0;
                  $postData["obligee_18a2"]=0;
                  $postData["obligor_18a2"]=0;

                  $postData["obligee_18b"]=0;
                  $postData["obligee_18c"]=0;
                  $postData["obligor_18c"]=0;
                  $postData["obligee_18d"]=0;
                  $postData["obligor_18d"]=0;

                  $postData["obligee_19a"]=((isset($postData['obligee_19a'])) && ($postData["obligee_19a"]!=''))?$postData["obligee_19a"]:0;
                  $postData["obligor_19a"]=((isset($postData['obligor_19a'])) && ($postData["obligor_19a"]!=''))?$postData["obligor_19a"]:0;

                  $postData["obligee_19b"]=0;
                  $postData["obligor_19b"]=0;

                  $postData["obligee_20"]=((isset($postData['obligee_20'])) && ($postData["obligee_20"]!=''))?$postData["obligee_20"]:0;
                  $postData["obligor_20"]=((isset($postData['obligor_20'])) && ($postData["obligor_20"]!=''))?$postData["obligor_20"]:0;

                  if($postData["obligee_16"]>0)
                  {
                  $postData["obligee_17"]=round(($postData["obligee_14"]/$postData["obligee_16"])*100,2);
                  $postData["obligor_17"]=round(($postData["obligor_14"]/$postData["obligee_16"])*100,2);
                  }

                  $result=DB::select(DB::raw("SELECT getOhioChildSupport2018(".$postData['obligee_14'].",".$postData['parent_a_children'].") AS calculation"));

                  if(isset($result[0]->calculation))
                  {
                        $postData["18a1"]=max($result[0]->calculation,960);
                  }


                  $result=DB::select(DB::raw("SELECT getOhioChildSupport2018(".$postData['obligor_14'].",".$postData['parent_a_children'].") AS calculation"));

                  if(isset($result[0]->calculation))
                  {
                        $postData["18a2"]=max($result[0]->calculation,960);
                  }

                  $result=DB::select(DB::raw("SELECT getOhioChildSupport2018(".$postData['obligee_14'].",".$postData['parent_b_children'].") AS calculation"));

                  if(isset($result[0]->calculation))
                  {
                        $postData["18a3"]=max($result[0]->calculation,960);
                  }


                  
                  $result=DB::select(DB::raw("SELECT getOhioChildSupport2018(".$postData['obligor_14'].",".$postData['parent_b_children'].") AS calculation"));

                  if(isset($result[0]->calculation))
                  {
                        $postData["18a4"]=max($result[0]->calculation,960);
                  }


                  
                  $result=DB::select(DB::raw("SELECT getOhioChildSupport2018(".$postData['obligee_16'].",".$postData['parent_a_children'].") AS calculation"));

                  if(isset($result[0]->calculation))
                  {
                        $postData["obligee_18b"] = max($result[0]->calculation,960);
                  }

                  $result=DB::select(DB::raw("SELECT getOhioChildSupport2018(".$postData['obligee_16'].",".$postData['parent_b_children'].") AS calculation"));

                  $postData["obligor_18b"] = (isset($postData['obligor_18b']) && $postData['obligor_18b'] != 0) ? $postData['obligor_18b'] : 0;
                  if(isset($result[0]->calculation))
                  {
                        $postData["obligor_18b"] = max($result[0]->calculation,960);
                  }

                  $postData["18c1"]=round(($postData["obligee_18b"]*($postData["obligee_17"]/100)),2);
                  $postData["18c2"]=round(($postData["obligee_18b"]*($postData["obligor_17"]/100)),2);
                  $postData["18c3"]=round(($postData["obligor_18b"]*($postData["obligee_17"]/100)),2);
                  $postData["18c4"]=round(($postData["obligor_18b"]*($postData["obligor_17"]/100)),2);

                  $low18=min($postData["18a1"],$postData["18c1"]);
                  $low18=max($low18,960);
                  $postData["18d1"]=$low18;

                  $low18=min($postData["18a2"],$postData["18c2"]);
                  $low18=max($low18,960);
                  $postData["18d2"]=$low18;

                  $low18=min($postData["18a3"],$postData["18c3"]);
                  $low18=max($low18,960);
                  $postData["18d3"]=$low18;

                  $low18=min($postData["18a4"],$postData["18c4"]);
                  $low18=max($low18,960);
                  $postData["18d4"]=$low18;

                  // formulas to calculate "obligee_19b" and "obligor_19b" are swapped
                  if(isset($postData["obligee_19a"]) && $postData["obligee_19a"]>0)
                  {
                        // $postData["obligee_19b"]=($postData["18d3"]*0.10);
                        $postData["obligee_19b"]=($postData["18d2"]*0.10);
                  } else {
                        $postData["obligee_19b"]=0;
                  }

                  if(isset($postData["obligor_19a"]) && $postData["obligor_19a"]>0)
                  {
                        $postData["obligor_19b"]=($postData["18d3"]*0.10);
                        // $postData["obligor_19b"]=($postData["18d2"]*0.10);
                  } else {
                        $postData["obligor_19b"]=0;
                  }

                  /***************** calculation for O21csplit **************************/
                  
                  $postData["20a2"]=($postData["20a2"]!='')?$postData["20a2"]:0;
                  $postData["20a3"]=($postData["20a3"]!='')?$postData["20a3"]:0;

                  /**
                   * Create a Function to calculate the sum
                   */
                  $type='obligee';
                  $lineNo=21;
                  $lineSubrow='d';
                  $name = $type.'_'.$lineNo.''.$lineSubrow;
                  $a = 0;

                  for ($i=1; $i <= 6; $i++)
                  {
                      if($postData['obligee_21b'.$i] !=''){
                        $postData[$name.''.$i] = ($postData[$name.''.$i] != '') ? $postData[$name.''.$i] : 0;
                      } else {
                        $postData[$name.''.$i]=0;
                      }
                      $a += $postData[$name.''.$i];
                  }
                  $postData['21a1'] = $a ?? 0;

                  $type='obligor';
                  $lineNo=21;
                  $lineSubrow='d';
                  $name = $type.'_'.$lineNo.''.$lineSubrow;
                  $a = 0;

                  for ($i=1; $i <= 6; $i++)
                  {
                      if($postData['obligee_21b'.$i] !=''){
                        $postData[$name.''.$i] = ($postData[$name.''.$i] != '') ? $postData[$name.''.$i] : 0;
                      } else {
                        $postData[$name.''.$i]=0;
                      }
                        $a += $postData[$name.''.$i];
                  }
                  $postData['21a2'] = $a ?? 0;

                  $type='obligee';
                  $lineNo=21;
                  $lineSubrow='h';
                  $name = $type.'_'.$lineNo.''.$lineSubrow;
                  $a = 0;

                  for ($i=1; $i <= 6; $i++)
                  {
                      if($postData['obligor_21b'.$i] !=''){
                        $postData[$name.''.$i] = ($postData[$name.''.$i] != '') ? $postData[$name.''.$i] : 0;
                      } else {
                        $postData[$name.''.$i]= 0;
                      }
                      $a += $postData[$name.''.$i];
                  }
                  $postData['21a3'] = $a ?? 0;

                  $type='obligor';
                  $lineNo=21;
                  $lineSubrow='h';
                  $name = $type.'_'.$lineNo.''.$lineSubrow;
                  $a = 0;

                  for ($i=1; $i <= 6; $i++)
                  {
                        if($postData['obligor_21b'.$i] !=''){
                          $postData[$name.''.$i] = ($postData[$name.''.$i] != '') ? $postData[$name.''.$i] : 0;
                        } else {
                          $postData[$name.''.$i]= 0;
                        }
                        $a += $postData[$name.''.$i];
                  }

                  $postData['21a4'] = $a ?? 0;

                  $postData["21a1"] = ($postData["21a1"]!='')?$postData["21a1"]:0;
                  $postData["21a2"] = ($postData["21a2"]!='')?$postData["21a2"]:0;
                  $postData["21a3"] = ($postData["21a3"]!='')?$postData["21a3"]:0;
                  $postData["21a4"] = ($postData["21a4"]!='')?$postData["21a4"]:0;

                  $postData["21l1"] = ($postData["21l1"]!='')?$postData["21l1"]:0;
                  $postData["21l2"] = ($postData["21l2"]!='')?$postData["21l2"]:0;
                  $postData["21l3"] = ($postData["21l3"]!='')?$postData["21l3"]:0;
                  $postData["21l4"] = ($postData["21l4"]!='')?$postData["21l4"]:0;

                  $postData["21o1"]=($postData["21o1"]!='')?$postData["21o1"]:0;
                  $postData["21o2"]=($postData["21o2"]!='')?$postData["21o2"]:0;
                  $postData["21o3"]=($postData["21o3"]!='')?$postData["21o3"]:0;
                  $postData["21o4"]=($postData["21o4"]!='')?$postData["21o4"]:0;

                  $postData["21m2"]=0;
                  $postData["21n4"]=0;

                  $postData["obligee_21f"]=0;
                  $postData["obligor_21f"]=0;

                  $postData["obligee_21g"]=((isset($postData['obligee_21g'])) && ($postData["obligee_21g"]!=''))?$postData["obligee_21g"]:0;
                  $postData["obligor_21g"]=((isset($postData['obligor_21g'])) && ($postData["obligor_21g"]!=''))?$postData["obligor_21g"]:0;

                  $postData["obligee_21h"]=0;
                  $postData["obligor_21h"]=0;

                  $postData["obligee_21i"]=0;
                  $postData["obligor_21i"]=0;

                  $postData["obligee_21j"]=0;
                  $postData["obligor_21j"]=0;

                  $e_total=0;
                  $obligor21JTotal = 0;

                  for($i=1;$i<=6;$i++)
                  {
                        $mac=0;
                        if($postData["obligee_21b".$i]!='')
                        {
                              $res = explode("/", $postData["obligee_21b".$i]);

                              if(count($res)>2)
                              {
                                    $newDob = $res[2]."-".$res[0]."-".$res[1];

                                    // get month difference
                                    $start=date("Y-m-d");
                                    $end=$newDob;
                                    $end OR $end = time();
                                    $start = new DateTime("$start");
                                    $end   = new DateTime("$end");
                                    $diff  = $start->diff($end);
                                    $months_diff=$diff->format('%y') * 12 + $diff->format('%m');

                                    if($months_diff<18) {
                                          $mac=11464;
                                    } elseif($months_diff>=18 && $months_diff<36) {
                                          $mac=10025;
                                    } elseif($months_diff>=36 && $months_diff<72) {
                                          $mac=8600;
                                    } elseif($months_diff>=72 && $months_diff<144) {
                                          $mac=7290;
                                    } else {
                                          $mac=0;
                                    }
                              }

                              if($months_diff<36)
                              {
                                $postData["obligee_21b".$i.'a']=$months_diff." Months";
                              } else {
                                 $start=date("Y-m-d");
                                 $end=$newDob;
                                 $end OR $end = time();
                                 $start = new DateTime("$start");
                                 $end   = new DateTime("$end");
                                 $diff  = $start->diff($end);
                                 $postData["obligee_21b".$i.'a']= $diff->format('%y')." Years";
                              }
                        } else {
                              $postData["obligee_21b".$i.'a']='';
                        }

                        $postData["obligee_21c".$i] = $mac;
                        $postData["obligee_21d".$i] = ($postData["obligee_21d".$i] != '') ? $postData["obligee_21d".$i] : 0;

                        $sumOf21dObligeeObligor = $postData['obligee_21d'.$i] + $postData['obligor_21d'.$i];
                        $sumOf21dObligeeObligor = ($sumOf21dObligeeObligor == '') ? 1 : $sumOf21dObligeeObligor;

                        $postData['obligee_21e'.$i] = min($postData['obligee_21c'.$i], $sumOf21dObligeeObligor);
                        
                        $postData["obligee_21e".$i] = ($postData["obligee_21e".$i] != '')?$postData["obligee_21e".$i]:0;
                        
                        // $apporSumObligee = ($postData['obligor_21e'.$i]/$sumOf21dObligeeObligor);

                        $apporSumObligee = ($postData['obligee_21e'.$i]/$sumOf21dObligeeObligor);
                        $postData['21_apportioned_obligee_A'.$i] = ($apporSumObligee * $postData['obligee_21d'.$i]);
                        $postData['21_apportioned_obligee_B'.$i] = ($apporSumObligee * $postData['obligor_21d'.$i]);          

                        $e_total = $e_total + $postData['21_apportioned_obligee_A'.$i];
                        $obligor21JTotal = $obligor21JTotal + $postData['21_apportioned_obligee_B'.$i];
                  }

                  $postData["obligee_21j"] = $e_total;
                  $postData["obligor_21j"] = $obligor21JTotal;

                  $e_total = 0;
                  $obligor21KTotal = 0;

                  for($i=1;$i<=6;$i++)
                  {
                  $mac=0;
                  if($postData["obligor_21b".$i]!='')
                  {

                    $res = explode("/", $postData["obligor_21b".$i]);

                    if(count($res)>2)
                    {
                      $newDob = $res[2]."-".$res[0]."-".$res[1];

                      // get month difference
                        $start=date("Y-m-d");
                        $end=$newDob;
                        $end OR $end = time();
                        $start = new DateTime("$start");
                        $end   = new DateTime("$end");
                        $diff  = $start->diff($end);
                        $months_diff=$diff->format('%y') * 12 + $diff->format('%m');

                      if($months_diff<18)
                      {
                        $mac=11464;
                      }
                      elseif($months_diff>=18 && $months_diff<36)
                      {
                        $mac=10025;
                      }
                      elseif($months_diff>=36 && $months_diff<72)
                      {
                        $mac=8600;
                      }
                      elseif($months_diff>=72 && $months_diff<144)
                      {
                        $mac=7290;
                      }
                      else
                      {
                        $mac=0;
                      }
                    }

                    if($months_diff<36)
                    {
                        $postData["obligor_21b".$i.'a']=$months_diff." Months";
                    } else {
                        $start=date("Y-m-d");
                        $end=$newDob;
                        $end OR $end = time();
                        $start = new DateTime("$start");
                        $end   = new DateTime("$end");
                        $diff  = $start->diff($end);
                        $postData["obligor_21b".$i.'a']= $diff->format('%y')." Years";
                    }

                  } else {
                              $postData["obligor_21b".$i.'a']='';
                  }

                        $postData["obligor_21c".$i] = $mac;

                        $postData["obligor_21d".$i] = ($postData["obligor_21d".$i] != '') ? $postData["obligor_21d".$i] : 0;

                        $sumOf21hObligeeObligor = $postData['obligee_21h'.$i] + $postData['obligor_21h'.$i];                  
                        $sumOf21hObligeeObligor = ($sumOf21hObligeeObligor == '') ? 1 : $sumOf21hObligeeObligor;

                        $postData['obligor_21e'.$i] = min($postData['obligor_21c'.$i], $sumOf21hObligeeObligor);
                        $postData["obligor_21e".$i]=($postData["obligor_21e".$i]!='')?$postData["obligor_21e".$i]:0;

                        $apporSumObligor = ($postData['obligor_21e'.$i]/$sumOf21hObligeeObligor);
                        $postData['21_apportioned_obligor_A'.$i] = ($apporSumObligor * $postData['obligee_21h'.$i]);
                        $postData['21_apportioned_obligor_B'.$i] = ($apporSumObligor * $postData['obligor_21h'.$i]);

                        // $e_total = $e_total+$postData["obligor_21e".$i];

                        $e_total = $e_total + $postData['21_apportioned_obligor_A'.$i];
                        $obligor21KTotal = $obligor21KTotal + $postData['21_apportioned_obligor_B'.$i];
                  }

                  $postData["obligee_21k"] = $e_total;
                  $postData["obligor_21k"] = $obligor21KTotal;

                  // if($postData["obligee_21j"]>0)
                  // {
                  //   $postData["21m2"] = $postData["obligee_21j"]-($postData["21l1"]-$postData["21l2"]);
                  // }

                  // if($postData["obligor_21k"]>0)
                  // {
                  //  $postData["21n4"] = $postData["obligor_21k"]-($postData["21l3"]-$postData["21l4"]);
                  // }

                  /*************************************************/

                  /**
                  * Remove Above Comments when Split sheets
                  * approved
                  */

                  // // (L21jC1+L21kC3)-(L21lC1+L21lC3)
                  // $postData['21m2'] = ($postData['obligee_21j'] + $postData['obligee_21k']) - ($postData['21l1'] + $postData['21l3']);

                  // // (L21jC2+L21kC4)-(L21lC2+L21lC4)
                  // $postData['21n4'] = ($postData['obligor_21j'] + $postData['obligor_21k']) - ($postData['21l2'] + $postData['21l4']);

                  $postData['21m2'] = ($postData['obligee_21j'] + $postData['obligor_21j']) - ($postData['21l1'] + $postData['21l2']);

                  // following fromulas are changed on 27-12-2019 23:11:00
                  // (L21jC2+L21kC4)-(L21lC2+L21lC4)
                  $postData['21n4'] = ($postData['obligor_21j'] + $postData['obligor_21k']) - ($postData['21l2'] + $postData['21l4']);
                  // (21k.c3+21k.c4)-(21l.c3+21l.c4)
                  $postData['21n4'] = ($postData['obligee_21k'] + $postData['obligor_21k']) - ($postData['21l3'] + $postData['21l4']);

                  if($postData['obligee_15'] == 1)
                  {
                        // echo $a=min($postData["obligee_17"], 0.5);
                        // echo $postData["obligor_17"];die;
                        $postData["21o1"] = (min($postData["obligee_17"]/100, 0.5) * $postData["21m2"]);
                        $postData["21o2"] = (min($postData["obligor_17"]/100,0.5) * $postData["21m2"]);

                  } else {

                        $postData["21o1"] = ($postData["obligee_17"]/100 * $postData["21m2"]);
                        $postData["21o2"] = ($postData["obligor_17"]/100 * $postData["21m2"]);
                  }

                  if($postData['obligor_15'] == 1)
                  {
                        $postData["21o3"] = (min($postData["obligee_17"]/100, 0.5) * $postData["21n4"]);
                        $postData["21o4"] = (min($postData["obligor_17"]/100, 0.5) * $postData["21n4"]);

                  } else {

                        $postData["21o3"] = $postData["obligee_17"]/100 * $postData["21n4"];
                        $postData["21o4"] = $postData["obligor_17"]/100 * $postData["21n4"];
                  }

                  /*************************************************/

                  $postData["21p1"] = max(($postData["21o1"]-$postData["21a1"]),0);
                  $postData["21p2"] = max(($postData["21o2"]-$postData["21a2"]),0);
                  $postData["21p3"] = max(($postData["21o3"]-$postData["21a3"]),0);
                  $postData["21p4"] = max(($postData["21o4"]-$postData["21a4"]),0);

                  $postData["obligee_22"] = ($postData["18d2"]-$postData["obligee_19b"]-$postData["20a2"])+$postData["21p2"];
                  $postData["obligor_22"] = ($postData["18d3"]-$postData["obligor_19b"]-$postData["20a3"])+$postData["21p3"];

                  $postData["obligee_22"] = max($postData["obligee_22"],0);
                  $postData["obligor_22"] = max($postData["obligor_22"],0);




                  /***************** calculation for O21ksplit **************************/
                  $result21kaObligeeArray=DB::select(DB::raw("SELECT getFedChildCareCreditPercentage2018(".$postData['obligee_14'].") AS calculation"));

                  $result21kaObligee = $result21kaObligeeArray[0]->calculation;

                  $result21kaObligorArray=DB::select(DB::raw("SELECT getFedChildCareCreditPercentage2018(".$postData['obligor_14'].") AS calculation"));

                  $result21kaObligor = $result21kaObligorArray[0]->calculation;

                  $postData['obligee_21ka1'] = $result21kaObligee;
                  $postData['obligee_21ka2'] = $result21kaObligor;

                  $postData['obligor_21ka1'] = $result21kaObligee;
                  $postData['obligor_21ka2'] = $result21kaObligor;

                  /*************************************************/

                  $countOf21e = 0;
                  $countOf21i = 0;

                  for ($i=0; $i <= 6; $i++) 
                  { 
                  if ($postData['obligee_21e'.$i] > 0)
                  {
                        $countOf21e = $countOf21e + 1;
                  }

                  if ($postData['obligor_21e'.$i] > 0)
                  {
                        $countOf21i = $countOf21i + 1;
                  }           
                  }

                  $parentACreditCapArray=DB::select(DB::raw("SELECT getFedChildCareCap2018(".$countOf21e.") AS calculation"));
                  $parentACreditCap = $parentACreditCapArray[0]->calculation;

                  $parentBCreditCapArray=DB::select(DB::raw("SELECT getFedChildCareCap2018(".$countOf21i.") AS calculation"));
                  $parentBCreditCap = $parentBCreditCapArray[0]->calculation;

                  $postData['obligee_21kb1'] = $postData['obligee_21ka1'] * min(($postData['obligee_1'] + max($postData['obligee_3d'], 0)), $postData['obligee_21j'], $parentACreditCap);

                  $postData['obligee_21kb2'] = $postData['obligee_21ka2'] * min(($postData['obligor_1'] + max($postData['obligor_3d'], 0)), $postData['obligor_21j'], $parentACreditCap);

                  $postData['obligor_21kb1'] = $postData['obligor_21ka1'] * min(($postData['obligee_1'] + max($postData['obligee_3d'], 0)), $postData['obligee_21k'], $parentBCreditCap);

                  $postData['obligor_21kb2'] = $postData['obligor_21ka2'] * min(($postData['obligor_1'] + max($postData['obligor_3d'], 0)), $postData['obligor_21k'], $parentBCreditCap);

                  /*************************************************/

                  $result21kcObligeeArray=DB::select(DB::raw("SELECT getOhChildCareCreditPercentage2018(".$postData['obligee_14'].") AS calculation"));

                  $result21kcObligee = $result21kcObligeeArray[0]->calculation;

                  $result21kcObligorArray=DB::select(DB::raw("SELECT getOhChildCareCreditPercentage2018(".$postData['obligor_14'].") AS calculation"));

                  $result21kcObligor = $result21kcObligorArray[0]->calculation;

                  $postData['obligee_21kc1'] = $result21kcObligee;
                  $postData['obligee_21kc2'] = $result21kcObligor;

                  $postData['obligor_21kc1'] = $result21kcObligee;
                  $postData['obligor_21kc2'] = $result21kcObligor;

                  /*************************************************/

                  // following fromulas are changed on 27-12-2019 22:14:00
                  // $postData['obligee_21kd1'] = $postData['obligee_21kc1'] * $postData['obligee_21j'];
                  // $postData['obligee_21kd2'] = $postData['obligee_21kc2'] * $postData['obligor_21j'];

                  // $postData['obligor_21kd1'] = $postData['obligor_21kc1'] * $postData['obligee_21k'];
                  // $postData['obligor_21kd2'] = $postData['obligor_21kc2'] * $postData['obligor_21k'];

                  $postData['obligee_21kd1'] = $postData['obligee_21kc1'] * $postData['obligee_21kb1'];
                  $postData['obligee_21kd2'] = $postData['obligee_21kc2'] * $postData['obligee_21kb2'];

                  $postData['obligor_21kd1'] = $postData['obligor_21kc1'] * $postData['obligor_21kb1'];
                  $postData['obligor_21kd2'] = $postData['obligor_21kc2'] * $postData['obligor_21kb2'];




                  /***************** calculation for O21lsplit **************************/
                  if ((isset($postData['21l_obligee_ParentA'])) && ($postData['21l_obligee_ParentA'] == 'calculation'))
                  {
                        $postData['21l1'] = $postData['obligee_21kb1'] + $postData['obligee_21kd1'];

                  } else {

                        $postData['21l1'] = ($postData['21l_obligee_ParentA_Over_input'] != '') ? $postData['21l_obligee_ParentA_Over_input'] : 0;
                  }

                  if ((isset($postData['21l_obligee_ParentB'])) && ($postData['21l_obligee_ParentB'] == 'calculation'))
                  {
                        $postData['21l2'] = $postData['obligee_21kb2'] + $postData['obligee_21kd2'];

                  } else {

                        $postData['21l2'] = ($postData['21l_obligee_ParentB_Over_input'] != '') ? $postData['21l_obligee_ParentB_Over_input'] : 0;
                  }

                  if ((isset($postData['21l_obligor_ParentA'])) && ($postData['21l_obligor_ParentA'] == 'calculation'))
                  {
                        $postData['21l3'] = $postData['obligor_21kb1'] + $postData['obligor_21kd1'];

                  } else {

                        $postData['21l3'] = ($postData['21l_obligor_ParentA_Over_input'] != '') ? $postData['21l_obligor_ParentA_Over_input'] : 0;
                  }

                  if ((isset($postData['21l_obligor_ParentB'])) && ($postData['21l_obligor_ParentB'] == 'calculation'))
                  {
                        $postData['21l4'] = $postData['obligor_21kb2'] + $postData['obligor_21kd2'];

                  } else {

                        $postData['21l4'] = ($postData['21l_obligor_ParentB_Over_input'] != '') ? $postData['21l_obligor_ParentB_Over_input'] : 0;
                  }

                  /**********************************************/

                  // following fromulas are changed on 27-12-2019 23:11:00
                  // (L21jC1+L21kC3)-(L21lC1+L21lC3)

                  // $postData['21m2'] = ($postData['obligee_21j'] + $postData['obligee_21k']) - ($postData['21l1'] + $postData['21l3']);

                  // (21j.c1+21j.c2)-(21l.c1+21l.c2). 

                  $postData['21m2'] = ($postData['obligee_21j'] + $postData['obligor_21j']) - ($postData['21l1'] + $postData['21l2']);

                  // following fromulas are changed on 27-12-2019 23:11:00
                  // (L21jC2+L21kC4)-(L21lC2+L21lC4)
                  $postData['21n4'] = ($postData['obligor_21j'] + $postData['obligor_21k']) - ($postData['21l2'] + $postData['21l4']);
                  // (21k.c3+21k.c4)-(21l.c3+21l.c4)
                  $postData['21n4'] = ($postData['obligee_21k'] + $postData['obligor_21k']) - ($postData['21l3'] + $postData['21l4']);


                  /***************** calculation for O24split **************************/
                  $combinedGrossIncome = $postData['obligee_1'] + $postData['obligor_1'];
                  $combinedGrossIncome = ($combinedGrossIncome == '') ? 0 : $combinedGrossIncome;

                  $ohCashMedicalData=DB::select(DB::raw("SELECT getOHCashMedical2018(".$combinedGrossIncome.",".$postData['number_children_order'].") As tmpResult"));

                  $postData["obligee_24"] = 0;
                  $postData["obligor_24"] = 0;

                  $postData["obligee_25"] = 0;
                  $postData["obligor_25"] = 0;

                  $postData["obligee_26a"] = ($postData["obligee_26a"] != '')?$postData["obligee_26a"]:0;
                  $postData["obligor_26a"] = ($postData["obligor_26a"] != '')?$postData["obligor_26a"]:0;
                  $postData["obligee_26b"] = ($postData["obligee_26b"] != '')?$postData["obligee_26b"]:0;
                  $postData["obligor_26b"] = ($postData["obligor_26b"] != '')?$postData["obligor_26b"]:0;

                  $postData["obligee_26c"] = 0;
                  $postData["obligor_26c"] = 0;

                  $postData["obligee_27"] = 0;
                  $postData["obligor_27"] = 0;

                  $postData["obligee_28"] = ($postData["obligee_28"] != '')?$postData["obligee_28"]:0;
                  $postData["obligor_28"] = ($postData["obligor_28"] != '')?$postData["obligor_28"]:0;

                  $postData["obligee_29"] = 0;
                  $postData["obligor_29"] = 0;

                  $postData["obligee_30"]=($postData["obligee_30"] != '')?$postData["obligee_30"]:0;
                  $postData["obligor_30"]=($postData["obligor_30"] != '')?$postData["obligor_30"]:0;

                  /******************************************************************************/

                  $obligee23aOhCash=DB::select(DB::raw("SELECT getOHCashMedical2018(".$postData['obligee_14'].",".$postData['parent_a_children'].") As tmpResult"));

                  $obligor23aOhCash=DB::select(DB::raw("SELECT getOHCashMedical2018(".$postData['obligor_14'].",".$postData['parent_b_children'].") As tmpResult"));

                  $postData['obligee_23a'] = $obligee23aOhCash[0]->tmpResult;
                  // $postData['obligee_23a'] = 388.70;
                  $postData['obligor_23a'] = $obligor23aOhCash[0]->tmpResult;
                  // $postData['obligor_23a'] = 388.70;

                  /******************************************************************************/

                  $postData['obligee_23b'] = ($postData['obligee_23a']*($postData['obligor_17']/100));
                  $postData['obligor_23b'] = ($postData['obligor_23a']*($postData['obligee_17']/100));


                  $postData['obligee_24'] = round($postData['obligor_22'], 2);
                  $postData['obligor_24'] = round($postData['obligee_22'], 2);

                  $postData['24nso'] = round(abs($postData['obligor_24']-$postData['obligee_24']), 2);


                  if($postData['obligee_24'] > $postData['obligor_24'])
                  {
                  $postData['obligee_25'] = $postData['24nso']/12;
                  }

                  if($postData['obligor_24'] > $postData['obligee_24'])
                  {
                  $postData['obligor_25'] = $postData['24nso']/12;
                  }

                  $postData['obligee_26c'] = ($postData['obligee_26a'] + $postData['obligee_26b']);
                  $postData['obligor_26c'] = ($postData['obligor_26a'] + $postData['obligor_26b']);

                  $postData['obligee_27'] = ($postData['obligee_25'] + $postData['obligee_26c']);
                  $postData['obligor_27'] = ($postData['obligor_25'] + $postData['obligor_26c']);

                  if($postData['obligor_23b'] > 0)
                  {
                  $postData['obligee_28'] = round($postData['obligor_23b'], 2);
                  }

                  if($postData['obligee_23b'] > 0)
                  {
                  $postData['obligor_28'] = round($postData['obligee_23b'], 2);
                  }

                  $postData['28nso'] = abs($postData['obligor_28'] - $postData['obligee_28']);

                  if ($postData['obligee_28'] > $postData['obligor_28'])
                  {
                  $postData['obligee_29'] = round(($postData['28nso']/12), 2);
                  }

                  if ($postData['obligor_28'] > $postData['obligee_28'])
                  {
                  $postData['obligor_29'] = round(($postData['28nso']/12), 2);
                  }

                  $postData['obligee_31'] = ($postData['obligee_29'] + $postData['obligee_30']);
                  $postData['obligor_31'] = ($postData['obligor_29'] + $postData['obligor_30']);

                  $postData['obligee_32'] = ($postData['obligee_27'] + $postData['obligee_31']);
                  $postData['obligor_32'] = ($postData['obligor_27'] + $postData['obligor_31']);

                  $postData['nso_32'] = abs($postData['obligor_32'] - $postData['obligee_32']);






                  /***************** calculation for O26split **************************/
                  $type='obligee';
                  if ((isset($postData['26a_'.$type.'_child_sport'])) && ($postData['26a_'.$type.'_child_sport'] == 'deviation'))
                  {
                        $postData[$type.'_26a'] = $postData['26a_'.$type.'_child_sport_deviation_text'];

                  } else {

                        $postData[$type.'_26a'] = $postData[$type.'_25'] - $postData['26a_'.$type.'_child_sport_non_deviation_text'];
                  }

                  $postData[$type.'_26a'] = ($postData[$type.'_26a'] != '') ? $postData[$type.'_26a'] : 0;

                  $type='obligor';
                  if ((isset($postData['26a_'.$type.'_child_sport'])) && ($postData['26a_'.$type.'_child_sport'] == 'deviation'))
                  {
                        $postData[$type.'_26a'] = $postData['26a_'.$type.'_child_sport_deviation_text'];

                  } else {

                        $postData[$type.'_26a'] = $postData[$type.'_25'] - $postData['26a_'.$type.'_child_sport_non_deviation_text'];
                  }

                  $postData[$type.'_26a'] = ($postData[$type.'_26a'] != '') ? $postData[$type.'_26a'] : 0;



                  /***************** calculation for O31split **************************/
                  $type='obligee';
                  $typeOpposite = ($type == 'obligee') ? 'obligor' : 'obligee';

                  $postData[$type.'_33'] = 0;
                  if ($postData[$type.'_32'] > $postData[$typeOpposite.'_32'])
                  {
                        // $postData[$type.'_33'] = round(($postData['nso_32']/12), 2);
                        $postData[$type.'_33'] = round(($postData['nso_32']), 2);
                  }

                  $postData[$type.'_34'] = (isset($postData[$type.'_33']) && ($postData[$type.'_33'] == 0)) ? 0 : $postData[$type.'_33'];
                  $postData[$type.'_35'] = (isset($postData[$type.'_33']) && ($postData[$type.'_33'] == 0)) ? 0 : ($postData[$type.'_33'] * 0.02);

                  $sumFor36 = $postData[$type.'_34'] + $postData[$type.'_35'];
                  $postData[$type.'_36'] = (isset($postData[$type.'_33']) && ($postData[$type.'_33'] == 0)) ? 0 : $sumFor36;

                  $type='obligor';
                  $typeOpposite = ($type == 'obligee') ? 'obligor' : 'obligee';

                  $postData[$type.'_33'] = 0;
                  if ($postData[$type.'_32'] > $postData[$typeOpposite.'_32'])
                  {
                        // $postData[$type.'_33'] = round(($postData['nso_32']/12), 2);
                        $postData[$type.'_33'] = round(($postData['nso_32']), 2);
                  }

                  $postData[$type.'_34'] = (isset($postData[$type.'_33']) && ($postData[$type.'_33'] == 0)) ? 0 : $postData[$type.'_33'];
                  $postData[$type.'_35'] = (isset($postData[$type.'_33']) && ($postData[$type.'_33'] == 0)) ? 0 : ($postData[$type.'_33'] * 0.02);

                  $sumFor36 = $postData[$type.'_34'] + $postData[$type.'_35'];
                  $postData[$type.'_36'] = (isset($postData[$type.'_33']) && ($postData[$type.'_33'] == 0)) ? 0 : $sumFor36;

                  // if ($postData['obligee_32'] == $postData['obligor_32'])
                  // {
                  //       // $postData[$type.'_33'] = round(($postData['nso_32']/12), 2);
                  //       $postData['obligee_33'] = 0;
                  //       $postData['obligor_33'] = 0;
                  // }

                  if(isset($postData['obligee_21ka1'])){
                        $postData['obligee_21ka1']=$postData['obligee_21ka1']*100;
                  };
                  if(isset($postData['obligee_21ka2'])){
                        $postData['obligee_21ka2']=$postData['obligee_21ka2']*100;
                  };
                  if(isset($postData['obligor_21ka1'])){
                        $postData['obligor_21ka1']=$postData['obligor_21ka1']*100;
                  };
                  if(isset($postData['obligor_21ka2'])){
                        $postData['obligor_21ka2']=$postData['obligor_21ka2']*100;
                  };
                  if(isset($postData['obligee_21kc1'])){
                        $postData['obligee_21kc1']=$postData['obligee_21kc1']*100;
                  };
                  if(isset($postData['obligee_21kc2'])){
                        $postData['obligee_21kc2']=$postData['obligee_21kc2']*100;
                  };
                  if(isset($postData['obligor_21kc1'])){
                        $postData['obligor_21kc1']=$postData['obligor_21kc1']*100;
                  };
                  if(isset($postData['obligor_21kc2'])){
                        $postData['obligor_21kc2']=$postData['obligor_21kc2']*100;
                  };
                  // end of calculate code for split sheet before save/download
                  $array=array(
                          "user_id"=>Auth::user()->id,
                          "case_id"=>$request->case_id,
                          "form_text"=>serialize($request->all()),
                          'form_state'=>$request->sheet_state,
                          "form_custody"=>$request->sheet_custody,
                          );

                  if(isset($request->case_id)){
                              // die('yes');
                        $sheet_data=DB::table('users_attorney_submissions')->where([['user_id', Auth::user()->id], ['case_id', $request->case_id],['form_state', $request->sheet_state],['form_custody', $request->sheet_custody]])->latest('id')->first();
                        if(isset($sheet_data)){
                              DB::table('users_attorney_submissions')->where('id',$sheet_data->id)->update($array);
                        } else {
                              // die('no');
                              DB::table('users_attorney_submissions')->insert($array);
                        }
                  } else {

                        $sheet_data=DB::table('users_attorney_submissions')->where([['user_id', Auth::user()->id],['form_state', $request->sheet_state],['form_custody', $request->sheet_custody]])->whereNull('case_id')->latest('id')->first();
                        if(isset($sheet_data)){
                              DB::table('users_attorney_submissions')->where('id',$sheet_data->id)->update($array);
                        } else {
                              DB::table('users_attorney_submissions')->insert($array);
                        }
                  }
                  if($postData['obligee_1_datepick']==''){
                        $postData['obligee_1_datepick']=null;
                  } else {
                        $postData['obligee_1_datepick']=date("Y-m-d", strtotime($postData['obligee_1_datepick'])); 
                  }
                  if($postData['obligor_1_datepick']==''){
                        $postData['obligor_1_datepick']=null;
                  } else {
                        $postData['obligor_1_datepick']=date("Y-m-d", strtotime($postData['obligor_1_datepick'])); 
                  }
                  if($postData['obligee_21b1']==''){
                        $postData['obligee_21b1']=null;
                  } else {
                        $postData['obligee_21b1']=date("Y-m-d", strtotime($postData['obligee_21b1'])); 
                  }
                  if($postData['obligee_21b2']==''){
                        $postData['obligee_21b2']=null;
                  } else {
                        $postData['obligee_21b2']=date("Y-m-d", strtotime($postData['obligee_21b2'])); 
                  }
                  if($postData['obligee_21b3']==''){
                        $postData['obligee_21b3']=null;
                  } else {
                        $postData['obligee_21b3']=date("Y-m-d", strtotime($postData['obligee_21b3'])); 
                  }
                  if($postData['obligee_21b4']==''){
                        $postData['obligee_21b4']=null;
                  } else {
                        $postData['obligee_21b4']=date("Y-m-d", strtotime($postData['obligee_21b4'])); 
                  }
                  if($postData['obligee_21b5']==''){
                        $postData['obligee_21b5']=null;
                  } else {
                        $postData['obligee_21b5']=date("Y-m-d", strtotime($postData['obligee_21b5'])); 
                  }
                  if($postData['obligee_21b6']==''){
                        $postData['obligee_21b6']=null;
                  } else {
                        $postData['obligee_21b6']=date("Y-m-d", strtotime($postData['obligee_21b6'])); 
                  }
                  if($postData['obligor_21b1']==''){
                        $postData['obligor_21b1']=null;
                  } else {
                        $postData['obligor_21b1']=date("Y-m-d", strtotime($postData['obligor_21b1'])); 
                  }
                  if($postData['obligor_21b2']==''){
                        $postData['obligor_21b2']=null;
                  } else {
                        $postData['obligor_21b2']=date("Y-m-d", strtotime($postData['obligor_21b2'])); 
                  }
                  if($postData['obligor_21b3']==''){
                        $postData['obligor_21b3']=null;
                  } else {
                        $postData['obligor_21b3']=date("Y-m-d", strtotime($postData['obligor_21b3'])); 
                  }
                  if($postData['obligor_21b4']==''){
                        $postData['obligor_21b4']=null;
                  } else {
                        $postData['obligor_21b4']=date("Y-m-d", strtotime($postData['obligor_21b4'])); 
                  }
                  if($postData['obligor_21b5']==''){
                        $postData['obligor_21b5']=null;
                  } else {
                        $postData['obligor_21b5']=date("Y-m-d", strtotime($postData['obligor_21b5'])); 
                  }
                  if($postData['obligor_21b6']==''){
                        $postData['obligor_21b6']=null;
                  } else {
                        $postData['obligor_21b6']=date("Y-m-d", strtotime($postData['obligor_21b6'])); 
                  }
                  $array2=array(
                              "user_id"=>Auth::user()->id,
                              "case_id"=>$postData['case_id'],
                              "parenta_name"=>$postData['obligee_name'],
                              "parentb_name"=>$postData['obligor_name'],                        
                              "county_name"=>$postData['county_name'], 
                              "sets_case_number"=>$postData['sets_case_number'],    
                              "court_administrative_order_number"=>$postData['court_administrative_order_number'], 
                              "number_children_order"=>$postData['number_children_order'], 
                              "parenta_1_radio"=>$postData['obligee_1_radio'],
                              "parenta_1_input_year"=>$postData['obligee_1_input_year'],   
                              "parenta_1_dropdown"=>$postData['obligee_1_dropdown'],
                              "parenta_1_input_ytd"=>$postData['obligee_1_input_ytd'],
                              "parenta_1_datepick"=>$postData['obligee_1_datepick'],
                              "parentb_1_input_year"=>$postData['obligor_1_input_year'],  
                              "parentb_1_dropdown"=>$postData['obligor_1_dropdown'],
                              "parentb_1_radio"=>$postData['obligor_1_radio'],
                              "parentb_1_input_ytd"=>$postData['obligor_1_input_ytd'],
                              "parentb_1_datepick"=>$postData['obligor_1_datepick'],
                              "parenta_1"=>$postData['obligee_1'],
                              "parentb_1"=>$postData['obligor_1'],   
                              "parenta_2a"=>$postData['obligee_2a'],  
                              "parentb_2a"=>$postData['obligor_2a'],  
                              "parenta_2b"=>$postData['obligee_2b'],  
                              "parentb_2b"=>$postData['obligor_2b'],  
                              "parenta_2c"=>$postData['obligee_2c'],  
                              "parentb_2c"=>$postData['obligor_2c'], 
                              "parenta_2d"=>$postData['obligee_2d'],  
                              "parentb_2d"=>$postData['obligor_2d'],  
                              "parenta_3a"=>$postData['obligee_3a'], 
                              "parentb_3a"=>$postData['obligor_3a'],
                              "parenta_3b"=>$postData['obligee_3b'],  
                              "parentb_3b"=>$postData['obligor_3b'], 
                              "parenta_3_c_radio"=>$postData['obligee_3_c_radio'],   
                              "parenta_3_c_top_override_input"=>$postData['obligee_3_c_top_override_input'],  
                              "parenta_3_c_override_input"=>$postData['obligee_3_c_override_input'],  
                              "parentb_3_c_radio"=>$postData['obligor_3_c_radio'],   
                              "parentb_3_c_top_override_input"=>$postData['obligor_3_c_top_override_input'],  
                              "parentb_3_c_override_input"=>$postData['obligor_3_c_override_input'],  
                              "parenta_3c"=>$postData['obligee_3c'],  
                              "parentb_3c"=>$postData['obligor_3c'],  
                              "parenta_3d"=>$postData['obligee_3d'],  
                              "parentb_3d"=>$postData['obligor_3d'],  
                              "parenta_4"=>$postData['obligee_4'],   
                              "parentb_4"=>$postData['obligor_4'],  
                              "parenta_5"=>$postData['obligee_5'],   
                              "parentb_5"=>$postData['obligor_5'],   
                              "parenta_6"=>$postData['obligee_6'],   
                              "parentb_6"=>$postData['obligor_6'],  
                              "parenta_7"=>$postData['obligee_7'],  
                              "parentb_7"=>$postData['obligor_7'],   
                              "parenta_8"=>$postData['obligee_8'],   
                              "parentb_8"=>$postData['obligor_8'],  
                              "parenta_9a"=>$postData['obligee_9a'],  
                              "parentb_9a"=>$postData['obligor_9a'],  
                              "parenta_9b"=>$postData['obligee_9b'], 
                              "parentb_9b"=>$postData['obligor_9b'],  
                              "parenta_9c"=>$postData['obligee_9c'],  
                              "parentb_9c"=>$postData['obligor_9c'],  
                              "parenta_9d"=>$postData['obligee_9d'],  
                              "parentb_9d"=>$postData['obligor_9d'],  
                              "parenta_9e"=>$postData['obligee_9e'],  
                              "parentb_9e"=>$postData['obligor_9e'],  
                              "parenta_9f"=>$postData['obligee_9f'], 
                              "parentb_9f"=>$postData['obligor_9f'], 
                              "parenta_10a"=>$postData['obligee_10a'], 
                              "parenta_10b"=>$postData['obligee_10b'], 
                              "parentb_10b"=>$postData['obligor_10b'], 
                              "parenta_11"=>$postData['obligee_11'],  
                              "parentb_11"=>$postData['obligor_11'],  
                              "parenta_12"=>$postData['obligee_12'], 
                              "parentb_12"=>$postData['obligor_12'],  
                              "parenta_13"=>$postData['obligee_13'], 
                              "parentb_13"=>$postData['obligor_13'],  
                              "parenta_14"=>$postData['obligee_14'],  
                              "parentb_14"=>$postData['obligor_14'], 
                              "parenta_15"=>$postData['obligee_15'],  
                              "parentb_15"=>$postData['obligor_15'], 
                              "parenta_16"=>$postData['obligee_16'], 
                              "parenta_17"=>$postData['obligee_17'],  
                              "parentb_17"=>$postData['obligor_17'],  
                              "parent_a_children"=>$postData['parent_a_children'],   
                              "parent_b_children"=>$postData['parent_b_children'],   
                              "18a1"=>$postData['18a1'],    
                              "18a2"=>$postData['18a2'],    
                              "18a3"=>$postData['18a3'],   
                              "18a4"=>$postData['18a4'],    
                              "parenta_18b"=>$postData['obligee_18b'],
                              "parentb_18b"=>$postData['obligor_18b'],
                              "18c1"=>$postData['18c1'],    
                              "18c2"=>$postData['18c2'],   
                              "18c3"=>$postData['18c3'],    
                              "18c4"=>$postData['18c4'],   
                              "18d1"=>$postData['18d1'],   
                              "18d2"=>$postData['18d2'],    
                              "18d3"=>$postData['18d3'],    
                              "18d4"=>$postData['18d4'],    
                              "parenta_19a"=>$postData['obligee_19a'], 
                              "parentb_19a"=>$postData['obligor_19a'], 
                              "parenta_19b"=>$postData['obligee_19b'], 
                              "parentb_19b"=>$postData['obligor_19b'], 
                              "20a2"=>$postData['20a2'],    
                              "20a3"=>$postData['20a3'],    
                              "21a1"=>$postData['21a1'],    
                              "21a2"=>$postData['21a2'],    
                              "21a3"=>$postData['21a3'],  
                              "21a4"=>$postData['21a4'],    
                              "parenta_21b1"=>$postData['obligee_21b1'],
                              "parenta_21b2"=>$postData['obligee_21b2'],
                              "parenta_21b3"=>$postData['obligee_21b3'],
                              "parenta_21b4"=>$postData['obligee_21b4'],
                              "parenta_21b5"=>$postData['obligee_21b5'],
                              "parenta_21b6"=>$postData['obligee_21b6'], 
                              "parenta_21b1a"=>$postData['obligee_21b1a'],  
                              "parenta_21b2a"=>$postData['obligee_21b2a'],   
                              "parenta_21b3a"=>$postData['obligee_21b3a'],   
                              "parenta_21b4a"=>$postData['obligee_21b4a'],   
                              "parenta_21b5a"=>$postData['obligee_21b5a'],   
                              "parenta_21b6a"=>$postData['obligee_21b6a'],  
                              "parenta_21c1"=>$postData['obligee_21c1'],    
                              "parenta_21c2"=>$postData['obligee_21c2'],    
                              "parenta_21c3"=>$postData['obligee_21c3'],    
                              "parenta_21c4"=>$postData['obligee_21c4'],   
                              "parenta_21c5"=>$postData['obligee_21c5'],    
                              "parenta_21c6"=>$postData['obligee_21c6'],    
                              "parenta_21d1"=>$postData['obligee_21d1'],    
                              "parentb_21d1"=>$postData['obligor_21d1'],    
                              "parenta_21d2"=>$postData['obligee_21d2'],    
                              "parentb_21d2"=>$postData['obligor_21d2'],    
                              "parenta_21d3"=>$postData['obligee_21d3'],    
                              "parentb_21d3"=>$postData['obligor_21d3'],    
                              "parenta_21d4"=>$postData['obligee_21d4'],    
                              "parentb_21d4"=>$postData['obligor_21d4'],    
                              "parenta_21d5"=>$postData['obligee_21d5'],    
                              "parentb_21d5"=>$postData['obligor_21d5'],   
                              "parenta_21d6"=>$postData['obligee_21d6'],    
                              "parentb_21d6"=>$postData['obligor_21d6'],    
                              "parenta_21e1"=>$postData['obligee_21e1'],    
                              "parenta_21e2"=>$postData['obligee_21e2'],    
                              "parenta_21e3"=>$postData['obligee_21e3'],    
                              "parenta_21e4"=>$postData['obligee_21e4'],    
                              "parenta_21e5"=>$postData['obligee_21e5'],    
                              "parenta_21e6"=>$postData['obligee_21e6'],    
                              "21_apportioned_parenta_A1"=>$postData['21_apportioned_obligee_A1'],   
                              "21_apportioned_parenta_B1"=>$postData['21_apportioned_obligee_B1'],   
                              "21_apportioned_parenta_A2"=>$postData['21_apportioned_obligee_A2'],   
                              "21_apportioned_parenta_B2"=>$postData['21_apportioned_obligee_B2'],   
                              "21_apportioned_parenta_A3"=>$postData['21_apportioned_obligee_A3'],   
                              "21_apportioned_parenta_B3"=>$postData['21_apportioned_obligee_B3'],   
                              "21_apportioned_parenta_A4"=>$postData['21_apportioned_obligee_A4'],   
                              "21_apportioned_parenta_B4"=>$postData['21_apportioned_obligee_B4'],   
                              "21_apportioned_parenta_A5"=>$postData['21_apportioned_obligee_A5'],   
                              "21_apportioned_parenta_B5"=>$postData['21_apportioned_obligee_B5'],   
                              "21_apportioned_parenta_A6"=>$postData['21_apportioned_obligee_A6'],   
                              "21_apportioned_parenta_B6"=>$postData['21_apportioned_obligee_B6'], 
                              "parentb_21b1"=>$postData['obligor_21b1'],
                              "parentb_21b2"=>$postData['obligor_21b2'],
                              "parentb_21b3"=>$postData['obligor_21b3'],
                              "parentb_21b4"=>$postData['obligor_21b4'],
                              "parentb_21b5"=>$postData['obligor_21b5'],
                              "parentb_21b6"=>$postData['obligor_21b6'],
                              "parentb_21b1a"=>$postData['obligor_21b1a'],   
                              "parentb_21b2a"=>$postData['obligor_21b2a'],   
                              "parentb_21b3a"=>$postData['obligor_21b3a'],  
                              "parentb_21b4a"=>$postData['obligor_21b4a'],   
                              "parentb_21b5a"=>$postData['obligor_21b5a'],   
                              "parentb_21b6a"=>$postData['obligor_21b6a'],   
                              "parentb_21c1"=>$postData['obligor_21c1'],    
                              "parentb_21c2"=>$postData['obligor_21c2'],    
                              "parentb_21c3"=>$postData['obligor_21c3'],   
                              "parentb_21c4"=>$postData['obligor_21c4'],   
                              "parentb_21c5"=>$postData['obligor_21c5'], 
                              "parentb_21c6"=>$postData['obligor_21c6'],    
                              "parenta_21h1"=>$postData['obligee_21h1'],    
                              "parentb_21h1"=>$postData['obligor_21h1'],    
                              "parenta_21h2"=>$postData['obligee_21h2'],    
                              "parentb_21h2"=>$postData['obligor_21h2'],   
                              "parenta_21h3"=>$postData['obligee_21h3'],    
                              "parentb_21h3"=>$postData['obligor_21h3'],    
                              "parenta_21h4"=>$postData['obligee_21h4'],    
                              "parentb_21h4"=>$postData['obligor_21h4'],    
                              "parenta_21h5"=>$postData['obligee_21h5'],    
                              "parentb_21h5"=>$postData['obligor_21h5'], 
                              "parenta_21h6"=>$postData['obligee_21h6'],    
                              "parentb_21h6"=>$postData['obligor_21h6'],    
                              "parentb_21e1"=>$postData['obligor_21e1'],    
                              "parentb_21e2"=>$postData['obligor_21e2'],    
                              "parentb_21e3"=>$postData['obligor_21e3'],   
                              "parentb_21e4"=>$postData['obligor_21e4'],    
                              "parentb_21e5"=>$postData['obligor_21e5'],    
                              "parentb_21e6"=>$postData['obligor_21e6'],    
                              "21_apportioned_parentb_A1"=>$postData['21_apportioned_obligor_A1'],  
                              "21_apportioned_parentb_B1"=>$postData['21_apportioned_obligor_B1'],   
                              "21_apportioned_parentb_A2"=>$postData['21_apportioned_obligor_A2'],   
                              "21_apportioned_parentb_B2"=>$postData['21_apportioned_obligor_B2'],   
                              "21_apportioned_parentb_A3"=>$postData['21_apportioned_obligor_A3'],   
                              "21_apportioned_parentb_B3"=>$postData['21_apportioned_obligor_B3'],   
                              "21_apportioned_parentb_A4"=>$postData['21_apportioned_obligor_A4'],   
                              "21_apportioned_parentb_B4"=>$postData['21_apportioned_obligor_B4'],   
                              "21_apportioned_parentb_A5"=>$postData['21_apportioned_obligor_A5'],  
                              "21_apportioned_parentb_B5"=>$postData['21_apportioned_obligor_B5'],   
                              "21_apportioned_parentb_A6"=>$postData['21_apportioned_obligor_A6'],   
                              "21_apportioned_parentb_B6"=>$postData['21_apportioned_obligor_B6'],   
                              "parenta_21j"=>$postData['obligee_21j'], 
                              "parentb_21j"=>$postData['obligor_21j'],
                              "parenta_21k"=>$postData['obligee_21k'], 
                              "parentb_21k"=>$postData['obligor_21k'], 
                              "parenta_21ka1"=>$postData['obligee_21ka1'],  
                              "parenta_21ka2"=>$postData['obligee_21ka2'],   
                              "parentb_21ka1"=>$postData['obligor_21ka1'],   
                              "parentb_21ka2"=>$postData['obligor_21ka2'],   
                              "parenta_21kb1"=>$postData['obligee_21kb1'],   
                              "parenta_21kb2"=>$postData['obligee_21kb2'],   
                              "parentb_21kb1"=>$postData['obligor_21kb1'],   
                              "parentb_21kb2"=>$postData['obligor_21kb2'],   
                              "parenta_21kc1"=>$postData['obligee_21kc1'],   
                              "parenta_21kc2"=>$postData['obligee_21kc2'],   
                              "parentb_21kc1"=>$postData['obligor_21kc1'],  
                              "parentb_21kc2"=>$postData['obligor_21kc2'],   
                              "parenta_21kd1"=>$postData['obligee_21kd1'],   
                              "parenta_21kd2"=>$postData['obligee_21kd2'],  
                              "parentb_21kd1"=>$postData['obligor_21kd1'],   
                              "parentb_21kd2"=>$postData['obligor_21kd2'],   
                              "21l_parenta_ParentA"=>$postData['21l_obligee_ParentA'], 
                              "21l_parenta_ParentB"=>$postData['21l_obligee_ParentB'], 
                              "21l_parentb_ParentA"=>$postData['21l_obligor_ParentA'], 
                              "21l_parentb_ParentB"=>$postData['21l_obligor_ParentB'],
                              "21l_parenta_ParentA_Over_input"=>$postData['21l_obligee_ParentA_Over_input'],  
                              "21l_parenta_ParentB_Over_input"=>$postData['21l_obligee_ParentB_Over_input'],  
                              "21l_parentb_ParentA_Over_input"=>$postData['21l_obligor_ParentA_Over_input'], 
                              "21l_parentb_ParentB_Over_input"=>$postData['21l_obligor_ParentB_Over_input'],  
                              "21l1"=>$postData['21l1'],    
                              "21l2"=>$postData['21l2'],    
                              "21l3"=>$postData['21l3'],    
                              "21l4"=>$postData['21l4'],    
                              "21m2"=>$postData['21m2'],   
                              "21n4"=>$postData['21n4'],    
                              "21o1"=>$postData['21o1'],   
                              "21o2"=>$postData['21o2'],    
                              "21o3"=>$postData['21o3'],    
                              "21o4"=>$postData['21o4'],    
                              "21p1"=>$postData['21p1'],    
                              "21p2"=>$postData['21p2'],    
                              "21p3"=>$postData['21p3'],    
                              "21p4"=>$postData['21p4'],    
                              "parenta_22"=>$postData['obligee_22'],  
                              "parentb_22"=>$postData['obligor_22'],
                              "parenta_23a"=>$postData['obligee_23a'],  
                              "parentb_23a"=>$postData['obligor_23a'],  
                              "parenta_23b"=>$postData['obligee_23b'],  
                              "parentb_23b"=>$postData['obligor_23b'],   
                              "parenta_24"=>$postData['obligee_24'],  
                              "parentb_24"=>$postData['obligor_24'],  
                              "24nso"=>$postData['24nso'],   
                              "parenta_25"=>$postData['obligee_25'],   
                              "parentb_25"=>$postData['obligor_25'],   
                              "parenta_26a_SpecialUnusual"=>$postData['obligee_26a_SpecialUnusual'],  
                              "parenta_26a_Significant"=>$postData['obligee_26a_Significant'], 
                              "parenta_26a_OtherCourt"=>$postData['obligee_26a_OtherCourt'],  
                              "parenta_26a_Extraordinaryt"=>$postData['obligee_26a_Extraordinaryt'],
                              "parenta_26a_Extended"=>$postData['obligee_26a_Extended'],  
                              "parenta_26a_ChildStandardt_living"=>$postData['obligee_26a_ChildStandardt_living'],  
                              "parenta_26a_ChildFinancial"=>$postData['obligee_26a_ChildFinancial'],
                              "parenta_26a_ChildEdOps"=>$postData['obligee_26a_ChildEdOps'],  
                              "parenta_26a_RelativeParental"=>$postData['obligee_26a_RelativeParental'],    
                              "parenta_26a_ParentalSupport"=>$postData['obligee_26a_ParentalSupport'], 
                              "parenta_26a_ObligeesIncome"=>$postData['obligee_26a_ObligeesIncome'], 
                              "parenta_26a_ChildPost_secondary"=>$postData['obligee_26a_ChildPost_secondary'], 
                              "parenta_26a_ParentalRemarriage"=>$postData['obligee_26a_ParentalRemarriage'],  
                              "parenta_26a_ParentalReunCost"=>$postData['obligee_26a_ParentalReunCost'], 
                              "parenta_26a_ParentalFederal"=>$postData['obligee_26a_ParentalFederal'], 
                              "parenta_26a_ExtraordinaryChild"=>$postData['obligee_26a_ExtraordinaryChild'],
                              "parenta_26a_relvant"=>$postData['obligee_26a_relvant'],   
                              "parentb_26a_SpecialUnusual"=>$postData['obligor_26a_SpecialUnusual'],  
                              "parentb_26a_Significant"=>$postData['obligor_26a_Significant'], 
                              "parentb_26a_OtherCourt"=>$postData['obligor_26a_OtherCourt'],  
                              "parentb_26a_Extraordinaryt"=>$postData['obligor_26a_Extraordinaryt'],
                              "parentb_26a_Extended"=>$postData['obligor_26a_Extended'],  
                              "parentb_26a_ChildStandardt_living"=>$postData['obligor_26a_ChildStandardt_living'],  
                              "parentb_26a_ChildFinancial"=>$postData['obligor_26a_ChildFinancial'],
                              "parentb_26a_ChildEdOps"=>$postData['obligor_26a_ChildEdOps'],  
                              "parentb_26a_RelativeParental"=>$postData['obligor_26a_RelativeParental'],    
                              "parentb_26a_ParentalSupport"=>$postData['obligor_26a_ParentalSupport'], 
                              "parentb_26a_ObligeesIncome"=>$postData['obligor_26a_ObligeesIncome'], 
                              "parentb_26a_ChildPost_secondary"=>$postData['obligor_26a_ChildPost_secondary'], 
                              "parentb_26a_ParentalRemarriage"=>$postData['obligor_26a_ParentalRemarriage'],  
                              "parentb_26a_ParentalReunCost"=>$postData['obligor_26a_ParentalReunCost'], 
                              "parentb_26a_ParentalFederal"=>$postData['obligor_26a_ParentalFederal'], 
                              "parentb_26a_ExtraordinaryChild"=>$postData['obligor_26a_ExtraordinaryChild'],
                              "parentb_26a_relvant"=>$postData['obligor_26a_relvant'],   
                              "26a_OtherRelevantText"=>$postData['26a_OtherRelevantText'],
                              "26a_parenta_child_sport"=>$postData['26a_obligee_child_sport'], 
                              "26a_parenta_child_sport_deviation_text"=>$postData['26a_obligee_child_sport_deviation_text'],  
                              "26a_parentb_child_sport"=>$postData['26a_obligor_child_sport'], 
                              "26a_parentb_child_sport_deviation_text"=>$postData['26a_obligor_child_sport_deviation_text'],  
                              "26a_parenta_child_sport_non_deviation_text"=>$postData['26a_obligee_child_sport_non_deviation_text'],  
                              "26a_parentb_child_sport_non_deviation_text"=>$postData['26a_obligor_child_sport_non_deviation_text'], 
                              "parentb_26a"=>$postData['obligor_26a'], 
                              "parenta_26a"=>$postData['obligee_26a'], 
                              "parenta_26b"=>$postData['obligee_26b'], 
                              "parentb_26b"=>$postData['obligor_26b'], 
                              "parenta_26c"=>$postData['obligee_26c'], 
                              "parentb_26c"=>$postData['obligor_26c'], 
                              "parenta_27"=>$postData['obligee_27'],  
                              "parentb_27"=>$postData['obligor_27'],  
                              "parenta_28"=>$postData['obligee_28'], 
                              "parentb_28"=>$postData['obligor_28'],  
                              "28nso"=>$postData['28nso'],  
                              "parenta_29"=>$postData['obligee_29'],  
                              "parentb_29"=>$postData['obligor_29'],  
                              "parenta_30"=>$postData['obligee_30'],  
                              "parentb_30"=>$postData['obligor_30'],  
                              "parenta_31"=>$postData['obligee_31'],  
                              "parentb_31"=>$postData['obligor_31'],  
                              "parenta_32"=>$postData['obligee_32'],  
                              "parentb_32"=>$postData['obligor_32'],  
                              "nso_32"=>$postData['nso_32'],  
                              "parenta_33"=>$postData['obligee_33'],  
                              "parentb_33"=>$postData['obligor_33'], 
                              "parenta_34"=>$postData['obligee_34'], 
                              "parentb_34"=>$postData['obligor_34'],  
                              "parenta_35"=>$postData['obligee_35'],  
                              "parentb_35"=>$postData['obligor_35'],  
                              "parenta_36"=>$postData['obligee_36'],  
                              "parentb_36"=>$postData['obligor_36'],
                              "form_state"=>$postData['sheet_state'],
                              "form_custody"=>$postData['sheet_custody'],
                              "counsel_dropdown"=>$postData['counsel_dropdown'],
                              "OhSPCSTrig"=>'1',
                              "updated_at"=>now(),
                        );
                  // echo "<pre>";print_r($array2);die;
                  if(isset($request->case_id)){
                              // die('yes');
                        $sheet_data=DB::table('split_submissions')->where([['user_id', Auth::user()->id],['case_id', $request->case_id]])->latest('id')->first();
                        if(isset($sheet_data)){
                              DB::table('split_submissions')->where('id',$sheet_data->id)->update($array2);
                        } else {
                              // die('no');
                              DB::table('split_submissions')->insert($array2);
                        }
                  } else {
                        $sheet_data=DB::table('split_submissions')->where([['user_id', Auth::user()->id],['form_state', $request->sheet_state],['form_custody', $request->sheet_custody]])->whereNull('case_id')->latest('id')->first();
                        if(isset($sheet_data)){
                              DB::table('split_submissions')->where('id',$sheet_data->id)->update($array2);
                        } else {
                              // die('no');
                              DB::table('split_submissions')->insert($array2);
                        }
                  }
                  if(isset($request->case_id)){
                  $prefill_data = DB::table('users_attorney_submissions')
                                    ->where([
                                      ['user_id', '=', Auth::user()->id],
                                      ['form_state', '=', $request->sheet_state],
                                      ['form_custody', '=', $request->sheet_custody],
                                      ['case_id', '=', $request->case_id]
                                    ])
                                     ->orderBy('id', 'desc')
                                     ->limit(1)
                                    ->get()->pluck('form_text');
                  } else {
                        $prefill_data = DB::table('users_attorney_submissions')
                                    ->where([
                                      ['user_id', '=', Auth::user()->id],
                                      ['form_state', '=', $request->sheet_state],
                                      ['form_custody', '=', $request->sheet_custody]
                                    ])->whereNull('case_id')
                                     ->orderBy('id', 'desc')
                                     ->limit(1)
                                    ->get()->pluck('form_text');
                  }
                  $postData=unserialize($prefill_data[0]);
                  $ohMinimumWageData=DB::select(DB::raw("select getOHMinimumWage2018(0) AS tmpResult"));
                  $OH_Minimum_Wage = $ohMinimumWageData[0]->tmpResult;
                  $postData['OH_Minimum_Wage']=$OH_Minimum_Wage;
                  $admin_email=Setting::where('setting_key', 'admin_email')->pluck('setting_value')->first();
                  if(!$admin_email){
                    $admin_email=env('APP_EMAIL');
                  }

                  if(isset($request->download_form) && $request->download_form=='Download')
                  {
                        exec('sh /home/ubuntu/.BFLODocs/MacrosScripts/QuickOhCSS_pdf.sh', $output, $return);
                        // Return will return non-zero upon an error
                        if (!$return)
                        {
                              sleep(5);
                              $response= "PDF Created Successfully";
                              // echo json_encode($response);
                              if(isset($request->case_id)){
                                $data=DB::table('split_submissions')
                                ->join('states', 'split_submissions.form_state', '=', 'states.id')
                                ->where('split_submissions.user_id', Auth::user()->id)
                                ->where('split_submissions.form_custody', $request->sheet_custody)
                                ->where('split_submissions.case_id', $request->case_id)
                                ->select('split_submissions.id','split_submissions.form_custody', 'split_submissions.updated_at', 'split_submissions.created_at','states.state')
                                ->latest('split_submissions.id')
                                ->first();
                              } else {
                                  $data=DB::table('split_submissions')
                                  ->join('states', 'split_submissions.form_state', '=', 'states.id')
                                  ->where('split_submissions.user_id', Auth::user()->id)
                                  ->where('split_submissions.form_custody', $request->sheet_custody)
                                  ->whereNull('split_submissions.case_id')
                                  ->select('split_submissions.id','split_submissions.form_custody', 'split_submissions.updated_at', 'split_submissions.created_at','states.state')
                                  ->latest('split_submissions.id')
                                  ->first();
                              }

                              $created_at=$data->created_at;
                              $updated_at=$data->updated_at;
                              $datetime=date("m-d-Y_His", strtotime($created_at));
                              $client_lname='NA';
                              if(isset($request->obligee_name) && $request->obligee_name !=''){
                                  $client_fullname=$request->obligee_name;
                                  $client_fullname = explode(" ", $client_fullname);
                                  $client_lname =end($client_fullname);
                                  // if(isset($client_fullname[0])){
                                  //   $client_lname=$client_fullname[0];
                                  // }
                                  // if(isset($client_fullname[1])){
                                  //   $client_lname=$client_fullname[1];
                                  // }
                                  // if(isset($client_fullname[2])){
                                  //   $client_lname=$client_fullname[2];
                                  // }
                              }
                              // dd($data);
                              $path=( public_path() . '/uiodirs/'.Auth::user()->id.'/download/'.$client_lname.'_'.$data->state.'_CS_'.$data->form_custody.'_'.$datetime.'.pdf');
                              $headers = array(
                                    'Content-Type'=> 'application/pdf'
                                  );
                              $filename=$client_lname.'_'.$data->state.'_CS_'.$data->form_custody.'_'.$datetime.'.pdf';
                              if(file_exists($path)){
                                  $download_array=array(
                                    'attorney_id' => Auth::user()->id,
                                    'obligee_name' => $request->obligee_name,
                                    'obligor_name' => $request->obligor_name,
                                    'type' => $request->sheet_custody,
                                    'file_name' => $filename,
                                    'created_at' => $updated_at,
                                    'updated_at' => $updated_at
                                  );
                                  $download=Download::create($download_array);
                                  return redirect()->route('attorney.downloads');
                                    // $response=response()->download($path, $filename, $headers);
                                    // ob_end_clean();
                                    // return $response;

                              }else{
                                  echo $errmsg="Sorry, File that you are trying to download is not available yet. Please <a href='mailto:".$admin_email."'>check this</a> with admin for more details"; die;
                              }
                        }
                        else
                        {
                              // $response= "PDF not created";
                              echo $errmsg="Sorry, File that you are trying to download is not available yet. Please <a href='mailto:".$admin_email."'>check</a> with admin for more details"; die;
                        }

                  }
                  return view('computations.computed.split',['sheet_custody' =>$request->sheet_custody, 'sheet_state' =>$request->sheet_state, 'chk_prefill'=>$request->chk_prefill, 'postData'=>$postData, 'case_data'=>$case_data, 'attorney_data'=>$attorney_data ])->with('success', 'Computation sheet saved successfully.');            
            }      

            if(isset($request->submit) && $request->submit=='Calculate')
            {
                  $postData = $request;
                  $ohMinimumWageData=DB::select(DB::raw("select getOHMinimumWage2018(0) AS tmpResult"));
                  $OH_Minimum_Wage = $ohMinimumWageData[0]->tmpResult;
                  $postData['OH_Minimum_Wage']=$OH_Minimum_Wage;
                  /******************* calculations for 02d ****************************/
                  $type='obligee';
                  $sum=0;
                  $arr=['a','b','c'];

                  /* SUM ALL 3 FIELDS */
                  for($i = 0;$i < 3;$i++)
                  {
                        $fieldName = $type."_2".$arr[$i];
                        $postData[$fieldName] = ($postData[$fieldName] != '') ? $postData[$fieldName] : 0;
                        $sum += $postData[$fieldName];
                  }

                  /* GOT AVERAGE OF ALL 3 FIELDS */
                  $rsum = ($sum/3);
                  $fieldName = $type."_2d";

                  $postData[$fieldName] = min($rsum,$postData[$type.'_2c']);

                  $type='obligor';
                  $sum=0;
                  $arr=['a','b','c'];

                  /* SUM ALL 3 FIELDS */
                  for($i = 0;$i < 3;$i++)
                  {
                        $fieldName = $type."_2".$arr[$i];
                        $postData[$fieldName] = ($postData[$fieldName] != '') ? $postData[$fieldName] : 0;
                        $sum += $postData[$fieldName];
                  }

                  /* GOT AVERAGE OF ALL 3 FIELDS */
                  $rsum = ($sum/3);
                  $fieldName = $type."_2d";

                  $postData[$fieldName] = min($rsum,$postData[$type.'_2c']);

                  /******************* calculations for 03d ****************************/
                  $type='obligee';
                  $postData[$type.'_3a'] = ($postData[$type.'_3a'] != '') ? $postData[$type.'_3a'] : 0;
                  $postData[$type.'_3b'] = ($postData[$type.'_3b'] != '') ? $postData[$type.'_3b'] : 0;

                  if ((isset($postData[$type.'_3_c_radio'])) && ($postData[$type.'_3_c_radio'] == 'manual'))
                  {
                              $postData[$type.'_3c'] = ($postData[$type.'_3_c_override_input'] != '') ? round(($postData[$type.'_3_c_override_input']),2) : 0;

                  } else {

                        $postData[$type.'_3c'] = round((max((0.062 * ($postData[$type.'_3a'] - $postData[$type.'_3b'])), 0)), 2);
                  }

                  $postData[$type.'_3d'] = round(((($postData[$type.'_3a']-$postData[$type.'_3b'])-$postData[$type.'_3c'])), 2);

                  $type='obligor';
                  $postData[$type.'_3a'] = ($postData[$type.'_3a'] != '') ? $postData[$type.'_3a'] : 0;
                  $postData[$type.'_3b'] = ($postData[$type.'_3b'] != '') ? $postData[$type.'_3b'] : 0;

                  if ((isset($postData[$type.'_3_c_radio'])) && ($postData[$type.'_3_c_radio'] == 'manual'))
                  {
                              $postData[$type.'_3c'] = ($postData[$type.'_3_c_override_input'] != '') ? round(($postData[$type.'_3_c_override_input']),2) : 0;

                  } else {

                        $postData[$type.'_3c'] = round((max((0.062 * ($postData[$type.'_3a'] - $postData[$type.'_3b'])), 0)), 2);
                  }

                  $postData[$type.'_3d'] = round(((($postData[$type.'_3a']-$postData[$type.'_3b'])-$postData[$type.'_3c'])), 2);


                  /******************* calculations for 08 ****************************/
                  $type='obligee';
                  $postData[$type."_4"]=($postData[$type."_4"]!='')?$postData[$type."_4"]:0;
                  $postData[$type."_5"]=($postData[$type."_5"]!='')?$postData[$type."_5"]:0;
                  $postData[$type."_6"]=($postData[$type."_6"]!='')?$postData[$type."_6"]:0;
                  $postData[$type."_7"]=($postData[$type."_7"]!='')?$postData[$type."_7"]:0;
                  $postData[$type."_8"]=($postData[$type."_8"]!='')?$postData[$type."_8"]:0;

                  $field_7=round(($postData[$type."_1"]+$postData[$type."_2d"]+$postData[$type."_3d"]+$postData[$type."_4"]+$postData[$type."_5"]+$postData[$type."_6"]),2);

                  if($field_7<0)
                  {
                        $field_7=0.00;
                  }

                  $postData[$type."_7"] = $field_7;
                  $postData[$type."_8"] = round(($field_7*.05),2);

                  $type='obligor';
                  $postData[$type."_4"]=($postData[$type."_4"]!='')?$postData[$type."_4"]:0;
                  $postData[$type."_5"]=($postData[$type."_5"]!='')?$postData[$type."_5"]:0;
                  $postData[$type."_6"]=($postData[$type."_6"]!='')?$postData[$type."_6"]:0;
                  $postData[$type."_7"]=($postData[$type."_7"]!='')?$postData[$type."_7"]:0;
                  $postData[$type."_8"]=($postData[$type."_8"]!='')?$postData[$type."_8"]:0;

                  $field_7=round(($postData[$type."_1"]+$postData[$type."_2d"]+$postData[$type."_3d"]+$postData[$type."_4"]+$postData[$type."_5"]+$postData[$type."_6"]),2);

                  if($field_7<0)
                  {
                        $field_7=0.00;
                  }

                  $postData[$type."_7"] = $field_7;
                  $postData[$type."_8"] = round(($field_7*.05),2);


                  /******************* calculations for 09c ****************************/
                  $type='obligee';
                  $postData[$type."_9a"] = ($postData[$type."_9a"] != '') ? $postData[$type."_9a"] : 0;
                  $postData[$type."_9b"] = ($postData[$type."_9b"] != '') ? $postData[$type."_9b"] : 0;
                  $postData[$type."_9c"] = ($postData[$type."_9c"] != '') ? $postData[$type."_9c"] : 0;

                  $postData[$type."_9d"] = 0;
                  $postData[$type."_9e"] = 0;
                  $postData[$type."_9f"] = 0;

                  $postData[$type."_9c"] = $postData[$type."_9a"]-$postData[$type."_9b"];

                  $result=DB::select(DB::raw("SELECT getOhioChildSupport2018(".$postData[$type.'_7'].",".$postData[$type.'_9a'].") AS calculation"));


                  if ($postData[$type.'_9a'] == 0)
                  {
                      $postData[$type."_9d"] = 0;

                  } else {

                      $postData[$type."_9d"] = $result[0]->calculation;
                  }

                  if($postData[$type."_9a"]>0)
                      $postData[$type."_9e"]=round(($postData[$type."_9d"]/$postData[$type."_9a"]),2);

                  if($postData[$type."_9c"]>0)
                      $postData[$type."_9f"]=round(($postData[$type."_9e"]*$postData[$type."_9c"]),2);

                  $type='obligor';
                  $postData[$type."_9a"] = ($postData[$type."_9a"] != '') ? $postData[$type."_9a"] : 0;
                  $postData[$type."_9b"] = ($postData[$type."_9b"] != '') ? $postData[$type."_9b"] : 0;
                  $postData[$type."_9c"] = ($postData[$type."_9c"] != '') ? $postData[$type."_9c"] : 0;

                  $postData[$type."_9d"] = 0;
                  $postData[$type."_9e"] = 0;
                  $postData[$type."_9f"] = 0;

                  $postData[$type."_9c"] = $postData[$type."_9a"]-$postData[$type."_9b"];

                  $result=DB::select(DB::raw("SELECT getOhioChildSupport2018(".$postData[$type.'_7'].",".$postData[$type.'_9a'].") AS calculation"));


                  if ($postData[$type.'_9a'] == 0)
                  {
                      $postData[$type."_9d"] = 0;

                  } else {

                      $postData[$type."_9d"] = $result[0]->calculation;
                  }

                  if($postData[$type."_9a"]>0)
                      $postData[$type."_9e"]=round(($postData[$type."_9d"]/$postData[$type."_9a"]),2);

                  if($postData[$type."_9c"]>0)
                      $postData[$type."_9f"]=round(($postData[$type."_9e"]*$postData[$type."_9c"]),2);

                  /***************** calculation for 015 **************************/
                  $type='obligee';
                  $postData[$type."_10b"] = ($postData[$type."_10b"] != '') ? $postData[$type."_10b"] : 0;

                  if((isset($postData[$type."_10a"])) && ($postData[$type."_10a"] == ''))
                  {
                      $postData[$type."_10b"] = 0;
                  }

                  $postData[$type."_11"] = ($postData[$type."_11"] != '') ? $postData[$type."_11"] : 0;
                  $postData[$type."_12"] = $postData[$type."_9f"] + $postData[$type."_10b"] + $postData[$type."_11"];
                  $postData[$type."_13"] = $postData[$type."_7"] - $postData[$type."_12"];
                  $postData[$type."_13"] = ($postData[$type."_13"] > 0) ? $postData[$type."_13"] : 0;
                  $postData[$type."_14"] = $postData[$type."_13"];

                  if((isset($postData[$type."_10a"])) && ($postData[$type."_10a"] == ''))
                  {
                      $postData[$type."_10b"] = 0;
                  }

                  $noChildThisOrder = $postData['number_children_order'];
                  $nthChildThreshholdData=DB::select(DB::raw("SELECT getOH_CS_Shaded_Threshold2018(".$noChildThisOrder.") As tmpResult"));
                  $postData[$type.'_15'] = 0;

                  if (isset($nthChildThreshholdData[0]->tmpResult))
                  {
                      if ((isset($postData[$type.'_14'])) && ($postData[$type.'_14'] <= $nthChildThreshholdData[0]->tmpResult))
                      {
                          $postData[$type.'_15'] = 1;

                      }
                  }

                  $type='obligor';

                  $postData[$type."_10b"] = ($postData[$type."_10b"] != '') ? $postData[$type."_10b"] : 0;

                  if((isset($postData[$type."_10a"])) && ($postData[$type."_10a"] == ''))
                  {
                      $postData[$type."_10b"] = 0;
                  }

                  $postData[$type."_11"] = ($postData[$type."_11"] != '') ? $postData[$type."_11"] : 0;
                  $postData[$type."_12"] = $postData[$type."_9f"] + $postData[$type."_10b"] + $postData[$type."_11"];
                  $postData[$type."_13"] = $postData[$type."_7"] - $postData[$type."_12"];
                  $postData[$type."_13"] = ($postData[$type."_13"] > 0) ? $postData[$type."_13"] : 0;
                  $postData[$type."_14"] = $postData[$type."_13"];

                  if((isset($postData[$type."_10a"])) && ($postData[$type."_10a"] == ''))
                  {
                      $postData[$type."_10b"] = 0;
                  }

                  $noChildThisOrder = $postData['number_children_order'];
                  $nthChildThreshholdData=DB::select(DB::raw("SELECT getOH_CS_Shaded_Threshold2018(".$noChildThisOrder.") As tmpResult"));

                  $postData[$type.'_15'] = 0;

                  if (isset($nthChildThreshholdData[0]->tmpResult))
                  {
                      if ((isset($postData[$type.'_14'])) && ($postData[$type.'_14'] <= $nthChildThreshholdData[0]->tmpResult))
                      {
                          $postData[$type.'_15'] = 1;

                      }
                  }

                  /***************** calculation for 016 **************************/
                  $postData["obligee_16"] = $postData["obligee_14"] + $postData["obligor_14"];

                  /***************** calculation for 018split **************************/
                  $postData["obligee_17"]=0;

                  $postData["obligee_18a1"]=0;
                  $postData["obligor_18a1"]=0;
                  $postData["obligee_18a2"]=0;
                  $postData["obligor_18a2"]=0;

                  $postData["obligee_18b"]=0;
                  $postData["obligee_18c"]=0;
                  $postData["obligor_18c"]=0;
                  $postData["obligee_18d"]=0;
                  $postData["obligor_18d"]=0;

                  $postData["obligee_19a"]=((isset($postData['obligee_19a'])) && ($postData["obligee_19a"]!=''))?$postData["obligee_19a"]:0;
                  $postData["obligor_19a"]=((isset($postData['obligor_19a'])) && ($postData["obligor_19a"]!=''))?$postData["obligor_19a"]:0;

                  $postData["obligee_19b"]=0;
                  $postData["obligor_19b"]=0;

                  $postData["obligee_20"]=((isset($postData['obligee_20'])) && ($postData["obligee_20"]!=''))?$postData["obligee_20"]:0;
                  $postData["obligor_20"]=((isset($postData['obligor_20'])) && ($postData["obligor_20"]!=''))?$postData["obligor_20"]:0;

                  if($postData["obligee_16"]>0)
                  {
                  $postData["obligee_17"]=round(($postData["obligee_14"]/$postData["obligee_16"])*100,2);
                  $postData["obligor_17"]=round(($postData["obligor_14"]/$postData["obligee_16"])*100,2);
                  }

                  $result=DB::select(DB::raw("SELECT getOhioChildSupport2018(".$postData['obligee_14'].",".$postData['parent_a_children'].") AS calculation"));

                  if(isset($result[0]->calculation))
                  {
                        $postData["18a1"]=max($result[0]->calculation,960);
                  }


                  $result=DB::select(DB::raw("SELECT getOhioChildSupport2018(".$postData['obligor_14'].",".$postData['parent_a_children'].") AS calculation"));

                  if(isset($result[0]->calculation))
                  {
                        $postData["18a2"]=max($result[0]->calculation,960);
                  }

                  $result=DB::select(DB::raw("SELECT getOhioChildSupport2018(".$postData['obligee_14'].",".$postData['parent_b_children'].") AS calculation"));

                  if(isset($result[0]->calculation))
                  {
                        $postData["18a3"]=max($result[0]->calculation,960);
                  }


                  
                  $result=DB::select(DB::raw("SELECT getOhioChildSupport2018(".$postData['obligor_14'].",".$postData['parent_b_children'].") AS calculation"));

                  if(isset($result[0]->calculation))
                  {
                        $postData["18a4"]=max($result[0]->calculation,960);
                  }


                  
                  $result=DB::select(DB::raw("SELECT getOhioChildSupport2018(".$postData['obligee_16'].",".$postData['parent_a_children'].") AS calculation"));

                  if(isset($result[0]->calculation))
                  {
                        $postData["obligee_18b"] = max($result[0]->calculation,960);
                  }

                  $result=DB::select(DB::raw("SELECT getOhioChildSupport2018(".$postData['obligee_16'].",".$postData['parent_b_children'].") AS calculation"));

                  $postData["obligor_18b"] = (isset($postData['obligor_18b']) && $postData['obligor_18b'] != 0) ? $postData['obligor_18b'] : 0;
                  if(isset($result[0]->calculation))
                  {
                        $postData["obligor_18b"] = max($result[0]->calculation,960);
                  }

                  $postData["18c1"]=round(($postData["obligee_18b"]*($postData["obligee_17"]/100)),2);
                  $postData["18c2"]=round(($postData["obligee_18b"]*($postData["obligor_17"]/100)),2);
                  $postData["18c3"]=round(($postData["obligor_18b"]*($postData["obligee_17"]/100)),2);
                  $postData["18c4"]=round(($postData["obligor_18b"]*($postData["obligor_17"]/100)),2);

                  $low18=min($postData["18a1"],$postData["18c1"]);
                  $low18=max($low18,960);
                  $postData["18d1"]=$low18;

                  $low18=min($postData["18a2"],$postData["18c2"]);
                  $low18=max($low18,960);
                  $postData["18d2"]=$low18;

                  $low18=min($postData["18a3"],$postData["18c3"]);
                  $low18=max($low18,960);
                  $postData["18d3"]=$low18;

                  $low18=min($postData["18a4"],$postData["18c4"]);
                  $low18=max($low18,960);
                  $postData["18d4"]=$low18;

                  // formulas to calculate "obligee_19b" and "obligor_19b" are swapped
                  if(isset($postData["obligee_19a"]) && $postData["obligee_19a"]>0)
                  {
                        // $postData["obligee_19b"]=($postData["18d3"]*0.10);
                        $postData["obligee_19b"]=($postData["18d2"]*0.10);
                  } else {
                        $postData["obligee_19b"]=0;
                  }

                  if(isset($postData["obligor_19a"]) && $postData["obligor_19a"]>0)
                  {
                        $postData["obligor_19b"]=($postData["18d3"]*0.10);
                        // $postData["obligor_19b"]=($postData["18d2"]*0.10);
                  } else {
                        $postData["obligor_19b"]=0;
                  }

                  /***************** calculation for O21csplit **************************/
                  
                  $postData["20a2"]=($postData["20a2"]!='')?$postData["20a2"]:0;
                  $postData["20a3"]=($postData["20a3"]!='')?$postData["20a3"]:0;

                  /**
                   * Create a Function to calculate the sum
                   */
                  $type='obligee';
                  $lineNo=21;
                  $lineSubrow='d';
                  $name = $type.'_'.$lineNo.''.$lineSubrow;
                  $a = 0;

                  for ($i=1; $i <= 6; $i++)
                  {
                      if($postData['obligee_21b'.$i] !=''){
                        $postData[$name.''.$i] = ($postData[$name.''.$i] != '') ? $postData[$name.''.$i] : 0;
                      } else {
                        $postData[$name.''.$i]=0;
                      }
                      $a += $postData[$name.''.$i];
                  }
                  $postData['21a1'] = $a ?? 0;

                  $type='obligor';
                  $lineNo=21;
                  $lineSubrow='d';
                  $name = $type.'_'.$lineNo.''.$lineSubrow;
                  $a = 0;

                  for ($i=1; $i <= 6; $i++)
                  {
                      if($postData['obligee_21b'.$i] !=''){
                        $postData[$name.''.$i] = ($postData[$name.''.$i] != '') ? $postData[$name.''.$i] : 0;
                      } else {
                        $postData[$name.''.$i]=0;
                      }
                        $a += $postData[$name.''.$i];
                  }
                  $postData['21a2'] = $a ?? 0;

                  $type='obligee';
                  $lineNo=21;
                  $lineSubrow='h';
                  $name = $type.'_'.$lineNo.''.$lineSubrow;
                  $a = 0;

                  for ($i=1; $i <= 6; $i++)
                  {
                      if($postData['obligor_21b'.$i] !=''){
                        $postData[$name.''.$i] = ($postData[$name.''.$i] != '') ? $postData[$name.''.$i] : 0;
                      } else {
                        $postData[$name.''.$i]= 0;
                      }
                      $a += $postData[$name.''.$i];
                  }
                  $postData['21a3'] = $a ?? 0;

                  $type='obligor';
                  $lineNo=21;
                  $lineSubrow='h';
                  $name = $type.'_'.$lineNo.''.$lineSubrow;
                  $a = 0;

                  for ($i=1; $i <= 6; $i++)
                  {
                        if($postData['obligor_21b'.$i] !=''){
                          $postData[$name.''.$i] = ($postData[$name.''.$i] != '') ? $postData[$name.''.$i] : 0;
                        } else {
                          $postData[$name.''.$i]= 0;
                        }
                        $a += $postData[$name.''.$i];
                  }
                  $postData['21a4'] = $a ?? 0;

                  $postData["21a1"] = ($postData["21a1"]!='')?$postData["21a1"]:0;
                  $postData["21a2"] = ($postData["21a2"]!='')?$postData["21a2"]:0;
                  $postData["21a3"] = ($postData["21a3"]!='')?$postData["21a3"]:0;
                  $postData["21a4"] = ($postData["21a4"]!='')?$postData["21a4"]:0;

                  $postData["21l1"] = ($postData["21l1"]!='')?$postData["21l1"]:0;
                  $postData["21l2"] = ($postData["21l2"]!='')?$postData["21l2"]:0;
                  $postData["21l3"] = ($postData["21l3"]!='')?$postData["21l3"]:0;
                  $postData["21l4"] = ($postData["21l4"]!='')?$postData["21l4"]:0;

                  $postData["21o1"]=($postData["21o1"]!='')?$postData["21o1"]:0;
                  $postData["21o2"]=($postData["21o2"]!='')?$postData["21o2"]:0;
                  $postData["21o3"]=($postData["21o3"]!='')?$postData["21o3"]:0;
                  $postData["21o4"]=($postData["21o4"]!='')?$postData["21o4"]:0;

                  $postData["21m2"]=0;
                  $postData["21n4"]=0;

                  $postData["obligee_21f"]=0;
                  $postData["obligor_21f"]=0;

                  $postData["obligee_21g"]=((isset($postData['obligee_21g'])) && ($postData["obligee_21g"]!=''))?$postData["obligee_21g"]:0;
                  $postData["obligor_21g"]=((isset($postData['obligor_21g'])) && ($postData["obligor_21g"]!=''))?$postData["obligor_21g"]:0;

                  $postData["obligee_21h"]=0;
                  $postData["obligor_21h"]=0;

                  $postData["obligee_21i"]=0;
                  $postData["obligor_21i"]=0;

                  $postData["obligee_21j"]=0;
                  $postData["obligor_21j"]=0;

                  $e_total=0;
                  $obligor21JTotal = 0;

                  for($i=1;$i<=6;$i++)
                  {
                        $mac=0;
                        if($postData["obligee_21b".$i]!='')
                        {
                              $res = explode("/", $postData["obligee_21b".$i]);

                              if(count($res)>2)
                              {
                                    $newDob = $res[2]."-".$res[0]."-".$res[1];

                                    // get month difference
                                    $start=date("Y-m-d");
                                    $end=$newDob;
                                    $end OR $end = time();
                                    $start = new DateTime("$start");
                                    $end   = new DateTime("$end");
                                    $diff  = $start->diff($end);
                                    $months_diff=$diff->format('%y') * 12 + $diff->format('%m');

                                    if($months_diff<18) {
                                          $mac=11464;
                                    } elseif($months_diff>=18 && $months_diff<36) {
                                          $mac=10025;
                                    } elseif($months_diff>=36 && $months_diff<72) {
                                          $mac=8600;
                                    } elseif($months_diff>=72 && $months_diff<144) {
                                          $mac=7290;
                                    } else {
                                          $mac=0;
                                    }
                              }

                              if($months_diff<36)
                              {
                                $postData["obligee_21b".$i.'a']=$months_diff." Months";
                              } else {
                                 $start=date("Y-m-d");
                                 $end=$newDob;
                                 $end OR $end = time();
                                 $start = new DateTime("$start");
                                 $end   = new DateTime("$end");
                                 $diff  = $start->diff($end);
                                 $postData["obligee_21b".$i.'a']= $diff->format('%y')." Years";
                              }
                        } else {
                              $postData["obligee_21b".$i.'a']='';
                        }

                        $postData["obligee_21c".$i] = $mac;
                        $postData["obligee_21d".$i] = ($postData["obligee_21d".$i] != '') ? $postData["obligee_21d".$i] : 0;

                        $sumOf21dObligeeObligor = $postData['obligee_21d'.$i] + $postData['obligor_21d'.$i];
                        $sumOf21dObligeeObligor = ($sumOf21dObligeeObligor == '') ? 1 : $sumOf21dObligeeObligor;

                        $postData['obligee_21e'.$i] = min($postData['obligee_21c'.$i], $sumOf21dObligeeObligor);
                        
                        $postData["obligee_21e".$i] = ($postData["obligee_21e".$i] != '')?$postData["obligee_21e".$i]:0;
                        
                        // $apporSumObligee = ($postData['obligor_21e'.$i]/$sumOf21dObligeeObligor);

                        $apporSumObligee = ($postData['obligee_21e'.$i]/$sumOf21dObligeeObligor);
                        $postData['21_apportioned_obligee_A'.$i] = ($apporSumObligee * $postData['obligee_21d'.$i]);
                        $postData['21_apportioned_obligee_B'.$i] = ($apporSumObligee * $postData['obligor_21d'.$i]);          

                        $e_total = $e_total + $postData['21_apportioned_obligee_A'.$i];
                        $obligor21JTotal = $obligor21JTotal + $postData['21_apportioned_obligee_B'.$i];
                  }

                  $postData["obligee_21j"] = $e_total;
                  $postData["obligor_21j"] = $obligor21JTotal;

                  $e_total = 0;
                  $obligor21KTotal = 0;

                  for($i=1;$i<=6;$i++)
                  {
                  $mac=0;
                  if($postData["obligor_21b".$i]!='')
                  {

                    $res = explode("/", $postData["obligor_21b".$i]);

                    if(count($res)>2)
                    {
                      $newDob = $res[2]."-".$res[0]."-".$res[1];

                      // get month difference
                        $start=date("Y-m-d");
                        $end=$newDob;
                        $end OR $end = time();
                        $start = new DateTime("$start");
                        $end   = new DateTime("$end");
                        $diff  = $start->diff($end);
                        $months_diff=$diff->format('%y') * 12 + $diff->format('%m');

                      if($months_diff<18)
                      {
                        $mac=11464;
                      }
                      elseif($months_diff>=18 && $months_diff<36)
                      {
                        $mac=10025;
                      }
                      elseif($months_diff>=36 && $months_diff<72)
                      {
                        $mac=8600;
                      }
                      elseif($months_diff>=72 && $months_diff<144)
                      {
                        $mac=7290;
                      }
                      else
                      {
                        $mac=0;
                      }
                    }

                    if($months_diff<36)
                    {
                        $postData["obligor_21b".$i.'a']=$months_diff." Months";
                    } else {
                        $start=date("Y-m-d");
                        $end=$newDob;
                        $end OR $end = time();
                        $start = new DateTime("$start");
                        $end   = new DateTime("$end");
                        $diff  = $start->diff($end);
                        $postData["obligor_21b".$i.'a']= $diff->format('%y')." Years";
                    }

                  } else {
                              $postData["obligor_21b".$i.'a']='';
                  }

                        $postData["obligor_21c".$i] = $mac;

                        $postData["obligor_21d".$i] = ($postData["obligor_21d".$i] != '') ? $postData["obligor_21d".$i] : 0;

                        $sumOf21hObligeeObligor = $postData['obligee_21h'.$i] + $postData['obligor_21h'.$i];                  
                        $sumOf21hObligeeObligor = ($sumOf21hObligeeObligor == '') ? 1 : $sumOf21hObligeeObligor;

                        $postData['obligor_21e'.$i] = min($postData['obligor_21c'.$i], $sumOf21hObligeeObligor);
                        $postData["obligor_21e".$i]=($postData["obligor_21e".$i]!='')?$postData["obligor_21e".$i]:0;

                        $apporSumObligor = ($postData['obligor_21e'.$i]/$sumOf21hObligeeObligor);
                        $postData['21_apportioned_obligor_A'.$i] = ($apporSumObligor * $postData['obligee_21h'.$i]);
                        $postData['21_apportioned_obligor_B'.$i] = ($apporSumObligor * $postData['obligor_21h'.$i]);

                        // $e_total = $e_total+$postData["obligor_21e".$i];

                        $e_total = $e_total + $postData['21_apportioned_obligor_A'.$i];
                        $obligor21KTotal = $obligor21KTotal + $postData['21_apportioned_obligor_B'.$i];
                  }

                  $postData["obligee_21k"] = $e_total;
                  $postData["obligor_21k"] = $obligor21KTotal;

                  // if($postData["obligee_21j"]>0)
                  // {
                  //   $postData["21m2"] = $postData["obligee_21j"]-($postData["21l1"]-$postData["21l2"]);
                  // }

                  // if($postData["obligor_21k"]>0)
                  // {
                  //  $postData["21n4"] = $postData["obligor_21k"]-($postData["21l3"]-$postData["21l4"]);
                  // }

                  /*************************************************/

                  /**
                  * Remove Above Comments when Split sheets
                  * approved
                  */

                  // // (L21jC1+L21kC3)-(L21lC1+L21lC3)
                  // $postData['21m2'] = ($postData['obligee_21j'] + $postData['obligee_21k']) - ($postData['21l1'] + $postData['21l3']);

                  // // (L21jC2+L21kC4)-(L21lC2+L21lC4)
                  // $postData['21n4'] = ($postData['obligor_21j'] + $postData['obligor_21k']) - ($postData['21l2'] + $postData['21l4']);

                  $postData['21m2'] = ($postData['obligee_21j'] + $postData['obligor_21j']) - ($postData['21l1'] + $postData['21l2']);

                  // following fromulas are changed on 27-12-2019 23:11:00
                  // (L21jC2+L21kC4)-(L21lC2+L21lC4)
                  $postData['21n4'] = ($postData['obligor_21j'] + $postData['obligor_21k']) - ($postData['21l2'] + $postData['21l4']);
                  // (21k.c3+21k.c4)-(21l.c3+21l.c4)
                  $postData['21n4'] = ($postData['obligee_21k'] + $postData['obligor_21k']) - ($postData['21l3'] + $postData['21l4']);

                  if($postData['obligee_15'] == 1)
                  {
                        // echo $a=min($postData["obligee_17"], 0.5);
                        // echo $postData["obligor_17"];die;
                        $postData["21o1"] = (min($postData["obligee_17"]/100, 0.5) * $postData["21m2"]);
                        $postData["21o2"] = (min($postData["obligor_17"]/100,0.5) * $postData["21m2"]);

                  } else {

                        $postData["21o1"] = ($postData["obligee_17"]/100 * $postData["21m2"]);
                        $postData["21o2"] = ($postData["obligor_17"]/100 * $postData["21m2"]);
                  }

                  if($postData['obligor_15'] == 1)
                  {
                        $postData["21o3"] = (min($postData["obligee_17"]/100, 0.5) * $postData["21n4"]);
                        $postData["21o4"] = (min($postData["obligor_17"]/100, 0.5) * $postData["21n4"]);

                  } else {

                        $postData["21o3"] = $postData["obligee_17"]/100 * $postData["21n4"];
                        $postData["21o4"] = $postData["obligor_17"]/100 * $postData["21n4"];
                  }

                  /*************************************************/

                  $postData["21p1"] = max(($postData["21o1"]-$postData["21a1"]),0);
                  $postData["21p2"] = max(($postData["21o2"]-$postData["21a2"]),0);
                  $postData["21p3"] = max(($postData["21o3"]-$postData["21a3"]),0);
                  $postData["21p4"] = max(($postData["21o4"]-$postData["21a4"]),0);

                  $postData["obligee_22"] = ($postData["18d2"]-$postData["obligee_19b"]-$postData["20a2"])+$postData["21p2"];
                  $postData["obligor_22"] = ($postData["18d3"]-$postData["obligor_19b"]-$postData["20a3"])+$postData["21p3"];

                  $postData["obligee_22"] = max($postData["obligee_22"],0);
                  $postData["obligor_22"] = max($postData["obligor_22"],0);




                  /***************** calculation for O21ksplit **************************/
                  $result21kaObligeeArray=DB::select(DB::raw("SELECT getFedChildCareCreditPercentage2018(".$postData['obligee_14'].") AS calculation"));

                  $result21kaObligee = $result21kaObligeeArray[0]->calculation;

                  $result21kaObligorArray=DB::select(DB::raw("SELECT getFedChildCareCreditPercentage2018(".$postData['obligor_14'].") AS calculation"));

                  $result21kaObligor = $result21kaObligorArray[0]->calculation;

                  $postData['obligee_21ka1'] = $result21kaObligee;
                  $postData['obligee_21ka2'] = $result21kaObligor;

                  $postData['obligor_21ka1'] = $result21kaObligee;
                  $postData['obligor_21ka2'] = $result21kaObligor;

                  /*************************************************/

                  $countOf21e = 0;
                  $countOf21i = 0;

                  for ($i=0; $i <= 6; $i++) 
                  { 
                  if ($postData['obligee_21e'.$i] > 0)
                  {
                        $countOf21e = $countOf21e + 1;
                  }

                  if ($postData['obligor_21e'.$i] > 0)
                  {
                        $countOf21i = $countOf21i + 1;
                  }           
                  }

                  $parentACreditCapArray=DB::select(DB::raw("SELECT getFedChildCareCap2018(".$countOf21e.") AS calculation"));
                  $parentACreditCap = $parentACreditCapArray[0]->calculation;

                  $parentBCreditCapArray=DB::select(DB::raw("SELECT getFedChildCareCap2018(".$countOf21i.") AS calculation"));
                  $parentBCreditCap = $parentBCreditCapArray[0]->calculation;

                  $postData['obligee_21kb1'] = $postData['obligee_21ka1'] * min(($postData['obligee_1'] + max($postData['obligee_3d'], 0)), $postData['obligee_21j'], $parentACreditCap);

                  $postData['obligee_21kb2'] = $postData['obligee_21ka2'] * min(($postData['obligor_1'] + max($postData['obligor_3d'], 0)), $postData['obligor_21j'], $parentACreditCap);

                  $postData['obligor_21kb1'] = $postData['obligor_21ka1'] * min(($postData['obligee_1'] + max($postData['obligee_3d'], 0)), $postData['obligee_21k'], $parentBCreditCap);

                  $postData['obligor_21kb2'] = $postData['obligor_21ka2'] * min(($postData['obligor_1'] + max($postData['obligor_3d'], 0)), $postData['obligor_21k'], $parentBCreditCap);

                  /*************************************************/

                  $result21kcObligeeArray=DB::select(DB::raw("SELECT getOhChildCareCreditPercentage2018(".$postData['obligee_14'].") AS calculation"));

                  $result21kcObligee = $result21kcObligeeArray[0]->calculation;

                  $result21kcObligorArray=DB::select(DB::raw("SELECT getOhChildCareCreditPercentage2018(".$postData['obligor_14'].") AS calculation"));

                  $result21kcObligor = $result21kcObligorArray[0]->calculation;

                  $postData['obligee_21kc1'] = $result21kcObligee;
                  $postData['obligee_21kc2'] = $result21kcObligor;

                  $postData['obligor_21kc1'] = $result21kcObligee;
                  $postData['obligor_21kc2'] = $result21kcObligor;

                  /*************************************************/

                  // following fromulas are changed on 27-12-2019 22:14:00
                  // $postData['obligee_21kd1'] = $postData['obligee_21kc1'] * $postData['obligee_21j'];
                  // $postData['obligee_21kd2'] = $postData['obligee_21kc2'] * $postData['obligor_21j'];

                  // $postData['obligor_21kd1'] = $postData['obligor_21kc1'] * $postData['obligee_21k'];
                  // $postData['obligor_21kd2'] = $postData['obligor_21kc2'] * $postData['obligor_21k'];

                  $postData['obligee_21kd1'] = $postData['obligee_21kc1'] * $postData['obligee_21kb1'];
                  $postData['obligee_21kd2'] = $postData['obligee_21kc2'] * $postData['obligee_21kb2'];

                  $postData['obligor_21kd1'] = $postData['obligor_21kc1'] * $postData['obligor_21kb1'];
                  $postData['obligor_21kd2'] = $postData['obligor_21kc2'] * $postData['obligor_21kb2'];




                  /***************** calculation for O21lsplit **************************/
                  if ((isset($postData['21l_obligee_ParentA'])) && ($postData['21l_obligee_ParentA'] == 'calculation'))
                  {
                        $postData['21l1'] = $postData['obligee_21kb1'] + $postData['obligee_21kd1'];

                  } else {

                        $postData['21l1'] = ($postData['21l_obligee_ParentA_Over_input'] != '') ? $postData['21l_obligee_ParentA_Over_input'] : 0;
                  }

                  if ((isset($postData['21l_obligee_ParentB'])) && ($postData['21l_obligee_ParentB'] == 'calculation'))
                  {
                        $postData['21l2'] = $postData['obligee_21kb2'] + $postData['obligee_21kd2'];

                  } else {

                        $postData['21l2'] = ($postData['21l_obligee_ParentB_Over_input'] != '') ? $postData['21l_obligee_ParentB_Over_input'] : 0;
                  }

                  if ((isset($postData['21l_obligor_ParentA'])) && ($postData['21l_obligor_ParentA'] == 'calculation'))
                  {
                        $postData['21l3'] = $postData['obligor_21kb1'] + $postData['obligor_21kd1'];

                  } else {

                        $postData['21l3'] = ($postData['21l_obligor_ParentA_Over_input'] != '') ? $postData['21l_obligor_ParentA_Over_input'] : 0;
                  }

                  if ((isset($postData['21l_obligor_ParentB'])) && ($postData['21l_obligor_ParentB'] == 'calculation'))
                  {
                        $postData['21l4'] = $postData['obligor_21kb2'] + $postData['obligor_21kd2'];

                  } else {

                        $postData['21l4'] = ($postData['21l_obligor_ParentB_Over_input'] != '') ? $postData['21l_obligor_ParentB_Over_input'] : 0;
                  }

                  /**********************************************/

                  // following fromulas are changed on 27-12-2019 23:11:00
                  // (L21jC1+L21kC3)-(L21lC1+L21lC3)

                  // $postData['21m2'] = ($postData['obligee_21j'] + $postData['obligee_21k']) - ($postData['21l1'] + $postData['21l3']);

                  // (21j.c1+21j.c2)-(21l.c1+21l.c2). 

                  $postData['21m2'] = ($postData['obligee_21j'] + $postData['obligor_21j']) - ($postData['21l1'] + $postData['21l2']);

                  // following fromulas are changed on 27-12-2019 23:11:00
                  // (L21jC2+L21kC4)-(L21lC2+L21lC4)
                  $postData['21n4'] = ($postData['obligor_21j'] + $postData['obligor_21k']) - ($postData['21l2'] + $postData['21l4']);
                  // (21k.c3+21k.c4)-(21l.c3+21l.c4)
                  $postData['21n4'] = ($postData['obligee_21k'] + $postData['obligor_21k']) - ($postData['21l3'] + $postData['21l4']);


                  /***************** calculation for O24split **************************/
                  $combinedGrossIncome = $postData['obligee_1'] + $postData['obligor_1'];
                  $combinedGrossIncome = ($combinedGrossIncome == '') ? 0 : $combinedGrossIncome;

                  $ohCashMedicalData=DB::select(DB::raw("SELECT getOHCashMedical2018(".$combinedGrossIncome.",".$postData['number_children_order'].") As tmpResult"));

                  $postData["obligee_24"] = 0;
                  $postData["obligor_24"] = 0;

                  $postData["obligee_25"] = 0;
                  $postData["obligor_25"] = 0;

                  $postData["obligee_26a"] = ($postData["obligee_26a"] != '')?$postData["obligee_26a"]:0;
                  $postData["obligor_26a"] = ($postData["obligor_26a"] != '')?$postData["obligor_26a"]:0;
                  $postData["obligee_26b"] = ($postData["obligee_26b"] != '')?$postData["obligee_26b"]:0;
                  $postData["obligor_26b"] = ($postData["obligor_26b"] != '')?$postData["obligor_26b"]:0;

                  $postData["obligee_26c"] = 0;
                  $postData["obligor_26c"] = 0;

                  $postData["obligee_27"] = 0;
                  $postData["obligor_27"] = 0;

                  $postData["obligee_28"] = ($postData["obligee_28"] != '')?$postData["obligee_28"]:0;
                  $postData["obligor_28"] = ($postData["obligor_28"] != '')?$postData["obligor_28"]:0;

                  $postData["obligee_29"] = 0;
                  $postData["obligor_29"] = 0;

                  $postData["obligee_30"]=($postData["obligee_30"] != '')?$postData["obligee_30"]:0;
                  $postData["obligor_30"]=($postData["obligor_30"] != '')?$postData["obligor_30"]:0;

                  /******************************************************************************/

                  $obligee23aOhCash=DB::select(DB::raw("SELECT getOHCashMedical2018(".$postData['obligee_14'].",".$postData['parent_a_children'].") As tmpResult"));

                  $obligor23aOhCash=DB::select(DB::raw("SELECT getOHCashMedical2018(".$postData['obligor_14'].",".$postData['parent_b_children'].") As tmpResult"));

                  $postData['obligee_23a'] = $obligee23aOhCash[0]->tmpResult;
                  // $postData['obligee_23a'] = 388.70;
                  $postData['obligor_23a'] = $obligor23aOhCash[0]->tmpResult;
                  // $postData['obligor_23a'] = 388.70;

                  /******************************************************************************/

                  $postData['obligee_23b'] = ($postData['obligee_23a']*($postData['obligor_17']/100));
                  $postData['obligor_23b'] = ($postData['obligor_23a']*($postData['obligee_17']/100));


                  $postData['obligee_24'] = round($postData['obligor_22'], 2);
                  $postData['obligor_24'] = round($postData['obligee_22'], 2);

                  $postData['24nso'] = round(abs($postData['obligor_24']-$postData['obligee_24']), 2);


                  if($postData['obligee_24'] > $postData['obligor_24'])
                  {
                  $postData['obligee_25'] = $postData['24nso']/12;
                  }

                  if($postData['obligor_24'] > $postData['obligee_24'])
                  {
                  $postData['obligor_25'] = $postData['24nso']/12;
                  }

                  $postData['obligee_26c'] = ($postData['obligee_26a'] + $postData['obligee_26b']);
                  $postData['obligor_26c'] = ($postData['obligor_26a'] + $postData['obligor_26b']);

                  $postData['obligee_27'] = ($postData['obligee_25'] + $postData['obligee_26c']);
                  $postData['obligor_27'] = ($postData['obligor_25'] + $postData['obligor_26c']);

                  if($postData['obligor_23b'] > 0)
                  {
                  $postData['obligee_28'] = round($postData['obligor_23b'], 2);
                  }

                  if($postData['obligee_23b'] > 0)
                  {
                  $postData['obligor_28'] = round($postData['obligee_23b'], 2);
                  }

                  $postData['28nso'] = abs($postData['obligor_28'] - $postData['obligee_28']);

                  if ($postData['obligee_28'] > $postData['obligor_28'])
                  {
                  $postData['obligee_29'] = round(($postData['28nso']/12), 2);
                  }

                  if ($postData['obligor_28'] > $postData['obligee_28'])
                  {
                  $postData['obligor_29'] = round(($postData['28nso']/12), 2);
                  }

                  $postData['obligee_31'] = ($postData['obligee_29'] + $postData['obligee_30']);
                  $postData['obligor_31'] = ($postData['obligor_29'] + $postData['obligor_30']);

                  $postData['obligee_32'] = ($postData['obligee_27'] + $postData['obligee_31']);
                  $postData['obligor_32'] = ($postData['obligor_27'] + $postData['obligor_31']);

                  $postData['nso_32'] = abs($postData['obligor_32'] - $postData['obligee_32']);






                  /***************** calculation for O26split **************************/
                  $type='obligee';
                  if ((isset($postData['26a_'.$type.'_child_sport'])) && ($postData['26a_'.$type.'_child_sport'] == 'deviation'))
                  {
                        $postData[$type.'_26a'] = $postData['26a_'.$type.'_child_sport_deviation_text'];

                  } else {

                        $postData[$type.'_26a'] = $postData[$type.'_25'] - $postData['26a_'.$type.'_child_sport_non_deviation_text'];
                  }

                  $postData[$type.'_26a'] = ($postData[$type.'_26a'] != '') ? $postData[$type.'_26a'] : 0;

                  $type='obligor';
                  if ((isset($postData['26a_'.$type.'_child_sport'])) && ($postData['26a_'.$type.'_child_sport'] == 'deviation'))
                  {
                        $postData[$type.'_26a'] = $postData['26a_'.$type.'_child_sport_deviation_text'];

                  } else {

                        $postData[$type.'_26a'] = $postData[$type.'_25'] - $postData['26a_'.$type.'_child_sport_non_deviation_text'];
                  }

                  $postData[$type.'_26a'] = ($postData[$type.'_26a'] != '') ? $postData[$type.'_26a'] : 0;



                  /***************** calculation for O31split **************************/
                  $type='obligee';
                  $typeOpposite = ($type == 'obligee') ? 'obligor' : 'obligee';

                  $postData[$type.'_33'] = 0;
                  if ($postData[$type.'_32'] > $postData[$typeOpposite.'_32'])
                  {
                        // $postData[$type.'_33'] = round(($postData['nso_32']/12), 2);
                        $postData[$type.'_33'] = round(($postData['nso_32']), 2);
                  }

                  $postData[$type.'_34'] = (isset($postData[$type.'_33']) && ($postData[$type.'_33'] == 0)) ? 0 : $postData[$type.'_33'];
                  $postData[$type.'_35'] = (isset($postData[$type.'_33']) && ($postData[$type.'_33'] == 0)) ? 0 : ($postData[$type.'_33'] * 0.02);

                  $sumFor36 = $postData[$type.'_34'] + $postData[$type.'_35'];
                  $postData[$type.'_36'] = (isset($postData[$type.'_33']) && ($postData[$type.'_33'] == 0)) ? 0 : $sumFor36;

                  $type='obligor';
                  $typeOpposite = ($type == 'obligee') ? 'obligor' : 'obligee';

                  $postData[$type.'_33'] = 0;
                  if ($postData[$type.'_32'] > $postData[$typeOpposite.'_32'])
                  {
                        // $postData[$type.'_33'] = round(($postData['nso_32']/12), 2);
                        $postData[$type.'_33'] = round(($postData['nso_32']), 2);
                  }

                  $postData[$type.'_34'] = (isset($postData[$type.'_33']) && ($postData[$type.'_33'] == 0)) ? 0 : $postData[$type.'_33'];
                  $postData[$type.'_35'] = (isset($postData[$type.'_33']) && ($postData[$type.'_33'] == 0)) ? 0 : ($postData[$type.'_33'] * 0.02);

                  $sumFor36 = $postData[$type.'_34'] + $postData[$type.'_35'];
                  $postData[$type.'_36'] = (isset($postData[$type.'_33']) && ($postData[$type.'_33'] == 0)) ? 0 : $sumFor36;

                  // if ($postData['obligee_32'] == $postData['obligor_32'])
                  // {
                  //       // $postData[$type.'_33'] = round(($postData['nso_32']/12), 2);
                  //       $postData['obligee_33'] = 0;
                  //       $postData['obligor_33'] = 0;
                  // }

                  if(isset($postData['obligee_21ka1'])){
                        $postData['obligee_21ka1']=$postData['obligee_21ka1']*100;
                  };
                  if(isset($postData['obligee_21ka2'])){
                        $postData['obligee_21ka2']=$postData['obligee_21ka2']*100;
                  };
                  if(isset($postData['obligor_21ka1'])){
                        $postData['obligor_21ka1']=$postData['obligor_21ka1']*100;
                  };
                  if(isset($postData['obligor_21ka2'])){
                        $postData['obligor_21ka2']=$postData['obligor_21ka2']*100;
                  };
                  if(isset($postData['obligee_21kc1'])){
                        $postData['obligee_21kc1']=$postData['obligee_21kc1']*100;
                  };
                  if(isset($postData['obligee_21kc2'])){
                        $postData['obligee_21kc2']=$postData['obligee_21kc2']*100;
                  };
                  if(isset($postData['obligor_21kc1'])){
                        $postData['obligor_21kc1']=$postData['obligor_21kc1']*100;
                  };
                  if(isset($postData['obligor_21kc2'])){
                        $postData['obligor_21kc2']=$postData['obligor_21kc2']*100;
                  };

                  // echo "<pre>"; print_r($postData->all());die;

                  // to get children names
                  $childreninfo=DrChildren::where('case_id',$request->case_id)->get()->first();
                  if(isset($childreninfo)){
                        // to get 18th and 21st Point Info of Sheet.
                        $client_name=$postData['obligee_name'];
                        $opponent_name=$postData['obligor_name'];

                        $caseuser=DB::table('caseusers')
                            ->join('users', 'caseusers.user_id', '=', 'users.id')
                            ->where([['caseusers.case_id', $request->case_id],['caseusers.party_group', 'top']])
                            ->select('users.name', 'caseusers.party_entity', 'caseusers.mname', 'caseusers.org_comp_name')
                            ->first();
                        if(isset($caseuser->name)){
                            $client_full_name=$caseuser->name;
                            if(isset($caseuser->party_entity) && $caseuser->party_entity=='organization_company') {
                                $client_full_name=$caseuser->org_comp_name;
                            } else {
                                $mname=$caseuser->mname;
                                if(isset($mname) && $mname !='') {
                                    $namearray = explode(' ', $caseuser->name, 2);
                                    if(count($namearray) > 1) {
                                        $client_full_name=$namearray[0].' '.$mname.' '.$namearray[1];
                                    } else {
                                        $client_full_name=$caseuser->name.' '.$mname;
                                    }
                                }
                            }
                        }else {
                            $client_full_name=$client_name;
                        }
                        $caseuser=DB::table('caseusers')
                            ->join('users', 'caseusers.user_id', '=', 'users.id')
                            ->where([['caseusers.case_id', $request->case_id],['caseusers.party_group', 'bottom']])
                            ->select('users.name', 'caseusers.party_entity', 'caseusers.mname', 'caseusers.org_comp_name')
                            ->first();
                        if(isset($caseuser->name)){
                            $opponent_full_name=$caseuser->name;
                            if(isset($caseuser->party_entity) && $caseuser->party_entity=='organization_company') {
                                $opponent_full_name=$caseuser->org_comp_name;
                            } else {
                                $mname=$caseuser->mname;
                                if(isset($mname) && $mname !='') {
                                    $namearray = explode(' ', $caseuser->name, 2);
                                    if(count($namearray) > 1) {
                                        $opponent_full_name=$namearray[0].' '.$mname.' '.$namearray[1];
                                    } else {
                                        $opponent_full_name=$caseuser->name.' '.$mname;
                                    }
                                }
                            }
                        }else {
                            $opponent_full_name=$opponent_name;
                        }

                        $case_data=array(
                            'case_id' => $request->case_id,
                            'client_name' => $client_name,
                            'opponent_name' => $opponent_name,
                            'client_full_name' => $client_full_name,
                            'opponent_full_name' => $opponent_full_name
                        );

                        $client_name_array = explode(" ", $client_name);
                        $opponent_name_array = explode(" ", $opponent_name);
                        $with_parent_A=0;
                        $with_parent_B=0;
                        $i_A=1;
                        $i_B=1;
                        $children_length=array('First','Second','Third','Fourth','Fifth','Sixth','Seventh','Eigth');
                        $children_name=array(
                          'Child_1'=>['name'=>'Child 1','parent_name'=>''],
                          'Child_2'=>['name'=>'Child 2','parent_name'=>''],
                          'Child_3'=>['name'=>'Child 3','parent_name'=>''],
                          'Child_4'=>['name'=>'Child 4','parent_name'=>''],
                          'Child_5'=>['name'=>'Child 5','parent_name'=>''],
                          'Child_6'=>['name'=>'Child 6','parent_name'=>''],
                          'Child_7'=>['name'=>'Child 7','parent_name'=>''],
                          'Child_8'=>['name'=>'Child 8','parent_name'=>'']
                        );
                        for ($i=0; $i < $childreninfo->Num_Children_ONLY_This_Marriage; $i++) {
                            $b=$i+1;
                            $obj_key='This_Marriage_'.$children_length[$i].'_Child_DOB';
                            $postData['obligee_21b'.$i_A.'']=NULL;
                            $postData['obligor_21b'.$i_B.'']=NULL;

                            $obj_key1='This_Marriage_'.$children_length[$i].'_Child_WILL_Resides_With';
                            $will_reside_with=$childreninfo->{$obj_key1};

                            $obj_key2='This_Marriage_'.$children_length[$i].'_Child_FirstName';

                            $obj_key3='This_Marriage_'.$children_length[$i].'_Child_Disabled_Dependent_Y_N';
                            $is_disabled_dependent=$childreninfo->{$obj_key3};

                            $child_age=Carbon::parse($childreninfo->{$obj_key})->age;

                            if((isset($is_disabled_dependent) && $is_disabled_dependent=='Yes') || (isset($child_age) && $child_age < '18')){

                              if(isset($will_reside_with) && isset($client_name_array[0]) && strpos($will_reside_with, $client_name_array[0]) !== false){
                                  if(isset($will_reside_with) && isset($client_name_array[1])){
                                      if(strpos($will_reside_with, $client_name_array[1]) !== false){
                                          $with_parent_A=$with_parent_A+1;
                                          $postData['obligee_21b'.$i_A.'']=date("m/d/Y", strtotime($childreninfo->{$obj_key}));
                                          $postData['obligee_21b'.$i_A.'_child_name']=$childreninfo->{$obj_key2};
                                          $children_name['Child_'.$b.'']['name']=$childreninfo->{$obj_key2};
                                          $children_name['Child_'.$b.'']['parent_name']=$client_full_name;
                                          $i_A=$i_A+1;
                                      } else {
                                          $with_parent_A=$with_parent_A;
                                          $postData['obligee_21b'.$i_A.'']=NULL;
                                          $postData['obligee_21b'.$i_A.'_child_name']=NULL;
                                          $i_A=$i_A;
                                      }
                                  } else {
                                      $with_parent_A=$with_parent_A+1;
                                      $postData['obligee_21b'.$i_A.'']=date("m/d/Y", strtotime($childreninfo->{$obj_key}));
                                      $postData['obligee_21b'.$i_A.'_child_name']=$childreninfo->{$obj_key2};
                                      $children_name['Child_'.$b.'']['name']=$childreninfo->{$obj_key2};
                                      $children_name['Child_'.$b.'']['parent_name']=$client_full_name;
                                      $i_A=$i_A+1;
                                  }
                              }
                              $opponent_name_array = explode(" ", $opponent_name);
                              if(isset($will_reside_with) && isset($opponent_name_array[0]) && strpos($will_reside_with, $opponent_name_array[0]) !== false){
                                  if(isset($will_reside_with) && isset($opponent_name_array[1])){
                                      if(strpos($will_reside_with, $opponent_name_array[1]) !== false){
                                          $with_parent_B=$with_parent_B+1;
                                          $postData['obligor_21b'.$i_B.'']=date("m/d/Y", strtotime($childreninfo->{$obj_key}));
                                          $postData['obligor_21b'.$i_B.'_child_name']=$childreninfo->{$obj_key2};
                                          $children_name['Child_'.$b.'']['name']=$childreninfo->{$obj_key2};
                                          $children_name['Child_'.$b.'']['parent_name']=$opponent_full_name;
                                          $i_B=$i_B+1;
                                      } else {
                                          $with_parent_B=$with_parent_B;
                                          $postData['obligor_21b'.$i_B.'']=NULL;
                                          $postData['obligor_21b'.$i_B.'_child_name']=NULL;
                                          $i_B=$i_B;
                                      }
                                  } else {
                                      $with_parent_B=$with_parent_B+1;
                                      $postData['obligor_21b'.$i_B.'']=date("m/d/Y", strtotime($childreninfo->{$obj_key}));
                                      $postData['obligor_21b'.$i_B.'_child_name']=$childreninfo->{$obj_key2};
                                      $children_name['Child_'.$b.'']['name']=$childreninfo->{$obj_key2};
                                      $children_name['Child_'.$b.'']['parent_name']=$opponent_full_name;
                                      $i_B=$i_B+1;
                                  }
                              }
                            }
                        }
                        
                        $postData['parent_a_children']=$with_parent_A;
                        $postData['parent_b_children']=$with_parent_B;
                    }
                  // dd($postData);

                  return view('computations.computed.split',['sheet_custody' =>$request->sheet_custody, 'sheet_state' =>$request->sheet_state, 'chk_prefill'=>$request->chk_prefill, 'case_data'=>$case_data, 'postData'=>$postData, 'attorney_data'=>$attorney_data, 'children_name'=>$children_name ])->with('bottom_scroll', '');
            }
            if($request->chk_prefill=='1'){
                  if(isset($request->case_id)){
                        $prefill_data = DB::table('users_attorney_submissions')
                                          ->where([
                                            ['user_id', '=', Auth::user()->id],
                                            ['form_state', '=', $request->sheet_state],
                                            ['form_custody', '=', $request->sheet_custody],
                                            ['case_id', '=', $request->case_id]
                                          ])
                                           ->orderBy('id', 'desc')
                                           ->limit(1)
                                          ->get()->pluck('form_text');
                  } else {
                        $prefill_data = DB::table('users_attorney_submissions')
                                          ->where([
                                            ['user_id', '=', Auth::user()->id],
                                            ['form_state', '=', $request->sheet_state],
                                            ['form_custody', '=', $request->sheet_custody]
                                          ])->whereNull('case_id')
                                           ->orderBy('id', 'desc')
                                           ->limit(1)
                                          ->get()->pluck('form_text');
                  }                                    
                  if(isset($prefill_data[0])){
                        $postData=unserialize($prefill_data[0]);
                        $ohMinimumWageData=DB::select(DB::raw("select getOHMinimumWage2018(0) AS tmpResult"));
                        $OH_Minimum_Wage = $ohMinimumWageData[0]->tmpResult;
                        $postData['OH_Minimum_Wage']=$OH_Minimum_Wage;
                        return view('computations.computed.split',['sheet_custody' =>$request->sheet_custody, 'sheet_state' =>$request->sheet_state, 'chk_prefill'=>$request->chk_prefill, 'case_data'=>$case_data, 'postData'=>$postData, 'attorney_data'=>$attorney_data ]);
                  } else {
                        $ohMinimumWageData=DB::select(DB::raw("select getOHMinimumWage2018(0) AS tmpResult"));
                        $OH_Minimum_Wage = $ohMinimumWageData[0]->tmpResult;
                        return view('computations.computed.split',['sheet_custody' =>$request->sheet_custody, 'sheet_state' =>$request->sheet_state, 'chk_prefill'=>$request->chk_prefill, 'case_data'=>$case_data, 'attorney_data'=>$attorney_data, 'OH_Minimum_Wage'=>$OH_Minimum_Wage]);
                  }
                  
            }

      }

}