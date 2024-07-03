<style>
        .star-rating {
            font-size: 3rem;
            cursor: pointer;
        }
        .star {
            color: gray;
        }
        .star.selected {
            color: gold;
        }
    </style>
<div class="container mt-5">
    <div class="col-12"><iconify-icon icon="icon-park-outline:back" width="40" height="40"></iconify-icon></div>
    <div class="col-12 text-center text-dark fw-bold fs-1 mb-2">Give Feedback</div>
    <div class="col-12 text-center text-dark fw-semibold fs-5">Rate your experience</div>
    <div class="star-rating text-center">
        <span class="star" data-value="1">&#9733;</span>
        <span class="star" data-value="2">&#9733;</span>
        <span class="star" data-value="3">&#9733;</span>
        <span class="star" data-value="4">&#9733;</span>
        <span class="star" data-value="5">&#9733;</span>
    </div>
    <input type="hidden" id="rating-value" name="rating-value">
    <div id="rating-message" class="mt-3"></div>
    <div class="row px-3">
        <div class="col-12">
            <label for="feedbackContent" class="text-dark fw-semibold py-2">Comment, if any?</label>
            <textarea class="form-control" id="feedbackContent" rows="3" placeholder="Say something here..."></textarea>
            <button type="button" class="btn btn-primary w-100 rounded-2 mt-3" id="submit_feedback">Submit Feedback</button>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('.star').on('click', function() {
            var rating = $(this).data('value');
            $('.star').removeClass('selected');
            for (var i = 1; i <= rating; i++) {
                $('.star[data-value="' + i + '"]').addClass('selected');
            }
            // Send the rating to the server
            // $.ajax({
            //     url: 'submit_rating.php',
            //     type: 'POST',
            //     data: { rating: rating },
            //     success: function(response) {
            //         $('#rating-message').text('Thank you for your feedback!');
            //     },
            //     error: function() {
            //         $('#rating-message').text('There was an error. Please try again.');
            //     }
            // });
            $('#rating-value').val(rating);
        });

        $('#submit_feedback').on('click', function() {
            var rating = $('#rating-value').val();
            var feedbackComment = $('#feedbackContent').val();
            let formData = localStorage.getItem('formData');
            // Parse the form data
            let params = new URLSearchParams(formData);
            let fullname = params.get('fullname');
            let contactno = params.get('contactno');
            let email = params.get('email');
            // Convert params to an object
            let data = {};
            params.forEach((value, key) => {
                data[key] = value;
            });
            
            // Add rating and action separately
            data['rating'] = rating;
            data['remarks'] = feedbackComment;

            // alert(JSON.stringify(data, null, 2));
                //submit user feedback
            let urlEncodedData = $.param(data);

            $.ajax({
                url: "process/user_action.php",
                method: "POST",
                data: urlEncodedData+"&action=submitFeedback",
                dataType: "json",
                success: function(response) {
                    if(response.success){
                        toastr.success(response.message);
                        setTimeout(function() {
                          window.location.href = "index.php?route=user-overview";
                        }, 2000);
                    }else{
                        toastr.error(response.message);
                    }
                }
            });
        });
    });
</script>