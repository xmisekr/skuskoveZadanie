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
        return "<p>Short answer: {$questionData['question']["value"]} [ {$questionData["student_test_answers"][0]["points"]}
                                                                        / {$questionData['question']["max_points"]}]</p>
                <p>Students answer: {$questionData["student_test_answers"][0]["student_answer"]}</p>
                <p>Correct answer: {$questionData["answers"][0]["value"]}</p>
";
    }

    private function getChoiceQuestion(array $questionData): string{
        return "<p>Choice: {$questionData['question']["value"]} [ {$questionData["student_test_answers"][0]["points"]} / {$questionData['question']["max_points"]}]</p>
                <p>Options:</p>
                
                    <input type='radio' id='option1' checked='checked'> 
                    <label for='option1'>{$questionData["answers"][0]["value"]}</label>
                    <input type='radio' id='option2'>
                    <label for='option2'>{$questionData["answers"][1]["value"]}</label>
                     <input type='radio' id='option3'>
                    <label for='option3'>{$questionData["answers"][2]["value"]}</label>
                     <input type='radio' id='option4'>
                    <label for='option4'>{$questionData["answers"][3]["value"]}</label>
                <p>Students answer: {$questionData["student_test_answers"][0]["student_answer"]}</p>
                <p>Correct answer: {$questionData["answers"][0]["value"]}</p>
";
    }

    private function getPairQuestion(array $questionData): string{
        return "<p>Pair: {$questionData["question"]["value"]} [ {$questionData["student_test_answers"][0]["points"]} / {$questionData['question']["max_points"]}]</p>
                <p>Students answer: {$questionData["student_test_answers"][0]["student_answer"]}</p>
                <p>Correct answer: {$questionData["answers"][0]["value"]}</p>
            ";
    }

    private function getDrawingQuestion(array $questionData): string{
        return "<p>Drawing:</p>";
    }

    private function getMathQuestion(array $questionData): string{
        return "<p>Math: </p>";
    }
}