@extends('layouts.app')


@section('content')
<style>
  .btn-danger.hover:hover {
    color: #fff;
    background-color: #767676;
    border-color: #767676;
    
}
.dataTables_wrapper .dataTables_processing{
  height: 65px!important;
  background: linear-gradient(to right, rgba(255,255,255,0) 0%, rgb(255 255 255 / 65%) 25%, rgb(255 255 255 / 62%) 75%, rgba(255,255,255,0) 100%);

}
</style>
<?php $filter = (isset($filter)) ? $filter : ''; ?>
<div class="container">
    <div class="row justify-content-center attorney-dashboard">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><strong>{{ __('Attorney Table Active Management') }}</strong>
                    <div class="pull-right">

                        <a class="btn btn-success" href="{{ route('attorneytableactive.create') }}"> Create New Attorney Table Active Record</a>

                    </div>
                </div>
                <div class="card-body table-sm table-responsive">
                    

                    @if ($message = Session::get('success'))

                    <div class="alert alert-success">
         <button type="button" class="close" data-dismiss="alert">×</button> 
                      <p>{{ $message }}</p>

                    </div>

                    @endif

                    @if ($message = Session::get('error'))
                      <div class="alert alert-danger alert-block">
                          <button type="button" class="close" data-dismiss="alert">×</button> 
                              <strong>{{ $message }}</strong>
                      </div>
                    @endif
                    {{-- <form class="form-inline pull-right" action="{{ url('attorneytableactive-filtering')}}" method="post" enctype="multipart/form-data">
                      @csrf
                        <div class="form-group mb-2 ">
                         
                          <input type="text" class="form-control" id="filter" name="filter" placeholder="Enter keyword.." value="{{ $filter }}">
                        </div>&nbsp;&nbsp;
                        <button type="submit" class="btn btn-success mb-2">Search</button>&nbsp;&nbsp;
                        <a href="{{ route('attorneytableactive.index') }}" class="btn btn-danger hover mb-2">Clear </a>
                      </form> --}}

                    <table class="table table-bordered attorneytableactive-table">
                      <thead>
                        <tr>

                          <th>Sno.</th>

                          <th>Registration Number</th>

                          <th>State</th>

                          <th>Document Sign Name</th>

                          <th>Action</th>
                         

                        </tr>
                      </thead>
                    
                    </table>
                  
                </div>
            </div>
        </div> 
    </div>
</div>  
     
<script>
  function ConfirmDelete()
  {
      var x = confirm("Are you sure you want to delete this attorney table active record.");
      if (x)
          return true;
      else
        return false;
  }

  
// alert('cv');
  //  $.ajax({
  //               url: "{{url('/getTable')}}",
  //               method: 'get',
  //               dataType: 'json',
  //               success: function (data) {
  //                 console.log(data);
  //                 console.log('data');
  //                   $('.attorneytableactive-table').dataTable({
  //                       paging: true,
  //                       sort: true,
  //                       searching: true,
  //                       data: data,
  //                       columns: [
  //                           { 'data': 'id' },
  //                           { 'data': 'registrationnumber' },
  //                           { 'data': 'state' },
  //                           { 'data': 'document_sign_name' },
                          
                          
  //                       ],
  //                       error: function () {
  //                           console.log("Get DataTable Error");
  //                       },
  //                   });
  //               },
  //           });
  
  
   $(document).ready(function(){
  
          // DataTable
      
        $('.attorneytableactive-table').dataTable({
             processing: true,
             serverSide: true,
                     columnDefs: [
    { orderable: false, targets: 0 }
  ],
  order: [[1, 'desc']],
 
             ajax: "{{url('/attorneytableactive')}}",
             columns: [
                            {data: 'id',orderable: false },
                            { data: 'registrationnumber'  },
                            { data: 'registration_state' },
                            { data: 'document_sign_name' },
                            { orderable: false,
               
                 render: (data,type,row,val) => {
                   
                   return "<a class='btn btn-primary' href='{{url('/attorneytableactive')}}/"+row.id+"/edit'>Edit</a>";
                 }
              },
                         
                           
             ],

  
          
            
              fnRowCallback : function(nRow, aData, iDisplayIndex){
                // console.log(aData  );
                $("td:first", nRow).html(aData.no);
               return nRow;
            },
             oLanguage: {sProcessing: "<i  class='spinner-border'></i> Loading...."},
     
          });
          $(".dataTables_filter label input[type=search]").attr('placeholder',' Enter keyword....');
           var table = $('.attorneytableactive-table').DataTable();
       
    
        });
</script>
@endsection