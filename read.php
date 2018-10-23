<?php
    
    include 'vendor/autoload.php';
    use mikehaertl\pdftk\Pdf;

    if (isset($_FILES["fileToRead"])) {
        if ($_FILES["fileToRead"]["error"] > 0)
        {
            echo "Error: " . $_FILES["fileToRead"]["error"] . "<br />";
        }
        else
        {
            // echo "Upload: " . $_FILES["fileToRead"]["name"] . "<br />";
            // echo "Type: " . $_FILES["fileToRead"]["type"] . "<br />";
            // echo "Size: " . ($_FILES["fileToRead"]["size"] / 1024) . " Kb<br />";
            // echo "Stored in: " . $_FILES["fileToRead"]["tmp_name"];
            $target_file = "upload/" . basename($_FILES["fileToRead"]["name"]);
            
            if (strtolower(substr($target_file, -3)) != "pdf") {
                echo "Invalid file type!";
            }
            else if (move_uploaded_file($_FILES["fileToRead"]["tmp_name"], $target_file)) {

                // Get data
                $pdf = new Pdf(__DIR__ . '/' . $target_file, [
                    'command' => 'C:\Program Files (x86)\PDFtk\bin\pdftk.exe',
                    'useExec' => true,  // May help on Windows systems if execution fails
                ]);
                
                $data = $pdf->getDataFields();
                
                $arr = (array) $data;
                $arr = $data->__toArray();

                $FieldNames = [
                    "sig1" => "Third Party Signature_es_:signer1:signature",
                    "fullname1" => "Third Party Name_es_:signer1:fullname",
                    "title1" => "Third Party Title_es_:signer1:title",
                    "sign_date1" => "Third Party Date_es_:signer1:date",
                    "sig2" => "Signer Signature_es_:signer2:signature",
                    "fullname2" => "Signer Name_es_:signer2:fullname",
                    "title2" => "Signer Title_es_:signer2:title",
                    "sign_date2" => "Signer Date_es_:signer2:date",
                    "doc" => "Document No_es_:prefill",
                    "doc_name" => "Name_es_:prefill",
                    "project" => "Project_es_:prefill",
                    "start_date" => "Start Date_es_:prefill",
                    "end_date" => "End Date_es_:prefill",
                    "fee" => "Fee_es_:prefill",
                    "eff" => "Effective Date_es_:prefill",
                    "desc" => "Description_es_:prefill"
                ];
                
                $isValidFile = false;
                for ($i = 0; $i < count($arr); $i++) {
                    if ($arr[$i]['FieldName'] == $FieldNames['doc']) {
                        $isValidFile = true;
                        break;
                    }
                }

                if ($isValidFile) {
                    $formData = [];
                    for ($i = 0; $i < count($arr); $i++) {
                        $formData[$arr[$i]['FieldName']] = isset($arr[$i]['FieldValue']) ? $arr[$i]['FieldValue'] : "";
                    }

                    $fieldValues = [];
                    foreach ($FieldNames as $key => $value) {
                        $fieldValues[$key] = $formData[$value];
                    }
                }
                else {
                    echo "Invalid form!";
                }
                
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    }
    
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <title>Read PDF Form</title>
</head>
<body>
    <div class="container">

        <div class="panel panel-default">
            <div class="panel-body">
                <form id="frmFile" action="read.php" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="fileToRead">Pdf file input</label>
                        <input type="file" class="form-control-file" id="fileToRead" name="fileToRead">
                     </div>
                     <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
        

        <form id="frmFieldValues" style="margin-top: 30px;">
            <div class="form-group row">
                <label for="fld-doc" class="col-sm-2 col-form-label">Document:</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control" id="doc">
                </div>
            </div>
            <div class="form-group row">
                <label for="fld-doc" class="col-sm-2 col-form-label">Name:</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control" id="doc_name">
                </div>
            </div>
            <div class="form-group row">
                <label for="fld-doc" class="col-sm-2 col-form-label">Project:</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control" id="project">
                </div>
            </div>
            <div class="form-group row">
                <label for="fld-doc" class="col-sm-2 col-form-label">Start Date:</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control" id="start_date">
                </div>
            </div>
            <div class="form-group row">
                <label for="fld-doc" class="col-sm-2 col-form-label">End Date:</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control" id="end_date">
                </div>
            </div>
            <div class="form-group row">
                <label for="fld-doc" class="col-sm-2 col-form-label">Project Deliver:</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control" id="eff">
                </div>
            </div>
            <div class="form-group row">
                <label for="fld-doc" class="col-sm-2 col-form-label">$</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control" id="fee">
                </div>
            </div>
            <div class="form-group row">
                <label for="fld-doc" class="col-sm-2 col-form-label">Description:</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control" id="desc">
                </div>
            </div>
            <hr>
            <div class="form-group row">
                <label class="col-sm-6 col-form-label">Signee:</label>
                <label class="col-sm-6 col-form-label">Signer:</label>
            </div>
            <div class="form-group row">
                <label for="fld-doc" class="col-sm-2 col-form-label">By:</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="sig1">
                </div>
                <label for="fld-doc" class="col-sm-2 col-form-label">By:</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="sig2">
                </div>
            </div>
            <div class="form-group row">
                <label for="fld-doc" class="col-sm-2 col-form-label">Pritned Name:</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="fullname1">
                </div>
                <label for="fld-doc" class="col-sm-2 col-form-label">Pritned Name:</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="fullname2">
                </div>
            </div>
            <div class="form-group row">
                <label for="fld-doc" class="col-sm-2 col-form-label">Title:</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="title1">
                </div>
                <label for="fld-doc" class="col-sm-2 col-form-label">Title:</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="title2">
                </div>
            </div>
            <div class="form-group row">
                <label for="fld-doc" class="col-sm-2 col-form-label">Date:</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="sign_date1">
                </div>
                <label for="fld-doc" class="col-sm-2 col-form-label">Date:</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="sign_date2">
                </div>
            </div>
        </form>
    </div>
    
</body>
</html>

<script type="text/javascript">
    var FieldValues = <?php if (isset($fieldValues)) echo json_encode($fieldValues); else echo 'null'; ?>;
    $(document).ready(function(){
        console.log(FieldValues);
        if (FieldValues) {
            for (var key in FieldValues) {
                $("#"+key).val(FieldValues[key]);
            }
        }
    });
</script>