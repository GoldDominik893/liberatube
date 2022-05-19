
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
        <link rel="stylesheet" href="/styles/main.css">
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