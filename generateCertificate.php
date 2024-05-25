


<script>
  if(window.history.replaceState){
    window.history.replaceState(null,null,window.location.href);
  }


</script>
<?php
@include 'config/config.php';
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>
     body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            
            flex-direction: column;
            justify-content: center; 
             align-items: center; 
            
        }
        .error {
            color: red;
            text-align: center;
            margin-bottom: 10px;
        }
        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        input,select {
            padding: 8px;
            margin-bottom: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .updateBtn,.pdfGenerate,.resetBtn,.backBtn{
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
        }

        .updateBtn:hover,.pdfGenerate:hover,.resetBtn:hover,.backBtn:hover{
            background-color: #0056b3;
        }
</style>

<body>
<div class="container">
<center><a href="clerk_certificates.php" class="backBtn">Back</a></center><br>
    <?php
    $stud_id=$_GET['stud_id'];
    $appliedFor=$_GET['appFor'];

    if($appliedFor=="Bonafide"){
        $selectQuery="select * from studregistration where reg_id='$stud_id';";
        $selectRsQuery=mysqli_query($conn,$selectQuery);
        if($row=mysqli_fetch_array($selectRsQuery)){
            ?>


<form action="" method="post">
    <?php if(isset($error)) { ?>
                <div class="error"><?php echo $error; ?></div>
            <?php } ?>

            Student Name :
        <input type="text" name="studentName" placeholder="Student Name" value="<?php echo $row['StudentName']; ?>" required>
        Class :
        <input type="text" name="class" placeholder="Class" value="<?php echo $row['Class']." ".$row['AdmittedFor']; ?>" required>
        Roll number :
        <input type="number" name="rollNo" placeholder="Roll number" value="<?php echo $row['reg_id']; ?>" required>
        Year :
        <input type="text" name="year" placeholder="Year" value="<?php echo date("Y"); ?>" required>
        Date Of Birth :
        <input type="text" name="birthDate" placeholder="Date Of Birth" value="<?php echo $row['DateOfBirth']; ?>" required>
        
        Aadhar Card No :
        <input type="text" name="aadharNo" placeholder="Aadhar Card No" value="<?php echo $row['AadharNo']; ?>" required>
        

        Religion-Caste :
        <input type="text" name="religionCaste" placeholder="Religion-Caste" value="<?php echo $row['Religion']."-".$row['Caste']; ?>" required>
        Purpose of Bonafide :
        <input type="text" name="reason" placeholder="Purpose of Bonafide" value="<?php if(isset($_POST['reason'])){echo htmlentities($_POST['reason']);} ?>" required>


    <?php } ?>

        <input type="submit" id="submit" class="updateBtn" name="savePdf" value="Save PDF">
        <input type="submit" name="pdfGenerate" class="pdfGenerate" id="pdfGenerate" value="Generate PDF">
        <input type="reset" name="reset" id="reset" class="resetBtn" value="Clear">
        
   
    </form>
    

<?php
            
        }else{
             ?>
                <div class="error"><?php echo "No certification requested"; ?></div>
            <?php
        }
    
    

    
   
    ?>

</div>

</body>
<?php

if(!empty($_POST['pdfGenerate'])){

    $studentName =  $_POST['studentName'];
    $class=$_POST['class'];
    $rollNo=$_POST['rollNo'];
    $year=$_POST['year'];
    $birthDate=$_POST['birthDate'];
    $aadharNo=$_POST['aadharNo'];
    $religion=$_POST['religionCaste'];
    $purpose=$_POST['reason'];

    ob_end_clean();
                require("fpdf/fpdf.php");
                $pdf=new FPDF();
                $pdf->AddPage();
            
                $pdf->Image('img/logo diet.png',10,10,185,15,'PNG');
                // $pdf->Ln();

                

                $pdf->SetFont("Arial","",16);
                $pdf->cell(0,50,"Bonafide Certificate",0,1,'C');
            
                $pdf->SetFont("Arial","U",16);
                $pdf->cell(190,10,"TO WHOMSOEVER IT MAY CONCERN",0,0.1,'C');

                $pdf->SetFont("Arial","B",14);
            
                $pdf->cell(20,10,"This is to certify that Mr./Miss/Mrs. ".$studentName);
                $pdf->Ln();
            
                $pdf->cell(20,10,"is/was a bonafide student of this college studying in");
                $pdf->Ln();
            
                $pdf->cell(20,10,$class." class with roll No. ".$rollNo." in the year");
                $pdf->Ln();
            
                $pdf->cell(20,10,$year." his/her birth date is ".$birthDate." his/her Aadhar");
                $pdf->Ln();
            
                $pdf->cell(20,10,"Card/UIDAI No. ".$aadharNo." and his/her caste is ");
                $pdf->Ln();

                $pdf->cell(20,10,$religion." as per our General Register and his/her");
                $pdf->Ln();

                $pdf->cell(20,10,"School Leaving Certificate.");
                $pdf->Ln();

                $pdf->cell(20,10,"To the best of my knowledge and belief, he/she bears a good moral character.");
                $pdf->Ln();

                $pdf->cell(20,10,"Purpose ".$purpose);
                $pdf->Ln();

                $pdf->Image('img/principal.jpg',10,165,25,15,'JPG');
                $pdf->Ln();
                $pdf->Ln();

                $pdf->cell(20,10,"Principal Sign",'C');
                $pdf->Ln();
                
                
            
                $pdf->Output();
            





}

?>

<?php
if(!empty($_POST['savePdf'])){

     $studentName =  $_POST['studentName'];
    $class=$_POST['class'];
    $regId=$_POST['rollNo'];
    $year=$_POST['year'];
    $birthDate=$_POST['birthDate'];
    $aadharNo=$_POST['aadharNo'];
    $religion=$_POST['religionCaste'];
    $purpose=$_POST['reason'];

$query="insert into certificates(reg_Id,StudentName,Class,RollNo,Year,DateOfBirth,AadharNo,Religion,Purpose) values('$regId','$studentName','$class','$regId','$year','$birthDate','$aadharNo','$religion','$purpose');";

if ($conn->query($query) === TRUE) {
   
    echo "<script>alert('PDF Saved successfully');</script>";
   
  } else {
    echo "Error: " . $conn->error;
  }

}



?>
</html>