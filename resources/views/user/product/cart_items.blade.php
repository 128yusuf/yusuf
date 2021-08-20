@php
    use App\Traits\CustomTraits;
    $subTotal = 0
@endphp
@forelse($data as $key => $value)
    @php
        $total = 0;
        $total = session()->get('cart')[$value->id]['quantity'] * $value->price;
        $subTotal +=$total
    @endphp
    <tr>
        <td>
            <img alt="Image placeholder" width="200" height="200" src="{{ url(config('constant.file_path.product')."/".$value->image) }}">
        </td>
        <td>{{ $value->product_name }}</td>
        <td>
            <input type="number" name="quantity" min="1" max=50 id="product_quantity" class="product_quantity" data-id="{{ $value->id }}" data-price="{{ $value->price }}"  value="{{ session()->get('cart')[$value->id]['quantity'] }}" class="form-control" />
        </td>
        <td>{{ CustomTraits::getPriceWithCurrency($value->price) }}</td>
        <td> {{ CustomTraits::getCurrencySymbol() }}<span class="total_per_product">{{ $total }}</span> </td>
        <td>
            <a href="javascript:void(0)" class="btn btn-danger remove-cart-product" data-id="{{ $value->id }}">x</a>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="4">@lang('messages.add_to_cart_product_for_checkout')</td>
    </tr>
@endforelse

<tr class="text-right">
    <td colspan="5">@lang('messages.sub_total') : {{ CustomTraits::getCurrencySymbol() }}<span class="sub_total">{{ $subTotal }}</span></td>
</tr>
<tr class="text-right">
    <td colspan="5">@lang('messages.grand_total') : {{ CustomTraits::getCurrencySymbol() }}<span class="grand_total">{{ $subTotal }}</span></td>
</tr>
