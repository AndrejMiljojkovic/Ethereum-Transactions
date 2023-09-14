<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <link rel="stylesheet" href="/style.css">
    <title>Ethereum Transactions</title>
</head>

<body>
    <div class="container">
        <h1>Ethereum Transactions for Wallet Address</h1>
        <form method="GET" id="transactionForm">
            <label for="walletAddress">Wallet Address:</label>
            <input type="text" id="walletAddress" name="walletAddress" required>
            <br>
            <label for="startBlock">Start Block:</label>
            <input type="text" id="startBlock" name="startBlock" required>
            <br>
            <label for="balanceDate">Date:</label>
            <input type="date" id="balanceDate" name="balanceDate">
            <button type="button" id="clearDate">Clear Date</button>
            <br>
            <button type="submit">Submit</button>
        </form>
        <div id="resultContainer">
            <p id="theBalanceDisplay">Current balance: </p>
            <div id="boxesTransaction" class="boxes transactions">
                <div id="boxesToAppend" class="boxes transactions">
                </div>
            </div>
        </div>

        <script src="/script.js"></script>
</body>

</html>