<?php
include('new_header.php');
class Process
{
    protected $_xml;
    protected $path;

    public function __construct()
    {
        $this->_xml = simplexml_load_file("data/recipies.xml");
				
    }

    public function getXml()
    {
        return $this->_xml;
    }
	
    public function setPath($path)
    {
        $this->path = $path;
    }

    public function getPath()
    {
        return $this->path;
    }

    public function recipie_list()
    { 
		$ar = array();
		foreach ( $this->_xml as $recipie )
	{
		$ar[] = $recipie;
	}

	function sort_callback($a, $b)
	{
		return (string)$a->name > (string)$b->name;
	}

	usort($ar, 'sort_callback');

	echo "<table>";

	foreach ( $ar as $recipie )
	{
	echo "
		<tr>
			<td>
				<a href=\"process.php?view_recipie=$recipie->id\">$recipie->name</a>
			</td>
            <td>
                <a href='process.php?edit=" . $recipie->id . "'>edit</a> 
			</td>
			<td>
                <a href='process.php?delete=" . $recipie->id . "'>delete</a>
            </td>
		</tr>";
}
	
        echo "</table>";
		//
		
    }
	
	public function highlightKeywords($text, $keyword) 
	{
			$wordsAry = explode(" ", $keyword);
			$wordsCount = count($wordsAry);
			
			for($i=0;$i<$wordsCount;$i++) {
				$highlighted_text = "<span style='font-weight:bold;color:red;'>$wordsAry[$i]</span>";
				$text = str_ireplace($wordsAry[$i], $highlighted_text, $text);
			}

			return $text;
	}

    public function search($post)
    {
		$search_str = $post;
		
	if ($search_str) {
	$str1="";
	$str2="";
	foreach ($this->_xml as $recipie) {
		
		if (preg_match('/'.$search_str.'/i',$recipie->ingredient) or
		preg_match('/'.$search_str.'/i',$recipie->name))
			{
				
				$str1 .= '<h2><a href=process.php?view_recipie='.$recipie->id.'>'.$recipie->name.'</a></h2>';
				$str1 .= $this->highlightKeywords($recipie->ingredient,$search_str) ."<br>";
				$str1 .= $this->highlightKeywords($recipie->name,$search_str) ."<br>";
				
			} 
	}
		
		}
		echo nl2br($str1);
    }

    public function add_recipie($post)
    {
        
			
            $xml = $this->_xml;
			$ids = $xml->xpath("//recipies/id"); // select all ids
			$newid = max(array_map("intval", $ids)) + 1; // change objects to `int`, get `max()`, + 1
            $recipies = $xml->addChild('recipies');
			$id = $recipies->addChild("id", $newid);
			$date = $recipies->addChild('date','' );
			$name = $recipies->addChild('name', ucfirst($_POST['name']));
			$note = $recipies->addChild('note', '');
			$archive = $recipies->addChild('archive', 0);
			$ingredient = $recipies->addChild('ingredient', $_POST['ingredient']);
			$method = $recipies->addChild('method', $_POST['method']);
			$meal_list = $recipies->addChild('meal_list', 0);
            //$name = $recipies->addChild("name", $post["name"]);
            //$ingredient = $recipies->addChild("ingredient", $post["ingredient"]);
            //$method = $recipies->addChild("method", $post["method"]);
            $xml->asXML($this->path);
			header( 'Location: index.php' ) ;
		
		
    }

    public function get_recipie_by_id($id)
    {
        $recipie = $this->_xml->xpath('recipies[id="' . $id . '"]');
		return $recipie[0];
    }

    public function update_recipie($post)
    {	
        $recipie = $this->_xml->xpath('recipies[id="' . $post['id'] . '"]');
        $recipie[0]->name = ucfirst($post["name"]);
        $recipie[0]->ingredient = $post["ingredient"];
        $recipie[0]->method = $post["method"];
		$this->_xml->asXML($this->path);
		header( 'Location: index.php' ) ;
    }
	
	public function meal_list()
	{	
		$ar = array();
		$edit = "<img src='css/images/edit.png'>";
		$close = "<img src='css/images/close.png'>";
		$xml = $this->_xml->xpath('recipies[meal_list=1]'); 
		foreach ( $xml as $recipie )
		{
			$ar[] = $recipie;
		}

	function sort_callback($a, $b)
	{
		return (string)$a->name > (string)$b->name;
	}

	usort($ar, 'sort_callback');

	echo "<table>";

	foreach ( $ar as $recipie )
	{
	
		$edit = "<img src='css/images/close.png'>";
		$xml = $this->_xml->xpath('recipies[meal_list=1]'); 
			echo "
				<tr>
						<td><a href=\"process.php?view_recipie=$recipie->id\">$recipie->name</a></td>
						<td><a href=\"process.php?meal_list_delete=$recipie->id\">$edit</a></td>
				</tr>";
    
		

			
	}
	echo "</table>";
}	

	public function meal_list_view()
	{	
		$ar = array();
		$edit = "<img src='css/images/edit.png'>";
		$close = "<img src='css/images/close.png'>";
		$xml = $this->_xml->xpath('recipies[meal_list=1]'); 
		foreach ( $xml as $recipie )
		{
			$ar[] = $recipie;
		}

	function sort_callback($a, $b)
	{
		return (string)$a->name > (string)$b->name;
	}

	usort($ar, 'sort_callback');


	foreach ( $ar as $recipie )
	{
		echo nl2br("<h3>$recipie->name</h3><p>$recipie->ingredient<br><br>$recipie->method </p><hr>");
	}
}	

	public function meal_list_shopping()
	{	
		$ar = array();
		$edit = "<img src='css/images/edit.png'>";
		$close = "<img src='css/images/close.png'>";
		$xml = $this->_xml->xpath('recipies[meal_list=1]'); 
		foreach ( $xml as $recipie )
		{
			$ar[] = $recipie;
		}

	function sort_callback($a, $b)
	{
		return (string)$a->name > (string)$b->name;
	}

	usort($ar, 'sort_callback');

	foreach ( $ar as $recipie )
	{
		echo nl2br("<h3>$recipie->name</h3><p>$recipie->ingredient</p><hr>");
	}
}	
	public function view_recipie($id)
	{
	    
		echo '<a style=color:green href="process.php?meal_list_add='.$id.'">Add recipie to meal list</a><br>';

		$arr = $this->_xml->xpath('recipies[id='.$id.']');        
		echo '<a href="#" onclick="printdiv()">Print</a><div id="printpage">'; 
		echo "<h3><p>".$arr[0]->name."</p></h3>";
		echo '<div class="view-search"; contenteditable="true"><p>';
		echo $arr[0]->ingredient;
		echo '</div><div class="view-search"; contenteditable="true"><p>';
		echo $arr[0]->method;
		echo '</p></div>'; 
		echo "<script src='dist/print_div.js'></script>";
	}
	
	public function meal_list_delete($id)
	{
		$recipie = $this->_xml->xpath('recipies[id='.$id.']');
		$recipie[0]->meal_list = 0;
		$this->getXml()->asXML($this->path);
		header( 'Location: process.php?meal_list' ) ;
		
		
	}
	
	public function meal_list_add($id)
	{
		if($id >0)
		{
			$recipie = $this->_xml->xpath('recipies[id='.$id.']');
			$recipie[0]->meal_list = 1;
			$this->getXml()->asXML($this->path);
			header( 'Location: process.php?meal_list' ) ;
		}
			
		
		
		
	}
	
	public function recipie_list_delete($id)
	{
		echo '<form method="post">';
		echo '<input type="hidden" name="del" value="1"/>';
		echo '<input type="submit" value="Confirm Delete"/>';
		echo '</form>';

		$del = $_POST['del'];
		
		if($del == 1)
		{
			$ar = $this->_xml->xpath('recipies[id='.$id.']');
			unset($ar[0][0]);
			$this->getXml()->asXML($this->path);
			header( 'Location: index.php' ) ;
		}
	}
}
//End of class 'process'
//Controller
$param = $_SERVER['QUERY_STRING'];
$arr = explode("=", $param);
if (count($arr) > 1) {
    $param = $arr[0];
}
$path = getcwd()."/data/recipies.xml";
$process = new Process();
$process->setPath($path);

if ($param == "recipie_list") {
    $process->recipie_list();
}
if ($param == "meal_list") {
    $process->meal_list();
}
if ($param == "meal_list_view") {
    $process->meal_list_view();
}
if ($param == "meal_list_shopping") {
    $process->meal_list_shopping();
}
if ($param == "view_recipie") {
    $id = $arr[1];
    $process->view_recipie($id);
}
if ($param == "meal_list_add") {
    $id = $arr[1];
    $process->meal_list_add($id);
}
if ($param == "meal_list_delete") {
    $id = $arr[1];
    $process->meal_list_delete($id);
}
if ($param == "add") {
    $post = $_POST;
    $process->add_recipie($post);
}
if ($param == "search") {
    $post = $_POST["search"];
    $process->search($post);
}
if ($param == "delete") {
    $id = $arr[1];
	$process->recipie_list_delete($id);
	

    
}

if ($param == "edit") {
    $id = $arr[1];
    $recipie = $process->get_recipie_by_id($id);
    include 'recipie.php';
}

if ($param == "update_recipie") {
    $post = $_POST;
    $process->update_recipie($post);
	

	
}


