<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <table class="table table-bordered table-responsive">
                    <tbody>
                        <tr>
                            <th>Discount Type</th>
                            <td>{{ $discountData->discount_type }}</td>
                        </tr>
                        <tr>
                            <th>Discount Amount</th>
                            <td>{{ $discountData->discount }}</td>
                        <tr>
                            <th>Start Date</th>
                            <td>{{ date('d M,Y h:i A', strtotime($discountData->starting_from)) }}</td>
                        </tr>
                        <tr>
                            <th>End Date</th>
                            <td>{{ date('d M,Y h:i A', strtotime($discountData->valid_till)) }}</td>
                        </tr>
                        <tr>
                            <th>Product</th>
                            <td>{{ $productName }}</td>
                        </tr>
                        <tr>
                            <th>Category</th>
                            <td>{{ $categoryNames == null ? 'N/A' : $categoryNames }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

</div>
