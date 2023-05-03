 <form action="{{ url('admin/master?action=edit-product-attribute') }}" method="POST" enctype="multipart/form-data"
     id="editProductAttrForm">
     @csrf
     <div class="row">
         <input type="hidden" name="id" value="{{ $singleAttr->id }}">
         <div class="col-md-12">
             <label for="" class="form-label required">Product Type</label>
             <select name="editproductType" id="" class="form-select">
                 <option value="">Please select</option>
                 @foreach ($products as $item)
                     <option value="{{ $item->id }}" @if ($singleAttr->product_type_id == $item->id) selected @endif>
                         {{ $item->product_type }}</option>
                 @endforeach
             </select>
         </div>
         <div class="col-md-12 mt-2">
             <label for="" class="form-label required">Attribute Name</label>
             <input type="text" name="editattrName" class="form-control" value="{{ $singleAttr->product_attr_name }}"
                 placeholder="Enter attribute name">
         </div>
     </div>
     <div class="float-end mt-2">
         <button class="btn btn-primary" type="submit" id="btnSubmit">Update</button>
         <button class="btn btn-dark" data-bs-dismiss="modal">Close</button>
     </div>
 </form>

 <script>
     $(document).ready(function() {

         // Edit category
         $('#editProductAttrForm').on('submit', function(e) {
             e.preventDefault();

             //alert('hi');
             var formData = new FormData(this);
             var btnSubmit = $('#btnSubmit');

             $.ajax({
                 type: $(this).attr('method'),
                 url: $(this).attr('action'),
                 contentType: false,
                 processData: false,
                 data: formData,
                 // beforeSend: function() {
                 //     btnSubmitEdit.text("Please wait").attr('disabled', true);
                 // },
                 success: function(data) {
                     // alert message
                     if (!data.success) {
                         if (data.data != null) {
                             $.each(data.data, function(id, error) {
                                 $('#' + id).text(error);
                             });
                         } else {
                             swal('Oops...', data.message, 'error');
                         }
                     } else {
                         swal('Success', data.message, 'success');
                         setTimeout(() => {
                             window.location.reload();
                         }, 2000);
                     }
                 }
             });
         });

     });
 </script>
