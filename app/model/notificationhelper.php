<?php


function getUserUrl($obj=null) {
  $url = '';

 
      $username = $obj->get('Username');
      $url = BASE_URL.'profile/'.$username;

    
  

  return $url;
}

function getPostUrl($obj)
{
  $url = '';

  $articleNum = $obj['Num'];
  $url = BASE_URL.'posts/'.$articleNum;

  return $url;
}

function getQuoteUrl($obj)
{
  $url = '';

  $quoteNum = $obj['Num'];
  $url = BASE_URL.'DailyQuote/'.$quoteNum;

  return $url;
}

function getQuizUrl($obj)
{
  $url = '';

  $quizNum = $obj['Num'];
  $url = BASE_URL.'EducateYourself/'.$quizNum;

  return $url;
}

function formatFollower($f)
{
  $formatted = '';

 
 
  $followerName = $f->get('Username');
  $followerUrl = getUserUrl($f);
  
  $formatted = sprintf("<a href=\"%s\">%s    ",
    $followerUrl, $followerName);

  return $formatted;
}


function formatNotification($n) {

  $formatted = '';
    //echo 'action id is ';
    //echo $n->get('ActionID');
  $nt = NotificationType::loadByNum($n->get('ActionID'));
  $notificationTypeName = $nt->get('Name');
  //echo $notificationTypeName;

 switch($notificationTypeName) {
    case 'quote_created':
       // get user's full name
      $user = AppUser::loadById($n->get('User1'));     
      $qb = quoteOps::getQuoteByID($n->get('Quote_1'));

      if($user != NULL && $qb != NULL)
      {
      $userUrl = getUserUrl($user);
      $quoteUrl = getQuoteUrl($qb);   
       $userName = $user->get('Username');
      // get the nicely formatted date
      // various examples here: http://php.net/manual/en/function.date.php
      $formattedDate = $qb['DatePosted'];
      //date("F j, Y, g:i a", strtotime($e->get('DatePosted')));

      // produce the formatted string
      $formatted = sprintf("<a href=\"%s\">%s</a> created <a href=\"%s\">the quote</a> on %s",
        $userUrl,
        $userName,
        $quoteUrl,
        $formattedDate
        );
    }
     break;

     case 'quiz_created':
       // get user's full name
      $user = AppUser::loadById($n->get('User1'));
      
      $qp = quizOps::getQuizByID($n->get('Quiz_1'));
      


      if($user != NULL && $qp != NULL)
      {
            $userName = $user->get('Username');
            $quizUrl = getQuizUrl($qp);
             $userUrl = getUserUrl($user);
            // get the nicely formatted date
            // various examples here: http://php.net/manual/en/function.date.php
            $formattedDate = $qp['DatePosted'];
            //date("F j, Y, g:i a", strtotime($e->get('DatePosted')));

            // produce the formatted string
            $formatted = sprintf("<a href=\"%s\">%s</a> created <a href=\"%s\">the quiz</a> on %s",
              $userUrl,
              $userName,
              $quizUrl,
              $formattedDate
              );
    }
      
     break;



     


    case 'post_created':

   
      // get user's full name
      $user = AppUser::loadById($n->get('User1'));
      $bp = articleOp::getArticleById($n->get('BlogPost_1'));
      
      if ($user != NULL && $bp != NULL)
      {
              $userUrl = getUserUrl($user);

              $userName = $user->get('Username');

              // get blogpost title
              
              $blogPostTitle = $bp['Title'];
              //echo $blogPostTitle;
              $blogPostUrl = getPostUrl($bp);
              // get the nicely formatted date
              // various examples here: http://php.net/manual/en/function.date.php
              $formattedDate = $bp['DatePosted'];
              //date("F j, Y, g:i a", strtotime($e->get('DatePosted')));

              // produce the formatted string
              $formatted = sprintf("<a href=\"%s\">%s</a> created the post <a href=\"%s\">%s</a> on %s",
                $userUrl,
                $userName,
                $blogPostUrl,
                $blogPostTitle,
                $formattedDate
                );
    }

      //echo $formatted;
    break;




    case 'post_edited':
      //echo $n->get('User1');
      // get user's full name
      $user = AppUser::loadById($n->get('User1'));
      $bp = articleOp::getArticleById($n->get('BlogPost_1'));
      
      if( $user != NULL && $bp != NULL)
      {
            $userUrl = getUserUrl($user);

            $userName = $user->get('Username');

            // get blogpost title
            
            $blogPostTitle = $bp['Title'];
            $blogPostUrl = getPostUrl($bp);
            // get the nicely formatted date
            // various examples here: http://php.net/manual/en/function.date.php
            $formattedDate = $bp['DatePosted'];
            // produce the formatted string
            $formatted = sprintf("<a href=\"%s\">%s</a> edited the post <a href=\"%s\">%s</a> on %s",
              $userUrl,
              $userName,
              $blogPostUrl,  
              $blogPostTitle,
              $formattedDate
              );
    }
    break;




    case 'comment_created':
      //echo $n->get('User1');
      // get user's full name
      $user = AppUser::loadById($n->get('User1'));
      // get blogpost title
      $bp = articleOp::getArticleById($n->get('BlogPost_1'));


      if($user != NULL && $bp != NULL)
      {
             $userName = $user->get('Username');
              $userUrl = getUserUrl($user);
              $blogPostTitle = $bp['Title'];
              $blogPostUrl = getPostUrl($bp);
              // get the nicely formatted date
              // various examples here: http://php.net/manual/en/function.date.php
              $formattedDate = $bp['DatePosted'];
              // produce the formatted string
              $formatted = sprintf("<a href=\"%s\">%s</a> commented on <a href=\"%s\">%s </a>on %s",
                $userUrl,
                $userName,
                $blogPostUrl,
                $blogPostTitle,
                $formattedDate
                
                );
    }

    break;

    

    
    default:
      $formatted = 'Event formatting not found.';
      break;
  }

  return $formatted;

}
