<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Thumbnail Gallery - Start Bootstrap Template</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/thumbnail-gallery.css" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/Gallery.css" rel="stylesheet">
    <link href="css/tabbar.css" rel="stylesheet">
    <link href="css/commentbox.css" rel="stylesheet">
    <!-- Custom Fonts -->
    <link href="css/listcomment.css" rel="stylesheet"type="text/css">
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="font-awesome/css/font-awesome.css">
    <link href="./css/fbphotobox.css" rel="stylesheet" type="text/css" />

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <script src="js/ca-pub-3311815518700050.js"></script>
    <script src="js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>

    <![endif]-->
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/themes/smoothness/jquery-ui.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/jquery-ui.min.js"></script>
    <link href="css/fbphotobox.css" rel="stylesheet" type="text/css" />
    <script src="js/fbphotobox.js"></script>

    <style>
        body {
            font-family: 'lucida grande', tahoma, verdana, arial, sans-serif;
            font-size: 13px;
            position: relative;
        }

        .fbphotobox img {
            width:200px;
            height:200px;
            margin:10px;
            border-radius:5px;
        }

        .fbphotobox img:hover {
            box-sizing:border-box;
            -moz-box-sizing:border-box;
            -webkit-box-sizing:border-box;
            border: 5px solid #4AE;
        }
    </style>
    <script type="application/javascript">
        $('#commentform').submit(function() {
            var name = 'comments='$(this).find('textarea[name="comments"]').val()
            $.ajax({
                type: "POST",
                url: "DoanWeb/Gallery/  ",
                data: name,
                success: function() {

                }
        });
    </script>

</head>
<body>
<?php
    include "../Data/ImageDb.php";
    include_once "../Data/CommentDb.php";
    $Image=new ImageDb();
    $user=$username;
    $list=$Image->geImageByUN($user);

    if(isset($_POST['comments'])){
        $UserName=$username;
        $content=$_POST['comments'];
        $commentImage = $_POST['CommentImageID'];
        $insertcomment=new CommentDb();
        $insertcomment->insertComment($UserName,$commentImage,$content);

    }
    if(isset($_POST['sortbydate'])){
        $sortType=$_POST['sortbydate'];
        if($sortType=='ASC'){
            $list=$Image->getImageByUNASC($user);
        }else{
            $list=$Image->getImageByUNDESC($user);
        }
    }

?>
<div class="col-lg-4" style="float: right">
    <table>
        <tr>
            <form name='dropdownform' action='index.php' method='post'>
            <td><label style="font-size: larger">Sort by date</label></td>
            <td>   <select class='form-control' name='sortbydate' onchange='this.form.submit()'>
                    <option>Select a type you want sort</option>
                    <option value='ASC'>ASC</option>
                    <option value='DESC'>DESC</option>
                </select></td>
            </form>
        </tr>
    </table>



</div>

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header"> Gallery</h1>
    </div>

    <?php
    $stt=0;
    foreach ($list as $img){
        $url=$img->getUrl();
        $imgId=$img->getImageID();
        $UserName=$img->getUsername();
        $Decription=$img->getDesciption();
        $Date=$img->getDate();
        $stt+=1;
        if(isset($_GET['ImageID'])) {
            $a=$_GET['ImageID'];
        }
       else{ $a=0;}
            echo "    <script>
        
        jQuery(function ($) {
       
         
          
         $(document).ready(function() {
             
            $('#target').submit( function(event) {
              
            
                event.preventDefault();
            
                setTimeout( function () { 
                    this.submit();
                }, 3000000);
            }); 
            $('#photo$imgId').on('click',function(){
                $.post('submit.php',{ImageID:$('#ImageID$imgId').val()},
                       function (data) {
                       {               
                            imgId=data;
                            $('.fbphotobox-image-content').load('Explore.php #abc'+data);
                       }
                });
            });
             $('.fbphotobox img').fbPhotoBox({
                    rightWidth: 360,
                    leftBgColor: 'black',
                    rightBgColor: 'white',
                    footerBgColor: 'black',
                    overlayBgColor: '#222',
                    containerClassName: 'fbphotobox',
                    imageClassName: 'photo',
                    
                    onImageShow: function() {
                     
                        $('.fbphotobox img').fbPhotoBox('addTags',
                            [{x:0.3,y:0.3,w:0.3,h:0.3}]);
                       
                        
                        
                 
                       	
                    }
                   });
            });
        })(jQuery);
           
    </script>";

        echo"<form id='target' method='get'>";
        echo "<input type='hidden'id='ImageID$imgId' name='ImageID' value='$imgId'>";
        echo "</form>";
        echo"<div class=\"col-lg-3 col-md-4 col-xs-6 thumb\">";
        echo"	<div class='fbphotobox' id='photo'>
                <a  class='aaf' id='photo$imgId'><img class='photo' fbphotobox-src='../../uploads/$user/$url'
         src='../../uploads/$user/$url'></a></div>";
        echo "<div class=\"modal fade\" id=\"myModal\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"myModalLabel\">
              <div class=\"modal-dialog\" role=\"document\">
                <div class=\"modal-content\">
                  <div class=\"modal-header\">
                    <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>
                    <h4 class=\"modal-title\" id=\"myModalLabel\">Modal title</h4>
                  </div>
                  <div class=\"modal-body\">
                <div id='abc$imgId'style='width: 20%;height: 100px;padding-right: 35%'>
               
                <table align='center' style='margin-left: 30px'>
                    <tr>
                        <td><div class=\"round\" style=\"background-image: url(img/portfolio-1.jpg);margin: 0;width: 70px;height: 70px\"></div>
                        </td>
                        <td>
                            <label style=\"font-size: large;float: right;margin-top: 20px;margin-left: 10px \">$UserName</label>
                            <label style='text-align: center;margin-left: 10px'>Updated:</label>
                          
                            $Date
                        </td>
                    </tr>
                    <td><Label>Decription:</Label></td>
                    <td><label>$Decription</label></td>
                    <tr>
            
                    </tr>
                </table>
                
                ";
        echo" 
           <div class='container' style='background-color: white' id='v'>
            <div class='row'>
            <div class='col-md-3'>
                    <label>Text you comment here!</label>
                    <form method='post'>
                           <input type='hidden' name='CommentImageID' value='$imgId'>
                           <textarea placeholder='comment here'  row='5' cols='45' name='comments' id='comments' display:none data-dismiss='modal'></textarea>
                          <button type='submit' style='margin-top: 10px'class=\"btn btn-success green\"><i class=\"fa fa-share\"></i>Comment</button>
                    </form>
                         
            </div>
        </div></div>";
        $commentDb=new CommentDb();
        $listComment=$commentDb->getCommentByImageId($imgId);
        $sizeoflComment=count($listComment);
         echo" 
                <div class=\"container\" >
                 <div class=\"row\"style='margin: 0'>
                <div class='col-md-3'>
                    <div class='page-header'>
                       <small class='pull-right'>$sizeoflComment comments</small> Comments
                    </div>
                 
                ";

             foreach ($listComment as $comment){
                 $UserComment=$comment->getUsername();
                 $Content=$comment->getContent();
                 $DateComment=$comment->getDate();
                 echo"  <div class='comments-list'>
                          <div class='media'>
                            <p class='pull-right'><small>$DateComment</small></p>
                            <a class='media-left' href='#'>
                            <img src = 'http://lorempixel.com/40/40/people/1/' >
                            </a>
                            <div class='media-body' ><h4 class=\"media-heading user_name\" >$UserComment</h4 >
                           $Content    
                           
                       <p ><small ><a href = \"\" > Like</a > - <a href = \"\" > Share</a ></small ></p >
                               </div>
                               </div>
                               </div>";

             }

              echo"   
                </div>
                 </div>
                </div>
                </div>
                </div>
                </div>
                </div>
                </div>    
            
         
           ";
	    echo"</div>";
    }
    ?>

</div>










<!-- jQuery -->
<script src="js/jquery.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/jquery-1.12.0.min.js"></script>

</body>

</html>