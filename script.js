$(document).ready(function () {
    $('#clearDate').click(function () {
        $('#balanceDate').val('');
    });
    $('#transactionForm').submit(function (e) {
        e.preventDefault();

        var walletAddress = $('#walletAddress').val();
        var startBlock = $('#startBlock').val();
        var dueDate = $('#balanceDate').val();
        var parts = dueDate.split('-');
        if (parts.length === 3) {
            var year = parseInt(parts[0], 10);
            var month = parseInt(parts[1], 10) - 1;
            var day = parseInt(parts[2], 10);
            var dateObject = new Date(Date.UTC(year, month, day, 0, 0, 0, 0));
            dueDate = dateObject.getTime();
            dueDate = dueDate / 1000;
        }
        $.ajax({
            url: '/back.php',
            type: 'GET',
            data: {
                walletAddress: walletAddress,
                startBlock: startBlock,
                dueDate: dueDate
            },
            success: function (data) {
                $('#boxesTransaction').empty();
                $.each(data.transactions, function (index, transaction) {
                    var newItem = '<div class="box">';
                    newItem += '<div class="icon">';
                    if (transaction.from == walletAddress) {
                        newItem += '<ion-icon name="arrow-up"></ion-icon>';
                    } else if (transaction.to == walletAddress) {
                        newItem += '<ion-icon name="arrow-down"></ion-icon>';
                    }
                    newItem += '</div>';
                    newItem += '<div class="hash">';
                    newItem += '<span>' + transaction.hash + '</span>';
                    newItem += '</div>';
                    newItem += '<div class="fromTo">';
                    newItem += '<span>From: ' + transaction.from + '</span>';
                    newItem += '<span>To: ' + transaction.to + '</span>';
                    newItem += '<span>Time: ' + transaction.timeFormatted + '</span>';
                    newItem += '</div>';
                    newItem += '<div class="amount">';
                    newItem += '<span> ' + transaction.value + '  ETH</span>';
                    newItem += '</div>';
                    newItem += '</div>';
                    $('#boxesTransaction').append(newItem);
                });
                $('#theBalanceDisplay').html('Current balance: ' + data.currentBalance + ' ETH');
            },
            error: function (xhr, status, error) {
                console.error('AJAX error: ' + status + ' ' + error);
            }
        });
    });
});