 @if ($message = Session::get('success'))
                        <script> Swal.fire({toast:true,position:'top-end',customClass:{container:'swal_width'},icon: 'success',title: "{{$message}}",showConfirmButton: false, timer: 5000, showClass: {
    popup: 'animate__animated animate__flipInY'
  },
  hideClass: {
    popup: 'animate__animated animate__flipOutY'
  }});</script>
                        @elseif($message = Session::get('error'))
                             <script> Swal.fire({toast:true,position:'top-end',customClass:{container:'swal_width'},icon: 'error',title: "{{$message}}",showConfirmButton: false, timer: 5000, showClass: {
    popup: 'animate__animated animate__flipInY'
  },
  hideClass: {
    popup: 'animate__animated animate__flipOutY'
  }});</script>
                        @elseif(session('status'))
                             <script> Swal.fire({toast:true,position:'top-end',customClass:{container:'swal_width'},icon: 'success',title: "{{ session('status') }}",showConfirmButton: false, timer: 5000, showClass: {
    popup: 'animate__animated animate__flipInY'
  },
  hideClass: {
    popup: 'animate__animated animate__flipOutY'
  }});</script>
                        @endif