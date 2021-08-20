@extends('user.layouts.app')

@push('styles')

    <style>
        .single-product-div {
            margin-top: 20px;
        }
        h6 {
            margin: 30px 0px 20px 20px;
        }
        .add-to-cart,.btn-div {
            margin-top: 30px;
        }
    </style>
@endpush
@section('content')
    <div class="container">
        <div class="row single-product-div">
            <div class="col-md-5">
                    <img alt="Image placeholder" width="400" height="400" src="{{ url(config('constant.file_path.product')."/".$data->image) }}">
            </div>
            <div class="col-md-7">
                <h6>{{ $data->product_name }}</h6>
                <p>{{ $data->description }}</p>
                <h6>{{ $data->getCurrencySymbol() }} {{ $data->price }}</h6>
                <div class="add-to-cart">
                    <a href="javascript:void(0)" class="btn btn-info add_cart" data-id="{{ $data->id }}" data-quantity=1 data-price="{{ $data->price }}">@lang('messages.add_to_cart')</a>
                </div>
            </div>
            <div class="col-md-12 btn-div d-inline">
                <a href="{{ route('user.product') }}" class="btn btn-info"> <- @lang('messages.back_to_product_list')</a>
                <a href="{{ route('user.product.cart') }}" class="btn btn-info"> @lang('messages.go_to_cart') -> </a>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script type="text/javascript">

    </script>
@endpush
