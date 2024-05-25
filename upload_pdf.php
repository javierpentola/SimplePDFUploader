<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_FILES['pdf']) && $_FILES['pdf']['error'] == 0) {
        $target_dir = "uploads/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        $target_file = $target_dir . basename($_FILES["pdf"]["name"]);
        $uploadOk = 1;
        $pdfFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if file is an actual PDF
        if ($pdfFileType == "pdf") {
            $uploadOk = 1;
        } else {
            echo "File is not a PDF.";
            $uploadOk = 0;
        }

        // Check if file already exists
        if (file_exists($target_file)) {
            echo "Sorry, file already exists.";
            $uploadOk = 0;
        }

        // Check file size
        if ($_FILES["pdf"]["size"] > 50000000) { // 50MB limit
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["pdf"]["tmp_name"], $target_file)) {
                // Update the XML file
                $xml = new DOMDocument("1.0", "UTF-8");

                if (file_exists('pdfs.xml')) {
                    if (filesize('pdfs.xml') == 0) {
                        // Initialize with root element if file is empty
                        $root = $xml->createElement("pdfs");
                        $xml->appendChild($root);
                        $xml->save('pdfs.xml'); // Save the initial structure
                    } else {
                        $xml->load('pdfs.xml');
                        $root = $xml->getElementsByTagName("pdfs")->item(0);
                    }
                } else {
                    $root = $xml->createElement("pdfs");
                    $xml->appendChild($root);
                    $xml->save('pdfs.xml'); // Save the initial structure
                }

                $pdf = $xml->createElement("pdf");
                $nameElement = $xml->createElement("name", htmlspecialchars($_FILES["pdf"]["name"]));
                $pathElement = $xml->createElement("path", htmlspecialchars($target_file));
                $sizeElement = $xml->createElement("size", htmlspecialchars($_FILES["pdf"]["size"]));
                $dateElement = $xml->createElement("upload_date", date("Y-m-d H:i:s"));

                $pdf->appendChild($nameElement);
                $pdf->appendChild($pathElement);
                $pdf->appendChild($sizeElement);
                $pdf->appendChild($dateElement);

                $root->appendChild($pdf);

                $xml->save('pdfs.xml');
                
                // Redirect to index.php after successful upload
                header('Location: index.php');
                exit();
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    } else {
        echo "No file was uploaded or file is too large.";
    }
}
?>
