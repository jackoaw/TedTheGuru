<?php

include_once '../global.php';

// get the identifier for the page we want to load
$action = $_GET['action'];

$ac = new ArticleController();
$ac->redirect($action);

$db = db::instance();

/**
*	Controls the articles 
*/
class ArticleController{
	// Redirect to the appropriate action or page
	function redirect($action)
	{
		switch($action)
		{
			// Viewing specific post
			case 'post':
				$postID = $_GET['postID'];
				if($_GET['postID'] > db::getMaxNum('posts') )
				{
					include_once SYSTEM_PATH."/view/home.tpl";
					die('Invalid access');
				}
				else
					$this->viewPost($postID);
				break;

			// Viewing all posts
			case 'all':
				$this->viewAll();

				break;

			case 'jsonAll':
				$this->jsonForAll();

				break;

			// Create a new article
			case 'create':
				$this->editor();
				break;

			// Delete an Article
			case 'delete':
				$this->editor();
				break;

			// Edit an existing article
			case 'edit':
				$this->editor();
				break;

			// Used for submitting a query from the previous 3 options
			case 'submit':
				$this->submitToDB();
				break;

			// When comment is added
			case 'addComment':
				$postID = $_GET['postID'];
				$userName = $_SESSION['username'];

				// Get user name by load $_SESSION['Username']		
				$user = AppUser::loadByUserName($userName); // get logged-in userna

				// Get comment by text area 'yourComment' in posts.tpl
				$commentText = $_POST['yourComment'];

				//Submit to database
				$this->submitComment($postID, $user, $commentText);
				break;
			
				
		}

	}


	// View all Posts
	// Access by 'view all posts' in posts.tpl
	function viewAll()
	{
		//header('Content-Type: application/json');
		// put in lister.class to list all posts
		$output = 'posts';
		$result = lister::listall('posts');
		// echo $result->fetch_assoc();
				// get all blog posts
		include_once SYSTEM_PATH.'/view/overview.tpl';
	}

	function jsonForAll()
	{

		header('Content-Type: application/json');
		$posts = articleOp::getAllArticles();

		$jsonPosts = array(); // array to hold json posts


		foreach($posts as $post) {
			// get comments for this post
			if($post != NULL)
			{
				$comments = comments::getByBlogPostId($post['Num']);
				//echo 'post nubmer is : '.$post['Num'];

				$jsonComments = array(); // array to hold json comments
				$jsonUser = array();
				if($comments != NULL)
				{	
					foreach($comments as $comment) 
					{
						$commentText = $comment->get('Comment');
						$commentUser = $comment->get('User');
						//echo 'how about here?    : \n'.$commentText;
						// truncate if needed to fit into visualization
						if(strlen($commentText) > 5)
						{
							$commentText = substr($commentText, 0, 5).'...';
						}
						// the json comment object
						$username = AppUser::loadById($commentUser)->get('Username');
						$jsonComment = array(
							'id' => 'comment',
							'name' => $commentText,
							'username' => $username,
							'num' => $comment->get('Num'),
							'url' => BASE_URL . "posts/" . $post['Num'],
							'children' => array(array('id' => 'username',
												'name' => $username,
												'url' => BASE_URL . "profile/" . $username))
						);
						$jsonComments[] = $jsonComment;
					}
				}
				else
				{
					$jsonComents = NULL;
				}
			


				if(strlen($post['Title']) < 6)
				{
					// the json post object
					$jsonPost = array(
						'id' => 'post',
						'name' => $post['Title'],
						'num' => $post['Num'],
						'url' => BASE_URL . "posts/" . $post['Num'],
						'children' => $jsonComments
					);
				}
				else
				{
					$shorterName = substr($post['Title'], 0 , 6).'...';
					$jsonPost = array(
						'id' => 'post',
						'name' => $shorterName,
						'num' => $post['Num'],
						'url' => BASE_URL . "posts/" . $post['Num'],
						'children' => $jsonComments
					);
				}
				$jsonPosts[] = $jsonPost;
			}
			else
			{
				$jsonPosts = NULL;
			}
		}

		// finally, the json root object
		$json = array(
			'id' => 'root',
			'name' => 'posts',
			'url' => BASE_URL . "posts/1",
			'children' => $jsonPosts
		);
		// $json[sizeof($json)] = "";

		echo json_encode($json);
	}


	// Add new comment to database
	function submitComment($pid, $user, $commentText) {
   		// save comment to database 
    	$comment = new comments();
		$comment->set('ArticleNum', $pid);
		$comment->set('User', $user->get('id'));
		$comment->set('Comment', $commentText);
		$comment->save();

		
		$commentNum = db::getMaxNum('comments');

		// Create new 'comment_created' type Notification
		$logEvent = new Notification(array(
				'ActionID' => NotificationType::getIdByName('comment_created'),
				'User1' => $comment->get('User'),
				'BlogPost_1' => $comment->get('ArticleNum'),
				'Comment_1' => $commentNum
		));
		// Submit to Notification table
		$logEvent->save(); // log the event

		header('Location: '.BASE_URL.'posts/'.$pid);
    }


    // View specific post
	function viewPost($postNumber)
	{
		// Post number you want to view
		$id = $postNumber;
		// Article and associated variables
    	$article = articleOp::getArticleById($id);
    	// number of articles

    	$max = db::getMaxNum('posts');
    	$min = db::getMinNum('posts');
    	$next = db::getNextNum('posts', $id);
    	$prev = db::getPrevNum('posts', $id);


    	// get any comments for this post
		$comments = comments::getByBlogPostId($postNumber);
    	// get a relevant image from Flickr by using getFlickrImage(text)
    	// search "Title" and return url
		$flickrImageURL = self::getFlickrImage($article["Title"]);
    	//load page
    	include_once SYSTEM_PATH.'/view/posts.tpl';
    	include_once SYSTEM_PATH.'/model/notificationhelper.php';

	}

	// Redirect to editor editor.tpl
	// Only admin can access
	function editor()
	{
		$action = $_GET['action'];
		// will determine page content from within
		include_once SYSTEM_PATH.'/view/editor.tpl';
	}


	//submit changes to database
	function submitToDB()
	{
		$action;
		// All of these are just to choose the appropriate action based on the POST variables recieved
		if(isset($_POST['content']) && isset($_POST['title']) && isset($_POST['post#']) && isset($_POST['imageURL']))
		{
			// Create Post
			$action = 'create';
		}
		else if(isset($_POST['newContent']) && isset($_POST['post#']))
		{
			//Edit article by using articleNum
			$action = 'edit';
		}
		else if(isset($_POST['post#']))
		{
			//Delete the post 
			$action = 'delete';
		}
		else
		{
			echo "ERROR";
		}
		include_once SYSTEM_PATH. '/view/editor.tpl';
		// Do the action
		switch($action)
		{
			
			case 'create':
				// Create the new articleOp
				articleOp::createArticle($_POST['post#'], $_POST['title'], $_POST['imageURL'], $_POST['content']);

				// Create new Notification
				$logEvent = new Notification(array(
				'ActionID' => NotificationType::getIdByName('post_created'),
				'User1' => 1,
				'BlogPost_1' => $_POST['post#']
				));

				// Save Notification to database
				$logEvent->save();
				echo 'Success!';
				break;

			case 'delete':
				// Delete the aritlce by ArticleNum
				articleOp::deleteArticle($_POST['post#']);
				Notification::deleteNotificationByPost($_POST['post#']);
				comments::deleteCommentByPost($_POST['post#']);
				echo 'Success!';
				break;

			case 'edit':
				// Edit aritcle by using ArticleNum
				articleOp::modifyArticle($_POST['post#'], $_POST['newContent']);

				//Create new 'post_edited' Notification
				$logEvent = new Notification(array(
				'ActionID' => NotificationType::getIdByName('post_edited'),
				'User1' => 1,
				'BlogPost_1' => $_POST['post#']
				));

				// Save notification to database
				$logEvent->save();

				echo 'Success!';
				break;
		}
	}


// Get Relevent Flicker Image by using search
public static function getFlickrImage($text){
			$endpoint = "https://api.flickr.com/services/rest/?";
			//url for result of search(text)
			$url = $endpoint.
						"method=flickr.photos.search&".
						"api_key=463a57dc15cdb003a638116f01e481a4&".
						"text=".urlencode($text)."&".
						"extras=url_n&". // return URL to small image (320 px longest side)
						"sort=relevance&". // sort by relevance
						"safe_search=1&".
						"format=json&".
						"nojsoncallback=1";

			//get contents from search result
			$json = file_get_contents($url);
			//decode contents into array
			$arr = json_decode($json, true); // decode JSON into php associative array
			
		//first Array photo
		$photo = $arr['photos'];
		//first photo array
		$photo = $photo['photo'];
		//first photo object
		$photo = $photo[1];

		//return url_n value of first photo object
		return $photo['url_n']; // just return the first one
		
			
			
	}


}