<?php

class FaQ {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function save($question, $answer) {
        $stmt = $this->db->prepare("INSERT INTO faq (question, answer) VALUES (?, ?)");
        return $stmt->execute([$question, $answer]);
    }

    public function findAll() {
        $stmt = $this->db->prepare("SELECT * FROM faq ORDER BY id DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);  
    }

    public function update($id, $question, $answer) {
        $stmt = $this->db->prepare("UPDATE faq SET question = ?, answer = ? WHERE id = ?");
        return $stmt->execute([$question, $answer, $id]);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM faq WHERE id = ?");
        return $stmt->execute([$id]);
    }
}