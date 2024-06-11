<div class="position-relative overflow-hidden text-bg-light min-vh-100 d-flex align-items-center justify-content-center">
    <div class="d-flex align-items-center justify-content-center w-100">
        <div class="row justify-content-center w-100">
            <div class="col-md-8 col-lg-6 col-xxl-3">
                <div class="card mb-0">
                    <h5 class="text-center mt-3">Personal Details</h5>
                    <div class="card-body">
                        <form id="personalForm">
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Full Name</label>
                            <input type="text" class="form-control" id="uFullname" name="fullname" required>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Contact No.</label>
                            <input type="text" class="form-control" id="uContact" maxlength="11" name="contactno">
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Email</label>
                            <input type="email" class="form-control" id="uEmail" name="email" aria-describedby="emailHelp">
                        </div>
                        <button class="btn btn-primary float-end text-uppercase" id="proceedBtn">Proceed</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('#personalForm').on('submit', function(event){
        event.preventDefault();
        });
        $('#proceedBtn').click(function() {
            var fullNameInput = $('#uFullname').val().trim();
            if (fullNameInput !== '') {
                var formData = $('#personalForm').serialize();
                localStorage.setItem('formData', formData);
                window.location.href = "index.php?route=user-overview";
            } else {
                alert("Please Enter your Fullname");
            }   
        });
        $('#uContact').on('input', function(){
            $(this).val($(this).val().replace(/\D/g,''));
        });
        var retrievedFormData = localStorage.getItem('formData');

        // If data exists in local storage, do something with it
        if (retrievedFormData) {
            // Use the retrieved form data as needed
            console.log(retrievedFormData);
        } else {
            // Handle the case when no data is found in local storage
            console.log("No form data found in local storage.");
        }
    });
    
</script>