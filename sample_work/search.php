<?php
$query=$_GET['query'];
$query=urlencode($query);

function startsWith ($string, $startString) 
{ 
    $len = strlen($startString); 
    return (substr($string, 0, $len) === $startString); 
} 
function get_data($query){
    $options  = array('http' => array('user_agent' => 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.169 Safari/537.36'));
    $context  = stream_context_create($options);
    $data=file_get_contents('http://libgen.io/search.php?req='.$query.'&open=0&res=25&view=simple&phrase=1&column=def',false,$context);
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

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Heroic Features - Start Bootstrap Template</title>

  <!-- Bootstrap core CSS -->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="css/heroic-features.css" rel="stylesheet">

</head>

<body>

  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
      <a class="navbar-brand" href="#">Yify Books</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item active">
            <a class="nav-link" href="#">Home
              <span class="sr-only">(current)</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">About</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Services</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Contact</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Page Content -->
  <div class="container">

    <!-- Jumbotron Header -->
    <header class="jumbotron my-4">
      <h1 class="display-3">Libgen CLoner</h1>
      <p class="lead">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ipsa, ipsam, eligendi, in quo sunt possimus non incidunt odit vero aliquid similique quaerat nam nobis illo aspernatur vitae fugiat numquam repellat.</p>
      <a href="#" class="btn btn-primary btn-lg">Call to action!</a>
    </header>



    <!-- Page Features -->
    <div class="row text-center">
    <?php
foreach($arr as $md5){
$data=get_book_data($md5);

?>
      <div class="col-lg-3 col-md-6 mb-4">
        <div class="card h-100">
          <img class="card-img-top" src="http://booksdescr.org/covers/<?php echo $data[0]->coverurl;?>" alt="">
          <div class="card-body">
            <h4 class="card-title"><?php echo $data[0]->title;?></h4>
            <p class="card-text"><?php echo $data[0]->author;?></p>
          </div>
          <div class="card-footer">
            <a href="download.php?md5=<?php echo $data[0]->md5;?>" class="btn btn-primary">Download</a>
          </div>
        </div>

      </div>
      <?php
}
?>

    </div>
    <!-- /.row -->

  </div>
  <!-- /.container -->

  <!-- Footer -->
  <footer class="py-5 bg-dark">
    <div class="container">
      <p class="m-0 text-center text-white">Copyright &copy; Your Website 2019</p>
    </div>
    <!-- /.container -->
  </footer>

  <!-- Bootstrap core JavaScript -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>

</html>