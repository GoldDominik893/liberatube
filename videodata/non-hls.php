<?php
    include('../config.php');
    header('Content-type: video/mp4');

    $InvApiUrl = $InvVIServer.'/api/v1/videos/' . $_GET['id'] . '?hl=en';

                $ch = curl_init();

                curl_setopt($ch, CURLOPT_HEADER, 0);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_URL, $InvApiUrl);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
                curl_setopt($ch, CURLOPT_VERBOSE, 0);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                $response = curl_exec($ch);

                curl_close($ch);
                $data = json_decode($response);
                $value = json_decode(json_encode($data), true);

                    $nonHlsUrls = [];
                    $nonHlsItag = [];
                    $nonHlsQuality = [];
                    $nonHlsType = [];
                    $nonHlsSize = [];

                    if (isset($value['formatStreams']) && is_array($value['formatStreams'])) {
                        foreach ($value['formatStreams'] as $formatStream) {
                            if (isset($formatStream['url'])) {
                                $nonHlsUrls[] = $formatStream['url'];
                                $nonHlsItag[] = $formatStream['itag'];
                                $nonHlsQuality[] = $formatStream['quality'];
                                $nonHlsType[] = $formatStream['type'];
                                $nonHlsSize[] = $formatStream['size'];
                            }
                        }
                    }

                    // itag hierarchy best to worst: 22(720p) 18(360p)

                    $selectedNonHlsUrl = '';
                    if ($_GET['itag']) {
                        $preferredItags = [$_GET['itag']];
                    } else {
                       $preferredItags = [end($nonHlsItag)]; 
                    }
                    


                    if (isset($value['formatStreams']) && is_array($value['formatStreams'])) {
                        foreach ($value['formatStreams'] as $formatStream) {
                            if (isset($formatStream['url']) && isset($formatStream['itag'])) {
                                $url = $formatStream['url'];
                                $itag = $formatStream['itag'];

                                if (in_array($itag, $preferredItags)) {
                                    $selectedNonHlsUrl = $url;
                                    break;
                                }
                            }
                        }
                    }


if ($_GET['dl'] == "dl" and ($allowProxy == "true" or $allowProxy == "downloads")) {
    readfile($selectedNonHlsUrl);
    exit();
} elseif ($_GET['dl'] == "true" and $allowProxy == "true") {
    readfile($selectedNonHlsUrl);
    exit();
}
else {
    header('Location: '.$selectedNonHlsUrl);
}
exit;
?>