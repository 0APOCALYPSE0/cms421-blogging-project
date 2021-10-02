<?php
//sitemap.php to sitemap.xml using .htaccess file
require_once('Includes/db.php');
require_once('Includes/functions.php');

$pages = mysqli_query($conn, 'SELECT * FROM post ORDER BY id ASC');
$article = mysqli_query($conn, 'SELECT slug FROM post ORDER BY id ASC');
$category = mysqli_query($conn, 'SELECT title FROM category ORDER BY id ASC');
$profile= mysqli_query($conn, 'SELECT username FROM admins ORDER BY id ASC');
$date = date("c", time());


//define your base URLs
//Main URL
$base_url = $serverName;



header("Content-Type: application/xml; charset=utf-8");

echo '<!--?xml version="1.0" encoding="UTF-8"?-->'.PHP_EOL;
echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemalocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">' . PHP_EOL;

echo '<url>' . PHP_EOL;
echo '<loc>'.$base_url.'</loc>' . PHP_EOL;
echo '<lastmod>'.$date.'</lastmod>' . PHP_EOL;
echo '<changefreq>daily</changefreq>'. PHP_EOL;
echo '</url>' . PHP_EOL;

echo '<url>' . PHP_EOL;
echo '<loc>'.$base_url.'/index</loc>' . PHP_EOL;
echo '<lastmod>'.$date.'</lastmod>' . PHP_EOL;
echo '<changefreq>daily</changefreq>' . PHP_EOL;
echo '</url>' . PHP_EOL;

echo '<url>' . PHP_EOL;
echo '<loc>'.$base_url.'/contact</loc>'.PHP_EOL;
echo '<lastmod>'.$date.'</lastmod>' . PHP_EOL;
echo '<changefreq>daily</changefreq>' . PHP_EOL;
echo '</url>' . PHP_EOL;

echo '<url>' . PHP_EOL;
echo '<loc>'.$base_url.'/about</loc>' . PHP_EOL;
echo '<lastmod>'.$date.'</lastmod>' . PHP_EOL;
echo '<changefreq>daily</changefreq>' . PHP_EOL;
echo '</url>' . PHP_EOL;

echo '<url>' . PHP_EOL;
echo '<loc>'.$base_url.'/login</loc>' . PHP_EOL;
echo '<lastmod>'.$date.'</lastmod>' . PHP_EOL;
echo '<changefreq>daily</changefreq>' . PHP_EOL;
echo '</url>' . PHP_EOL;

echo '<url>' . PHP_EOL;
echo '<loc>'.$base_url.'/signup</loc>' . PHP_EOL;
echo '<lastmod>'.$date.'</lastmod>' . PHP_EOL;
echo '<changefreq>daily</changefreq>' . PHP_EOL;
echo '</url>' . PHP_EOL;

$num = ceil(mysqli_num_rows($pages)/5);
while($num > 0){
 echo '<url>' . PHP_EOL;
 echo '<loc>'.$serverName.'/blog/'.$num.'</loc>' . PHP_EOL;
 echo '<lastmod>'.$date.'</lastmod>' . PHP_EOL;
 echo '<changefreq>daily</changefreq>' . PHP_EOL;
 echo '</url>' . PHP_EOL;
 $num = $num-1;
}

while($row = mysqli_fetch_assoc($article)){
  echo '<url>' . PHP_EOL;
  echo '<loc>'.$serverName.'/post/'.$row['slug'].'</loc>' . PHP_EOL;
  echo '<lastmod>'.$date.'</lastmod>' . PHP_EOL;
  echo '<changefreq>daily</changefreq>' . PHP_EOL;
  echo '</url>' . PHP_EOL;
}

while($row = mysqli_fetch_assoc($category)){
  $title = $row['title'];
  $categoryTemp = mysqli_query($conn, "SELECT * FROM post WHERE category='$title'");
  $num1 = intval(mysqli_num_rows($categoryTemp)/5);
  $num1 = $num1+1;
  while($num1 > 0){
    echo '<url>' . PHP_EOL;
    echo '<loc>'.$serverName.'/category/'.$row['title'].'/'.$num1.'</loc>' . PHP_EOL;
    echo '<lastmod>'.$date.'</lastmod>' . PHP_EOL;
    echo '<changefreq>daily</changefreq>' . PHP_EOL;
    echo '</url>' . PHP_EOL;
    $num1 = $num1-1;
  }
}

while($row = mysqli_fetch_assoc($profile)){
  echo '<url>' . PHP_EOL;
  echo '<loc>'.$serverName.'/profile/'.$row['username'].'</loc>' . PHP_EOL;
  echo '<lastmod>'.$date.'</lastmod>' . PHP_EOL;
  echo '<changefreq>daily</changefreq>' . PHP_EOL;
  echo '</url>' . PHP_EOL;
}

echo '</urlset>' . PHP_EOL;

?>