@extends('layouts.app')
@section('content')
<style>
   .imagebox img {
    display: block;
    width: auto;
    height: 47px;
    position: relative;
    margin: 6px;
}

.imagebox {
    display: inline-flex;
    width: 100%;
    position: relative;
}
.imageData {
 
  display: flex;
 animation: move 10s linear infinite;
}

.imageData:hover {
  -webkit-animation-play-state: paused;
}

/* @-webkit-keyframes move {
  0% {
    margin-left: -400px;
  }
  100% {
    margin-left: 800px;
  }
} */
.box-image {
    width: 100%;
    display: flex;
    overflow: auto;
}

i.fa.fa-trash.delete.custom-delete {
    position: absolute;
    color: white;
    right: 10%;
    background: #ff00007d;
    font-size: 10px;
    padding: 1px 3px 3px;
    border-radius: 11px;
    top: 6px;
}
.box-image::-webkit-scrollbar {
    /* width: 5px; */
    height: 5px;
    background: #d9d9e3;
}

.box-image::-webkit-scrollbar-thumb {
    /* width: 5px; */
    background: #625c5c;
    /* height: 5px; */
}
.modal-body img {
    width: 100%;
}

</style>
    <div class="container">
        <div class="row justify-content-center attorney-dashboard">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header"><strong>{{ __('Edit Listing') }}</strong>
                        <div class="pull-right">
                            <a class="btn btn-primary" href="{{ route('advertise.new_listing') }}"> Back</a>
                        </div>
                    </div>
                    <div class="card-body">
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
                        <div class="container">
                            <form class="form" id="edit-listing-form" method="post"
                                action="{{ route('listing.update') }}" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" id="listing_id" name="id" value="{{ $listing_data->id }}">
                                <div class="form-group ">
                                    <label for='title'>Title</label>
                                    <input id='title' type="text" value="{{ $listing_data->title }}" required
                                        name="title" class="form-control @error('title') is-invalid @enderror">
                                    @error('title')
                                        <span class="help-block text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group ">
                                    <label for='price'>Price</label>
                                    <input id='price' type="number" min="1"
                                        value="{{ $listing_data->AD_price }}" required name="AD_price"
                                        class="form-control @error('AD_price') is-invalid @enderror">
                                    @error('AD_price')
                                        <span class="help-block text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-4"><label for="image" class="form-label">Image</label>
                                    <input class="form-control-file" accept="image/*" id="image" type="file" name="images[]"  onchange="imageValidate()" multiple><div id="dvPreview"></div>
                                    <span id='spanFileName' class="text-danger"></span>
                                    @error('images')
                                        <span class=" text-danger">{{ $message }}</span>
                                    @enderror
                                    </div>
                                    <div class="col-md-8">
                                    <div class="box-image">
                                        <div class="imageData"></div>
                                        
                                    </div>
                                    </div>
                                    
                                </div>
                                <div class="form-group ">
                                    <label for='desc'>Description</label>
                                    <textarea id='desc' rows='4' required class="form-control @error('description') is-invalid @enderror" name="description">{!! $listing_data->description !!}</textarea>
                                    @error('description')
                                        <span class="help-block text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                {{-- <div class="form-group " > <label for='image'>Image</label><input type="file" id='image' name="images[]"  accept="image/*" onchange="imageValidate()" class="form-custom-file" " multiple><div id="dvPreview"></div></div><span id='spanFileName' class="text-danger"></span></div> --}}
                                <button id="update-btn" type="submit"  class="btn btn-primary">Update</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<div class="modal fade bd-example-modal-lg" id="exampleModal" tabindex="-1"
        role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog " role="document">
            <div class="modal-content">
                
                <!--Modal body with image-->
                <div class="modal-body">
                     <button type="button" class="close"
                        data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">
                            ×
                        </span>
                    </button>
                    <img src="" />
                </div>
                
            </div>
        </div>
    </div>
    <script>
          getImage();
        function  zoomIn(e)
          {
   var image =e.target.currentSrc;
  
     $(".modal img").attr("src", image);
   
          }
 $('#edit-listing-form').on("input",function() {
 $('#edit-listing-form').valid();
 })
     $(document).ready(function() {
   
    $(document).on("click", ".delete", function() { 
        var ele = $(this);
    //   console.log(ele);
        var id= $(this).data('value');
        var url = "{{URL('images')}}";
        var dltUrl = url+"/"+id;
        // console.log(dltUrl);
        Swal.fire({
        title: "Are you sure?",
        text: "Do you want to delete this image?",
        // icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: "#3085d6",

        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!",
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
			url: dltUrl,
			type: "DELETE",
			cache: false,
			data:{
				_token:'{{ csrf_token() }}'
			},
			success: function(dataResult){
               
				var dataResult = JSON.parse(dataResult);
 
				if(dataResult[0].status == 1){
                   
					$('#'+id).remove();
                     Swal.fire({toast:true,position:'top-end',customClass:{container:'swal_width'},icon: 'success',title: "Image deleted successfully ",showConfirmButton: false, timer: 5000});
                   
				}
			}
		});
        }
       
    });
       
	});
        
});
   function getImage(){
        var listing_id = $('#listing_id').val();
        // console.log(listing_id);
      
        $.ajax({
            url: "{{route('get.images')}}",
            type: "POST",
            data:{ 
                _token:'{{ csrf_token() }}',
                listing_id:listing_id
            },
            cache: false,
            dataType: 'json',
            success: function(dataResult){
                // console.log(dataResult);
                var resultData = dataResult.data;
                var bodyData = '';
             
                $.each(resultData,function(index,row){
                //    console.log(row);
                    bodyData+="<div class='imagebox'  id='"+row.id+"' ><img class='image-position' data-toggle='modal'"+
       " data-target='#exampleModal' onclick='zoomIn(event)'  src='{{asset('uploads/AD_images').'/'}}"+row.image+"' > "
                        +"<i class='fa fa-trash delete custom-delete'  data-value='"+row.id+"'></i> </div>";
                    
                    
                })
                $(".imageData").append(bodyData);
            }
        });

    }

function imageValidate() {
    var total_file=document.getElementById("image").files.length;
//  for(var i=0;i<total_file;i++)
//  {
//   $('#dvPreview').append("<div class='d-inline ' > <img  width='40' height='40' class='img-thumbnail'  src='"+URL.createObjectURL(event.target.files[i])+"'></div>");
//  }
  var s=$('#image').val();
  function stringEndsWithValidExtension(stringToCheck, acceptableExtensionsArray, required) {
    if (required == false && stringToCheck.length == 0) { 
         $('#update-btn').prop('disabled', false) ;
        return true;
     }
    for (var i = 0; i < acceptableExtensionsArray.length; i++) {
        if (stringToCheck.toLowerCase().endsWith(acceptableExtensionsArray[i].toLowerCase())) {$('#spanFileName').html(""); return true; }
    }
     $('#update-btn').prop('disabled', true) ;
    return false;
}

String.prototype.startsWith = function (str) { return (this.match("^" + str) == str) }

String.prototype.endsWith = function (str) { return (this.match(str + "$") == str) }

   if (!stringEndsWithValidExtension($("[id*='image']").val(), [".png", ".jpeg", ".jpg",".ico",".gif",".svg" ], false)) {
    $('#spanFileName').html("Image only allows file types of .png, .jpg , .ico , .gif , .jpeg , .svg ");
     $('#update-btn').prop('disabled', true) ;
        return false;
    }
    $('#spanFileName').html("");
     $('#update-btn').prop('disabled', false) ;
    return true;
}
    </script>
@endsection
