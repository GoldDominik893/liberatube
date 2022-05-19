
<?php
    define("MAX_RESULTS", 18);
    
     if (isset($_POST['submit']) )
     {
          
  
        $keyword = $_POST['keyword'];
    
               
        if (empty($keyword))
        {
            $response = array(
                  "type" => "error",
                  "message" => "Please enter the keyword."
                );
        } 
    }
         
?>
<!doctype html>
<html>
    <head>
        <title>Bad YouTube</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <style>
            body {
                font-family: Arial;
                padding: 10px;
                color: white;
                background-color: #2a2a2a;
            }
            .search-form-container {
                background: #3B3B3B;
                border: #3B3B3B 1px solid;
                padding: 20px;
                border-radius: 6px;
            }
            .input-row {
                margin-bottom: 20px;
            }
            .input-field {
                width: 100%;
                border-radius: 2px;
                padding: 10px;
                border: #515151 1px solid;
                background: #515151;
            }
            .input-field:focus {
                color: white;
            }
            .btn-submit {
                padding: 10px 20px;
                background: #333;
                border: #333 1px solid;
                color: #f0f0f0;
                font-size: 0.9em;
                width: 100px;
                border-radius: 6px;
                cursor:pointer;
            }
            .videos-data-container {
                background: #3B3B3B;
                border: #3B3B3B 1px solid;
                padding: 20px;
                border-radius: 6px;
            }
            .response {
                padding: 10px;
                margin-top: 10px;
                border-radius: 2px;
            }
            .error {
                 background: #331111;
            }
           .success {
                background: #c5f3c3;
                border: #bbe6ba 1px solid;
            }
            .result-heading {
                margin: 20px 0px;
                padding: 20px 10px 5px 0px;
                border-bottom: #e0dfdf 1px solid;
            }
            iframe {
                border: 0px;
            }
            .video-tile {
                display: inline-block;
                margin: 10px 10px 20px 10px;
                border: #222222 2px solid;
                border-radius: 8px;
                background-color: #222222;
                transition: transform 0.2s;
            }
            .video-tile:hover {
                transform: scale(1.1);
                transition: transform 0.2s;
            }
            .videoDiv {
                width: 270px;
                height: 220px;
                display: inline-block;
            }
            .videoTitle {
                text-overflow: ellipsis;
                overflow: hidden;
                white-space: initial;
            }
            .videoDesc {
                text-overflow: ellipsis;
                overflow: hidden;
                white-space: initial;
            }
            .videoInfo {
                width: 250px;
            }
            a {
                color: green;
            }
            a:hover {
                color: lime;
            }
            a:focus {
                color: lime;
            }
        </style>
    <body>
       <center> <h2>Bad YouTube</h2>
        </center>
        <div class="search-form-container">
            <form id="keywordForm" method="post" action="">
                <div class="input-row">
                    <input class="input-field" type="search" id="keyword" name="keyword"  placeholder="Type the search query here" value="<?php echo $keyword; ?>">
                </div>

                <input class="btn-submit"  type="submit" name="submit" value="Search">
            </form>
        </div>
        <?php 
    $searchqk = $keyword;
    $keyword = str_replace(' ','_',$keyword)
    ?>
        <?php if(!empty($response)) { ?>
                <div class="response <?php echo $response["type"]; ?>"> <?php echo $response["message"]; ?> </div>
        <?php }?>
        <?php
            if (isset($_POST['submit']) )
            {
                                         
              if (!empty($keyword))
              {
                $apikey = 'YOUR_API_KEY'; 
                $googleApiUrl = 'https://www.googleapis.com/youtube/v3/search?part=snippet&q=' . $keyword . '&maxResults=' . MAX_RESULTS . '&key=' . $apikey;

                $ch = curl_init();

                curl_setopt($ch, CURLOPT_HEADER, 0);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_URL, $googleApiUrl);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
                curl_setopt($ch, CURLOPT_VERBOSE, 0);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                $response = curl_exec($ch);

                curl_close($ch);
                $data = json_decode($response);
                $value = json_decode(json_encode($data), true);
            ?>

            <br>
            <div class="videos-data-container" id="SearchResultsDiv">
<h4> You have searched for: <font color="red"><?php echo $searchqk; ?></font><br>
What was sent to Google's API: <font color="red"><?php echo $keyword; ?></font> </h4>
            <?php
                for ($i = 0; $i < MAX_RESULTS; $i++) {
                    $videoId = $value['items'][$i]['id']['videoId'];
                    $title = $value['items'][$i]['snippet']['title'];
                    $description = $value['items'][$i]['snippet']['description'];
                    ?> 
                       <div class="video-tile">
                        <div class="videoDiv">
                            <center><u><h4> https://youtu.be/<?php echo $videoId; ?></u> </h4>
                            <h4><u><a href="/vi/?w=<?php echo $videoId; ?>&t=<?php echo $title; ?>&d=<?php echo $description; ?>">open in player (beta)</a></u></h4>
                            <img src="http://i.ytimg.com/vi/<?php echo $videoId; ?>/mqdefault.jpg" height="144px">
       </center>
                        </div>
                        <div class="videoInfo">
                        <div class="videoTitle"><b><center><?php echo $title; ?></center></b></div>
                        <div class="videoDesc"><center><?php echo $description; ?></center></div>
                        </div>
                        </div>
           <?php 
                    }
                } 
           
            }
            ?> 
            
        </div>
    </body>
</html>