<?php
$domain = "localhost/url/";
$servername = "localhost";
$username = "root";
$password = "";
$dbname='shorten-url';
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

<?php
  include "php/connect.php";
  $new_url = "";
  if(isset($_GET)){
    foreach($_GET as $key=>$val){
      $u = mysqli_real_escape_string($conn, $key);
      $new_url = str_replace('/', '', $u);
    }
      $sql = mysqli_query($conn, "SELECT original_url FROM url WHERE short_url = '{$new_url}'");
      if(mysqli_num_rows($sql) > 0){
        $sql2 = mysqli_query($conn, "UPDATE url SET clicks = clicks + 1 WHERE short_url = '{$new_url}'");
        if($sql2){
            $original_url = mysqli_fetch_assoc($sql);
            header("Location:".$original_url['original_url']);
          }
      }
  }
?>

<?php
      $sql2 = mysqli_query($conn, "SELECT * FROM url ORDER BY id DESC");
      if(mysqli_num_rows($sql2) > 0){;
        ?>
        <div class="url-area">
          <div class="title">
            <li>Shorten URL</li>
            <li>Original URL</li>
            <li>Clicks</li>
            <li>Action</li>
          </div>
          <?php
            while($row = mysqli_fetch_assoc($sql2)){
              ?>
                <div class="data">
                <li>
                  <a href="<?php echo $domain.$row['short_url'] ?>" target="_blank">
                  <?php
                    if($domain.strlen($row['short_url']) > 50){
                      echo $domain.substr($row['short_url'], 0, 50) . '...';
                    }else{
                      echo $domain.$row['short_url'];
                    }
                  ?>
                  </a>
                </li>
                <li>
                  <?php
                    if(strlen($row['original_url']) > 60){
                      echo substr($row['original_url'], 0, 60) . '...';
                    }else{
                      echo $row['original_url'];
                    }
                  ?>
                </li>
              </li>
              </div>
              <?php
            }
          ?>
      </div>
        <?php
      }
    ?>
  </div>

  <?php
    include "connect.php";
    $original_url = mysqli_real_escape_string($conn, $_POST['original_url']);

    if(!empty($original_url) && filter_var($original_url, FILTER_VALIDATE_URL)){
        $ran_url = substr(md5(microtime()), rand(0, 26), 5);////generating a random number, 5 characters

        //checking that random generated url exists in the database or not
        $sql = mysqli_query($conn, "SELECT * FROM url WHERE short_url = '{$ran_url}'");
        if(mysqli_num_rows($sql) > 0){
            echo "Something went wrong. Please generate again!";
        }else{
            //insert typed url into the table with short url
            $sql2 = mysqli_query($conn, "INSERT INTO url (original_url, short_url, clicks)
                                         VALUES ('{$original_url}', '{$ran_url}', '0')");
            if($sql2){
                $sql3 = mysqli_query($conn, "SELECT short_url FROM url WHERE short_url = '{$ran_url}'");
                if(mysqli_num_rows($sql3) > 0){
                    $short_url = mysqli_fetch_assoc($sql3);
                    echo $short_url['short_url'];
                }
            }
        }
    }
    let domain = "localhost/url/";
shortenURL.value = domain + data;
copyIcon.onclick = ()=>{
    shortenURL.select();
    document.execCommand("copy");
}

    ?>

<div class="data">
                <li>
                  <a href="<?php echo $domain.$row['short_url'] ?>" target="_blank">
                  <?php
                    if($domain.strlen($row['short_url']) > 50){
                      echo $domain.substr($row['short_url'], 0, 50) . '...';
                    }else{
                      echo $domain.$row['short_url'];
                    }
                  ?>
                  </a>
                </li>