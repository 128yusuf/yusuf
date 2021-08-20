@extends('shop.layouts.app')

@push('styles')
@endpush
@section('content')
    <div class="row">
        <div class="col-md-6 product-title-list">
            <h1>Manage Product</h1>
        </div>
        <div class="col-md-12">
            <div class="card-body">
                <form method="post" action="{{ route('product.store') }}" enctype="multipart/form-data" autocomplete="off">
                    @csrf
                    @method('post')

                    @if (session('status'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('status') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    <div class="pl-lg-4 row">

                        <div class="col-md-6 form-group{{ $errors->has('product_name') ? ' has-danger' : '' }}">
                            <label class="form-control-label" for="input-product_name">{{ __('Product Name') }}</label>
                            <input type="text" name="product_name" id="input-product_name" class="form-control form-control-alternative{{ $errors->has('product_name') ? ' is-invalid' : '' }}" placeholder="{{ __('Product Name') }}" value="{{ old('product_name', '') }}" autofocus>

                            @if ($errors->has('product_name'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('product_name') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="col-md-6 form-group{{ $errors->has('price') ? ' has-danger' : '' }}">
                            <label class="form-control-label" for="input-name">{{ __('Price') }}</label>
                            <input type="text" name="price" id="input-price" class="form-control form-control-alternative{{ $errors->has('price') ? ' is-invalid' : '' }}" value="{{ old('price', '') }}" autofocus>

                            @if ($errors->has('price'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('price') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="col-md-6 form-group{{ $errors->has('category') ? ' has-danger' : '' }}">
                            <label class="form-control-label" for="category">{{ __('Category') }}</label>
                            <select class="form-control" name="category" id="category">
                                <option value="">Select</option>
                                @foreach(config('constant.category') as $key => $value )
                                    <option value={{ $key }}>{{ $value }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('category'))
                                <span class="text-danger" role="alert">
                                    <strong>{{ $errors->first('category') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="col-md-6 form-group{{ $errors->has('sub_category') ? ' has-danger' : '' }}">
                            <label class="form-control-label" for="sub_category">{{ __('Sub Category') }}</label>
                            <select class="form-control" name="sub_category" id="sub_category">
                                <option value="">Select</option>
                                @foreach(config('constant.sub_category')[1] as $key => $value )
                                    <option value={{ $key }}>{{ $value }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('sub_category'))
                                <span class="text-danger" role="alert">
                                    <strong>{{ $errors->first('sub_category') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="col-md-6 form-group{{ $errors->has('description') ? ' has-danger' : '' }}">
                            <label class="form-control-label" for="input-description">{{ __('Description') }}</label>
                            <textarea name="description" id="description" class="form-control form-control-alternative{{ $errors->has('description') ? ' is-invalid' : '' }}" placeholder="{{ __('Description') }}" rows="5">{{ old('description', '') }}</textarea>
                            @if ($errors->has('description'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('description') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="col-md-3 form-group{{ $errors->has('image') ? ' has-danger' : '' }}">
                            <label class="form-control-label" for="input-email">{{ __('Image') }}</label>
                            <input type="file" name="image" id="image" class="form-control form-control-alternative{{ $errors->has('image') ? ' is-invalid' : '' }}" value="{{ old('image', '') }}" required>

                            @if ($errors->has('image'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('image') }}</strong>
                                </span>
                            @endif

                        </div>
                        <div class="col-md-3 imageDiv">
                        </div>
                        <div class="col-md-12">
                            <hr>
                            <p class="text-danger"><b>Info :</b> Enter Product Name And Description in Dutch Language</p>
                        </div>

                        <div class="col-md-6 form-group{{ $errors->has('product_name_nl') ? ' has-danger' : '' }}">
                            <label class="form-control-label" for="input-product_name_nl">{{ __('Product Name') }} (NL)</label>
                            <input type="text" name="product_name_nl" id="input-product_name_nl" class="form-control form-control-alternative{{ $errors->has('product_name_nl') ? ' is-invalid' : '' }}" placeholder="{{ __('Productnaam') }}" value="{{ old('product_name_nl', '') }}" autofocus>

                            @if ($errors->has('product_name_nl'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('product_name_nl') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="col-md-6 form-group{{ $errors->has('description_nl') ? ' has-danger' : '' }}">
                            <label class="form-control-label" for="input-description_nl">{{ __('Description') }} (NL)</label>
                            <textarea name="description_nl" id="description_nl" class="form-control form-control-alternative{{ $errors->has('description_nl') ? ' is-invalid' : '' }}" placeholder="{{ __('Omschrijving') }}" rows="5">{{ old('description_nl', '') }}</textarea>
                            @if ($errors->has('description_nl'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('description_nl') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="col-md-6">
                            <label class="form-control-label" for="input-status">{{ __('Status') }}</label>
                            <label class="switch">
                                <input name="status" type="checkbox" checked>
                                <span class="slider round"></span>
                            </label><br><br>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-success mt-4">{{ __('Save') }}</button>
                            <a href="{{ route('products') }}" type="button" class="btn btn-danger mt-4">{{ __('Cancel') }}</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script type="text/javascript">

        $(document).ready(function() {

            var sub_category = @json(config('constant.sub_category'));
            $(document).on('change','#category',function(){
                let category = $(this).val()

                let options = '<option value="">Select</option>'
                $('#sub_category').empty()
                $.each(sub_category[category],function(key, value){
                    options+=`<option value="${key}">${value}</option>`
                })
                $('#sub_category').html(options)
            });

        })
    </script>
@endpush
