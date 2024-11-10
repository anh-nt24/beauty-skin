<?php

require_once __DIR__ . "/../models/FaQ.php";

class FaQController {
    private $faq;

    public function __construct($db) {
        $this->faq = new FaQ($db);
    }

    public function getAllFaQs() {
        return $this->faq->findAll();
    }

    public function editFaQ() {
        $id = $_GET['id'] ?? null;
        if ($id === null || !isset($_POST)) {
            echo '<script>
                alert("Error editting data. Please try again.");
                window.location.href = window.location.href;
            </script>';
            exit;
        }
        $question = $_POST['question'];
        $answer = $_POST['answer'];

        $success = $this->faq->update($id, $question, $answer);

        if ($success) {
            header('Location:' . ROOT_URL . '/admin/customer-service/index');
            exit;
        } else {
            echo '<script>
                alert("Error editting data. Please try again.");
                window.location.href = window.location.href;
            </script>';
        }
    }

    public function deleteFaQ() {
        $id = $_GET['id'] ?? null;
        if ($id === null) {
            echo '<script>
                alert("Error deleting data. Please try again.");
                window.location.href = window.location.href;
            </script>';
            exit;
        }

        $success = $this->faq->delete($id);
        
        echo json_encode(['success' => $success]);
    }

    public function addNewFaQ() {
        if (isset($_POST)) {
            $question = $_POST['question'];
            $answer = $_POST['answer'];

            $success = $this->faq->save($question, $answer);
            if ($success) {
                header('Location:' . ROOT_URL . '/admin/customer-service/index');
                exit;
            } else {
                echo '<script>
                    alert("Error adding data. Please try again.");
                    window.location.href = window.location.href;
                </script>';
            }
        }
    }
}
?>