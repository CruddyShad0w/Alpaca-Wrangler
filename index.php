<!DOCTYPE HTML>
<html>

<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <style>
        .card:last-child {
            margin-right: 20px;
        }
    </style>
</head>

<body style="background:#212529">
    <!-- TradingView Widget BEGIN -->
    <div id="banner">
    <?php
        
        echo '<div class="tradingview-widget-container">';
        echo '<div class="tradingview-widget-container__widget"></div>';
            echo "<script type='text/javascript' src='https://s3.tradingview.com/external-embedding/embed-widget-ticker-tape.js' async>";
            echo '{
                "symbols": ';
            
 
            $symbols = array();
            array_push($symbols, 'INDEX:SPX');
            
            $strings = array();
            for($i=0; $i< sizeof($symbols); $i++){
                if($i+1 == sizeof($symbols)){
                    $strings[$i] = '{"title": "'.$symbols[$i].'", "proName": "'.$symbols[$i].'"}';
                }
                else{
                    $strings[$i] = '{"title": "'.$symbols[$i].'", "proName": "'.$symbols[$i].'"},';
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
            
    ?>
    </div> 
    
    <!-- TradingView Widget END -->
    <nav class="navbar navbar-dark ">
        <form>
            <div class="row"id ="account_details">
                <div class="col" >
                     <label class="mr-sm-2 sr-only" for="inlineFormCustomSelect">Preference</label>
                      <select class="custom-select mr-sm-2" id="base_url">
                        <option selected>Account Type</option>
                        <option value="true">Paper</option>
                        <option value="false">Live</option>
                      </select>
                </div>
                <div class="col">
                    <input  class="form-control" type = "username"  id="key" placeholder="Key Id">
                </div>
                <div class="col">
                    <input  class="form-control" type ="password" id="secret" placeholder="Secret Key">
                </div>
                <div class= "col">
                    <button id="submitButton" type="submit" class="btn btn-primary">Log in</button>
                </div>
            </div>
        </form>
    </nav>
    <!-- TradingView Widget BEGIN -->
    <div class="tradingview-widget-container" >
        <div id="tradingview_23bdd" style="height:40rem; padding:20px;"></div>
        <script type="text/javascript" src="https://s3.tradingview.com/tv.js"></script>
        <script type="text/javascript">
            new TradingView.widget({
                "autosize": true,
                "symbol": "INDEX:SPX",
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
    <nav class="navbar navbar-dark ">
        <form>
            <div class="row"id ="chart_type">
                <div class="col" style ="width:500px" >
                      <select class="custom-select mr-sm-2" id="update_type">
                        <option selected>Chart Type</option>
                        <option value="ticker">Ticker</option>
                        <option value="small">Cards small</option>
                        <option value="large">Cards large</option>
                      </select>
                </div>
                <div class= "col">
                    <button id="updateButton" type="submit" class="btn btn-primary">Update</button>
                </div>
            </div>
        </form>
    </nav>
    <div class = ".container-fluid" style = "padding-left:75px; padding-right:75px;">
        
    <div id ="cards" class = ".container-fluid "style = "padding-left:100px; padding-right:50px;">
    
    </div>
  
<script src="script.js">
</script>

</html>