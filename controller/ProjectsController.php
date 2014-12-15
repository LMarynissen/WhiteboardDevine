<?php

require_once WWW_ROOT . 'controller' . DS . 'Controller.php';
require_once WWW_ROOT . 'dao' . DS . 'ProjectDAO.php';
require_once WWW_ROOT . 'dao' . DS . 'UserDAO.php';
require_once WWW_ROOT . 'php-image-resize' . DS . 'ImageResize.php';

class ProjectsController extends Controller {

	private $projectDAO;
	private $userDAO;

	function __construct() {
		$this->projectDAO = new ProjectDAO();
		$this->userDAO = new UserDAO();
	}

	public function index() {
		if(!empty($_SESSION["user"])){
			$this->set("projects",$this->projectDAO->selectByUser($_SESSION["user"]["id"]));
			$this->set("invitedProjects",$this->projectDAO->selectInvitedProjectsByUser($_SESSION["user"]["id"]));
		}
	}

	public function view(){

		$project = false;
		$items = false;
		$itemCreators = false;
		$invited = false;
		$access = false;

		//Find email of creator of whiteboard
		$creatorEmail = false;
		$creatorEmail = $this->projectDAO->selectCreatorByProjectId($_GET["id"])[0]['email'];
		$this->set("creatorEmail",$creatorEmail);

		if(!empty($_GET["id"])){
			$project = $this->projectDAO->selectById($_GET["id"]);
			$items = $this->projectDAO->selectItemsByProjectId($_GET["id"]);
			for( $i = 0; $i < sizeof($items); $i++ ){
				$itemCreators[$i] = $this->projectDAO->selectUserByItemId($items[$i]['id']);
			}

			$invited = $this->projectDAO->selectInvitedByProjectId($_GET["id"]);
			$inviteds = $this->projectDAO->selectInvitedPeopleByProject($_GET["id"]);

			//Check if user is allowed to view the whiteboard
			if(!empty($_SESSION["user"])){
				//If person is on the invited list for this whiteboard
				foreach ($invited as $invite) {
					if($_SESSION["user"]["id"] == $invite['user_id']){
						$access = true;
					}
				}

				//If person is creator of whiteboard
				if($_SESSION["user"]["id"] == $project['user_id']){
					$access = true;
				}

				if(!$access){
					$_SESSION["info"] = "Je hebt geen toegang tot deze whiteboard";
					$this->redirect("index.php");
				}

			}else{
				$_SESSION["info"] = "Je moet ingelogd zijn om whiteboards te kunnen bekijken";
				$this->redirect("index.php");
			}
			
			if(empty($project)){
				$this->redirect("index.php");
			}
			$this->set("project",$project);
			$this->set("items",$items);
			$this->set("itemCreators",$itemCreators);
			$this->set("access",$access);
			$this->set("inviteds",$inviteds);
		} else {
			$this->redirect("index.php");
		}
		if(empty($project)){
			$this->redirect("index.php");
		}
	}

	public function add(){
		$errors = array();

		if(!empty($_POST)){

			$title = $_POST["title"];
			$description = $_POST["description"];

			if(empty($errors)){
					$this->projectDAO->insert(array(
						"user_id"=>$_SESSION["user"]["id"],
						"title"=>$title,
						"description"=>$description
					));
					$_SESSION["info"] = "Project successvol aangemaakt";
					$this->redirect("index.php");
			}
		}	

		if(!empty($errors)){
			$_SESSION["error"] = "Het project kon niet aangemaakt worden";
		}
		$this->set('errors', $errors);
	}

	public function addItem(){
		$errors = array();
		$size = array();

		if($_FILES['content']['error'] == 0){

				//check if file is an image
				$size = getimagesize($_FILES['content']['tmp_name']);
				if(empty($size)) {
					$isAnImage = false;
				}else{
					$isAnImage = true;
				}

				if($isAnImage){
					if(empty($errors["content"])){
						$size = getimagesize($_FILES["content"]["tmp_name"]);
						if(empty($size)){
							$errors["content"] = "please insert either a video or an image";
						}
					}
					if(empty($errors["content"])){
						if($size[0] < 200 || $size[1] < 200){
							$errors["content"] = "the image should be at least 200x200";
						}
					}		
				}

				$contentlink = preg_replace("/\\.[^.\\s]{3,4}$/", "", $_FILES["content"]["name"]);
				$extension = explode($contentlink.".", $_FILES["content"]["name"])[1];
				if(!empty($_FILES["content"]["error"])){
					$errors["content"] = "the content could not be uploaded";
				}
		}
			
		$project_id = $_GET["id"];
		$title = $_POST["title"];
		if(empty($title)){
			$title = " ";
		}
		$description = $_POST["description"];
		if(empty($description)){
			$description = " ";
		}
		$color = $_POST["color"];

		if(empty($contentlink)){
			$contentlink = " ";
		}
				
		if(empty($extension)){
			$extension = " ";
		}

		$this->projectDAO->insertItem(array(
			"user_id"=>$_SESSION["user"]["id"],
			"contentlink"=>$contentlink,
			"extension"=>$extension,
			"posX"=>100,
			"posY"=>100,
			"title"=>$title,
			"description"=>$description,
			"project_id"=>$_GET["id"],
			"datum"=>date("Y-m-d h:i:s"),
			"color"=>$color
		));

		if($_FILES['content']['error'] == 0){
			if($isAnImage){
				$imageresize = new EventViva\ImageResize($_FILES["content"]["tmp_name"]);
				$imageresize->resizeToHeight(600);
				$imageresize->save(WWW_ROOT."uploads".DS.$contentlink.".".$extension);
				$imageresize->resizeToHeight(120);
				$imageresize->crop(180,120);
				$imageresize->save(WWW_ROOT."uploads".DS.$contentlink."_th.".$extension);	
			}else{
				//VIDEO UPLOAD SHIZZLES
				$target = "uploads/";
				$target = $target . basename( $_FILES['content']['name']) ;
				move_uploaded_file($_FILES['content']['tmp_name'], $target);
			}

		}
		$this->redirect("index.php?page=detail&id=".$_GET["id"]);
		$_SESSION["info"] = "The sticky note was uploaded";
		
		if(!empty($errors)){
			$_SESSION["error"] = "the sticky note could not be uploaded";
		}

		$this->set('errors', $errors);
	}

	public function delete(){
		$errors = array();

		if(empty($errors)){
			$this->projectDAO->delete($_GET["id"]);
			$_SESSION["info"] = "Project deleted successfully";
			$this->redirect("index.php");
		}

		if(!empty($errors)){
			$_SESSION["error"] = "the project could not be deleted";
		}
		$this->set('errors', $errors);
	}

	public function deleteItem(){
		$errors = array();

		if(empty($errors)){
			$this->projectDAO->deleteItem($_POST["id"]);
			$_SESSION["info"] = "Item deleted successfully";
			$this->redirect("index.php");
		}

		if(!empty($errors)){
			$_SESSION["error"] = "the Item could not be deleted";
		}
		$this->set('errors', $errors);
	}

	public function moveItem(){
		$errors = array();

		if(!empty($_POST)){

			$id = $_POST["id"];
			$x = $_POST["x"];
			$y = $_POST["y"];

			if(empty($errors)){
					$this->projectDAO->moveUpdate(array(
						"id"=>$id,
						"posX"=>$x,
						"posY"=>$y
					));
			}
		}	

		if(!empty($errors)){
			$_SESSION["error"] = "the sticky note could not be moved";
		}
		$this->set('errors', $errors);
	}
}