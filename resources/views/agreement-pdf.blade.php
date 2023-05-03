<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <style>
        body {
            font-family: sans-serif !important;
            /* color: #303e67 !important ; */
        }
    </style>
</head>
<body>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <h4 class="fw-bold pb-2">PAYMENT PERCENTAGE DISTRIBUTION AGREEMENT </h4>

                <p class = "pb-1">This Payment Percentage Distribution Agreement is entered into as of {{ $agreement_data['valid_from'] }} (the "Effective Date") by and 
                    between {{ $vendor_data->store_name }}  ("Party 1") and Rideofto ("Party 2") and will be valid till {{ $agreement_data['valid_till'] }}  </p>
                <p class = "pb-1">WHEREAS, Party 1 and Party 2 have entered into a business relationship pursuant to which Party 2, Rideofto  will receive 
                    payments for services rendered by Party 1 and Party 2, {{ $vendor_data->store_name }} & Rideofto  (the 
                    "Services"); </p>
                
                <p class = "pb-1">WHEREAS, Party 1 and Party 2 desire to establish the percentage distribution of the payments to be received by Party 2, 
                    Rideofto for the Services rendered by both Parties </p>
                
                <p class = "pb-1">NOW, THEREFORE, in consideration of the mutual promises and covenants contained herein, and other good and valuable 
                    consideration, the receipt and sufficiency of which are hereby acknowledged, the parties agree as follows: </p>

                <p class = "pb-1"><span class="fw-bold">Payment Distribution :</span> Party 2, being the recipient of the payment [Rideofto] agrees to pay Party 1,  {{ $vendor_data->store_name }} {{ $agreement_data['num'] }} percent ({{ $agreement_data['vendor_percentage'] }} %) of the total amount received for the Services rendered 
                    by both Parties. These payments will be received and collected by Party 2 [Rideofto] for each and every transaction and 
                    at the end of every month a total as per the decided percentage ({{ $agreement_data['vendor_percentage'] }} %) will be transferred to 
                    Party 1. </p>


                <p class = "pb-1"><span class="fw-bold">Payment Schedule :</span> Party 2, [Rideofto] will pay Party 1, {{ $vendor_data->store_name }} the certain percentage of the total 
                    amount received for the Services rendered after the end of every month by the 3rd day of the following month. This will 
                    be the sum total of all the payments received as per ({{ $agreement_data['vendor_percentage'] }} %), which is the decided percentage 
                    of share. </p>

                <p class = "pb-1"><span class="fw-bold">Taxes :</span> Both Parties shall be responsible for any and all taxes associated with such payments, as per the law of the land, 
                    received pursuant to this Agreement. </p>
                   
                <p class = "pb-1"><span class="fw-bold">Relationship of Parties :</span> The relationship between Party 1, {{ $vendor_data->store_name }}   and Party 2, Rideofto is that of 
                    Vendor and Broker.</p>
                      
                <p class = "pb-1"><span class="fw-bold">Termination : </span> Either party may terminate this Agreement upon [insert number] days written notice to the other party.</p>
                     
                <p class = "pb-1"><span class="fw-bold">Governing  Law :</span> This  Agreement  shall  be  governed  by  and  construed  in  accordance  with  the  laws  of  {{ $agreement_data['governed_by'] }} </p>
                
                <p class = "pb-1"><span class="fw-bold">Entire Agreement : </span> This Agreement constitutes the entire agreement between the parties and supersedes all prior and 
                    contemporaneous agreements and understandings, whether written or oral, relating to the subject matter of this 
                    Agreement. </p>
                    
                <p>IN WITNESS WHEREOF, the parties have executed this Agreement as of the Effective Date. </p>
                
            </div>
        </div>
    </div>
    
</body>
</html>











 






