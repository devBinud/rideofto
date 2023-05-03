  <form action="{{ url('admin/vendor?action=vendor-change-password') }}" method="POST" id="resetPasswordForm"
      enctype="multipart/form-data">
      @csrf
      <input type="hidden" name="vendorId" value="{{ $vendorId }}">
      <div class="row">
          <div class="col-md-12">
              <label for="Password" class="form-label  required" style="color: #012970"><i class="fas fa-lock"></i>
                  Current
                  Password </label>
              <div class="input-group">
                  <input type="password" class="form-control" name="current_password" id="current_password"
                      placeholder="Enter your current password ?">
                  <span class="input-group-text" id="togglePassword" type="button"><i class="fas fa-eye"></i>
                  </span>
              </div>
          </div>
          <div class="col-md-12 mt-2">
              <label for="Password" class="form-label  required" style="color: #012970"><i class="fas fa-lock"></i>
                  Create new
                  password </label>
              <div class="input-group">
                  <input type="password" class="form-control" name="new_password" id="new_password"
                      placeholder="Create new password !">
                  <span class="input-group-text" id="togglePassword_two" type="button"><i class="fas fa-eye"></i>
                  </span>
              </div>
          </div>
          <div class="col-md-12 mt-2">
              <label for="Password" class="form-label  required" style="color: #012970"><i class="fas fa-lock"></i>
                  Confirm
                  password </label>
              <div class="input-group">
                  <input type="password" class="form-control" name="confirm_password" id="confirm_password"
                      placeholder="Enter confirm password !">
                  <span class="input-group-text" id="togglePassword_three" type="button"><i class="fas fa-eye"></i>
                  </span>
              </div>
          </div>

          <div class="float-end mt-4">
              <button type="submit" class="btn btn-success" id="btnSubmit"><i class="fas fa-lock"></i>
                  Change Password</button>
              <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
          </div>
  </form>

  <script>
      $(document).ready(function() {
          $('#resetPasswordForm').submit(function(e) {
              e.preventDefault();
              var formData = new FormData(this);
              var submit = $("#btnSubmit");

              $.ajax({
                  url: $(this).attr('action'),
                  type: $(this).attr('method'),
                  data: formData,
                  contentType: false,
                  processData: false,
                  beforeSend: function() {
                      submit.attr('disabled', true).html('Please wait..');
                  },
                  success: function(data) {
                      if (!data.success) {
                          alert(data.message);
                      } else {
                          alert(data.message);
                          window.location.reload();

                      }
                  },
                  complete: function() {
                      submit.attr('disabled', false).html('Reset Password');
                  }
              });

          });
      });

      //============== Old Password
      const togglePassword = document.querySelector('#togglePassword');
      const old_password = document.querySelector('#current_password');
      togglePassword.addEventListener('click', function(e) {
          // toggle the type attribute
          const type = old_password.getAttribute('type') === 'password' ? 'text' : 'password';
          old_password.setAttribute('type', type);
          // toggle the eye slash icon
          // this.classList.toggleClass('fas fa-eye-slash');
      });

      //============ New Password
      const togglePassword_two = document.querySelector('#togglePassword_two');
      const new_password = document.querySelector('#new_password');

      togglePassword_two.addEventListener('click', function(e) {
          // toggle the type attribute
          const type = new_password.getAttribute('type') === 'password' ? 'text' : 'password';
          new_password.setAttribute('type', type);
          // toggle the eye slash icon
          // this.classList.toggleClass('fas fa-eye-slash');
      });
      //===================== Confirm Password
      const togglePassword_three = document.querySelector('#togglePassword_three');
      const confirm_password = document.querySelector('#confirm_password');

      togglePassword_three.addEventListener('click', function(e) {
          // toggle the type attribute
          const type = confirm_password.getAttribute('type') === 'password' ? 'text' : 'password';
          confirm_password.setAttribute('type', type);
          // toggle the eye slash icon
          // this.classList.toggleClass('fas fa-eye-slash');
      });
  </script>
