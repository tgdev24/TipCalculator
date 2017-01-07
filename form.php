<!DOCTYPE html>
<html>
    <head>
        <style>.error{color: #FF0000;}</style>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <?php
            $subtotal=$tipPercent=$custom=$tip=$total=$splits=0;
            $subtotalErr=$tipPercentErr=$customErr=$splitsErr="";
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                
                if (empty($_POST["subtotal"])) {
                    $subtotalErr = "Subtotal is required";
                } else {
                    $subtotal = trim($_POST["subtotal"]);
                    $subtotal = stripslashes($subtotal);
                    $subtotal = htmlspecialchars($subtotal);
                    // check if name only contains letters and whitespace
                    if (!is_numeric($subtotal) || $subtotal <= 0) {
                        $subtotalErr = "Only numbers greater than 0 is allowed for subtotal"; 
                    }
                }
                
                if (empty($_POST["tipPercentage"])) {
                    $tipPercentErr = "Tip Percentage is required";
                } else {            
                    $tipPercent = trim($_POST["tipPercentage"]);
                    $tipPercent = stripslashes($tipPercent);
                    $tipPercent = htmlspecialchars($tipPercent);
                }
                
                if($_POST["tipPercentage"] == "Custom"){
                    if (empty($_POST["customTip"])) {
                        $customErr = "A custom tip amount is required OR select other options";
                    } else {
                        $custom = trim($_POST["customTip"]);
                        $custom = stripslashes($custom);
                        $custom = htmlspecialchars($custom);
                        // check if name only contains letters and whitespace
                        if (!is_numeric($custom) || $custom <= 0) {
                            $customErr = "Only numbers greater than 0 is allowed for custom percentage"; 
                        }
                    }
                }
                
                if (empty($_POST["splits"])) {
                    $splitsErr = "Number of splits is required";
                } else {
                    $splits = trim($_POST["splits"]);
                    $splits = stripslashes($splits);
                    $splits = htmlspecialchars($splits);
                    // check if name only contains letters and whitespace
                    if (!is_numeric($splits) || $splits <= 0) {
                        $splitsErr = "Only numbers greater than 0 is allowed for splits"; 
                    }
                }
            }
        ?>
        
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div>
                <h1>Tip Calculator</h1>
                Bill Subtotal:<span class="error">* <?php echo $subtotalErr;?></span>
                <input id="subtotal" type="text" name="subtotal" size="2" value="<?php echo $subtotal?>"><br>   
                Tip Percentage: 
                <span class="error">* <?php echo $tipPercentErr;?></span><br>  
                <?php 
                    for($i=0; $i<3; $i++){
                        if($tipPercent == 10 + $i * 5){
                            echo '<input type="radio" name="tipPercentage" value="'.(10 + $i * 5).'"checked>'. " " .(10 + $i * 5).'%';
                        } else{
                            echo '<input type="radio" name="tipPercentage" value="'.(10 + $i * 5).'">'. " " .(10 + $i * 5).'%';   
                        }
                    }
                ?>
                <br>
                <?php
                if($tipPercent == 'Custom'){
                    echo '<input type="radio" name="tipPercentage" value="Custom" checked>';
                    
                }
                else{
                    echo '<input type="radio" name="tipPercentage" value="Custom">';
            
                }
                ?>
                <label for="customTip">Custom: </label>
                <input type="text" id="customTip" name="customTip" value="<?php echo $custom?>">%
                <span class="error"><?php echo $customErr;?></span> 
                <br>
                <br>
                <label for="splits">Split: </label>
                <input type="text" name="splits" id="splits" value="<?php echo $splits?>">person(s)
                <span class="error">* <?php echo $splitsErr;?></span>  
                <br>
                <br>
                <br>
                <input id="submit" type="submit" name="submit" value="submit">
            </div>
            <div id="result">    
                <?php
                    if(is_numeric($subtotal) && $subtotal > 0){
                        if(!empty($_POST["tipPercentage"])){
                            if($_POST["tipPercentage"] == "Custom"){
                                if(is_numeric($custom) && $custom > 0){
                                    $tip = ($custom/100) * $subtotal;
                                }
                            }
                            else{
                                $tip = ($tipPercent/100) * $subtotal;
                            }
                            $total = $tip+$subtotal;
                            if(!empty($_POST["splits"])){
                                $tipSplit = $tip / $splits;
                                $totalSplits = $total / $splits;
                                $tip=number_format((float)$tip, 2, '.', '');
                                $tipSplit=number_format((float)$tipSplit, 2, '.', '');
                                $totalSplits=number_format((float)$totalSplits, 2, '.', '');
                                $total=number_format((float)$total, 2, '.', '');
                                echo "Tip: $" . $tip;
                                echo "<br>";
                                echo "Total: $" . $total;
                                echo "<br>";
                                if($splits > 0){
                                    echo "Tip Split: $" . $tipSplit;
                                    echo "<br>";
                                    echo "Total Split: $" . $totalSplits;
                                }
                            }
                        }
                    }
                ?>
            </div>
        </form>
    </body>
</html>