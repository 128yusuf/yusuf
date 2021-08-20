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
       @forelse($data as $key => $value)
        <div class="row single-product-div">
            <div class="col-md-3 col-md-offset2">
                <a href="{{ route('user.product.detail',['id' => $value->id ]) }}" class="">
                    <img alt="Image placeholder" width="200" height="200" src="{{ url(config('constant.file_path.product')."/".$value->image) }}">
                </a>
            </div>
            <div class="col-md-8">
                <a href="{{ route('user.product.detail',['id' => $value->id ]) }}" class="">
                    <h6>{{ $value->product_name }}</h6>
                </a>
                <p>{{ $value->description }}</p>
                <h6>{{ $value->getCurrencySymbol() }}{{ $value->price }}</h6>
                <div class="d-inline">
                    <a href="javascript:void(0)" class="btn btn-info add_cart" data-id="{{ $value->id }}" data-quantity=1 data-price="{{ $value->price }}")>@lang('messages.add_to_cart')</a>
                </div>
            </div>
        </div>
            @empty
            <h1> @lang('messages.no_product_available') </h1>
        @endforelse
    </div>
@endsection
@push('js')
    <script type="text/javascript">

    </script>
@endpush
