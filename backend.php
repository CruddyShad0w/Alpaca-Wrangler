<?php
/*

*/
session_start();
    


    require './vendor/autoload.php';
    use Alpaca\Alpaca;
    
    
    $httpMethod = strtoupper($_SERVER['REQUEST_METHOD']);

    switch($httpMethod) {
      case "OPTIONS":
        // Allows anyone to hit your API, not just this c9 domain
        header("Access-Control-Allow-Headers: X-ACCESS_TOKEN, Access-Control-Allow-Origin, Authorization, Origin, X-Requested-With, Content-Type, Content-Range, Content-Disposition, Content-Description");
        header("Access-Control-Allow-Methods: POST, GET");
        header("Access-Control-Max-Age: 3600");
        exit();
      case "GET":
        
        // Allow any client to access
        header("Access-Control-Allow-Origin: *");
        // Let the client know the format of the data being returned
        header("Content-Type: application/json");
        if($_SESSION['base_url'] =='true'){
            $alpaca = new Alpaca($_SESSION['key'], $_SESSION['pass'], true);
        }
        else{
            $alpaca = new Alpaca($_SESSION['key'], $_SESSION['pass'], false);
        }
        
        
        $positions = $alpaca->getPositions()->getResponse();
        $account = $alpaca->getAccount()->getResponse();
        $symbols = array();
            
        for($z=0; $z<sizeof($positions); $z++){
            array_push($symbols, $positions[$z]->exchange.':'.$positions[$z]->symbol);
        }
        if(isset($_GET['positions_list'])){
            echo '<div class="col" style ="width:500px" >
                      <select class="custom-select mr-sm-2" id="single_stock_chosen">
                      <option selected>Symbol</option>';
            for ($i=0; $i<sizeof($positions); $i++){
                echo '<option value="'.$positions[$i]->exchange.":".$positions[$i]->symbol.'">'.$positions[$i]->symbol.'</option>';
            }
            echo '
                      </select>
                </div>
                <div class= "col">
                    <button id="update_single_stock" type="submit" class="btn btn-primary">Update</button>
                </div>';
        }
        if(isset($_GET['largeChart'])){
            echo '
            <!-- TradingView Widget BEGIN -->
            <div class="tradingview-widget-container" >
                <div id="tradingview_23bdd" style="height:40rem; padding:20px;"></div>
                <script type="text/javascript" src="https://s3.tradingview.com/tv.js"></script>
                <script type="text/javascript">
                    new TradingView.widget({
                        "autosize": true,
                        "symbol": "'.$_GET['largeChart'].'",
                        "interval": "D",
                        "timezone": "Etc/UTC",
                        "theme": "Dark",
                        "style": "1",
                        "locale": "en",
                        "toolbar_bg": "#f1f3f6",
                        "enable_publishing": false,
                        "allow_symbol_change": true,
                        "container_id": "tradingview_23bdd"
                    });
                </script>
            </div>
            ';
        }
            if(isset($_GET['cards'])){
                if ($_GET['cards'] == 'large'){
                    echo "<div class = 'row '>";
                    for($k=0; $k<sizeof($symbols);$k++){
                        $profit = $positions[$k]->market_value - $positions[$k]->cost_basis;
                        echo '<div id = "cards" class="card border-dark " style="width: 20rem;border-width:2px">
                            <div class="card-body col-sm" style="background:#131722;">
                                <!-- TradingView Widget BEGIN -->
                                <div class="tradingview-widget-container">
                                    <div class="tradingview-widget-container__widget"></div>
                                    <div class="tradingview-widget-copyright"></div>
                                    <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-mini-symbol-overview.js" async>
                                        {
                                            "symbol": "'.$symbols[$k].'",
                                            "width": "275",
                                            "height": "300",
                                            "locale": "en",
                                            "dateRange": "1d",
                                            "colorTheme": "dark",
                                            "trendLineColor": "#37a6ef",
                                            "underLineColor": "rgba(55, 166, 239, 0.15)",
                                            "isTransparent": false,
                                            "autosize": false,
                                            "largeChartUrl": "#largeChart"
                                        }
                                    </script>
                                </div>
                                <!-- TradingView Widget END -->
                                <h6 class="card-subtitle mb-2 text-muted">'.$symbols[$k].'</h6>
                                <p class="card-text"style="color:grey;">AVG Entry: $'.$positions[$k]->avg_entry_price.'</p>
                                <p class="card-text" style="color:grey;">Shares: '.$positions[$k]->qty.'</p>
                                <p class="card-text"style="color:grey;">Market Value: $'.$positions[$k]->market_value.'</p>
                                <p class="card-text"style="color:';
                                if($profit>=0){
                                    echo'#20c997';
                                }
                                else{
                                    echo'#dc3545';
                                }
                                echo ';">Total Profit: $'.$profit;
                                
                                echo'</p>
                                
                            </div>
                        </div>';
                    }echo"</div>";
                }
                else if ($_GET['cards'] == 'small'){
                    echo "<div class = 'row '>";
                    for($k=0; $k<sizeof($symbols);$k++){
                        $profit = $positions[$k]->market_value - $positions[$k]->cost_basis;
                        echo '<div id = "cards" class="card border-dark " style="width: 20rem;border-width:2px">
                                <div class="card-body col-sm" style="background:#131722;">
                                <!-- TradingView Widget BEGIN -->
                                <div class="tradingview-widget-container">
                                  <div class="tradingview-widget-container__widget"></div>
                                  <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-single-quote.js" async>
                                  {
                                  "symbol": "'.$symbols[$k].'",
                                  "width": 275,
                                  "locale": "en"
                                }
                                  </script>
                                </div>
                                <!-- TradingView Widget END -->
                                <h6 class="card-subtitle mb-2 text-muted">'.$symbols[$k].'</h6>
                                <p class="card-text"style="color:grey;">AVG Entry: $'.$positions[$k]->avg_entry_price.'</p>
                                <p class="card-text" style="color:grey;">Shares: '.$positions[$k]->qty.'</p>
                                <p class="card-text"style="color:grey;">Market Value: $'.$positions[$k]->market_value.'</p>
                                <p class="card-text"style="color:';
                                if($profit>=0){
                                    echo'#20c997';
                                }
                                else{
                                    echo'#dc3545';
                                }
                                echo ';">Total Profit: $'.$profit;
                                
                                echo'</p>
                                
                            </div>
                        </div>';
                    }echo"</div>";
                }
        }
        
        if(isset($_GET['ticker'])){
            echo '<div class="tradingview-widget-container">';
            echo '<div class="tradingview-widget-container__widget"></div>';
        
        
            echo "<script type='text/javascript' src='https://s3.tradingview.com/external-embedding/embed-widget-ticker-tape.js' async>";
            echo '{
                "symbols": ';
            
            $test = '{"title": "S&P 500 MINE", "proName": "INDEX:SPX"}';
            

            $strings = array();
            for($i=0; $i< sizeof($symbols); $i++){
                if($i+1 == sizeof($symbols)){
                    $strings[$i] = '{"title": "'.$positions[$i]->qty.':'.$positions[$i]->symbol.'", "proName": "'.$symbols[$i].'"}';
                }
                else{
                    $strings[$i] = '{"title": "'.$positions[$i]->qty.':'.$positions[$i]->symbol.'", "proName": "'.$symbols[$i].'"},';
                }
            }
            echo '[';
            for($j=0; $j< sizeof($strings); $j++){
                echo $strings[$j];
            }
            echo'],"theme": "dark",
                "isTransparent": false,
                "displayMode": "adaptive",
                "locale": "en"
            }</script></div>';
        }
        if(isset($_GET['account_details'])){
            echo'
                <div id="currentValue" class="card border-dark" style="width: 15%;border-width:2px">
                    <div class="card-body col-sm" style="background:#131722;">
                    <h5 class="card-title text-muted">Current Value:</h5>
                    <h6 class="card-subtitle mb-2 " style="color:';
                    if($account->portfolio_value > 0){
                        echo '#20c997';
                    }
                    else{
                        echo '#dc3545';
                    }
                    echo'">$'.$account->portfolio_value.'</h6>
                    </div>
                </div>
            
            
                <div id="buyingPower" class="card border-dark" style="width: 15%;border-width:2px">
                    <div class="card-body col-sm" style="background:#131722;">
                    <h5 class="card-title text-muted">Buying Power:</h5>
                    <h6 class="card-subtitle mb-2" style="color:';
                    if($account->buying_power > 0){
                        echo '#20c997';
                    }
                    else{
                        echo '#dc3545';
                    }
                    echo '">$'.$account->buying_power.'</h6>
                    </div>
                </div>
            
            ';
            if($account->pattern_dat_trader){
            echo'
                <div id="dayTrader" class="card border-dark" style="width: 15%;border-width:2px">
                    <div class="card-body col-sm" style="background:#131722;">
                    <h5 class="card-title " style = "color:#dc3545;">Day Trader:</h5>
                    <h6 class="card-subtitle mb-2 " style="color:grey;">'.$account->pattern_day_trader.'</h6>
                    </div>
                </div>
            ';}
            if($account->trading_blocked){
            echo '
                <div id="tradingBlocked" class="card border-dark" style="width: 15%;border-width:2px">
                    <div class="card-body col-sm" style="background:#131722;">
                    <h5 class="card-title " style = "color:#dc3545;">Trading Blocked:</h5>
                    <h6 class="card-subtitle mb-2 " style="color:grey;">'.$account->trading_blocked.'</h6>
                    </div>
                </div>
            ';
            }
        }
        break;
        
        
      case "POST":
        global $alpaca;
        $return = 'successfull';
        if(isset($_POST['user_data'])){
            $user_data = $_POST['user_data'];
            $_SESSION['base_url'] = $_POST['base_url'];
            $_SESSION['key'] = $_POST['username'];
            $_SESSION['pass'] = $_POST['password'];

        }
        
    }

?>