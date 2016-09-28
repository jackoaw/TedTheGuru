<?php
include_once '../global.php';
$action = $_GET['type'];
// will be post Num or comment Num
$num = $_GET['Num'];
$str = $_GET['str'];
switch($action)
{
	case "content":
		articleOp::modifyArticle($num, $str);
		echo 'successfuly edited the post content ' . $num;
		break;

	case "comment":
		comments::modifyComment($num, $str);
		echo 'successfuly edited your post comment';
		break;

	case "url":
		articleOp::modifyArticleImage($num, $str);
		echo 'sucessfully edited the image url!';
		break;

	case 'title':
		articleOp::modifyArticleTitle($num, $str);
		echo 'sucessfully edited the title!';
		break;

	case 'deletePost':
		articleOp::deleteArticle($num);
		comments::deleteCommentByPost($num);
		Notification::deleteNotificationByPost($num);
		echo 'success!';
		break;

	case 'deleteComment':
		comments::deleteComment($num);
		Notification::deleteNotificationByComment($num);
		echo 'success!';
		break;

	default:
		echo "failure";
}

?>