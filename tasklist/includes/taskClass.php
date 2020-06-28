<?php
require_once('db.php');

/*
 * Task CRUD operations
 */
class taskClass {

    public $database = null;

    public function __construct()
    {
        $db = new DB();
        $this->database = $db->dbConnect();
    }

    /**
     * Get all or a single row from tasks table
     */
    public function getRows($id = null){
        try{
            $sql = 'SELECT * FROM `tasks`';

            if ($id){
                $sql .= ' WHERE `id` = :id ';
            }

            $stmt = $this->database->prepare($sql);

            if ($id){
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            }

            $stmt->execute();
            $records = $stmt->fetchAll();

            //Format completion and target dates
            foreach($records as $obj){
                if ($obj->completion_date){
                    $obj->completion_date = date('M j, Y', strtotime($obj->completion_date));
                }
                if ($obj->target_date){
                    $obj->target_date = date('M j, Y', strtotime($obj->target_date));
                }
            }
            return $records;

        } catch(PDOException $e) {
            return [];
        }

    }


    /*
    * Adds new task
    */
    public function addTask($newContent=[])
    {
        try{
            $targetDate = null;

            if ($newContent['target_completion_date']){
                $targetDate = date('Y-m-d', strtotime($newContent['target_completion_date']));
            }

            $stmt = $this->database->prepare("
                INSERT INTO `tasks`
                  (`task_name`,`task_description`,`target_date`)
                VALUES (:name, :description, :targetData);
            ");
            $stmt->bindParam(':name', $newContent['name'], PDO::PARAM_STR);
            $stmt->bindParam(':description', $newContent['description'], PDO::PARAM_STR);
            $stmt->bindParam(':targetData', $targetDate, PDO::PARAM_STR);
            $stmt->execute();
            if( ! $stmt->rowCount() ){
                return false;
            }

            return true;

        } catch(PDOException $e) {
            return false;
        }
    }


    /*
    * Update task by its id
    */
    public function updateTask($data)
    {
        try{
            $id = $data['id'];
            $taskName = $data['name'];
            $taskDescription = $data['description'];

            $targetDate = null;
            if ($data['target_completion_date']){
                $targetDate = date('Y-m-d', strtotime($data['target_completion_date']));
            }

            $stmt = $this->database->prepare("
                UPDATE `tasks`
                SET 
                  `task_name` = :name, 
                  `task_description` = :description,
                  `target_date` = :targetDate
                WHERE id = :id
                LIMIT 1
            ");

            $stmt->bindParam(':name', $taskName, PDO::PARAM_STR);
            $stmt->bindParam(':description', $taskDescription, PDO::PARAM_STR);
            $stmt->bindParam(':targetDate', $targetDate, PDO::PARAM_STR);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            if( ! $stmt->rowCount() ){
                return false;
            }

            return true;

        } catch(PDOException $e) {
            return false;
        }
    }


    /*
    * Set the completion date for this task if it's
    * currently empty otherwise remove completion date
    */
    public function updateCompletionDate($id = null)
    {

        try{
            if (!id){
                return false;
            }

            $stmt = $this->database->prepare("
                    SELECT `completion_date` 
                    FROM `tasks` 
                    WHERE `id` = :id");

            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            $record = $stmt->fetch();
            if (!$record){
                return false;
            }

            $taskCompletionDate = null;

            if (!$record->completion_date){
                //Task has been complete. Set completion date
                $taskCompletionDate = date('Y-m-d');
            }

            $stmt = $this->database->prepare("
                UPDATE `tasks`
                SET 
                  `completion_date` = :completionDate
                WHERE id = :id
                LIMIT 1
            ");

            $stmt->bindParam(':completionDate', $taskCompletionDate, PDO::PARAM_STR);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            if( ! $stmt->rowCount() ){
                return false;
            }

            return true;

        } catch(PDOException $e) {
            return false;
        }
    }



    /*
     * Delete task by its id
     */
    public function deleteTask($id = null)
    {
        try{
            if (!id){
                return false;
            }

            $stmt = $this->database->prepare("
                DELETE FROM `tasks` 
                WHERE id = :id 
                LIMIT 1
            ");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            if( ! $stmt->rowCount() ){
                return false;
            }

            return true;

        } catch(PDOException $e) {
            return false;
        }
    }
}