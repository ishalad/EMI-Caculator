<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EMI Calculator</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">EMI Calculator</h2>

        <form id="emiForm">
            @csrf
            <div class="form-group">
                <label for="principal_amount">Principal Amount:</label>
                <input type="number" class="form-control" id="principal_amount" name="principal_amount" required>
            </div>

            <div class="form-group">
                <label for="interest_rate">Rate of Interest (% per annum):</label>
                <input type="number" step="0.01" class="form-control" id="interest_rate" name="interest_rate" required>
            </div>

            <div class="form-group">
                <label for="duration">Loan Duration (in months):</label>
                <input type="number" class="form-control" id="duration" name="duration" required>
            </div>

            <button type="submit" class="btn btn-primary">Calculate EMI</button>
        </form>

        <div id="result" class="mt-4">
            <!-- Display the calculated EMI here -->
        </div>
    </div>


    
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    $(document).ready(function () {
        $('#calculateForm').submit(function (e) {
            e.preventDefault();

            // Serialize the form data
            var formData = $(this).serialize();

            // Send an AJAX request to the server
            $.ajax({
                url: '/loan-calculator/calculate',
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function (data) {
                    // Handle the JSON response
                    // Update the result section with the calculated data
                    $('#result').html('<p>EMI: ' + data.emiData + '</p>');

                    // Update the history section with the new calculation
                    $('#history').append('<li><a href="#" class="history-link" data-id="' + data.history.id + '">Calculation ' + data.history.id + '</a></li>');
                },
                error: function (error) {
                    // Handle errors
                    console.log(error);
                }
            });
        });

        // Handle history links
        $(document).on('click', '.history-link', function (e) {
            e.preventDefault();

            // Get the calculation ID from the data attribute
            var calculationId = $(this).data('id');

            // Send an AJAX request to get the details for the selected calculation
            $.ajax({
                url: '/loan-calculator/history/' + calculationId,
                type: 'GET',
                dataType: 'json',
                success: function (data) {
                    // Handle the JSON response
                    // Update the result section with the selected calculation data
                    $('#result').html('<p>EMI: ' + data.emiData + '</p>');
                },
                error: function (error) {
                    // Handle errors
                    console.log(error);
                }
            });
        });
    });
</script>
</body>
</html>
<!-- Your input form goes here -->

