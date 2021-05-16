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

        $test = $this->getTestData($testId, $id);

        return [
            'studentTest' => $studentTest,
            'student' => $student,
            'test' => $test,
        ];
    }

    private function getTestData(int $testId, int $studentTestId): ?array {
        $test = $this->repository->findById("test", $testId);

        if ($test === null){
            return null;
        }

        return [
            'test' => $test,
            'questions' => $this->getTestQuestions($testId, $studentTestId),
        ];
    }

    private function getTestQuestions(int $testId, int $studentTestId): array
    {
        // dotiahnnut test, otazky aj odpovede
        // [
        // 'question' => [],
        // 'answers' => [],
        // 'student_test_answer' => [],
        $questions = $this->repository->selectAll("question", [
            'test_id' => $testId,
        ]);

        $questions_ids = array_map(fn ($q) => $q['id'], $questions);

        // Vsetky odpovede na dane otazky
        $answers = $this->repository->selectAll('answer', [
            'question_id' => $questions_ids,
        ]);

        $student_test_answers = $this->repository->selectAll('student_test_answer', [
            'student_test_id' => $studentTestId,
            'question_id' => $questions_ids,
        ]);

        return $this->groupAnswersWithQuestions(
            $questions,
            $answers,
            $student_test_answers,
        );
    }

    private function groupAnswersWithQuestions(array $questions, array $answers, array $student_test_answers): array {
        $grouped_questions = [];

        foreach ($questions as $question) {
            $grouped_questions[$question['id']] = [
                'question' => $question,
                'answers' => [],
                'student_test_answers' => [],
            ];
        }

        foreach ($answers as $answer) {
            $grouped_questions[$answer['question_id']]['answers'][] = $answer;
        }

        foreach ($student_test_answers as $student_test_answer) {
            $grouped_questions[$student_test_answer['question_id']]['student_test_answers'][] = $student_test_answer;
        }

        return array_values($grouped_questions);
    }
}



