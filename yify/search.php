<?php
$query=$_GET['query'];
$query=urlencode($query);

if(isset($_GET["start"])){
  $start = $_GET["start"];
}else{
  $start = 1;
}

function startsWith ($string, $startString) 
{ 
    $len = strlen($startString); 
    return (substr($string, 0, $len) === $startString); 
} 
function get_data($query){
    $options  = array('http' => array('user_agent' => 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.169 Safari/537.36'));
    $context  = stream_context_create($options);
    $data=file_get_contents('http://libgen.io/search.php?req='.$query.'&open=0&res=16&view=simple&phrase=1&column=def',false,$context);
    preg_match_all('/<a[^>]+>/i', $data, $result);
    $link=$result[0];
    

    foreach($link as $value){
        $val=substr($value, strpos($value, 'md5='));  
        if(startsWith($val,'md5=')){
            $val=substr($val, 0, -2);
            $val=substr($val, 4);
            $val=strtolower(substr($val, 0,32));
            $val;
            $arr[$val] = $val;
   
        }
    }
    return $arr;
    }

$arr=get_data($query);

?>
<!DOCTYPE html>
<html lang="en">
<?php
function get_book_data($book_md5)   //function to fetch track id from url
{
    $data      = file_get_contents("http://libgen.io/json.php?md5=$book_md5&fields=Title,Author,MD5,coverurl,extension,id");
    $data = json_decode($data);
    return $data;
}
?>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0,maximum-scale=1">
    <link rel="icon" href="images/favicon.png" type="image/png">
    <title>Books-Yify
    </title>

    <!-- Loading third party fonts -->
    <link href="http://fonts.googleapis.com/css?family=Roboto:300,400,700|" rel="stylesheet" type="text/css">
    <link href="fonts/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- Loading main css file -->
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="hover_effect.css">
    

  </head>


  <body>
    
    <div class="site-content">
      <div class="site-header">
        <div class="container">
          <a href="index.php" class="branding">
            <img src="images/logo.png" width="65" height="65" alt="" class="logo">
            <div class="logo-type">
              <h1 class="site-title">YIFY BOOKS</h1>
              <small class="site-description">Lootta©</small>
            </div>
          </a>

          <!-- Default snippet for navigation --><br>
          <div class="main-navigation">
            <button type="button" class="menu-toggle"><i class="fa fa-bars"></i></button>
            <ul class="menu">
              <li class="menu-item current-menu-item"><a href="index.php">Home</a></li>
              
            </ul> <!-- .menu -->
          </div> <!-- .main-navigation -->

          <div class="mobile-navigation"></div>

        </div>
      </div> <!-- .site-header -->
      <div class="hero" data-bg-image="images/banner.png">
        <div class="container">
          <form action="search.php" class="find-location" method="get">
            <input type="text" name="query" value="<?php echo $query."..."; ?>" placeholder="Search your book name here...">
            <input type="submit" value="Find">
            
          </form>

        </div>
      </div>
      <main class="main-content">
        <div class="fullwidth-block">
  
        <div class="container">
          <div class="row">
                    <?php
                      $r_count=1;
                      foreach($arr as $md5){
                      $data=get_book_data($md5);

                      ?>
                    <div class="col-md-3 col-sm-6" style="padding-bottom:40px;">
                      <div class="live-camera">
                        <div class="item cl">
                        <figure class="live-camera-cover">
                              <img src="http://booksdescr.org/covers/<?php echo $data[0]->coverurl;?>" alt="">
                            </figure>
                        <i class="fa fa-book" aria-hidden="true"> <a href="page.php?md5=<?php echo $data[0]->md5;?>"></a></i>     
                        </div>
                        <h4 class="card-title"><a href="page.php?md5=<?php echo $data[0]->md5;?>"><?php echo $data[0]->title;?></a></h4>
                              <p class="card-text"><?php echo $data[0]->author;?></p>
                         <div class="card-footer">
                            <a href="download.php?md5=<?php echo $data[0]->md5;?>"><div class="button" style="float:right;"><b>Download</b></div></a>
                         </div>
                      </div>
                    </div>
                      <?php
                      if($r_count > 3){
                        echo "</div><br><div class='row'>";
                        $r_count=0;
                        }
                        $r_count=$r_count+1;
                        }
                      ?>
            </div>


    </div>
            

        </div>
        </main> <!-- .main-content -->

      <footer class="site-footer">
        <div class="container">
          <div class="row">
            <div class="col-md-8">
              <form action="#" class="subscribe-form">
                <input type="text" placeholder="Enter your email to subscribe...">
                <input type="submit" value="Subscribe">
              </form>
            </div>
            <div class="col-md-3 col-md-offset-1">
              <div class="social-links">
                <a href="#"><i class="fa fa-facebook"></i></a>
                <a href="#"><i class="fa fa-twitter"></i></a>
                <a href="#"><i class="fa fa-google-plus"></i></a>
                <a href="#"><i class="fa fa-pinterest"></i></a>
              </div>
            </div>
          </div>

          <p class="colophon">Copyright 2014 Company name. Designed by Themezy. All rights reserved</p>
        </div>
      </footer> <!-- .site-footer -->
    </div>
            
            
            
    <script src="js/jquery-1.11.1.min.js"></script>
    <script src="js/plugins.js"></script>
    <script src="js/app.js"></script>
    
  </body>

</html>
        