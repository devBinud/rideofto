 <form action="{{ url('admin/master?action=edit-category') }}" method="POST" enctype="multipart/form-data"
     id="editCategoryForm">
     @csrf
     <div class="row">
         <input type="hidden" name="id" value="{{ $singleCategory->category_id }}">
         <div class="col-md-12">
             <label for="" class="form-label required">Product Type</label>
             <select name="editproductType" class="form-select">
                 <option value="">Please select</option>
                 @foreach ($products as $item)
                     <option value="{{ $item->id }}" @if ($singleCategory->product_type_id == $item->id) selected @endif>
                         {{ $item->product_type }}</option>
                 @endforeach
             </select>
         </div>
         <div class="col-md-12 mt-2">
             <label for="" class="form-label required">Category</label>
             <input type="text" name="editcategory" id="editcategory" class="form-control"
                 placeholder="Enter category" value="{{ $singleCategory->product_category }}">
         </div>
         <div class="col-md-12 mt-2">
             <label for="" class="form-label required">Category Slug</label>
             <input type="text" name="editcategorySlug" id="editcategorySlug" class="form-control"
                 value="{{ $singleCategory->category_slug }}">
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
         $('#editCategoryForm').on('submit', function(e) {
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

         // Product Category Slug
         $('#editcategory').keyup(function() {
             var title = $(this).val();
             // alert(title);
             var slug = $('#editcategorySlug');
             // alert(slug);
             if (title.length > 0) {
                 $.get("{{ url('/generate-slug') }}", {
                     data: title,
                 }).done(function(data) {
                     slug.val(data);
                 });
             } else {
                 slug.val("");
             }
         });
     });
 </script>
