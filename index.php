
<html>
<body>
<center><form method="GET">
<input id="name" type="text" name="search" placeholder="search"><br><br>
<input type="submit">
</form>
</center>
</body>
<html>
<?php
if(isset($_GET['search'])){
	$name=$_GET['search'];
 @$html = file_get_contents('https://www.amazon.in/s/field-keywords='.$name.'');// for getting the htmlusing @ on starting to avoid warnings 
 $link= new DOMDocument();
libxml_use_internal_errors(TRUE);//disable libxml errors
if(!empty($html)){//check whether the html is returned or not
              $link->loadHTML($html);
	libxml_clear_errors(); //remove errors for yucky html
	
	$link_xpath = new DOMXPath($link);
	//get all the h2's with an id
	
     $number = $link_xpath->query('//li[@class="s-result-item celwidget  "]');
    

    for($i=0;$i<($number->length);$i++)
    {
            $field="result_".$i;
    	$name = $link_xpath->query('//li[@id="'.$field.'"]/div[@class="s-item-container"]/div[@class="a-fixed-left-grid"]/div[@class="a-fixed-left-grid-inner"]/div[@class="a-fixed-left-grid-col a-col-right"]/div[@class="a-row a-spacing-small"]/div[@class="a-row a-spacing-none"]/a[@class="a-link-normal s-access-detail-page  s-color-twister-title-link a-text-normal"]');
    	$price =$link_xpath->query('//li[@id="'.$field.'"]/div[@class="s-item-container"]/div[@class="a-fixed-left-grid"]/div[@class="a-fixed-left-grid-inner"]/div[@class="a-fixed-left-grid-col a-col-right"]/div[@class="a-row"]/div[@class="a-column a-span7"]/div[@class="a-row a-spacing-none"]/a[@class="a-link-normal a-text-normal"]/span[@class="a-size-base a-color-price s-price a-text-bold"]');
    $image= $link_xpath->query('//li[@id="'.$field.'"]/div[@class="s-item-container"]/div[@class="a-fixed-left-grid"]/div[@class="a-fixed-left-grid-inner"]/div[@class="a-fixed-left-grid-col a-col-left"]/div[@class="a-row"]/div[@class="a-column a-span12 a-text-center"]/a[@class="a-link-normal a-text-normal"]/img[@class="s-access-image cfMarker"]');
    $discount=$link_xpath->query('//li[@id="'.$field.'"]/div[@class="s-item-container"]/div[@class="a-fixed-left-grid"]/div[@class="a-fixed-left-grid-inner"]/div[@class="a-fixed-left-grid-col a-col-right"]/div[@class="a-row"]/div[@class="a-column a-span7"]/div[@class="a-row a-spacing-none"]/span[@class="a-size-small a-color-price"]');

    if($discount->length>0){
    

    $a=0;
    $disc= $discount[0]->nodeValue;
    preg_match('/\([^\%]+/',$disc,$disc1);
    $disc_final=str_replace("(", "", $disc1);
    $disc_final_1=(int)$disc_final[0];
    
    
}
else{
$disc_final_1=0;
}
    echo "Discount: ".$disc_final_1."<br>";
    echo "Price: ".$price[0]->nodeValue."<br>";
    echo "Name: ".$name[0]->nodeValue."<br>";
    $src=$image[0]->getAttribute('src');
    echo "<img width='150px' height='150px' src='$src'>"."<br>";

 }
}
}
?>
