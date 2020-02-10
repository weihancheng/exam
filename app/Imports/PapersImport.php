<?php

namespace App\Imports;

use App\Models\Item;
use App\Models\Paper;
use App\Models\Post;
use App\Models\Question;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PapersImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row) {}

    // 处理数据
    public function getPaper(array $rows)
    {
        // 返回试卷内容
        $paper = [
            'content' => [],   // 试卷题目列表
            'type' => Paper::PAPER_ONLY_QUESTION  //试卷类型
        ];
        foreach ($rows as $row) {
            // question_status  把中文转英文
            if ($row['题目类型'] == "单选题") {
                $row['题目类型'] = Question::SINGLE_CHOICE_QUESTION;
            }
            if ($row['题目类型'] == "多选题") {
                $row['题目类型'] = Question::MULTIPLE_CHOICE_QUESTIONS;
            }
            if ($row['题目类型'] == "问答题") {
                $row['题目类型'] = Question::SINGLE_TEXT;
                $paper['type'] = Paper::PAPER_QUESTION_AND_TEXT;
            }
            if ($row['题目类型'] == "填空题") {
                $row['题目类型'] = Question::MULTIPLE_TEXT;
                $paper['type'] = Paper::PAPER_QUESTION_AND_TEXT;
            }
            // answer 把1,2,3 转为 [1,2,3] 且添加
            $row['题目答案'] = str_replace('，', ',', $row['题目答案']);
            $row['题目答案'] = explode(',', $row['题目答案']);
            $row['题目答案'] = array_map(function ($value) {
                return intval($value);
            }, $row['题目答案']);
            if (!is_array($row['题目答案'])) $row['题目答案'] = array($row['题目答案']);
            // post_id
            if (isset($row['分类'])) {
                if (!is_int($row['分类'])) $row['分类'] = Post::query()->where('name', $row['分类'])->first();
            }
            $question = new Question([
                'question_status' => $row['题目类型'],
                'title' => $row['题目内容'],
                'memo' => $row['题目解释']
            ]);
            $question->save();
            $answer = [];
            if (isset($row['选项一']) && !is_null($row['选项一'])) {
                $item1 = $question->items()->create([
                    'content' => $row['选项一'],
                    'sort' => 100,
                    'is_answer' => in_array(1, $row['题目答案']) ? Item::IS_ANSWER : Item::NOT_ANSWER
                ]);
                $item1->question()->associate($question);
                if (in_array(1, $row['题目答案'])) $answer[] = $item1->id;
            }
            if (isset($row['选项二']) && !is_null($row['选项二'])) {
                $item2 = $question->items()->create([
                    'content' => $row['选项二'],
                    'sort' => 100,
                    'is_answer' => in_array(2, $row['题目答案']) ? Item::IS_ANSWER : Item::NOT_ANSWER
                ]);
                $item2->question()->associate($question);
                if (in_array(2, $row['题目答案'])) $answer[] = $item2->id;
            }
            if (isset($row['选项三']) && !is_null($row['选项三'])) {
                $item3 = $question->items()->create([
                    'content' => $row['选项三'],
                    'sort' => 100,
                    'is_answer' => in_array(3, $row['题目答案']) ? Item::IS_ANSWER : Item::NOT_ANSWER
                ]);
                $item3->question()->associate($question);
                if (in_array(3, $row['题目答案'])) $answer[] = $item3->id;
            }
            if (isset($row['选项四']) && !is_null($row['选项四'])) {
                $item4 = $question->items()->create([
                    'content' => $row['选项四'],
                    'sort' => 100,
                    'is_answer' => in_array(4, $row['题目答案']) ? Item::IS_ANSWER : Item::NOT_ANSWER
                ]);
                $item4->question()->associate($question);
                if (in_array(4, $row['题目答案'])) $answer[] = $item4->id;
            }
            if (isset($row['选项五']) && !is_null($row['选项五'])) {
                $item5 = $question->items()->create([
                    'content' => $row['选项五'],
                    'sort' => 100,
                    'is_answer' => in_array(5, $row['题目答案']) ? Item::IS_ANSWER : Item::NOT_ANSWER
                ]);
                $item5->question()->associate($question);
                if (in_array(5, $row['题目答案'])) $answer[] = $item5->id;
            }
            if (isset($row['选项六']) && !is_null($row['选项六'])) {
                $item6 = $question->items()->create([
                    'content' => $row['选项六'],
                    'sort' => 100,
                    'is_answer' => in_array(6, $row['题目答案']) ? Item::IS_ANSWER : Item::NOT_ANSWER
                ]);
                $item6->question()->associate($question);
                if (in_array(6, $row['题目答案'])) $answer[] = $item6->id;
            }
            if (isset($row['选项七']) && !is_null($row['选项七'])) {
                $item7 = $question->items()->create([
                    'content' => $row['选项七'],
                    'sort' => 100,
                    'is_answer' => in_array(7, $row['题目答案']) ? Item::IS_ANSWER : Item::NOT_ANSWER
                ]);
                $item7->question()->associate($question);
                if (in_array(7, $row['题目答案'])) $answer[] = $item7->id;
            }

            $paper['content'][] = $question->id;
            $question->update([
                'answer' => $answer
            ]);
        }
        return $paper;
    }
}
