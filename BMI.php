<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BMI Calculator</title>
    <style type = "text/css">
         body{
            font-family: Arial, sans-serif;
            padding: 20px;
            margin-left: 30%;
            margin-right: 30%;
            margin-top: 10%;
            border-width: 5px;
            border-style: outset;
            border-color: blue;
            
        }
        .container{
            
            background-color:  #f0f0f0;
        }
        .content{
            background-color: black;
        }
        h2{
            font-style: oblique;
            color: #ADD8E6;
            text-align: center;
        }
        .content p{
            color: white;
        }
        .content form{
            color: white;
        } 
        .error{background:red; 
            color: white; 
            padding: 0.2em;
        }
        input[type="number"]{
            width: 150px;
            height: 30px;
        }
        select{
            width: 100px;
            height: 35px;
        }
        select, select option, input{
            font-family: Arial, sans-serif;
            font-size: 20px;
        }
        @keyframes colorChange{
            0%{
                background-color: white; 
                color: blue;
            }
            50%{
                background-color: blue; 
                color: red;
            }
            100%{
                background-color: white; 
                color: blue;
            }

        }
        input[type="submit"]{
            animation: colorChange 1s infinite;
            background-color: blue;
            color: white;
        }
        input[type = "reset"]{
            background-color: white; 
            color: blue;
        }
        input[type = "reset"]:hover{
            background-color: blue; 
            color: white;
        }
        .result{
            padding: 10px;
            margin-top: 20px;
            font-weight: bold;
            text-align: center;
            background-color: #f0f0f0;
            
        }
        
        .result.underweight {
            background-color: red;
        }

        .result.normal {
            background-color: green;
        }

        .result.overweight {
            background-color: orange;
        }

        .result.obese {
            background-color: red;
        }

        .result.extremely-obese {
            background-color: red;
        }
        
       
    </style>
</head>
<body>

    <?php 
        if(isset($_POST["Calculate"])){
            processCal();
        }
        else{
            displayForm(array());
        }

        function processCal(){
            $requiredFields = array("weight", "height", "mesure");
            $missingFields = array();
            foreach($requiredFields as $requiredField){
                if(!isset($_POST[$requiredField]) or empty($_POST[$requiredField])){
                    $missingFields[] = $requiredField;
                }
            }
            if($missingFields){
                displayForm($missingFields);
            }
            else{
                $BMI = calculateBMI($_POST["weight"], $_POST["height"], $_POST["mesure"]);
                displayResult($BMI);
            }
        }
       
        function calculateBMI($weight, $height, $heightUnit){
            $BMI = 0;
            if($heightUnit == "cm"){
                $height = $height/100;
                $BMI = $weight/($height*$height);
            } else if($heightUnit == "m"){
                $BMI = $weight/($height*$height);
            } else{
                $height = $height/ 39.37;
                $BMI = $weight/($height*$height);
            }
            return $BMI;
        }

        function getHealthSuggestions($BMI){
            if($BMI < 18.5){
                return "Underweight";
            } else if($BMI < 25){
                return "Normal";
            } else if($BMI < 30){
                return "Overweight";
            } else if($BMI < 35){
                return "Obese";
            } else{
                return "Extremely Obese";
            }
        }

        function getHealthTips($BMI){
            if($BMI < 18.5){
                return "<br>Focus on a balanced diet and healthy weight gain strategies.";
            } else if($BMI < 25){
                return "<br>Maintain a well-rounded diet and regular physical activity.";
            } else if($BMI < 30){
                return "<br>Make healthier food choices and increase physical activity for weight management.";
            } else if($BMI < 35){
                return "<br>Seek professional guidance and adopt lifestyle changes for sustainable weight loss.";
            } else{
                return "<br>Seek comprehensive medical support, including professional guidance, specialized treatment options, and lifestyle modifications, to address the health risks associated with extreme obesity.";
            }
        }

        function validateField($fieldName, $missingFields){
            if(in_array($fieldName, $missingFields)){
                echo "class='error'";
            }
        }

        function setValue($fieldName){
            if(isset($_POST[$fieldName])){
                echo $_POST[$fieldName];
            }
        }

        function setSelected($fieldName, $fieldValue){
            if(isset($_POST[$fieldName]) && $_POST[$fieldName] == $fieldValue){
                echo "selected='selected'";
            }
        }

        function displayForm($missingFields){
    ?>
    <dive class = "container">
    <div class = "content"><br>
    <h2>BMI Calculator</h2>
    <?php if($missingFields){ ?>
        <p class="error">There was some problem. Please make sure you filled all fields. please check it again!!!</p>
    <?php } else { ?>
        <p>Fill each fealds and select units for height, Then click "Calculate BMI" button.</p>
    <?php } ?>
    <form action="BMI.php" method="post">
        <label for="weight">Weight*: <?php validateField("weight", $missingFields); ?></label>
        <input type="number" name="weight" value="<?php setValue("weight"); ?>">
        <br><br>
        <label for="height">Height*: <?php validateField("height", $missingFields); ?></label>
        <input type="number" name="height" value="<?php setValue("height"); ?>">

        <select name="mesure" id="measure">
            <option value="select">select</option>
            <option value="cm" <?php setSelected("mesure", "cm"); ?>>cm</option>
            <option value="m" <?php setSelected("mesure", "m"); ?>>m</option>
            <option value="inch" <?php setSelected("mesure", "inch"); ?>>inch</option>
        </select>
        <br><br>
        <input type="submit" name="Calculate" value="Calculate BMI">
        <input type="reset" name="clear" value="Clear"><br>
    </form>
    <?php
        }

        function displayResult($BMI){
    ?>
    <div class = "result <?php echo strtolower(getHealthSuggestions($BMI)); ?>">
    <p>Your Body Mass Index is: <?php echo round($BMI, 2); ?></p>
    <p>This is considered: <?php echo getHealthSuggestions($BMI); ?></p>
    <p><?php echo getHealthTips($BMI) ?></p>
    <?php
        }
    ?>
    </div>
</div>
</div>
</body>
</html>