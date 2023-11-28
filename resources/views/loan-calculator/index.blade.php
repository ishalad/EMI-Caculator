<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>EMI Calculator</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
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
            <table class="table" id="history">
                <thead>
                    <tr>
                        <th scope="col" >Principal Amount</th>
                        <th scope="col">Rate Of Interest (% per annum)</th>
                        <th scope="col">Loan Duration (in Months)</th>
                        <th scope="col">EMI Amount (per month) </th>
                        <th scope="col">Details</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($history as $item)
                <tr>
                    <td>{{$item->principal_amount}}</td>
                    <td>{{$item->interest_rate}}</td>
                    <td>{{$item->duration}}</td>
                    <td>{{$item->emi_amount}}</td>
                    <td>  <a href="JavaScript:Void(0);" class="btn btn-primary show_result"  data-id="{{$item->id}}"> show </a> </td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        {{-- {{ $history->links() }} --}}
    <div id="emiTableContainer"></div>
    </div>


    
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
    $(document).ready(function () {
        $('#emiForm').submit(function (e) {
            e.preventDefault();

            var formData = $(this).serialize();

            $.ajax({
                url: '/loan-calculator/calculate',
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function (data) {
                    toastr.success(data.message);
                    let recentrow = '<tr>' +
                                '<td >'+ data.history.principal_amount + '</td>' +
                                '<td>'+ data.history.interest_rate+'</td>' +
                                '<td>'+data.history.duration +'</td>' +
                                '<td>'+data.history.emi_amount +'</td>' +
                                '</tr>';
                    $('#result tbody').prepend(recentrow);
                },
                error: function (error) {
                    toastr.error(error.message);
                    console.log(error);
                }
            });
        });
        $('.show_result').click(function(e){
            e.preventDefault();
            $.ajax({
                url: '{{route('result_EMI')}}',
                type: 'POST',
                data: {
                    "_token": "{{ csrf_token() }}",
                    id: $(this).attr('data-id'),
                },
                dataType:'json',
                success: function (data) {
                    var principal = data.emiData.principal_amount;
                    var interestRate =data.emiData.interest_rate;
                    var duration = data.emiData.duration;
                    var emi = data.emiData.emi_amount;
                    createEMITable(duration, emi);
                    console.log(data);
                },
                error: function(error) {
                    console.log(error)
                }
            })
        });

        function createEMITable(duration, emi) {
            $('#emiTableContainer').empty();

            var tableHTML = '<table border="1" class="table"><thead><tr><th>Month</th><th>EMI Amount</th></tr></thead><tbody>';

            for (var i = 1; i <= duration; i++) {
                tableHTML += '<tr><td>' + i + '</td><td>' + emi.toFixed(2) + '</td></tr>';
            }

            tableHTML += '</tbody></table>';

            // Append the table to the container
            $('#emiTableContainer').html(tableHTML);
        }
    });
</script>
</body>
</html>

