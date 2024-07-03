
<style>
    .card:hover {
        background: radial-gradient(60% 60% at 50.25% 40%, #FF7979 0%, #F20000 100%);
        cursor: pointer;
    }
</style>
<div class="position-relative overflow-hidden text-bg-light min-vh-100 d-flex align-items-center justify-content-center">
    <div class="d-flex align-items-center justify-content-center w-100">
        <div class="row justify-content-center w-100">
            <div class="col-md-8 col-lg-6 col-xxl-3">
                <div class="row gy-2">
                    <div class="col-12">
                        <div class="card py-5 shadow-sm" id="takeOrder">
                            <h5 class="text-center mt-3 text-uppercase">Take Order</h5>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="card py-5 shadow-sm" id="takeSurvey">
                            <h5 class="text-center mt-3 text-uppercase">Take Survey</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('#takeOrder').click(function() {
            window.location.href = "index.php?route=eskina-order";
        });
        $('#takeSurvey').click(function() {
            window.location.href = "index.php?route=feedback";
        });
    });
</script>