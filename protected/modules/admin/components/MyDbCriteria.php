<?php

class MyDbCriteria extends CDbCriteria
{
    public function addSearchConditions($columns, $escape=true, $operator='AND', $like='LIKE')
    {
        foreach ($columns as $column => $keyword)
            if (!Helper::isEmpty($keyword))
                $this->addSearchCondition($column, $keyword, $escape, $operator, $like);

        return $this;
    }

    public function addColumnCondition($columns, $columnOperator='AND', $operator='AND')
    {
        foreach ($columns as $column => $value)
            if (Helper::isEmpty($value))
                unset($columns[$column]);
        if (!empty($columns))
            parent::addColumnCondition($columns, $columnOperator, $operator);

        return $this;
    }

    public function addCompareConditions($columns, $partialMatch=false, $operator='AND')
    {
        foreach ($columns as $column => $values) {
            list($minValue, $maxValue) = $values;
            if (!Helper::isEmpty($minValue))
                $this->compare($column, ">= $minValue");
            if (!Helper::isEmpty($maxValue))
                $this->compare($column, "<= $maxValue");
        }

        return $this;
    }
}
