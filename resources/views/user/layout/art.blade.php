 <section class="design" id="design">
     <div class="container">
         <div class="title">
             <h1>Arts & Designs</h1>
             <div class="line"></div>
             <!-- made change here  -->
             {{-- <div class="toggler-and-category bg-brown text-white flex" style="margin-left: 40%; margin-top: 1%"> --}}
             <div class="category-list category-toggler-btn">
                 {{-- <span>Category</span> --}}
                 {{-- <button type="button" class="btn category-toggler-btn text-white"> --}}
                 {{-- <i class="fas fa-circle-arrow-down"></i> --}}
                 {{-- </button> --}}
             </div>
             {{-- <ul id="category-list-items" class="bg-white" style="z-index: 1" class="bg-white">

                 </ul> --}}
             {{-- </div> --}}
         </div>

         <div class="design-content">
             <!-- item -->
             @foreach ($products as $product)
                 <div class="design-item">
                     <div class="design-img">
                         <img src="{{ asset('/uploads' . '/' . $product->image) }}" alt="" />
                     </div>
                     <div class="text-center">
                         <div class="text-capitalize mt-3 mb-1">{{ $product->name }}</div>
                         <span class="fw-bold d-block">RS. {{ $product->price }}</span>
                         <button id="cart" class="button btn-primary mt-3 cart"
                             onClick="set('{{ $product->id }}')">Add to Cart</button>
                         {{-- <a href="{{ route('UserOrderList.show', [$product->id]) }}"
                             class="button btn-primary mt-3 ml-2">Buy it Now</a> --}}
                         <a onClick="buyNow('{{ $product->id }}')" class="button btn-primary mt-3 ml-2">Buy it Now</a>
                     </div>
                 </div>
             @endforeach
         </div>
         <div>
             <div class="center">
                @if (Auth::user())
                <a href="{{ route('home.art') }}" class="button btn-primary ">View More</a>

            @else
                <a href="{{ route('login') }}" class="button btn-primary ">View More</a>
            @endif
             </div>
         </div>
         {{-- @if (Auth::id() > 0)
             <input type="hidden" id="user_type" value="{{ Auth::user()->user_type }}">
         @endif --}}
 </section>
 <script src="https://code.jquery.com/jquery-3.6.3.js" integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM="
     crossorigin="anonymous"></script>
 <script>
     function set($id) {
         if ($("#user_type").val() != 1 &&  $("#user_type").val() != 2) {
             $.ajax({
                 url: '{{ route('home.cart') }}',
                 type: 'POST',
                 data: {
                     "_token": "{{ csrf_token() }}",
                     "id": $id

                 },
                 success: function(response) {
                     debugger
                     console.log(response);
                     if (response.code == 0) {
                         $(".cartCount").text("")
                         $(".cartCount").text(response.count);
                     }
                     if (response.code == 1) {
                         toastr.error(response.message)
                     }
                     if (response.code == 101) {

                         window.location.href = "{{ route('login') }}";

                     }
                 },
                 error: function(xhr) {
                     alert(xhr.responseText);
                 }
             });
         } else {
             toastr.error("Try Login as a user", "Sorry,Not Authorized!!");
         }
     }

     function buyNow($id) {
         if ($("#user_type").val() != 1) {

             $.ajax({
                 url: '{{ route('UserOrderList.check') }}',
                 type: 'POST',
                 data: {
                     "_token": "{{ csrf_token() }}",
                     "id": $id
                 },
                 success: function(response) {
                     console.log(response.message);

                     if (response.code == 0) {
                         var orderId = response.message;
                         window.location.href = "{{ route('UserOrderList.show', ':id') }}".replace(':id',
                             orderId);
                     }

                     if (response.code == 1) {
                         toastr.error(response.message)
                     }
                     if (response.code == 101) {

                         window.location.href = "{{ route('login') }}";

                     }
                 },
                 error: function(xhr) {
                     alert(xhr.responseText);
                 }
             });
         } else {
             toastr.error("Try Login as a user", "Sorry,Not Authorized!!");
         }
     }
     $(document).ready(function() {

         $(".cart").click(function() {
             // debugger

         });
     });
 </script>
