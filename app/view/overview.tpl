<!DOCTYPE html>
<html lang="en">
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title> You are feeling enlightened </title>

<script src="<?= BASE_URL ?>/public/js/jquery-2.2.0.js"></script>
<script src="<?= BASE_URL ?>/public/js/script.js"></script>
<!-- Bootstrap core CSS -->
<link href="<?= BASE_URL ?>/bootstrap-3.3.6-dist/css/bootstrap.min.css" rel="stylesheet">
<script src="<?= BASE_URL ?>/bootstrap-3.3.6-dist/js/bootstrap.min.js"></script>

<script type="text/javascript" src="//d3js.org/d3.v3.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?= BASE_URL ?>/public/css/nav.css"/>

<script type="text/javascript">

var articleNum;
  
  // Function to be called for ajax changes to database
  // type: type of functionality you will be performing 
  // str: new data
  function ajaxCall(type, str)
    {
        var xmlhttp;
        if(str == "")
        {
            window.alert("Form is empty");
            return false;
        }
        else
        {
            if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        }   else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
        }

        xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            // document.getElementById("txtHint").innerHTML = xmlhttp.responseText;
            window.alert(xmlhttp.responseText);
            // drawDendrogram();
        }}
        // send the request to GUIcontroller.php
        xmlhttp.open("GET", "<?= BASE_URL ?>posts/all/gui/edit?str=" + str + "&type=" + type + "&Num=" + articleNum, true);
        xmlhttp.send();
      }


$(document).ready(function(){
  // Hide them all at the beginning
  $('.GUIedit').hide();
  // If the change URL button is clicked
  $("#GUIURLButton").click(function()
    { 
      var val = $('#GUIURLBox').val();
      ajaxCall("url", val);
      // return false; 
    });

  // If the change comment button is clicked
  $("#GUIcommentButton").click(function()
    { 
      var val = $('#GUIcommentBox').val();
      ajaxCall("comment", val);
      // return false; 
    });

  // If the change content button is clicked
  $("#GUIcontentButton").click(function(){ 
      var val = $('#GUIcontentBox').val();
      ajaxCall("content", val);
      // return false; 
  });

  // If the change title button is clicked
  $("#GUItitleButton").click(function(){
      var val = $('#GUItitleBox').val(); 
      ajaxCall("title", val);
      // return false; 
  });

  // If the delete button is clicked
  $("#GUIdeletePost").click(function(){
      ajaxCall("deletePost", "none");
      // return false; 
  });

  // If the delete button is clicked
 // If the delete button is clicked
  $("#GUIdeleteComment").click(function(){
      ajaxCall("deleteComment", "none");
      // return false; 
  });

  // First draw of it
  drawDendrogram();
});

function drawDendrogram() {


  var width = 500,
      height = 1000;

  var diameter = 1000;

  var tree = d3.layout.tree()
      .size([360, diameter / 2 - 120])
      .separation(function(a, b) { return (a.parent == b.parent ? 4 : 2) / a.depth; });

    var diagonal = d3.svg.diagonal()
      .projection(function(d) { return [d.y, d.x]; });

  var viz = $('#viz')[0]; // get the node for this Jquery result
  var svg = d3.select("body").append("svg")
      .attr("width", diameter)
      .attr("height", diameter)
      .append("g")
      .attr("transform", "translate(" + diameter / 2 + "," + diameter / 2 + ")");

  d3.json("<?= BASE_URL ?>/posts/all/json", function(error, root) {
    if (error) throw error;

    var nodes = tree.nodes(root);
    var links = tree.links(nodes);

      var link = svg.selectAll(".link")
      .data(links)
      .enter().append("path")
      .attr("class", "link")
      .attr("d", diagonal);

  var node = svg.selectAll(".node")
      .data(nodes)
      .enter().append("g")  
      .on('click', function(d) {
           $('.GUIedit').hide();
           switch(d.id)
           {
            // On node click...
              case "post":
                // display the post editor
                $('#GUIpostEdit').show();
                articleNum = d.num;
                break;
              case "comment":
                // display the comment editor only if you are the same user as that comment selected
                if(d.username == "<?= $_SESSION['username']?>")
                  $('#GUIcommentEdit').show();
                articleNum = d.num;
                break;
              case "username":
                break; 
                // do nothing, you can't change your username
              case "root":
                window.alert("All of the posts are displayed here!");

           }
         }
         )
    // .text(function(d) { return d.className + ": " + d.value; })
      .attr("class", "node")
      .attr("transform", function(d) { return "translate(" + d.y + "," + d.x + ")"; });

  node.append("a")
   .attr("xlink:href", function (d) { return d.url; })
    .append("rect")
          .attr("class", "clickable")
          .attr("y", -13)
          .attr("x", 12)
          .attr("width", 90) //2*4.5)
          .attr("height", 28)
          .style("fill", "white")
          .style("stroke", "pink")
          //.style("stroke-width", 0.3 px)
          .style("fill-opacity", 4)        // set to 1e-6 to hide          
          ;
  node.append("circle")
      .attr("r", 10);

  node.append("text")
      .attr("dx", function(d) { return  15; })
        .attr("dy", 8)

        .style("text-anchor", function(d) { return /*d.children ? "end" :*/ "start"; })
        .text(function(d) { return   d.name; });

  node.append("svg:a")
    .attr("xlink:href", function(d){return d.url;})  // <-- reading the new "url" property
  });

  d3.select(self.frameElement).style("height", height + "px");
}

</script>

<style type="text/css">

.node circle {
  fill: #fff;
  stroke: steelblue;
  stroke-width: 6px;
}

.node {
  font: 20px sans-serif;
  fill: orange;
}

.link {
  fill: none;
  stroke: #ccc;
  stroke-width: 3px;
}

#viz {
  width: 50%;
  float: right;
}

</style>




<body>
    <!-- Static navbar -->
      <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container-fluid">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#"></a>
          </div>
          <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
              <li><a href="<?= BASE_URL ?>">Home</a></li>
              <li><a href="<?= BASE_URL ?>posts/">Articles</a></li>
              <li><a href="<?= BASE_URL ?>EducateYourself">Weekly Enlightenment Quiz</a></li>
              <li><a href="<?= BASE_URL ?>DailyQuote">Daily Quote</a></li>
              <li><a href="<?= BASE_URL ?>tedswalk">Forest of Enlightenment</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
              <?php if (isset($_SESSION['username']))  {
              ?>
                <li><a href=<?php 
                      echo "/profile/" . ($_SESSION['username']);
                      ?>
                      >Profile</a></li>
              <?php } 
              
              if (isset($_SESSION['username']) && $_SESSION['username'] == 'Ted') { ?>
                <li><a href="/login">Settings</a></li>
              <?php } 
              else {?>
                <li><a href="/login">Login</a></li>
              <?php } ?>
            </ul>
          </div><!--/.nav-collapse -->
        </div><!--/.container-fluid -->
      </nav><center>
      

    <div>
    <!-- Free use image from Unsplash -->
    <img id="pic" class="img-responsive" src="<?= BASE_URL ?>/public/local/peaceful.jpg" />
    </div>

<!-- <ol> -->
<?php
    // Print out all items in a database in a visually appropriate way depending on whether you are printing out for posts, quizes, or quotes
    $var = "empty";
    switch($output)
    {
        case 'posts':
            while ($row = $result->fetch_assoc()) 
            {
                $var =  "<a href=" . BASE_URL. 'posts/'. $row["Num"] . '>' . $row["Title"] . "  :  " . $row["DatePosted"] ."</a><br>" ;
                echo $var;
            }
            ?><br><br>
            <?php if(isset($_SESSION['admin']) && $_SESSION['admin'] == 1){?>
              <form class="GUIedit" id="GUIpostEdit">
                  New Content:
                  <input type="text" name="content" id="GUIcontentBox"><input type="submit" value="Submit Changes" id="GUIcontentButton"><br>
                  New Title:
                  <input type="text" name="title" id="GUItitleBox"><input type="submit" value="Submit Changes" id="GUItitleButton"><br>
                  New Image URL:
                  <input type="text" name="URL" id="GUIURLBox"><input type="submit" value="Submit Changes" id="GUIURLButton"><br><br>
                  <input type="submit" value="Delete Node" id="GUIdeletePost"><br><br>
              </form>
            <?php } if(isset($_SESSION['username'])) {?>
              <form class="GUIedit" id="GUIcommentEdit">
                  Modify Comment:
                  <input type="text" name="firstname" id="GUIcommentBox"><input type="submit" value="Submit Changes" id="GUIcommentButton"><br><br>
                  <input type="submit" value="Delete Node" id="GUIdeleteComment">
              </form>
            <div id="viz">
            <h2>Visualization</h2>
            </div>
            <?php } ?>
            <?php
            break;
        case 'quizes':
            while ($row = $result->fetch_assoc()) {
                $var = "<a href=" . BASE_URL. 'EducateYourself/'. $row["Num"] . '>' . $row["Num"] . "  :  " . $row["DatePosted"] ."</a><br>" ;
                echo $var;
            }
            break;
        case 'quotes':
            while ($row = $result->fetch_assoc()) {
                $var = "<a href=" . BASE_URL. 'DailyQuote/'. $row["Num"] . '>' . $row["Num"] . "  :  " . $row["DatePosted"] ."</a><br>" ;
                echo $var;
            }
            break;
    }
?>



<!-- </ol> -->
</center><br><br>
<div id="footer"> 
    <a href="/info"> Info and References </a>
</div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
    <script src="../../dist/js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>
</body>
</html>