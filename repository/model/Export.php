<?php
include_once __DIR__ . '/../SharedRepository.php';

class Export
{
    private SharedRepository $repository;

    public function __construct()
    {
        $this->repository = new SharedRepository();
    }

    /**
     * Hotove data
     *
     * @param int $id
     * @return array
     */
    public function getStudentTest(int $id): ?array {
        $studentTest = $this->repository->findById("student_test", $id);

        if ($studentTest === null) {
            return null;
        }

        //todo export nie je moynz ak nie jd okonceny test

        $studentId = (int) $studentTest["student_id"];

        $student = $this->repository->findById("student", $studentId);

        $testId = (int) $studentTest["test_id"];

        $test = $this->getTestData($testId, $studentId);

        return [
            'studentTest' => $studentTest,
            'student' => $student,
            'test' => $test,
        ];
    }

    private function getTestData(int $testId, int $studentId): ?array {
        $test = $this->repository->findById("test", $testId);

        if ($test === null){
            return null;
        }
        $questions = $this->repository->selectAll("question", [
            'test_id' => $testId,
        ]);

        return [
            'test' => $test,
            'questions' => $questions,
        ];
    }
}



