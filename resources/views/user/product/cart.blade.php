@extends('user.layouts.app')

@push('styles')

    <style>
        .single-product-div {
            margin-top: 20px;
        }
    </style>
@endpush
@section('content')
    <div class="container">
        <div class="cart-page">
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-bordered data-table">
                        <thead>
                        <tr>
                            <th>@lang('messages.image')</th>
                            <th>@lang('messages.description')</th>
                            <th>@lang('messages.quantity')</th>
                            <th>@lang('messages.unit_price')</th>
                            <th width="100px">@lang('messages.total')</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-12 btn-div d-inline">
                    <a href="{{ route('user.product') }}" class="btn btn-danger"> <- @lang('messages.continue_shopping')</a>
                    <a href="javascript:void(0)" class="btn btn-info btn-checkout"> @lang('messages.checkout') -> </a>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script type="text/javascript">

         $(document).ready(function() {

             let totalItem = {{ session()->has('cart') ? count(session()->get('cart')) : 0 }}

             const displayCheckOut = (totalItem) => {
                 if(totalItem == 0) {  $('.btn-checkout').hide(); }
             }

             const getItemsTotal = () => {
                 let total = 0.00;
                 $('tbody tr').each(function() {
                     let itemTotal = $(this).find('span.total_per_product').text()
                     if(itemTotal)
                        total += parseFloat(itemTotal);
                 })
                 return total
             }

            displayCheckOut(totalItem)
            const getCartData = () =>  {
                $.ajax({
                    url: "{{ route('user.product.cart') }}",
                    type: "get",
                    success: function (response) {
                        if( response.code == 200 ) {

                            $('table tbody').html(response.data)
                        }
                        else {
                            alert('Something went wrong!.Please try again')
                        }
                    }
                })
            }
            getCartData()

             $(document).on('click','.remove-cart-product',function(){
                 var requestData = {
                     id : $(this).data('id'),
                 }

                 $.ajax({
                     url: "{{ route('user.product.remove') }}",
                     type: "POST",
                     data: requestData,
                     success: function (response) {
                         if( response.code == 200 ) {
                             $('.item-counter').text(response.data.totalItems);
                             getCartData()
                             displayCheckOut(response.data.totalItems)
                         }
                         else
                             alert(response.msg)
                     }
                 })
             })


            $(document).on('click','.btn-checkout',function(){

                $.ajax({
                    url: "{{ route('user.product.checkout') }}",
                    type: "POST",
                    success: function (response) {

                        if( response.code == 200 ){

                            $('.cart-page').html(response.data)
                            $('.item-counter').text(0)
                        }else
                            alert(response.msg)
                    },
                    data: {}
                })
            })

            $(document).on('input','.product_quantity',debounce(function(){
                var requestData = {
                    id : $(this).data('id'),
                    price : $(this).data('price'),
                    quantity : $(this).val(),
                    fromCartPage : true
                }

                let total_per_product = ($(this).val() * $(this).data('price')).toFixed(2);
                $(this).closest('tr').find('span.total_per_product').text(total_per_product)
                let total = getItemsTotal().toFixed(4)
                    $('.sub_total').text(total)
                    $('.grand_total').text(total)

                $.ajax({
                    url: "{{ route('user.addtocart') }}",
                    type: "POST",
                    data: requestData,
                    success: function (response) {
                            // getCartData()
                    }
                })
            },500))

             function debounce(func, wait, immediate) {
                 var timeout;
                 return function() {
                     var context = this, args = arguments;
                     var later = function() {
                         timeout = null;
                         if (!immediate) func.apply(context, args);
                     };
                     var callNow = immediate && !timeout;
                     clearTimeout(timeout);
                     timeout = setTimeout(later, wait);
                     if (callNow) func.apply(context, args);
                 };
             };
        })
    </script>
@endpush
