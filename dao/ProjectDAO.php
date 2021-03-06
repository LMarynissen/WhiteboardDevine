<?php
require_once __DIR__ . '/DAO.php';
class ProjectDAO extends DAO {

	public function selectById($id) {
		$sql = "SELECT * FROM `projects` WHERE `id` = :id";
		$stmt = $this->pdo->prepare($sql);
		$stmt->bindValue(':id', $id);
		$stmt->execute();
		return $stmt->fetch(PDO::FETCH_ASSOC);
	}

	public function selectItemsByProjectId($id) {
		$sql = "SELECT * FROM `items` WHERE `project_id` = :id";
		$stmt = $this->pdo->prepare($sql);
		$stmt->bindValue(':id', $id);
		$stmt->execute();
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	public function selectInvitedByProjectId($project_id) {
		$sql = "SELECT * FROM `invites` WHERE `project_id` = :project_id";
		$stmt = $this->pdo->prepare($sql);
		$stmt->bindValue(':project_id', $project_id);
		$stmt->execute();
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	public function selectInvitedByProjectAndUserId($project_id, $user_id) {
		$sql = "SELECT * FROM `invites` WHERE `project_id` = :project_id AND `user_id` = :user_id";
		$stmt = $this->pdo->prepare($sql);
		$stmt->bindValue(':project_id', $project_id);
		$stmt->bindValue(':user_id', $user_id);
		$stmt->execute();
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	public function selectInvitedProjectsByUser($user_id) {
		$sql = "SELECT *
				FROM `projects`
				INNER JOIN `invites`
				ON `invites`.project_id = `projects`.id
				WHERE `invites`.user_id = :user_id";
		$stmt = $this->pdo->prepare($sql);
		$stmt->bindValue(':user_id', $user_id);
		$stmt->execute();
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	public function selectInvitedPeopleByProject($project_id) {
		$sql = "SELECT *
				FROM `users`
				INNER JOIN `invites`
				ON `invites`.user_id = `users`.id
				WHERE `invites`.project_id = :project_id";
		$stmt = $this->pdo->prepare($sql);
		$stmt->bindValue(':project_id', $project_id);
		$stmt->execute();
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	public function selectCreatorByProjectId($project_id) {
		$sql = "SELECT email
				FROM `users`
				INNER JOIN `projects`
				ON `projects`.user_id = `users`.id
				WHERE `projects`.id = :project_id";
		$stmt = $this->pdo->prepare($sql);
		$stmt->bindValue(':project_id', $project_id);
		$stmt->execute();
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	

	public function selectByUser($user_id) {
		$sql = "SELECT * FROM `projects` WHERE `user_id` = :user_id";
		$stmt = $this->pdo->prepare($sql);
		$stmt->bindValue(':user_id', $user_id);
		$stmt->execute();
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	public function selectUserByItemId($item_id) {
		$sql = "SELECT email
				FROM `users`
				INNER JOIN `items`
				ON `items`.user_id = `users`.id
				WHERE `items`.id = :item_id";
		$stmt = $this->pdo->prepare($sql);
		$stmt->bindValue(':item_id', $item_id);
		$stmt->execute();
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	public function insert($data) {
		$errors = $this->getValidationErrors($data);
		if(empty($errors)) {
			$sql = "INSERT INTO `projects` (`user_id`, `title`, `description`) VALUES (:user_id, :title, :description)";
	        $stmt = $this->pdo->prepare($sql);
	        $stmt->bindValue(':user_id', $data['user_id']);
	        $stmt->bindValue(':title', $data['title']);
	        $stmt->bindValue(':description', $data['description']);
			if($stmt->execute()) {
				$insertedId = $this->pdo->lastInsertId();
				return $this->selectById($insertedId);
			}
		}
		return false;
	}

	public function insertItem($data) {
		$errors = $this->getValidationErrors($data);
		if(empty($errors)) {
			$sql = "INSERT INTO `items` (`user_id`, `title`, `description`, `project_id`, `contentlink`, `extension`, `posX`, `posY`, `datum`, `color`) 
								 VALUES (:user_id, :title, :description, :project_id, :contentlink, :extension, :posX, :posY, :datum, :color)";
	        $stmt = $this->pdo->prepare($sql);
	        $stmt->bindValue(':user_id', $data['user_id']);
	        $stmt->bindValue(':title', $data['title']);
	        $stmt->bindValue(':description', $data['description']);
	        $stmt->bindValue(':project_id', $data['project_id']);
	        $stmt->bindValue(':contentlink', $data['contentlink']);
	        $stmt->bindValue(':extension', $data['extension']);
	        $stmt->bindValue(':posX', $data['posX']);
	        $stmt->bindValue(':posY', $data['posY']);
	        $stmt->bindValue(':datum', $data['datum']);
	        $stmt->bindValue(':color', $data['color']);
			if($stmt->execute()) {
			}
		}
		return false;
	}

	public function insertVideo($data) {
		$errors = $this->getValidationErrors($data);
		if(empty($errors)) {
			$sql = "INSERT INTO `items` (`user_id`, `title`, `description`, `project_id`, `contentlink`, `extension`, `posX`, `posY`, `datum`, `color`) 
								 VALUES (:user_id, :title, :description, :project_id, :contentlink, :extension, :posX, :posY, :datum, :color)";
	        $stmt = $this->pdo->prepare($sql);
	        $stmt->bindValue(':user_id', $data['user_id']);
	        $stmt->bindValue(':title', $data['title']);
	        $stmt->bindValue(':description', $data['description']);
	        $stmt->bindValue(':project_id', $data['project_id']);
	        $stmt->bindValue(':contentlink', $data['contentlink']);
	        $stmt->bindValue(':extension', $data['extension']);
	        $stmt->bindValue(':posX', $data['posX']);
	        $stmt->bindValue(':posY', $data['posY']);
	        $stmt->bindValue(':datum', $data['datum']);
	        $stmt->bindValue(':color', $data['color']);
			if($stmt->execute()) {
			}
		}
		return false;
	}

	public function delete($id) {

		$sql = " DELETE FROM projects
				 WHERE id = :id";
	    $stmt = $this->pdo->prepare($sql);
	    $stmt->bindValue(':id', $id);
		if($stmt->execute()) {
		}
	
		$sql2 = " DELETE FROM items
		WHERE project_id = :project_id";
	    $stmt2 = $this->pdo->prepare($sql2);
	    $stmt2->bindValue(':project_id', $id);
		if($stmt2->execute()) {
		}
		
		return false;
	}

	public function deleteItem($id) {

		$sql = " DELETE FROM items
			 	 WHERE id = :id";
	    $stmt = $this->pdo->prepare($sql);
	    $stmt->bindValue(':id', $id);
		if($stmt->execute()) {
		}
		
		return false;
	}

	public function moveUpdate($data) {
		$id = $data['id'];
		$posX = $data['posX'];
		$posY = $data['posY'];
		$sql = " UPDATE items SET posX ='$posX', posY ='$posY'  WHERE id = $id";
		$stmt = $this->pdo->prepare($sql);
	    $stmt->bindValue(':id', $id);
		if($stmt->execute()) {
		}
		
		return false;
	}

	public function getValidationErrors($data) {
		$errors = array();
		if(empty($data['user_id'])) {
			$errors['user_id'] = "Please fill in the user_id";
		}
		if(empty($data['title'])) {
	        $errors['title'] = 'please enter a title';
	    }
	    if(empty($data['description'])) {
	        $errors['description'] = 'please enter an description';
	    }
		return $errors;
	}
}