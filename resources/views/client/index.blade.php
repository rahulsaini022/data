@extends('layouts.app')
@section('content')

<div class="container">
    <div class="row justify-content-center attorney-dashboard case-list-main">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><strong>{{ __('Cases List') }}</strong>
                </div>
                <div class="card-body table-sm table-responsive">
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success alert-block">
                            <button type="button" class="close" data-dismiss="alert">×</button> 
                                <strong>{{ $message }}</strong>
                        </div>
                    @endif
                    @if ($message = Session::get('error'))
                        <div class="alert alert-danger alert-block">
                            <button type="button" class="close" data-dismiss="alert">×</button> 
                                <strong>{{ $message }}</strong>
                        </div>
                    @endif

                    <table class="table table-bordered cases-table">
                      <thead>
                       <tr>

                         <!-- <th>No</th> -->

                         <th>Short Caption</th>

                         <!-- <th>Court State</th> -->

                         <th>Court County</th>

                         <th>Court Name</th>
                         
                         <!-- <th>Court Division</th> -->
                         
                         <th>Court Case Number</th>
                         
                         <!-- <th>GroupConcat Client</th> -->
                         
                         <!-- <th>GroupConcat Ops</th> -->

                         <th>Judge</th>
                        
                         <th style="min-width: 200px;">Action</th>

                       </tr>
                      </thead>
                      <tbody>  
                       <?php $i=1; ?>
                       @foreach ($data as $key => $case)

                        <tr>

                          <!-- <td>{{ $i }}</td><?php ++$i; ?> -->

                          <td>{{ $case->short_caption }}</td>
                          
                          <!-- <td>{{ $case->state_name }}</td> -->

                          <td>{{ $case->county_name }}</td>

                          <td>{{ $case->court_name }}</td>

                          <!-- <td>{{ $case->division_name }}</td> -->
                          
                          <td>{{ $case->case_number }}</td>

                          <!-- <td>{{ $case->client_name }}</td> -->
                          
                          <!-- <td>{{ $case->opponent_name }}</td> -->

                          <td>{{ $case->judge_name }}</td>
                         
                          <td>
                            <?php
                              $case_type_ids=$case->case_type_ids;
                              $case_type_ids=explode(",",$case_type_ids);
                              $array=array('1', '2', '3', '4', '5', '6', '7', '8', '9', '49', '50', '51', '52');
                              $hascaseid = !empty(array_intersect($array, $case_type_ids));
                            ?>
                            @if(isset($hascaseid) && $hascaseid=='1' && $case->state_id=='35')
                             <a class="btn btn-primary mb-2" href="{{ route('cases.family_law_interview_tabs',$case->id) }}">Enter/Edit Family Law Interview/Data</a>
                            @else
                             <!-- <a class="btn btn-primary mb-2" href="{{ route('cases.edit',$case->id) }}">Edit</a> -->
                            @endif
                          </td>

                        </tr>

                       @endforeach
                      </tbody>
                    </table>


                </div>
            </div>          
        </div>
    </div>
</div>
<script>

  $(document).ready( function () {
    $('.cases-table').DataTable({
        pageLength: 50,
        responsive: true,
        aaSorting: []
    });
  });
</script>        
@endsection