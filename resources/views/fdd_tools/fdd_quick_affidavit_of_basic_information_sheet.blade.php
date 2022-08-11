@extends('layouts.app')

@section('content')
<div class="container">
<style type="text/css">
               /*
               Print Table Record
               */
               /* Global CSS */
               body {
               margin: 0;
               padding: 0;
               line-height: 1.4;
               font-family: inherit;
               color: #333;
               }
               *,
               *:after,
               *:before {
               box-sizing: border-box;
               }
               .textcenter {
               text-align: center !important;
               }
               .textright {
               text-align: right !important;
               }
               h1 {
               margin: 0;
               padding: 0;
               line-height: normal;
               }
               .input_field_wrapper input:focus,
               .input_field_wrapper input:active,
               .input_field_wrapper input:hover {
               outline: none;
               }
               input[type="number"]::-webkit-inner-spin-butt on,
               input[type="number"]::-webkit-outer-spin-button {
               -webkit-appearance: none;
               margin: 0;
               }
               input:read-only {
               color: #000 !important;
               }
               table.childtable input {
               width: 40px !important;
               font-size: 13px !important;
               }
               table.childtable input:read-only {
               width: 60px !important;
               font-size: 13px !important;
               }
               .sfont {
               font-size: 13px !important;
               }
               .divider {
              display: table;
              width: 100%;
               }
               .currency_start,
               .percentage_end {
               padding-right: 15px;
               position: relative;
               }
               .currency_start{
               padding-right: 0;
               padding-left: 15px;
               width: auto;
               float: right;
               }
               .currency_start input.currency.ws-number {
                   width: 110px!important;
                   min-width: 90px!important;
                   padding-left: 5px;
                   text-align: right;
                   padding-right: 20px !important;
               }
               .currency_start:before,
               .percentage_end:after {
               content: "%";
               position: absolute;
               right: 0;
               top: 1px;
               color: #000000;
               }
               .currency_start:before{
               content: '$';
               right: auto;
               left: 0;
               }
               .input_field_checkbox__currency{
               display: inline-flex;
               }
               .input_field_checkbox__currency .currency_start{
               margin-left: 15px;
               }
               .input_field_checkbox__currency .input_field_wrapper{
               margin-left: 5px;
               }
               input::placeholder {
               /* Chrome, Firefox, Opera, Safari 10.1+ */
               color: #008000;
               opacity: 1; /* Firefox */
               }
               input:-ms-input-placeholder {
               /* Internet Explorer 10-11 */
               color: #008000;
               }
               input::-ms-input-placeholder {
               /* Microsoft Edge */
               color: #008000;
               }
               input:read-only::placeholder {
               /* Chrome, Firefox, Opera, Safari 10.1+ */
               color: #000000;
               opacity: 1; /* Firefox */
               }
               input:read-only:-ms-input-placeholder {
               /* Internet Explorer 10-11 */
               color: #000000;
               }
               input:read-only::-ms-input-placeholder {
               /* Microsoft Edge */
               color: #000000;
               }
               /* Print Form CSS */
               .Tableworksheet_Outer {
               width: 100%;
               margin: 0;
               }
               .tbl_full_width,
               .Tableworksheet {
               border-collapse: collapse;
               width: 100%;
               border-spacing: 0;
               }
               .Cell_heading {
               width: 80%;
               }
               .Cell_obligee,
               .Cell_obligor {
               width: 10%;
               }
               .Tableworksheet tr th,
               .Tableworksheet tr td {
               padding: 5px;
               text-align: left;
               font-size: 16px;
               line-height: inherit;
               color: #000;
               }
               .Tableworksheet .table_header {
               padding: 0;
               }
               .input_field_wrapper input[type="text"],
               .input_field_wrapper input[type="number"] {
               font-size: 16px;
               padding: 0;
               box-sizing: border-box;
               width: 100%;
               color: #008000;
               border: none;
               }
               .input_field_wrapper_highlight {
               border: 1px solid #333;
               padding: 0 5px;
               }
               .input_field_wrapper input[type="text"]:focus {
               outline: none;
               }
               .input_field_wrapper input[type="text"]:focus {
               outline: none;
               }
               .recordInner_heading {
               font-size: 24px;
               font-weight: normal;
               color: #000;
               text-transform: uppercase;
               font-family: inherit;
               }
               .Cell_obligee b,
               .Cell_obligor b,
               .Cell_obligee strong,
               .Cell_obligor strong {
               font-size: 24px;
               text-transform: uppercase;
               }
               .highligt_row {
               background-color: #dcdede;
               }
               .serial_count {
               width: 50px;
               }
               .input_field_wrapper_checkbox * {
               display: inline-block;
               vertical-align: middle;
               }
               .input_field_wrapper_checkbox input[type="checkbox"] {
               transform: scale(1.1);
               border: 1px solid #fff;
               }
               .inner_table_wrapper {
               border-top: none;
               border-bottom: none;
               }
               .inner_table td {
               border-color: #333;
               }
               .inner_table {
               border: 1px solid transparent;
               }
               .inner_table_wrapper {
               padding: 0 !important;
               }
               .header_inner_table,
               .header_inner_table thead {
               border: none;
               }
               .header_inner_table td,
               .header_inner_table th {
               border: 1px solid #333;
               }
               .header_inner_table th {
               border-top: none;
               }
               .table_header .header_inner_table:last-child tbody td {
               border-bottom: none;
               }
               .header_inner_table th:first-child,
               .header_inner_table tbody td:first-child {
               border-left: none;
               }
               .header_inner_table th:last-child,
               .header_inner_table tbody td:last-child {
               border-right: none;
               }
               .Tableworksheet tfoot tr td {
               font-size: 13px;
               }
               input[type="text"],
               select {
               }
               table select {
               border: none;
               background: none;
               box-shadow: none !important;
               font-size: 14px;
               }
               select.textcenter {
               text-align-last: center;
               }
               /********************************/
               .anuual-income tr td {
               border: 1px solid #000;
               font-size: 14px;
               border-right: none;
               border-top: none;
               }
               .pd-0 {
               padding: 0 !important;
               }
               .bt-n tr td {
               border-top: none;
               }
               .border-left {
               border-left: 1px solid #000 !important;
               }
               .border-right {
               border-right: 1px solid #000 !important;
               }
               .Table-col-2 tr td {
               border-bottom: 1px solid #000;
               }
               .Table-col-2 tr td:nth-child(odd) {
               border-right: 1px solid #000;
               }
               .border-bottom-custom {
               border-bottom: 1px solid #000;
               }
               .border-bottom-none {
               border-bottom: none !important;
               }
               .table-3c tr td {
               border: 1px solid #000;
               font-size: 16px;
               border-right: none;
               border-top: none;
               }
               .border-left-none {
               border-left: none !important;
               }
               .border-right-none {
               border-right: none !important;
               }
               .tbl-input-full tr td input {
               width: 100% !important;
               font-size: 13px !important;
               }
               .root-last-tr td,
               .last-tr td {
               border-bottom: none !important;
               }
               .anual-child-care input[type="text"] {
               text-align: center !important;
               }
               .anual-child-care tr td {
               text-align: center;
               }
               .eligible-federal td {
               border-bottom: #333 solid thin;
               border-right: #333 solid thin;
               }
               .eligible-federal tr td:last-child {
               border-right: none;
               }
               .cash-medical td.serial_count {
               width: auto;
               }
               h3.page-title {
               color: #333;
               font-weight: 600;
               margin-bottom: 30px;
               }
               .preparedby tr td h3,
               .preparedby tr td select {
               color: #333;
               font-size: 18px;
               line-height: 2;
               font-weight: 600;
               }
               tfoot,
               .print-header {
               display: none;
               }
               .dummy-text {
               opacity: 0;
               display: none;
               }
               .printingW {
               width: 269px;
               }
               .printingW1 {
               width: 274px;
               }
               .countryW {
               width: 274px;
               }
               .setsW {
               width: 292px;
               }
               .administrativeW {
               width: 269px;
               }
               select#county_name {
               font-size: 16px;
               text-align-last: center;
               }
               .anual-child-care tr.L21d-tr input[type="text"] {
               width: 60px !important;
               font-size: 13px !important;
               }
               body {
               min-width: 1170px;
               width: 100%;
               }
               body .container {
               max-width: 100%;
               width: 1140px;
               }
               body .container .container {
               width: 100%;
               padding: 0;
               }
               @media (max-width: 800px) {
               .table_outer {
               width: 1080px;
               }
               .Tableworksheet_Outer {
               overflow: auto;
               }
               .table_outer tr td {
               padding: 2px;
               }
               .recordInner_heading,
               .Cell_obligee b,
               .Cell_obligor b,
               .Cell_obligee strong,
               .Cell_obligor strong {
               font-weight: bold;
               }
               .input_field_wrapper input[type="text"],
               .input_field_wrapper input[type="number"],
               table.childtable input:read-only,
               .recordInner_heading,
               .Cell_obligee b,
               .Cell_obligor b,
               .Cell_obligee strong,
               .Cell_obligor strong,
               .table_outer tr td,
               .Tableworksheet tr th,
               .Tableworksheet tr td {
               font-size: 12px !important;
               }
               .input_field_wrapper input[type="text"],
               .input_field_wrapper input[type="number"] {
               text-align: center !important;
               }
               }
               @media print {
               @page {
               margin: 15px;
               }
               .container {
               min-width: unset !important;
               float: left;
               margin: 0 !important;
               width: 100% !important;
               max-width: 100% !important;
               padding: 0 !important;
               }
               .row {
               margin: 0 !important;
               }
               [class*="col-"] {
               padding: 0 !important;
               }
               .serial_count {
               width: auto;
               }
               #page-wrapper {
               padding: 0;
               }
               h1 {
               line-height: 1.2;
               font-size: 20px;
               }
               h3.page-title {
               margin-bottom: 10px;
               }
               .Tableworksheet tr th {
               font-weight: normal;
               font-size: 14px;
               }
               .page-break {
               page-break-before: always !important;
               page-break-after: always;
               page-break-inside: always;
               }
               .print-header {
               display: table-row;
               }
               tfoot {
               display: table-footer-group;
               }
               tfoot td {
               border: none !important;
               }
               tfoot td:last-child {
               text-align: right;
               }
               .anual-child-care tr > td:first-child {
               width: 130px;
               line-height: normal;
               }
               .anual-child-care tr td {
               padding: 2px 5px;
               }
               .root-last-tr td {
               border-bottom: #000 solid 1px !important;
               }
               .income-share {
               line-height: 1.2;
               }
               .desktop-tfoot {
               display: none;
               }
               .Cell_obligee b,
               .Cell_obligor b,
               .Cell_obligee strong,
               .Cell_obligor strong {
               font-size: 16px;
               }
               .input_field_wrapper input[type="text"],
               .input_field_wrapper input[type="number"],
               input::-webkit-input-placeholder,
               input::placeholder {
               color: #000;
               }
               input:focus {
               outline: none;
               }
               input,
               select {
               border: none;
               }
               select {
               -webkit-appearance: none;
               }
               .number-input-buttons,
               footer {
               display: none;
               }
               .well {
               padding: 15px;
               }
               .Tableworksheet td.Cell_obligee,
               .Tableworksheet td.Cell_obligor {
               text-align: center;
               }
               .preparedby tr td h3 select {
               font-weight: 600;
               }
               .dummy-text {
               opacity: 0;
               display: block;
               }
               .dummy-text {
               margin-bottom: 10px !important;
               }
               .parentB-td {
               width: 150px !important;
               }
               .printingW {
               width: 275px;
               }
               .printingW1 {
               width: 277px;
               }
               .countryW {
               width: 277px;
               }
               .setsW {
               width: 295px;
               }
               .administrativeW {
               width: 275px;
               }
               tr.bg-grey {
               background: #dadada;
               }
               }
               @media print {
               .bg-grey th {
               font-weight: bold !important;
               }
               .hide-print-buttons {
               display: none;
               }
               }
               .input-buttons {
               float: right;
               }
               .custom-inline-elements .input_field_wrapper_checkbox {
               padding: 0 10px;
               }
               .custom-inline-elements {
               align-items: flex-start;
               flex-flow:wrap;
               }

               /* developer css */
               .custom-input-focus{
                    border: 1px solid #00FF00;
               }
            </style>
          <script src="https://code.jquery.com/jquery-migrate-3.0.0.min.js"></script>
          <script src="{{ asset('js/polyfiller.js') }}"></script>

           <script>

            webshims.setOptions('forms-ext', {
              replaceUI: 'auto',
              types: 'number'
          });
          webshims.polyfill('forms forms-ext');
            </script>

          <div class="row mx-0">
               <table width="100%" border="0">
                  <tbody>
                     <tr>
                        <td align="center" colspan="3">
                           <h3 class="page-title">
                              FDD QUICK AFFIDAVIT OF BASIC INFORMATION, INCOME, AND EXPENSES
                           </h3>
                        </td>
                     </tr>
                     <tr>
                        <td align="center" colspan="3"></td>
                     </tr>
                  </tbody>
               </table>
          </div>
            <?php 
               $currentYear = date("Y"); 
               //$result = $db->query("SELECT calcValueOhio2018(10000,4,1,2,1) AS calculation")->results();
               if(isset($postData['OH_Minimum_Wage'])){
                 $OH_Minimum_Wage=$postData['OH_Minimum_Wage'];
               }
            ?>
            <form method="post" action="{{route('show_affidavit_of_basic_information_sheet_form')}}" id="">
               @csrf
               <div class="Tableworksheet_Outer">
                  <table border="1" bordercolor="#333" class="Tableworksheet table_outer" style="border-bottom: none;">
                     <tbody>
                        <tr>
                           <td colspan="5" class="p-0">
                              <table width="100%" class="tbl_full_width header_inner_table">
                                 <tbody>
                                    <tr class="bg-grey">
                                       <th class="textcenter stateW">State</th>
                                       <th class="textcenter countryW">County</th>
                                       <th class="textcenter courtW">Court</th>
                                       <th class="textcenter divisionW">Division</th>
                                    </tr>
                                 </tbody>
                                 <tbody>
                                    <tr class="last-tr">
                                       <td>
                                          <div class="input_field_wrapper textcenter">
                                             <input type="text" name="update_id" value="<?php echo isset($postData['update_id'])? $postData['update_id']:''; ?>" style="display: none;">
                                             <input type="text" name="update_id_serialize" value="<?php echo isset($postData['update_id_serialize'])? $postData['update_id_serialize']:''; ?>" style="display: none;">
                                             <input type="text" name="state_id" value="{{$postData['state_id']}}" style="display: none;">
                                             <select class="test county-select" id="show_selected_state" name="show_selected_state" style="font-size: 16px;" disabled="">
                                                <option value="{{$postData['state_id']}}">{{$selected_state_info->state}}</option>
                                             </select>
                                          </div>
                                       </td>
                                       <td>
                                          <div class="input_field_wrapper textcenter">
                                             <input type="text" id="selected_affidavit_county" value="<?php echo isset($postData['county_id'])? $postData['county_id']:''; ?>" style="display: none;">
                                             <select id="affidavit_county" class="test county-select county_inputs" name="county_id" style="font-size: 16px;">
                                                <option value="">Choose County</option>
                                             </select>
                                          </div>
                                       </td>
                                       <td>
                                          <div class="input_field_wrapper textcenter">
                                             <input type="text" id="selected_affidavit_court" value="<?php echo isset($postData['court_id'])? $postData['court_id']:''; ?>" style="display: none;">
                                             <select id="affidavit_court" class="test county-select court_inputs" name="court_id" style="font-size: 16px;">
                                                <option value="">Choose Court</option>
                                             </select>
                                          </div>
                                       </td>
                                       <td>
                                          <div class="input_field_wrapper textcenter">
                                             <input type="text" id="selected_affidavit_division" value="<?php echo isset($postData['division_id'])? $postData['division_id']:''; ?>" style="display: none;">
                                             <select id="affidavit_division" class="test county-select division_inputs" name="division_id" style="font-size: 16px;">
                                                <option value="">Choose Division</option>
                                             </select>
                                          </div>
                                       </td>
                                    </tr>
                                 </tbody>
                              </table>
                           </td>
                        </tr>
                        <tr>
                           <td colspan="5" class="p-0">
                              <table width="100%" class="tbl_full_width header_inner_table">
                                 <tbody>
                                    <tr class="bg-grey">
                                       <th class="textcenter">Judge</th>
                                       <th class="textcenter">Magistrate</th>
                                       <th class="textcenter">Case number</th>
                                       <th class="textcenter">Top Party Role</th>
                                       <th class="textcenter">Top Party FullName*</th>
                                    </tr>
                                 </tbody>
                                 <tbody>
                                    <tr>
                                       <td class="textcenter border-0">
                                          <div class="input_field_wrapper textcenter">
                                             <input type="text" id="selected_affidavit_judge" value="<?php echo isset($postData['judge_id'])? $postData['judge_id']:''; ?>" style="display: none;">
                                             <select id="affidavit_judge" class="test county-select judge_inputs" name="judge_id" style="font-size: 16px;">
                                                <option value="">Judge</option>
                                             </select>
                                          </div>
                                       </td>
                                       <td class="border-bottom-0">
                                          <div class="input_field_wrapper textcenter">
                                             <input type="text" id="selected_affidavit_magistrate" value="<?php echo isset($postData['magistrate_id'])? $postData['magistrate_id']:''; ?>" style="display: none;">
                                             <select id="affidavit_magistrate" class="test magistrate_inputs" name="magistrate_id" style="font-size: 16px;">
                                                <option value="">Magistrate</option>
                                             </select>
                                          </div>
                                       </td>
                                       <td class="border-bottom-0">
                                          <div class="input_field_wrapper">
                                             <input class="textcenter" type="text" placeholder="Enter" name="case_number" value="<?php echo isset($postData['case_number'])? $postData['case_number']:''; ?>">
                                          </div>
                                       </td>
                                       <td class="p-0 border-bottom-0">
                                          <table width="100%" class="anuual-income">
                                             <tbody>
                                                <tr>
                                                   <td>
                                                      <div class="input_field_wrapper_checkbox textcenter">
                                                         <input type="radio" name="topparty_role" class="es_checkbox" value="Plaintiff" <?php echo ((isset($postData['topparty_role'])) && ($postData['topparty_role'] == 'Petitioner 1')) ? '' : 'checked'; ?>>
                                                      </div>
                                                   </td>
                                                   <td>
                                                      <div class="input_field_wrapper">
                                                         Plaintiff
                                                      </div>
                                                   </td>
                                                </tr>
                                                <tr class="last-tr">
                                                   <td>
                                                      <div class="input_field_wrapper_checkbox textcenter">
                                                         <input type="radio" name="topparty_role" class="es_checkbox" value="Petitioner 1" <?php echo ((isset($postData['topparty_role'])) && ($postData['topparty_role'] == 'Petitioner 1')) ? 'checked' : ''; ?>>
                                                      </div>
                                                   </td>
                                                   <td>
                                                      <div class="input_field_wrapper">
                                                         Petitioner 1
                                                      </div>
                                                   </td>
                                                </tr>
                                             </tbody>
                                          </table>
                                       </td>
                                       <td class="border-bottom-0">
                                          <div class="input_field_wrapper">
                                             <input id="topparty_name" name="topparty_name" class="textcenter" type="text" placeholder="Enter" value="<?php echo isset($postData['topparty_name'])? $postData['topparty_name']:''; ?>" required="">
                                          </div>
                                       </td>
                                    </tr>
                                 </tbody>
                              </table>
                           </td>
                        </tr>
                        <tr>
                           <td colspan="4" class="p-0">
                              <table width="100%" class="tbl_full_width header_inner_table">
                                 <tbody>
                                    <tr class="bg-grey">
                                       <th class="textcenter">Bottom Party Role</th>
                                       <th class="textcenter">Bottom Party FullName*</th>
                                       <th class="textcenter">Affidavit Party</th>
                                       <th class="textcenter">Date of marriage</th>
                                       <th class="textcenter">Date of separation</th>
                                    </tr>
                                 </tbody>
                                 <tbody>
                                    <tr>
                                       <td class="border-bottom-0">
                                          <div class="input_field_wrapper">
                                             <input class="textcenter" type="text" id="bottomparty_role" name="bottomparty_role" value="<?php echo isset($postData['bottomparty_role'])? $postData['bottomparty_role']:'Defendant'; ?>" readonly>
                                          </div>
                                       </td>
                                       <td class="textcenter border-0">
                                          <div class="input_field_wrapper">
                                             <input id="bottomparty_name" name="bottomparty_name" class="textcenter" type="text" placeholder="Enter" value="<?php echo isset($postData['bottomparty_name'])? $postData['bottomparty_name']:''; ?>" required="">
                                          </div>
                                       </td>
                                       <td class="p-0 border-bottom-0">
                                          <table width="100%" class="anuual-income">
                                             <tbody>
                                                <tr>
                                                   <td>
                                                      <div class="input_field_wrapper_checkbox textcenter">
                                                         <input type="radio" class="es_checkbox" name="aff_party" value="top" <?php echo ((isset($postData['aff_party'])) && ($postData['aff_party'] == 'bottom')) ? '' : 'checked'; ?>>
                                                      </div>
                                                   </td>
                                                   <td>
                                                      <div class="input_field_wrapper">
                                                         <span class="topparty_name_span">Top Party FullName</span>
                                                      </div>
                                                   </td>
                                                </tr>
                                                <tr class="last-tr">
                                                   <td>
                                                      <div class="input_field_wrapper_checkbox textcenter">
                                                         <input type="radio" class="es_checkbox" name="aff_party" value="bottom" <?php echo ((isset($postData['aff_party'])) && ($postData['aff_party'] == 'bottom')) ? 'checked' : ''; ?>>
                                                      </div>
                                                   </td>
                                                   <td>
                                                      <div class="input_field_wrapper">
                                                         <span class="bottomparty_name_span">Bottom Party FullName</span>
                                                      </div>
                                                   </td>
                                                </tr>
                                             </tbody>
                                          </table>
                                       </td>
                                       <td class="border-bottom-0">
                                          <div class="input_field_wrapper">
                                             <input class="textcenter hasDatepickerPast" name="marriage_date" id="marriage_date" type="text" placeholder="mm/dd/yyyy" value="<?php echo isset($postData['marriage_date'])? date("m/d/Y", strtotime($postData['marriage_date'])):''; ?>">
                                          </div>
                                       </td>
                                       <td class="border-bottom-0">
                                          <div class="input_field_wrapper">
                                             <input class="textcenter hasDatepickerPast" name="separation_date" id="separation_date" type="text" placeholder="mm/dd/yyyy" value="<?php echo isset($postData['separation_date'])? date("m/d/Y", strtotime($postData['separation_date'])):''; ?>">
                                          </div>
                                       </td>
                                    </tr>
                                 </tbody>
                              </table>
                           </td>
                        </tr>
                        <tr>
                           <td class="Cell_heading" colspan="5">
                              <h1 class="recordInner_heading mb-0">I. Basic Information</h1>
                           </td>
                        </tr>
                        <tr>
                           <td colspan="4" class="p-0 border-bottom-0">
                              <table width="100%" class="tbl_full_width header_inner_table">
                                 <thead>
                                    <tr>
                                       <th class="textcenter border-bottom-0"><span class="topparty_name_span">Top Party FullName</span>, <span class="topparty_role_span">Plaintiff</span></th>
                                       <th class="textcenter border-bottom-0"><span class="bottomparty_name_span">Bottom Party FullName</span>, <span class="bottomparty_role_span">Defendant</span></th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    <tr>
                                       <td class="border-bottom-0 p-0">
                                          <table width="100%" class="tbl_full_width header_inner_table anuual-income">
                                             <tbody>
                                                <tr>
                                                   <td>Top Party Date of Birth</td>
                                                   <td>
                                                      <div class="input_field_wrapper">
                                                         <input class="textcenter hasDatepickerPast" name="tp_birthdate" id="tp_birthdate" type="text" placeholder="mm/dd/yyyy" value="<?php echo isset($postData['tp_birthdate'])? date("m/d/Y", strtotime($postData['tp_birthdate'])):''; ?>">
                                                      </div>
                                                   </td>
                                                </tr>
                                                <tr>
                                                   <td>Top Party Social Security Number</td>
                                                   <td>
                                                      <div class="input_field_wrapper">
                                                         <input class="textcenter" type="text" name="tp_ssn" id="tp_ssn" placeholder="xxx-xx-xxxx" value="<?php echo isset($postData['tp_ssn'])? $postData['tp_ssn']:''; ?>">
                                                      </div>
                                                   </td>
                                                </tr>
                                                <tr>
                                                   <td>Top Party Phone Number</td>
                                                   <td>
                                                      <div class="input_field_wrapper">
                                                         <input class="textcenter" type="text" name="tp_phone" id="tp_phone" placeholder="(xxx) xxx-xxxx" value="<?php echo isset($postData['tp_phone'])? $postData['tp_phone']:''; ?>">
                                                      </div>
                                                   </td>
                                                </tr>
                                                <tr>
                                                   <td>Top Party Health</td>
                                                   <td class="p-0">
                                                      <table width="100%" class="anuual-income">
                                                         <tbody>
                                                            <tr>
                                                               <td>
                                                                  <div class="input_field_wrapper_checkbox textcenter">
                                                                     <input type="radio" class="es_checkbox" name="tp_health" value="Good" <?php echo ((isset($postData['tp_health'])) && ($postData['tp_health'] == 'Good')) ? 'checked' : ''; ?>>
                                                                  </div>
                                                               </td>
                                                               <td>
                                                                  <div class="input_field_wrapper">
                                                                     Good
                                                                  </div>
                                                               </td>
                                                            </tr>
                                                            <tr>
                                                               <td>
                                                                  <div class="input_field_wrapper_checkbox textcenter">
                                                                     <input type="radio" class="es_checkbox" name="tp_health" value="Fair" <?php echo ((isset($postData['tp_health'])) && ($postData['tp_health'] == 'Fair')) ? 'checked' : ''; ?>>
                                                                  </div>
                                                               </td>
                                                               <td>
                                                                  <div class="input_field_wrapper">
                                                                     Fair
                                                                  </div>
                                                               </td>
                                                            </tr>
                                                            <tr class="last-tr">
                                                               <td>
                                                                  <div class="input_field_wrapper_checkbox textcenter">
                                                                     <input type="radio" class="es_checkbox" name="tp_health" value="Poor" <?php echo ((isset($postData['tp_health'])) && ($postData['tp_health'] == 'Poor')) ? 'checked' : ''; ?>>
                                                                  </div>
                                                               </td>
                                                               <td>
                                                                  <div class="input_field_wrapper">
                                                                     Poor
                                                                  </div>
                                                               </td>
                                                            </tr>
                                                         </tbody>
                                                      </table>
                                                   </td>
                                                </tr>
                                                <tr>
                                                   <td>If not Good, Explain</td>
                                                   <td>
                                                      <div class="input_field_wrapper">
                                                         <input class="textcenter" type="text" placeholder="text" value="<?php echo isset($postData['tp_health_explain'])? $postData['tp_health_explain']:''; ?>" name="tp_health_explain" id="tp_health_explain" <?php echo ((isset($postData['tp_health'])) && ($postData['tp_health'] == 'Good')) ? 'readonly' : ''; ?>>
                                                      </div>
                                                   </td>
                                                </tr>
                                                <tr>
                                                   <td>Highest Education</td>
                                                   <td class="p-0">
                                                      <table width="100%" class="anuual-income">
                                                         <tbody>
                                                            <tr>
                                                               <td>
                                                                  <div class="input_field_wrapper_checkbox textcenter">
                                                                     <input type="radio" class="es_checkbox" name="tp_high_ed" value="Grade School" <?php echo ((isset($postData['tp_high_ed'])) && ($postData['tp_high_ed'] == 'Grade School')) ? 'checked' : ''; ?>>
                                                                  </div>
                                                               </td>
                                                               <td>
                                                                  <div class="input_field_wrapper">
                                                                     Grade School
                                                                  </div>
                                                               </td>
                                                            </tr>
                                                            <tr>
                                                               <td>
                                                                  <div class="input_field_wrapper_checkbox textcenter">
                                                                     <input type="radio" class="es_checkbox" name="tp_high_ed" value="High School" <?php echo ((isset($postData['tp_high_ed'])) && ($postData['tp_high_ed'] == 'High School')) ? 'checked' : ''; ?>>
                                                                  </div>
                                                               </td>
                                                               <td>
                                                                  <div class="input_field_wrapper">
                                                                     High School
                                                                  </div>
                                                               </td>
                                                            </tr>
                                                            <tr>
                                                               <td>
                                                                  <div class="input_field_wrapper_checkbox textcenter">
                                                                     <input type="radio" class="es_checkbox" name="tp_high_ed" value="Associate" <?php echo ((isset($postData['tp_high_ed'])) && ($postData['tp_high_ed'] == 'Associate')) ? 'checked' : ''; ?>>
                                                                  </div>
                                                               </td>
                                                               <td>
                                                                  <div class="input_field_wrapper">
                                                                     Associate
                                                                  </div>
                                                               </td>
                                                            </tr>
                                                            <tr>
                                                               <td>
                                                                  <div class="input_field_wrapper_checkbox textcenter">
                                                                     <input type="radio" class="es_checkbox" name="tp_high_ed" value="Bachelor’s" <?php echo ((isset($postData['tp_high_ed'])) && ($postData['tp_high_ed'] == 'Bachelor’s')) ? 'checked' : ''; ?>>
                                                                  </div>
                                                               </td>
                                                               <td>
                                                                  <div class="input_field_wrapper">
                                                                     Bachelor’s
                                                                  </div>
                                                               </td>
                                                            </tr>
                                                            <tr class="last-tr">
                                                               <td>
                                                                  <div class="input_field_wrapper_checkbox textcenter">
                                                                     <input type="radio" class="es_checkbox" name="tp_high_ed" value="Post Graduate" <?php echo ((isset($postData['tp_high_ed'])) && ($postData['tp_high_ed'] == 'Post Graduate')) ? 'checked' : ''; ?>>
                                                                  </div>
                                                               </td>
                                                               <td>
                                                                  <div class="input_field_wrapper">
                                                                     Post Graduate
                                                                  </div>
                                                               </td>
                                                            </tr>
                                                         </tbody>
                                                      </table>
                                                   </td>
                                                </tr>
                                                <tr>
                                                   <td>Other Technical Certifications</td>
                                                   <td>
                                                      <div class="input_field_wrapper">
                                                         <input class="textcenter" type="text" name="tp_other_tech_certs" placeholder="text" value="<?php echo isset($postData['tp_other_tech_certs'])? $postData['tp_other_tech_certs']:''; ?>">
                                                      </div>
                                                   </td>
                                                </tr>
                                                <tr>
                                                   <td class="border-bottom-0">Active Member of the U.S. Military</td>
                                                   <td class="border-bottom-0 p-0">
                                                      <table width="100%" class="anuual-income">
                                                         <tbody>
                                                            <tr>
                                                               <td>
                                                                  <div class="input_field_wrapper_checkbox textcenter">
                                                                     <input type="radio" name="tp_active_mil" class="es_checkbox" value="Yes" <?php echo ((isset($postData['tp_active_mil'])) && ($postData['tp_active_mil'] == 'Yes')) ? 'checked' : ''; ?>>
                                                                  </div>
                                                               </td>
                                                               <td>
                                                                  <div class="input_field_wrapper">
                                                                     Yes
                                                                  </div>
                                                               </td>
                                                            </tr>
                                                            <tr class="last-tr">
                                                               <td>
                                                                  <div class="input_field_wrapper_checkbox textcenter">
                                                                     <input type="radio" name="tp_active_mil" class="es_checkbox" value="No" <?php echo ((isset($postData['tp_active_mil'])) && ($postData['tp_active_mil'] == 'Yes')) ? '' : 'checked'; ?>>
                                                                  </div>
                                                               </td>
                                                               <td>
                                                                  <div class="input_field_wrapper">
                                                                     No
                                                                  </div>
                                                               </td>
                                                            </tr>
                                                         </tbody>
                                                      </table>
                                                   </td>
                                                </tr>
                                             </tbody>
                                          </table>
                                       </td>
                                       <td class="border-bottom-0 p-0">
                                          <table width="100%" class="tbl_full_width header_inner_table anuual-income">
                                             <tbody>
                                                <tr>
                                                   <td>Bottom Party Date of Birth</td>
                                                   <td>
                                                      <div class="input_field_wrapper">
                                                         <input class="textcenter hasDatepickerPast" name="bp_birthdate" id="bp_birthdate" type="text" placeholder="mm/dd/yyyy" value="<?php echo isset($postData['bp_birthdate'])? date("m/d/Y", strtotime($postData['bp_birthdate'])):''; ?>">
                                                      </div>
                                                   </td>
                                                </tr>
                                                <tr>
                                                   <td>Bottom Party Social Security Number</td>
                                                   <td>
                                                      <div class="input_field_wrapper">
                                                         <input class="textcenter" type="text" name="bp_ssn" id="bp_ssn" placeholder="xxx-xx-xxxx" value="<?php echo isset($postData['bp_ssn'])? $postData['bp_ssn']:''; ?>">
                                                      </div>
                                                   </td>
                                                </tr>
                                                <tr>
                                                   <td>Bottom Party Phone Number</td>
                                                   <td>
                                                      <div class="input_field_wrapper">
                                                         <input class="textcenter" type="text" name="bp_phone" id="bp_phone" placeholder="(xxx) xxx-xxxx" value="<?php echo isset($postData['bp_phone'])? $postData['bp_phone']:''; ?>">
                                                      </div>
                                                   </td>
                                                </tr>
                                                <tr>
                                                   <td>Bottom Party Health</td>
                                                   <td class="p-0">
                                                      <table width="100%" class="anuual-income">
                                                         <tbody>
                                                            <tr>
                                                               <td>
                                                                  <div class="input_field_wrapper_checkbox textcenter">
                                                                     <input type="radio" class="es_checkbox" name="bp_health" value="Good" <?php echo ((isset($postData['bp_health'])) && ($postData['bp_health'] == 'Good')) ? 'checked' : ''; ?>>
                                                                  </div>
                                                               </td>
                                                               <td>
                                                                  <div class="input_field_wrapper">
                                                                     Good
                                                                  </div>
                                                               </td>
                                                            </tr>
                                                            <tr>
                                                               <td>
                                                                  <div class="input_field_wrapper_checkbox textcenter">
                                                                     <input type="radio" class="es_checkbox" name="bp_health" value="Fair" <?php echo ((isset($postData['bp_health'])) && ($postData['bp_health'] == 'Fair')) ? 'checked' : ''; ?>>
                                                                  </div>
                                                               </td>
                                                               <td>
                                                                  <div class="input_field_wrapper">
                                                                     Fair
                                                                  </div>
                                                               </td>
                                                            </tr>
                                                            <tr class="last-tr">
                                                               <td>
                                                                  <div class="input_field_wrapper_checkbox textcenter">
                                                                     <input type="radio" class="es_checkbox" name="bp_health" value="Poor" <?php echo ((isset($postData['bp_health'])) && ($postData['bp_health'] == 'Poor')) ? 'checked' : ''; ?>>
                                                                  </div>
                                                               </td>
                                                               <td>
                                                                  <div class="input_field_wrapper">
                                                                     Poor
                                                                  </div>
                                                               </td>
                                                            </tr>
                                                         </tbody>
                                                      </table>
                                                   </td>
                                                </tr>
                                                <tr>
                                                   <td>If not Good, Explain</td>
                                                   <td>
                                                      <div class="input_field_wrapper">
                                                         <input class="textcenter" type="text" placeholder="text" value="<?php echo isset($postData['bp_health_explain'])? $postData['bp_health_explain']:''; ?>" name="bp_health_explain" id="bp_health_explain" <?php echo ((isset($postData['bp_health'])) && ($postData['bp_health'] == 'Good')) ? 'readonly' : ''; ?>>
                                                      </div>
                                                   </td>
                                                </tr>
                                                <tr>
                                                   <td>Highest Education</td>
                                                   <td class="p-0">
                                                      <table width="100%" class="anuual-income">
                                                         <tbody>
                                                            <tr>
                                                               <td>
                                                                  <div class="input_field_wrapper_checkbox textcenter">
                                                                     <input type="radio" class="es_checkbox" name="bp_high_ed" value="Grade School" <?php echo ((isset($postData['bp_high_ed'])) && ($postData['bp_high_ed'] == 'Grade School')) ? 'checked' : ''; ?>>
                                                                  </div>
                                                               </td>
                                                               <td>
                                                                  <div class="input_field_wrapper">
                                                                     Grade School
                                                                  </div>
                                                               </td>
                                                            </tr>
                                                            <tr>
                                                               <td>
                                                                  <div class="input_field_wrapper_checkbox textcenter">
                                                                     <input type="radio" class="es_checkbox" name="bp_high_ed" value="High School" <?php echo ((isset($postData['bp_high_ed'])) && ($postData['bp_high_ed'] == 'High School')) ? 'checked' : ''; ?>>
                                                                  </div>
                                                               </td>
                                                               <td>
                                                                  <div class="input_field_wrapper">
                                                                     High School
                                                                  </div>
                                                               </td>
                                                            </tr>
                                                            <tr>
                                                               <td>
                                                                  <div class="input_field_wrapper_checkbox textcenter">
                                                                     <input type="radio" class="es_checkbox" name="bp_high_ed" value="Associate" <?php echo ((isset($postData['bp_high_ed'])) && ($postData['bp_high_ed'] == 'Associate')) ? 'checked' : ''; ?>>
                                                                  </div>
                                                               </td>
                                                               <td>
                                                                  <div class="input_field_wrapper">
                                                                     Associate
                                                                  </div>
                                                               </td>
                                                            </tr>
                                                            <tr>
                                                               <td>
                                                                  <div class="input_field_wrapper_checkbox textcenter">
                                                                     <input type="radio" class="es_checkbox" name="bp_high_ed" value="Bachelor’s" <?php echo ((isset($postData['bp_high_ed'])) && ($postData['bp_high_ed'] == 'Bachelor’s')) ? 'checked' : ''; ?>>
                                                                  </div>
                                                               </td>
                                                               <td>
                                                                  <div class="input_field_wrapper">
                                                                     Bachelor’s
                                                                  </div>
                                                               </td>
                                                            </tr>
                                                            <tr class="last-tr">
                                                               <td>
                                                                  <div class="input_field_wrapper_checkbox textcenter">
                                                                     <input type="radio" class="es_checkbox" name="bp_high_ed" value="Post Graduate" <?php echo ((isset($postData['bp_high_ed'])) && ($postData['bp_high_ed'] == 'Post Graduate')) ? 'checked' : ''; ?>>
                                                                  </div>
                                                               </td>
                                                               <td>
                                                                  <div class="input_field_wrapper">
                                                                     Post Graduate
                                                                  </div>
                                                               </td>
                                                            </tr>
                                                         </tbody>
                                                      </table>
                                                   </td>
                                                </tr>
                                                <tr>
                                                   <td>Other Technical Certifications</td>
                                                   <td>
                                                      <div class="input_field_wrapper">
                                                         <input class="textcenter" type="text" name="bp_other_tech_certs" placeholder="text" value="<?php echo isset($postData['bp_other_tech_certs'])? $postData['bp_other_tech_certs']:''; ?>">
                                                      </div>
                                                   </td>
                                                </tr>
                                                <tr>
                                                   <td class="border-bottom-0">Active Member of the U.S. Military</td>
                                                   <td class="border-bottom-0 p-0">
                                                      <table width="100%" class="anuual-income">
                                                         <tbody>
                                                            <tr>
                                                               <td>
                                                                  <div class="input_field_wrapper_checkbox textcenter">
                                                                     <input type="radio" name="bp_active_mil" class="es_checkbox" value="Yes" <?php echo ((isset($postData['bp_active_mil'])) && ($postData['bp_active_mil'] == 'Yes')) ? 'checked' : ''; ?>>
                                                                  </div>
                                                               </td>
                                                               <td>
                                                                  <div class="input_field_wrapper">
                                                                     Yes
                                                                  </div>
                                                               </td>
                                                            </tr>
                                                            <tr class="last-tr">
                                                               <td>
                                                                  <div class="input_field_wrapper_checkbox textcenter">
                                                                     <input type="radio" name="bp_active_mil" class="es_checkbox" value="No" <?php echo ((isset($postData['bp_active_mil'])) && ($postData['bp_active_mil'] == 'Yes')) ? '' : 'checked'; ?>>
                                                                  </div>
                                                               </td>
                                                               <td>
                                                                  <div class="input_field_wrapper">
                                                                     No
                                                                  </div>
                                                               </td>
                                                            </tr>
                                                         </tbody>
                                                      </table>
                                                   </td>
                                                </tr>
                                             </tbody>
                                          </table>
                                       </td>
                                    </tr>
                                 </tbody>
                              </table>
                           </td>
                        </tr>
                        <tr>
                           <td class="Cell_heading" colspan="5">
                              <h2 class="recordInner_heading mb-0 mb-0">II. Income</h2>
                           </td>
                        </tr>
                        <tr>
                           <td colspan="5" class="border-bottom-0 p-0">
                              <table width="100%" class="tbl_full_width header_inner_table anuual-income">
                                 <tbody>
                                    <tr>
                                       <td></td>
                                       <th><span class="topparty_name_span">Top Party FullName</span>, <span class="topparty_role_span">Plaintiff</span></th>
                                       <th><span class="bottomparty_name_span">Bottom Party FullName</span>, <span class="bottomparty_role_span">Defendant</span></th>
                                    </tr>
                                    <tr>
                                       <td>Employed</td>
                                       <td class="p-0">
                                          <table width="100%" class="anuual-income">
                                             <tbody>
                                                <tr>
                                                   <td>
                                                      <div class="input_field_wrapper_checkbox textcenter">
                                                         <input type="radio" name="tp_employed" class="es_checkbox" value="Yes" <?php echo ((isset($postData['tp_employed'])) && ($postData['tp_employed'] == 'No')) ? '' : 'checked'; ?>>
                                                      </div>
                                                   </td>
                                                   <td>
                                                      <div class="input_field_wrapper">
                                                         Yes
                                                      </div>
                                                   </td>
                                                </tr>
                                                <tr class="last-tr">
                                                   <td>
                                                      <div class="input_field_wrapper_checkbox textcenter">
                                                         <input type="radio" name="tp_employed" class="es_checkbox" value="No" <?php echo ((isset($postData['tp_employed'])) && ($postData['tp_employed'] == 'No')) ? 'checked' : ''; ?>>
                                                      </div>
                                                   </td>
                                                   <td>
                                                      <div class="input_field_wrapper">
                                                         No
                                                      </div>
                                                   </td>
                                                </tr>
                                             </tbody>
                                          </table>
                                       </td>
                                       <td class="p-0">
                                          <table width="100%" class="anuual-income">
                                             <tbody>
                                                <tr>
                                                   <td>
                                                      <div class="input_field_wrapper_checkbox textcenter">
                                                         <input type="radio" name="bp_employed" class="es_checkbox" value="Yes" <?php echo ((isset($postData['bp_employed'])) && ($postData['bp_employed'] == 'No')) ? '' : 'checked'; ?>>
                                                      </div>
                                                   </td>
                                                   <td>
                                                      <div class="input_field_wrapper">
                                                         Yes
                                                      </div>
                                                   </td>
                                                </tr>
                                                <tr class="last-tr">
                                                   <td>
                                                      <div class="input_field_wrapper_checkbox textcenter">
                                                         <input type="radio" name="bp_employed" class="es_checkbox" value="No" <?php echo ((isset($postData['bp_employed'])) && ($postData['bp_employed'] == 'No')) ? 'checked' : ''; ?>>
                                                      </div>
                                                   </td>
                                                   <td>
                                                      <div class="input_field_wrapper">
                                                         No
                                                      </div>
                                                   </td>
                                                </tr>
                                             </tbody>
                                          </table>
                                       </td>
                                    </tr>
                                    <tr>
                                       <td>Date of Employment</td>
                                       <td>
                                          <div class="input_field_wrapper">
                                             <input class="textcenter hasDatepickerPast" name="tp_date_employed" type="text" placeholder="mm/dd/yyyy" value="<?php echo isset($postData['tp_date_employed'])? date("m/d/Y", strtotime($postData['tp_date_employed'])):''; ?>">
                                          </div>
                                       </td>
                                       <td>
                                          <div class="input_field_wrapper">
                                             <input class="textcenter hasDatepickerPast" name="bp_date_employed" type="text" placeholder="mm/dd/yyyy" value="<?php echo isset($postData['bp_date_employed'])? date("m/d/Y", strtotime($postData['bp_date_employed'])):''; ?>">
                                          </div>
                                       </td>
                                    </tr>
                                    <tr>
                                       <td>Employer Name</td>
                                       <td>
                                          <div class="input_field_wrapper">
                                             <input class="textcenter" name="tp_employer_name" type="text" placeholder="Employer Name" value="<?php echo isset($postData['tp_employer_name'])? $postData['tp_employer_name']:''; ?>">
                                          </div>
                                       </td>
                                       <td>
                                          <div class="input_field_wrapper">
                                             <input class="textcenter" name="bp_employer_name" type="text" placeholder="Employer Name" value="<?php echo isset($postData['bp_employer_name'])? $postData['bp_employer_name']:''; ?>">
                                          </div>
                                       </td>
                                    </tr>
                                    <tr>
                                       <td>Payroll Address</td>
                                       <td>
                                          <div class="input_field_wrapper">
                                             <input class="textcenter" name="tp_payroll_street_ad" type="text" placeholder="Payroll Address" value="<?php echo isset($postData['tp_payroll_street_ad'])? $postData['tp_payroll_street_ad']:''; ?>">
                                          </div>
                                       </td>
                                       <td>
                                          <div class="input_field_wrapper">
                                             <input class="textcenter" name="bp_payroll_street_ad" type="text" placeholder="Payroll Address" value="<?php echo isset($postData['bp_payroll_street_ad'])? $postData['bp_payroll_street_ad']:''; ?>">
                                          </div>
                                       </td>
                                    </tr>
                                    <tr>
                                       <td>Payroll City, State & Zip</td>
                                       <td class="p-0">
                                          <table width="100%" class="anuual-income">
                                             <tbody>
                                                <tr>
                                                   <td>City</td>
                                                   <td>
                                                      <div class="input_field_wrapper textcenter">
                                                         <input type="text" id="selected_top_party_payroll_city" value="<?php echo isset($postData['tp_payroll_city'])? $postData['tp_payroll_city']:''; ?>" style="display: none;">
                                                         <select class="test county-select" id="top_party_payroll_city" name="tp_payroll_city" style="font-size: 16px;">
                                                            <option value="">Choose City</option>
                                                         </select>
                                                      </div>
                                                   </td>
                                                </tr>
                                                <tr>
                                                   <td>State</td>
                                                   <td>
                                                      <div class="input_field_wrapper textcenter">
                                                       <input type="text" id="selected_top_party_payroll_state" value="<?php echo isset($postData['tp_payroll_state_id'])? $postData['tp_payroll_state_id']:''; ?>" style="display: none;">
                                                         <select class="test county-select" id="top_party_payroll_state" name="tp_payroll_state_id" style="font-size: 16px;">
                                                            <option value="">Choose State</option>
                                                         </select>
                                                      </div>
                                                   </td>
                                                </tr>
                                                <tr class="last-tr">
                                                   <td>Zip</td>
                                                   <td>
                                                       <div class="input_field_wrapper">
                                                         <input class="textcenter" type="text" id="tp_payroll_zip" name="tp_payroll_zip" placeholder="Zipcode" value="<?php echo isset($postData['tp_payroll_zip'])? $postData['tp_payroll_zip']:''; ?>" oninput="onPayrollZipChange(this, 'top');" data-onload="onPayrollZipChange(this, 'top');">
                                                       </div>
                                                   </td>
                                                </tr>
                                             </tbody>
                                          </table>
                                       </td>
                                       <td class="p-0">
                                          <table width="100%" class="anuual-income">
                                             <tbody>
                                                <tr>
                                                   <td>City</td>
                                                   <td>
                                                      <div class="input_field_wrapper textcenter">
                                                            <input type="text" id="selected_bottom_party_payroll_city" value="<?php echo isset($postData['bp_payroll_city'])? $postData['bp_payroll_city']:''; ?>" style="display: none;">
                                                            <select class="test county-select" id="bottom_party_payroll_city" name="bp_payroll_city" style="font-size: 16px;">
                                                                 <option value="">Choose City</option>
                                                            </select>
                                                      </div>
                                                   </td>
                                                </tr>
                                                <tr>
                                                   <td>State</td>
                                                   <td>
                                                      <div class="input_field_wrapper textcenter">
                                                            <input type="text" id="selected_bottom_party_payroll_state" value="<?php echo isset($postData['bp_payroll_state_id'])? $postData['bp_payroll_state_id']:''; ?>" style="display: none;">
                                                            <select class="test county-select" id="bottom_party_payroll_state" name="bp_payroll_state_id" style="font-size: 16px;">
                                                                 <option value="">Choose State</option>
                                                            </select>
                                                      </div>
                                                   </td>
                                                </tr>
                                                <tr class="last-tr">
                                                   <td>Zip</td>
                                                   <td>
                                                      <div class="input_field_wrapper">
                                                         <input class="textcenter" type="text" id="bp_payroll_zip" name="bp_payroll_zip" placeholder="Zipcode" value="<?php echo isset($postData['bp_payroll_zip'])? $postData['bp_payroll_zip']:''; ?>" oninput="onPayrollZipChange(this, 'bottom');" data-onload="onPayrollZipChange(this, 'bottom');">
                                                      </div>
                                                   </td>
                                                </tr>
                                             </tbody>
                                          </table>
                                       </td>
                                    </tr>
                                    <tr class="last-tr">
                                       <td>Number of Pay Periods/Year</td>
                                       <td>
                                          <div class="input_field_wrapper textcenter">
                                             <select class="test county-select" name="tp_yearly_pay_periods" style="font-size: 16px;">
                                                <option value="" <?php echo ((isset($postData['tp_yearly_pay_periods'])) && ($postData['tp_yearly_pay_periods'] == '')) ? 'selected' : ''; ?>>Choose</option>
                                                <option value="12" <?php echo ((isset($postData['tp_yearly_pay_periods'])) && ($postData['tp_yearly_pay_periods'] == '12')) ? 'selected' : ''; ?>>12</option>
                                                <option value="24" <?php echo ((isset($postData['tp_yearly_pay_periods'])) && ($postData['tp_yearly_pay_periods'] == '24')) ? 'selected' : ''; ?>>24</option>
                                                <option value="26" <?php echo ((isset($postData['tp_yearly_pay_periods'])) && ($postData['tp_yearly_pay_periods'] == '26')) ? 'selected' : ''; ?>>26</option>
                                                <option value="52" <?php echo ((isset($postData['tp_yearly_pay_periods'])) && ($postData['tp_yearly_pay_periods'] == '52')) ? 'selected' : ''; ?>>52</option>
                                             </select>
                                          </div>
                                       </td>
                                       <td>
                                          <div class="input_field_wrapper textcenter">
                                             <select class="test county-select" name="bp_yearly_pay_periods" style="font-size: 16px;">
                                                <option value="" <?php echo ((isset($postData['bp_yearly_pay_periods'])) && ($postData['bp_yearly_pay_periods'] == '')) ? 'selected' : ''; ?>>Choose</option>
                                                <option value="12" <?php echo ((isset($postData['bp_yearly_pay_periods'])) && ($postData['bp_yearly_pay_periods'] == '12')) ? 'selected' : ''; ?>>12</option>
                                                <option value="24" <?php echo ((isset($postData['bp_yearly_pay_periods'])) && ($postData['bp_yearly_pay_periods'] == '24')) ? 'selected' : ''; ?>>24</option>
                                                <option value="26" <?php echo ((isset($postData['bp_yearly_pay_periods'])) && ($postData['bp_yearly_pay_periods'] == '26')) ? 'selected' : ''; ?>>26</option>
                                                <option value="52" <?php echo ((isset($postData['bp_yearly_pay_periods'])) && ($postData['bp_yearly_pay_periods'] == '52')) ? 'selected' : ''; ?>>52</option>
                                             </select>
                                          </div>
                                       </td>
                                    </tr>
                                 </tbody>
                              </table>
                           </td>
                        </tr>
                        <tr>
                           <th colspan="5">
                              A. Yearly Income, Overtime, Commissions, and Bonuses for Past Three Years
                           </th>
                        </tr>
                        <tr>
                           <td colspan="5" class="border-bottom-0 p-0">
                              <table width="100%" class="tbl_full_width header_inner_table anuual-income">
                                 <tbody>
                                    <tr>
                                       <td></td>
                                       <td colspan="1"><span class="topparty_name_span">Top Party FullName</span>, <span class="topparty_role_span">Plaintiff</span> </td>
                                       <td></td>
                                       <td class="textcenter">Year</td>
                                       <td><span class="bottomparty_name_span">Bottom Party FullName</span>, <span class="bottomparty_role_span">Defendant</span> </td>
                                    </tr>
                                    <tr>
                                       <td rowspan="3">Base Yearly Income</td>
                                       <td>
                                          <div class="input_field_wrapper currency_start">
                                             <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="currency" type="number" placeholder="0.00" name="tp_base_yearly_income_3ya" value="<?php echo isset($postData['tp_base_yearly_income_3ya'])?number_format((float)$postData['tp_base_yearly_income_3ya'], 2, '.', ''):'0.00'; ?>">
                                          </div>
                                       </td>
                                       <td>
                                          <div class="input_field_wrapper textcenter">
                                             3 years ago
                                          </div>
                                       </td>
                                       <td>
                                          <div class="input_field_wrapper textcenter">
                                             <?php echo ($currentYear - 3); ?>
                                          </div>
                                       </td>
                                       <td>
                                          <div class="input_field_wrapper currency_start">
                                             <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="currency" type="number" placeholder="0.00" name="bp_base_yearly_income_3ya" value="<?php echo isset($postData['bp_base_yearly_income_3ya'])?number_format((float)$postData['bp_base_yearly_income_3ya'], 2, '.', ''):'0.00'; ?>">
                                          </div>
                                       </td>
                                    </tr>
                                    <tr>
                                       <td>
                                          <div class="input_field_wrapper currency_start">
                                             <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="currency" type="number" placeholder="0.00" name="tp_base_yearly_income_2ya" value="<?php echo isset($postData['tp_base_yearly_income_2ya'])?number_format((float)$postData['tp_base_yearly_income_2ya'], 2, '.', ''):'0.00'; ?>">
                                          </div>
                                       </td>
                                       <td>
                                          <div class="input_field_wrapper textcenter">
                                             2 years ago
                                          </div>
                                       </td>
                                       <td>
                                          <div class="input_field_wrapper textcenter">
                                             <?php echo ($currentYear - 2); ?>
                                          </div>
                                       </td>
                                       <td>
                                          <div class="input_field_wrapper currency_start">
                                             <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="currency" type="number" placeholder="0.00" name="bp_base_yearly_income_2ya" value="<?php echo isset($postData['bp_base_yearly_income_2ya'])?number_format((float)$postData['bp_base_yearly_income_2ya'], 2, '.', ''):'0.00'; ?>">
                                          </div>
                                       </td>
                                    </tr>
                                    <tr>
                                       <td>
                                          <div class="input_field_wrapper currency_start">
                                             <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="currency" type="number" placeholder="0.00" name="tp_base_yearly_income_1ya" value="<?php echo isset($postData['tp_base_yearly_income_1ya'])?number_format((float)$postData['tp_base_yearly_income_1ya'], 2, '.', ''):'0.00'; ?>">
                                          </div>
                                       </td>
                                       <td>
                                          <div class="input_field_wrapper textcenter">
                                             1 years ago
                                          </div>
                                       </td>
                                       <td>
                                          <div class="input_field_wrapper textcenter">
                                             <?php echo ($currentYear - 1); ?>
                                          </div>
                                       </td>
                                       <td>
                                          <div class="input_field_wrapper currency_start">
                                             <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="currency" type="number" placeholder="0.00" name="bp_base_yearly_income_1ya" value="<?php echo isset($postData['bp_base_yearly_income_1ya'])?number_format((float)$postData['bp_base_yearly_income_1ya'], 2, '.', ''):'0.00'; ?>">
                                          </div>
                                       </td>
                                    </tr>
                                    <tr>
                                       <td rowspan="3" class="border-bottom-0">Yearly overtime, commissions, and/or bonuses</td>
                                       <td>
                                          <div class="input_field_wrapper currency_start">
                                             <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="currency" type="number" placeholder="0.00" name="tp_yearly_OT_comms_bonuses_3ya" value="<?php echo isset($postData['tp_yearly_OT_comms_bonuses_3ya'])?number_format((float)$postData['tp_yearly_OT_comms_bonuses_3ya'], 2, '.', ''):'0.00'; ?>">
                                          </div>
                                       </td>
                                       <td>
                                          <div class="input_field_wrapper textcenter">
                                             3 years ago
                                          </div>
                                       </td>
                                       <td>
                                          <div class="input_field_wrapper textcenter">
                                             <?php echo ($currentYear - 3); ?>
                                          </div>
                                       </td>
                                       <td>
                                          <div class="input_field_wrapper currency_start">
                                             <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="currency" type="number" placeholder="0.00" name="bp_yearly_OT_comms_bonuses_3ya" value="<?php echo isset($postData['bp_yearly_OT_comms_bonuses_3ya'])?number_format((float)$postData['bp_yearly_OT_comms_bonuses_3ya'], 2, '.', ''):'0.00'; ?>">
                                          </div>
                                       </td>
                                    </tr>
                                    <tr>
                                       <td>
                                          <div class="input_field_wrapper currency_start">
                                             <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="currency" type="number" placeholder="0.00" name="tp_yearly_OT_comms_bonuses_2ya" value="<?php echo isset($postData['tp_yearly_OT_comms_bonuses_2ya'])?number_format((float)$postData['tp_yearly_OT_comms_bonuses_2ya'], 2, '.', ''):'0.00'; ?>">
                                          </div>
                                       </td>
                                       <td>
                                          <div class="input_field_wrapper textcenter">
                                             2 years ago
                                          </div>
                                       </td>
                                       <td>
                                          <div class="input_field_wrapper textcenter">
                                             <?php echo ($currentYear - 2); ?>
                                          </div>
                                       </td>
                                       <td>
                                          <div class="input_field_wrapper currency_start">
                                             <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="currency" type="number" placeholder="0.00" name="bp_yearly_OT_comms_bonuses_2ya" value="<?php echo isset($postData['bp_yearly_OT_comms_bonuses_2ya'])?number_format((float)$postData['bp_yearly_OT_comms_bonuses_2ya'], 2, '.', ''):'0.00'; ?>">
                                          </div>
                                       </td>
                                    </tr>
                                    <tr class="last-tr">
                                       <td>
                                          <div class="input_field_wrapper currency_start">
                                             <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="currency" type="number" placeholder="0.00" name="tp_yearly_OT_comms_bonuses_1ya" value="<?php echo isset($postData['tp_yearly_OT_comms_bonuses_1ya'])?number_format((float)$postData['tp_yearly_OT_comms_bonuses_1ya'], 2, '.', ''):'0.00'; ?>">
                                          </div>
                                       </td>
                                       <td>
                                          <div class="input_field_wrapper textcenter">
                                             1 years ago
                                          </div>
                                       </td>
                                       <td>
                                          <div class="input_field_wrapper textcenter">
                                             <?php echo ($currentYear - 1); ?>
                                          </div>
                                       </td>
                                       <td>
                                          <div class="input_field_wrapper currency_start">
                                             <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="currency" type="number" placeholder="0.00" name="bp_yearly_OT_comms_bonuses_1ya" value="<?php echo isset($postData['bp_yearly_OT_comms_bonuses_1ya'])?number_format((float)$postData['bp_yearly_OT_comms_bonuses_1ya'], 2, '.', ''):'0.00'; ?>">
                                          </div>
                                       </td>
                                    </tr>
                                 </tbody>
                              </table>
                           </td>
                        </tr>
                        <tr>
                           <th colspan="5">B. Computation of Current Income</th>
                        </tr>
                        <tr>
                           <td colspan="5" class="p-0">
                              <table width="100%" class="tbl_full_width header_inner_table anuual-income">
                                 <tbody>
                                    <tr>
                                       <td></td>
                                       <td><span class="topparty_name_span">Top Party FullName</span>, <span class="topparty_role_span">Plaintiff</span> </td>
                                       <td><span class="bottomparty_name_span">Bottom Party FullName</span>, <span class="bottomparty_role_span">Defendant</span></td>
                                    </tr>
                                    <tr>
                                       <td>Base Yearly Income Tools</td>
                                       <td class="p-0">
                                          <table width="100%" class="anuual-income">
                                             <tbody>
                                                <tr>
                                                   <td>
                                                      <div class="input_field_checkbox__currency">
                                                         <div class="input_field_wrapper_checkbox textcenter">
                                                            <input type="radio" id="top_party_base_yearly_checks_radio" name="tp_inc_radio_dial" class="es_checkbox" onclick="enableDisableField1('top', this)" value="year" <?php echo ((isset($postData['tp_inc_radio_dial'])) && ($postData['tp_inc_radio_dial'] == 'year')) ? 'checked' : ''; ?> required="">
                                                         </div>
                                                         <div class="input_field_wrapper currency_start">
                                                            <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="currency" type="number" id="top_party_input_year" name="tp_input_year" placeholder="Checks/Year" value="<?php echo isset($postData['tp_input_year'])?number_format((float)$postData['tp_input_year'], 2, '.', ''):'0.00'; ?>" step="0.01" onchange="callCalcuAnnualGrossIncome('top');" <?php echo ((isset($postData['tp_inc_radio_dial'])) && ($postData['tp_inc_radio_dial'] == 'year')) ? '' : 'readonly'; ?>>
                                                         </div>
                                                      </div>
                                                   </td>
                                                   <td>
                                                      <div class="input_field_wrapper textcenter">
                                                         <select class="test county-select" id="top_party_dropdown" name="tp_dropdown" onchange="callCalcuAnnualGrossIncome('top');" style="font-size: 16px;">
                                                            <option value="0" <option value="0" <?php echo ((isset($postData['tp_dropdown'])) && ($postData['tp_dropdown'] == '0')) ? 'selected' : ''; ?>>None</option>>Frequency</option>
                                                            <option value="1" <?php echo ((isset($postData['tp_dropdown'])) && ($postData['tp_dropdown'] == '1')) ? 'selected' : ''; ?>>Yearly</option>
                                                            <option value="12" <?php echo ((isset($postData['tp_dropdown'])) && ($postData['tp_dropdown'] == '12')) ? 'selected' : ''; ?>>Monthly</option>
                                                            <option value="24" <?php echo ((isset($postData['tp_dropdown'])) && ($postData['tp_dropdown'] == '24')) ? 'selected' : ''; ?>>Bi-Monthly</option>
                                                            <option value="26" <?php echo ((isset($postData['tp_dropdown'])) && ($postData['tp_dropdown'] == '26')) ? 'selected' : ''; ?>>Bi-Weekly</option>
                                                            <option value="52" <?php echo ((isset($postData['tp_dropdown'])) && ($postData['tp_dropdown'] == '52')) ? 'selected' : ''; ?>>Weekly</option>
                                                         </select>
                                                      </div>
                                                   </td>
                                                </tr>
                                                <tr>
                                                   <td>
                                                      <div class="input_field_checkbox__currency">
                                                         <div class="input_field_wrapper_checkbox textcenter">
                                                            <input type="radio" class="es_checkbox" id="top_party_base_yearly_ytd_radio" name="tp_inc_radio_dial" onclick="enableDisableField1('top', this)" value="ytd" <?php echo ((isset($postData['tp_inc_radio_dial'])) && ($postData['tp_inc_radio_dial'] == 'ytd')) ? 'checked' : ''; ?>>
                                                         </div>
                                                         <div class="input_field_wrapper currency_start">
                                                            <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="currency" type="number" id="top_party_input_ytd" name="tp_input_ytd" placeholder="0.00" value="<?php echo isset($postData['tp_input_ytd'])?number_format((float)$postData['tp_input_ytd'], 2, '.', ''):'0.00'; ?>" step="0.01" onchange="callCalcuAnnualGrossIncome('top');" <?php echo ((isset($postData['tp_inc_radio_dial'])) && ($postData['tp_inc_radio_dial'] == 'ytd')) ? '' : 'readonly'; ?>>
                                                         </div>
                                                      </div>
                                                   </td>
                                                   <td>
                                                      <div class="input_field_wrapper textcenter">
                                                         <div class="input_field_wrapper">
                                                            <input class="textcenter hasDatepicker" id="top_party_datepick" name="tp_datepick" type="text" placeholder="YTD" value="<?php echo isset($postData['tp_datepick'])? date("m/d/Y", strtotime($postData['tp_datepick'])):''; ?>" onchange="callCalcuAnnualGrossIncome('top');" <?php echo ((isset($postData['tp_inc_radio_dial'])) && ($postData['tp_inc_radio_dial'] == 'ytd')) ? '' : 'readonly'; ?>>
                                                         </div>
                                                      </div>
                                                   </td>
                                                </tr>
                                                <tr class="last-tr">
                                                   <td colspan="2">
                                                      <div class="input_field_checkbox__currency">
                                                         <div class="input_field_wrapper_checkbox textcenter">
                                                            <input type="radio" class="es_checkbox" id="top_party_base_yearly_ohio_min_wage_radio" name="tp_inc_radio_dial" onclick="enableDisableField1('top', this)" value="ohio_min_wage" <?php echo ((isset($postData['tp_inc_radio_dial'])) && ($postData['tp_inc_radio_dial'] == 'ohio_min_wage')) ? 'checked' : ''; ?>>
                                                         </div>
                                                         <div class="input_field_wrapper">
                                                            Ohio Minimum Wage
                                                         </div>
                                                      </div>
                                                   </td>
                                                </tr>
                                             </tbody>
                                          </table>
                                       </td>
                                       <td class="p-0">
                                          <table width="100%" class="anuual-income">
                                             <tbody>
                                                <tr>
                                                   <td>
                                                      <div class="input_field_checkbox__currency">
                                                         <div class="input_field_wrapper_checkbox textcenter">
                                                            <input type="radio" id="bottom_party_base_yearly_checks_radio" name="bp_inc_radio_dial" class="es_checkbox" onclick="enableDisableField1('bottom', this)" value="year" <?php echo ((isset($postData['bp_inc_radio_dial'])) && ($postData['bp_inc_radio_dial'] == 'year')) ? 'checked' : ''; ?> required="">
                                                         </div>
                                                         <div class="input_field_wrapper currency_start">
                                                            <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="currency" type="number" id="bottom_party_input_year" name="bp_input_year" placeholder="Checks/Year" value="<?php echo isset($postData['bp_input_year'])?number_format((float)$postData['bp_input_year'], 2, '.', ''):'0.00'; ?>" step="0.01" onchange="callCalcuAnnualGrossIncome('bottom');" <?php echo ((isset($postData['bp_inc_radio_dial'])) && ($postData['bp_inc_radio_dial'] == 'year')) ? '' : 'readonly'; ?>>
                                                         </div>
                                                      </div>
                                                   </td>
                                                   <td>
                                                      <div class="input_field_wrapper textcenter">
                                                         <select class="test county-select" id="bottom_party_dropdown" name="bp_dropdown" onchange="callCalcuAnnualGrossIncome('bottom');" style="font-size: 16px;">
                                                            <option value="0" <option value="0" <?php echo ((isset($postData['bp_dropdown'])) && ($postData['bp_dropdown'] == '0')) ? 'selected' : ''; ?>>None</option>>Frequency</option>
                                                            <option value="1" <?php echo ((isset($postData['bp_dropdown'])) && ($postData['bp_dropdown'] == '1')) ? 'selected' : ''; ?>>Yearly</option>
                                                            <option value="12" <?php echo ((isset($postData['bp_dropdown'])) && ($postData['bp_dropdown'] == '12')) ? 'selected' : ''; ?>>Monthly</option>
                                                            <option value="24" <?php echo ((isset($postData['bp_dropdown'])) && ($postData['bp_dropdown'] == '24')) ? 'selected' : ''; ?>>Bi-Monthly</option>
                                                            <option value="26" <?php echo ((isset($postData['bp_dropdown'])) && ($postData['bp_dropdown'] == '26')) ? 'selected' : ''; ?>>Bi-Weekly</option>
                                                            <option value="52" <?php echo ((isset($postData['bp_dropdown'])) && ($postData['bp_dropdown'] == '52')) ? 'selected' : ''; ?>>Weekly</option>
                                                         </select>
                                                      </div>
                                                   </td>
                                                </tr>
                                                <tr>
                                                   <td>
                                                      <div class="input_field_checkbox__currency">
                                                         <div class="input_field_wrapper_checkbox textcenter">
                                                            <input type="radio" class="es_checkbox" id="bottom_party_base_yearly_ytd_radio" name="bp_inc_radio_dial" onclick="enableDisableField1('bottom', this)" value="ytd" <?php echo ((isset($postData['bp_inc_radio_dial'])) && ($postData['bp_inc_radio_dial'] == 'ytd')) ? 'checked' : ''; ?>>
                                                         </div>
                                                         <div class="input_field_wrapper currency_start">
                                                            <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="currency" type="number" id="bottom_party_input_ytd" name="bp_input_ytd" placeholder="0.00" value="<?php echo isset($postData['bp_input_ytd'])?number_format((float)$postData['bp_input_ytd'], 2, '.', ''):'0.00'; ?>" step="0.01" onchange="callCalcuAnnualGrossIncome('bottom');" <?php echo ((isset($postData['bp_inc_radio_dial'])) && ($postData['bp_inc_radio_dial'] == 'ytd')) ? '' : 'readonly'; ?>>
                                                         </div>
                                                      </div>
                                                   </td>
                                                   <td>
                                                      <div class="input_field_wrapper textcenter">
                                                         <div class="input_field_wrapper">
                                                            <input class="textcenter hasDatepicker" id="bottom_party_datepick" name="bp_datepick" type="text" placeholder="YTD" value="<?php echo isset($postData['bp_datepick'])? date("m/d/Y", strtotime($postData['bp_datepick'])):''; ?>" onchange="callCalcuAnnualGrossIncome('bottom');" <?php echo ((isset($postData['bp_inc_radio_dial'])) && ($postData['bp_inc_radio_dial'] == 'ytd')) ? '' : 'readonly'; ?>>
                                                         </div>
                                                      </div>
                                                   </td>
                                                </tr>
                                                <tr class="last-tr">
                                                   <td colspan="2">
                                                      <div class="input_field_checkbox__currency">
                                                         <div class="input_field_wrapper_checkbox textcenter">
                                                            <input type="radio" class="es_checkbox" id="bottom_party_base_yearly_ohio_min_wage_radio" name="bp_inc_radio_dial" onclick="enableDisableField1('bottom', this)" value="ohio_min_wage" <?php echo ((isset($postData['bp_inc_radio_dial'])) && ($postData['bp_inc_radio_dial'] == 'ohio_min_wage')) ? 'checked' : ''; ?>>
                                                         </div>
                                                         <div class="input_field_wrapper">
                                                            Ohio Minimum Wage
                                                         </div>
                                                      </div>
                                                   </td>
                                                </tr>
                                             </tbody>
                                          </table>
                                       </td>
                                    </tr>
                                    <tr>
                                       <td> Base Yearly Income </td>
                                       <td>
                                          <div class="input_field_wrapper currency_start">
                                             <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="currency" type="number" id="top_party_base_yearly_income_current" name="tp_base_yearly_income_current" placeholder="0.00" value="<?php echo isset($postData['tp_base_yearly_income_current'])?number_format((float)$postData['tp_base_yearly_income_current'], 2, '.', ''):'0.00'; ?>" readonly="">
                                          </div>
                                       </td>
                                       <td>
                                          <div class="input_field_wrapper currency_start">
                                             <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="currency" type="number" id="bottom_party_base_yearly_income_current" name="bp_base_yearly_income_current" placeholder="0.00" value="<?php echo isset($postData['bp_base_yearly_income_current'])?number_format((float)$postData['bp_base_yearly_income_current'], 2, '.', ''):'0.00'; ?>" readonly="">
                                          </div>
                                       </td>
                                    </tr>
                                    <tr>
                                       <td> Average yearly overtime, commissions, and/or bonuses over last three years</td>
                                       <td>
                                            <div class="input_field_wrapper currency_start">
                                                  <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="currency" type="number" id="tp_ave_OT_comms_bonuses" name="tp_ave_OT_comms_bonuses" placeholder="0.00" value="<?php echo isset($postData['tp_ave_OT_comms_bonuses'])?number_format((float)$postData['tp_ave_OT_comms_bonuses'], 2, '.', ''):'0.00'; ?>" readonly="">
                                             </div>
                                             <!-- <div class="input_field_wrapper_checkbox">
                                                  <input type="checkbox" id="tp_ave_OT_comms_bonuses_compute" class="es_checkbox" value="tp_compute_from_a" onclick="computeAvgOtComsBonus(this, 'tp')">
                                                  <label class="mb-0">compute from second half of A.</label>
                                             </div> -->
                                       </td>
                                       <td>
                                             <div class="input_field_wrapper currency_start">
                                                  <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="currency" type="number" id="bp_ave_OT_comms_bonuses" name="bp_ave_OT_comms_bonuses" placeholder="0.00" value="<?php echo isset($postData['bp_ave_OT_comms_bonuses'])?number_format((float)$postData['bp_ave_OT_comms_bonuses'], 2, '.', ''):'0.00'; ?>" readonly="">
                                             </div>
                                             <!-- <div class="input_field_wrapper_checkbox">
                                                  <input type="checkbox" id="bp_ave_OT_comms_bonuses_compute" class="es_checkbox" value="bp_compute_from_a" onclick="computeAvgOtComsBonus(this, 'bp')">
                                                  <label class="mb-0">compute from second half of A.</label>
                                             </div> -->
                                       </td>
                                    </tr>
                                    <tr>
                                       <td> Unemployment Compensation </td>
                                       <td>
                                          <div class="input_field_wrapper currency_start">
                                             <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="currency" type="number" placeholder="0.00" value="<?php echo isset($postData['tp_unemp_comp'])?number_format((float)$postData['tp_unemp_comp'], 2, '.', ''):'0.00'; ?>" name="tp_unemp_comp">
                                          </div>
                                       </td>
                                       <td>
                                          <div class="input_field_wrapper currency_start">
                                             <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="currency" type="number" placeholder="0.00" value="<?php echo isset($postData['bp_unemp_comp'])?number_format((float)$postData['bp_unemp_comp'], 2, '.', ''):'0.00'; ?>" name="bp_unemp_comp">
                                          </div>
                                       </td>
                                    </tr>
                                    <tr>
                                       <td>
                                        <?php 
                                             if((isset($postData['tp_workers_comp']) && $postData['tp_workers_comp'] > 0.00) || (isset($postData['bp_workers_comp']) && $postData['bp_workers_comp'] > 0.00)){ $workers_comp_checked="checked"; } else { $workers_comp_checked=""; }

                                             if((isset($postData['tp_ss_disability']) && $postData['tp_ss_disability'] > 0.00) || (isset($postData['bp_ss_disability']) && $postData['bp_ss_disability'] > 0.00)){ $ss_disability_checked="checked"; } else { $ss_disability_checked=""; }

                                             if((isset($postData['tp_other_disability']) && $postData['tp_other_disability'] > 0.00) || (isset($postData['bp_other_disability']) && $postData['bp_other_disability'] > 0.00)){ $other_disability_checked="checked"; } else { $other_disability_checked=""; }
                                        ?>
                                          <p class="mb-1">Disability Benefits</p>
                                          <div class="input_field_wrapper_checkbox">
                                             <input type="checkbox" class="es_checkbox" value="" id="tp_bp_workers_comp_checkbox" onclick="enableDisableCurrencyInputs(this, 'tp_bp_workers_comp_inputs');" {{$workers_comp_checked}}>
                                             <label class="mb-0">Worker’s Compensation</label>
                                          </div>
                                          <div class="input_field_wrapper_checkbox">
                                             <input type="checkbox" class="es_checkbox" value="" id="tp_bp_ss_disability_checkbox" onclick="enableDisableCurrencyInputs(this, 'tp_bp_ss_disability_inputs');" {{$ss_disability_checked}}>
                                             <label class="mb-0">Social Security</label>
                                          </div>
                                          <div class="input_field_wrapper_checkbox">
                                             <input type="checkbox" class="es_checkbox" value="" id="tp_bp_other_disability_checkbox" onclick="enableDisableCurrencyInputsWithText(this, 'tp_bp_other_disability_inputs');" {{$other_disability_checked}}>
                                             <label class="mb-0">Other:</label>
                                          </div>
                                       </td>
                                       <td>
                                          <br>
                                          <div class="input_field_wrapper currency_start mb-1">
                                             <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="currency tp_bp_workers_comp_inputs" type="number" id="tp_workers_comp" name="tp_workers_comp" placeholder="0.00" value="<?php echo isset($postData['tp_workers_comp'])?number_format((float)$postData['tp_workers_comp'], 2, '.', ''):'0.00'; ?>" <?php echo ((isset($workers_comp_checked)) && ($workers_comp_checked == 'checked')) ? '' : 'readonly'; ?>>
                                          </div>
                                          <div class="divider"></div>
                                          <div class="input_field_wrapper currency_start mb-1">
                                             <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="currency tp_bp_ss_disability_inputs" type="number" id="tp_ss_disability" name="tp_ss_disability" placeholder="0.00" value="<?php echo isset($postData['tp_ss_disability'])?number_format((float)$postData['tp_ss_disability'], 2, '.', ''):'0.00'; ?>" <?php echo ((isset($ss_disability_checked)) && ($ss_disability_checked == 'checked')) ? '' : 'readonly'; ?>>
                                          </div>
                                          <div class="divider"></div>
                                          <div class="input_field_wrapper currency_start">
                                             <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="currency tp_bp_other_disability_inputs" type="number" id="tp_other_disability" name="tp_other_disability" placeholder="0.00" value="<?php echo isset($postData['tp_other_disability'])?number_format((float)$postData['tp_other_disability'], 2, '.', ''):'0.00'; ?>" <?php echo ((isset($other_disability_checked)) && ($other_disability_checked == 'checked')) ? '' : 'readonly'; ?>>
                                          </div>
                                          <div class="divider"></div>
                                          <div class="input_field_wrapper mt-1">
                                             <input type="text" id="tp_other_disability_type" class="tp_bp_other_disability_inputs_text" name="tp_other_disability_type" placeholder="Enter Disability Type" value="<?php echo isset($postData['tp_other_disability_type'])? $postData['tp_other_disability_type']:''; ?>" <?php echo ((isset($other_disability_checked)) && ($other_disability_checked == 'checked')) ? '' : 'readonly'; ?>>
                                          </div>
                                       </td>
                                       <td>
                                          <br>
                                          <div class="input_field_wrapper currency_start mb-1">
                                             <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="currency tp_bp_workers_comp_inputs" type="number" id="bp_workers_comp" name="bp_workers_comp" placeholder="0.00" value="<?php echo isset($postData['bp_workers_comp'])?number_format((float)$postData['bp_workers_comp'], 2, '.', ''):'0.00'; ?>" <?php echo ((isset($workers_comp_checked)) && ($workers_comp_checked == 'checked')) ? '' : 'readonly'; ?>>
                                          </div>
                                          <div class="divider"></div>
                                          <div class="input_field_wrapper currency_start mb-1">
                                             <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="currency tp_bp_ss_disability_inputs" type="number" id="bp_ss_disability" name="bp_ss_disability" placeholder="0.00" value="<?php echo isset($postData['bp_ss_disability'])?number_format((float)$postData['bp_ss_disability'], 2, '.', ''):'0.00'; ?>" <?php echo ((isset($ss_disability_checked)) && ($ss_disability_checked == 'checked')) ? '' : 'readonly'; ?>>
                                          </div>
                                          <div class="divider"></div>
                                          <div class="input_field_wrapper currency_start">
                                             <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="currency tp_bp_other_disability_inputs" type="number" id="bp_other_disability" name="bp_other_disability" placeholder="0.00" value="<?php echo isset($postData['bp_other_disability'])?number_format((float)$postData['bp_other_disability'], 2, '.', ''):'0.00'; ?>" <?php echo ((isset($other_disability_checked)) && ($other_disability_checked == 'checked')) ? '' : 'readonly'; ?>>
                                          </div>
                                          <div class="divider"></div>
                                          <div class="input_field_wrapper mt-1">
                                             <input type="text" id="bp_other_disability_type" class="tp_bp_other_disability_inputs_text" name="bp_other_disability_type" placeholder="Enter Disability Type" value="<?php echo isset($postData['bp_other_disability_type'])? $postData['bp_other_disability_type']:''; ?>" <?php echo ((isset($other_disability_checked)) && ($other_disability_checked == 'checked')) ? '' : 'readonly'; ?>>
                                          </div>
                                       </td>
                                    </tr>
                                    <tr>
                                       <td>
                                        <?php 
                                             if((isset($postData['tp_retirement_ss']) && $postData['tp_retirement_ss'] > 0.00) || (isset($postData['bp_retirement_ss']) && $postData['bp_retirement_ss'] > 0.00)){ $retirement_ss_checked="checked"; } else { $retirement_ss_checked=""; }

                                             if((isset($postData['tp_retirement_other']) && $postData['tp_retirement_other'] > 0.00) || (isset($postData['bp_retirement_other']) && $postData['bp_retirement_other'] > 0.00)){ $retirement_other_checked="checked"; } else { $retirement_other_checked=""; }
                                        ?>
                                          <p class="mb-1">Retirement Benefits</p>
                                          <div class="input_field_wrapper_checkbox">
                                             <input type="checkbox" class="es_checkbox" value="" id="tp_bp_retirement_ss_checkbox" onclick="enableDisableCurrencyInputs(this, 'tp_bp_retirement_ss_inputs');" {{$retirement_ss_checked}}>
                                             <label class="mb-0">Social Security</label>
                                          </div>
                                          <div class="input_field_wrapper_checkbox">
                                             <input type="checkbox" class="es_checkbox" value="" id="tp_bp_retirement_other_type_checkbox" onclick="enableDisableCurrencyInputsWithText(this, 'tp_bp_retirement_other_inputs');" {{$retirement_other_checked}}>
                                             <label class="mb-0">Other:</label>
                                          </div>
                                       </td>
                                       <td>
                                          <br>
                                          <div class="input_field_wrapper currency_start mb-1">
                                             <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="currency tp_bp_retirement_ss_inputs" type="number" id="tp_retirement_ss" name="tp_retirement_ss" placeholder="0.00" value="<?php echo isset($postData['tp_retirement_ss'])?number_format((float)$postData['tp_retirement_ss'], 2, '.', ''):'0.00'; ?>" <?php echo ((isset($retirement_ss_checked)) && ($retirement_ss_checked == 'checked')) ? '' : 'readonly'; ?>>
                                          </div>
                                          <div class="divider"></div>
                                          <div class="input_field_wrapper currency_start mb-1">
                                             <input  data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="currency tp_bp_retirement_other_inputs" type="number" id="tp_retirement_other" name="tp_retirement_other"  placeholder="0.00" value="<?php echo isset($postData['tp_retirement_other'])?number_format((float)$postData['tp_retirement_other'], 2, '.', ''):'0.00'; ?>" <?php echo ((isset($retirement_other_checked)) && ($retirement_other_checked == 'checked')) ? '' : 'readonly'; ?>>
                                          </div>
                                          <div class="divider"></div>
                                          <div class="input_field_wrapper mt-1">
                                             <input type="text" id="tp_retirement_other_type" class="tp_bp_retirement_other_inputs_text" name="tp_retirement_other_type" placeholder="Enter Other Benefits" value="<?php echo isset($postData['tp_retirement_other_type'])? $postData['tp_retirement_other_type']:''; ?>" <?php echo ((isset($retirement_other_checked)) && ($retirement_other_checked == 'checked')) ? '' : 'readonly'; ?>>
                                          </div>
                                       </td>
                                       <td>
                                          <br>
                                          <div class="input_field_wrapper currency_start">
                                             <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="currency tp_bp_retirement_ss_inputs" type="number" id="bp_retirement_ss" name="bp_retirement_ss" placeholder="0.00" value="<?php echo isset($postData['bp_retirement_ss'])?number_format((float)$postData['bp_retirement_ss'], 2, '.', ''):'0.00'; ?>" <?php echo ((isset($retirement_ss_checked)) && ($retirement_ss_checked == 'checked')) ? '' : 'readonly'; ?>>
                                          </div>
                                          <div class="divider"></div>
                                          
                                          <div class="input_field_wrapper currency_start">
                                             <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="currency tp_bp_retirement_other_inputs" type="number" id="bp_retirement_other" name="bp_retirement_other" placeholder="0.00" value="<?php echo isset($postData['bp_retirement_other'])?number_format((float)$postData['bp_retirement_other'], 2, '.', ''):'0.00'; ?>" <?php echo ((isset($retirement_other_checked)) && ($retirement_other_checked == 'checked')) ? '' : 'readonly'; ?>>
                                          </div>
                                          <div class="divider"></div>
                                          <div class="input_field_wrapper mt-1">
                                             <input type="text" id="bp_retirement_other_type" class="tp_bp_retirement_other_inputs_text" name="bp_retirement_other_type" placeholder="Enter Other Benefits" value="<?php echo isset($postData['bp_retirement_other_type'])? $postData['bp_retirement_other_type']:''; ?>" <?php echo ((isset($retirement_other_checked)) && ($retirement_other_checked == 'checked')) ? '' : 'readonly'; ?>>
                                          </div>
                                       </td>
                                    </tr>
                                    <tr>
                                       <td>Spousal Support Received</td>
                                       <td>
                                          <div class="input_field_wrapper currency_start">
                                             <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="currency" type="number" placeholder="0.00" value="<?php echo isset($postData['tp_spousal_support_recvd'])?number_format((float)$postData['tp_spousal_support_recvd'], 2, '.', ''):'0.00'; ?>" name="tp_spousal_support_recvd">
                                          </div>
                                       </td>
                                       <td>
                                          <div class="input_field_wrapper currency_start">
                                             <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="currency" type="number" placeholder="0.00" value="<?php echo isset($postData['bp_spousal_support_recvd'])?number_format((float)$postData['bp_spousal_support_recvd'], 2, '.', ''):'0.00'; ?>" name="bp_spousal_support_recvd">
                                          </div>
                                       </td>
                                    </tr>
                                    <tr>
                                       <td>Interest and dividend income:</td>
                                       <td>
                                          <div class="input_field_wrapper currency_start">
                                             <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="currency" type="number" placeholder="0.00" value="<?php echo isset($postData['tp_int_and_div'])?number_format((float)$postData['tp_int_and_div'], 2, '.', ''):'0.00'; ?>" name="tp_int_and_div">
                                          </div>
                                       </td>
                                       <td>
                                          <div class="input_field_wrapper currency_start">
                                             <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="currency" type="number" placeholder="0.00" value="<?php echo isset($postData['bp_int_and_div'])?number_format((float)$postData['bp_int_and_div'], 2, '.', ''):'0.00'; ?>" name="bp_int_and_div">
                                          </div>
                                       </td>
                                    </tr>
                                    <tr>
                                       <td>
                                          Source:
                                       </td>
                                       <td>
                                          <div class="input_field_wrapper">
                                             <input type="text" placeholder="Enter Source" value="<?php echo isset($postData['tp_int_div_source'])? $postData['tp_int_div_source']:''; ?>" name="tp_int_div_source">
                                          </div>
                                       </td>
                                       <td>
                                          <div class="input_field_wrapper">
                                             <input type="text" placeholder="Enter Source" value="<?php echo isset($postData['bp_int_div_source'])? $postData['bp_int_div_source']:''; ?>" name="bp_int_div_source">
                                          </div>
                                       </td>
                                    </tr>
                                    <tr>
                                       <td>
                                        <?php 
                                             if((isset($postData['tp_other_inc']) && $postData['tp_other_inc'] > 0.00) || (isset($postData['bp_other_inc']) && $postData['bp_other_inc'] > 0.00)){ $other_inc_checked="checked"; } else { $other_inc_checked=""; }
                                        ?>
                                          <div class="input_field_wrapper_checkbox">
                                             <input type="checkbox" class="es_checkbox" value="" id="tp_bp_other_inc_source_checkbox" onclick="enableDisableCurrencyInputsWithText(this, 'tp_bp_other_inc_inputs');" {{$other_inc_checked}}>
                                               Other income: Source:
                                          </div>
                                       </td>
                                       <td>
                                          <div class="input_field_wrapper currency_start">
                                             <input  data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="currency tp_bp_other_inc_inputs" type="number" placeholder="0.00" value="<?php echo isset($postData['tp_other_inc'])?number_format((float)$postData['tp_other_inc'], 2, '.', ''):'0.00'; ?>" name="tp_other_inc" <?php echo ((isset($other_inc_checked)) && ($other_inc_checked == 'checked')) ? '' : 'readonly'; ?>>
                                          </div>
                                          <div class="input_field_wrapper mt-1">
                                             <input type="text" placeholder="Enter Other Income Source" value="<?php echo isset($postData['tp_other_inc_source'])? $postData['tp_other_inc_source']:''; ?>" class="tp_bp_other_inc_inputs_text" name="tp_other_inc_source" <?php echo ((isset($other_inc_checked)) && ($other_inc_checked == 'checked')) ? '' : 'readonly'; ?>>
                                          </div>
                                       </td>
                                       <td>
                                          <div class="input_field_wrapper currency_start">
                                             <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="currency tp_bp_other_inc_inputs" type="number" placeholder="0.00" value="<?php echo isset($postData['bp_other_inc'])?number_format((float)$postData['bp_other_inc'], 2, '.', ''):'0.00'; ?>" name="bp_other_inc" <?php echo ((isset($other_inc_checked)) && ($other_inc_checked == 'checked')) ? '' : 'readonly'; ?>>
                                          </div>
                                          <div class="input_field_wrapper mt-1">
                                             <input type="text" placeholder="Enter Other Income Source" value="<?php echo isset($postData['bp_other_inc_source'])? $postData['bp_other_inc_source']:''; ?>" class="tp_bp_other_inc_inputs_text" name="bp_other_inc_source" <?php echo ((isset($other_inc_checked)) && ($other_inc_checked == 'checked')) ? '' : 'readonly'; ?>>
                                          </div>
                                       </td>
                                    </tr>
                                    <tr>
                                       <td>
                                          <b>TOTAL YEARLY INCOME</b>
                                       </td>
                                       <td>
                                          <div class="input_field_wrapper currency_start">
                                             <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="currency" type="number" id="tp_total_yearly_inc" name="tp_total_yearly_inc" value="<?php echo isset($postData['tp_total_yearly_inc'])?number_format((float)$postData['tp_total_yearly_inc'], 2, '.', ''):'0.00'; ?>" placeholder="0.00" readonly="">
                                        
                                          </div>
                                       </td>
                                       <td>
                                          <div class="input_field_wrapper currency_start">
                                             <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="currency" type="number" id="bp_total_yearly_inc" name="bp_total_yearly_inc" value="<?php echo isset($postData['bp_total_yearly_inc'])?number_format((float)$postData['bp_total_yearly_inc'], 2, '.', ''):'0.00'; ?>" placeholder="0.00" readonly="">
                                        
                                          </div>
                                       </td>
                                    </tr>
                                    <tr>
                                       <td>Supplemental Security Income (SSI) or public assistance </td>
                                       <td>
                                          <div class="input_field_wrapper currency_start">
                                             <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="currency" type="number" placeholder="0.00" value="<?php echo isset($postData['tp_ssi'])?number_format((float)$postData['tp_ssi'], 2, '.', ''):'0.00'; ?>" name="tp_ssi">
                                          </div>
                                       </td>
                                       <td>
                                          <div class="input_field_wrapper currency_start">
                                             <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="currency" type="number" placeholder="0.00" value="<?php echo isset($postData['bp_ssi'])?number_format((float)$postData['bp_ssi'], 2, '.', ''):'0.00'; ?>" name="bp_ssi">
                                          </div>
                                       </td>
                                    </tr>
                                    <tr>
                                       <td>Court-ordered child support that you receive for minor and/or dependent child(ren) NOT of the marriage or relationship</td>
                                       <td>
                                          <div class="input_field_wrapper currency_start">
                                             <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="currency" type="number" placeholder="0.00" value="<?php echo isset($postData['tp_child_support_received_NoM'])?number_format((float)$postData['tp_child_support_received_NoM'], 2, '.', ''):'0.00'; ?>" name="tp_child_support_received_NoM">
                                          </div>
                                       </td>
                                       <td>
                                          <div class="input_field_wrapper currency_start">
                                             <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="currency" type="number" placeholder="0.00" value="<?php echo isset($postData['bp_child_support_received_NoM'])?number_format((float)$postData['bp_child_support_received_NoM'], 2, '.', ''):'0.00'; ?>" name="bp_child_support_received_NoM">
                                          </div>
                                       </td>
                                    </tr>
                                    <tr>
                                       <td class="Cell_heading" colspan="5">
                                          <h2 class="recordInner_heading">III. Children and Household Residents</h2>
                                       </td>
                                    </tr>
                                    <tr>
                                       <td class="p-0" colspan="3">
                                          <table width="100%" class="annual-income">
                                             <tbody>
                                                <tr class="last-tr">
                                                   <td>
                                                      Number of Minor and/or dependent child(ren) adopted or born from this marriage or relationship
                                                   </td>
                                                   <td>
                                                      <div class="input_field_wrapper textcenter">
                                                        <input type="number" class="d-none" id="selected_num_minordependent_children_this_marriage" data-onload="handleNumMinorDeoChildOnLoad(this)" value="<?php echo isset($postData['num_minordependent_children_this_marriage'])? $postData['num_minordependent_children_this_marriage']:''; ?>" style="display: none;">
                                                         <select class="test county-select" name="num_minordependent_children_this_marriage" id="num_minordependent_children_this_marriage" style="font-size: 16px;" onchange="handleNumMinorDeoChildChange(this)">
                                                            <option value="0">None</option>
                                                            <option value="1">1</option>
                                                            <option value="2">2</option>
                                                            <option value="3">3</option>
                                                            <option value="4">4</option>
                                                            <option value="5">5</option>
                                                            <option value="6">6</option>
                                                            <option value="7">7</option>
                                                            <option value="8">8</option>
                                                         </select>
                                                      </div>
                                                   </td>
                                                </tr>
                                             </tbody>
                                          </table>
                                       </td>
                                    </tr>
                                    <tr>
                                       <td class="border-bottom-0 p-0" colspan="3">
                                          <table width="100%" class="annual-income">
                                             <tbody>
                                                <tr>
                                                   <th class="textcenter">Name</th>
                                                   <th class="textcenter">Date of Birth</th>
                                                   <th>Living with </th>
                                                </tr>
                                                <tr>
                                                   <td>
                                                      <div class="input_field_wrapper">
                                                         <input class="textcenter minordependent_child1_inputs" type="text" name="minordependent_fullname1" placeholder="[Full Name1]" value="<?php echo isset($postData['minordependent_fullname1'])? $postData['minordependent_fullname1']:''; ?>" readonly="">
                                                      </div>
                                                   </td>
                                                   <td>
                                                      <div class="input_field_wrapper">
                                                         <input class="textcenter hasDatepickerPast minordependent_child1_inputs" type="text" placeholder="mm/dd/yyyy" value="<?php echo isset($postData['minordependent_birth_date1'])? date("m/d/Y", strtotime($postData['minordependent_birth_date1'])):''; ?>" name="minordependent_birth_date1" readonly="">
                                                      </div>
                                                   </td>
                                                   <td>
                                                      <div class="input_field_wrapper_checkbox">
                                                         <input type="radio" class="es_checkbox minordependent_child1_inputs_radio minordependent_livingwith_top_party" value="top_party" name="minordependent_livingwith1" id="minordependent_livingwith1_top_party" disabled="" onclick="handleMinorDepLivWithOtherChange(this, '1');" <?php echo ((isset($postData['minordependent_livingwith1'])) && ($postData['minordependent_livingwith1'] == $postData['topparty_name'])) ? 'checked' : ''; ?>>
                                                         <label class="mb-0"><span class="topparty_name_span">TPName</span> </label>
                                                      </div>
                                                      <div class="input_field_wrapper_checkbox">
                                                         <input type="radio" class="es_checkbox minordependent_child1_inputs_radio minordependent_livingwith_bottom_party" value="bottom_party" name="minordependent_livingwith1" id="minordependent_livingwith1_bottom_party" disabled="" onclick="handleMinorDepLivWithOtherChange(this, '1');" <?php echo ((isset($postData['minordependent_livingwith1'])) && ($postData['minordependent_livingwith1'] == $postData['bottomparty_name'])) ? 'checked' : ''; ?>>
                                                         <label class="mb-0"><span class="bottomparty_name_span">BPName</span>  </label>
                                                      </div>
                                                      <div class="input_field_wrapper_checkbox">
                                                         <input type="radio" class="es_checkbox minordependent_child1_inputs_radio" value="other" name="minordependent_livingwith1" disabled="" onclick="handleMinorDepLivWithOtherChange(this, '1');" <?php echo ((isset($postData['minordependent_livingwith1'])) && ($postData['minordependent_livingwith1'] == 'other')) ? 'checked' : ''; ?>>
                                                         <label class="mb-0">Other  </label>
                                                         <br>
                                                         <div class="input_field_wrapper minordependent_livingwith_other_div1" style="display: none;">
                                                              <input class="textcenter minordependent_child1_inputs" type="text" id="minordependent_livingwith_other1" name="minordependent_livingwith_other1" placeholder="Enter Name" value="<?php echo isset($postData['minordependent_livingwith_other1'])? $postData['minordependent_livingwith_other1']:''; ?>">
                                                           </div>
                                                      </div>
                                                   </td>
                                                </tr>
                                                <tr>
                                                   <td>
                                                      <div class="input_field_wrapper">
                                                         <input class="textcenter minordependent_child2_inputs" type="text" name="minordependent_fullname2" placeholder="[Full Name2]" value="<?php echo isset($postData['minordependent_fullname2'])? $postData['minordependent_fullname2']:''; ?>" readonly="">
                                                      </div>
                                                   </td>
                                                   <td>
                                                      <div class="input_field_wrapper">
                                                         <input class="textcenter hasDatepickerPast minordependent_child2_inputs" type="text" placeholder="mm/dd/yyyy" value="<?php echo isset($postData['minordependent_birth_date2'])? date("m/d/Y", strtotime($postData['minordependent_birth_date2'])):''; ?>" name="minordependent_birth_date2" readonly="">
                                                      </div>
                                                   </td>
                                                   <td>
                                                      <div class="input_field_wrapper_checkbox">
                                                         <input type="radio" class="es_checkbox minordependent_child2_inputs_radio minordependent_livingwith_top_party" value="top_party" name="minordependent_livingwith2" id="minordependent_livingwith2_top_party" disabled="" onclick="handleMinorDepLivWithOtherChange(this, '2');" <?php echo ((isset($postData['minordependent_livingwith2'])) && ($postData['minordependent_livingwith2'] == $postData['topparty_name'])) ? 'checked' : ''; ?>>
                                                         <label class="mb-0"><span class="topparty_name_span">TPName</span> </label>
                                                      </div>
                                                      <div class="input_field_wrapper_checkbox">
                                                         <input type="radio" class="es_checkbox minordependent_child2_inputs_radio minordependent_livingwith_bottom_party" value="bottom_party" name="minordependent_livingwith2" id="minordependent_livingwith2_bottom_party" disabled="" onclick="handleMinorDepLivWithOtherChange(this, '2');" <?php echo ((isset($postData['minordependent_livingwith2'])) && ($postData['minordependent_livingwith2'] == $postData['bottomparty_name'])) ? 'checked' : ''; ?>>
                                                         <label class="mb-0"><span class="bottomparty_name_span">BPName</span>  </label>
                                                      </div>
                                                      <div class="input_field_wrapper_checkbox">
                                                         <input type="radio" class="es_checkbox minordependent_child2_inputs_radio" value="other" name="minordependent_livingwith2" disabled="" onclick="handleMinorDepLivWithOtherChange(this, '2');" <?php echo ((isset($postData['minordependent_livingwith2'])) && ($postData['minordependent_livingwith2'] == 'other')) ? 'checked' : ''; ?>>
                                                         <label class="mb-0">Other  </label>
                                                            <br>
                                                            <div class="input_field_wrapper minordependent_livingwith_other_div2" style="display: none;">
                                                              <input class="textcenter minordependent_child2_inputs" type="text" id="minordependent_livingwith_other2" name="minordependent_livingwith_other2" placeholder="Enter Name" value="<?php echo isset($postData['minordependent_livingwith_other2'])? $postData['minordependent_livingwith_other2']:''; ?>">
                                                            </div>
                                                      </div>
                                                   </td>
                                                </tr>
                                                <tr>
                                                   <td>
                                                      <div class="input_field_wrapper">
                                                         <input class="textcenter minordependent_child3_inputs" type="text" name="minordependent_fullname3" placeholder="[Full Name3]" value="<?php echo isset($postData['minordependent_fullname3'])? $postData['minordependent_fullname3']:''; ?>" readonly="">
                                                      </div>
                                                   </td>
                                                   <td>
                                                      <div class="input_field_wrapper">
                                                         <input class="textcenter hasDatepickerPast minordependent_child3_inputs" type="text" placeholder="mm/dd/yyyy" value="<?php echo isset($postData['minordependent_birth_date3'])? date("m/d/Y", strtotime($postData['minordependent_birth_date3'])):''; ?>" name="minordependent_birth_date3" readonly="">
                                                      </div>
                                                   </td>
                                                   <td>
                                                      <div class="input_field_wrapper_checkbox">
                                                         <input type="radio" class="es_checkbox minordependent_child3_inputs_radio minordependent_livingwith_top_party" value="top_party" name="minordependent_livingwith3" id="minordependent_livingwith3_top_party" disabled="" onclick="handleMinorDepLivWithOtherChange(this, '3');" <?php echo ((isset($postData['minordependent_livingwith3'])) && ($postData['minordependent_livingwith3'] == $postData['topparty_name'])) ? 'checked' : ''; ?>>
                                                         <label class="mb-0"><span class="topparty_name_span">TPName</span> </label>
                                                      </div>
                                                      <div class="input_field_wrapper_checkbox">
                                                         <input type="radio" class="es_checkbox minordependent_child3_inputs_radio minordependent_livingwith_bottom_party" value="bottom_party" name="minordependent_livingwith3" id="minordependent_livingwith3_bottom_party" disabled="" onclick="handleMinorDepLivWithOtherChange(this, '3');" <?php echo ((isset($postData['minordependent_livingwith3'])) && ($postData['minordependent_livingwith3'] == $postData['bottomparty_name'])) ? 'checked' : ''; ?>>
                                                         <label class="mb-0"><span class="bottomparty_name_span">BPName</span>  </label>
                                                      </div>
                                                      <div class="input_field_wrapper_checkbox">
                                                         <input type="radio" class="es_checkbox minordependent_child3_inputs_radio" value="other" name="minordependent_livingwith3" disabled="" onclick="handleMinorDepLivWithOtherChange(this, '3');" <?php echo ((isset($postData['minordependent_livingwith3'])) && ($postData['minordependent_livingwith3'] == 'other')) ? 'checked' : ''; ?>>
                                                         <label class="mb-0">Other  </label>
                                                            <br>
                                                            <div class="input_field_wrapper minordependent_livingwith_other_div3" style="display: none;">
                                                              <input class="textcenter minordependent_child3_inputs" type="text" id="minordependent_livingwith_other3" name="minordependent_livingwith_other3" placeholder="Enter Name" value="<?php echo isset($postData['minordependent_livingwith_other3'])? $postData['minordependent_livingwith_other3']:''; ?>">
                                                            </div>
                                                      </div>
                                                   </td>
                                                </tr>
                                                <tr>
                                                   <td>
                                                      <div class="input_field_wrapper">
                                                         <input class="textcenter minordependent_child4_inputs" type="text" name="minordependent_fullname4" placeholder="[Full Name4]" value="<?php echo isset($postData['minordependent_fullname4'])? $postData['minordependent_fullname4']:''; ?>" readonly="">
                                                      </div>
                                                   </td>
                                                   <td>
                                                      <div class="input_field_wrapper">
                                                         <input class="textcenter hasDatepickerPast minordependent_child4_inputs" type="text" placeholder="mm/dd/yyyy" value="<?php echo isset($postData['minordependent_birth_date4'])? date("m/d/Y", strtotime($postData['minordependent_birth_date4'])):''; ?>" name="minordependent_birth_date4" readonly="">
                                                      </div>
                                                   </td>
                                                   <td>
                                                      <div class="input_field_wrapper_checkbox">
                                                         <input type="radio" class="es_checkbox minordependent_child4_inputs_radio minordependent_livingwith_top_party" value="top_party" name="minordependent_livingwith4" id="minordependent_livingwith4_top_party" disabled="" onclick="handleMinorDepLivWithOtherChange(this, '4');" <?php echo ((isset($postData['minordependent_livingwith4'])) && ($postData['minordependent_livingwith4'] == $postData['topparty_name'])) ? 'checked' : ''; ?>>
                                                         <label class="mb-0"><span class="topparty_name_span">TPName</span> </label>
                                                      </div>
                                                      <div class="input_field_wrapper_checkbox">
                                                         <input type="radio" class="es_checkbox minordependent_child4_inputs_radio minordependent_livingwith_bottom_party" value="bottom_party" name="minordependent_livingwith4" id="minordependent_livingwith4_bottom_party" disabled="" onclick="handleMinorDepLivWithOtherChange(this, '4');" <?php echo ((isset($postData['minordependent_livingwith4'])) && ($postData['minordependent_livingwith4'] == $postData['bottomparty_name'])) ? 'checked' : ''; ?>>
                                                         <label class="mb-0"><span class="bottomparty_name_span">BPName</span>  </label>
                                                      </div>
                                                      <div class="input_field_wrapper_checkbox">
                                                         <input type="radio" class="es_checkbox minordependent_child4_inputs_radio" value="other" name="minordependent_livingwith4" disabled="" onclick="handleMinorDepLivWithOtherChange(this, '4');" <?php echo ((isset($postData['minordependent_livingwith4'])) && ($postData['minordependent_livingwith4'] == 'other')) ? 'checked' : ''; ?>>
                                                         <label class="mb-0">Other  </label>
                                                            <br>
                                                            <div class="input_field_wrapper minordependent_livingwith_other_div4" style="display: none;">
                                                              <input class="textcenter minordependent_child4_inputs" type="text" id="minordependent_livingwith_other4" name="minordependent_livingwith_other4" placeholder="Enter Name" value="<?php echo isset($postData['minordependent_fullname1'])? $postData['minordependent_fullname1']:''; ?>">
                                                            </div>
                                                      </div>
                                                   </td>
                                                </tr>
                                                <tr>
                                                   <td>
                                                      <div class="input_field_wrapper">
                                                         <input class="textcenter minordependent_child5_inputs" type="text" name="minordependent_fullname5" placeholder="[Full Name5]" value="<?php echo isset($postData['minordependent_fullname5'])? $postData['minordependent_fullname5']:''; ?>" readonly="">
                                                      </div>
                                                   </td>
                                                   <td>
                                                      <div class="input_field_wrapper">
                                                         <input class="textcenter hasDatepickerPast minordependent_child5_inputs" type="text" placeholder="mm/dd/yyyy" value="<?php echo isset($postData['minordependent_birth_date5'])? date("m/d/Y", strtotime($postData['minordependent_birth_date5'])):''; ?>" name="minordependent_birth_date5" readonly="">
                                                      </div>
                                                   </td>
                                                   <td>
                                                      <div class="input_field_wrapper_checkbox">
                                                         <input type="radio" class="es_checkbox minordependent_child5_inputs_radio minordependent_livingwith_top_party" value="top_party" name="minordependent_livingwith5" id="minordependent_livingwith5_top_party" disabled="" onclick="handleMinorDepLivWithOtherChange(this, '5');" <?php echo ((isset($postData['minordependent_livingwith5'])) && ($postData['minordependent_livingwith5'] == $postData['topparty_name'])) ? 'checked' : ''; ?>>
                                                         <label class="mb-0"><span class="topparty_name_span">TPName</span> </label>
                                                      </div>
                                                      <div class="input_field_wrapper_checkbox">
                                                         <input type="radio" class="es_checkbox minordependent_child5_inputs_radio minordependent_livingwith_bottom_party" value="bottom_party" name="minordependent_livingwith5" id="minordependent_livingwith5_bottom_party" disabled="" onclick="handleMinorDepLivWithOtherChange(this, '5');" <?php echo ((isset($postData['minordependent_livingwith5'])) && ($postData['minordependent_livingwith5'] == $postData['bottomparty_name'])) ? 'checked' : ''; ?>>
                                                         <label class="mb-0"><span class="bottomparty_name_span">BPName</span>  </label>
                                                      </div>
                                                      <div class="input_field_wrapper_checkbox">
                                                         <input type="radio" class="es_checkbox minordependent_child5_inputs_radio" value="other" name="minordependent_livingwith5" disabled="" onclick="handleMinorDepLivWithOtherChange(this, '5');" <?php echo ((isset($postData['minordependent_livingwith5'])) && ($postData['minordependent_livingwith5'] == 'other')) ? 'checked' : ''; ?>>
                                                         <label class="mb-0">Other  </label>
                                                            <br>
                                                            <div class="input_field_wrapper minordependent_livingwith_other_div5" style="display: none;">
                                                              <input class="textcenter minordependent_child5_inputs" type="text" id="minordependent_livingwith_other5" name="minordependent_livingwith_other5" placeholder="Enter Name" value="<?php echo isset($postData['minordependent_livingwith_other5'])? $postData['minordependent_livingwith_other5']:''; ?>">
                                                            </div>
                                                      </div>
                                                   </td>
                                                </tr>
                                                <tr>
                                                   <td>
                                                      <div class="input_field_wrapper">
                                                         <input class="textcenter minordependent_child6_inputs" type="text" name="minordependent_fullname6" placeholder="[Full Name6]" value="<?php echo isset($postData['minordependent_fullname6'])? $postData['minordependent_fullname6']:''; ?>" readonly="">
                                                      </div>
                                                   </td>
                                                   <td>
                                                      <div class="input_field_wrapper">
                                                         <input class="textcenter hasDatepickerPast minordependent_child6_inputs" type="text" placeholder="mm/dd/yyyy" value="<?php echo isset($postData['minordependent_birth_date6'])? date("m/d/Y", strtotime($postData['minordependent_birth_date6'])):''; ?>" name="minordependent_birth_date6" readonly="">
                                                      </div>
                                                   </td>
                                                   <td>
                                                      <div class="input_field_wrapper_checkbox">
                                                         <input type="radio" class="es_checkbox minordependent_child6_inputs_radio minordependent_livingwith_top_party" value="top_party" name="minordependent_livingwith6" id="minordependent_livingwith6_top_party" disabled="" onclick="handleMinorDepLivWithOtherChange(this, '6');" <?php echo ((isset($postData['minordependent_livingwith6'])) && ($postData['minordependent_livingwith6'] == $postData['topparty_name'])) ? 'checked' : ''; ?>>
                                                         <label class="mb-0"><span class="topparty_name_span">TPName</span> </label>
                                                      </div>
                                                      <div class="input_field_wrapper_checkbox">
                                                         <input type="radio" class="es_checkbox minordependent_child6_inputs_radio minordependent_livingwith_bottom_party" value="bottom_party" name="minordependent_livingwith6" id="minordependent_livingwith6_bottom_party" disabled="" onclick="handleMinorDepLivWithOtherChange(this, '6');" <?php echo ((isset($postData['minordependent_livingwith6'])) && ($postData['minordependent_livingwith6'] == $postData['bottomparty_name'])) ? 'checked' : ''; ?>>
                                                         <label class="mb-0"><span class="bottomparty_name_span">BPName</span>  </label>
                                                      </div>
                                                      <div class="input_field_wrapper_checkbox">
                                                         <input type="radio" class="es_checkbox minordependent_child6_inputs_radio" value="other" name="minordependent_livingwith6" disabled="" onclick="handleMinorDepLivWithOtherChange(this, '6');" <?php echo ((isset($postData['minordependent_livingwith6'])) && ($postData['minordependent_livingwith6'] == 'other')) ? 'checked' : ''; ?>>
                                                         <label class="mb-0">Other  </label>
                                                            <br>
                                                            <div class="input_field_wrapper minordependent_livingwith_other_div6" style="display: none;">
                                                              <input class="textcenter minordependent_child6_inputs" type="text" id="minordependent_livingwith_other6" name="minordependent_livingwith_other6" placeholder="Enter Name" value="<?php echo isset($postData['minordependent_livingwith_other6'])? $postData['minordependent_livingwith_other6']:''; ?>">
                                                            </div>
                                                      </div>
                                                   </td>
                                                </tr>
                                                <tr>
                                                   <td>
                                                      <div class="input_field_wrapper">
                                                         <input class="textcenter minordependent_child7_inputs" type="text" name="minordependent_fullname7" placeholder="[Full Name7]" value="<?php echo isset($postData['minordependent_fullname7'])? $postData['minordependent_fullname7']:''; ?>" readonly="">
                                                      </div>
                                                   </td>
                                                   <td>
                                                      <div class="input_field_wrapper">
                                                         <input class="textcenter hasDatepickerPast minordependent_child7_inputs" type="text" placeholder="mm/dd/yyyy" value="<?php echo isset($postData['minordependent_birth_date7'])? date("m/d/Y", strtotime($postData['minordependent_birth_date7'])):''; ?>" name="minordependent_birth_date7" readonly="">
                                                      </div>
                                                   </td>
                                                   <td>
                                                      <div class="input_field_wrapper_checkbox">
                                                         <input type="radio" class="es_checkbox minordependent_child7_inputs_radio minordependent_livingwith_top_party" value="top_party" name="minordependent_livingwith7" id="minordependent_livingwith7_top_party" disabled="" onclick="handleMinorDepLivWithOtherChange(this, '7');" <?php echo ((isset($postData['minordependent_livingwith7'])) && ($postData['minordependent_livingwith7'] == $postData['topparty_name'])) ? 'checked' : ''; ?>>
                                                         <label class="mb-0"><span class="topparty_name_span">TPName</span> </label>
                                                      </div>
                                                      <div class="input_field_wrapper_checkbox">
                                                         <input type="radio" class="es_checkbox minordependent_child7_inputs_radio minordependent_livingwith_bottom_party" value="bottom_party" name="minordependent_livingwith7" id="minordependent_livingwith7_bottom_party" disabled="" onclick="handleMinorDepLivWithOtherChange(this, '7');" <?php echo ((isset($postData['minordependent_livingwith7'])) && ($postData['minordependent_livingwith7'] == $postData['bottomparty_name'])) ? 'checked' : ''; ?>>
                                                         <label class="mb-0"><span class="bottomparty_name_span">BPName</span>  </label>
                                                      </div>
                                                      <div class="input_field_wrapper_checkbox">
                                                         <input type="radio" class="es_checkbox minordependent_child7_inputs_radio" value="other" name="minordependent_livingwith7" disabled="" onclick="handleMinorDepLivWithOtherChange(this, '7');" <?php echo ((isset($postData['minordependent_livingwith7'])) && ($postData['minordependent_livingwith7'] == 'other')) ? 'checked' : ''; ?>>
                                                         <label class="mb-0">Other  </label>
                                                            <br>
                                                            <div class="input_field_wrapper minordependent_livingwith_other_div7" style="display: none;">
                                                              <input class="textcenter minordependent_child7_inputs" type="text" id="minordependent_livingwith_other7" name="minordependent_livingwith_other7" placeholder="Enter Name" value="<?php echo isset($postData['minordependent_livingwith_other7'])? $postData['minordependent_livingwith_other7']:''; ?>">
                                                            </div>
                                                      </div>
                                                   </td>
                                                </tr>
                                                <tr>
                                                   <td>
                                                      <div class="input_field_wrapper">
                                                         <input class="textcenter minordependent_child8_inputs" type="text" name="minordependent_fullname8" placeholder="[Full Name8]" value="<?php echo isset($postData['minordependent_fullname8'])? $postData['minordependent_fullname8']:''; ?>" readonly="">
                                                      </div>
                                                   </td>
                                                   <td>
                                                      <div class="input_field_wrapper">
                                                         <input class="textcenter hasDatepickerPast minordependent_child8_inputs" type="text" placeholder="mm/dd/yyyy" value="<?php echo isset($postData['minordependent_birth_date8'])? date("m/d/Y", strtotime($postData['minordependent_birth_date8'])):''; ?>" name="minordependent_birth_date8" readonly="">
                                                      </div>
                                                   </td>
                                                   <td>
                                                      <div class="input_field_wrapper_checkbox">
                                                         <input type="radio" class="es_checkbox minordependent_child8_inputs_radio minordependent_livingwith_top_party" value="top_party" name="minordependent_livingwith8" id="minordependent_livingwith8_top_party" disabled="" onclick="handleMinorDepLivWithOtherChange(this, '8');" <?php echo ((isset($postData['minordependent_livingwith8'])) && ($postData['minordependent_livingwith8'] == $postData['topparty_name'])) ? 'checked' : ''; ?>>
                                                         <label class="mb-0"><span class="topparty_name_span">TPName</span> </label>
                                                      </div>
                                                      <div class="input_field_wrapper_checkbox">
                                                         <input type="radio" class="es_checkbox minordependent_child8_inputs_radio minordependent_livingwith_bottom_party" value="bottom_party" name="minordependent_livingwith8" id="minordependent_livingwith8_bottom_party" disabled="" onclick="handleMinorDepLivWithOtherChange(this, '8');" <?php echo ((isset($postData['minordependent_livingwith8'])) && ($postData['minordependent_livingwith8'] == $postData['bottomparty_name'])) ? 'checked' : ''; ?>>
                                                         <label class="mb-0"><span class="bottomparty_name_span">BPName</span>  </label>
                                                      </div>
                                                      <div class="input_field_wrapper_checkbox">
                                                         <input type="radio" class="es_checkbox minordependent_child8_inputs_radio" value="other" name="minordependent_livingwith8" disabled="" onclick="handleMinorDepLivWithOtherChange(this, '8');" <?php echo ((isset($postData['minordependent_livingwith8'])) && ($postData['minordependent_livingwith8'] == 'other')) ? 'checked' : ''; ?>>
                                                         <label class="mb-0">Other  </label>
                                                            <br>
                                                            <div class="input_field_wrapper minordependent_livingwith_other_div8" style="display: none;">
                                                              <input class="textcenter minordependent_child8_inputs" type="text" id="minordependent_livingwith_other8" name="minordependent_livingwith_other8" placeholder="Enter Name" value="<?php echo isset($postData['minordependent_livingwith_other8'])? $postData['minordependent_livingwith_other8']:''; ?>">
                                                            </div>
                                                      </div>
                                                   </td>
                                                </tr>
                                             </tbody>
                                          </table>
                                       </td>
                                    </tr>
                                    <tr>
                                       <td colspan="5">In addition to the above child(ren):</td>
                                    </tr>
                                    <tr>
                                       <td class="p-0 border-bottom-0" colspan="5">
                                          <table width="100%" class="annual-income">
                                             <tbody>
                                                <tr>
                                                   <td class="p-0">
                                                      <table width="100%" class="annual-income">
                                                         <tbody>
                                                            <tr class="last-tr">
                                                               <td><span class="topparty_role_span">Plaintiff</span>, <span class="topparty_name_span">Top Party FullName</span> has other minor biological or adopted child(ren)</td>
                                                               <td>
                                                                  <div class="input_field_wrapper textcenter">
                                                                     <select class="test county-select" name="tp_num_children_NoM" style="font-size: 16px;">
                                                                        <option value="0" <?php echo ((isset($postData['tp_num_children_NoM'])) && ($postData['tp_num_children_NoM'] == '0')) ? 'selected' : ''; ?>>None</option>
                                                                        <option value="1" <?php echo ((isset($postData['tp_num_children_NoM'])) && ($postData['tp_num_children_NoM'] == '1')) ? 'selected' : ''; ?>>1</option>
                                                                        <option value="2" <?php echo ((isset($postData['tp_num_children_NoM'])) && ($postData['tp_num_children_NoM'] == '2')) ? 'selected' : ''; ?>>2</option>
                                                                        <option value="3" <?php echo ((isset($postData['tp_num_children_NoM'])) && ($postData['tp_num_children_NoM'] == '3')) ? 'selected' : ''; ?>>3</option>
                                                                        <option value="4" <?php echo ((isset($postData['tp_num_children_NoM'])) && ($postData['tp_num_children_NoM'] == '4')) ? 'selected' : ''; ?>>4</option>
                                                                        <option value="5" <?php echo ((isset($postData['tp_num_children_NoM'])) && ($postData['tp_num_children_NoM'] == '5')) ? 'selected' : ''; ?>>5</option>
                                                                     </select>
                                                                  </div>
                                                               </td>
                                                            </tr>
                                                         </tbody>
                                                      </table>
                                                   </td>
                                                   <td class="p-0">
                                                      <table width="100%" class="annual-income">
                                                         <tbody>
                                                            <tr class="last-tr">
                                                               <td><span class="bottomparty_role_span">Defendant</span>, <span class="bottomparty_name_span">Bottom Party FullName</span> has other minor biological or adopted child(ren)</td>
                                                               <td>
                                                                  <div class="input_field_wrapper textcenter">
                                                                     <select class="test county-select" name="bp_num_children_NoM" style="font-size: 16px;">
                                                                        <option value="0" <?php echo ((isset($postData['bp_num_children_NoM'])) && ($postData['bp_num_children_NoM'] == '0')) ? 'selected' : ''; ?>>None</option>
                                                                        <option value="1" <?php echo ((isset($postData['bp_num_children_NoM'])) && ($postData['bp_num_children_NoM'] == '1')) ? 'selected' : ''; ?>>1</option>
                                                                        <option value="2" <?php echo ((isset($postData['bp_num_children_NoM'])) && ($postData['bp_num_children_NoM'] == '2')) ? 'selected' : ''; ?>>2</option>
                                                                        <option value="3" <?php echo ((isset($postData['bp_num_children_NoM'])) && ($postData['bp_num_children_NoM'] == '3')) ? 'selected' : ''; ?>>3</option>
                                                                        <option value="4" <?php echo ((isset($postData['bp_num_children_NoM'])) && ($postData['bp_num_children_NoM'] == '4')) ? 'selected' : ''; ?>>4</option>
                                                                        <option value="5" <?php echo ((isset($postData['bp_num_children_NoM'])) && ($postData['bp_num_children_NoM'] == '5')) ? 'selected' : ''; ?>>5</option>
                                                                     </select>
                                                                  </div>
                                                               </td>
                                                            </tr>
                                                         </tbody>
                                                      </table>
                                                   </td>
                                                </tr>
                                             </tbody>
                                          </table>
                                       </td>
                                    </tr>
                                    <tr>
                                       <td class="p-0" colspan="5">
                                          <table class="annual-income" width="100%">
                                             <tbody>
                                                <tr class="last-tr">
                                                   <td>There is/are adult(s) in your household.</td>
                                                   <td>
                                                      <div class="input_field_wrapper textcenter">
                                                         <select class="test county-select" name="aff_party_num_adults_in_household" style="font-size: 16px;">
                                                            <option value="0" <?php echo ((isset($postData['aff_party_num_adults_in_household'])) && ($postData['aff_party_num_adults_in_household'] == '0')) ? 'selected' : ''; ?>>None</option>
                                                            <option value="1" <?php echo ((isset($postData['aff_party_num_adults_in_household'])) && ($postData['aff_party_num_adults_in_household'] == '1')) ? 'selected' : ''; ?>>1</option>
                                                            <option value="2" <?php echo ((isset($postData['aff_party_num_adults_in_household'])) && ($postData['aff_party_num_adults_in_household'] == '2')) ? 'selected' : ''; ?>>2</option>
                                                            <option value="3" <?php echo ((isset($postData['aff_party_num_adults_in_household'])) && ($postData['aff_party_num_adults_in_household'] == '3')) ? 'selected' : ''; ?>>3</option>
                                                            <option value="4" <?php echo ((isset($postData['aff_party_num_adults_in_household'])) && ($postData['aff_party_num_adults_in_household'] == '4')) ? 'selected' : ''; ?>>4</option>
                                                            <option value="5" <?php echo ((isset($postData['aff_party_num_adults_in_household'])) && ($postData['aff_party_num_adults_in_household'] == '5')) ? 'selected' : ''; ?>>5</option>
                                                         </select>
                                                      </div>
                                                   </td>
                                                </tr>
                                             </tbody>
                                          </table>
                                       </td>
                                    </tr>
                                    <tr>
                                       <td class="Cell_heading" colspan="5">
                                          <h2 class="recordInner_heading">IV. Expenses</h2>
                                       </td>
                                    </tr>
                                    <tr>
                                       <td colspan="5">
                                          List monthly expenses below for your present household. <br>
                                          <strong>A. Monthly Housing Expenses </strong>
                                       </td>
                                    </tr>
                                    <tr>
                                       <td class="p-0 border-bottom-0" colspan="5">
                                          <table class="annual-income" width="100%">
                                             <tbody>
                                                <tr>
                                                   <td> Rent or first mortgage (including taxes and insurance) </td>
                                                   <td>
                                                      <div class="input_field_wrapper currency_start">
                                                         <input  data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="currency" type="number" placeholder="0.00" value="<?php echo isset($postData['monthly_housing_rent_first_mortgage_inc_tax_ins'])?number_format((float)$postData['monthly_housing_rent_first_mortgage_inc_tax_ins'], 2, '.', ''):'0.00'; ?>" name="monthly_housing_rent_first_mortgage_inc_tax_ins" id="monthly_housing_rent_first_mortgage_inc_tax_ins">
                                                      </div>
                                                   </td>
                                                </tr>
                                                <tr>
                                                   <td>Second mortgage/equity line of credit</td>
                                                   <td>
                                                      <div class="input_field_wrapper currency_start">
                                                         <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="currency" type="number" placeholder="0.00" value="<?php echo isset($postData['monthly_housing_second_mort_heloc'])?number_format((float)$postData['monthly_housing_second_mort_heloc'], 2, '.', ''):'0.00'; ?>" name="monthly_housing_second_mort_heloc" id="monthly_housing_second_mort_heloc">
                                                      </div>
                                                   </td>
                                                </tr>
                                                <tr>
                                                   <td>Real estate taxes (if not included above)</td>
                                                   <td>
                                                      <div class="input_field_wrapper currency_start">
                                                         <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="currency" type="number" placeholder="0.00" value="<?php echo isset($postData['monthly_housing_re_taxes'])?number_format((float)$postData['monthly_housing_re_taxes'], 2, '.', ''):'0.00'; ?>" name="monthly_housing_re_taxes" id="monthly_housing_re_taxes">
                                                      </div>
                                                   </td>
                                                </tr>
                                                <tr>
                                                   <td>Renter or homeowner's insurance (if not included above)</td>
                                                   <td>
                                                      <div class="input_field_wrapper currency_start">
                                                         <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="currency" type="number" placeholder="0.00" value="<?php echo isset($postData['monthly_housing_renter_homeowner_insurance'])?number_format((float)$postData['monthly_housing_renter_homeowner_insurance'], 2, '.', ''):'0.00'; ?>" name="monthly_housing_renter_homeowner_insurance" id="monthly_housing_renter_homeowner_insurance">
                                                      </div>
                                                   </td>
                                                </tr>
                                                <tr>
                                                   <td>Homeowner or condominium association fee</td>
                                                   <td>
                                                      <div class="input_field_wrapper currency_start">
                                                         <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="currency" type="number" placeholder="0.00" value="<?php echo isset($postData['monthly_housing_hoa_fee'])?number_format((float)$postData['monthly_housing_hoa_fee'], 2, '.', ''):'0.00'; ?>" name="monthly_housing_hoa_fee" id="monthly_housing_hoa_fee">
                                                      </div>
                                                   </td>
                                                </tr>
                                                <tr>
                                                   <td>
                                                      <p class="mb-1">Utilities</p>
                                                      <div class="input_field_wrapper mt-2 pl-2">
                                                         <p class="mb-1">Electric </p>
                                                         <p class="mb-1">Gas, fuel oil, propane </p>
                                                         <p class="mb-1">Water and sewer </p>
                                                         <p class="mb-1">Telephone and/or cell phone </p>
                                                         <p class="mb-1">Trash collection </p>
                                                         <p class="mb-1">Cable/satellite television </p>
                                                         <p class="mb-1">Internet service</p>
                                                      </div>
                                                   </td>
                                                   <td>
                                                      <div class="input_field_wrapper currency_start mt-2 mb-1">
                                                         <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="currency" type="number" placeholder="0.00" value="<?php echo isset($postData['monthly_housing_electric'])?number_format((float)$postData['monthly_housing_electric'], 2, '.', ''):'0.00'; ?>" name="monthly_housing_electric" id="monthly_housing_electric">
                                                      </div>
                                                      <div class="divider"></div>
                                                      <div class="input_field_wrapper currency_start mb-1">
                                                         <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="currency" type="number" placeholder="0.00" value="<?php echo isset($postData['monthly_housing_gas_fueloil_propane'])?number_format((float)$postData['monthly_housing_gas_fueloil_propane'], 2, '.', ''):'0.00'; ?>" name="monthly_housing_gas_fueloil_propane" id="monthly_housing_gas_fueloil_propane">
                                                      </div>
                                                      <div class="divider"></div>
                                                      <div class="input_field_wrapper currency_start mb-1">
                                                         <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="currency" type="number" placeholder="0.00" value="<?php echo isset($postData['monthly_housing_water_sewer'])?number_format((float)$postData['monthly_housing_water_sewer'], 2, '.', ''):'0.00'; ?>" name="monthly_housing_water_sewer" id="monthly_housing_water_sewer">
                                                      </div>
                                                      <div class="divider"></div>
                                                      <div class="input_field_wrapper currency_start mb-1">
                                                         <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="currency" type="number" placeholder="0.00" value="<?php echo isset($postData['monthly_housing_telephone_cellphone'])?number_format((float)$postData['monthly_housing_telephone_cellphone'], 2, '.', ''):'0.00'; ?>" name="monthly_housing_telephone_cellphone" id="monthly_housing_telephone_cellphone">
                                                      </div>
                                                      <div class="divider"></div>
                                                      <div class="input_field_wrapper currency_start mb-1">
                                                         <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="currency" type="number" placeholder="0.00" value="<?php echo isset($postData['monthly_housing_trash'])?number_format((float)$postData['monthly_housing_trash'], 2, '.', ''):'0.00'; ?>" name="monthly_housing_trash" id="monthly_housing_trash">
                                                      </div>
                                                      <div class="divider"></div>
                                                      <div class="input_field_wrapper currency_start mb-1">
                                                         <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="currency" type="number" placeholder="0.00" value="<?php echo isset($postData['monthly_housing_cable_satellite_tv'])?number_format((float)$postData['monthly_housing_cable_satellite_tv'], 2, '.', ''):'0.00'; ?>" name="monthly_housing_cable_satellite_tv" id="monthly_housing_cable_satellite_tv">
                                                      </div>
                                                      <div class="divider"></div>
                                                      <div class="input_field_wrapper currency_start">
                                                         <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="currency" type="number" placeholder="0.00" value="<?php echo isset($postData['monthly_housing_internet'])?number_format((float)$postData['monthly_housing_internet'], 2, '.', ''):'0.00'; ?>" name="monthly_housing_internet" id="monthly_housing_internet">
                                                      </div>
                                                   </td>
                                                </tr>
                                                <tr>
                                                   <td>Cleaning</td>
                                                   <td>
                                                      <div class="input_field_wrapper currency_start">
                                                         <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="currency" type="number" placeholder="0.00" value="<?php echo isset($postData['monthly_housing_cleaning'])?number_format((float)$postData['monthly_housing_cleaning'], 2, '.', ''):'0.00'; ?>" name="monthly_housing_cleaning">
                                                      </div>
                                                   </td>
                                                </tr>
                                                <tr>
                                                   <td>Lawn service and/or snow removal</td>
                                                   <td>
                                                      <div class="input_field_wrapper currency_start">
                                                         <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="currency" type="number" placeholder="0.00" value="<?php echo isset($postData['monthly_housing_lawn_snow'])?number_format((float)$postData['monthly_housing_lawn_snow'], 2, '.', ''):'0.00'; ?>" name="monthly_housing_lawn_snow">
                                                      </div>
                                                   </td>
                                                </tr>
                                                <tr>
                                                   <td>
                                                      Other:
                                                      <div class="input_field_wrapper">
                                                         <input type="text" placeholder="Enter Other Housing Expenses" value="<?php echo isset($postData['monthly_housing_other1_type'])? $postData['monthly_housing_other1_type']:''; ?>" name="monthly_housing_other1_type">
                                                      </div>
                                                   </td>
                                                   <td>
                                                      <div class="input_field_wrapper currency_start">
                                                         <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="currency" type="number" placeholder="0.00" value="<?php echo isset($postData['monthly_housing_other1'])?number_format((float)$postData['monthly_housing_other1'], 2, '.', ''):'0.00'; ?>" name="monthly_housing_other1">
                                                      </div>
                                                   </td>
                                                </tr>
                                                <tr>
                                                   <td>
                                                      Other:
                                                      <div class="input_field_wrapper">
                                                         <input type="text" placeholder="Enter Other Housing Expenses 2" value="<?php echo isset($postData['monthly_housing_other2_type'])? $postData['monthly_housing_other2_type']:''; ?>" name="monthly_housing_other2_type">
                                                      </div>
                                                   </td>
                                                   <td>
                                                      <div class="input_field_wrapper currency_start">
                                                         <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="currency" type="number" placeholder="0.00" value="<?php echo isset($postData['monthly_housing_other2'])?number_format((float)$postData['monthly_housing_other2'], 2, '.', ''):'0.00'; ?>" name="monthly_housing_other2">
                                                      </div>
                                                   </td>
                                                </tr>
                                                <tr>
                                                   <td class="text-right">
                                                      <b>TOTAL MONTHLY</b>
                                                   </td>
                                                   <td>
                                                      <div class="input_field_wrapper currency_start">
                                                         <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="currency" type="number" value="<?php echo isset($postData['total_monthly_housing'])?number_format((float)$postData['total_monthly_housing'], 2, '.', ''):'0.00'; ?>" placeholder="0.00" name="total_monthly_housing" id="total_monthly_housing" readonly="">
                                                       
                                                      </div>
                                                   </td>
                                                </tr>
                                             </tbody>
                                          </table>
                                       </td>
                                    </tr>
                                    <tr>
                                       <td class="p-0 border-bottom-0" colspan="5">
                                          <table class="annual-income" width="100%">
                                             <tbody>
                                                <tr>
                                                   <td class="p-0 border-bottom-0" colspan="5">
                                                      <table class="annual-income" width="100%">
                                                         <tbody>
                                                            <tr>
                                                               <td colspan="5">
                                                                  <strong>B. Other Monthly Living Expenses</strong>
                                                               </td>
                                                            </tr>
                                                            <tr>
                                                               <td>
                                                                  <p class="mb-1">Food</p>
                                                                  <div class="input_field_wrapper mt-2 pl-2">
                                                                     <p class="mb-1">Groceries (including food, paper, cleaning products, toiletries, and other) </p>
                                                                     <p class="mb-1">Restaurant </p>
                                                                  </div>
                                                               </td>
                                                               <td>
                                                                  <br>
                                                                  <div class="input_field_wrapper currency_start mt-2 mb-1">
                                                                     <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="currency" type="number" placeholder="0.00" value="<?php echo isset($postData['monthly_living_groceries'])?number_format((float)$postData['monthly_living_groceries'], 2, '.', ''):'0.00'; ?>" name="monthly_living_groceries">
                                                                  </div>
                                                                  <div class="divider"></div>
                                                                  <div class="input_field_wrapper currency_start mb-1">
                                                                     <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="currency" type="number" placeholder="0.00" value="<?php echo isset($postData['monthly_living_restaurant'])?number_format((float)$postData['monthly_living_restaurant'], 2, '.', ''):'0.00'; ?>" name="monthly_living_restaurant">
                                                                  </div>
                                                                  <div class="divider"></div>
                                                               </td>
                                                            </tr>
                                                            <tr>
                                                               <td>
                                                                  <p class="mb-1">Transportation</p>
                                                                  <div class="input_field_wrapper mt-2 pl-2">
                                                                     <p class="mb-1">Vehicle loan, lease </p>
                                                                     <p class="mb-1">Vehicle maintenance </p>
                                                                     <p class="mb-1">Gasoline </p>
                                                                     <p class="mb-1">Parking, public transportation </p>
                                                                  </div>
                                                               </td>
                                                               <td>
                                                                  <br>
                                                                  <div class="input_field_wrapper currency_start mt-2 mb-1">
                                                                     <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="currency" type="number" placeholder="0.00" value="<?php echo isset($postData['monthly_living_vehicle_loan_lease'])?number_format((float)$postData['monthly_living_vehicle_loan_lease'], 2, '.', ''):'0.00'; ?>" name="monthly_living_vehicle_loan_lease">
                                                                  </div>
                                                                  <div class="divider"></div>
                                                                  <div class="input_field_wrapper currency_start mb-1">
                                                                     <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="currency" type="number" placeholder="0.00" value="<?php echo isset($postData['monthly_living_vehicle_maintenance'])?number_format((float)$postData['monthly_living_vehicle_maintenance'], 2, '.', ''):'0.00'; ?>" name="monthly_living_vehicle_maintenance">
                                                                  </div>
                                                                  <div class="divider"></div>
                                                                  <div class="input_field_wrapper currency_start mb-1">
                                                                     <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="currency" type="number" placeholder="0.00" value="<?php echo isset($postData['monthly_living_vehicle_gasoline'])?number_format((float)$postData['monthly_living_vehicle_gasoline'], 2, '.', ''):'0.00'; ?>" name="monthly_living_vehicle_gasoline">
                                                                  </div>
                                                                  <div class="divider"></div>
                                                                  <div class="input_field_wrapper currency_start mb-1">
                                                                     <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="currency" type="number" placeholder="0.00" value="<?php echo isset($postData['monthly_living_vehicle_parking_pub_transportation'])?number_format((float)$postData['monthly_living_vehicle_parking_pub_transportation'], 2, '.', ''):'0.00'; ?>" name="monthly_living_vehicle_parking_pub_transportation">
                                                                  </div>
                                                                  <div class="divider"></div>
                                                               </td>
                                                            </tr>
                                                            <tr>
                                                               <td>
                                                                  <p class="mb-1">Clothing</p>
                                                                  <div class="input_field_wrapper mt-2 pl-2">
                                                                     <p class="mb-1">Clothes (other than child(ren)’s)</p>
                                                                     <p class="mb-1">Dry cleaning and laundry </p>
                                                                  </div>
                                                               </td>
                                                               <td>
                                                                  <br>
                                                                  <div class="input_field_wrapper currency_start mt-2 mb-1">
                                                                     <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="currency" type="number" placeholder="0.00" value="<?php echo isset($postData['monthly_living_clothes'])?number_format((float)$postData['monthly_living_clothes'], 2, '.', ''):'0.00'; ?>" name="monthly_living_clothes">
                                                                  </div>
                                                                  <div class="divider"></div>
                                                                  <div class="input_field_wrapper currency_start mb-1">
                                                                     <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="currency" type="number" placeholder="0.00" value="<?php echo isset($postData['monthly_living_dry_cleaning_laundry'])?number_format((float)$postData['monthly_living_dry_cleaning_laundry'], 2, '.', ''):'0.00'; ?>" name="monthly_living_dry_cleaning_laundry">
                                                                  </div>
                                                                  <div class="divider"></div>
                                                               </td>
                                                            </tr>
                                                            <tr>
                                                               <td>
                                                                  <p class="mb-1">Personal grooming</p>
                                                                  <div class="input_field_wrapper mt-2 pl-2">
                                                                     <p class="mb-1">Hair and nail care</p>
                                                                     <p class="mb-1">Other:
                                                                     <div class="input_field_wrapper">
                                                                        <input type="text" placeholder="Enter Other Personal grooming Expenses" value="<?php echo isset($postData['monthly_living_grooming_other_type'])? $postData['monthly_living_grooming_other_type']:''; ?>" name="monthly_living_grooming_other_type">
                                                                     </div>
                                                                     </p>
                                                                  </div>
                                                               </td>
                                                               <td>
                                                                  <br>
                                                                  <div class="input_field_wrapper currency_start mt-2 mb-1">
                                                                     <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="currency" type="number" placeholder="0.00" value="<?php echo isset($postData['monthly_living_hair_nail'])?number_format((float)$postData['monthly_living_hair_nail'], 2, '.', ''):'0.00'; ?>" name="monthly_living_hair_nail">
                                                                  </div>
                                                                  <div class="divider"></div>
                                                                  <div class="input_field_wrapper currency_start mb-1">
                                                                     <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="currency" type="number" placeholder="0.00" value="<?php echo isset($postData['monthly_living_grooming_other'])?number_format((float)$postData['monthly_living_grooming_other'], 2, '.', ''):'0.00'; ?>" name="monthly_living_grooming_other">
                                                                  </div>
                                                                  <div class="divider"></div>
                                                               </td>
                                                            </tr>
                                                            <tr>
                                                               <td>
                                                                  Other:
                                                                  <div class="input_field_wrapper">
                                                                     <input type="text" placeholder="Enter Other Monthly Living Expenses" value="<?php echo isset($postData['monthly_living_other_type'])? $postData['monthly_living_other_type']:''; ?>" name="monthly_living_other_type">
                                                                  </div>
                                                               </td>
                                                               <td>
                                                                  <div class="input_field_wrapper currency_start">
                                                                     <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="currency" type="number" placeholder="0.00" value="<?php echo isset($postData['monthly_living_other'])?number_format((float)$postData['monthly_living_other'], 2, '.', ''):'0.00'; ?>" name="monthly_living_other">
                                                                  </div>
                                                               </td>
                                                            </tr>
                                                            <tr>
                                                               <td class="text-right">
                                                                  <b>TOTAL MONTHLY</b>
                                                               </td>
                                                               <td>
                                                                  <div class="input_field_wrapper currency_start">
                                                                     <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="currency" type="number" value="<?php echo isset($postData['total_monthly_living'])?number_format((float)$postData['total_monthly_living'], 2, '.', ''):'0.00'; ?>" placeholder="0.00" name="total_monthly_living" readonly="">
                                                                 
                                                                  </div>
                                                               </td>
                                                            </tr>
                                                         </tbody>
                                                      </table>
                                                   </td>
                                                </tr>
                                                <tr>
                                                   <td class="p-0 border-bottom-0" colspan="5">
                                                      <table class="annual-income" width="100%">
                                                         <tbody>
                                                            <tr>
                                                               <td colspan="5">
                                                                  <strong>C. Monthly Minor Child-Related Expenses </strong><br>
                                                                  (for children of the marriage or relationship)
                                                               </td>
                                                            </tr>
                                                            <tr>
                                                               <td>Work and/or education-related child care</td>
                                                               <td>
                                                                  <div class="input_field_wrapper currency_start">
                                                                     <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="currency" type="number" placeholder="0.00" value="<?php echo isset($postData['monthly_minor_work_ed_child_care'])?number_format((float)$postData['monthly_minor_work_ed_child_care'], 2, '.', ''):'0.00'; ?>" name="monthly_minor_work_ed_child_care">
                                                                  </div>
                                                               </td>
                                                            </tr>
                                                            <tr>
                                                               <td>
                                                                  Other child care: 
                                                                  <div class="input_field_wrapper">
                                                                     <input type="text" placeholder="Enter Other Child Care Expenses" value="<?php echo isset($postData['monthly_minor_other_child_care_type'])? $postData['monthly_minor_other_child_care_type']:''; ?>" name="monthly_minor_other_child_care_type">
                                                                  </div>
                                                               </td>
                                                               <td>
                                                                  <div class="input_field_wrapper currency_start">
                                                                     <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="currency" type="number" placeholder="0.00" value="<?php echo isset($postData['monthly_minor_other_child_care'])?number_format((float)$postData['monthly_minor_other_child_care'], 2, '.', ''):'0.00'; ?>" name="monthly_minor_other_child_care">
                                                                  </div>
                                                               </td>
                                                            </tr>
                                                            <tr>
                                                               <td>Extraordinary parenting time travel cost</td>
                                                               <td>
                                                                  <div class="input_field_wrapper currency_start">
                                                                     <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="currency" type="number" placeholder="0.00" value="<?php echo isset($postData['monthly_minor_extra_travel_cost'])?number_format((float)$postData['monthly_minor_extra_travel_cost'], 2, '.', ''):'0.00'; ?>" name="monthly_minor_extra_travel_cost">
                                                                  </div>
                                                               </td>
                                                            </tr>
                                                            <tr>
                                                               <td>School tuition</td>
                                                               <td>
                                                                  <div class="input_field_wrapper currency_start">
                                                                     <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="currency" type="number" placeholder="0.00" value="<?php echo isset($postData['monthly_minor_school_tuition'])?number_format((float)$postData['monthly_minor_school_tuition'], 2, '.', ''):'0.00'; ?>" name="monthly_minor_school_tuition">
                                                                  </div>
                                                               </td>
                                                            </tr>
                                                            <tr>
                                                               <td>School lunches</td>
                                                               <td>
                                                                  <div class="input_field_wrapper currency_start">
                                                                     <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="currency" type="number" placeholder="0.00" value="<?php echo isset($postData['monthly_minor_school_lunches'])?number_format((float)$postData['monthly_minor_school_lunches'], 2, '.', ''):'0.00'; ?>" name="monthly_minor_school_lunches">
                                                                  </div>
                                                               </td>
                                                            </tr>
                                                            <tr>
                                                               <td>School supplies</td>
                                                               <td>
                                                                  <div class="input_field_wrapper currency_start">
                                                                     <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="currency" type="number" placeholder="0.00" value="<?php echo isset($postData['monthly_minor_school_supplies'])?number_format((float)$postData['monthly_minor_school_supplies'], 2, '.', ''):'0.00'; ?>" name="monthly_minor_school_supplies">
                                                                  </div>
                                                               </td>
                                                            </tr>
                                                            <tr>
                                                               <td>Extracurricular activities and lessons</td>
                                                               <td>
                                                                  <div class="input_field_wrapper currency_start">
                                                                     <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="currency" type="number" placeholder="0.00" value="<?php echo isset($postData['monthly_minor_extracurriculars'])?number_format((float)$postData['monthly_minor_extracurriculars'], 2, '.', ''):'0.00'; ?>" name="monthly_minor_extracurriculars">
                                                                  </div>
                                                               </td>
                                                            </tr>
                                                            <tr>
                                                               <td>Clothing</td>
                                                               <td>
                                                                  <div class="input_field_wrapper currency_start">
                                                                     <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="currency" type="number" placeholder="0.00" value="<?php echo isset($postData['monthly_minor_clothing'])?number_format((float)$postData['monthly_minor_clothing'], 2, '.', ''):'0.00'; ?>" name="monthly_minor_clothing">
                                                                  </div>
                                                               </td>
                                                            </tr>
                                                            <tr>
                                                               <td>Child(ren)’s allowances</td>
                                                               <td>
                                                                  <div class="input_field_wrapper currency_start">
                                                                     <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="currency" type="number" placeholder="0.00" value="<?php echo isset($postData['monthly_minor_allowance'])?number_format((float)$postData['monthly_minor_allowance'], 2, '.', ''):'0.00'; ?>" name="monthly_minor_allowance">
                                                                  </div>
                                                               </td>
                                                            </tr>
                                                            <tr>
                                                               <td>Special and extraordinary needs of child(ren)  (not included elsewhere)</td>
                                                               <td>
                                                                  <div class="input_field_wrapper currency_start">
                                                                     <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="currency" type="number" placeholder="0.00" value="<?php echo isset($postData['monthly_minor_spec_extra_needs'])?number_format((float)$postData['monthly_minor_spec_extra_needs'], 2, '.', ''):'0.00'; ?>" name="monthly_minor_spec_extra_needs">
                                                                  </div>
                                                               </td>
                                                            </tr>
                                                            <tr>
                                                               <td>
                                                                  Other:
                                                                  <div class="input_field_wrapper">
                                                                     <input type="text" placeholder="Enter Other Minor Child-Related Expenses" value="<?php echo isset($postData['monthly_minor_other_type'])? $postData['monthly_minor_other_type']:''; ?>" name="monthly_minor_other_type">
                                                                  </div>
                                                               </td>
                                                               <td>
                                                                  <div class="input_field_wrapper currency_start">
                                                                     <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="currency" type="number" placeholder="0.00" value="<?php echo isset($postData['monthly_minor_other'])?number_format((float)$postData['monthly_minor_other'], 2, '.', ''):'0.00'; ?>" name="monthly_minor_other">
                                                                  </div>
                                                               </td>
                                                            </tr>
                                                            <tr>
                                                               <td class="text-right">
                                                                  <b>TOTAL MONTHLY</b>
                                                               </td>
                                                               <td>
                                                                  <div class="input_field_wrapper currency_start">
                                                                     <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="currency" type="number" value="<?php echo isset($postData['total_monthly_minor'])?number_format((float)$postData['total_monthly_minor'], 2, '.', ''):'0.00'; ?>" placeholder="0.00" name="total_monthly_minor" readonly="">
                                                                 
                                                                  </div>
                                                               </td>
                                                            </tr>
                                                         </tbody>
                                                      </table>
                                                   </td>
                                                </tr>
                                                <tr>
                                                   <td class="p-0" colspan="5">
                                                      <table class="annual-income" width="100%">
                                                         <tbody>
                                                            <tr>
                                                               <td colspan="2"><strong>D. Monthly Insurance Premiums</strong></td>
                                                            </tr>
                                                            <tr>
                                                               <td>Life</td>
                                                               <td>
                                                                  <div class="input_field_wrapper currency_start">
                                                                     <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="currency" type="number" placeholder="0.00" value="<?php echo isset($postData['monthly_ins_life'])?number_format((float)$postData['monthly_ins_life'], 2, '.', ''):'0.00'; ?>" name="monthly_ins_life">
                                                                  </div>
                                                               </td>
                                                            </tr>
                                                            <tr>
                                                               <td>Auto</td>
                                                               <td>
                                                                  <div class="input_field_wrapper currency_start">
                                                                     <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="currency" type="number" placeholder="0.00" value="<?php echo isset($postData['monthly_ins_auto'])?number_format((float)$postData['monthly_ins_auto'], 2, '.', ''):'0.00'; ?>" name="monthly_ins_auto">
                                                                  </div>
                                                               </td>
                                                            </tr>
                                                            <tr>
                                                               <td>Health</td>
                                                               <td>
                                                                  <div class="input_field_wrapper currency_start">
                                                                     <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="currency" type="number" placeholder="0.00" value="<?php echo isset($postData['monthly_ins_health'])?number_format((float)$postData['monthly_ins_health'], 2, '.', ''):'0.00'; ?>" name="monthly_ins_health">
                                                                  </div>
                                                               </td>
                                                            </tr>
                                                            <tr>
                                                               <td>Disability</td>
                                                               <td>
                                                                  <div class="input_field_wrapper currency_start">
                                                                     <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="currency" type="number" placeholder="0.00" value="<?php echo isset($postData['monthly_ins_disability'])?number_format((float)$postData['monthly_ins_disability'], 2, '.', ''):'0.00'; ?>" name="monthly_ins_disability">
                                                                  </div>
                                                               </td>
                                                            </tr>
                                                            <tr>
                                                               <td>
                                                                  Other:
                                                                  <div class="input_field_wrapper">
                                                                     <input type="text" placeholder="Enter Other Insurance Premium Expenses" value="<?php echo isset($postData['monthly_ins_other_type'])? $postData['monthly_ins_other_type']:''; ?>" name="monthly_ins_other_type">
                                                                  </div>
                                                               </td>
                                                               <td>
                                                                  <div class="input_field_wrapper currency_start">
                                                                     <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="currency" type="number" placeholder="0.00" value="<?php echo isset($postData['monthly_ins_other'])?number_format((float)$postData['monthly_ins_other'], 2, '.', ''):'0.00'; ?>" name="monthly_ins_other">
                                                                  </div>
                                                               </td>
                                                            </tr>
                                                            <tr class="last-tr">
                                                               <td class="text-right">
                                                                  <b>TOTAL MONTHLY</b>
                                                               </td>
                                                               <td>
                                                                  <div class="input_field_wrapper currency_start">
                                                                     <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="currency" type="number" value="<?php echo isset($postData['total_monthly_ins'])?number_format((float)$postData['total_monthly_ins'], 2, '.', ''):'0.00'; ?>" placeholder="0.00" name="total_monthly_ins" readonly="">
                                                                 
                                                                  </div>
                                                               </td>
                                                            </tr>
                                                         </tbody>
                                                      </table>
                                                   </td>
                                                </tr>
                                                <tr>
                                                   <td class="p-0" colspan="5">
                                                      <table class="annual-income" width="100%">
                                                         <tbody>
                                                            <tr>
                                                               <td colspan="2"><strong>E. Monthly Work and Education Expenses For Self</strong></td>
                                                            </tr>
                                                            <tr>
                                                               <td>Mandatory work expenses (union dues, uniforms, or other)</td>
                                                               <td>
                                                                  <div class="input_field_wrapper currency_start">
                                                                     <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="currency" type="number" placeholder="0.00" value="<?php echo isset($postData['monthly_self_mandatory_work_expenses'])?number_format((float)$postData['monthly_self_mandatory_work_expenses'], 2, '.', ''):'0.00'; ?>" name="monthly_self_mandatory_work_expenses">
                                                                  </div>
                                                               </td>
                                                            </tr>
                                                            <tr>
                                                               <td>Additional income taxes paid (not deducted from wages)</td>
                                                               <td>
                                                                  <div class="input_field_wrapper currency_start">
                                                                     <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="currency" type="number" placeholder="0.00" value="<?php echo isset($postData['monthly_self_addtional_inc_taxes_paid'])?number_format((float)$postData['monthly_self_addtional_inc_taxes_paid'], 2, '.', ''):'0.00'; ?>" name="monthly_self_addtional_inc_taxes_paid">
                                                                  </div>
                                                               </td>
                                                            </tr>
                                                            <tr>
                                                               <td>Tuition</td>
                                                               <td>
                                                                  <div class="input_field_wrapper currency_start">
                                                                     <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="currency" type="number" placeholder="0.00" value="<?php echo isset($postData['monthly_self_tuition'])?number_format((float)$postData['monthly_self_tuition'], 2, '.', ''):'0.00'; ?>" name="monthly_self_tuition">
                                                                  </div>
                                                               </td>
                                                            </tr>
                                                            <tr>
                                                               <td>Books, fees, and other</td>
                                                               <td>
                                                                  <div class="input_field_wrapper currency_start">
                                                                     <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="currency" type="number" placeholder="0.00" value="<?php echo isset($postData['monthly_self_books_fees_other'])?number_format((float)$postData['monthly_self_books_fees_other'], 2, '.', ''):'0.00'; ?>" name="monthly_self_books_fees_other">
                                                                  </div>
                                                               </td>
                                                            </tr>
                                                            <tr>
                                                               <td>College loan</td>
                                                               <td>
                                                                  <div class="input_field_wrapper currency_start">
                                                                     <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="currency" type="number" placeholder="0.00" value="<?php echo isset($postData['monthly_self_college_loan'])?number_format((float)$postData['monthly_self_college_loan'], 2, '.', ''):'0.00'; ?>" name="monthly_self_college_loan">
                                                                  </div>
                                                               </td>
                                                            </tr>
                                                            <tr>
                                                               <td>
                                                                  Other:
                                                                  <div class="input_field_wrapper">
                                                                     <input type="text" placeholder="Enter Other Self Work and Education Expenses" value="<?php echo isset($postData['monthly_self_other1_type'])? $postData['monthly_self_other1_type']:''; ?>" name="monthly_self_other1_type">
                                                                  </div>
                                                               </td>
                                                               <td>
                                                                  <div class="input_field_wrapper currency_start">
                                                                     <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="currency" type="number" placeholder="0.00" value="<?php echo isset($postData['monthly_self_other1'])?number_format((float)$postData['monthly_self_other1'], 2, '.', ''):'0.00'; ?>" name="monthly_self_other1">
                                                                  </div>
                                                               </td>
                                                            </tr>
                                                            <tr>
                                                               <td>
                                                                  Other:
                                                                  <div class="input_field_wrapper">
                                                                     <input type="text" placeholder="Enter Other Self Work and Education Expenses 2" value="<?php echo isset($postData['monthly_self_other2_type'])? $postData['monthly_self_other2_type']:''; ?>" name="monthly_self_other2_type">
                                                                  </div>
                                                               </td>
                                                               <td>
                                                                  <div class="input_field_wrapper currency_start">
                                                                     <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="currency" type="number" placeholder="0.00" value="<?php echo isset($postData['monthly_self_other2'])?number_format((float)$postData['monthly_self_other2'], 2, '.', ''):'0.00'; ?>" name="monthly_self_other2">
                                                                  </div>
                                                               </td>
                                                            </tr>
                                                            <tr class="last-tr">
                                                               <td class="text-right">
                                                                  <b>TOTAL MONTHLY</b>
                                                               </td>
                                                               <td>
                                                                  <div class="input_field_wrapper currency_start">
                                                                     <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="currency" type="number" value="<?php echo isset($postData['total_monthly_self'])?number_format((float)$postData['total_monthly_self'], 2, '.', ''):'0.00'; ?>" placeholder="0.00" name="total_monthly_self" readonly="">
                                                                 
                                                                  </div>
                                                               </td>
                                                            </tr>
                                                         </tbody>
                                                      </table>
                                                   </td>
                                                </tr>
                                                <tr>
                                                   <td class="p-0" colspan="5">
                                                      <table class="annual-income" width="100%">
                                                         <tbody>
                                                            <tr>
                                                               <td colspan="2"><strong>F. Monthly Health Care Expenses</strong></td>
                                                            </tr>
                                                            <tr>
                                                               <td>Physicians</td>
                                                               <td>
                                                                  <div class="input_field_wrapper currency_start">
                                                                     <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="currency" type="number" placeholder="0.00" value="<?php echo isset($postData['monthly_health_physicians'])?number_format((float)$postData['monthly_health_physicians'], 2, '.', ''):'0.00'; ?>" name="monthly_health_physicians">
                                                                  </div>
                                                               </td>
                                                            </tr>
                                                            <tr>
                                                               <td>Dentists and orthodontists</td>
                                                               <td>
                                                                  <div class="input_field_wrapper currency_start">
                                                                     <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="currency" type="number" placeholder="0.00" value="<?php echo isset($postData['monthly_health_dentists_orthodontists'])?number_format((float)$postData['monthly_health_dentists_orthodontists'], 2, '.', ''):'0.00'; ?>" name="monthly_health_dentists_orthodontists">
                                                                  </div>
                                                               </td>
                                                            </tr>
                                                            <tr>
                                                               <td>Optometrists and opticians</td>
                                                               <td>
                                                                  <div class="input_field_wrapper currency_start">
                                                                     <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="currency" type="number" placeholder="0.00" value="<?php echo isset($postData['monthly_health_optometrists_opticians'])?number_format((float)$postData['monthly_health_optometrists_opticians'], 2, '.', ''):'0.00'; ?>" name="monthly_health_optometrists_opticians">
                                                                  </div>
                                                               </td>
                                                            </tr>
                                                            <tr>
                                                               <td>Prescriptions</td>
                                                               <td>
                                                                  <div class="input_field_wrapper currency_start">
                                                                     <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="currency" type="number" placeholder="0.00" value="<?php echo isset($postData['monthly_health_prescriptions'])?number_format((float)$postData['monthly_health_prescriptions'], 2, '.', ''):'0.00'; ?>" name="monthly_health_prescriptions">
                                                                  </div>
                                                               </td>
                                                            </tr>
                                                            <tr>
                                                               <td>
                                                                  Other:
                                                                  <div class="input_field_wrapper">
                                                                     <input type="text" placeholder="Enter Other Health Care Expenses" value="<?php echo isset($postData['monthly_health_other_type'])? $postData['monthly_health_other_type']:''; ?>" name="monthly_health_other_type">
                                                                  </div>
                                                               </td>
                                                               <td>
                                                                  <div class="input_field_wrapper currency_start">
                                                                     <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="currency" type="number" placeholder="0.00" value="<?php echo isset($postData['monthly_health_other'])?number_format((float)$postData['monthly_health_other'], 2, '.', ''):'0.00'; ?>" name="monthly_health_other">
                                                                  </div>
                                                               </td>
                                                            </tr>
                                                            <tr class="last-tr">
                                                               <td class="text-right">
                                                                  <b>TOTAL MONTHLY</b>
                                                               </td>
                                                               <td>
                                                                  <div class="input_field_wrapper currency_start">
                                                                     <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="currency" type="number" value="<?php echo isset($postData['total_monthly_health'])?number_format((float)$postData['total_monthly_health'], 2, '.', ''):'0.00'; ?>" placeholder="0.00" name="total_monthly_health" readonly="">
                                                                 
                                                                  </div>
                                                               </td>
                                                            </tr>
                                                         </tbody>
                                                      </table>
                                                   </td>
                                                </tr>
                                                <tr>
                                                   <td class="p-0" colspan="5">
                                                      <table class="annual-income" width="100%">
                                                         <tbody>
                                                            <tr>
                                                               <td colspan="2"><strong>G. Miscellaneous Monthly Expenses</strong></td>
                                                            </tr>
                                                            <tr>
                                                               <td>Extraordinary obligations for other minor/handicapped child(ren) [for child(ren) who were not born of this marriage or relationship and were not adopted by these parties] 
                                                               </td>
                                                               <td>
                                                                  <div class="input_field_wrapper currency_start">
                                                                     <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="currency" type="number" placeholder="0.00" value="<?php echo isset($postData['monthly_misc_extra_ob_minor_children_NoM'])?number_format((float)$postData['monthly_misc_extra_ob_minor_children_NoM'], 2, '.', ''):'0.00'; ?>" name="monthly_misc_extra_ob_minor_children_NoM">
                                                                  </div>
                                                               </td>
                                                            </tr>
                                                            <tr>
                                                               <td>Child support for child(ren) who were not born of this marriage or relationship and were not adopted by these parties</td>
                                                               <td>
                                                                  <div class="input_field_wrapper currency_start">
                                                                     <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="currency" type="number" placeholder="0.00" value="<?php echo isset($postData['monthly_misc_child_support_paid_children_NoM'])?number_format((float)$postData['monthly_misc_child_support_paid_children_NoM'], 2, '.', ''):'0.00'; ?>" name="monthly_misc_child_support_paid_children_NoM">
                                                                  </div>
                                                               </td>
                                                            </tr>
                                                            <tr>
                                                               <td>Expenses paid for adult child(ren) or other dependent(s)</td>
                                                               <td>
                                                                  <div class="input_field_wrapper currency_start">
                                                                     <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="currency" type="number" placeholder="0.00" value="<?php echo isset($postData['monthly_misc_exp_adult_children_NoM'])?number_format((float)$postData['monthly_misc_exp_adult_children_NoM'], 2, '.', ''):'0.00'; ?>" name="monthly_misc_exp_adult_children_NoM">
                                                                  </div>
                                                               </td>
                                                            </tr>
                                                            <tr>
                                                               <td>Spousal support paid to former spouse(s)</td>
                                                               <td>
                                                                  <div class="input_field_wrapper currency_start">
                                                                     <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="currency" type="number" placeholder="0.00" value="<?php echo isset($postData['monthly_misc_spousal_support_paid'])?number_format((float)$postData['monthly_misc_spousal_support_paid'], 2, '.', ''):'0.00'; ?>" name="monthly_misc_spousal_support_paid">
                                                                  </div>
                                                               </td>
                                                            </tr>
                                                            <tr>
                                                               <td>Subscriptions and books</td>
                                                               <td>
                                                                  <div class="input_field_wrapper currency_start">
                                                                     <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="currency" type="number" placeholder="0.00" value="<?php echo isset($postData['monthly_misc_subscriptions_books'])?number_format((float)$postData['monthly_misc_subscriptions_books'], 2, '.', ''):'0.00'; ?>" name="monthly_misc_subscriptions_books">
                                                                  </div>
                                                               </td>
                                                            </tr>
                                                            <tr>
                                                               <td>Charitable contributions</td>
                                                               <td>
                                                                  <div class="input_field_wrapper currency_start">
                                                                     <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="currency" type="number" placeholder="0.00" value="<?php echo isset($postData['monthly_misc_charity'])?number_format((float)$postData['monthly_misc_charity'], 2, '.', ''):'0.00'; ?>" name="monthly_misc_charity">
                                                                  </div>
                                                               </td>
                                                            </tr>
                                                            <tr>
                                                               <td>Memberships (associations and clubs)</td>
                                                               <td>
                                                                  <div class="input_field_wrapper currency_start">
                                                                     <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="currency" type="number" placeholder="0.00" value="<?php echo isset($postData['monthly_misc_assoc_club_membership'])?number_format((float)$postData['monthly_misc_assoc_club_membership'], 2, '.', ''):'0.00'; ?>" name="monthly_misc_assoc_club_membership">
                                                                  </div>
                                                               </td>
                                                            </tr>
                                                            <tr>
                                                               <td>Travel and vacations</td>
                                                               <td>
                                                                  <div class="input_field_wrapper currency_start">
                                                                     <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="currency" type="number" placeholder="0.00" value="<?php echo isset($postData['monthly_misc_travel_vacations'])?number_format((float)$postData['monthly_misc_travel_vacations'], 2, '.', ''):'0.00'; ?>" name="monthly_misc_travel_vacations">
                                                                  </div>
                                                               </td>
                                                            </tr>
                                                            <tr>
                                                               <td>Pets</td>
                                                               <td>
                                                                  <div class="input_field_wrapper currency_start">
                                                                     <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="currency" type="number" placeholder="0.00" value="<?php echo isset($postData['monthly_misc_pets'])?number_format((float)$postData['monthly_misc_pets'], 2, '.', ''):'0.00'; ?>" name="monthly_misc_pets">
                                                                  </div>
                                                               </td>
                                                            </tr>
                                                            <tr>
                                                               <td>Gifts</td>
                                                               <td>
                                                                  <div class="input_field_wrapper currency_start">
                                                                     <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="currency" type="number" placeholder="0.00" value="<?php echo isset($postData['monthly_misc_gifts'])?number_format((float)$postData['monthly_misc_gifts'], 2, '.', ''):'0.00'; ?>" name="monthly_misc_gifts">
                                                                  </div>
                                                               </td>
                                                            </tr>
                                                            <tr>
                                                               <td>Attorney fees</td>
                                                               <td>
                                                                  <div class="input_field_wrapper currency_start">
                                                                     <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="currency" type="number" placeholder="0.00" value="<?php echo isset($postData['monthly_misc_atty_fees'])?number_format((float)$postData['monthly_misc_atty_fees'], 2, '.', ''):'0.00'; ?>" name="monthly_misc_atty_fees">
                                                                  </div>
                                                               </td>
                                                            </tr>
                                                            <tr>
                                                               <td>
                                                                  Other:
                                                                  <div class="input_field_wrapper">
                                                                     <input type="text" placeholder="Enter Other Miscellaneous Expenses" value="<?php echo isset($postData['monthly_misc_other1_type'])? $postData['monthly_misc_other1_type']:''; ?>" name="monthly_misc_other1_type">
                                                                  </div>
                                                               </td>
                                                               <td>
                                                                  <div class="input_field_wrapper currency_start">
                                                                     <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="currency" type="number" placeholder="0.00" value="<?php echo isset($postData['monthly_misc_other1'])?number_format((float)$postData['monthly_misc_other1'], 2, '.', ''):'0.00'; ?>" name="monthly_misc_other1">
                                                                  </div>
                                                               </td>
                                                            </tr>
                                                            <tr>
                                                               <td>
                                                                  Other:
                                                                  <div class="input_field_wrapper">
                                                                     <input type="text" placeholder="Enter Other Miscellaneous Expenses 2" value="<?php echo isset($postData['monthly_misc_other2_type'])? $postData['monthly_misc_other2_type']:''; ?>" name="monthly_misc_other2_type">
                                                                  </div>
                                                               </td>
                                                               <td>
                                                                  <div class="input_field_wrapper currency_start">
                                                                     <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="currency" type="number" placeholder="0.00" value="<?php echo isset($postData['monthly_misc_other2'])?number_format((float)$postData['monthly_misc_other2'], 2, '.', ''):'0.00'; ?>" name="monthly_misc_other2">
                                                                  </div>
                                                               </td>
                                                            </tr>
                                                            <tr class="last-tr">
                                                               <td class="text-right">
                                                                  <b>TOTAL MONTHLY</b>
                                                               </td>
                                                               <td>
                                                                  <div class="input_field_wrapper currency_start">
                                                                     <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="currency" type="number" value="<?php echo isset($postData['total_monthly_misc'])?number_format((float)$postData['total_monthly_misc'], 2, '.', ''):'0.00'; ?>" placeholder="0.00" name="total_monthly_misc" readonly="">
                                                                 
                                                                  </div>
                                                               </td>
                                                            </tr>
                                                         </tbody>
                                                      </table>
                                                   </td>
                                                </tr>
                                                <tr>
                                                   <td class="p-0 border-bottom-0" colspan="5">
                                                      <table class="annual-income" width="100%">
                                                         <tbody>
                                                            <tr>
                                                               <td colspan="2"><strong>H. Monthly Installment Payments Including Bankruptcy Payments</strong></td>
                                                            </tr>
                                                            <tr>
                                                               <td class="p-0 border-bottom-0" colspan="5">
                                                                  <table class="annual-income" width="100%">
                                                                     <tbody>
                                                                        <tr>
                                                                           <td><b>To whom paid</b></td>
                                                                           <td><b>Purpose</b></td>
                                                                           <td><b>Balance</b> </td>
                                                                           <td><b>Monthly Payment</b></td>
                                                                        </tr>
                                                                        <tr>
                                                                           <td>
                                                                              <div class="input_field_wrapper">
                                                                                 <input type="text" placeholder="Text" value="<?php echo isset($postData['monthly_installment_creditor1'])? $postData['monthly_installment_creditor1']:''; ?>" name="monthly_installment_creditor1">
                                                                              </div>
                                                                           </td>
                                                                           <td>
                                                                              <select onchange="handleInstPurposeChange(this, '1');" class="test county-select" name="monthly_installment_purpose1" style="font-size: 16px;">
                                                                                
                                                                                <option value="">Select</option>
                                                                                <option value="Credit Card">Credit Card</option>
                                                                                <option value="Car Loan">Car Loan</option>
                                                                                <option value="Motorcycle Loan">Motorcycle Loan</option>
                                                                                <option value="RV Loan">RV Loan</option>
                                                                                <option value="Personal Loan">Personal Loan</option>
                                                                                <option value="Line of Credit">Line of Credit</option>
                                                                                <option value="Education Loan">Education Loan</option>
                                                                                <option value="Medical Bills">Medical Bills</option>
                                                                                <option value="Other">Other</option>
                                                                              </select>
                                                                              <div style="display: none;" class="input_field_wrapper monthly_installment_purpose1_text_div">
                                                                                 <input type="text" placeholder="Text" value="<?php echo isset($postData['monthly_installment_purpose1'])? $postData['monthly_installment_purpose1']:''; ?>" name="monthly_installment_purpose1_text" data-onload="handleInstPurposeTextOnLoad(this, '1');">
                                                                              </div>
                                                                           </td>
                                                                           <td>
                                                                              <div class="input_field_wrapper currency_start">
                                                                                 <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="currency" type="number" placeholder="0.00" value="<?php echo isset($postData['monthly_installment_balance1'])?number_format((float)$postData['monthly_installment_balance1'], 2, '.', ''):'0.00'; ?>" name="monthly_installment_balance1">
                                                                              </div>
                                                                           </td>
                                                                           <td>
                                                                              <div class="input_field_wrapper currency_start">
                                                                                 <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="currency" type="number" placeholder="0.00" value="<?php echo isset($postData['monthly_installment_payment1'])?number_format((float)$postData['monthly_installment_payment1'], 2, '.', ''):'0.00'; ?>" name="monthly_installment_payment1">
                                                                              </div>
                                                                           </td>
                                                                        </tr>
                                                                        <tr>
                                                                           <td>
                                                                              <div class="input_field_wrapper">
                                                                                 <input type="text" placeholder="Text" value="<?php echo isset($postData['monthly_installment_creditor2'])? $postData['monthly_installment_creditor2']:''; ?>" name="monthly_installment_creditor2">
                                                                              </div>
                                                                           </td>
                                                                           <td>
                                                                              <select onchange="handleInstPurposeChange(this, '2');" class="test county-select" name="monthly_installment_purpose2" style="font-size: 16px;">
                                                                                
                                                                                <option value="">Select</option>
                                                                                <option value="Credit Card">Credit Card</option>
                                                                                <option value="Car Loan">Car Loan</option>
                                                                                <option value="Motorcycle Loan">Motorcycle Loan</option>
                                                                                <option value="RV Loan">RV Loan</option>
                                                                                <option value="Personal Loan">Personal Loan</option>
                                                                                <option value="Line of Credit">Line of Credit</option>
                                                                                <option value="Education Loan">Education Loan</option>
                                                                                <option value="Medical Bills">Medical Bills</option>
                                                                                <option value="Other">Other</option>
                                                                              </select>
                                                                              <div style="display: none;" class="input_field_wrapper monthly_installment_purpose2_text_div">
                                                                                 <input type="text" placeholder="Text" value="<?php echo isset($postData['monthly_installment_purpose2'])? $postData['monthly_installment_purpose2']:''; ?>" name="monthly_installment_purpose2_text" data-onload="handleInstPurposeTextOnLoad(this, '2');">
                                                                              </div>
                                                                           </td>
                                                                           <td>
                                                                              <div class="input_field_wrapper currency_start">
                                                                                 <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="currency" type="number" placeholder="0.00" value="<?php echo isset($postData['monthly_installment_balance2'])?number_format((float)$postData['monthly_installment_balance2'], 2, '.', ''):'0.00'; ?>" name="monthly_installment_balance2">
                                                                              </div>
                                                                           </td>
                                                                           <td>
                                                                              <div class="input_field_wrapper currency_start">
                                                                                 <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="currency" type="number" placeholder="0.00" value="<?php echo isset($postData['monthly_installment_payment2'])?number_format((float)$postData['monthly_installment_payment2'], 2, '.', ''):'0.00'; ?>" name="monthly_installment_payment2">
                                                                              </div>
                                                                           </td>
                                                                        </tr>
                                                                        <tr>
                                                                           <td>
                                                                              <div class="input_field_wrapper">
                                                                                 <input type="text" placeholder="Text" value="<?php echo isset($postData['monthly_installment_creditor3'])? $postData['monthly_installment_creditor3']:''; ?>" name="monthly_installment_creditor3">
                                                                              </div>
                                                                           </td>
                                                                           <td>
                                                                              <select onchange="handleInstPurposeChange(this, '3');" class="test county-select" name="monthly_installment_purpose3" style="font-size: 16px;">
                                                                                
                                                                                <option value="">Select</option>
                                                                                <option value="Credit Card">Credit Card</option>
                                                                                <option value="Car Loan">Car Loan</option>
                                                                                <option value="Motorcycle Loan">Motorcycle Loan</option>
                                                                                <option value="RV Loan">RV Loan</option>
                                                                                <option value="Personal Loan">Personal Loan</option>
                                                                                <option value="Line of Credit">Line of Credit</option>
                                                                                <option value="Education Loan">Education Loan</option>
                                                                                <option value="Medical Bills">Medical Bills</option>
                                                                                <option value="Other">Other</option>
                                                                              </select>
                                                                              <div style="display: none;" class="input_field_wrapper monthly_installment_purpose3_text_div">
                                                                                 <input type="text" placeholder="Text" value="<?php echo isset($postData['monthly_installment_purpose3'])? $postData['monthly_installment_purpose3']:''; ?>" name="monthly_installment_purpose3_text" data-onload="handleInstPurposeTextOnLoad(this, '3');">
                                                                              </div>
                                                                           </td>
                                                                           <td>
                                                                              <div class="input_field_wrapper currency_start">
                                                                                 <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="currency" type="number" placeholder="0.00" value="<?php echo isset($postData['monthly_installment_balance3'])?number_format((float)$postData['monthly_installment_balance3'], 2, '.', ''):'0.00'; ?>" name="monthly_installment_balance3">
                                                                              </div>
                                                                           </td>
                                                                           <td>
                                                                              <div class="input_field_wrapper currency_start">
                                                                                 <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="currency" type="number" placeholder="0.00" value="<?php echo isset($postData['monthly_installment_payment3'])?number_format((float)$postData['monthly_installment_payment3'], 2, '.', ''):'0.00'; ?>" name="monthly_installment_payment3">
                                                                              </div>
                                                                           </td>
                                                                        </tr>
                                                                        <tr>
                                                                           <td>
                                                                              <div class="input_field_wrapper">
                                                                                 <input type="text" placeholder="Text" value="<?php echo isset($postData['monthly_installment_creditor4'])? $postData['monthly_installment_creditor4']:''; ?>" name="monthly_installment_creditor4">
                                                                              </div>
                                                                           </td>
                                                                           <td>
                                                                              <select onchange="handleInstPurposeChange(this, '4');" class="test county-select" name="monthly_installment_purpose4" style="font-size: 16px;">
                                                                                
                                                                                <option value="">Select</option>
                                                                                <option value="Credit Card">Credit Card</option>
                                                                                <option value="Car Loan">Car Loan</option>
                                                                                <option value="Motorcycle Loan">Motorcycle Loan</option>
                                                                                <option value="RV Loan">RV Loan</option>
                                                                                <option value="Personal Loan">Personal Loan</option>
                                                                                <option value="Line of Credit">Line of Credit</option>
                                                                                <option value="Education Loan">Education Loan</option>
                                                                                <option value="Medical Bills">Medical Bills</option>
                                                                                <option value="Other">Other</option>
                                                                              </select>
                                                                              <div style="display: none;" class="input_field_wrapper monthly_installment_purpose4_text_div">
                                                                                 <input type="text" placeholder="Text" value="<?php echo isset($postData['monthly_installment_purpose4'])? $postData['monthly_installment_purpose4']:''; ?>" name="monthly_installment_purpose4_text" data-onload="handleInstPurposeTextOnLoad(this, '4');">
                                                                              </div>
                                                                           </td>
                                                                           <td>
                                                                              <div class="input_field_wrapper currency_start">
                                                                                 <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="currency" type="number" placeholder="0.00" value="<?php echo isset($postData['monthly_installment_balance4'])?number_format((float)$postData['monthly_installment_balance4'], 2, '.', ''):'0.00'; ?>" name="monthly_installment_balance4">
                                                                              </div>
                                                                           </td>
                                                                           <td>
                                                                              <div class="input_field_wrapper currency_start">
                                                                                 <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="currency" type="number" placeholder="0.00" value="<?php echo isset($postData['monthly_installment_payment4'])?number_format((float)$postData['monthly_installment_payment4'], 2, '.', ''):'0.00'; ?>" name="monthly_installment_payment4">
                                                                              </div>
                                                                           </td>
                                                                        </tr>
                                                                        <tr>
                                                                           <td>
                                                                              <div class="input_field_wrapper">
                                                                                 <input type="text" placeholder="Text" value="<?php echo isset($postData['monthly_installment_creditor5'])? $postData['monthly_installment_creditor5']:''; ?>" name="monthly_installment_creditor5">
                                                                              </div>
                                                                           </td>
                                                                           <td>
                                                                              <select onchange="handleInstPurposeChange(this, '5');" class="test county-select" name="monthly_installment_purpose5" style="font-size: 16px;">
                                                                                
                                                                                <option value="">Select</option>
                                                                                <option value="Credit Card">Credit Card</option>
                                                                                <option value="Car Loan">Car Loan</option>
                                                                                <option value="Motorcycle Loan">Motorcycle Loan</option>
                                                                                <option value="RV Loan">RV Loan</option>
                                                                                <option value="Personal Loan">Personal Loan</option>
                                                                                <option value="Line of Credit">Line of Credit</option>
                                                                                <option value="Education Loan">Education Loan</option>
                                                                                <option value="Medical Bills">Medical Bills</option>
                                                                                <option value="Other">Other</option>
                                                                              </select>
                                                                              <div style="display: none;" class="input_field_wrapper monthly_installment_purpose5_text_div">
                                                                                 <input type="text" placeholder="Text" value="<?php echo isset($postData['monthly_installment_purpose5'])? $postData['monthly_installment_purpose5']:''; ?>" name="monthly_installment_purpose5_text" data-onload="handleInstPurposeTextOnLoad(this, '5');">
                                                                              </div>
                                                                           </td>
                                                                           <td>
                                                                              <div class="input_field_wrapper currency_start">
                                                                                 <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="currency" type="number" placeholder="0.00" value="<?php echo isset($postData['monthly_installment_balance5'])?number_format((float)$postData['monthly_installment_balance5'], 2, '.', ''):'0.00'; ?>" name="monthly_installment_balance5">
                                                                              </div>
                                                                           </td>
                                                                           <td>
                                                                              <div class="input_field_wrapper currency_start">
                                                                                 <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="currency" type="number" placeholder="0.00" value="<?php echo isset($postData['monthly_installment_payment5'])?number_format((float)$postData['monthly_installment_payment5'], 2, '.', ''):'0.00'; ?>" name="monthly_installment_payment5">
                                                                              </div>
                                                                           </td>
                                                                        </tr>
                                                                        <tr>
                                                                           <td>
                                                                              <div class="input_field_wrapper">
                                                                                 <input type="text" placeholder="Text" value="<?php echo isset($postData['monthly_installment_creditor6'])? $postData['monthly_installment_creditor6']:''; ?>" name="monthly_installment_creditor6">
                                                                              </div>
                                                                           </td>
                                                                           <td>
                                                                              <select onchange="handleInstPurposeChange(this, '6');" class="test county-select" name="monthly_installment_purpose6" style="font-size: 16px;">
                                                                                
                                                                                <option value="">Select</option>
                                                                                <option value="Credit Card">Credit Card</option>
                                                                                <option value="Car Loan">Car Loan</option>
                                                                                <option value="Motorcycle Loan">Motorcycle Loan</option>
                                                                                <option value="RV Loan">RV Loan</option>
                                                                                <option value="Personal Loan">Personal Loan</option>
                                                                                <option value="Line of Credit">Line of Credit</option>
                                                                                <option value="Education Loan">Education Loan</option>
                                                                                <option value="Medical Bills">Medical Bills</option>
                                                                                <option value="Other">Other</option>
                                                                              </select>
                                                                              <div style="display: none;" class="input_field_wrapper monthly_installment_purpose6_text_div">
                                                                                 <input type="text" placeholder="Text" value="<?php echo isset($postData['monthly_installment_purpose6'])? $postData['monthly_installment_purpose6']:''; ?>" name="monthly_installment_purpose6_text" data-onload="handleInstPurposeTextOnLoad(this, '6');">
                                                                              </div>
                                                                           </td>
                                                                           <td>
                                                                              <div class="input_field_wrapper currency_start">
                                                                                 <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="currency" type="number" placeholder="0.00" value="<?php echo isset($postData['monthly_installment_balance6'])?number_format((float)$postData['monthly_installment_balance6'], 2, '.', ''):'0.00'; ?>" name="monthly_installment_balance6">
                                                                              </div>
                                                                           </td>
                                                                           <td>
                                                                              <div class="input_field_wrapper currency_start">
                                                                                 <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="currency" type="number" placeholder="0.00" value="<?php echo isset($postData['monthly_installment_payment6'])?number_format((float)$postData['monthly_installment_payment6'], 2, '.', ''):'0.00'; ?>" name="monthly_installment_payment6">
                                                                              </div>
                                                                           </td>
                                                                        </tr>
                                                                        <tr>
                                                                           <td>
                                                                              <div class="input_field_wrapper">
                                                                                 <input type="text" placeholder="Text" value="<?php echo isset($postData['monthly_installment_creditor7'])? $postData['monthly_installment_creditor7']:''; ?>" name="monthly_installment_creditor7">
                                                                              </div>
                                                                           </td>
                                                                           <td>
                                                                              <select onchange="handleInstPurposeChange(this, '7');" class="test county-select" name="monthly_installment_purpose7" style="font-size: 16px;">
                                                                                
                                                                                <option value="">Select</option>
                                                                                <option value="Credit Card">Credit Card</option>
                                                                                <option value="Car Loan">Car Loan</option>
                                                                                <option value="Motorcycle Loan">Motorcycle Loan</option>
                                                                                <option value="RV Loan">RV Loan</option>
                                                                                <option value="Personal Loan">Personal Loan</option>
                                                                                <option value="Line of Credit">Line of Credit</option>
                                                                                <option value="Education Loan">Education Loan</option>
                                                                                <option value="Medical Bills">Medical Bills</option>
                                                                                <option value="Other">Other</option>
                                                                              </select>
                                                                              <div style="display: none;" class="input_field_wrapper monthly_installment_purpose7_text_div">
                                                                                 <input type="text" placeholder="Text" value="<?php echo isset($postData['monthly_installment_purpose7'])? $postData['monthly_installment_purpose7']:''; ?>" name="monthly_installment_purpose7_text" data-onload="handleInstPurposeTextOnLoad(this, '7');">
                                                                              </div>
                                                                           </td>
                                                                           <td>
                                                                              <div class="input_field_wrapper currency_start">
                                                                                 <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="currency" type="number" placeholder="0.00" value="<?php echo isset($postData['monthly_installment_balance7'])?number_format((float)$postData['monthly_installment_balance7'], 2, '.', ''):'0.00'; ?>" name="monthly_installment_balance7">
                                                                              </div>
                                                                           </td>
                                                                           <td>
                                                                              <div class="input_field_wrapper currency_start">
                                                                                 <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="currency" type="number" placeholder="0.00" value="<?php echo isset($postData['monthly_installment_payment7'])?number_format((float)$postData['monthly_installment_payment7'], 2, '.', ''):'0.00'; ?>" name="monthly_installment_payment7">
                                                                              </div>
                                                                           </td>
                                                                        </tr>
                                                                        <tr>
                                                                           <td>
                                                                              <div class="input_field_wrapper">
                                                                                 <input type="text" placeholder="Text" value="<?php echo isset($postData['monthly_installment_creditor8'])? $postData['monthly_installment_creditor8']:''; ?>" name="monthly_installment_creditor8">
                                                                              </div>
                                                                           </td>
                                                                           <td>
                                                                              <select onchange="handleInstPurposeChange(this, '8');" class="test county-select" name="monthly_installment_purpose8" style="font-size: 16px;">
                                                                                
                                                                                <option value="">Select</option>
                                                                                <option value="Credit Card">Credit Card</option>
                                                                                <option value="Car Loan">Car Loan</option>
                                                                                <option value="Motorcycle Loan">Motorcycle Loan</option>
                                                                                <option value="RV Loan">RV Loan</option>
                                                                                <option value="Personal Loan">Personal Loan</option>
                                                                                <option value="Line of Credit">Line of Credit</option>
                                                                                <option value="Education Loan">Education Loan</option>
                                                                                <option value="Medical Bills">Medical Bills</option>
                                                                                <option value="Other">Other</option>
                                                                              </select>
                                                                              <div style="display: none;" class="input_field_wrapper monthly_installment_purpose8_text_div">
                                                                                 <input type="text" placeholder="Text" value="<?php echo isset($postData['monthly_installment_purpose8'])? $postData['monthly_installment_purpose8']:''; ?>" name="monthly_installment_purpose8_text" data-onload="handleInstPurposeTextOnLoad(this, '8');">
                                                                              </div>
                                                                           </td>
                                                                           <td>
                                                                              <div class="input_field_wrapper currency_start">
                                                                                 <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="currency" type="number" placeholder="0.00" value="<?php echo isset($postData['monthly_installment_balance8'])?number_format((float)$postData['monthly_installment_balance8'], 2, '.', ''):'0.00'; ?>" name="monthly_installment_balance8">
                                                                              </div>
                                                                           </td>
                                                                           <td>
                                                                              <div class="input_field_wrapper currency_start">
                                                                                 <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="currency" type="number" placeholder="0.00" value="<?php echo isset($postData['monthly_installment_payment8'])?number_format((float)$postData['monthly_installment_payment8'], 2, '.', ''):'0.00'; ?>" name="monthly_installment_payment8">
                                                                              </div>
                                                                           </td>
                                                                        </tr>
                                                                        <tr>
                                                                           <td>
                                                                              <div class="input_field_wrapper">
                                                                                 <input type="text" placeholder="Text" value="<?php echo isset($postData['monthly_installment_creditor9'])? $postData['monthly_installment_creditor9']:''; ?>" name="monthly_installment_creditor9">
                                                                              </div>
                                                                           </td>
                                                                           <td>
                                                                              <select onchange="handleInstPurposeChange(this, '9');" class="test county-select" name="monthly_installment_purpose9" style="font-size: 16px;">
                                                                                
                                                                                <option value="">Select</option>
                                                                                <option value="Credit Card">Credit Card</option>
                                                                                <option value="Car Loan">Car Loan</option>
                                                                                <option value="Motorcycle Loan">Motorcycle Loan</option>
                                                                                <option value="RV Loan">RV Loan</option>
                                                                                <option value="Personal Loan">Personal Loan</option>
                                                                                <option value="Line of Credit">Line of Credit</option>
                                                                                <option value="Education Loan">Education Loan</option>
                                                                                <option value="Medical Bills">Medical Bills</option>
                                                                                <option value="Other">Other</option>
                                                                              </select>
                                                                              <div style="display: none;" class="input_field_wrapper monthly_installment_purpose9_text_div">
                                                                                 <input type="text" placeholder="Text" value="<?php echo isset($postData['monthly_installment_purpose9'])? $postData['monthly_installment_purpose9']:''; ?>" name="monthly_installment_purpose9_text" data-onload="handleInstPurposeTextOnLoad(this, '9');">
                                                                              </div>
                                                                           </td>
                                                                           <td>
                                                                              <div class="input_field_wrapper currency_start">
                                                                                 <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="currency" type="number" placeholder="0.00" value="<?php echo isset($postData['monthly_installment_balance9'])?number_format((float)$postData['monthly_installment_balance9'], 2, '.', ''):'0.00'; ?>" name="monthly_installment_balance9">
                                                                              </div>
                                                                           </td>
                                                                           <td>
                                                                              <div class="input_field_wrapper currency_start">
                                                                                 <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="currency" type="number" placeholder="0.00" value="<?php echo isset($postData['monthly_installment_payment9'])?number_format((float)$postData['monthly_installment_payment9'], 2, '.', ''):'0.00'; ?>" name="monthly_installment_payment9">
                                                                              </div>
                                                                           </td>
                                                                        </tr>
                                                                        <tr>
                                                                           <td>
                                                                              <div class="input_field_wrapper">
                                                                                 <input type="text" placeholder="Text" value="<?php echo isset($postData['monthly_installment_creditor10'])? $postData['monthly_installment_creditor10']:''; ?>" name="monthly_installment_creditor10">
                                                                              </div>
                                                                           </td>
                                                                           <td>
                                                                              <select onchange="handleInstPurposeChange(this, '10');" class="test county-select" name="monthly_installment_purpose10" style="font-size: 16px;">
                                                                                
                                                                                <option value="">Select</option>
                                                                                <option value="Credit Card">Credit Card</option>
                                                                                <option value="Car Loan">Car Loan</option>
                                                                                <option value="Motorcycle Loan">Motorcycle Loan</option>
                                                                                <option value="RV Loan">RV Loan</option>
                                                                                <option value="Personal Loan">Personal Loan</option>
                                                                                <option value="Line of Credit">Line of Credit</option>
                                                                                <option value="Education Loan">Education Loan</option>
                                                                                <option value="Medical Bills">Medical Bills</option>
                                                                                <option value="Other">Other</option>
                                                                              </select>
                                                                              <div style="display: none;" class="input_field_wrapper monthly_installment_purpose10_text_div">
                                                                                 <input type="text" placeholder="Text" value="<?php echo isset($postData['monthly_installment_purpose10'])? $postData['monthly_installment_purpose10']:''; ?>" name="monthly_installment_purpose10_text" data-onload="handleInstPurposeTextOnLoad(this, '10');">
                                                                              </div>
                                                                           </td>
                                                                           <td>
                                                                              <div class="input_field_wrapper currency_start">
                                                                                 <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="currency" type="number" placeholder="0.00" value="<?php echo isset($postData['monthly_installment_balance10'])?number_format((float)$postData['monthly_installment_balance10'], 2, '.', ''):'0.00'; ?>" name="monthly_installment_balance10">
                                                                              </div>
                                                                           </td>
                                                                           <td>
                                                                              <div class="input_field_wrapper currency_start">
                                                                                 <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="currency" type="number" placeholder="0.00" value="<?php echo isset($postData['monthly_installment_payment10'])?number_format((float)$postData['monthly_installment_payment10'], 2, '.', ''):'0.00'; ?>" name="monthly_installment_payment10">
                                                                              </div>
                                                                           </td>
                                                                        </tr>
                                                                        <tr>
                                                                           <td>
                                                                              <div class="input_field_wrapper">
                                                                                 <input type="text" placeholder="Text" value="<?php echo isset($postData['monthly_installment_creditor11'])? $postData['monthly_installment_creditor11']:''; ?>" name="monthly_installment_creditor11">
                                                                              </div>
                                                                           </td>
                                                                           <td>
                                                                              <select onchange="handleInstPurposeChange(this, '11');" class="test county-select" name="monthly_installment_purpose11" style="font-size: 16px;">
                                                                                
                                                                                <option value="">Select</option>
                                                                                <option value="Credit Card">Credit Card</option>
                                                                                <option value="Car Loan">Car Loan</option>
                                                                                <option value="Motorcycle Loan">Motorcycle Loan</option>
                                                                                <option value="RV Loan">RV Loan</option>
                                                                                <option value="Personal Loan">Personal Loan</option>
                                                                                <option value="Line of Credit">Line of Credit</option>
                                                                                <option value="Education Loan">Education Loan</option>
                                                                                <option value="Medical Bills">Medical Bills</option>
                                                                                <option value="Other">Other</option>
                                                                              </select>
                                                                              <div style="display: none;" class="input_field_wrapper monthly_installment_purpose11_text_div">
                                                                                 <input type="text" placeholder="Text" value="<?php echo isset($postData['monthly_installment_purpose11'])? $postData['monthly_installment_purpose11']:''; ?>" name="monthly_installment_purpose11_text" data-onload="handleInstPurposeTextOnLoad(this, '11');">
                                                                              </div>
                                                                           </td>
                                                                           <td>
                                                                              <div class="input_field_wrapper currency_start">
                                                                                 <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="currency" type="number" placeholder="0.00" value="<?php echo isset($postData['monthly_installment_balance11'])?number_format((float)$postData['monthly_installment_balance11'], 2, '.', ''):'0.00'; ?>" name="monthly_installment_balance11">
                                                                              </div>
                                                                           </td>
                                                                           <td>
                                                                              <div class="input_field_wrapper currency_start">
                                                                                 <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="currency" type="number" placeholder="0.00" value="<?php echo isset($postData['monthly_installment_payment11'])?number_format((float)$postData['monthly_installment_payment11'], 2, '.', ''):'0.00'; ?>" name="monthly_installment_payment11">
                                                                              </div>
                                                                           </td>
                                                                        </tr>
                                                                        <tr>
                                                                           <td>
                                                                              <div class="input_field_wrapper">
                                                                                 <input type="text" placeholder="Text" value="<?php echo isset($postData['monthly_installment_creditor12'])? $postData['monthly_installment_creditor12']:''; ?>" name="monthly_installment_creditor12">
                                                                              </div>
                                                                           </td>
                                                                           <td>
                                                                              <select onchange="handleInstPurposeChange(this, '12');" class="test county-select" name="monthly_installment_purpose12" style="font-size: 16px;">
                                                                                
                                                                                <option value="">Select</option>
                                                                                <option value="Credit Card">Credit Card</option>
                                                                                <option value="Car Loan">Car Loan</option>
                                                                                <option value="Motorcycle Loan">Motorcycle Loan</option>
                                                                                <option value="RV Loan">RV Loan</option>
                                                                                <option value="Personal Loan">Personal Loan</option>
                                                                                <option value="Line of Credit">Line of Credit</option>
                                                                                <option value="Education Loan">Education Loan</option>
                                                                                <option value="Medical Bills">Medical Bills</option>
                                                                                <option value="Other">Other</option>
                                                                              </select>
                                                                              <div style="display: none;" class="input_field_wrapper monthly_installment_purpose12_text_div">
                                                                                 <input type="text" placeholder="Text" value="<?php echo isset($postData['monthly_installment_purpose12'])? $postData['monthly_installment_purpose12']:''; ?>" name="monthly_installment_purpose12_text" data-onload="handleInstPurposeTextOnLoad(this, '12');">
                                                                              </div>
                                                                           </td>
                                                                           <td>
                                                                              <div class="input_field_wrapper currency_start">
                                                                                 <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="currency" type="number" placeholder="0.00" value="<?php echo isset($postData['monthly_installment_balance12'])?number_format((float)$postData['monthly_installment_balance12'], 2, '.', ''):'0.00'; ?>" name="monthly_installment_balance12">
                                                                              </div>
                                                                           </td>
                                                                           <td>
                                                                              <div class="input_field_wrapper currency_start">
                                                                                 <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="currency" type="number" placeholder="0.00" value="<?php echo isset($postData['monthly_installment_payment12'])?number_format((float)$postData['monthly_installment_payment12'], 2, '.', ''):'0.00'; ?>" name="monthly_installment_payment12">
                                                                              </div>
                                                                           </td>
                                                                        </tr>
                                                                        <tr>
                                                                           <td>
                                                                              <div class="input_field_wrapper">
                                                                                 <input type="text" placeholder="Text" value="<?php echo isset($postData['monthly_installment_creditor13'])? $postData['monthly_installment_creditor13']:''; ?>" name="monthly_installment_creditor13">
                                                                              </div>
                                                                           </td>
                                                                           <td>
                                                                              <select onchange="handleInstPurposeChange(this, '13');" class="test county-select" name="monthly_installment_purpose13" style="font-size: 16px;">
                                                                                
                                                                                <option value="">Select</option>
                                                                                <option value="Credit Card">Credit Card</option>
                                                                                <option value="Car Loan">Car Loan</option>
                                                                                <option value="Motorcycle Loan">Motorcycle Loan</option>
                                                                                <option value="RV Loan">RV Loan</option>
                                                                                <option value="Personal Loan">Personal Loan</option>
                                                                                <option value="Line of Credit">Line of Credit</option>
                                                                                <option value="Education Loan">Education Loan</option>
                                                                                <option value="Medical Bills">Medical Bills</option>
                                                                                <option value="Other">Other</option>
                                                                              </select>
                                                                              <div style="display: none;" class="input_field_wrapper monthly_installment_purpose13_text_div">
                                                                                 <input type="text" placeholder="Text" value="<?php echo isset($postData['monthly_installment_purpose13'])? $postData['monthly_installment_purpose13']:''; ?>" name="monthly_installment_purpose13_text" data-onload="handleInstPurposeTextOnLoad(this, '13');">
                                                                              </div>
                                                                           </td>
                                                                           <td>
                                                                              <div class="input_field_wrapper currency_start">
                                                                                 <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="currency" type="number" placeholder="0.00" value="<?php echo isset($postData['monthly_installment_balance13'])?number_format((float)$postData['monthly_installment_balance13'], 2, '.', ''):'0.00'; ?>" name="monthly_installment_balance13">
                                                                              </div>
                                                                           </td>
                                                                           <td>
                                                                              <div class="input_field_wrapper currency_start">
                                                                                 <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="currency" type="number" placeholder="0.00" value="<?php echo isset($postData['monthly_installment_payment13'])?number_format((float)$postData['monthly_installment_payment13'], 2, '.', ''):'0.00'; ?>" name="monthly_installment_payment13">
                                                                              </div>
                                                                           </td>
                                                                        </tr>
                                                                        <tr>
                                                                           <td class="text-right" colspan="3">
                                                                              <b>TOTAL MONTHLY</b>
                                                                           </td>
                                                                           <td>
                                                                              <div class="input_field_wrapper currency_start">
                                                                                 <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="currency" type="number" value="<?php echo isset($postData['total_monthly_installment_payments'])?number_format((float)$postData['total_monthly_installment_payments'], 2, '.', ''):'0.00'; ?>" placeholder="0.00" name="total_monthly_installment_payments" readonly="">
                                                                                
                                                                              </div>
                                                                           </td>
                                                                        </tr>
                                                                     </tbody>
                                                                  </table>
                                                               </td>
                                                            </tr>
                                                         </tbody>
                                                      </table>
                                                   </td>
                                                </tr>
                                                <tr>
                                                   <td class="p-0 border-bottom-0" colspan="5">
                                                      <table class="annual-income" width="100%">
                                                         <tbody>
                                                            <tr class="last-tr" >
                                                               <td colspan="4">GRAND TOTAL MONTHLY EXPENSES</td>
                                                               <td colspan="1">
                                                                  <div class="input_field_wrapper currency_start">
                                                                     <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="currency" type="number" value="<?php echo isset($postData['grand_total_monthly_expenses'])?number_format((float)$postData['grand_total_monthly_expenses'], 2, '.', ''):'0.00'; ?>" placeholder="0.00" name="grand_total_monthly_expenses" readonly="">
                                                                 
                                                                  </div>
                                                               </td>
                                                            </tr>
                                                         </tbody>
                                                      </table>
                                                   </td>
                                                </tr>
                                             </tbody>
                                          </table>
                                       </td>
                                    </tr>
                                 </tbody>
                              </table>
                           </td>
                        </tr>
                     </tbody>
                  </table>
                  <div class="row mt-4 mx-0">
                     <div class="d-inline-flex w-100 custom-inline-elements">
                        <label for="">Notary : </label>
                        <div class="input_field_wrapper_checkbox">
                           <input type="radio" name="notary_name_radio" class="es_checkbox" value="{{Auth::user()->name}}" onclick="handleNotaryChange(this);" <?php echo ((isset($postData['notary_name_radio'])) && ($postData['notary_name_radio'] == 'other')) ? '' : 'checked'; ?>>
                           <label class="mb-0"> {{Auth::user()->attorney->document_sign_name}} </label>
                        </div>
                        <div class="input_field_wrapper_checkbox">
                           <div class="input_field_wrapper">
                              <input type="radio" name="notary_name_radio" class="es_checkbox" value="other" onclick="handleNotaryChange(this);" <?php echo ((isset($postData['notary_name_radio'])) && ($postData['notary_name_radio'] == 'other')) ? 'checked' : ''; ?>>
                              <label class="mb-0">Other:</label>
                           </div>
                           @if((isset($postData['notary_name_radio'])) && ($postData['notary_name_radio'] == 'other'))
                                <div class="input_field_wrapper">
                                   <input type="text" value="<?php echo isset($postData['notary_name'])? $postData['notary_name']:''; ?>" placeholder="Enter Notary" id="notary_name_text" class="px-2" name="notary_name">
                                </div>
                           @else
                                <div class="input_field_wrapper">
                                   <input type="text" value="" placeholder="Enter Notary" id="notary_name_text" class="px-2" name="notary_name" readonly="">
                                </div>
                           @endif
                        </div>
                     </div>
                  </div>
                  <div class="row mt-4">
                     <div class="col-12 text-right mb-3">
                        <input type="submit" name="submit" value="Calculate" class="btn btn-success">
                     </div>
                     <div class="col-12 text-right mb-3">
                        <input type="submit" name="save_download_sheet" value="Save Data" class="btn btn-info">
                     </div> 
                     <div class="col-12 text-right mb-3">
                        <input type="submit" name="download_sheet" value="Download Affidavit" class="btn btn-info">
                     </div>
                     <div class="col-12 text-right mb-3">
                        <input type="button" name="" value="To Calculate/Save Data & open FDD Quick Child Support Worksheet using this data" class="btn btn-info" data-toggle="modal" data-target="#myModal">
                     </div>
                  </div>
                  
                  
               </div>
               <!-- The Modal -->
               <div class="modal" id="myModal">
                    <div class="modal-dialog">
                         <div class="modal-content">

                               <!-- Modal Header -->
                              <div class="modal-header">
                                   <!-- <h4 class="modal-title">Open FDD Quick Child Support Worksheet</h4> -->
                                   <button type="button" class="close" data-dismiss="modal">&times;</button>
                              </div>

                               <!-- Modal body -->
                              <div class="modal-body">
                                   <div class="row mb-3 mx-0">
                                        <div class="d-inline-flex w-100 custom-inline-elements">
                                             <label for="">Select Custody:</label>
                                             <div class="input_field_wrapper_checkbox">
                                                  <input name="cs_sheet_custody" type="radio" class="es_checkbox" value="Shared" checked="">
                                                  <label class="mb-0"> Shared  </label>
                                             </div>
                                             <div class="input_field_wrapper_checkbox">
                                                  <input name="cs_sheet_custody" type="radio" class="es_checkbox" value="Sole">
                                                  <label class="mb-0">Sole  </label>
                                             </div>
                                             <div class="input_field_wrapper_checkbox">
                                                  <input name="cs_sheet_custody" type="radio" class="es_checkbox" value="Split">
                                                  <label class="mb-0">Split  </label>
                                             </div>
                                        </div>
                                   </div>
                                   <div class="row mb-3 mx-0">
                                        <div class="d-inline-flex w-100 custom-inline-elements">
                                             <label for="">Select Child Support Obligor:</label>
                                             <div class="input_field_wrapper_checkbox">
                                                  <input name="cs_sheet_obligor" type="radio" class="es_checkbox" value="top_party" checked="">
                                                  <label class="mb-0"><span class="topparty_name_span">Top PartyName</span></label>
                                             </div>
                                             <div class="input_field_wrapper_checkbox">
                                                  <input name="cs_sheet_obligor" type="radio" class="es_checkbox" value="bottom_party">
                                                  <label class="mb-0"><span class="bottomparty_name_span">Bottom PartyName</span> </label>
                                             </div>
                                        </div>
                                   </div>
                                   <div class="row my-3">
                                        <div class="col-8">
                                             <input type="submit" name="open_cs_sheet" value="Open FDD Quick Child Support Worksheet" class="btn btn-info">
                                        </div>
                                   </div>
                              </div>
                         </div>
                    </div>
               </div>
               <!-- Modal End -->
            </form>
          
<script type="text/javascript">

$(document).ready(function(){
     $(window).keydown(function(event){
          if(event.keyCode == 13) {
               event.preventDefault();
               return false;
          }
     });

     $(".hasDatepicker").datepicker({
          startDate: "01/01/1901",
     });

     $(".hasDatepickerPast").datepicker({
          startDate: "01/01/1901",
          endDate: '+0d',
     });

    $('[data-onload]').each(function(){
        eval($(this).data('onload'));
    });

     // fetch counties based on state
     var state_id='{{ $postData["state_id"] }}';
     var token= $('input[name=_token]').val();
     if(state_id) {
          $.ajax({
               url:"{{route('ajax_get_counties_by_state')}}",
               method:"POST",
               dataType: 'json',
               data:{
                   id: state_id, 
                   _token: token, 
               },
               success: function(data){
                    // console.log(data);
                    if(data==null || data=='null'){
                    } else {
                       $.each(data, function (key, val) {
                           $('.county_inputs').append('<option value='+key+'>'+val+'</option>');
                       });
                       var selected_county=$('#selected_affidavit_county').val();
                       $(".county_inputs").val(selected_county);
                    }
               }
          });
     }

     // fetch courts for counties,state
     $('#affidavit_county').on('change', function(){
          $('.court_inputs, .division_inputs, .judge_inputs, .magistrate_inputs').find('option:not(:first)').remove();
          var county_id=this.value;
          if(county_id) {
               $.ajax({
                    url:"{{route('ajax_get_affidavit_court_by_county_state')}}",
                    method:"POST",
                    dataType: 'json',
                    data:{
                        county_id: county_id, 
                        state_id: state_id, 
                        _token: token, 
                    },
                    success: function(data){
                        // console.log(data);
                        if(data==null || data=='null'){
                              // $('.no-courts').show();
                         } else {
                              // $('.no-courts').hide();
                              $.each(data, function (key, val) {
                                   $('.court_inputs').append('<option value='+key+'>'+val+'</option>');
                              });
                         }
                    }
               });
          }
     });

     // fetch division for court
     $('#affidavit_court').on('change', function(){
          $('.division_inputs, .judge_inputs, .magistrate_inputs').find('option:not(:first)').remove();
          var court_id=this.value;
          if(court_id) {
               $.ajax({
                    url:"{{route('ajax_get_affidavit_division_by_court')}}",
                    method:"POST",
                    dataType: 'json',
                    data:{
                        court_id: court_id, 
                        _token: token, 
                    },
                    success: function(data){
                         // console.log(data);
                         if(data==null || data=='null'){
                         } else {
                            $.each(data, function (key, val) {
                                $('.division_inputs').append('<option value='+key+'>'+val+'</option>');
                            });
                         }
                    }
               });
          }
     });

     // fetch judges and magistrates for court and division
     $('#affidavit_division').on('change', function(){
          $('.judge_inputs, .magistrate_inputs').find('option:not(:first)').remove();
          var division_id=this.value;
          var court_id=$('#affidavit_court').val();
          if(division_id && court_id) {
                $.ajax({
                    url:"{{route('ajax_get_judge_magistrate_casetype_by_court_div')}}",
                    method:"POST",
                    dataType: 'json',
                    data:{
                        division_id: division_id, 
                        court_id: court_id, 
                        _token: token, 
                    },
                    success: function(data){
                        // console.log(data);
                        if(data['judges']==null || data['judges']=='null'){
                            // $('.judge_inputs').append('<option value="other">Other Judge</option>');
                        } else {
                              $.each(data['judges'], function (key, val) {
                                   $('.judge_inputs').append('<option value='+key+'>'+val+'</option>');
                              });
                              // $('.judge_inputs').append('<option value="other">Other Judge</option>');
                        }

                        if(data['magistrates']==null || data['magistrates']=='null'){
                            // $('.magistrate_inputs').append('<option value="other">Other Magistrate</option>');
                        } else {
                              $.each(data['magistrates'], function (key, val) {
                                   $('.magistrate_inputs').append('<option value='+key+'>'+val+'</option>');
                              });
                              // $('.magistrate_inputs').append('<option value="other">Other Magistrate</option>');
                        }
                    }
               })
          }          
     });
     
     // on top party role change
     $('input[name="topparty_role"]').on('change', function(){
          if(this.value === 'Plaintiff'){
               $('#bottomparty_role').val('Defendant');
               $('.topparty_role_span').text(this.value);
               $('.bottomparty_role_span').text('Defendant');
          } else {
               $('#bottomparty_role').val('Petitioner 2');
               $('.topparty_role_span').text(this.value);
               $('.bottomparty_role_span').text('Petitioner 2');
          }
     });
     
     // on top party name change
     $('input[name="topparty_name"]').on('input', function(){
          $('.topparty_name_span').text(this.value);
          $('.minordependent_livingwith_top_party').val(this.value);
     });
     
     // on bottom party name change
     $('input[name="bottomparty_name"]').on('input', function(){
          $('.bottomparty_name_span').text(this.value);
          $('.minordependent_livingwith_bottom_party').val(this.value);
     });
     
     // on top party health change
     $('input[name="tp_health"]').on('change', function(){
          if(this.value === 'Good'){
               $('#tp_health_explain').val('');
               $('#tp_health_explain').prop('required', false);
               $('#tp_health_explain').prop('readonly', true);
          } else {
               $('#tp_health_explain').prop('required', true);
               $('#tp_health_explain').prop('readonly', false);
          }
     });
     
     // on bottom party health change
     $('input[name="bp_health"]').on('change', function(){
          if(this.value === 'Good'){
               $('#bp_health_explain').val('');
               $('#bp_health_explain').prop('required', false);
               $('#bp_health_explain').prop('readonly', true);
          } else {
               $('#bp_health_explain').prop('required', true);
               $('#bp_health_explain').prop('readonly', false);
          }
     });

});

// fetch state and city based on zipcode
function onPayrollZipChange(zipinput, partytype){
     var zip=zipinput.value;
     $('#'+partytype+'_party_payroll_city').find('option').remove().end().append('<option value="">Choose City</option>');
     $('#'+partytype+'_party_payroll_state').find('option').remove().end().append('<option value="">Choose State</option>');

     if( zip != '' && zip != null && zip.length >= '3'){
            var token= $('input[name=_token]').val();
            $.ajax({
               url:"{{route('ajax_get_city_state_county_by_zip')}}",
               method:"POST",
               dataType: 'json',
               data:{
                    zip: zip, 
                    _token: token, 
               },
               success: function(data){
                    // console.log(data);
                    if(data=='null' || data==''){
                        // $('.no-state-county-'+partytype+'').show();
                      // $('.cl_no_zip').show();
                    } else {
                        $.each(data, function (key, val) {
                            $('#'+partytype+'_party_payroll_city').append('<option value="'+data[key].city+'">'+data[key].city+'</option>');
                            $('#'+partytype+'_party_payroll_state').append('<option value="'+data[key].state_id+'">'+data[key].state+'</option>');
                        });
                        var a = new Array();
                        $('#'+partytype+'_party_payroll_city').children("option").each(function(x){
                            test = false;
                            b = a[x] = $(this).val();
                            for (i=0;i<a.length-1;i++){
                                if (b ==a[i]) test =true;
                            }
                            if (test) $(this).remove();
                        })
                        var a = new Array();
                        $('#'+partytype+'_party_payroll_state').children("option").each(function(x){
                            test = false;
                            b = a[x] = $(this).val();
                            for (i=0;i<a.length-1;i++){
                                if (b ==a[i]) test =true;
                            }
                            if (test) $(this).remove();
                        })
                        if($('#'+partytype+'_party_payroll_city').children('option').length =='2'){
                            $('#'+partytype+'_party_payroll_city').children('option').first().remove();
                        } else {
                              $('#'+partytype+'_party_payroll_city').toggleClass('custom-input-focus');
                        }
                        if($('#'+partytype+'_party_payroll_state').children('option').length =='2'){
                            $('#'+partytype+'_party_payroll_state').children('option').first().remove();
                        }


                       var selected_payroll_city=$('#selected_'+partytype+'_party_payroll_city').val();
                       if(selected_payroll_city && selected_payroll_city !=''){
                         $('#'+partytype+'_party_payroll_city').val(selected_payroll_city);
                       }

                       var selected_payroll_state=$('#selected_'+partytype+'_party_payroll_state').val();
                       if(selected_payroll_state && selected_payroll_state !=''){
                         $('#'+partytype+'_party_payroll_state').val(selected_payroll_state);
                       }
                        // $('.no-state-county-cl').hide();
                    }
               }
          });        
     }
}

// to enable/disable base yearly income inputs
function enableDisableField1(type, radiofield)
  {
    if (radiofield.id == ''+type+'_party_base_yearly_checks_radio')
    {
      $("#"+type+"_party_input_year").attr("readonly", false);
      $("#"+type+"_party_input_year").attr("required", true);

      $("#"+type+"_party_input_ytd, #"+type+"_party_datepick").attr("readonly", true);
      $("#"+type+"_party_input_ytd, #"+type+"_party_datepick").attr("required", false);
      $("#"+type+"_party_input_ytd, #"+type+"_party_datepick").val('');

    } else if (radiofield.id == type+'_party_base_yearly_ytd_radio') {

      $("#"+type+"_party_input_ytd, #"+type+"_party_datepick").attr("readonly", false);
      $("#"+type+"_party_input_ytd, #"+type+"_party_datepick").attr("required", true);

      $("#"+type+"_party_input_year").attr("readonly", true);
      $("#"+type+"_party_input_year").attr("required", false);
      $("#"+type+"_party_input_year").val('');

      $("#"+type+"_party_dropdown").val(0);

    } else {

      $("#"+type+"_party_input_ytd, #"+type+"_party_datepick").attr("readonly", true);
      $("#"+type+"_party_input_ytd, #"+type+"_party_datepick").val('');

      $("#"+type+"_party_input_year").attr("readonly", true);
      $("#"+type+"_party_input_year").val('');

      $("#"+type+"_party_dropdown").val(0);
    }

    $("#"+type+"_party_base_yearly_income_current").val('');
    calcuAnnualGrossIncome(type);
}

  /**
   * Calculate Annual Gross Income
   */
function calcuAnnualGrossIncome(label){ 
    //var minWage = "<?php //echo isset($postData['OH_Minimum_Wage'])?$postData['OH_Minimum_Wage']:''?>";
    var minWage = "<?php echo isset($OH_Minimum_Wage)?$OH_Minimum_Wage:''?>";
    var tmpAmount;

    var obligeeMinWageCheck = $("#"+label+"_party_base_yearly_ohio_min_wage_radio");
    var obligeeYtdCheckDate = $("#"+label+"_party_base_yearly_ytd_radio");
    var obligeeCheckYear = $("#"+label+"_party_base_yearly_checks_radio");

    var amount;
    if (obligeeYtdCheckDate.is(":checked")) {

      amount = document.getElementById(label+"_party_input_ytd").value;

    } else if (obligeeCheckYear.is(":checked")) {

      amount = document.getElementById(label+"_party_input_year").value;

    } else {

      amount = 2000;
    }

    if ((obligeeCheckYear.is(":checked")))
    {
      var frequencyForObligee = $('#'+label+'_party_dropdown').val();
      tmpAmount = amount * frequencyForObligee;

      $("#"+label+"_party_base_yearly_income_current").prop("readonly", true).val(tmpAmount);

    } else if (obligeeYtdCheckDate.is(":checked")) {

      var obligee_1_Datepick = $("#"+label+"_party_datepick").val();

      var currentDate = new Date(obligee_1_Datepick);
      var first = new Date(currentDate.getFullYear(), 0, 1);
      var theDay = Math.round(((currentDate - first) / 1000 / 60 / 60 / 24) + .5, 0);

      if(isNaN(theDay))
      {
      }
      else
      {
        tmpAmount = amount * (365/theDay);
      }
      $("#"+label+"_party_base_yearly_income_current").prop("readonly", true).val(tmpAmount);

      obligeeCheckYear.attr('checked', false);

    } else if ((obligeeMinWageCheck.is(":checked"))) {

      var fixAmount = amount * minWage;

      $("#"+label+"_party_base_yearly_income_current").val(fixAmount);

    } else {

      $("#"+label+"_party_base_yearly_income_current").val(0.00);
    }
}

  /**
   * Calculate gross income when
   * select box changed
   */
  function callCalcuAnnualGrossIncome(label)
  {
    var fixAmount;

    if ($("#"+label+"_party_base_yearly_ytd_radio").is(":checked"))
    {
      fixAmount = document.getElementById(label+"_party_input_ytd").value;

    } else if ($("#"+label+"_1_checks_year").is(":checked")) {

      fixAmount = document.getElementById(label+"_party_input_year").value;
    }

    if (fixAmount == '')
    {
      alert('Please enter the amount first.');
      return false;

    } else {

      calcuAnnualGrossIncome(label);
    }
  }

  // to calculate Average yearly overtime, commissions, and/or bonuses over last three years
  // function computeAvgOtComsBonus(checkboxinput, type){
  //    if(checkboxinput.checked){
  //         var OT_comms_bonuses_3ya=$('input[name="'+type+'_yearly_OT_comms_bonuses_3ya"]').val();
  //         var OT_comms_bonuses_2ya=$('input[name="'+type+'_yearly_OT_comms_bonuses_2ya"]').val();
  //         var OT_comms_bonuses_1ya=$('input[name="'+type+'_yearly_OT_comms_bonuses_1ya"]').val();
  //         var amount=(+OT_comms_bonuses_1ya)+(+OT_comms_bonuses_2ya)+(+OT_comms_bonuses_3ya);
  //         $('#'+type+'_ave_OT_comms_bonuses').prop("readonly", true).val(amount);
  //    } else {
  //         $('#'+type+'_ave_OT_comms_bonuses').prop("readonly", false).val('0.00');
  //    }
  // }

  // to enable/disable inputs if checkbox is checked/unchecked
  function enableDisableCurrencyInputs(checkboxinput, className){
     if(checkboxinput.checked){
          $('.'+className+'').prop("readonly", false).val('0.00');
     } else {
          $('.'+className+'').prop("readonly", true).val('0.00');
     }
  }

  // to enable/disable inputs and explanation text if checkbox is checked/unchecked
  function enableDisableCurrencyInputsWithText(checkboxinput, className){
     if(checkboxinput.checked){
          $('.'+className+'').prop("readonly", false).val('0.00');
          $('.'+className+'_text').prop("readonly", false).val('');
     } else {
          $('.'+className+'').prop("readonly", true).val('0.00');
          $('.'+className+'_text').prop("readonly", true).val('');
     }
  }

  // enable/disable children info based on selected numbers
  function handleNumMinorDeoChildChange(selectedinput){
     if(selectedinput.value){
          for (var i = 1; i <= selectedinput.value; i++) {
               $('.minordependent_child'+i+'_inputs').prop("readonly", false);
               $('.minordependent_child'+i+'_inputs_radio').prop("disabled", false);
          }

          for (var j = i; j <= 8; j++) {
               $('.minordependent_child'+j+'_inputs').prop("readonly", true).val('');
               $('.minordependent_child'+j+'_inputs_radio').prop('checked', false).prop("disabled", true);
               $('.minordependent_livingwith_other_div'+j+'').hide();
          }

     } else {
          $('.minordependent_child1_inputs, .minordependent_child2_inputs, .minordependent_child3_inputs, .minordependent_child4_inputs, .minordependent_child5_inputs, .minordependent_child6_inputs, .minordependent_child7_inputs, .minordependent_child8_inputs').prop("readonly", true).val('');
          $('.minordependent_child1_inputs_radio, .minordependent_child2_inputs_radio, .minordependent_child3_inputs_radio, .minordependent_child4_inputs_radio, .minordependent_child5_inputs_radio, .minordependent_child6_inputs_radio, .minordependent_child7_inputs_radio, .minordependent_child8_inputs_radio').prop('checked', false).prop("disabled", true);
     }
  }

  // enable/disable children info based on selected numbers
  function handleNumMinorDeoChildOnLoad(selectedinput){
     if(selectedinput.value && selectedinput.value > 0){
          $('#num_minordependent_children_this_marriage').val(selectedinput.value);
          for (var i = 1; i <= selectedinput.value; i++) {
               $('.minordependent_child'+i+'_inputs').prop("readonly", false);
               $('.minordependent_child'+i+'_inputs_radio').prop("disabled", false);
               if($('input[name="minordependent_livingwith'+i+'"]:checked').val() == 'other'){
                    $('.minordependent_livingwith_other_div'+i+'').show();
               }
          }

          for (var j = i; j <= 8; j++) {
               $('.minordependent_child'+j+'_inputs').prop("readonly", true).val('');
               $('.minordependent_child'+j+'_inputs_radio').prop('checked', false).prop("disabled", true);
               $('.minordependent_livingwith_other_div'+j+'').hide();
          }

     } else {
     }
  }


  // to enable/disable inputs if other checkbox is checked/unchecked For Notary
  function handleNotaryChange(radioinput){
     if(radioinput.checked && radioinput.value =='other'){
          $('#notary_name_text').prop("readonly", false).val('');
     } else {
          $('#notary_name_text').prop("readonly", true).val('');
     }
  }

  function handleMinorDepLivWithOtherChange(otherinput, num){
     if(otherinput.checked && otherinput.value == 'other'){
          $('.minordependent_livingwith_other_div'+num+'').show();
     } else {
          $('.minordependent_livingwith_other_div'+num+'').hide();
     }
  }

  function handleInstPurposeChange(purposeinput, num){
     if(purposeinput.value == 'Other'){
          $('input[name="monthly_installment_purpose'+num+'_text"]').val('');
          $('input[name="monthly_installment_purpose'+num+'_text"]').prop('required', true);
          $('.monthly_installment_purpose'+num+'_text_div').show();
     } else {
          $('.monthly_installment_purpose'+num+'_text_div').hide();
          $('input[name="monthly_installment_purpose'+num+'_text"]').val('');
          $('input[name="monthly_installment_purpose'+num+'_text"]').prop('required', false);
     }
  }

  function handleInstPurposeTextOnLoad(purposetextinput, num){
     var loan_purpose_array=['Credit Card', 'Car Loan', 'Motorcycle Loan', 'RV Loan', 'Personal Loan', 'Line of Credit', 'Education Loan', 'Medical Bills'];
     if(purposetextinput.value && loan_purpose_array.includes(purposetextinput.value)){
          $('select[name="monthly_installment_purpose'+num+'"]').val(purposetextinput.value);
          $('.monthly_installment_purpose'+num+'_text_div').hide();
          $('input[name="monthly_installment_purpose'+num+'_text"]').val('');
          $('input[name="monthly_installment_purpose'+num+'_text"]').prop('required', false);
     } else if(purposetextinput.value =='') {
          $('input[name="monthly_installment_purpose'+num+'_text"]').prop('required', false);
          $('.monthly_installment_purpose'+num+'_text_div').hide();
     } else {
          $('select[name="monthly_installment_purpose'+num+'"]').val('Other');
          $('input[name="monthly_installment_purpose'+num+'_text"]').prop('required', true);
          $('.monthly_installment_purpose'+num+'_text_div').show();
     }
  }

// to prefill county, court, division, judge and magistrate
var selected_county_id=$('#selected_affidavit_county').val();
var state_id='{{ $postData["state_id"] }}';
var token= $('input[name=_token]').val();
if(selected_county_id) {
   $.ajax({
       url:"{{route('ajax_get_court_by_county_state')}}",
       method:"POST",
       dataType: 'json',
       data:{
           county_id: selected_county_id, 
           state_id: state_id, 
           _token: token, 
       },
       success: function(data){
           // console.log(data);
           if(data==null || data=='null'){
               //$('.no-courts-original').show();
           } else {
               $.each(data, function (key, val) {
                    $('.court_inputs').append('<option value='+key+'>'+val+'</option>');
               });
               var selected_court=$('#selected_affidavit_court').val();
               $(".court_inputs").val(selected_court);
           }
       }
   });
}

// to fetch original division on basis of original courts
var selected_court=$('#selected_affidavit_court').val();
if(selected_court) {
   $.ajax({
       url:"{{route('ajax_get_division_by_court')}}",
       method:"POST",
       dataType: 'json',
       data:{
           court_id: selected_court, 
           _token: token, 
       },
       success: function(data){
           // console.log(data);
           if(data==null || data=='null'){
           } else {
               $.each(data, function (key, val) {
                    $('.division_inputs').append('<option value='+key+'>'+val+'</option>');
               });
               var selected_division=$('#selected_affidavit_division').val();
               $(".division_inputs").val(selected_division);
           }
       }
   });
}

var selected_division=$('#selected_affidavit_division').val();

// to fetch judges and magistrates on basis of division
if(selected_division && selected_court) {
   $.ajax({
       url:"{{route('ajax_get_judge_magistrate_casetype_by_court_div')}}",
       method:"POST",
       dataType: 'json',
       data:{
           division_id: selected_division, 
           court_id: selected_court, 
           _token: token, 
       },
       success: function(data){
          // console.log(data);
          if(data['judges']==null || data['judges']=='null'){
             // $('.judge_inputs').append('<option value="other">Other Judge</option>');
          } else {
               $.each(data['judges'], function (key, val) {
                    $('.judge_inputs').append('<option value='+key+'>'+val+'</option>');
               });
               // $('.judge_inputs').append('<option value="other">Other Judge</option>');
          }

          var selected_judge=$('#selected_affidavit_judge').val();
          $(".judge_inputs").val(selected_judge);

          if(data['magistrates']==null || data['magistrates']=='null'){
             // $('.magistrate_inputs').append('<option value="other">Other Magistrate</option>');
          } else {
               $.each(data['magistrates'], function (key, val) {
                    $('.magistrate_inputs').append('<option value='+key+'>'+val+'</option>');
               });
               // $('.magistrate_inputs').append('<option value="other">Other Magistrate</option>');
          }

          var selected_magistrate=$('#selected_affidavit_magistrate').val();
          $(".magistrate_inputs").val(selected_magistrate);
       }
   });
}

// to prefill top/bootm party name and role related inputs

if($('input[name="topparty_role"]:checked').val() == 'Plaintiff'){
     // $('#bottomparty_role').val('Defendant');
     $('.topparty_role_span').text('Plaintiff');
     $('.bottomparty_role_span').text('Defendant');
} else {
     // $('#bottomparty_role').val('Petitioner 2');
     $('.topparty_role_span').text('Petitioner 1');
     $('.bottomparty_role_span').text('Petitioner 2');
}

if($('input[name="topparty_name"]').val()){
     $('.topparty_name_span').text($('input[name="topparty_name"]').val());
     $('.minordependent_livingwith_top_party').val($('input[name="topparty_name"]').val());
}
if($('input[name="bottomparty_name"]').val()){
     $('.bottomparty_name_span').text($('input[name="bottomparty_name"]').val());
     $('.minordependent_livingwith_bottom_party').val($('input[name="bottomparty_name"]').val());
}

if($("input[name='tp_health']:checked").length == 0){
     $("input[name='tp_health'][value='Good']").prop('checked', true);
     $('#tp_health_explain').prop('readonly', true);
     $('#tp_health_explain').prop('required', false);
}
if($("input[name='bp_health']:checked").length == 0){
     $("input[name='bp_health'][value='Good']").prop('checked', true);
     $('#bp_health_explain').prop('readonly', true);
     $('#bp_health_explain').prop('required', false);
}

if($("input[name='tp_high_ed']:checked").length == 0){
     $("input[name='tp_high_ed'][value='High School']").prop('checked', true);
}
if($("input[name='bp_high_ed']:checked").length == 0){
     $("input[name='bp_high_ed'][value='High School']").prop('checked', true);
}

</script> 
@endsection
