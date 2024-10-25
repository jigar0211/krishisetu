<?php
include_once "include/connection.php";
include_once "include/auth.php";

include_once "include/header.php";
?>
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row mb-5">
        <div class="col-12 col-md-6 col-lg-4 mb-3">
            <div class="card h-100 shadow-sm border-0 rounded-lg">
                <!-- User Info Row -->
                <div class="row d-flex align-items-center mb-3 px-3 pt-3">
                    <div class="col-12 d-flex align-items-center">
                        <a class="nav-link d-flex align-items-center text-decoration-none flex-grow-1" href="javascript:void(0);">
                            <div class="avatar avatar-online me-2">
                                <img src="assets/img/avatars/1.png" alt="User Avatar" class="w-px-40 h-auto rounded-circle">
                            </div>
                            <span class="fw-semibold fs-5 text-dark username-hover">John Doe Farmer</span>
                        </a>
                        <button type="button" class="btn rounded-pill btn-icon btn-light ms-auto" data-bs-toggle="modal" data-bs-target="#modalScrollable">
                            <img src="assets/img/icons/brands/info.svg" alt="" srcset="">
                        </button>
                    </div>
                </div>

                <!-- Card Body -->
                <div class="card-body pt-0">
                    <img class="img-fluid d-flex mx-auto my-4 rounded" src="assets/img/avatars/Screenshot 2024-10-21 093959.png" alt="Card image cap">

                    <!-- Time under the image -->
                    <p class="text-center text-muted mb-2"><small>Posted on 1/1/2023 - 5:40 AM</small></p>

                    <h5 class="card-title fs-4">Card title</h5>
                    <h6 class="card-subtitle text-muted mb-2">Support card subtitle</h6>

                    <p class="card-text my-3">
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eum minus error fugiat assumenda hic alias temporibus.
                    </p>

                    <ul class="list-group list-group-flush mb-4">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>Area of work</span>
                            <span class="fw-bold">5 hectares</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>Work Address</span>
                            <span class="fw-bold ms-2">1234 Main St, New York, USA</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>Price by Area</span>
                            <span class="fw-bold">$50,000</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>Work date</span>
                            <span class="fw-bold">1/1/2023 - 5:40 AM</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>Market Coverage</span>
                            <span class="fw-bold">30 KM</span>
                        </li>
                    </ul>

                    <!-- Card Links -->
                    <div class="d-flex justify-content-between">
                        <a href="javascript:void(0)" class="card-link text-primary text-decoration-none">Card link</a>
                        <a href="javascript:void(0)" class="card-link text-primary text-decoration-none">Another link</a>
                    </div>
                </div>

                <!-- Footer -->
                <div class="card-footer bg-white border-0">
                    <figcaption class="blockquote-footer mb-0 text-muted">
                        <cite title="Source Title">#987312</cite>
                    </figcaption>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-6 col-lg-4 mb-3">
            <div class="card h-100 shadow-sm border-0 rounded-lg">
                <!-- User Info Row -->
                <div class="row d-flex align-items-center mb-3 px-3 pt-3">
                    <div class="col-12 d-flex align-items-center">
                        <a class="nav-link d-flex align-items-center text-decoration-none flex-grow-1" href="javascript:void(0);">
                            <div class="avatar avatar-online me-2">
                                <img src="assets/img/avatars/1.png" alt="User Avatar" class="w-px-40 h-auto rounded-circle">
                            </div>
                            <span class="fw-semibold fs-5 text-dark username-hover">John Doe Driver</span>
                        </a>
                        <button type="button" class="btn rounded-pill btn-icon btn-light ms-auto" data-bs-toggle="modal" data-bs-target="#modalScrollable">
                            <img src="assets/img/icons/brands/info.svg" alt="" srcset="">
                        </button>
                    </div>
                </div>

                <!-- Card Body -->
                <div class="card-body pt-0">
                    <img class="img-fluid d-flex mx-auto my-4 rounded" src="assets/img/avatars/Screenshot 2024-10-21 093959.png" alt="Card image cap">

                    <!-- Time under the image -->
                    <p class="text-center text-muted mb-2"><small>Posted on 1/1/2023 - 5:40 AM</small></p>

                    <h5 class="card-title fs-4">Card title</h5>
                    <h6 class="card-subtitle text-muted mb-2">Support card subtitle</h6>

                    <p class="card-text my-3">
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eum minus error fugiat assumenda hic alias temporibus.
                    </p>

                    <ul class="list-group list-group-flush mb-4">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>Price by Area</span>
                            <span class="fw-bold">$50,000</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>Address</span>
                            <span class="fw-bold ms-2">1234 Main St, New York, USA</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>Post Expiry Date</span>
                            <span class="fw-bold">12/31/2023</span>
                        </li>
                    </ul>

                    <!-- Card Links -->
                    <div class="d-flex justify-content-between">
                        <a href="javascript:void(0)" class="card-link text-primary text-decoration-none">Card link</a>
                        <a href="javascript:void(0)" class="card-link text-primary text-decoration-none">Another link</a>
                    </div>
                </div>

                <!-- Footer -->
                <div class="card-footer bg-white border-0">
                    <figcaption class="blockquote-footer mb-0 text-muted">
                        <cite title="Source Title">#987312</cite>
                    </figcaption>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-6 col-lg-4 mb-3">
            <div class="card h-100 shadow-sm border-0 rounded-lg">
                <!-- User Info Row -->
                <div class="row d-flex align-items-center mb-3 px-3 pt-3">
                    <div class="col-12 d-flex align-items-center">
                        <a class="nav-link d-flex align-items-center text-decoration-none flex-grow-1" href="javascript:void(0);">
                            <div class="avatar avatar-online me-2">
                                <img src="assets/img/avatars/1.png" alt="User Avatar" class="w-px-40 h-auto rounded-circle">
                            </div>
                            <span class="fw-semibold fs-5 text-dark username-hover">John Doe Seller</span>
                        </a>
                        <button type="button" class="btn rounded-pill btn-icon btn-light ms-auto" data-bs-toggle="modal" data-bs-target="#modalScrollable">
                            <img src="assets/img/icons/brands/info.svg" alt="" srcset="">
                        </button>
                    </div>
                </div>

                <!-- Card Body -->
                <div class="card-body pt-0">
                    <img class="img-fluid d-flex mx-auto my-4 rounded" src="assets/img/avatars/Screenshot 2024-10-21 093959.png" alt="Card image cap">

                    <!-- Time under the image -->
                    <p class="text-center text-muted mb-2"><small>Posted on 1/1/2023 - 5:40 AM</small></p>

                    <h5 class="card-title fs-4">Card title</h5>
                    <h6 class="card-subtitle text-muted mb-2">Support card subtitle</h6>

                    <p class="card-text my-3">
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eum minus error fugiat assumenda hic alias temporibus.
                    </p>

                    <ul class="list-group list-group-flush mb-4">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>Quantity</span>
                            <span class="fw-bold">100 tons</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>Product Age</span>
                            <span class="fw-bold">2 months</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>Is Transport Available</span>
                            <span class="fw-bold">Yes</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>Product Expiry Date</span>
                            <span class="fw-bold">12/31/2023</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>Address</span>
                            <span class="fw-bold ms-2">1234 Main St, New York, USA</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>Price</span>
                            <span class="fw-bold">$50,000</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>Market Coverage</span>
                            <span class="fw-bold">30 KM</span>
                        </li>
                    </ul>

                    <!-- Card Links -->
                    <div class="d-flex justify-content-between">
                        <a href="javascript:void(0)" class="card-link text-primary text-decoration-none">Card link</a>
                        <a href="javascript:void(0)" class="card-link text-primary text-decoration-none">Another link</a>
                    </div>
                </div>

                <!-- Footer -->
                <div class="card-footer bg-white border-0">
                    <figcaption class="blockquote-footer mb-0 text-muted">
                        <cite title="Source Title">#987312</cite>
                    </figcaption>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-6 col-lg-4 mb-3">
            <div class="card h-100 shadow-sm border-0 rounded-lg">
                <!-- User Info Row -->
                <div class="row d-flex align-items-center mb-3 px-3 pt-3">
                    <div class="col-12 d-flex align-items-center">
                        <a class="nav-link d-flex align-items-center text-decoration-none flex-grow-1" href="javascript:void(0);">
                            <div class="avatar avatar-online me-2">
                                <img src="assets/img/avatars/1.png" alt="User Avatar" class="w-px-40 h-auto rounded-circle">
                            </div>
                            <span class="fw-semibold fs-5 text-dark username-hover">John Doe Buyer</span>
                        </a>
                        <button type="button" class="btn rounded-pill btn-icon btn-light ms-auto" data-bs-toggle="modal" data-bs-target="#modalScrollable">
                            <img src="assets/img/icons/brands/info.svg" alt="" srcset="">
                        </button>
                    </div>
                </div>

                <!-- Card Body -->
                <div class="card-body pt-0">
                    <h5 class="card-title fs-4">Card title</h5>
                    <h6 class="card-subtitle text-muted mb-2">Support card subtitle</h6>

                    <p class="card-text my-3">
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eum minus error fugiat assumenda hic alias temporibus.
                    </p>

                    <ul class="list-group list-group-flush mb-4">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>Price</span>
                            <span class="fw-bold">$50,000</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>Address</span>
                            <span class="fw-bold ms-2">1234 Main St, New York, USA</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>Quantity</span>
                            <span class="fw-bold">100 tons</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>Is Transport Available</span>
                            <span class="fw-bold">Yes</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>Expiry Date</span>
                            <span class="fw-bold">12/31/2023</span>
                        </li>
                    </ul>

                    <!-- Card Links -->
                    <div class="d-flex justify-content-between">
                        <a href="javascript:void(0)" class="card-link text-primary text-decoration-none">Card link</a>
                        <a href="javascript:void(0)" class="card-link text-primary text-decoration-none">Another link</a>
                    </div>
                </div>

                <!-- Footer -->
                <div class="card-footer bg-white border-0">
                    <figcaption class="blockquote-footer mb-0 text-muted">
                        <cite title="Source Title">#987312</cite>
                    </figcaption>
                </div>
            </div>
        </div>

    </div>

    <!-- Modal for Profile Info -->
    <div class="modal fade" id="modalScrollable" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalScrollableTitle">Profile Information</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Profile Image and Name -->
                    <div class="text-center mb-4">
                        <img src="assets/img/avatars/1.png" alt="Profile Image" class="rounded-circle mb-3" style="width: 100px; height: 100px;">
                        <h5 class="fw-bold">John Doe</h5>
                        <small class="text-muted">Software Engineer</small>
                    </div>

                    <!-- Profile Details -->
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>Mobile</span>
                            <span class="fw-bold">+1 234 567 8901</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>Email</span>
                            <span class="fw-bold">johndoe@example.com</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>Location</span>
                            <span class="fw-bold">New York, USA</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>


    <div class="row mb-5">

    </div>



</div>
<?php
include_once "include/footer.php"
?>