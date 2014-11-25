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

	public function selectByUser($user_id) {
		$sql = "SELECT * FROM `projects` WHERE `user_id` = :user_id";
		$stmt = $this->pdo->prepare($sql);
		$stmt->bindValue(':user_id', $user_id);
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