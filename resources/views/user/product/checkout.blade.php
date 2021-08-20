<div class="row">
    <div class="col-md-12">
        <h3 class="text-center">@lang('messages.checkout_completed')</h3>
        <hr>
        <h3 class="text-center p-5 bg-success"> @lang('messages.thank_you')  @lang('messages.your_order_has_been_received') </h3>
    </div>
</div>
    <div class="row">
        <div class="col-md-4">
            <b>@lang('messages.order_number')</b>
            <p> {{ $data['orderNumber'] }} </p>
        </div>
        <div class="col-md-4">
            <b>@lang('messages.date_purchased')</b>
            <p> {{ $data['datePurchased'] }} </p>
        </div>
        <div class="col-md-4">
            <b>@lang('messages.total_payable')</b>
            <p> {{ $data['totalPrice'] }} </p>
        </div>
    </div>
    <br>
{{--    <div class="row">--}}
{{--        <div class="col-md-4"> </div>--}}
{{--        <div class="col-md-4"> @lang('messages.date_purchased')</div>--}}
{{--        <div class="col-md-4"> @lang('messages.total_payable')</div>--}}
{{--    </div>--}}
<div class="mt-7 btn-div">
    <a href="{{ route('user.product') }}" class="btn btn-danger"> <- @lang('messages.continue_shopping')</a>
</div>
