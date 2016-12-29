<!DOCTYPE html>
<html>
    <head><style>.error{color: #FF0000;}</style>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <?php
        
        $subtotal=$tipPercent=$tip=$total=0;
        $subtotalErr=$tipPercentErr="";
        
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (empty($_POST["subtotal"])) {
                $subtotalErr = "Subtotal is required";
            } else {
                $subtotal = trim($_POST["subtotal"]);
                $subtotal = stripslashes($subtotal);
                $subtotal = htmlspecialchars($subtotal);
                // check if name only contains letters and whitespace
                if (!is_numeric($subtotal) || $subtotal <= 0) {
                    $subtotalErr = "Only numbers greater than 0 is allowed"; 
                }
            }
            
            if (empty($_POST["tipPercentage"])) {
                $tipPercentErr = "Tip Percentage is required";
            } else {            
                $tipPercent = trim($_POST["tipPercentage"]);
                $tipPercent = stripslashes($tipPercent);
                $tipPercent = htmlspecialchars($tipPercent);
                // check if name only contains letters and whitespace
                if (!is_numeric($tipPercent) || $tipPercent <= 0) {
                    $tipPercentErr = "Only numbers greater than 0 is allowed";
                }
            }
        }
        
        ?>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div>
                <h1>Tip Calculator</h1>
                <label>
                <span>Bill Subtotal: </span>
                <span class="error">* <?php echo $subtotalErr;?></span>
                <input id="subtotal" type="text" name="subtotal" size="2" value="<?php echo $subtotal?>"><br>
                </label>
            
                <label>
                    Tip Percentage: 
                    <span class="error">* <?php echo $tipPercentErr;?></span>
                    <br>
                    <span>  
            <?php
            for($i=0; $i<3; $i++){
                if($tipPercent == 10 + $i * 5){
                    echo '<input type="radio" name="tipPercentage" value="'.(10 + $i * 5).'"checked>'. " " .(10 + $i * 5).'%';
                }
                else{
                    echo '<input type="radio" name="tipPercentage" value="'.(10 + $i * 5).'">'. " " .(10 + $i * 5).'%';   
                }
            }
            ?>
                    <br>
                    </span>
                </label>
                <label>
                    <input id="submit" type="submit" name="submit" value="submit">
                </label>
            </div>
            <div id="result">    
                <?php
                
                if(is_numeric($subtotal) && $subtotal > 0){
                    if(!empty($_POST["tipPercentage"])){
        $tip = ($tipPercent/100) * $subtotal;
        $total = $tip+$subtotal;
        echo "Tip: $" . $tip;
        echo "<br>";
        echo "Total: $" . $total;
        echo "<br>";
                }}
        ?>
            </div>
        </form>
    </body>
</html>