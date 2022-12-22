<?php include 'includes/config.php' ?>

<?php

    $error = false;

    if (isset($_POST['btnSubmit'])) {

        $item_purchase_code = $_POST['item_purchase_code'];

        if (strlen($item_purchase_code) < 36) {
            $error[] = 'Whoops, Invalid Purchase Code!';
        }

        if (strlen($item_purchase_code) > 36) {
            $error[] = 'Whoops, Invalid Purchase Code!';
        }

        if (empty($item_purchase_code)) {
            $error[] = 'Purchase code can not be empty!';
        }

        if($error) {

            $sql = "INSERT INTO tbl_purchase_code (item_purchase_code) VALUES (?)";

            $insert = $connect->prepare($sql);
            $insert->bind_param('s', $item_purchase_code);
            $insert->execute();

            $succes =<<<EOF
            <script>
            alert('Thank you');
            window.location = 'dashboard.php';
            </script>
EOF;
            echo $succes;
        }

    }

?>


<div class="verifycard">
    <div class="pmd-card card-default pmd-z-depth dashboard">
        <div class="login-card">
            <form method="POST">
                <br>
                <div class="pmd-card-title card-header-border text-center">
                    <div class="lead"><img src="assets/images/ic_envato.png" width="24" height="24"> Please Verify your Purchase Code to Continue Using Admin Panel.</div>
                </div>
                
                <div class="pmd-card-body">
                    <?php echo $error ? '<div class="alert alert-warning">'. implode('<br>', $error) . '</div>' : '';?>
                    <div class="form-group pmd-textfield pmd-textfield-floating-label">
                        <label for="item_purchase_code" class="control-label pmd-input-group-label">Your Item Purchase Code</label>
                        <div class="input-group">
                            <div class="input-group-addon"><i class="material-icons md-dark pmd-sm">vpn_key</i></div>
                            <input type="text" name="item_purchase_code" class="form-control" id="item_purchase_code" required>
                        </div>
                    </div>
                    
                </div>
                <div class="pmd-card-footer card-footer-no-border card-footer-p16 text-center">
                    <div class="form-group clearfix">
                    </div>
                    <button type="submit" name="btnSubmit" class="btn pmd-ripple-effect btn-danger btn-block">Submit</button>
                    <br>
                    <br>
                    <h3 class="pmd-card-subtitle-text">
                        <a href="https://help.market.envato.com/hc/en-us/articles/202822600-Where-Is-My-Purchase-Code-" target="_blank">Where Is My Purchase Code?</a><br>
                        <a href="https://codecanyon.net/item/ecommerce-online-shop-app/10442576" target="_blank">Don't Have Purchase Code? I Want to Purchase it first.</a>
                    </h3>
                    
                </div>
                
            </form>
        </div>
        
    </div>
</div>