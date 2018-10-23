<?php
    include 'vendor/autoload.php';

    use mikehaertl\pdftk\Pdf;

    $pdf = new Pdf(__DIR__.'/template/GenericForm.pdf', [
        'command' => 'C:\Program Files (x86)\PDFtk\bin\pdftk.exe',
        'useExec' => true,  // May help on Windows systems if execution fails
    ]);
    
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
    
    if (isset($_POST['doc']))
    {
        $data = [];
        foreach ($FieldNames as $key => $value) {
            $data[$value] = $_POST[$key];
        }

        $targetFileName = '/generated/filled_'.date('m-d-Y_His').'.pdf';
        $targetFile = __DIR__ . $targetFileName;
        $pdf->fillForm($data)
            ->needAppearances()
            ->saveAs($targetFile);

        $targetUrl = "http://" . $_SERVER['SERVER_NAME'] . ":" . $_SERVER['SERVER_PORT'] . $targetFileName;
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

        <form style="margin-top: 30px;" method="post" action="write.php">
            <div class="form-group row">
                <label for="fld-doc" class="col-sm-2 col-form-label">Document:</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control" name="doc">
                </div>
            </div>
            <div class="form-group row">
                <label for="fld-doc" class="col-sm-2 col-form-label">Name:</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control" name="doc_name">
                </div>
            </div>
            <div class="form-group row">
                <label for="fld-doc" class="col-sm-2 col-form-label">Project:</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control" name="project">
                </div>
            </div>
            <div class="form-group row">
                <label for="fld-doc" class="col-sm-2 col-form-label">Start Date:</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control" name="start_date">
                </div>
            </div>
            <div class="form-group row">
                <label for="fld-doc" class="col-sm-2 col-form-label">End Date:</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control" name="end_date">
                </div>
            </div>
            <div class="form-group row">
                <label for="fld-doc" class="col-sm-2 col-form-label">Project Deliver:</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control" name="eff">
                </div>
            </div>
            <div class="form-group row">
                <label for="fld-doc" class="col-sm-2 col-form-label">$</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control" name="fee">
                </div>
            </div>
            <div class="form-group row">
                <label for="fld-doc" class="col-sm-2 col-form-label">Description:</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control" name="desc">
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
                    <input type="text" class="form-control" name="sig1">
                </div>
                <label for="fld-doc" class="col-sm-2 col-form-label">By:</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" name="sig2">
                </div>
            </div>
            <div class="form-group row">
                <label for="fld-doc" class="col-sm-2 col-form-label">Pritned Name:</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" name="fullname1">
                </div>
                <label for="fld-doc" class="col-sm-2 col-form-label">Pritned Name:</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" name="fullname2">
                </div>
            </div>
            <div class="form-group row">
                <label for="fld-doc" class="col-sm-2 col-form-label">Title:</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" name="title1">
                </div>
                <label for="fld-doc" class="col-sm-2 col-form-label">Title:</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" name="title2">
                </div>
            </div>
            <div class="form-group row">
                <label for="fld-doc" class="col-sm-2 col-form-label">Date:</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" name="sign_date1">
                </div>
                <label for="fld-doc" class="col-sm-2 col-form-label">Date:</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" name="sign_date2">
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
    
</body>
</html>

<script type="text/javascript">
    var FileUrl = "<?php if (isset($targetUrl)) echo $targetUrl; else echo ''; ?>";
    $(document).ready(function(){
        setTimeout(function () { 
            if (FileUrl){
                var win = window.open(FileUrl, '_blank');
                win.focus();
            }
        }, 1000)
    });
</script>