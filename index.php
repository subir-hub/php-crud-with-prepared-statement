<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php require './includes/links.php' ?>
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card shadow">
                    <h3 class="text-center py-3">Registration Form</h3>

                    <div class="card-body">
                        <form id="regForm">
                            <div class="mb-3">
                                <input type="text" name="name" id="name" class="form-control" placeholder="Enter your full name">
                                <div id="nameError" class="error text-danger"></div>
                            </div>

                            <div class="mb-3">
                                <input type="email" name="email" id="email" class="form-control" placeholder="Enter your email id">
                                <div id="emailError" class="error text-danger"></div>
                            </div>

                            <div class="mb-3">
                                <label for="gender" class="fw-semibold">Select Gender:</label>
                                <input type="radio" name="gender" value="Male"> Male
                                <input type="radio" name="gender" value="Female"> Female
                                <input type="radio" name="gender" value="Other"> Other

                                <div id="genderError" class="error text-danger"></div>
                            </div>

                            <div class="mb-3">
                               <select name="city" id="city" class="form-control">
                                <option value="">Select Your City</option>
                                <option value="Kolkata">Kolkata</option>
                                <option value="Bengaluru">Bengaluru</option>
                                <option value="Delhi">Delhi</option>
                               </select>

                                <div id="cityError" class="error text-danger"></div>
                            </div>

                            <div class="mb-3">
                                <input type="checkbox" name="terms" id="terms"> Accept the <a href="#" class="text-decoration-none">terms & conditions</a>
                                <div id="termsError" class="error text-danger"></div>
                            </div>

                            <button type="submit" class="btn btn-primary w-100">Submit</button>
                            <div id="result" class="text-center py-2"></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center mt-4">
            <a href="./display.php" class="text-decoration-none">Click here</a> to see the user details.
        </div>
    </div>

    <script src="./assets/JS/script.js?v=<?= time(); ?>"></script>
</body>
</html>