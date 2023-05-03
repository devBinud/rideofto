<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <table class="table table-bordered table-responsive">
                    <tbody>
                        <tr>
                            <th>Product Type</th>
                            <td>{{ $productsData->product_type }}</td>
                        </tr>
                        <tr>
                            <th>Product Name</th>
                            <td>{{ $productsData->product_name }}</td>
                        </tr>
                        <tr>
                            <th>Category</th>
                            <td>{{ $categoryNames }}</td>
                        </tr>
                        <tr>
                            <th>Description</th>
                            <td>{!! $productsData->product_description !!}</td>
                        </tr>
                        <tr>
                            <th>Initial Stock</th>
                            <td>{{ $productsData->initial_stock }}</td>
                        </tr>
                        <tr>
                            <th>Remaining Stock</th>
                            <td>{{ $productsData->remaining_stock }}</td>
                        </tr>
                        <tr>
                            <th>Attribute</th>
                            <td>{{ $productsData->product_attr_name }}</td>
                        </tr>
                        <tr>
                            <th>Attribute Value</th>
                            <td>{{ $productsData->attribute_value }}</td>
                        </tr>
                        <tr>
                            <th>Unit</th>
                            @if ($productsData->unit == 'unit')
                                <td>{{ $productsData->unit }}</td>
                            @else
                                <td>N/A</td>
                            @endif
                        </tr>
                        <tr>
                            <th>Currency</th>
                            <td>{{ $productsData->currency }}</td>
                        </tr>
                        <tr>
                            <th>Additional Charges</th>
                            @if ($productsData->addn_charge == 'addn_charge')
                                <td>{{ $productsData->addn_charge }}</td>
                            @else
                                <td>N/A</td>
                            @endif
                        </tr>

                        @foreach ($productPrice as $data)
                            @if ($data->pricing_plan_unit == 'hour')
                                <tr>
                                    <th>Hour</th>
                                    <td>{{ $productsData->currency }} {{ $data->price }}.00</td>
                                </tr>
                            @endif
                            @if ($data->pricing_plan_unit == 'day')
                                <tr>
                                    <th>Day</th>
                                    <td>{{ $productsData->currency }} {{ $data->price }}.00</td>

                                </tr>
                            @endif
                            @if ($data->pricing_plan_unit == 'week')
                                <tr>
                                    <th>Week</th>
                                    <td>{{ $productsData->currency }} {{ $data->price }}.00</td>

                                </tr>
                            @endif
                            @if ($data->pricing_plan_unit == 'month')
                                <tr>
                                    <th>Month</th>
                                    <td>{{ $productsData->currency }} {{ $data->price }}.00</td>

                                </tr>
                            @endif
                        @endforeach
                        <tr>
                            <th>Related Accessories</th>
                            <td>
                                @if ($productsData->related_accessories > 0)
                                    @foreach (explode(',', $accessoriesImage) as $data => $img)
                                        <div class="avatar-box thumb-xxl align-self-center me-2">
                                            <span class="avatar-title bg-soft-primary rounded">
                                                <img src="{{ asset('assets/uploads/product-image') . '/' . $img }}"
                                                    style="width: 70px;height:70px;border-radius:10%" alt="">
                                            </span>
                                        </div>
                                    @endforeach
                                @else
                                    <span>
                                        N/A
                                    </span>
                                @endif

                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>
        </div>

    </div>
    <div class="col-md-4">
        <div class="card p-2" style="border-radius: 10%">
            <div class="card-body text-center">
                <div class="mb-2" id="imgHolder" style="min-height: 120px;">
                    <img src="{{ asset('assets/uploads/product-image') . '/' . $productsData->product_thumbnail }}"
                        style="width:80%;border-radius:10%" alt="">
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <table class="table table-bordered table-responsive">
                    <tbody>
                        <tr>
                            <th>Is Home Delivery</th>
                            <td>
                                @if ($productsData->is_home_delivery == 1)
                                    <span>Yes</span>
                                @elseif($productsData->is_home_delivery == 0)
                                    <span>No</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Max Delivery Distance</th>
                            <td>
                                @if ($productsData->max_delivery_distance > 0)
                                    <span>{{ $productsData->max_delivery_distance }} Meter</span>
                                @else
                                    <span>N/A</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Delivery Charge</th>
                            <td>
                                @if ($productsData->delivery_charge > 0)
                                    <span>{{ $productsData->currency }}{{ $productsData->delivery_charge }}.00</span>
                                @else
                                    <span>
                                        N/A
                                    </span>
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
