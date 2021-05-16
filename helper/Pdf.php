<?php

class Pdf
{
    public function generateQuestionsHtml(array $questions): string {
        $items = [];
        foreach ($questions as $question) {
            try {
                $items[] = $this->generateHtmlForQuestionType($question);

            } catch (Exception) {
                $items[] = '<p>rendrovanie otazky zlyhalo</p>';
            }
        }

        $list_items = array_map(
            fn($item) =>
                "<li>$item</li>",
            $items
        );

        $list_items_html = implode("", $list_items);

        return "<ol>{$list_items_html}</ol>";
    }

    /**
     * @param array $questionData
     * @return string
     * @throws Exception
     *
     */
    function generateHtmlForQuestionType(array $questionData): string{
        return match ($questionData['question']["type"]) {
            "text" => $this->getTextQuestion($questionData),
            "choice" => $this->getChoiceQuestion($questionData),
            "pair" => $this->getPairQuestion($questionData),
            "drawing" => $this->getDrawingQuestion($questionData),
            "math" => $this->getMathQuestion($questionData),
            default => throw new Exception('Unexpected value'),
        };
    }

    private function getTextQuestion(array $questionData): string{
        return "<p>{$questionData['question']["value"]} [{$questionData["answers"][0]["points"]} / {$questionData['question']["max_points"]}]</p>
                <p>Students answer: {$questionData["student_test_answers"][0]["student_answer"]}</p>
                <p>Correct answer: {$questionData["answers"][0]["value"]}</p>
";
    }

    private function getChoiceQuestion(array $questionData): string{
        return "<p>{$questionData['question']["value"]} [ {$questionData["answers"][0]["points"]} / {$questionData['question']["max_points"]}]</p>
                <p>Students answer: {$questionData["student_test_answers"][0]["student_answer"]}</p>
                <p>Correct answer: {$questionData["answers"][0]["value"]}</p>
";
    }

    private function getPairQuestion(array $questionData): string{
        return "<p>Pair {$questionData["question"]["value"]} [ TODO / {$questionData['question']["max_points"]}]</p>
                <p>Students answer: TODO</p>
                <p>Correct answer: TODO</p>
            ";
    }

    private function getDrawingQuestion(array $questionData): string{
        return "";
    }

    private function getMathQuestion(array $questionData): string{
        return "";
    }
}