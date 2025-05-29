<?php
//
//die('do not use');
//debug(true);
//printarray($_POST);
?>


<!-- Page header -->
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <!-- Page pre-title -->
                <div class="page-pretitle">
                    Overview
                </div>
                <h2 class="page-title">
                    Vertical layout
                </h2>
            </div>
            <!-- Page title actions -->
            <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">
                  <span class="d-none d-sm-inline">
                    <a href="#" class="btn">
                      New view
                    </a>
                  </span>
                    <a href="#" class="btn btn-primary d-none d-sm-inline-block" data-bs-toggle="modal" data-bs-target="#modal-report">
                        <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>
                        Create new report
                    </a>
                    <a href="#" class="btn btn-primary d-sm-none btn-icon" data-bs-toggle="modal" data-bs-target="#modal-report" aria-label="Create new report">
                        <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Page body -->
<div class="page-body">
    <div class="container-xl">

        <div class="col-lg-12">
            <div class="row row-cards">
                <div class="col-12">
                    <form class="card" enctype="multipart/form-data" method="POST" action="<?php echo $_SERVER['PHP_SELF'].'?navId='.$navId;?>">

                        <div class="card-body">
                            <h3 class="card-title">Edit Profile</h3>
                            <div class="row row-cards">
                                <div class="col-md-5">
                                    <div class="mb-3">
                                        <label class="form-label">Company</label>
                                        <input type="text" name="company" class="form-control" disabled="" placeholder="Company" value="Creative Code Inc.">
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label">Username</label>
                                        <input type="text" name="Username" class="form-control" placeholder="Username" value="michael23">
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Email address</label>
                                        <input type="email" class="form-control" placeholder="Email">
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">First Name</label>
                                        <input type="text" class="form-control" placeholder="Company" value="Chet">
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Last Name</label>
                                        <input type="text" class="form-control" placeholder="Last Name" value="Faker">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label">Address</label>
                                        <input type="text" class="form-control" placeholder="Home Address" value="Melbourne, Australia">
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">City</label>
                                        <input type="text" class="form-control" placeholder="City" value="Melbourne">
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label">Postal Code</label>
                                        <input type="test" class="form-control" placeholder="ZIP Code">
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="mb-3">
                                        <label class="form-label">Country</label>
                                        <select class="form-control form-select">
                                            <option value="">Germany</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3 mb-0">
                                        <label class="form-label">About Me</label>
                                        <textarea rows="5" class="form-control" placeholder="Here can be your description" value="Mike">Oh so, your weak rhyme
You doubt I'll bother, reading into it
I'll probably won't, left to my own devices
But that's the difference in our opinions.</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-end">
                            <button type="submit" class="btn btn-primary">Update Profile</button>
                        </div>
                    </form>
                </div>
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">HTTP Request</h3>
                        </div>
                        <div class="card-body">
                            <div class="row row-cards">
                                <div class="mb-3 col-sm-4 col-md-2">
                                    <label class="form-label required">Method</label>
                                    <select class="form-select">
                                        <option value="GET">GET</option>
                                        <option value="POST">POST</option>
                                        <option value="PUT">PUT</option>
                                        <option value="HEAD">HEAD</option>
                                        <option value="DELETE">DELETE</option>
                                        <option value="PATCH">PATCH</option>
                                    </select>
                                </div>
                                <div class="mb-3 col-sm-8 col-md-10">
                                    <label class="form-label required">URL</label>
                                    <input name="url" type="text" class="form-control" value="https://content.googleapis.com/discovery/v1/apis/surveys/v2/rest">
                                </div>
                            </div>
                            <div class="form-label">Assertions</div>
                            <div class="table-responsive">
                                <table class="table mb-0">
                                    <thead>
                                    <tr>
                                        <th>Source</th>
                                        <th>Property</th>
                                        <th>Comparison</th>
                                        <th>Target</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>
                                            <select class="form-select">
                                                <option value="STATUS_CODE" selected="">Status code</option>
                                                <option value="JSON_BODY">JSON body</option>
                                                <option value="HEADERS">Headers</option>
                                                <option value="TEXT_BODY">Text body</option>
                                                <option value="RESPONSE_TIME">Response time</option>
                                            </select>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control"></td>
                                        <td>
                                            <select class="form-select">
                                                <option value="EQUALS" selected="">Equals</option>
                                                <option value="NOT_EQUALS">Not equals</option>
                                                <option value="HAS_KEY">Has key</option>
                                                <option value="NOT_HAS_KEY">Not has key</option>
                                                <option value="HAS_VALUE">Has value</option>
                                                <option value="NOT_HAS_VALUE">Not has value</option>
                                                <option value="IS_EMPTY">Is empty</option>
                                                <option value="NOT_EMPTY">Is not empty</option>
                                                <option value="GREATER_THAN">Greater than</option>
                                                <option value="LESS_THAN">Less than</option>
                                            </select>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" value="200">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <select class="form-select">
                                                <option value="STATUS_CODE">Status code</option>
                                                <option value="JSON_BODY" selected="">JSON body</option>
                                                <option value="HEADERS">Headers</option>
                                                <option value="TEXT_BODY">Text body</option>
                                                <option value="RESPONSE_TIME">Response time</option>
                                            </select>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" value="parameters.alt.type">
                                        </td>
                                        <td>
                                            <select class="form-select">
                                                <option value="EQUALS">Equals</option>
                                                <option value="NOT_EQUALS">Not equals</option>
                                                <option value="HAS_KEY">Has key</option>
                                                <option value="NOT_HAS_KEY">Not has key</option>
                                                <option value="HAS_VALUE" selected="">Has value</option>
                                                <option value="NOT_HAS_VALUE">Not has value</option>
                                                <option value="IS_EMPTY">Is empty</option>
                                                <option value="NOT_EMPTY">Is not empty</option>
                                                <option value="GREATER_THAN">Greater than</option>
                                                <option value="LESS_THAN">Less than</option>
                                            </select>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" value="string">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <select class="form-select">
                                                <option value="STATUS_CODE">Status code</option>
                                                <option value="JSON_BODY">JSON body</option>
                                                <option value="HEADERS">Headers</option>
                                                <option value="TEXT_BODY">Text body</option>
                                                <option value="RESPONSE_TIME" selected="">Response time</option>
                                            </select>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control"></td>
                                        <td>
                                            <select class="form-select">
                                                <option value="EQUALS">Equals</option>
                                                <option value="NOT_EQUALS">Not equals</option>
                                                <option value="HAS_KEY">Has key</option>
                                                <option value="NOT_HAS_KEY">Not has key</option>
                                                <option value="HAS_VALUE">Has value</option>
                                                <option value="NOT_HAS_VALUE">Not has value</option>
                                                <option value="IS_EMPTY">Is empty</option>
                                                <option value="NOT_EMPTY">Is not empty</option>
                                                <option value="GREATER_THAN">Greater than</option>
                                                <option value="LESS_THAN" selected="">Less than</option>
                                            </select>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" value="500">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <select class="form-select">
                                                <option value="STATUS_CODE">Status code</option>
                                                <option value="JSON_BODY">JSON body</option>
                                                <option value="HEADERS" selected="">Headers</option>
                                                <option value="TEXT_BODY">Text body</option>
                                                <option value="RESPONSE_TIME">Response time</option>
                                            </select>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" value="content-type">
                                        </td>
                                        <td>
                                            <select class="form-select">
                                                <option value="EQUALS" selected="">Equals</option>
                                                <option value="NOT_EQUALS">Not equals</option>
                                                <option value="HAS_KEY">Has key</option>
                                                <option value="NOT_HAS_KEY">Not has key</option>
                                                <option value="HAS_VALUE">Has value</option>
                                                <option value="NOT_HAS_VALUE">Not has value</option>
                                                <option value="IS_EMPTY">Is empty</option>
                                                <option value="NOT_EMPTY">Is not empty</option>
                                                <option value="GREATER_THAN">Greater than</option>
                                                <option value="LESS_THAN">Less than</option>
                                            </select>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" value="application/json; charset=UTF-8">
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer text-end">
                            <button type="submit" class="btn btn-primary">Make request</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>
</div>
<footer class="footer footer-transparent d-print-none">
    <div class="container-xl">
        <div class="row text-center align-items-center flex-row-reverse">
            <div class="col-lg-auto ms-lg-auto">
                <ul class="list-inline list-inline-dots mb-0">
                    <li class="list-inline-item"><a href="https://tabler.io/docs" target="_blank" class="link-secondary" rel="noopener">Documentation</a></li>
                    <li class="list-inline-item"><a href="./license.html" class="link-secondary">License</a></li>
                    <li class="list-inline-item"><a href="https://github.com/tabler/tabler" target="_blank" class="link-secondary" rel="noopener">Source code</a></li>
                    <li class="list-inline-item">
                        <a href="https://github.com/sponsors/codecalm" target="_blank" class="link-secondary" rel="noopener">
                            <!-- Download SVG icon from http://tabler-icons.io/i/heart -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon text-pink icon-filled icon-inline" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M19.5 12.572l-7.5 7.428l-7.5 -7.428a5 5 0 1 1 7.5 -6.566a5 5 0 1 1 7.5 6.572" /></svg>
                            Sponsor
                        </a>
                    </li>
                </ul>
            </div>
            <div class="col-12 col-lg-auto mt-3 mt-lg-0">
                <ul class="list-inline list-inline-dots mb-0">
                    <li class="list-inline-item">
                        Copyright &copy; 2023
                        <a href="." class="link-secondary">Tabler</a>.
                        All rights reserved.
                    </li>
                    <li class="list-inline-item">
                        <a href="./changelog.html" class="link-secondary" rel="noopener">
                            v1.0.0-beta20
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</footer>
