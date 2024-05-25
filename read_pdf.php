<?php
if (isset($_GET['path'])) {
    $pdf_path = $_GET['path'];
} else {
    die("No PDF specified.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unpkg.com/98.css" />
    <title>Read PDF</title>
    <style>
        body {
            font-family: 'MS Sans Serif', sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #008080; /* Dark teal background */
        }

        .container {
            background-color: #c0c0c0; /* Light gray background */
            border: 2px solid #000000; /* Black border */
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            text-align: center;
            width: 90%; /* Increase width to 90% of the viewport */
            height: 90vh; /* Increase height to 90% of the viewport height */
        }

        .pdf-viewer {
            width: 100%;
            height: 80vh; /* Increase height to 80% of the container height */
        }

        .back-button {
            background-color: #0000ff; /* Blue button */
            color: #ffffff; /* White text */
            border: none;
            padding: 10px;
            cursor: pointer;
            font-weight: bold;
            width: 100%;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            margin-top: 20px;
        }

        .back-button:hover {
            background-color: #0000cc; /* Darker blue on hover */
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Read PDF</h1>
        <iframe class="pdf-viewer" src="<?php echo htmlspecialchars($pdf_path); ?>"></iframe>
        <a href="view_pdfs.php" class="back-button">Back to PDF List</a>
    </div>
</body>
</html>
